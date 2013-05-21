Mongator Laravel4 Provider [![Build Status](https://travis-ci.org/mongator/laravel.png?branch=master)](https://travis-ci.org/mongator/laravel)
==============================

Provider for using Mongator with Laravel 4 framework


Requirements
------------

* PHP 5.3.x
* Laravel 4
* mongator/mongator

Installation
------------

Add `mongator/laravel` to your composer requirements, you can see [the package information on Packagist.](https://packagist.org/packages/mongator/laravel):

```JSON
{
    "require": {
        "mongator/laravel": "dev-master"
    }
}
```

Now, run `composer update`

Once the package is installed, open your `app/config/app.php` configuration file and locate the `providers` key.  Add the following line to the end:

```PHP
    ...
    'Mongator\Laravel\MongatorServiceProvider',
    ...
```

Next, locate the `aliases` key and add the following lines:

```PHP
    ...
    'Mondator'        => 'Mongator\Laravel\Facades\Mondator',
    'Mongator'        => 'Mongator\Laravel\Facades\Mongator',
    ...
```

Now just create a YAML config classes dir at your ```app``` folder: 

```bash
mkdir app/schema/
```

Parameters
------------

* ```connection_dsn``` (default 'mongodb://localhost:27017'): database connection string
* ```connection_database```: the database name
* ```connection_name``` (default 'default'): the name of the connection 
* ```models_output``` (default 'app/models/'): output path of the classes
* ```models_input``` (default 'app/schema/'): A valid dir with YAML definitions of the config classes
* ```metadata_class```: The metadata factory class name 
* ```logger``` (default false): enable the query logger
* ```extensions``` (default Array()): array of extension instances 

Usage
------------

```PHP
Route::get('/view', function() { 
    $articleRepository = Mongator::getRepository('Article');
    $article = $articleRepository->findOneById($id);

    return View::make($article);
});
```

```PHP
Route::get('/create', function() { 
    $article = Mongator::create('Article');
    $article->setAuthor('John Doe');
    $article->setTitle('Lorem ipsum dolor sit amet, consectetur adipisicing elit.')
    $article->save();
});
```

> Remember, before using the models you must generate them. (You can use the command provided with this package.)

Commands
------------
With this package you can find three useful commands, thought ```php artisan```:

* ```mongator:generate```: Processes config classes and generates the files of the classes.
* ```mongator:_indexes```: Ensures the indexes of all repositories
* ```mongator:fix```: Fixes all the missing references.


Tests
-----

Tests are in the `tests` folder.
To run them, you need PHPUnit.
Example:

    $ phpunit --configuration phpunit.xml.dist


License
-------

MIT, see [LICENSE](LICENSE)
