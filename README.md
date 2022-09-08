# Lucid Support

[![PHP from Packagist](https://img.shields.io/packagist/php-v/decodelabs/lucid-support?style=flat)](https://packagist.org/packages/decodelabs/lucid-support)
[![Latest Version](https://img.shields.io/packagist/v/decodelabs/lucid-support.svg?style=flat)](https://packagist.org/packages/decodelabs/lucid-support)
[![Total Downloads](https://img.shields.io/packagist/dt/decodelabs/lucid-support.svg?style=flat)](https://packagist.org/packages/decodelabs/lucid-support)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/decodelabs/lucid-support/Integrate)](https://github.com/decodelabs/lucid-support/actions/workflows/integrate.yml)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-44CC11.svg?longCache=true&style=flat)](https://github.com/phpstan/phpstan)
[![License](https://img.shields.io/packagist/l/decodelabs/lucid-support?style=flat)](https://packagist.org/packages/decodelabs/lucid-support)

Support Lucid sanitisation in your libraries without the dependencies


## Installation

Install the library via composer:

```bash
composer require decodelabs/lucid-support
```

## Usage
[Lucid](https://github.com/decodelabs/lucid) provides interfaces and traits to implement providing input sanitisation from your own value container objects.

The main library however has a substantial dependency list which may not be desirable when deploying the Lucid Provider interfaces in your own libraries.

Instead, those interfaces have been sectioned off in this package with a <code>class_exists()</code> check to ensure that Lucid is available at runtime.

If you want to provide Lucid's sanitisation interface in a library, you only need to require _this_ package, and implement either <code>[DirectContextProvider](./blob/develop/src/Sanitizer/DirectContextProvider.php)</code> (for passing the value directly to the methods), <code>[MultiContextProvider](./blob/develop/src/Sanitizer/MultiContextProvider.php)</code> (for dictionaries and maps) or <code>[SingleContextProvider](./blob/develop/src/Sanitizer/SingleContextProvider.php)</code> (for single-value objects).

For example:

```php
namespace My\Library;

use DecodeLabs\Lucid\Sanitizer\SingleContextProvider;
use DecodeLabs\Lucid\Sanitizer\SingleContextProviderTrait;

class MyClass implements SingleContextProvider {

    use SingleContextProviderTrait;

    protected mixed $value;

    public function __construct(mixed $value) {
        $this->value = $value;
    }

    /**
     * This method provides the value to all other
     * sanitisation methods in the interface
     */
    public function getValue(): mixed {
        return $this->value;
    }
}
```

## Licensing
Lucid Support is licensed under the MIT License. See [LICENSE](./LICENSE) for the full license text.
