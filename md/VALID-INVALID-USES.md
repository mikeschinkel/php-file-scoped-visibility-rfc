# Valid and Invalid Uses 

The TBD keyword introduces file-scoped visibility, which determines the scope of various elements within a PHP file. This section outlines where the TBD keyword will be valid and where it will not be applicable, based on the type of symbol being qualified.

## Valid Uses

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

## Invalid uses

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
