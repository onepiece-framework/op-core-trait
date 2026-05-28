# `OP_ENV` トレイト

## 概要

`OP_ENV` は、次のような環境関連の framework method を提供する trait です。

- `isCI()`
- `isShell()`
- `isHttp()`
- `isHTTPs()`
- `isLocalhost()`
- `isAdmin()`
- `MIME()`
- `Request()`
- `AppID()`
- `Time()`
- `Timestamp()`

## `isCI()`

`isCI()` は、現在の process が ONEPIECE Framework の CI pipeline の中で実行されている場合に `true` を返します。

現行実装では、`_IS_CI_` constant が定義されているかどうかを確認します。

`OP()->isCI()` は、environment-dependent behavior を CI inspection 中に deterministic にするための、framework 標準の方法です。runtime code が local machine や process の値を必要とする場合、その environment read を小さな method に分け、`OP()->isCI()` が `true` の時だけ固定値を返してください。

例:

```php
function GetPosixUid()
{
	return OP()->isCI() ? 1000 : posix_geteuid();
}
```

class を class-based CI に残すべきだが、一部の behavior が次のような runtime-only state に依存する場合、この pattern を使います。

- process user または group
- local filesystem state
- shell command availability
- generated ID または timestamp
- deterministic な CI value が必要な database record

framework 自身が CI-mode branch を提供できる場合、この pattern は外部 stub class の代替になります。

`OP()->isCI()` を、意味のある contract check を skip するために使わないでください。検査対象 behavior を repeatable にし、その安定した結果を通常の CI config で確認するために使ってください。

## `isAdmin()`

`isAdmin()` は、現在の request を管理者アクセスとして扱うべきかどうかを判定します。

現行の挙動は次です。

- localhost からのアクセスは常に admin 扱い
- それ以外は、remote IP address と `asset/config/admin.php` に設定された admin IP を比較する

関連する設定は次です。

- `OP::_ADMIN_IP_`

つまり、通常の application 運用では、`OP()->isAdmin()` の挙動を制御する主な設定ファイルは `asset/config/admin.php` です。

## 歴史的背景

ONEPIECE Framework では、これまでに何度か大きな刷新が行われています。

`op-core-7` と 2020 世代までは、`Env.class.php` が存在しており、trait 化されていない通常の class でした。

しかし、`op-core` の肥大化によってメンテナンスが困難になっていきました。

そのため、`op-core-8` と 2030 世代では framework を大幅にスリム化し、`Env.class.php` は独立した主設計要素としては不要になりました。

そのリファクタリングの一環として、もともと `Env.class.php` 経由で使っていた method 群は `OP_ENV` trait に移されました。

## 互換性維持という責任

ONEPIECE Framework では、2020版と2030版の互換性を維持し、そのままローリングアップデートできることを重要な責任のひとつと考えています。

この互換性維持が、移行期に旧来の呼び出し方を残した主な理由のひとつです。

## 互換挙動

2020版では、環境関連機能は通常次のように呼び出していました。

```php
OP()->Env()->isLocalhost()
```

2030版では、同じ結果を次のどちらでも得られます。

```php
OP()->isLocalhost()
```

または

```php
OP()->Env()->isLocalhost()
```

直接呼び出す新しい形式は `OP_ENV` が提供しています。

旧来の `Env()` アクセス経路は `OP_DEPRECATE` によって維持されています。

実務上の移行モデルは次です。

- 旧来の `Env.class.php` 的な method 群を `OP_ENV` に移す
- `\OP\OP` が `OP_ENV` を use することで、`OP()->isLocalhost()` のような直接呼び出しを可能にする
- `OP_DEPRECATE` の互換 wrapper により、移行期間中も `OP()->Env()` を使えるようにする

そのため、まだ `OP()->Env()` を呼び出している古い unit でも、直接 `OP()` method への移行が完了するまで動かし続けることができます。

## `OP_DEPRECATE` との関係

後方互換のための `OP()->Env()` method は `OP_DEPRECATE` に実装されています。

つまり、互換用の経路は新しい直接アクセス経路とは意図的に分離されています。

これにより、移行方針が明確になります。

- 新しい形式: `OP()` 直下の method
- 古い形式: deprecated wrapper を経由する互換呼び出し

## [DOC-FUTURE] 将来的な廃止予定

この両対応の互換挙動は、移行措置として位置付けられています。

現在の方針では、この互換機能は 2030 移行 line まで、またはその後に廃止される予定です。

つまり、次の両方を呼べる状態:

- `OP()->isLocalhost()`
- `OP()->Env()->isLocalhost()`

は、永続的な core 要件として残す前提ではありません。

## 設計の柔軟性

将来的に framework が標準では `OP_DEPRECATE` を use しなくなったとしても、利用者が自分でその trait を use してカスタマイズすれば、互換性を維持することは可能です。

この柔軟性も ONEPIECE Framework の特徴のひとつです。

framework を前進させつつ、必要な利用者には旧来挙動を意図的に維持する余地を残しています。
