<?php
require_once __DIR__.'/vendor/autoload.php';

$ldap = new \app\AD\ADConnect();

$employee_data = $ldap->getByDate();

echo json_encode($employee_data);

