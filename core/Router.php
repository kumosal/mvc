<?php
/**
 * Router
 */
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
        $route = preg_replace('\{([a-z-]+)\}/','(?<\1>[a-z-]+)', $route);
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
        // foreach ($this->routes as $route => $params) {
        //     if ($url == $route) {
        //         $this->params = $params;
        //         return true;
        //     }
        // }
        // return false;
        $reg_exp = "/^(?<controller>[a-z-]+)\/(?<action>[a-z-]+)$/";
        if (preg_match( $reg_exp, $url , $match)) {
            $params = [];
            foreach ($match as $key => $value) {
                if(is_string($key)) {
                    $params[$key] = $value;
                }
            }
            $this->params = $params;
            return true;
        }
    }
    /**
     * Get the currently matched parameters
     *
     * @return array
     */
    public function getParams() {
        return $this->params;
    }
    
}
