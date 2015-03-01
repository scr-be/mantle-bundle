# Scribe / Mantle Bundle

[![License](https://img.shields.io/packagist/l/scribe/mantle-bundle.svg?style=flat-square)](https://symfony-mantle-bundle.docs.scribe.tools/license)
[![RTD](https://readthedocs.org/projects/symfony-mantle-bundle/badge/?version=latest&style=flat-square)](https://symfony-mantle-bundle.docs.scribe.tools/docs)
[![Travis](https://img.shields.io/travis/scribenet/symfony-mantle-bundle.svg?style=flat-square)](https://symfony-mantle-bundle.docs.scribe.tools/ci) 
[![Scrutinizer](https://img.shields.io/scrutinizer/g/scribenet/symfony-mantle-bundle.svg?style=flat-square)](https://symfony-mantle-bundle.docs.scribe.tools/quality)
[![Coveralls](https://img.shields.io/coveralls/scribenet/symfony-mantle-bundle.svg?style=flat-square)](https://symfony-mantle-bundle.docs.scribe.tools/coverage)
[![Gemnasium](https://img.shields.io/gemnasium/scribenet/symfony-mantle-bundle.svg?style=flat-square)](https://symfony-mantle-bundle.docs.scribe.tools/deps)
[![Packagist](https://img.shields.io/packagist/v/scribe/mantle-bundle.svg?style=flat-square)](https://symfony-mantle-bundle.docs.scribe.tools/pkg/mantle-bundle)

*Scribe / Cache Bundle* is a simple and extensible caching abstraction layer with built-in support for APUu and Memcached.

## Our Standards

- *Auto-loading*: Conformance with the [PS4-4](http://www.php-fig.org/psr/psr-4/) 
  standard, allowing for seamless inclusion in any [composer](https://getcomposer.org/)
  project or any PSR-4 aware auto-loader implementation.
- *Continuous Integration*: Utilization of [Travis CI](https://symfony-mantle-bundle.docs.scribe.tools/ci)
  to provide per-commit reports on the success or failure status of our builds.
- *Tests and Coverage*: Automated testing against our comprehensive 
  [PHPUnit](https://phpunit.de/) test suite, resulting code-coverage metrics
  dispatched to [Coveralls](https://symfony-mantle-bundle.docs.scribe.tools/coverage).
- *Reports and Metrics*: Automated metrics pertaining to the defined code-styling
  guidelines, general code quality reports, and other statistics using 
  [Scrutinizer-CI](https://symfony-mantle-bundle.docs.scribe.tools/quality).
- *API and Documentation*: Comprehensive [API reference](https://symfony-mantle-bundle.docs.scribe.tools/api) 
  generated automatically using [Sami](https://github.com/fabpot/sami), as well 
  as [documentation and examples](https://symfony-mantle-bundle.docs.scribe.tools/docs)
  compiled using [Read the Docs](https://readthedocs.org/).

## Installation

To include this bundle in your project, simply add it as a dependency to your `composer.json` file within the `require` block.

```json
    "require" : {
        "scribe/mantle-bundle" : "dev-master"
    }
```

After adding Scribe's Cache Bundle as a dependency, simply run composer to update your vendor files and composer auto-loader includes.

```bash
composer.phar update
```