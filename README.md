# sunrise-runset-php
PHP project that shows sunrise and sunset for a giving time.

### /view/
contains views that the [router](includes/router.php) takes care of showing.

You can create routes in [routes.php.](routes.php)
In the [routes.php.](routes.php) you can add new routes by using the `add` function with the parameters `$router->add('PATH', 'PATH_TO_VIEW')`
### /view/partials
Contains files that can be imported to pages, for example the [nav.php](view/partials/nav.php)
<hr>

### Calculating Sunrise & Sunset

I found out that PHP had, although depdrecated, function called `date_sunrise()` and `date_sunset()` after I had implemented the function using the [sunrisesunset.io](https://sunrisesunset.io/api/) API.

Instead of removing the first implementation of the function, I made it so you can choose either or on top of the [calculationSun.php](includes/calculateSun.php) by changing the variable `$calcMethod` by either choosing `API` or `PHP`.

the method for calculation has corresponding functions inside [calculationSun.php](includes/calculateSun.php)

`CalculateSunUsingAPI($latitude, $longitude, $date)` - for the API function.

`CalculateSunUsingPHP(float $latitude, float $longitude, $date)` - for the PHP function that uses the deprecated PHP functions.

<hr>

### Tailwind
The frontend is using tailwind. In the [package.json](package.json) I've added a `npm run watch-css` script, which is used during development.

<hr>

### Apache
Was used to serve the PHP project. The project also contains [.htaccess](.htaccess) which is required to make the router work, as it makes apache reroute all URL back to [index.php](index.php).

[index.php](index.php) includes [routes.php](routes.php) which instantiates an object of [router.php](includes/router.php).

Routes is taking care inside of [routes.php](routes.php) where you can add routes to the project, and point the into views inside of /view/


### comments
I am aware that I should probably exclude public folder for GIT, but this way you don't have to install the whole project to run on Apache.

Also, there is about an hour difference between the API and PHP methods. I assume that either the API or PHP doesn't take daytimesavings into account.