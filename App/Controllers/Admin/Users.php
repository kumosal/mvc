<?php
namespace App\Controllers\Admin;

class Users extends \Core\Controller {
    protected function before() {
        echo "Welcome to the admin page.<br>";
    }
    public function indexAction() {
        echo "User admin index";
    }
    protected function after() {

    }
}