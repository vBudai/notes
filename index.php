<?php

use routing\Request;
use routing\Router;

try{
    require "vendor/autoload.php";
}
catch (Exception $e){
    echo "Composer autoload.php file error: {$e->getMessage()}";
}

require_once "config/routes.php";

$router = new Router(new Request());
try {
    echo $router->getContent();
} catch (ReflectionException $e) {
    echo "Routing error: {$e->getMessage()}";
}
