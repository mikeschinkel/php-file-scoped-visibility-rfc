# Keyword Choices

Options considered, in reverse order of author preference:

1. `var` — An existing reserverd word — deprecated for other uses — but only makes sense for variables. This would be perfect for variables with file-only visibility, but as it does not apply to any other symbol type `var` appear to be a non-starter.
2. `private` — An existing reserved word, but has the potential for too confusion with other uses of `private`.
3. `internal` — Not an existing keyword so has an existing small impact, There are [583 uses](https://github.com/search?q=internal+language%3APHP+symbol%3A%2F%5Einternal%24%2F&type=code) of `/^internal$/` in symbols in PHP code on public GitHub. However `internal` might get confused with being related to PHP Internals somehow.
4. `hidden` — Not an existing keyword so has an existing small impact, There are [approximate 1.5K uses](https://github.com/search?q=hidden+language%3APHP+symbol%3A%2F%hidden%24%2F&type=code) of `/^hidden$/` in symbols in PHP code on public GitHub. However, while its usage could learned, this is not a strong candidate as the symbols would not be hidden within the file, only outside of it.
5. `local` — Not an existing keyword so has an existing small impact, There are [approximate 2K uses](https://github.com/search?q=local+language%3APHP+symbol%3A%2F%5Elocal%24%2F&type=code) of `/^local$/` in symbols in PHP code on public GitHub. Ignoring the impact, the author believes `local` is a strong candidate for balancing conciseness and clarity, but can we ignore the impact?
5. `fileonly` — Not an existing keyword but [only affects 1 file](https://github.com/search?q=fileonly+language%3APHP+symbol%3A%2F%5Efileonly%24%2F&type=code) when searching `/^fileonly$/` on public GitHub. `fileonly` is the most clear in its intent however its combined word form _might_ be off-putting to some developers, hence why this RFC plans to offer a choice.
