# Symbol Typing

This RFC proposes that any symbols declared with the `fileonly` keyword that can be typed MUST be typed, even if that type is `mixed`.  Symbols that can and cannot be typed are:

- **_Typeable_**: variables and functions _(includes properties and methods)_
- **_Not Typeable_**: constants, classes, and interfaces

## Rationale for Requiring Typing
Introducing a file-scoping provides an opportunity for optimnization that does not current exist in PHP. Since everything else in PHP can be declared in one file and referenced in another at runtime PHP must ensure that they are compatible with `eval()`, variable variables, and other techniques which requires extra information to be associated with the symbol which occupies extra memory and takes extra time to process compared to _"raw"_ data.

This RFC envisions that the PHP compile step will be allowed to fully process file-scoped variables and optimize them for their use-cases. This RFC however does not include such optimization to minimize scope but intended to make such optimization possible via future RFCs.

# Parsing and Name Access
Per this RFC, PHP is allowed to optimize out any symbols that are declared with the `fileonly` keyword and that cannot be referenced externally.

For example, given the following PHP would be allowed to replace `{$name}` in the string at compile time so that the string need not be interpolated at runtime:

```php
fileonly string $name = "php";
echo "Hello {$name}!"
```
Further, the variable `$name` is also discarded at compile time and not available at runtime.  This also means that Reflection will mostly not be available for these symbols.

## Boxing and Unboxing
When variables and properties need to be passed to existing PHP functions that expect proper PHP value structures the compiler will need to "box" them first. In the following example the PHP compiler **_might_** need to box `$name` before sending to `strtoupper()` and then unbox upon retrieving the return value to store back into name.

```php
fileonly string $name = "php";
$name = strtoupper($name);
echo "Hello {$name}!"
```
Note that I said _"might"_ need to box and unbox. This RFC defines this behavior as up to the compiler to decide if it should maintain `$name` as a raw value or if it should just maintain it as a proper PHP variable. Userland should never be affected by this choice.

## Repeated Loading
If a PHP file repeated is loaded using `include` or `require` and all symbols are declared with `fileonly` declared symbols then PHP seeing those symbols repeatedly does not cause a runtime error. Regarding each symbol type:

- Variables declared with the `fileonly` keyword will be treated as separate variables. If they are not exposed externally with a pointer then the compiler can discard them after processing the file.
- Variables declared `fileonly static` will be treated as the same variable and will have the same lifetime as a global.
- `fileonly`-declared classes, interfaces, functions and constants can be treated the same as there will be no need to duplicate them in PHP's symbol table memory.

## Variables declared `fileonly static`
If a variable is declared as `fileonly static` it will have file-scoped visibility, and it will have the lifetime of a global variable just as a static property has when declared in a class.

## Referencing File-scoped Symbols Externally
Even though a symbol may be `fileonly`-declared and thus has file-scoped visibility it could still be used externally if exposed by non file-scoped visible symbols.

Consider the following example:

```php
<?php // my-package.php
fileonly class MyClass {
   public $myProperty = "My Value";
}
return new package\MyClass();
```
Then it can be used like so:
```php 
<?php

$c = include("my-package.php");
echo $c->myProperty;            // Outputs: My Value
```

## Simulating Packages
As an even more useful pattern, consider this example:

```php
<?php // my-package.php
tdb class MyClass {
   private string $value;
   public function __construct(string $value) {
      $this->value = $value;
   }
   public function getValue():string {
      return $this->value;
   }
}
tdb class MyPackage {
   public function newMyClass(string $value):object {
      return new package\MyClass($value);
   }
}
return new MyPackage();
```
Now this can be used like so:
```php 
<?php
$p = include("my-package.php");
$c = $p->newMyClass("foo");
echo $c->value();                   // Outputs: foo
```
## Fully-qualified Names of File-scoped Classes
Clearly, the code declaring `MyClass` and `MyPackage` from the prior section brings up an interesting concern; what value should `get_class()`, `get_called_class()` and similar functionality have?

Following the lead provided by anonymous classes this RFC proposes that for `fileonly MyClass` in the `\Foo\Bar` namespace in the file `/path/to/php.file` and declared on line `42` then the return value from `get_class()` et al. would be:

```php
$null=chr(0);
return "\\Foo\\Bar\\MyClass@fileonly{$null}/path/to/php.file:42$0";
```
In the above `fileonly` would of course be replaced by the actual keyword chosen for `fileonly`.

## Reflection
Although Reflection could potentially be enhanced for file-scoped visibility this RFC proposes that Reflection simply ignore TDB keyword declared symbols and treats class instances for classes declared with file-scoped visibility as it anonymous classes albeit with the change in actual FQCN described the prior section.

If a strong need for enhanced reflection is identified after this RFC is adopted, assuming it is, then future RFCs can tackle those concerns. 
