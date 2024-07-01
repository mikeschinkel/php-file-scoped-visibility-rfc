# PHP RFC: File-scoped Visibility

- Version: 0.1
- Date: 2024-06-29
- Author: Mike Schinkel <mike@newclarity.net>
- Status: Draft
- First Published at: https://github.com/mikeschinkel/php-file-scoped-visibility-rfc

## Introduction

PHP has a rich set of visibility-scoping capabilities for class members in the form or `public`, `protected` and `private` modifiers to be applied methods and properties.

PHP also has _(legacy)_ global variables which can be introduced as visible into the scope of a function using the `global` keyword.

PHP has the `namespace` keyword for enabling the developer to organize related code, avoid name collisions, and enhance autoloading.  

What PHP does **_not_** provide is any visibility scoping mechanism for variables or constants declared outside of a `function` or `class`, nor for functions, classes or interfaces themselves, **_collectively referred to as "symbols"_** for the rest of this RFC.

And specifically regarding namespaces, PHP also does not provide any way for developers to limit the access of symbols declared inside a `namespace` from outside the `namespace`.

This RFC proposes to introduce a new form of visibility scoping to PHP in the form of a **TBD keyword** that, if adopted will impart visibility of symbols declared with the selected keyword to be visible only within the file, and nowhere else.

Note: **_TBD_** means **_"To Be Determined"_** either by RFC vote, or by overwhelming consensus before the RFC vote begins.

### Defining "Visibility" in PHP
See [VISIBILITY.md](VISIBILITY.md)

## Proposal

File-Scoped Visibility with the proposed TBD keyword refers to a new visibility level where symbols are accessible _**only**_ within the file in which they are declared. This enhances modularity and prevents unintended access from outside the file, ensuring better encapsulation and separation of concerns.

A simple example:

```php 
<?php // example.php
tbd function tbdFunction():string {
    return 'Function is file-scoped';
}
```

## Keyword Choices
See [KEYWORD-CHOICES.md](KEYWORD-CHOICES.md)

### Example Usages 
See [EXAMPLE-USES.md](EXAMPLE-USES.md)

### Symbol Typing
See [SYMBOL-TYPING.md](SYMBOL-TYPING.md)

### Valid and Invalid Uses
See [VALID-INVALID-USES.md](VALID-INVALID-USES.md)

### Prior Art 
See [PRIOR-ART.md](PRIOR-ART.md)

## Compile-Time Concepts and Optimization
See [COMPILE-TIME.md](COMPILE-TIME.md)

## RFC Impact
See [RFC-IMPACT.md](RFC-IMPACT.md)

## Open Questions
1. What is the TBD keyword going to be?

2. Can TBD-declared variables be implemented in a more performant manner and require less memory than regular PHP variables by following any _(additional)_ constraints, even is the optimizing implementation is postponed to a future RFC? 

## Potential Future Scope
1. Compile-time Optimization
2. Run-time Optimization
3. Reflection

## Conclusion
The addition of file-scoped visibility using the TBD keyword will provide PHP developers with a powerful tool for better encapsulation, modularity, and security. By clearly defining and restricting the scope of symbols to the file level, this feature will help maintain clean and maintainable codebases.

