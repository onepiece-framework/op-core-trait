# `OP_ENV` Trait

## Overview

`OP_ENV` is the trait that provides environment-related framework methods such as:

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

## `isAdmin()`

`isAdmin()` determines whether the current request should be treated as administrator access.

The current behavior is:

- localhost is always treated as admin
- otherwise, the remote IP address is compared with the admin IP configured in `asset/config/admin.php`

The relevant setting is:

- `OP::_ADMIN_IP_`

This means `asset/config/admin.php` is the main configuration file that controls `OP()->isAdmin()` behavior in normal application use.

## Historical Background

The ONEPIECE Framework has gone through several major redesigns.

In the 2016 edition and the 2020 edition, `Env.class.php` existed as a normal class rather than as a trait.

As `op-core` grew larger, maintenance became more difficult.

For the 2030 edition, the framework was slimmed down significantly.

As part of that refactoring, environment-related behavior was moved into the `OP_ENV` trait.

## Compatibility Responsibility

The framework maintains compatibility between the 2020 edition and the 2030 edition so that rolling updates remain possible.

This compatibility is treated as one of the major responsibilities of the ONEPIECE Framework.

That is one of the main reasons the old usage style was preserved during the transition.

## Compatibility Behavior

In the 2020 edition, environment-related behavior was typically called like this:

```php
OP()->Env()->isLocalhost()
```

In the 2030 edition, the same result can be obtained by either:

```php
OP()->isLocalhost()
```

or:

```php
OP()->Env()->isLocalhost()
```

The direct form is provided by `OP_ENV`.

The older `Env()` access path is preserved through `OP_DEPRECATE`.

## Relationship to `OP_DEPRECATE`

The backward-compatible `OP()->Env()` method is implemented in `OP_DEPRECATE`.

That means the compatibility path is intentionally separated from the new direct-access path.

This makes the transition strategy explicit:

- new style: direct methods on `OP()`
- old style: compatibility access through deprecated wrapper behavior

## [DOC-FUTURE] Planned Removal

The dual-call compatibility behavior is considered a transition measure.

The current plan is that this compatibility feature will be removed after the 2030 line.

In other words, the ability to call both:

- `OP()->isLocalhost()`
- `OP()->Env()->isLocalhost()`

is not intended to remain forever as a core requirement.

## Flexibility of the Design

Even if the framework stops using `OP_DEPRECATE` by default in the future, compatibility can still be retained by users who explicitly continue to use that trait in their own customization.

This flexibility is one of the characteristics of the ONEPIECE Framework.

It allows the framework to move forward while still giving advanced users a path to preserve older behavior intentionally.
