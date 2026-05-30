# `OP_SESSION`

この document は、`OP_SESSION` trait の current As-Is behavior を説明します。

implementation owner は次です。

- `asset/core/trait/OP_SESSION.php`

## role

`OP_SESSION` は、この trait を use した class または trait に package-scoped session storage を提供します。

UNIT、MODULE、CORE、helper class は、`OP()->Session()` が返す shared な `\OP\Session` wrapper ではなく、自分の framework namespace に scoped された session state が必要な場合に、この trait を使えます。

## basic use

session state を所有する class または trait で、この trait を use します。

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

key-specific access として、key と optional value を渡すこともできます。

```php
$value = self::Session('key');
self::Session('key', 'value');
self::Session('key', null);
```

第二引数に `null` を渡すと、その key は unset されます。

## storage namespace

`OP_SESSION::Session()` は `get_called_class()` から storage location を組み立てます。

current の形は次です。

```php
$_SESSION[_OP_NAME_SPACE_][group][name][_APP_ID_]
```

trait は called class namespace から `group` と `name` を導きます。

例:

- `OP\UNIT\Html` は `UNIT` / `Html` 配下に解決されます。
- `OP\MODULE\Counter` は `MODULE` / `Counter` 配下に解決されます。
- `OP\MODULE\COUNTER\Countup` は `MODULE` / `COUNTER` 配下に解決されます。
- `OP\Session` は `CORE` / `Session` 配下に解決されます。

`_APP_ID_` が定義されていない場合、trait は `md5(__FILE__)` に fallback します。

## reference return

`Session()` は reference を返します。

これにより package code は scoped session array を直接扱えます。

```php
$session = & self::Session();
$session['key'] = 'value';
```

この pattern は UNIT / MODULE code に有用です。package が自分の session namespace を所有し、facade wrapper call を別に挟まなくて済むためです。

## `OP()->Session()` との関係

`OP()->Session()` は instantiated `\OP\Session` wrapper を返します。
この wrapper も `OP_SESSION` を使いますが、called class が `\OP\Session` であるため、storage は `CORE` / `Session` に scoped されます。

shared な framework facade access が適切な場合は `OP()->Session()` を使います。

UNIT、MODULE、package helper が自分の package-scoped session namespace に state を保持すべき場合は、`OP_SESSION` と `self::Session()` を使います。

framework-managed session namespacing を bypass する明確な理由がない限り、package code から raw `$_SESSION` を直接使ってはいけません。
