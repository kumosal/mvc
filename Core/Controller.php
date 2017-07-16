<?php

namespace Core;

abstract class Controller {
    protected $route_params = [];
    // when an object of the class is created we pass route params
    public function __construct($route_params) {
        $this->route_params = $route_params;
    }

}