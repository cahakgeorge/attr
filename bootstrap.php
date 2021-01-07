<?php
require 'vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = new DotEnv(__DIR__);
$dotenv->load();

// test code, should output:
// attr
// when you run $ php bootstrap.php
// echo getenv('APP_NAME');