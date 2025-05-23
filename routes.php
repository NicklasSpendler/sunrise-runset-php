<?php
    //Here you can create multiple routes. Its getting included inside of index.php
    require "includes/router.php";

    $router = new router();

    $router->add('/', 'view/app.php');
    $router->add('/about', 'view/about.php');
    $router->serve();

?>