# Proposal

File-Scoped Visibility with the proposed TBD keyword refers to a new visibility level where symbols are accessible _**only**_ within the file in which they are declared. This enhances modularity and prevents unintended access from outside the file, ensuring better encapsulation and separation of concerns.

A simple example:

```php 
<?php // example.php
tbd function tbdFunction():string {
    return 'Function is file-scoped';
}
```

[include](./keyword-choices.md)

[include](./example-uses.md)

[include](./symbol-typing.md)

[include](./valid-invalid-uses.md)

[include](./prior-art.md)

[include](./compile-time.md)

[include](./conclusion.md)

