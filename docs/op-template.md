# OP_TEMPLATE

Source file: `asset/core/trait/OP_TEMPLATE.php`

## Overview

`OP_TEMPLATE` provides `OP()->Template()`.

`OP()->Template()` resolves a template path, executes the selected file inside an isolated closure, passes the supplied arguments as local variables, and returns the included file result when that result is not PHP's normal `include` success value.

## As-Is

This section records the current implementation behavior of `OP()->Template()` as provided by `OP_TEMPLATE`.

Other documents that need the current `OP()->Template()` behavior should refer to this As-Is section instead of duplicating implementation details.

### Current Directory During Template Execution

Current implementation changes PHP's current working directory to the directory of the selected template file before including that file.

This means a template can include or refer to another file by a relative path from the template file's own directory, no matter which directory originally called `OP()->Template()`.

After template execution finishes, the implementation restores the previous current working directory.

This behavior matters because template authors can write directory-local relative paths without needing to know the caller's working directory.

### Current Lookup Order

[DOC-PRIORITY1] Current implementation searches template files in this order:

1. current working directory at the time `OP()->Template()` is called
2. unit template directory, when the call is made from a Unit namespace
3. `asset/layout/<layout-name>/template/`, when a layout is configured
4. `asset/template/`

The intended specification order is documented in `asset/docs/skeleton/template-directory.md`.

### Path Rules

Current implementation rejects:

- an empty file name
- an absolute path from filesystem root
- a path containing `..`

It accepts:

- framework meta paths, after conversion through `ConvertPath()`
- relative paths that resolve inside one of the template search directories

### Argument Rules

`$args` must be an associative array.

When arguments are provided, `OP()->Template()` extracts them into the template closure with `EXTR_SKIP`, so existing local variables inside the closure are not overwritten.

Current implementation checks numeric-indexed arguments before resolving the template path or changing the current working directory.

This means an invalid non-associative `$args` value does not leave PHP in the template directory.

Normal associative-argument execution and caught template exceptions restore the previous directory after template execution.
