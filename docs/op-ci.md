# `OP_CI`

## Overview

`OP_CI` is the trait that gives the ONEPIECE Framework CI pipeline a standard inspection surface for classes.

In the current design, classes that participate in CI are expected to use this trait.

If they do not, repository CI fails.

## Why It Exists

The CI pipeline is class-oriented.

It scans target repositories, finds class files, instantiates those classes, and then inspects methods through a standard trait-based entry.

`OP_CI` exists so that CI can rely on a uniform inspection contract without requiring each class to implement its own custom CI dispatch logic.

## Current Methods

The current trait provides:

- `CI_AllMethods()`
- `CI_Inspection(string $method, ...$args)`

## `CI_AllMethods()`

`CI_AllMethods()` returns:

- `get_class_methods($this)`

This gives the CI layer a standard way to obtain the inspectable method list for the current instance.

In the current operational design, that method list is treated as the inspection source for the class, subject to CI-engine-side skip rules.

## `CI_Inspection()`

`CI_Inspection()` executes the requested method through:

- `$this->{$method}(...$args)`

This gives the CI layer a single standard entry point for invoking class behavior under inspection.

## Why Private Methods Can Be Inspected

One of the important practical consequences of this design is that private methods can also be inspection targets.

Because `CI_Inspection()` is defined in the trait and runs inside the class context:

- the CI pipeline does not have to call every method directly from outside the class
- internal class behavior can still be executed through the trait-based inspection path

This is one of the reasons `OP_CI` is more than just a marker trait.

It is also the technical bridge that makes deeper class-level inspection possible.

## Note About Reflection-Based Alternatives

Private-method inspection is not technically limited to the trait approach.

It would also be possible to build CI inspection through reflection-based techniques.

Examples include:

- `ReflectionMethod`
- `Closure::bind()`
- other test-side access helpers

### Advantages of a Reflection-Based Approach

- classes would not need to use a CI-specific trait
- existing or legacy classes could be inspected with less direct modification
- private or protected methods could still be inspected from the CI side
- more of the inspection logic could be centralized on the CI-engine side

### Disadvantages of a Reflection-Based Approach

- it weakens normal class encapsulation boundaries more aggressively
- CI becomes more tightly coupled to internal method names and signatures
- the CI engine becomes more complex
- the participation contract becomes less explicit at the class level
- long-term maintenance can become harder because the CI side carries more special-case behavior

## Why the Current Design Uses `OP_CI`

The current ONEPIECE Framework design chooses `OP_CI` not because reflection is impossible, but because a trait-based contract is easier to standardize operationally.

The trait gives the pipeline a uniform way to do:

- method discovery
- method invocation

So the current design favors:

- explicit CI participation
- a consistent inspection contract
- a simpler CI engine

over a more implicit reflection-heavy approach.

## Why Trait Over Reflection in This Framework

With the current `op-unit-ci` design, the comparison is not only about whether private methods can be reached.

It is about how CI participation is standardized.

The current CI flow does the following:

- walks target repositories
- finds `.class.php` targets
- also scans `class/*.class.php` when needed
- instantiates the class
- requires `OP_CI`
- gets the method list through `CI_AllMethods()`
- loads expected-result rules from the subsystem `ci/` directory
- invokes each target through `CI_Inspection()`

Because of that flow, `OP_CI` is not just a private-method access trick.

It is also the current contract for:

- CI participation
- method discovery
- method invocation

### Trait-Based Model

In this model, the class explicitly provides the inspection entry.

That keeps the CI engine simpler and makes the participation contract visible.

### Reflection-Based Model

In a reflection-heavy model, the CI engine would have to do more of the work itself.

That would make CI more flexible in one sense, but it would also shift more hidden complexity into the CI engine.

### Practical Difference

In short:

- reflection means the CI engine reaches into the class
- `OP_CI` means the class provides a standard inspection gateway to the CI engine

That difference matters in the ONEPIECE Framework because the framework generally prefers explicit contracts over hidden special-case behavior.

So, in this framework, the trait approach fits better with the broader design style:

- explicit participation
- uniform contracts
- simpler operational behavior

This also matches the broader framework philosophy that prefers explicit processing because it is more:

- simple
- intuitive
- concise
- easy to understand

## Relationship to `op-unit-ci`

`op-unit-ci` depends on `OP_CI` for two things:

- method discovery
- method invocation

So the trait is part of the current technical contract between:

- the CI engine
- the inspected class

## Summary

`OP_CI` is the trait that standardizes how CI inspects class behavior in the current ONEPIECE Framework design.

It is required by the current pipeline, and it helps make even class-internal behavior inspectable through a uniform entry path.
