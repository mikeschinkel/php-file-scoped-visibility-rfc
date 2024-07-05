# Valid and Invalid Uses 

The `fileonly` keyword introduces file-scoped visibility, which determines the scope of various elements within a PHP file. This section outlines where the `fileonly` keyword will be valid and where it will not be applicable, based on the type of symbol being qualified.

## Valid Uses

1. **Functions**
    - **Valid**: The `fileonly` keyword can be used to declare functions that are only accessible within the file where they are defined.
    - **Valid example**:
      ```php
      fileonly function exampleFunction():mixed {
          // Function is file-scoped
      }
      ```

2. **Variables**
    - **Valid**: The `fileonly` keyword can be used to declare variables that are only accessible within the file where they are defined.
    - **Valid example**:
      ```php
      fileonly string $exampleVariable = 'This variable is file-scoped';
      ```

3. **Constants**
    - **Valid**: The `fileonly` keyword can be used to declare constants that are only accessible within the file where they are defined.
    - **Valid example**:
      ```php
      fileonly const EXAMPLE_CONSTANT = 'This constant is file-scoped';
      ```

4. **Classes**
    - **Valid**: The `fileonly` keyword can be used to declare classes that are only accessible within the file where they are defined.
    - **Valid example**:
      ```php
      fileonly class FileOnlyClass {
          // Class is file-scoped
      }
      ```

5. **Interfaces**
    - **Valid**: The `fileonly` keyword can be used to declare interfaces that are only accessible within the file where they are defined.
    - **Valid example**:
      ```php
      fileonly interface FileOnlyInterface {
          // Interface is file-scoped
      }
      ```
3. **Within Namespaces**
    - **Valid**: The `fileonly` keyword can be used within a namespace to limit visibility to only the specific file. This however **_will not_** make fileonly symbols accessible via other files within the same namespace.
    - **Valid example**:
      ```php
      namespace MyNamespace {
        fileonly function namespacedFunction():mixed {
          // Function is file-scoped
        }
        fileonly string $namespacedVariable = 'This variable is file-scoped';
        fileonly const NAMESPACED_CONSTANT = 'This constant is file-scoped';
        fileonly class NamespacedClass {
          // Class is file-scoped
        }
        fileonly interface NamespacedInterface {
           // Interface is file-scoped
        }
      }
       ```

## Invalid uses

1. **Class Properties and Methods**
    - **Not Valid**: The `fileonly` keyword cannot be used to declare properties or methods within a class. Class properties and methods are governed by the existing visibility keywords (`public`, `protected`, `private`).
    - **Invalid example**:
      ```php
      class MyClass {
          fileonly mixed $property; // Invalid
          fileonly function method():void {} // Invalid
      }
      ```

2. **Global Scope**
    - **Not Valid**: The `fileonly` keyword is not applicable for elements that need to be accessible globally. Elements marked with `fileonly` are restricted to the file in which they are declared.
    - **Invalid example**:
      ```php
      fileonly global $globalVariable = 'This should be global'; // Invalid
      ```

3. **Namespaces**
    - **Not Valid**: The `fileonly` keyword cannot be used to limit visibility of a namespaces across files. Namespaces are intended to organize code across files, and `fileonly` operates within the file.
    - **Invalid example**:
      ```php
      fileonly namespace MyNamespace { // Invalid
      }
      ```

The `fileonly` keyword provides a way to declare file-scoped symbols and within namespaces for same. `fileonly` is not applicable for class properties, class methods, global scope elements, or on namespaces. This targeted applicability ensures clear and consistent use of file-scoped visibility, enhancing code modularity and encapsulation.
