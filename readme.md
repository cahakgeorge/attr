Code Test App
==============

This is a solution app for the short [API] test given.

This app was made using [Vanilla PHP]. With help from the official PHP docs at [their documentation](php.net/manual/en/index.php).


Installation
------------
First, you will need to install [Composer](http://getcomposer.org/) following the instructions on their site.

Next, you clone the [contents of this repository](https://github.com/cahakgeorge/attr.git) and run `composer install` from your project's root directory.

Then, simply run the following command:

```sh
composer install
```

Run
-------------

Now you can test your app! Startup your local PHP server at `http://localhost:8002` by running:

```sh
php -S 127.0.0.1:8002 -t public
```

from the `root` directory

Test
-------------

Next, run the feature and unit tests included by running 

```
    ./vendor/bin/phpunit
```