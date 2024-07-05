# Prior Art

If the RFC is adopted then the concept of file-scoped or localized visibility will not unique to PHP and has been implemented in various forms across most well-known programming languages.

This section explores how different languages have approached similar concepts, including the syntax they use and their specific implementations.

**NOTE: This section was written with the help of ChatGPT as the author is not an expert in all these languages. If there are any errors you recognize please submit a pull request with a correction** _or at least create an issue and describe what is incorrect and how to fix it._

## 1. **C/C++**

In C and C++, file-scoped variables and functions are achieved using the `static` keyword. When applied to a global variable or function, `static` restricts its visibility to the file in which it is declared.

- **Syntax**:
  ```c
  // file1.c
  static int fileScopedVariable = 0;

  static void fileScopedFunction() {
      // Function is file-scoped
  }


## 2. **JavaScript (ES6 Modules)**
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
## 3. **Python**
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

## 4. **Rust**
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

## 5. **Go**
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


## 6. **Ruby**

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

## 7. **Kotlin**
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

## 8. **Swift**
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

## 8. **Java**

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

## 9. TypeScript
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

## 10. Clipper
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

## Summary of Prior Art

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

These implementations provide valuable insights into how PHP can introduce file-scoped visibility using the `fileonly` keyword, drawing from established practices in other languages.

