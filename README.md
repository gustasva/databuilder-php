Databuilder-php
========

Databuilder-php is a simple library that allows to define Spryker databuilders in PHP classes.
This greatly improves readability and type hinting.

## Installation

To install Databuilder-php, run the command below and you will get the latest version

```sh
composer require --dev gustasva/databuilder-php
```

## Documentation

1. First we need to add PHP databuilders autoloading as Spryker autoloads only PyzTest directory for testing.

``` php
"autoload-dev": {
        "psr-4": {
            "_data\\": "tests/_data/",
```

2. Next we create databuilders directory in _data directory.

```bash
├── ...
├── tests
      ├── _data
            ├── Builders
```

4. Next we create Databuilders. Naming convention here is *Something*Databuilder

``` php
namespace _data\Builders;

use Databuilder\Databuilder;

class SomethingDatabuilder extends Databuilder
```

4. Define builder:
   1. First level of array is transfer name
   2. Second level of array is the place where you define databuilder properties
      1. For faker parameters or methods use `$this->faker->method()`
      2. For literal values use `=value`
   3. In getName() method we're defining the name of xml databuilder. If we return `name` from this method the xml databuilder will be named `name.databuilder.xml`

Example displayed below:
``` php
return [
    'Something' => [
        'name' => $this->faker->word(),
        'value' => '=thisIsSomeValue',
```

5. Run databuilder generator:

```sh
vendor/bin/databuilder
```