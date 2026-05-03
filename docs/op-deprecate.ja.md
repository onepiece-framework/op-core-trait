# `OP_DEPRECATE` トレイト

## 概要

`OP_DEPRECATE` は、互換挙動のために作られた trait です。

framework が新しい API に移行していく過程で、旧来の呼び出し方を維持する wrapper 的 method をまとめています。

## 役割

この trait の役割は、新しい推奨 API を定義することではありません。

役割は、ローリングアップデートや長い移行期間の中で、既存コードとの互換性を維持することです。

## 例: `Env()`

もっとも分かりやすい例の一つが次です。

```php
OP()->Env()
```

2030版では、次のような直接 method:

```php
OP()->isLocalhost()
```

が `OP_ENV` によって提供されています。

それでも、`OP()->Env()->isLocalhost()` は `OP_DEPRECATE` によって維持されています。

## [DOC-FUTURE] 将来方針

`OP_DEPRECATE` に集約されている互換 helper は、設計上移行用です。

framework の主構造を単純化しながら、互換性も維持できるようにするために存在しています。

将来の line では、framework がこれらの互換 helper を標準では使わなくなる可能性があります。

## 柔軟性

将来的に framework が標準利用をやめたとしても、利用者が自分でその trait を明示的に use すれば、挙動を維持することは可能です。

そのため、`OP_DEPRECATE` は単なる deprecated 層ではなく、制御可能な互換層でもあります。
