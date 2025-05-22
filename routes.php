<?php
    require "includes/router.php";

    $router = new router();

    $router->add('/', 'view/app.php');
    $router->add('/about', 'view/about.php');
    $router->serve();

?>