# Introduction

PHP has a rich set of visibility-scoping capabilities for class members in the form or `public`, `protected` and `private` modifiers to be applied methods and properties.

PHP also has _(legacy)_ global variables which can be introduced as visible into the scope of a function using the `global` keyword.

PHP has the `namespace` keyword for enabling the developer to organize related code, avoid name collisions, and enhance autoloading.

What PHP does **_not_** provide is any visibility scoping mechanism for variables or constants declared outside of a `function` or `class`, nor for functions, classes or interfaces themselves, **_collectively referred to as "symbols"_** for the rest of this RFC.

And specifically regarding namespaces, PHP also does not provide any way for developers to limit the access of symbols declared inside a `namespace` from outside the `namespace`.

This RFC proposes to introduce a new form of visibility scoping to PHP in the form of a **`fileonly` keyword** that, if adopted will impart visibility of symbols declared with the selected keyword to be visible only within the file, and nowhere else.
