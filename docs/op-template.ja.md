# OP_TEMPLATE

Source file: `asset/core/trait/OP_TEMPLATE.php`

## 概要

`OP_TEMPLATE` は `OP()->Template()` を提供する。

`OP()->Template()` は template path を解決し、選択された file を isolated closure の中で実行し、渡された arguments を local variables として渡し、included file の戻り値が PHP の通常の `include` success value ではない場合にその値を返す。

## As-Is

この section は、`OP_TEMPLATE` が提供する `OP()->Template()` の current implementation behavior を記録する。

current の `OP()->Template()` behavior が必要な他の document は、implementation detail を重複して書かず、この As-Is section を参照する。

### Template 実行中の current directory

current implementation は、選択された template file を `include` する前に、PHP の current working directory をその template file がある directory に変更する。

これにより、どの directory から `OP()->Template()` が呼び出されても、template は自分自身が置かれている directory からの relative path で別 file を include または参照できる。

template 実行が終わると、implementation は変更前の current working directory に戻す。

この behavior は、template author が caller の working directory を知らなくても、directory-local な relative path を書けるようにするために重要である。

### Current lookup order

[DOC-PRIORITY1] current implementation は template file を次の順で検索する。

1. `OP()->Template()` が呼び出された時点の current working directory
2. Unit namespace から呼び出された場合の unit template directory
3. layout が configured の場合の `asset/layout/<layout-name>/template/`
4. `asset/template/`

intended specification order は `asset/docs/skeleton/template-directory.ja.md` に記録されている。

### Path rules

current implementation は次を拒否する。

- empty file name
- filesystem root からの absolute path
- `..` を含む path

current implementation は次を受け入れる。

- `ConvertPath()` で変換された framework meta path
- template search directories のいずれかで解決される relative path

### Argument rules

`$args` は associative array でなければならない。

arguments が渡された場合、`OP()->Template()` は `EXTR_SKIP` により template closure 内へ展開する。そのため、closure 内に既に存在する local variable は上書きされない。

current implementation は numeric-indexed arguments の確認を、template path の解決や current working directory の変更より前に行う。

これにより、不正な non-associative `$args` が渡されても、PHP が template directory に残ることはない。

通常の associative-argument execution と、捕捉された template exception では、template execution 後に変更前の directory に戻る。
