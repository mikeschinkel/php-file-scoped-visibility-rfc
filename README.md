# PHP RFC: File-scoped Visibility

- Version: 0.1
- Date: 2024-06-29
- Author: Mike Schinkel <mike@newclarity.net>
- Status: **ROUGH DRAFT**
- First Published at: https://github.com/mikeschinkel/php-file-scoped-visibility-rfc


## Defining "Visibility" in PHP
Visibility refers to the scope within which symbols can be accessed. Visibility controls access levels to these elements and ensures encapsulation, enhancing security and modularity in code.

### Why Do We Need File-Scoped Visibility in PHP?
**File-scoped visibility**, proposed to be implemented using the TBD keyword, addresses several critical needs in PHP development:

- **Encapsulation**: By restricting access to symbols within a single file, file-scoped visibility ensures better encapsulation. This prevents unintended interactions with other parts of the codebase and maintains a clear separation of concerns.

- **Alternate to Static Classes**: There are many PHP developers who actively dislike seeing `static` classes used as an alternate to namespaces, but many other PHP developers continue to use `static` classes in that manner as `static` classes allow for reducing the visibility of a long-lived variable to within just the one class.
  Adding a TDB keyword support would give developers a viable alternative to using `static` classes for encapsulation.

- **Reduced Naming Conflicts**: As projects grow, the risk of naming conflicts increases. File-scoped visibility prevents global namespace pollution, allowing developers to use the same names in different files without conflict, thereby reducing the risk of accidental name collisions.

- **Enhanced Security**: Sensitive data and functions can be confined within a single file, limiting their exposure and reducing the attack surface. This adds an extra layer of security by preventing access from outside the file.

- **Improved Code Organization**: File-scoped visibility encourages developers to organize code into self-contained, modular files. This makes the codebase easier to understand, maintain, and debug, promoting cleaner and more maintainable code structures.

By addressing these needs, file-scoped visibility will help PHP developers create more robust, secure, and maintainable applications.

## Proposal

File-Scoped Visibility with the proposed TBD keyword refers to a new visibility level where symbols are accessible _**only**_ within the file in which they are declared. This enhances modularity and prevents unintended access from outside the file, ensuring better encapsulation and separation of concerns.

A simple example:

```php 
<?php // example.php
tbd function tbdFunction():string {
    return 'Function is file-scoped';
}
```

### Keyword Choices

Options considered, in reverse order of author preference:

