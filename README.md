<center>
<h1>Laravel Service Repository Generator</h1>
<p>Laravel Service Repository Generator is a Package for Generating Service and Repository Class based on Model or custom name</p>

[![Latest Stable Version](http://poser.pugx.org/ferdinalaxewall/service-repository-generator/v)](https://packagist.org/packages/ferdinalaxewall/service-repository-generator) [![Total Downloads](http://poser.pugx.org/ferdinalaxewall/service-repository-generator/downloads)](https://packagist.org/packages/ferdinalaxewall/service-repository-generator) [![Daily Downloads](http://poser.pugx.org/ferdinalaxewall/service-repository-generator/d/daily)](https://packagist.org/packages/ferdinalaxewall/service-repository-generator) [![License](http://poser.pugx.org/ferdinalaxewall/service-repository-generator/license)](https://packagist.org/packages/ferdinalaxewall/service-repository-generator)

</center>

## Installation Guide
```bash
composer require ferdinalaxewall/service-repository-generator
```

Go to config/app.php, then put these code on service providers
```php
'providers' => [
    /*
    * Package Service Providers...
    */
    \Ferdinalaxewall\ServiceRepositoryGenerator\ServiceRepositoryGeneratorProvider::class,
],
```

Last, for make sure this package installed correctly.
```bash
composer dump-autoload && php artisan optimize:clear
```

## Default Service Repository Directory Structure Based
```php
├── app
|   ├── Services          
|   |    ├── Entity          
|   |    |   ├── EntityService.php
|   |    |   ├── EntityServiceImp.php
|   ├── Repositories          
|   |    ├── Entity          
|   |    |   ├── EntityRepository.php
|   |    |   ├── EntityRepositoryImp.php 
|   |    └── BaseRepository.php
```

## Usage Guide

### Generate Service Repository Class with Interface
Generate Service and Repository Class with construct the Model and Create Base Repository Class
```bash
php artisan make:service-repository {model}
```

### Generate Service Only Class with Interface
Generate Service Class
```bash
php artisan make:service {service-name}
```

### Generate Repository Only Class with Interface
- Generate Repository Class with construct the Model and Create Base Repository Class
```bash
php artisan make:repository {repository-name} {--model=}
```

_OR_

- Generate Repository Class without construct the Model
```bash
php artisan make:repository {repository-name}
```

## Features
- **Generate Service and Repository Class** with Implement Interface
- **Generate Only Service Class** with Implement Interface
- **Generate Only Repository Class** with Implement Interface
- **Automaticaly Generate Base Repository Class**
- **Support Nesting Service, Repository** Classpath (e.g. Master/User, Master/User/Employee, etc)
- **Automaticaly Generate Model** (If the model didn't exists) when Create Repository Class
- **Automaticaly Class and Interface Binding** (Only File inside Services or Repositories Directory)

## Contributors
- [Ferdinalaxewall](https://github.com/ferdinalaxewall)
- [See All Contributors](https://github.com/ferdinalaxewall/service-repository-generator/contributors)

## License
This project is released under the [MIT](http://opensource.org/licenses/MIT) license.