# `OP_SESSION`

This document describes the current As-Is behavior implemented by the `OP_SESSION` trait.

The implementation owner is:

- `asset/core/trait/OP_SESSION.php`

## Responsibility

`OP_SESSION` provides the low-level session namespace resolver and reference accessor for the class or trait that uses it.

It is separated from the `\OP\Session` wrapper class because the same trait can be used by CORE, UNIT, MODULE, and helper classes.

When a package uses `OP_SESSION`, the session namespace is built from the calling class. This lets each package keep framework-managed session values under its own class scope instead of sharing the `\OP\Session` wrapper scope returned by `OP()->Session()`.

This document does not define the public `OP()->Session()` access method. That access method is documented in `asset/core/class/docs/op-class-session.md`.

It also does not define the `\OP\Session` wrapper methods. The wrapper class behavior is documented in `asset/core/class/docs/session.md`.

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

## Namespace Construction

`OP_SESSION::Session()` builds the session storage location from the calling class.

The current implementation uses:

- `get_called_class()`
- `_OP_NAME_SPACE_`
- `_APP_ID_` when defined
- `md5(__FILE__)` as the fallback application key when `_APP_ID_` is not defined

The calling class is split by namespace separator.

For two-part class names such as `OP\Session`, the second part is treated as a core class name and the group is set to `CORE`.

The first namespace part is replaced with `_OP_NAME_SPACE_`.

The resulting storage shape is:

```php
$_SESSION[_OP_NAME_SPACE_][group][class-name][app-id]
```

Examples:

- `OP\UNIT\Html` resolves under `UNIT` / `Html`.
- `OP\MODULE\Counter` resolves under `MODULE` / `Counter`.
- `OP\MODULE\COUNTER\Countup` resolves under `MODULE` / `COUNTER`.
- `OP\Session` resolves under `CORE` / `Session`.

## Reference Behavior

`Session()` returns the selected session array by reference.

Calling it without arguments returns the whole scoped session array:

```php
$session = & self::Session();
$session['key'] = 'value';
```

Because the return value is a reference, callers can read or mutate the scoped session array directly.

This pattern is useful for UNIT and MODULE code because the package owns its session namespace and avoids a separate facade wrapper call.

## Direct Method Behavior

The trait method accepts optional arguments:

```php
Session($key = null, $val = null)
```

Current direct behavior is:

- `Session()`
  Returns the current scoped session array by reference.
- `Session($key)`
  Returns `$session[$key]`.
- `Session($key, $val)`
  Stores `$val` at `$session[$key]` when `$val` is not `null`.
- `Session($key, null)`
  Unsets `$session[$key]`.

The unset behavior belongs to this direct trait method path.

## Relationship To `OP()->Session()`

`OP()->Session()` returns an instantiated `\OP\Session` wrapper.

That wrapper also uses `OP_SESSION`, but because the called class is `\OP\Session`, its storage is scoped to `CORE` / `Session`.

Use `OP()->Session()` when shared framework facade access is appropriate.

Use `OP_SESSION` and `self::Session()` when a UNIT, MODULE, or package helper should keep state in its own package-scoped session namespace.

Do not use raw `$_SESSION` directly from package code unless there is an explicit reason to bypass framework-managed session namespacing.

## Scope

This document records the trait-owned As-Is behavior only.

Wrapper behavior for `\OP\Session` and facade behavior for `OP()->Session()` are documented separately.
