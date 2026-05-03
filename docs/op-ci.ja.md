# `OP_CI`

## 概要

`OP_CI` は、ONEPIECE Framework の CI pipeline に対して、class inspection の標準 surface を与える trait です。

現在の設計では、CI に参加する class はこの trait を use していることが期待されます。

そうでなければ、その repository の CI は失敗します。

## なぜ存在するのか

CI pipeline は class 指向です。

target repository を走査し、class file を見つけ、class を instantiate し、その後 trait ベースの標準 entry を通して method を inspection します。

`OP_CI` は、各 class が独自の CI dispatch logic を個別実装しなくても、CI が統一 inspection contract に依存できるようにするために存在します。

## 現在の method

現在の trait は次を提供します。

- `CI_AllMethods()`
- `CI_Inspection(string $method, ...$args)`

## `CI_AllMethods()`

`CI_AllMethods()` は次を返します。

- `get_class_methods($this)`

これにより、CI 層は current instance の inspect 対象 method list を統一的に取得できます。

現在の運用設計では、この method list が、CI engine 側の skip rule を除いた class inspection source として扱われます。

## `CI_Inspection()`

`CI_Inspection()` は、次によって要求された method を実行します。

- `$this->{$method}(...$args)`

これにより、CI 層は class 挙動を呼び出すための標準 entry point を 1 つ持てます。

## なぜ private method も inspection できるのか

この設計の重要な実務上の結果のひとつは、private method も inspection 対象にできることです。

`CI_Inspection()` は trait に定義されており、class context の内側で動くため、

- CI pipeline は各 method を class 外側から直接呼ぶ必要がない
- class 内部挙動でも trait ベースの inspection path を通して実行できる

このため、`OP_CI` は単なる marker trait 以上の意味を持ちます。

それは、より深い class-level inspection を可能にする技術的な橋渡しでもあります。

## Reflection ベース代替案についての補足

private method の inspection は、技術的には trait 方式だけに限られません。

Reflection ベースの手法で CI inspection を組み立てることも可能です。

例:

- `ReflectionMethod`
- `Closure::bind()`
- その他の test 側 access helper

### Reflection 方式のメリット

- class 側で CI 専用 trait を use しなくてよい
- 既存 class や legacy class に後付けしやすい
- private / protected method も CI 側から inspection できる
- inspection logic を CI engine 側へより集約できる

### Reflection 方式のデメリット

- 通常の class カプセル化境界をより強く壊しやすい
- CI が内部 method 名や引数シグネチャに強く依存しやすい
- CI engine 側が複雑になる
- class 側での CI 参加 contract が暗黙的になりやすい
- 長期保守では、CI 側に特殊処理が増えやすい

## なぜ現行設計では `OP_CI` を使うのか

現在の ONEPIECE Framework 設計が `OP_CI` を選んでいるのは、Reflection が不可能だからではありません。

trait ベースの contract の方が、運用上標準化しやすいためです。

この trait は pipeline に対して、次を統一的に提供します。

- method discovery
- method invocation

つまり、現行設計は、より implicit で reflection-heavy な方式よりも、次を優先しています。

- 明示的な CI 参加
- 一貫した inspection contract
- より単純な CI engine

## この framework で trait が Reflection より合っている理由

現在の `op-unit-ci` 設計では、比較対象は単に private method に到達できるかどうかだけではありません。

CI 参加をどう標準化するかが本質です。

現在の CI flow は次を行います。

- target repository を走査する
- `.class.php` を見つける
- 必要なら `class/*.class.php` も走査する
- class を instantiate する
- `OP_CI` を要求する
- `CI_AllMethods()` で method list を取得する
- subsystem の `ci/` directory から expected-result rule を読む
- `CI_Inspection()` を通して各対象を実行する

この flow から見ると、`OP_CI` は単なる private method access の小技ではありません。

それは同時に、現在の次の contract でもあります。

- CI 参加
- method discovery
- method invocation

### trait ベースモデル

この model では、class が inspection entry を明示的に提供します。

そのため、CI engine をより単純に保ちつつ、participation contract も可視化できます。

### Reflection ベースモデル

Reflection-heavy な model では、CI engine 側がより多くの仕事を担う必要があります。

その結果、ある意味では柔軟になりますが、hidden な複雑さも CI engine 側へ移ります。

### 実務上の違い

要するに次の違いです。

- Reflection は、CI engine が class の中へ入り込む
- `OP_CI` は、class が CI engine に標準 inspection gateway を提供する

この違いは、ONEPIECE Framework では重要です。framework 全体が hidden な特殊処理よりも explicit contract を好むためです。

そのため、この framework では trait 方式の方が、より大きな設計スタイルに合っています。

- 明示的な参加
- 統一された contract
- より単純な運用挙動

これは、ONEPIECE Framework が次の理由から明示的な処理を好む、というより大きな思想にも一致しています。

- simple
- intuitive
- concise
- easy to understand

## `op-unit-ci` との関係

`op-unit-ci` は、次の 2 点で `OP_CI` に依存しています。

- method discovery
- method invocation

つまり、この trait は current technical contract の一部です。

- CI engine
- 検査される class

の間をつなぐ役割を持っています。

## まとめ

`OP_CI` は、現在の ONEPIECE Framework 設計において、CI が class 挙動をどう inspection するかを標準化する trait です。

現行 pipeline では必須であり、class 内部挙動も統一 entry path で inspection できるようにしています。
