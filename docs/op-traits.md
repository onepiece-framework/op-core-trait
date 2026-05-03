# Traits Used by `\OP\OP`

## Overview

The `\OP\OP` class is built by combining traits.

These traits are the mechanism that gives the framework object most of its usable surface.

## Current Traits

The current class composition includes:

- `OP_CORE`
- `OP_CI`
- `OP_ENV`
- `OP_TEMPLATE`
- `OP_ONEPIECE`
- `OP_DEPRECATE`

## Trait Roles

At a high level:

- `OP_CORE`
  Core shared behavior
- `OP_CI`
  CI-related behavior
- `OP_ENV`
  Environment-related helpers such as request or MIME handling
- `OP_TEMPLATE`
  Template execution support
- `OP_ONEPIECE`
  High-level framework access methods such as `Unit()`, `Config()`, `Session()`, `Cookie()`, and `Encrypt()`
- `OP_DEPRECATE`
  Backward-compatibility or deprecated behavior handling

## Practical Importance

In practice, many of the methods developers call through `OP()` are provided by these traits rather than by the class body itself.

That is why the trait layer is essential to understanding how `OP()` works.

## Summary

The traits under `asset/core/trait/` are the behavior source of the `\OP\OP` framework object.
