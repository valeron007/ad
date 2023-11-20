<?php

namespace app\Employee;

class Unit
{
    public $name;
    public $login;

    function __construct($name) {
        $this->name = $name;
    }

    public function __toString() {
        return $this->name;
    }

}