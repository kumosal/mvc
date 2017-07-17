<?php

namespace App\Controllers;

class Posts extends \Core\Controller {
    public function indexAction() {
        echo "Hello from the index action action in Posts controller";
    }
    public function addNewAction() {
        echo "Hello from the addNew action in Posts controller";

    }
    public function editAction() {
        echo "Hello from the edit action in Posts controller";
        echo '<p><pre>Route Parameters:'
        . htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }

    protected function before() {
        echo "before ..";
    }
    protected function after() {
        echo "After code ..";
    }

}