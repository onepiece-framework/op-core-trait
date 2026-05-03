# `OP_DEPRECATE` Trait

## Overview

`OP_DEPRECATE` is the trait created for compatibility behavior.

It gathers wrapper-style methods that preserve older calling styles while the framework transitions to newer APIs.

## Role

The role of this trait is not to define the preferred new API.

Its role is to preserve compatibility for existing code during rolling updates and long transition periods.

## Example: `Env()`

One of the clearest examples is:

```php
OP()->Env()
```

In the 2030 edition, direct methods such as:

```php
OP()->isLocalhost()
```

are available through `OP_ENV`.

However, `OP()->Env()->isLocalhost()` is still preserved through `OP_DEPRECATE`.

## [DOC-FUTURE] Planned Direction

Compatibility helpers collected in `OP_DEPRECATE` are transitional by design.

They exist so that the framework can keep compatibility while still simplifying the main architecture.

The framework may stop using some of these compatibility helpers by default in future lines.

## Flexibility

Even if the framework removes default use of a compatibility helper, users can still choose to preserve that behavior themselves by explicitly using the trait in their own customization.

This makes `OP_DEPRECATE` not only a deprecation layer, but also a controlled compatibility layer.
