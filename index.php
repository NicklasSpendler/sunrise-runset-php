<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="public/style.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <main>
        <?php
            require('view/partials/nav.php');

            //Handles pages
            require "routes.php";
        ?>
    </main>
</body>
</html>