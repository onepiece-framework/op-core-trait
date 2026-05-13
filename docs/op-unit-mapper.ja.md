# `OP_UNIT_MAPPER`

## 概要

`OP_UNIT_MAPPER` は、次のような typed unit accessor を提供する trait です。

- `App()`
- `CI()`
- `Layout()`
- `WebPack()`

これは generic な `OP()->Unit('Name')` 機構を置き換えるものではありません。

代わりに、mapper が明示的に対応している unit について、typed な method-chain access を追加するものです。

## 現行の挙動

各 typed accessor は次を行います。

- optional arguments を受け取る
- `_Map(__FUNCTION__, ...$args)` を呼ぶ
- `Mapping()` で mapping 後の unit 名を解決する
- `Instantiated()` を通して unit instance を取得する
- optional Auto step の後で unit instance を返す

## optional Auto step

`_Map()` は、typed accessor に arguments が渡され、mapping 後の unit instance が `Auto` method を持つ場合だけ `Auto(...$args)` を実行します。

つまり、通常の unit access は副作用を持ちません。

```php
OP()->Unit()->WebPack();
```

arguments が渡された場合、その accessor は明示的な Auto shortcut になります。

```php
OP()->Unit()->WebPack('app.js', 'app.css');
```

arguments は unit の `Auto()` method に転送されます。

```php
OP()->Unit()->WebPack()->Auto('app.js', 'app.css');
```

この behavior は、accessor に arguments がある場合だけに意図的に限定されています。単に unit instance を取得するだけで automatic behavior を起動してはいけません。既存 code は、通常の method call のために mapper accessor で unit instance を取得しているためです。

## mapping の参照元

`Mapping()` は次を cache します。

- `Config::Get('unit')`

その後、次を見ます。

- `$_config['mapping'][strtolower($name)]`

mapping が存在すれば、要求された unit 名は mapping 後の名前へ置き換えられます。

mapping が無ければ元の unit 名をそのまま使います。

## typed return contract

各 accessor は typed return interface を宣言しています。

例:

- `App() : IF_APP`
- `CI() : IF_CI`
- `Layout() : IF_LAYOUT`
- `WebPack() : IF_WEBPACK`

これにより、mapper ベースの差し替えと interface ベースの期待値が結び付いています。
