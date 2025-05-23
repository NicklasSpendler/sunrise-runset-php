<?php
    class router {
        //Initially empty of routes, but gets populated inside of /routes.php
        public $routes = [
            
        ];

        function add(string $path, $file){
            $this->routes[$path] = $file;
        }

        function serve(){
            $url = parse_url($_SERVER['REQUEST_URI']);

            $path = $url["path"];

            if(array_key_exists($path, $this->routes)){
                require $this->routes[$path];
            }else{
                require ("view/notfound.php");
            }
        }
    }
?>