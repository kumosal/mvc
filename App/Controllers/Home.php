<?php
namespace App\Controllers;

class Home extends \Core\Controller {
    public function indexAction() {
        echo "WElcome from the home action from the Home controller.";
    }

    protected function before() {
        echo "Before code ...<br>";
    }
    protected function after() {
        echo "<br>After code ...";
    }
}