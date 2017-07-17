<?php
/**
 * Router
 */
namespace Core;
class Router {
    /**
     * Associative array of routes (the routing table)
     * @var array
     */
    protected $routes = [];
    /**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];
    /**
     * Add a route to the routing table
     *
     * @param [string] $route The route URL
     * @param [array] $params Parameters (controller, action, ...)
     * @return void
     */
    public function add($route, $params = []) {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//','\\/', $route);
        // Convert a variable ex: {controller}
        $route = preg_replace('/\{([a-z]+)\}/','(?<\1>[a-z-]+)', $route);
        // Convert variables with custom regular expressions e.g. {id:\d+}
        // $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?<\1>\2)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters and case insesitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }
    
    /**
     * Get all the routes from the routing table
     *
     * @return void
     */
    public function getRoutes() {
        return $this->routes;
    }
    /**
     * Match the route to the routes in the routing table, 
     * setting $params property if a route is found.
     * @param [string] $url the route URL
     * @return boolean true if a match was found, flase otherwise.
     */
    public function match($url) {
        // match the fixed ulrl format /controller/action
        // $reg_exp = "/^(?<controller>[a-z-]+)\/(?<action>[a-z-]+)$/";
        foreach ($this->routes as $route => $params) {
            if(preg_match($route, $url, $matches)) {
                // get named capture group values
                // $params = []
                foreach ($matches as $key => $match) {
                    if(is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }
    /**
     * Get the currently matched parameters
     *
     * @return array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * Dispatching function
     *
     * @param [type] $url
     * @return void
     */
    public function dispatch($url) {
        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            // $controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace() . $controller;
            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);
                
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);
                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                } else {
                    echo "Method $action (in controller: $controller) not found.";
                }
            } else {
               echo "Controller class $controller not found."; 
            }
        } else {
            echo "this route doesn't exist";
        }
    }
    
    protected function convertToStudlyCaps($string) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }
    // convert action-new to actionNew
    protected function convertToCamelCase($string) {
        return lcfirst($this->convertToStudlyCaps($string));
    }
    protected function getNamespace() {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
    
}
