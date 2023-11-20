<?php

namespace app\Employee;

class Department
{
    public $name;
    public $login;
    public $depart_name;
    public function __construct($name){
        $this->name = $name;
    }

}
