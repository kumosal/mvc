<?php

// echo 'Requested URL: "'.$_SERVER['QUERY_STRING'].'"';

//Controllers
// require('../App/Controllers/Posts.php');
// Routing
// require('../Core/Router.php');

// Autoloader
spl_autoload_register(function($class) {
    $root = dirname(__DIR__); // get the parent directory
    $file = $root . '/' . str_replace('\\','/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\','/', $class) . '.php';
    }
});

$router = new Core\Router();

// Add routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
// $router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

// // display the routing table
// echo "<pre>";
// //var_dump($router->getRoutes());
// echo htmlspecialchars(print_r($router->getRoutes(), true));
// echo "</pre>";

// // Mtach the requested route
// $url = $_SERVER['QUERY_STRING'];

// if ($router->match($url)) {
//     echo '<pre>';
//         var_dump($router->getParams());
//     echo '</pre>';
// } else {
//     echo 'No matching route found for url: '.$url;
// }
$router->dispatch($_SERVER['QUERY_STRING']);