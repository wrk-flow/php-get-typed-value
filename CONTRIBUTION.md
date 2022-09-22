# LaraStrict contribution

Feel free to contribute. Guide lines contributions:

## Bug fixes

For bug fixes create and issue and pull request if possible.

## Ideas

Use the discussion functionality and propose your idea:

- What you want to solve?
- Sample proof of concept code? (just how it could look)

## Wait to take in account

- Always design your classes with dependency injection in mind (possibly constructor).
- Always think about tests -> how they should be written and if it is easy.

## Lint and tests

```bash
composer run check
```

We are using set of tools to ensure that the code is consistent. Run this before pushing your code changes.

### [PHPStan](https://phpstan.org)

```bash
composer run check
```

### [Rector](https://github.com/rectorphp/rector)

```bash
composer run check
```

### [Easy coding standard](https://github.com/symplify/easy-coding-standard)

```bash
composer run check
```
## Tests

- Tests are executed with Laravel and without Laravel (separate GitHub action, tests/Laravel folder is removed).
