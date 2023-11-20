<?php
require_once __DIR__.'/vendor/autoload.php';

$ldap = new \app\AD\ADConnect();

$employee_data = $ldap->getForMonth();

$employee = json_encode($employee_data, JSON_PRETTY_PRINT);

$path = 'C:\Users\administrator\Desktop\scripts\users.json';
//echo json_encode($users);
$fp = fopen($path, 'w');
//print_r($fp);
fwrite($fp, $employee);
fclose($fp);
