# `OP_UNIT_MAPPER`

## Overview

`OP_UNIT_MAPPER` is the trait that provides typed unit accessors such as:

- `App()`
- `CI()`
- `Layout()`
- `WebPack()`

It does not replace the generic `OP()->Unit('Name')` mechanism.

Instead, it adds typed method-chain access for units that are explicitly supported by the mapper.

## Current Behavior

Each typed accessor:

- accepts optional arguments
- calls `_Map(__FUNCTION__, ...$args)`
- resolves the mapped unit name through `Mapping()`
- gets the instantiated unit through `Instantiated()`
- returns the instantiated unit after the optional Auto step

## Optional Auto Step

`_Map()` runs `Auto(...$args)` only when the typed accessor receives arguments and the mapped unit instance has an `Auto` method.

This means normal unit access remains side-effect free:

```php
OP()->Unit()->WebPack();
```

When arguments are passed, the accessor becomes an explicit Auto shortcut:

```php
OP()->Unit()->WebPack('app.js', 'app.css');
```

The arguments are forwarded to the unit's `Auto()` method:

```php
OP()->Unit()->WebPack()->Auto('app.js', 'app.css');
```

This behavior is intentionally gated by the presence of accessor arguments. Simply retrieving a unit instance must not launch its automatic behavior, because existing code uses mapper accessors to get unit instances for normal method calls.

## Mapping Source

`Mapping()` caches:

- `Config::Get('unit')`

and then looks at:

- `$_config['mapping'][strtolower($name)]`

If a mapping exists, the requested unit name is replaced by the mapped name.

If no mapping exists, the original unit name is used.

## Typed Return Contracts

Each accessor declares a typed return interface.

Examples:

- `App() : IF_APP`
- `CI() : IF_CI`
- `Layout() : IF_LAYOUT`
- `WebPack() : IF_WEBPACK`

This is what ties mapper-based replacement to interface-based expectations.
