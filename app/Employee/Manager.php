<?php

namespace app\Employee;

use PHPUnit\Framework\Constraint\Count;

class Manager
{
    public $employee;
    public $manager;
    function __construct($employee, $manager) {
        $this->employee = $employee;
        $this->setManager($manager);
    }
    private function setManager(string $manager){
        if(!is_null($manager)){
            preg_match('/CN=(.*?)\(ABX\)/', $manager, $output_array);
            if (\count($output_array) == 0){
                preg_match('/CN=(.*?)\,/', $manager, $output_array);
            }

            $this->manager = rtrim($output_array[1], " ");
        }
    }
}
