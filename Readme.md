
[![Latest Version](https://img.shields.io/github/release/Happyr/SerializerBundle.svg?style=flat-square)](https://github.com/Happyr/SerializerBundle/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/Happyr/SerializerBundle.svg?style=flat-square)](https://travis-ci.org/Happyr/SerializerBundle)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/Happyr/SerializerBundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/Happyr/SerializerBundle)
[![Quality Score](https://img.shields.io/scrutinizer/g/Happyr/SerializerBundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/Happyr/SerializerBundle)
[![Total Downloads](https://img.shields.io/packagist/dt/happyr/serializer-bundle.svg?style=flat-square)](https://packagist.org/packages/happyr/serializer-bundle)

**Make the Symfony's serializer easy to use.**


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

## Usage

```php

use \Happyr\SerializerBundle\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class Car
{
    /**
     * @Serializer\Expose
     */
    private $size = 'Small';
    
    /**
     * @Serializer\Expose
     * @Serializer\Accessor({"getter":"getModel"})
     */
    private $model = 'Volvo';

    private $color = 'Red';
    
    public function getModel()
    {
        return 'This is model: '.$this->model;
    }
}

class Owner
{
    private $name;

    /**
     * @Serializer\Type("Car")
     */
    private $car;

    /**
     * @Serializer\ReadOnly
     */
    private $birthday;

    public function __construct()
    {
        $this->name = 'Tobias';
        $this->car = new Car(true);
        $this->birthday = new \DateTime('1989-04-30');
    }
}

$json = $this->container->get('serializer')->serialize(new Owner(), 'json');
var_dump($json);
```

```json
{
  "name":"Tobias",
  "car":{
    "size":"Small",
    "model":"This is model: Volvo"
  },
  "birthday":"1989-04-30T00:00:00+02:00"
}
```

## Under the hood

This bundle provides a custom normalizer to [Symfony's serializer component](http://symfony.com/doc/current/components/serializer.html). This makes
this serializer very flexible. If you want to serialize an object in a very custom way, 
add your own serializer as discibed in the [Symfony documentation](http://symfony.com/doc/current/cookbook/serializer.html). 

## Configuration

You need to provide one or more paths to where your source code is. 

```yaml
// app/config/config.yml
happyr_serializer:
  source: ['%kernel.root_dir%/../src'] # default
  twig_extension: false # default
```

## Adding metadata

Currently you may only configure the normalizer with Annotations. These annotations
are very similar to JmsSerializer. 

#### @ExclusionPolicy

This annotation can be defined on a class to indicate the exclusion strategy
that should be used for the class.


| Policy   | Description |
| -------- | ----------- |
| all      | all properties are excluded by default; only properties marked with @Expose will be serialized/unserialized 
| none     | no properties are excluded by default; all properties except those marked with @Exclude will be serialized/unserialized


#### @Exclude

This annotation can be defined on a property to indicate that the property should
not be serialized/unserialized. Works only in combination with ExclusionPolicy = "NONE".

#### @Expose
This annotation can be defined on a property to indicate that the property should
be serialized/unserialized. Works only in combination with ExclusionPolicy = "ALL".

#### @SerializedName
This annotation can be defined on a property to define the serialized name for a
property. If this is not defined, the property will be translated from camel-case
to a lower-cased underscored name, e.g. camelCase -> camel_case.


#### @Groups
This annotation can be defined on a property to specifiy to if the property
should be serialized when only serializing specific groups. If this is excluded the
property/method will get group "Default". 


#### @Accessor
This annotation can be defined on a property to specify which public method should
be called to retrieve, or set the value of the given property. By default we access
properties by reflection. 

```php

<?php
use \Happyr\SerializerBundle\Annotation as Serializer;

class User
{
    private $id;

    /** 
     * @Serializer\Accessor(getter="getTrimmedName",setter="setName") 
     */
    private $name;

    // ...
    public function getTrimmedName()
    {
        return trim($this->name);
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
```

#### @ReadOnly

This annotation can be defined on a property to indicate that the data of the property
is read only and cannot be set during deserialization.

A property can be marked as non read only with `@ReadOnly(false)` annotation (useful when a class is marked as read only).
