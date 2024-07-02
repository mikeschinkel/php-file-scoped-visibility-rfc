# Example Usages of `fileonly` keyword
## Functions
```php 
<?php // example.php
fileonly function exampleFunction():string {
    return 'Function is file-scoped';
}

// Accessible within this file
echo exampleFunction();  // Outputs: Function is file-scoped
```

```php 
<?php 
require('example.php');
echo exampleFunction();  // Throws an error — FileOnly functions 
                         // not visible outside declaring file
```

## Variables
```php 
<?php // example.php
fileonly string $exampleVariable = 'Variable is file-scoped';

// Accessible within this file
echo $exampleVariable();  // Outputs: Variable is file-scoped

function getExampleVariable() {
   // $exampleVariable is file-scoped and visibly across
   // entire file, including within function and class method.
   return $exampleVariable;
}
```

```php 
<?php 
require('example.php');
echo getExampleVariable();  // Outputs: Variable is file-scoped
echo $exampleVariable;      // Throws an error — FileOnly variables 
                            // not visible outside declaring file
 
```

## Constants
```php 
<?php // example.php
fileonly const EXAMPLE_CONSTANT = 'Constant is file-scoped';

// Accessible within this file
echo EXAMPLE_CONSTANT;      // Outputs: Constant is file-scoped

function get_EXAMPLE_CONSTANT() {
   // EXAMPLE_CONSTANT being file-scoped means it is visibly across
   // entire file, including within a function or class method.
   return EXAMPLE_CONSTANT;
}
```

```php 
<?php 
require('example.php');
echo get_EXAMPLE_CONSTANT(); // Outputs: Constant is file-scoped
echo EXAMPLE_CONSTANT;       // Throws an error — FileOnly constants 
                             // not visible outside declaring file
```

## Classes
```php 
<?php // example.php
fileonly class ExampleClass {
    public function getMessage():string {
        return 'Class is file-scoped';
    }
}

// Accessible within this file
$exampleClass = new ExampleClass();
echo $exampleClass->getMessage(); // Outputs: Class is file-scoped

function newExampleClass() {
   // ExampleClass being file-scoped means it is visibly across
   // entire file, including within a function or class method.
   return new ExampleClass();
}
```

```php 
<?php 
require('example.php');
$c1 = newExampleClass();
$c1->getMessage();          // Outputs: Class is file-scoped
$c2 = new ExampleClass();   // Throws an error — FileOnly classes 
                            // not visible outside declaring file
```
## Interfaces
```php 
<?php // example.php
fileonly interface ExampleInterface {
    public function getIt();
}

fileonly class ImplementingClass implements ExampleInterface {
    public function getIt():string {
        return 'Interface is file-scoped';
    }
}

// Accessible within this file
$instance = new ImplementingClass();
echo $instance->getIt();    // Outputs: Interface is file-scoped
```

```php 
<?php 
require('example.php');
// Throws an error — FileOnly interfaces not visible outside 
// declaring file
class MyClass implements ExampleInterface {
    public function getIt():string {
        return 'This class cannot be declared';
    }
}
```