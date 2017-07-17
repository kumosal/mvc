<?php

namespace Core;

abstract class Controller {
    protected $route_params = [];
    // when an object of the class is created we pass route params
    public function __construct($route_params) {
        $this->route_params = $route_params;
    }
    // when a protected/non-existing method is called the magic __call is called
    public function __call($name, $args) {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            //Checks if user has the permission to see the content
            if ($this->before() !== false ) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
             echo "Method $method not found in controller " . get_class($this);
        }
    }

    protected function before() {}
    protected function after() {}

}