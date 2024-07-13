# Proposal

File-Scoped Visibility with the proposed `fileonly` keyword refers to a new visibility level where symbols are accessible _**only**_ within the file in which they are declared. This enhances modularity and prevents unintended access from outside the file, ensuring better encapsulation and separation of concerns.

A simple example:

```php 
<?php // example.php
fileonly function exampleFunction():string {
    return 'Function is file-scoped';
}
```

[merge](./keyword-choices.md)

[merge](./example-uses.md)

[merge](./symbol-typing.md)

[merge](./valid-invalid-uses.md)

[merge](./prior-art.md)

[merge](./compile-time.md)

[merge](./conclusion.md)

