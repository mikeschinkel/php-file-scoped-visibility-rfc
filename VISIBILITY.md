### Example Usages of TBD keyword
#### Tbd Function
```php 
<?php // example.php
tbd function tbdFunction():string {
    return 'Function is file-scoped';
}

// Accessible within this file
echo tbdFunction();         // Outputs: Function is file-scoped
```

```php 
<?php 
require('example.php');
echo tbdFunction();         // Throws an error — TBD functions 
                            // not visible outside declaring file
```

#### TBD Variable
```php 
<?php // example.php
tbd string $tbdVariable = 'Variable is file-scoped';

// Accessible within this file
echo $tbdVariable();        // Outputs: Variable is file-scoped

function getTbdVariable() {
   // $tbdVariable being file-scoped means it is visibly across
   // entire file, including within a function or class method.
   return $tbdVariable;
}
```

```php 
<?php 
require('example.php');
echo getTbdVariable();      // Outputs: Variable is file-scoped
echo $tbdVariable;          // Throws an error — TBD variables 
                            // not visible outside declaring file
 
```

#### TBD Constant
```php 
<?php // example.php
tbd const LOCAL_CONSTANT = 'Constant is file-scoped';

// Accessible within this file
echo LOCAL_CONSTANT;        // Outputs: Constant is file-scoped

function get_LOCAL_CONSTANT() {
   // LOCAL_CONSTANT being file-scoped means it is visibly across
   // entire file, including within a function or class method.
   return LOCAL_CONSTANT;
}
```

```php 
<?php 
require('example.php');
echo get_LOCAL_CONSTANT();  // Outputs: Constant is file-scoped
echo LOCAL_CONSTANT;        // Throws an error — TBD constants 
                            // not visible outside declaring file
```

#### TBD Class
```php 
<?php // example.php
tbd class TbdClass {
    public function getMessage():string {
        return 'Class is file-scoped';
    }
}

// Accessible within this file
$tbdClass = new TbdClass();
echo $tbdClass->getMessage(); // Outputs: Class is file-scoped

function newTbdClass() {
   // TbdClass being file-scoped means it is visibly across
   // entire file, including within a function or class method.
   return new TbdClass();
}
```

```php 
<?php 
require('example.php');
$c1 = newTbdClass();
$c1->getMessage();          // Outputs: Class is file-scoped
$c2 = new TbdClass();       // Throws an error — TBD classes 
                            // not visible outside declaring file
```
#### TBD Interface
```php 
<?php // example.php
tbd interface TBDInterface {
    public function getIt();
}

tbd class ImplementingClass implements TBDInterface {
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
// Throws an error — TBD interfaces not visible outside 
// declaring file
class MyClass implements TBDInterface {
    public function getIt():string {
        return 'This class cannot be declared';
    }
}
```
~~~~~~~~