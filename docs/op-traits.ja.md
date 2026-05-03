# `\OP\OP` が使う trait 群

## 概要

`\OP\OP` class は、複数の trait を組み合わせて構築されています。

これらの trait が、framework object の実用的な機能面の大部分を与えています。

## 現在の trait

現在の class 構成には次が含まれます。

- `OP_CORE`
- `OP_CI`
- `OP_ENV`
- `OP_TEMPLATE`
- `OP_ONEPIECE`
- `OP_DEPRECATE`

## trait の役割

大まかには次のような役割です。

- `OP_CORE`
  core の共有挙動
- `OP_CI`
  CI 関連の挙動
- `OP_ENV`
  request や MIME 処理などの環境補助
- `OP_TEMPLATE`
  template 実行支援
- `OP_ONEPIECE`
  `Unit()`, `Config()`, `Session()`, `Cookie()`, `Encrypt()` などの高水準 framework access method
- `OP_DEPRECATE`
  後方互換や deprecated 挙動の扱い

## 実務上の重要性

実務上、開発者が `OP()` 経由で呼ぶ多くの method は、class body ではなくこれらの trait から提供されています。

そのため、`OP()` の仕組みを理解するうえで trait 層は本質的です。

## まとめ

`asset/core/trait/` 配下の trait 群は、`\OP\OP` framework object の振る舞いの源になっています。
