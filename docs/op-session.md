# `OP_SESSION`

This document describes the current As-Is behavior of the `OP_SESSION` trait.

The implementation owner is:

- `asset/core/trait/OP_SESSION.php`

## Role

`OP_SESSION` provides package-scoped session storage to the class or trait that uses it.

UNIT, MODULE, CORE, and helper classes can use this trait when they need session state scoped to their own framework namespace instead of the shared `\OP\Session` wrapper returned by `OP()->Session()`.

## Basic Use

Use the trait in the class or trait that owns the session state:

```php
namespace OP\MODULE\EXAMPLE;

class Example
{
	use \OP\OP_SESSION;

	function SaveFlag() : void
	{
		$session = & self::Session();
		$session['flag'] = true;
	} // SaveFlag
}
```

For key-specific access, the trait also accepts a key and optional value:

```php
$value = self::Session('key');
self::Session('key', 'value');
self::Session('key', null);
```

Passing `null` as the second argument unsets that key.

## Storage Namespace

`OP_SESSION::Session()` builds its storage location from `get_called_class()`.

The current shape is:

```php
$_SESSION[_OP_NAME_SPACE_][group][name][_APP_ID_]
```

The trait derives `group` and `name` from the called class namespace.

Examples:

- `OP\UNIT\Html` resolves under `UNIT` / `Html`.
- `OP\MODULE\Counter` resolves under `MODULE` / `Counter`.
- `OP\MODULE\COUNTER\Countup` resolves under `MODULE` / `COUNTER`.
- `OP\Session` resolves under `CORE` / `Session`.

If `_APP_ID_` is not defined, the trait falls back to `md5(__FILE__)`.

## Reference Return

`Session()` returns by reference.

This allows package code to work with the scoped session array directly:

```php
$session = & self::Session();
$session['key'] = 'value';
```

This pattern is useful for UNIT and MODULE code because the package owns its session namespace and avoids a separate facade wrapper call.

## Relationship To `OP()->Session()`

`OP()->Session()` returns an instantiated `\OP\Session` wrapper.
That wrapper also uses `OP_SESSION`, but because the called class is `\OP\Session`, its storage is scoped to `CORE` / `Session`.

Use `OP()->Session()` when shared framework facade access is appropriate.

Use `OP_SESSION` and `self::Session()` when a UNIT, MODULE, or package helper should keep state in its own package-scoped session namespace.

Do not use raw `$_SESSION` directly from package code unless there is an explicit reason to bypass framework-managed session namespacing.
