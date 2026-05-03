# OP_ERROR

この文書は、`OP_ERROR` trait が実装している保存仕様を説明します。

## 目的

`OP_ERROR` は、framework が収集したエラーの保存層です。

この trait 自体は PHP handler を登録せず、またエラーを画面表示するかメール送信するかも決定しません。

役割は次です。

- 収集済みエラーの session 保存先を提供する
- 保存データを正規化する
- 同じエラーを集約する
- 後段の notice 処理に向けて読出メソッドを提供する

## Session の名前空間

現行の保存先は次です。

- `$_SESSION[_OP_NAME_SPACE_][_APP_ID_]['OP_ERROR']`

これにより、エラーレコードは現在の framework namespace と現在の application scope の中に保持されます。

## `Set()`

`Set()` は次を受け取れます。

- `Throwable`
- `error_get_last()` が返す配列
- 文字列メッセージ

このメソッドは入力を共通の保存構造に正規化します。

## 保存される項目

各エラーレコードには次が含まれます。

- `count`
- `created`
- `updated`
- `message`
- `backtrace`
- `REQUEST_URI`

### 各項目の意味

- `count`
  同じ正規化 message が記録された回数
- `created`
  最初に発生した時刻
- `updated`
  繰り返し発生した最後の時刻
- `message`
  正規化されたエラーメッセージ
- `backtrace`
  最初に保存された時点のトレース情報
- `REQUEST_URI`
  そのエラーが発生した request URI の履歴

## 集約ルール

エラーは message から生成した key でまとめられます。

- `substr(md5($message), 0, 8)`

つまり、同じ message を持つ繰り返しエラーは、1 つの保存レコードに集約されます。

同じ key が再度現れた場合は次が行われます。

- `count` を増やす
- `updated` を更新する
- 新しい `REQUEST_URI` を追記する

一方で、最初の `backtrace` と `created` 時刻は保持されます。

## 読み出しメソッド

この trait は次を提供します。

- `Get()`
  `array_shift()` により最古のエラーを取り出して削除する
- `Pop()`
  `array_pop()` により最新のエラーを取り出して削除する
- `Has()`
  1 件以上の保存済みエラーがあるかを返す

これらは後段の notice や debug の流れで使われます。

## 依存境界

`OP_ERROR` は、エラー取得層と notice 層の間に位置します。

上流:

- `asset/core/include/Error.php`

下流:

- `asset/unit/notice/Notice.class.php`

## 設計意図

この trait は、エラーハンドリングを分業化しています。

- 取得は取得専用の場所で扱う
- 保存は保存専用の場所で扱う
- 表示と通知は表示・通知専用の場所で扱う

この分離により、framework は進化しやすくなり、rolling update をまたいだ互換性も保ちやすくなります。

