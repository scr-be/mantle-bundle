########
Overview
########

The *Scribe / Mantle Bundle* is an MIT licensed Symfony bundle used as an internal
dependency used by `Scribe Inc <https://scribenet.com/>`_ for our public and
internal web applications as well as our client web projects.

In addition to providing the bleeding-edge of Symfony, complete with its relevant
components such as Assetic, Twig, the Framework Bundle, etc, this package also
includes a additional third-party packages that have been important to facilitating
Scribe's fast-paced development schedules.

Aside from some custom components created for our internal needs (and hopefully
useful to others) this package includes a *lib* directory that includes an array
of base exceptions, abstract components, additional response types, and a large
assortment of static utility methods.

Latest Code Statistics
======================

:License:         |license|
:Build:           |travis|
:Coverage:        |coverage|
:Quality:         |scrutinizer|
:Dependencies:    |dependencies|
:Stable Release:  |packagist|
:Dev Release:     |packagistd|

Our Standards
=============

- **Continuous Integration**: Utilization of `Travis CI <https://symfony-mantle-bundle.docs.scribe.tools/ci>`_
  to provide per-commit reports on the success or failure status of our builds.
- **Tests and Coverage**: Automated testing against our comprehensive
  `PHPUnit <https://phpunit.de/>`_ test suite, resulting code-coverage metrics
  dispatched to `Coveralls <https://symfony-mantle-bundle.docs.scribe.tools/coverage>`_.
- **Reports and Metrics**: Automated metrics pertaining to the defined code-styling
  guidelines, general code quality reports, and other statistics using
  `Scrutinizer CI <https://symfony-mantle-bundle.docs.scribe.tools/quality>`_.
- **Documentation and Reference**: Comprehensive
  `API reference <https://symfony-mantle-bundle.docs.scribe.tools/api>`_
  generated automatically using `Sami <https://github.com/fabpot/sami>`_, as well
  as `documentation and examples <https://symfony-mantle-bundle.docs.scribe.tools/docs>`_
  compiled using the wonderful `Read the Docs <https://readthedocs.org/>`_ service.
- **Auto-loading**: Conformance with the `PS4-4 <http://www.php-fig.org/psr/psr-4/>`_
  standard, allowing for seamless inclusion in any `composer <https://getcomposer.org/>`_
  project or any PSR-4 aware auto-loader implementation.

Documentation
=============

:General:       |docs|
:API Reference: |docsapi|

General documentation is provided via custom-written Read the Docs documentation,
while automatically generated API documentation is available for those looking to
understand the code structure and possibly implement this software within their
own project.

.. |license| image:: https://img.shields.io/packagist/l/scribe/mantle-bundle.svg?style=flat-square
   :target: https://symfony-mantle-bundle.docs.scribe.tools/license
   :alt: The MIT License (MIT)
.. |travis| image:: https://img.shields.io/travis/scribenet/symfony-mantle-bundle.svg?style=flat-square
   :target: https://symfony-mantle-bundle.docs.scribe.tools/ci
   :alt: Travis Build Status
.. |scrutinizer| image:: https://img.shields.io/scrutinizer/g/scribenet/symfony-mantle-bundle.svg?style=flat-square
   :target: https://symfony-mantle-bundle.docs.scribe.tools/quality
   :alt: Scrutinizer Code Quality Metrics
.. |coverage| image:: https://img.shields.io/coveralls/scribenet/symfony-mantle-bundle.svg?style=flat-square
   :target: https://symfony-mantle-bundle.docs.scribe.tools/coverage
   :alt: Test Coverage Metrics
.. |dependencies| image:: https://img.shields.io/gemnasium/scribenet/symfony-mantle-bundle.svg?style=flat-square
   :target: https://symfony-mantle-bundle.docs.scribe.tools/deps
   :alt: Dependency Health/Status
.. |packagist| image:: https://img.shields.io/badge/packagist-none-blue.svg?style=flat-square
   :target: https://symfony-mantle-bundle.docs.scribe.tools/pkg/mantle-bundle
   :alt: Packagist Stable Info
.. |packagistd| image:: https://img.shields.io/packagist/vpre/scribe/mantle-bundle.svg?style=flat-square
   :target: https://symfony-mantle-bundle.docs.scribe.tools/pkg/mantle-bundle
   :alt: Packagist Development Info
.. |docs| image:: https://readthedocs.org/projects/symfony-mantle-bundle/badge/?version=latest&style=flat-square
   :target: https://symfony-mantle-bundle.docs.scribe.tools/docs
   :alt: Read the Docs Build Status
.. |docsapi| image:: https://img.shields.io/badge/api-latest-ff69b4.svg?style=flat-square
   :target: https://symfony-mantle-bundle.docs.scribe.tools/api
   :alt: Sami API Reference
