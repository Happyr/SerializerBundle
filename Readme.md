
[![Latest Version](https://img.shields.io/github/release/happyr/serializer-bundle.svg?style=flat-square)](https://github.com/happyr/serializer-bundle/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/happyr/serializer-bundle.svg?style=flat-square)](https://travis-ci.org/happyr/serializer-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/happyr/serializer-bundle.svg?style=flat-square)](https://packagist.org/packages/php-http/httplug-bundle)

**Make the Symfony serializer easy to use.**


## Install

Via Composer

``` bash
$ composer require happyr/serializer-bundle
```

Enable the bundle in your kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Happyr\SerializerBundle\HappyrSerializerBundle(),
    );
}
```
First we read all annotations, Add the data to our normalizers


