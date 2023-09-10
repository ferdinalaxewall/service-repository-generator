# Laravel Service Repository Generator
Laravel Service Repository Generator is a Package for Generating Service and Repository Class based on Model

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

## Default Service Repository Directory Structure based on Model Name
```php
├── app
|   ├── Services          
|   |    ├── Model          
|   |    |   ├── ModelService.php
|   |    |   ├── ModelServiceImp.php
|   ├── Repositories          
|   |    ├── Model          
|   |    |   ├── ModelRepository.php
|   |    |   ├── ModelRepositoryImp.php 
|   |    └── BaseRepository.php
```

## Usage Guide

### Generate Service Repository Class with Interface
```bash
php artisan make:service-repository {model}
```

### Generate Service Only Class with Interface
- Coming Soon

### Generate Repository Only Class with Interface
- Coming Soon

## Contributors
- [Ferdinalaxewall](https://github.com/ferdinalaxewall)
- [See All Contributors](https://github.com/ferdinalaxewall/service-repository-generator/contributors)

## License
This project is released under the [MIT](http://opensource.org/licenses/MIT) license.