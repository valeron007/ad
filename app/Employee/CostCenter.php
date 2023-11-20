<?php

namespace app\Employee;

class CostCenter
{
    public $number;
    public $department;
    public function __construct($name){
        $this->number = $name;
    }

}
