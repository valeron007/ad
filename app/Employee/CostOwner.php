<?php

namespace app\Employee;

class CostOwner
{
    public $cost_number;
    public $login;

    public function __construct($login, $number){
        $this->login = $login;
        $this->cost_number = $number;
    }

}