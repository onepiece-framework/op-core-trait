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

- `_Map(__FUNCTION__)` を呼ぶ
- `Mapping()` で mapping 後の unit 名を解決する
- `Instantiated()` を通して unit instance を返す

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