1. `var` — An existing reserverd word — deprecated for other uses — but only makes sense for variables. This would be perfect for variables with file-only visibility, but as it does not apply to any other symbol type `var` appear to be a non-starter.
2. `private` — An existing reserved word, but has the potential for too confusion with other uses of `private`.
3. `internal` — Not an existing keyword so has an existing small impact, There are [583 uses](https://github.com/search?q=internal+language%3APHP+symbol%3A%2F%5Einternal%24%2F&type=code) of `/^internal$/` in symbols in PHP code on public GitHub. However `internal` might get confused with being related to PHP Internals somehow.
4. `hidden` — Not an existing keyword so has an existing small impact, There are [approximate 1.5K uses](https://github.com/search?q=hidden+language%3APHP+symbol%3A%2F%hidden%24%2F&type=code) of `/^hidden$/` in symbols in PHP code on public GitHub. However, while its usage could learned, this is not a strong candidate as the symbols would not be hidden within the file, only outside of it.
5. `local` — Not an existing keyword so has an existing small impact, There are [approximate 2K uses](https://github.com/search?q=local+language%3APHP+symbol%3A%2F%5Elocal%24%2F&type=code) of `/^local$/` in symbols in PHP code on public GitHub. Ignoring the impact, the author believes `local` is a strong candidate for balancing conciseness and clarity, but can we ignore the impact?
5. `fileonly` — Not an existing keyword but [only affects 1 file](https://github.com/search?q=fileonly+language%3APHP+symbol%3A%2F%5Efileonly%24%2F&type=code) when searching `/^fileonly$/` on public GitHub. `fileonly` is the most clear in its intent however its combined word form _might_ be off-putting to some developers, hence why this RFC plans to offer a choice.

### Example Usages of TBD keyword
#### TBD Function
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

### Symbol Typing

This RFC proposes that any symbols declared with the TBD keyword that can be typed MUST be typed, even if that type is `mixed`.  Symbols that can and cannot be typed are:

- **_Typeable_**: variables and functions _(includes properties and methods)_
- **_Not Typeable_**: constants, classes, and interfaces

#### Rationale for Requiring Typing
Introducing a file-scoping provides an opportunity for optimnization that does not current exist in PHP. Since everything else in PHP can be declared in one file and referenced in another at runtime PHP must ensure that they are compatible with `eval()`, variable variables, and other techniques which requires extra information to be associated with the symbol which occupies extra memory and takes extra time to process compared to _"raw"_ data.

This RFC envisions that the PHP compile step will be allowed to fully process file-scoped variables and optimize them for their use-cases. This RFC however does not include such optimization to minimize scope but intended to make such optimization possible via future RFCs.

### Parsing and Name Access
Per this RFC, PHP is allowed to optimize out any symbols that are declared with the TBD keyword and that cannot be referenced externally.

For example, given the following PHP would be allowed to replace `{$name}` in the string at compile time so that the string need not be interpolated at runtime:

```php
tbd string $name = "php";
echo "Hello {$name}!"
```
Further, the variable `$name` is also discarded at compile time and not available at runtime.  This also means that Reflection will mostly not be available for these symbols.

#### Boxing and Unboxing
When variables and properties need to be passed to existing PHP functions that expect proper PHP value structures the compiler will need to "box" them first. In the following example the PHP compiler **_might_** need to box `$name` before sending to `strtoupper()` and then unbox upon retrieving the return value to store back into name.

```php
tbd string $name = "php";
$name = strtoupper($name);
echo "Hello {$name}!"
```
Note that I said _"might"_ need to box and unbox. This RFC defines this behavior as up to the compiler to decide if it should maintain `$name` as a raw value or if it should just maintain it as a proper PHP variable. Userland should never be affected by this choice.

#### Repeated Loading
If a PHP file repeated is loaded using `include` or `require` and all symbols are declared with `tbd` declared symbols then PHP seeing those symbols repeatedly does not cause a runtime error. Regarding each symbol type:

- Variables declared with the TBD keyword will be treated as separate variables. If they are not exposed externally with a pointer then the compiler can discard them after processing the file.
- Variables declared `tbd static` will be treated as the same variable and will have the same lifetime as a global.
- TBD-declared classes, interfaces, functions and constants can be treated the same as there will be no need to duplicate them in PHP's symbol table memory.

#### Variables declared `tbd static`
If a variable is declared as `tbd static` it will have file-scoped visibility, and it will have the lifetime of a global variable just as a static property has when declared in a class.

#### Referencing File-scoped Symbols Externally
Even though a symbol may be TBD-declared and thus has file-scoped visibility it could still be used externally if exposed by non file-scoped visible symbols.

Consider the following example:

```php
<?php // my-package.php
tbd class MyClass {
   public $myProperty = "My Value";
}
return new MyClass();
```
Then it can be used like so:
```php 
<?php

$c = include("my-package.php");
echo $c->myProperty;            // Outputs: My Value
```

#### Simulating Packages
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
      return new MyClass($value);
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
#### Fully-qualified Names of File-scoped Classes
Clearly, the code declaring `MyClass` and `MyPackage` from the prior section brings up an interesting concern; what value should `get_class()`, `get_called_class()` and similar functionality have?

Following the lead provided by anonymous classes this RFC proposes that for `tbd MyClass` in the `\Foo\Bar` namespace in the file `/path/to/php.file` and declared on line `42` then the return value from `get_class()` et al. would be:

```php
$null=chr(0);
return "\\Foo\\Bar\\MyClass@tbd{$null}/path/to/php.file:42$0";
```
In the above `tbd` would of course be replaced by the actual keyword chosen for `tbd`.

#### Reflection
Although Reflection could potentially be enhanced for file-scoped visibility this RFC proposes that Reflection simply ignore TDB keyword declared symbols and treats class instances for classes declared with file-scoped visibility as it anonymous classes albeit with the change in actual FQCN described the prior section.

If a strong need for enhanced reflection is identified after this RFC is adopted, assuming it is, then future RFCs can tackle those concerns. 

### Valid and Invalid Uses 

The TBD keyword introduces file-scoped visibility, which determines the scope of various elements within a PHP file. This section outlines where the TBD keyword will be valid and where it will not be applicable, based on the type of symbol being qualified.

#### Valid Uses

1. **Functions**
    - **Valid**: The TBD keyword can be used to declare functions that are only accessible within the file where they are defined.
    - **Valid example**:
      ```php
      tbd function tbdFunction():mixed {
          // Function is file-scoped
      }
      ```

2. **Variables**
    - **Valid**: The TBD keyword can be used to declare variables that are only accessible within the file where they are defined.
    - **Valid example**:
      ```php
      tbd string $tbdVariable = 'This variable is file-scoped';
      ```

3. **Constants**
    - **Valid**: The TBD keyword can be used to declare constants that are only accessible within the file where they are defined.
    - **Valid example**:
      ```php
      tbd const TBD_CONSTANT = 'This constant is file-scoped';
      ```

4. **Classes**
    - **Valid**: The TBD keyword can be used to declare classes that are only accessible within the file where they are defined.
    - **Valid example**:
      ```php
      tbd class TbdClass {
          // Class is file-scoped
      }
      ```

5. **Interfaces**
    - **Valid**: The TBD keyword can be used to declare interfaces that are only accessible within the file where they are defined.
    - **Valid example**:
      ```php
      tbd interface TbdInterface {
          // Interface is file-scoped
      }
      ```
3. **Within Namespaces**
    - **Valid**: The TBD keyword can be used within a namespace to limit visibility to only the specific file. This however **_will not_** make tbd symbols accessible via other files within the same namespace.
    - **Valid example**:
      ```php
      namespace MyNamespace {
        tbd function namespacedFunction():mixed {
          // Function is file-scoped
        }
        tbd string $namespacedVariable = 'This variable is file-scoped';
        tbd const NAMESPACED_CONSTANT = 'This constant is file-scoped';
        tbd class NamespacedClass {
          // Class is file-scoped
        }
        tbd interface NamespacedInterface {
           // Interface is file-scoped
        }
      }
       ```

#### Invalid uses

1. **Class Properties and Methods**
    - **Not Valid**: The TBD keyword cannot be used to declare properties or methods within a class. Class properties and methods are governed by the existing visibility keywords (`public`, `protected`, `private`).
    - **Invalid example**:
      ```php
      class MyClass {
          tbd mixed $property; // Invalid
          tbd function method():void {} // Invalid
      }
      ```

2. **Global Scope**
    - **Not Valid**: The TBD keyword is not applicable for elements that need to be accessible globally. Elements marked with TBD are restricted to the file in which they are declared.
    - **Invalid example**:
      ```php
      tbd global $globalVariable = 'This should be global'; // Invalid
      ```

3. **Namespaces**
    - **Not Valid**: The TBD keyword cannot be used to limit visibility of a namespaces across files. Namespaces are intended to organize code across files, and TBD operates within the file.
    - **Invalid example**:
      ```php
      tbd namespace MyNamespace { // Invalid
      }
      ```

The TBD keyword provides a way to declare file-scoped symbols and within namespaces for same. TBD is not applicable for class properties, class methods, global scope elements, or on namespaces. This targeted applicability ensures clear and consistent use of file-scoped visibility, enhancing code modularity and encapsulation.

### Prior Art

If the RFC is adopted then the concept of file-scoped or localized visibility will not unique to PHP and has been implemented in various forms across most well-known programming languages.

This section explores how different languages have approached similar concepts, including the syntax they use and their specific implementations.

**NOTE: This section was written with the help of ChatGPT since the author is not an expert in all languages so if there are errors you recognize please submit a pull request with a correction.**

#### 1. **C/C++**

In C and C++, file-scoped variables and functions are achieved using the `static` keyword. When applied to a global variable or function, `static` restricts its visibility to the file in which it is declared.

- **Syntax**:
  ```c
  // file1.c
  static int fileScopedVariable = 0;

  static void fileScopedFunction() {
      // Function is file-scoped
  }


#### 2. **JavaScript (ES6 Modules)**
JavaScript ES6 introduced modules, which allow variables, functions, and classes to be scoped to a single file. By default, any declaration within a module is scoped to that module unless explicitly exported.
- **Syntax**:
  ```javascript
  // fileScopedModule.js
  let fileScopedVariable = 0;

  function fileScopedFunction() {
      // Function is file-scoped
  }

  class FileScopedClass {
      // Class is file-scoped
  }

  // Exported items are accessible outside the file
  export { fileScopedVariable, fileScopedFunction, FileScopedClass };
   ```
#### 3. **Python**
In Python, file-scoped variables and functions are achieved using module-level scope. A Python module is a single file containing Python definitions and statements. Modules can define functions, classes, variables, and include runnable code. By default, any variable, function, or class defined in a module is accessible only within that module unless explicitly imported elsewhere.

- **Syntax**:
   ```py
   # file_scoped_module.py
   _file_scoped_variable = 0  # Via Python convention, a leading underscore 
                              # indicates intended module-private scope
   
   def _file_scoped_function():
   # Function is file-scoped
   pass
   
   class _FileScopedClass:
   # Class is file-scoped
   pass
   ```

#### 4. **Rust**
Rust has module-level privacy by default. Items in a module are private to the module unless declared `pub`.

- **Syntax**:
   ```rust
   // my_module.rs
   fn file_scoped_function() {
      // Function is file-scoped
   }
   
   const FILE_SCOPED_CONSTANT: u32 = 0;
   
   struct FileScopedStruct {
      // Struct is file-scoped
   }
   ```

#### 5. **Go**
In Go, there are no file-scoped variables or functions. Instead, Go has `package` scoped variables and functions. These are identified as package-only scope by not being exported, where in Go symbols are exported by making the first letter of the symbol upper-case.

- **Syntax**:
   ```go
   package main
   
   var packageScopedVariable = 0 // package-scoped
   
   func packageScopedFunction() {
      // Function is package-scoped
   }
   
   type packageScopedStruct struct {
      // Struct is package-scoped
   }
   ```


#### 6. **Ruby**

In Ruby, file-scoped variables and functions are not natively supported as in some other languages, although it can be simulated using module encapsulation similar to how it can be simulated in PHP classes with `static`.

By defining variables, methods, and classes within a Ruby module and not including the module in any other part of the code, these elements remain accessible only within the file where they are defined. This approach leverages Ruby's modular structure to create a private, file-level scope.

- **Syntax**:
  ```ruby
  module FileScopedModule
    FILE_SCOPED_CONSTANT = 0

    def file_scoped_function
      # Function is file-scoped
    end

    class FileScopedClass
      # Class is file-scoped
    end
  end
  # Not including FileScopedModule in any other context keeps it file-scoped
  ```

#### 7. **Kotlin**
In Kotlin, top-level functions, variables, and classes are scoped to the file unless explicitly marked `internal` or `public`. Using the `private` keyword makes these declarations file-scoped, ensuring they are only accessible within the file where they are defined.

- **Syntax**:
  ```kotlin
  private val fileScopedVariable = 0

  private fun fileScopedFunction() {
      // Function is file-scoped
  }

  private class FileScopedClass {
      // Class is file-scoped
  }
  ```

#### 8. **Swift**
In Swift, file-scoped variables and functions are declared using the `private` keyword at the top level within a file. This keyword restricts the visibility of these elements to the file in which they are defined, preventing them from being accessed from other files.

- **Syntax**:
   ```swift
   private var fileScopedVariable = 0
   
   private func fileScopedFunction() {
      // Function is file-scoped
   }
   
   private class FileScopedClass {
      // Class is file-scoped
   }
   ```

#### 8. **Java**

Java does not support file-scoped variables and functions directly, but it has package-private scope _(default visibility)_ to restrict access within the same package. In Java you do not specify an access modifier (such as `public`, `protected`, or `private`) for a class, method, or variable, it is only accessible to other classes within the same package.

Although it doesn't provide true file-level scope, package-private visibility effectively limits the accessibility of certain elements to a defined group of classes, thereby maintaining a degree of modularity and preventing unintended interactions between unrelated parts of the code.

- **Syntax**:
   ```java
   class FileScopedClass {
      // Class is package-private
      void fileScopedMethod() {
          // Method is package-private
      }
   }
   ```

#### 9. TypeScript
TypeScript uses ES6 modules, similar to JavaScript, to scope variables, functions, and classes to a single file unless they are explicitly exported. By default, any declarations within a TypeScript file are private to that file, meaning they cannot be accessed from other files unless the module exports them. This is done using the `export` keyword, which makes them declared variables, functions, or classes available to other files that `import` them. When elements are not exported, they remain isolated within the file.

- **Syntax**:
   ```
   // fileScopedModule.ts
   let fileScopedVariable = 0;
   
   function fileScopedFunction() {
   // Function is file-scoped
   }
   
   class FileScopedClass {
   // Class is file-scoped
   }
   
   // Exported items are accessible outside the file
   export { fileScopedVariable, fileScopedFunction, FileScopedClass };
   ```

#### 10. Clipper
Clipper, an older programming language, initially had only dynamic variables, which were globally accessible throughout the program. Later, the concept of `LOCAL` variables was introduced to restrict the scope of variables to the procedure or function in which they were declared.

`LOCAL` variables in Clipper compared to its dynamic stack-scoped `PRIVATE` variables that came before `LOCAL` which could be seen and updated within called procedures unless that procedure first declared the same named variable `PRIVATE` or `LOCAL` to _"hide"_ its parent's variable:

- **Syntax**:
   ```clipper
   PROCEDURE Main
      LOCAL procScopedVariable
      procScopedVariable := 10
      ? procScopedVariable       // Outputs: 10
   
      PRIVATE stackScopedVariable
      stackScopedVariable := 5
      ? stackScopedVariable      // Outputs: 5
      
      DO Sub
      
      ? procScopedVariable       // Outputs: 10, remains unchanged by Sub
      ? stackScopedVariable      // Outputs: 20, changed by Sub
   RETURN
   
   PROCEDURE Sub
      procScopedVariable := 20
      stackScopedVariable := 20
   RETURN

   ```
Clipper is included here not because the language is well-known but because the author of this RFC [once wrote a book on it](https://www.amazon.com/Programming-Clipper-5-Version-5-01/dp/0201570181) in a former life and its distinction from Clipper's `PRIVATE` type of variable is in part what inspired the ideas of this RFC.

#### Summary of Prior Art

The concept of file-scoped or localized visibility is a common feature in many programming languages, each with its unique syntax and implementation:

- **C/C++**: Uses the `static` keyword for file-scoped variables and functions.
- **JavaScript (ES6 Modules)**: Variables, functions, and classes are module-scoped by default.
- **Python**: Module-level scope with a convention of using a leading underscore for private items.
- **Rust**: Module-level privacy by default, with items made public using the `pub` keyword.
- **Go**: File-scoped by default for top-level declarations.
- **Kotlin**: Uses `private` for file-scoped top-level declarations.
- **Swift**: Uses `private` for file-scoped top-level declarations.
- **Ruby**: Simulates file scope through module encapsulation.
- **Java**: Uses package-private (default) visibility for restricting access within a package.
- **TypeScript**: Uses ES6 module syntax to scope elements to the file unless exported.
- **Clipper**: Initially had only dynamic variables, later introduced `LOCAL` keyword for procedure-level scope.

These implementations provide valuable insights into how PHP can introduce file-scoped visibility using the TBD keyword, drawing from established practices in other languages.


### Compile-Time Concepts and Optimization


The introduction of the TBD keyword would establish file-scoped variables and constants as compile-time concepts. This approach provides several advantages, particularly in terms of optimization capabilities:

1. **Compile-Time Concepts**:
    - **Definition**: Variables and constants declared with the TBD keyword are confined to the file in which they are declared and do not exist beyond the compilation phase.
    - **Behavior**: These elements are not included in runtime constructs such as the Reflection API or variable variables, ensuring that their scope and lifecycle are strictly limited to the file during compilation.

2. **Optimization Capabilities**:
    - **Memory Management**: Since TBD variables and constants are resolved at compile time, they do not occupy memory beyond their file scope. This reduces memory overhead and enhances performance.
    - **Code Optimization**: The compiler can perform more aggressive optimizations by knowing that TBD elements do not escape their file scope. This can lead to improved inlining, dead code elimination, and other optimizations.
    - **Isolation and Encapsulation**: By restricting the scope of TBD elements to a single file, it becomes easier to reason about the code, which can lead to more effective static analysis and optimization strategies.

3. **Implementation Considerations**:
    - **Parser and Compiler Adjustments**: The PHP parser and compiler will need to recognize and handle the TBD keyword appropriately, ensuring that these elements are treated as compile-time entities.
    - **Tooling Support**: IDEs, static analyzers, and other development tools will need to incorporate support for the TBD keyword, enabling developers to leverage these optimizations seamlessly.


### Conclusion
The addition of file-scoped visibility using the TBD keyword will provide PHP developers with a powerful tool for better encapsulation, modularity, and security. By clearly defining and restricting the scope of symbols to the file level, this feature will help maintain clean and maintainable codebases.



## RFC Impact

The introduction of file-scoped visibility using the TBD keyword will have various impacts on PHP. This section outlines the expected changes and confirms that certain well-known areas of PHP will remain unaffected, as well as areas where there will be definite impacts.

### Areas with No Impact

1. **Backward Compatibility**:
    - The addition of the TBD keyword will not affect existing codebases. All current code will continue to function as expected since this is an additive feature. Existing visibility keywords (`public`, `protected`, `private`) and their behavior remain unchanged.

2. **Global Scope and Superglobals**:
    - Superglobals like `$_POST`, `$_GET`, `$_SESSION`, and others will not be impacted by the introduction of file-scoped visibility. These superglobals will continue to be accessible throughout the application as they currently are.

3. **Namespaces**:
    - The existing functionality of namespaces remains unchanged. The TBD keyword provides an additional level of visibility control within files but does not alter how namespaces organize code or how namespace-based autoloading operates.

4. **Class and Interface Inheritance**:
    - Class inheritance and interface implementation mechanisms remain unaffected. The TBD keyword applies only to the file scope, ensuring it does not interfere with the inheritance chains or interface contracts.

5. **Visibility Keywords (`public`, `protected`, `private`)**:
    - The visibility keywords `public`, `protected`, and `private` will maintain their current behavior. The TBD keyword adds a new option for file-level scope but does not change the existing visibility rules within classes.

6. **PHP Standard Library (SPL)**:
    - The PHP Standard Library, including all its components and functions, will not be impacted by the introduction of file-scoped visibility. The SPL will continue to operate as it currently does without any changes.

### Areas with Definite Impact

1. **Reserved Keywords**:
    - The introduction of the TBD keyword will require it to be added as a reserved keyword in PHP. This means that any existing code using TBD keyword as an identifier (e.g., variable names, function names) will need to be updated. A thorough analysis will be required to determine the extent of this impact on existing codebases.

2. **New Keyword Addition**:
    - The addition of the TBD keyword introduces a new way to declare symbols with file-level scope. This will require updates to the PHP parser, lexer, and documentation to accommodate the new keyword and its usage.

3. **Enhanced Modularity**:
    - Developers will have the ability to create more modular and encapsulated code by restricting the scope of certain elements to a single file. This promotes better organization and security within PHP projects.

4. **Reduced Global Namespace Pollution**:
    - By using the TBD keyword, developers can prevent unnecessary global scope pollution, reducing the risk of naming conflicts and improving the overall structure of their codebases.

5. **Tooling and IDE Support**:
    - IDEs, static analyzers, and other development tools will need to update their syntax highlighting, autocompletion, and code analysis features to support the new TBD keyword and its semantics.

6. **Learning Curve**:
    - While the TBD keyword adds an additional concept for developers to learn, its benefits in terms of code organization and encapsulation justify the learning effort. Clear documentation and examples will help mitigate any initial learning curve.

### Additional Areas of Impact

1. **Reflection API**:
    - **Impact**: File-scoped visibility should ideally be a compile-time concept and not participate in reflection. This means that elements declared with TBD would not be visible through reflection.
    - **Implementation**: Ensure the Reflection API respects file-scoped visibility, omitting TBD elements from reflection results.

2. **Variable Variables**:
    - **Impact**: File-scoped variables should not be accessible via variable variables.
    - **Implementation**: Adjust the handling of variable variables to exclude TBD variables from being accessed dynamically.

3. **Abstract Syntax Tree (AST)**:
    - **Impact**: The introduction of TBD will require updates to the AST to recognize and handle file-scoped elements appropriately.
    - **Implementation**: Modify the AST generation to include nodes for TBD elements and ensure they are handled correctly during compilation.

4. **Class Name Resolution (`::class`)**:
    - **Impact**: The `::class` constant should not be affected by file-scoped visibility as it pertains to fully qualified class names.
    - **Implementation**: No changes needed for the `::class` constant functionality.

5. **Magic Constants**:
    - **Impact**: Magic constants such as `__FILE__`, `__DIR__`, `__FUNCTION__`, etc., should remain unaffected by the introduction of file-scoped visibility.
    - **Implementation**: Ensure magic constants continue to function as they currently do without interference from TBD.

By explicitly addressing the areas with no impact and outlining the areas with definite impacts, this RFC aims to provide a comprehensive understanding of how the introduction of file-scoped visibility will affect PHP development. This ensures transparency and prepares developers and tool maintainers for the adoption of the new feature.

Note: Anything that is discovered as problematic during implementation that if disallowed would keep the rest of the RFC non-problematic and with its value still intact should be explicitly disallowed during implementation and allowed to be considered on a future RFC. 


## Open Questions
1. What is the TBD keyword going to be?

2. Can TBD-declared variables be implemented in a more performant manner and require less memory than regular PHP variables by following any _(additional)_ constraints, even is the optimizing implementation is postponed to a future RFC? 


## Remember, this is still a ROUGH DRAFT
