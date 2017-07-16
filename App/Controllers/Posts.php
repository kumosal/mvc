<?php

namespace App\Controllers;

class Posts extends \Core\Controller {
    public function index() {
        echo "Hello from the index action action in Posts controller";
    }
    public function addNew() {
        echo "Hello from the addNew action in Posts controller";

    }
    public function edit() {
        echo "Hello from the edit action in Posts controller";
        echo '<p><pre>Route Parameters:'
        . htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }

}