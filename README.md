CommonMark Bundle
=================

[![Packagist](https://img.shields.io/packagist/v/webuni/commonmark-bundle.svg?style=flat-square)](https://packagist.org/packages/webuni/commonmark-bundle)
[![Build Status](https://img.shields.io/travis/webuni/commonmark-bundle.svg?style=flat-square)](https://travis-ci.org/webuni/commonmark-bundle)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/webuni/commonmark-bundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/webuni/commonmark-bundle)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/29bd3e8e-1b60-4ad5-aa6a-e04efb41e9e2.svg?style=flat-square)](https://insight.sensiolabs.com/projects/29bd3e8e-1b60-4ad5-aa6a-e04efb41e9e2)

Symfony bundle that integrates the league/commonmark markdown parser.

Installation
------------

This project can be installed via Composer:

    composer require webuni/commonmark-bundle

Add WebuniCommonMarkBundle to your application kernel

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Webuni\Bundle\CommonMarkBundle\WebuniCommonMarkBundle(),
        // ...
    );
}
```
