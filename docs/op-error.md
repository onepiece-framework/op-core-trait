# OP_ERROR

This document describes the storage behavior implemented by the `OP_ERROR` trait.

## Purpose

`OP_ERROR` is the storage layer for collected framework errors.

It does not register PHP handlers by itself, and it does not decide whether an error is shown on screen or sent by email.

Its role is:

- provide the session storage location for collected errors
- normalize stored error data
- aggregate repeated errors
- provide read methods for later notice processing

## Session Namespace

The current storage location is:

- `$_SESSION[_OP_NAME_SPACE_][_APP_ID_]['OP_ERROR']`

This keeps error records inside the current framework namespace and current application scope.

## `Set()`

`Set()` accepts:

- a `Throwable`
- an array from `error_get_last()`
- a string message

The method normalizes the input into a common stored structure.

## Stored Fields

Each stored error record may contain:

- `count`
- `created`
- `updated`
- `message`
- `backtrace`
- `REQUEST_URI`

### Meaning of Each Field

- `count`
  Number of times the same normalized message has been recorded
- `created`
  Timestamp of the first occurrence
- `updated`
  Timestamp of the latest repeated occurrence
- `message`
  Normalized error message
- `backtrace`
  Trace information captured when the error was first stored
- `REQUEST_URI`
  A history of request URIs where the error occurred

## Aggregation Rule

Errors are grouped by a key derived from the message:

- `substr(md5($message), 0, 8)`

This means repeated errors with the same message are merged into one stored record.

When the same key appears again:

- `count` is incremented
- `updated` is refreshed
- the new `REQUEST_URI` is appended

The original `backtrace` and initial `created` timestamp are preserved from the first record.

## Read Methods

The trait provides:

- `Get()`
  Reads and removes the oldest stored error with `array_shift()`
- `Pop()`
  Reads and removes the newest stored error with `array_pop()`
- `Has()`
  Returns whether at least one stored error exists

These methods are used by later notice and debugging flows.

## Dependency Boundary

`OP_ERROR` is between the error-capture layer and the notice layer.

Upstream:

- `asset/core/include/Error.php`

Downstream:

- `asset/unit/notice/Notice.class.php`

## Design Intent

The trait keeps error handling modular.

- capture is handled in one place
- storage is handled in one place
- output and notification are handled in one place

This separation makes the framework easier to evolve and easier to keep compatible across rolling updates.

