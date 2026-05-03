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

- calls `_Map(__FUNCTION__)`
- resolves the mapped unit name through `Mapping()`
- returns the instantiated unit through `Instantiated()`

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
