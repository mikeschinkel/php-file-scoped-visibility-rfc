# RFC Impact

The introduction of file-scoped visibility using the `fileonly` keyword will have various impacts on PHP. This section outlines the expected changes and confirms that certain well-known areas of PHP will remain unaffected, as well as areas where there will be definite impacts.

## Areas with No Impact

1. **Backward Compatibility**:
    - The addition of the `fileonly` keyword will not affect existing codebases. All current code will continue to function as expected since this is an additive feature. Existing visibility keywords (`public`, `protected`, `private`) and their behavior remain unchanged.

2. **Global Scope and Superglobals**:
    - Superglobals like `$_POST`, `$_GET`, `$_SESSION`, and others will not be impacted by the introduction of file-scoped visibility. These superglobals will continue to be accessible throughout the application as they currently are.

3. **Namespaces**:
    - The existing functionality of namespaces remains unchanged. The `fileonly` keyword provides an additional level of visibility control within files but does not alter how namespaces organize code or how namespace-based autoloading operates.

4. **Class and Interface Inheritance**:
    - Class inheritance and interface implementation mechanisms remain unaffected. The `fileonly` keyword applies only to the file scope, ensuring it does not interfere with the inheritance chains or interface contracts.

5. **Visibility Keywords (`public`, `protected`, `private`)**:
    - The visibility keywords `public`, `protected`, and `private` will maintain their current behavior. The `fileonly` keyword adds a new option for file-level scope but does not change the existing visibility rules within classes.

6. **PHP Standard Library (SPL)**:
    - The PHP Standard Library, including all its components and functions, will not be impacted by the introduction of file-scoped visibility. The SPL will continue to operate as it currently does without any changes.

## Areas with Definite Impact

1. **Reserved Keywords**:
    - The introduction of the `fileonly` keyword will require it to be added as a reserved keyword in PHP. This means that any existing code using `fileonly` keyword as an identifier (e.g., variable names, function names) will need to be updated. A thorough analysis will be required to determine the extent of this impact on existing codebases.

2. **New Keyword Addition**:
    - The addition of the `fileonly` keyword introduces a new way to declare symbols with file-level scope. This will require updates to the PHP parser, lexer, and documentation to accommodate the new keyword and its usage.

3. **Enhanced Modularity**:
    - Developers will have the ability to create more modular and encapsulated code by restricting the scope of certain elements to a single file. This promotes better organization and security within PHP projects.

4. **Reduced Global Namespace Pollution**:
    - By using the `fileonly` keyword, developers can prevent unnecessary global scope pollution, reducing the risk of naming conflicts and improving the overall structure of their codebases.

5. **Tooling and IDE Support**:
    - IDEs, static analyzers, and other development tools will need to update their syntax highlighting, autocompletion, and code analysis features to support the new `fileonly` keyword and its semantics.

6. **Learning Curve**:
    - While the `fileonly` keyword adds an additional concept for developers to learn, its benefits in terms of code organization and encapsulation justify the learning effort. Clear documentation and examples will help mitigate any initial learning curve.

## Additional Areas of Impact

1. **Reflection API**:
    - **Impact**: File-scoped visibility should ideally be a compile-time concept and not participate in reflection. This means that elements declared with `fileonly` would not be visible through reflection.
    - **Implementation**: Ensure the Reflection API respects file-scoped visibility, omitting `fileonly` elements from reflection results.

2. **Variable Variables**:
    - **Impact**: File-scoped variables should not be accessible via variable variables.
    - **Implementation**: Adjust the handling of variable variables to exclude `fileonly` variables from being accessed dynamically.

3. **Abstract Syntax Tree (AST)**:
    - **Impact**: The introduction of `fileonly` will require updates to the AST to recognize and handle file-scoped elements appropriately.
    - **Implementation**: Modify the AST generation to include nodes for `fileonly` elements and ensure they are handled correctly during compilation.

4. **Class Name Resolution (`::class`)**:
    - **Impact**: The `::class` constant should not be affected by file-scoped visibility as it pertains to fully qualified class names.
    - **Implementation**: No changes needed for the `::class` constant functionality.

5. **Magic Constants**:
    - **Impact**: Magic constants such as `__FILE__`, `__DIR__`, `__FUNCTION__`, etc., should remain unaffected by the introduction of file-scoped visibility.
    - **Implementation**: Ensure magic constants continue to function as they currently do without interference from `fileonly`.

By explicitly addressing the areas with no impact and outlining the areas with definite impacts, this RFC aims to provide a comprehensive understanding of how the introduction of file-scoped visibility will affect PHP development. This ensures transparency and prepares developers and tool maintainers for the adoption of the new feature.

Note: Anything that is discovered as problematic during implementation that if disallowed would keep the rest of the RFC non-problematic and with its value still intact should be explicitly disallowed during implementation and allowed to be considered on a future RFC. 

