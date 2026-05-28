# `OP_SESSION`

この文書は、`OP_SESSION` trait が実装している current As-Is behavior を説明します。

implementation owner は次です。

- `asset/core/trait/OP_SESSION.php`

## 責務

`OP_SESSION` は、この trait を use した class または trait に、低レベルの session namespace resolver と reference accessor を提供します。

`\OP\Session` wrapper class と分かれている理由は、同じ trait を CORE、UNIT、MODULE、helper class でも use できるようにするためです。

package が `OP_SESSION` を use した場合、session namespace はその呼び出し元 class から組み立てられます。これにより各 package は、`OP()->Session()` が返す `\OP\Session` wrapper scope を共有するのではなく、framework-managed session values を自分自身の class scope 配下に保持できます。

public な `OP()->Session()` access method はこの文書では定義しません。その access method は `asset/core/class/docs/op-class-session.md` に記録します。

また、`\OP\Session` wrapper method もこの文書では定義しません。wrapper class の挙動は `asset/core/class/docs/session.md` に記録します。

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

## namespace の組み立て

`OP_SESSION::Session()` は、呼び出し元 class から session 保存先を組み立てます。

current implementation は次を使います。

- `get_called_class()`
- `_OP_NAME_SPACE_`
- 定義されている場合の `_APP_ID_`
- `_APP_ID_` が未定義の場合の fallback application key として `md5(__FILE__)`

呼び出し元 class は namespace separator で分割されます。

`OP\Session` のような 2 要素の class name では、2 つ目の要素が core class name として扱われ、group は `CORE` に設定されます。

先頭の namespace part は `_OP_NAME_SPACE_` に置き換えられます。

結果の保存構造は次です。

```php
$_SESSION[_OP_NAME_SPACE_][group][class-name][app-id]
```

例:

- `OP\UNIT\Html` は `UNIT` / `Html` 配下に解決されます。
- `OP\MODULE\Counter` は `MODULE` / `Counter` 配下に解決されます。
- `OP\MODULE\COUNTER\Countup` は `MODULE` / `COUNTER` 配下に解決されます。
- `OP\Session` は `CORE` / `Session` 配下に解決されます。

## 参照の挙動

`Session()` は、選択された session array を参照で返します。

引数なしで呼ぶと、scope 済みの session array 全体を返します。

```php
$session = & self::Session();
$session['key'] = 'value';
```

戻り値が参照であるため、呼び出し元は scope 済み session array を直接読み書きできます。

この pattern は UNIT / MODULE code に有用です。package が自分の session namespace を所有し、facade wrapper call を別に挟まなくて済むためです。

## 直接 method の挙動

trait method は optional argument を受け取ります。

```php
Session($key = null, $val = null)
```

current の直接挙動は次です。

- `Session()`
  現在 scope の session array を参照で返す。
- `Session($key)`
  `$session[$key]` を返す。
- `Session($key, $val)`
  `$val` が `null` でなければ `$session[$key]` に保存する。
- `Session($key, null)`
  `$session[$key]` を unset する。

unset の挙動は、この trait method 直接呼び出し経路に属します。

## `OP()->Session()` との関係

`OP()->Session()` は instantiated `\OP\Session` wrapper を返します。

この wrapper も `OP_SESSION` を使いますが、called class が `\OP\Session` であるため、storage は `CORE` / `Session` に scoped されます。

shared な framework facade access が適切な場合は `OP()->Session()` を使います。

UNIT、MODULE、package helper が自分の package-scoped session namespace に state を保持すべき場合は、`OP_SESSION` と `self::Session()` を使います。

framework-managed session namespacing を bypass する明確な理由がない限り、package code から raw `$_SESSION` を直接使ってはいけません。

## 範囲

この文書は trait が所有する As-Is behavior のみを記録します。

`\OP\Session` の wrapper behavior と、`OP()->Session()` の facade behavior は別文書に記録します。
