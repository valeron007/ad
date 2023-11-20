<?php
require_once __DIR__.'/vendor/autoload.php';
/*
 *  $ldapuri = "LDAP://abxads002.int.atosbox.ru:389";
    $login = "INT\A828835";
    $pwd = "Gtlhbkj0792!";
 *  OU=Users,OU=ABX,OU=OU_Root,DC=int,DC=atosbox,DC=ru
 * */


$configuration = [
    // Mandatory Configuration Options
    'hosts'            => ['abxads002.int.atosbox.ru'],
    'base_dn'          => 'OU=Users,OU=ABX,OU=OU_Root,DC=int,DC=atosbox,DC=ru',
    'username'         => 'INT\A828835',
    'password'         => 'Ufvflhbk0792!',

    // Optional Configuration Options
    'schema'           => Adldap\Schemas\ActiveDirectory::class,
    'account_prefix'   => 'INT-',
    'account_suffix'   => '@acme.org',
    'port'             => 389,
    'follow_referrals' => false,
    'use_ssl'          => false,
    'use_tls'          => false,
    'version'          => 3,
    'timeout'          => 5,
];

$connections = [
    'connection1' => [
        'hosts' => ['abxads002.int.atosbox.ru'],
    ],
];


$ldap = new \app\AD\ADConnect();

$employee_data = $ldap->getByDate();


$exportToJson = new \app\Export\ExportJson(__DIR__, 'units', $ldap->getUnits());
//$exportToJson::export('units', $ldap->getUnits());
//$exportToJson::export('departments', $ldap->getDepartments());
//$exportToJson::export('costs', $ldap->getCosts());
//$exportToJson::export('cost_owner', $ldap->getCostOwner());
//$exportToJson::export('employee_unit', $ldap->getUnitEmployee());
//$exportToJson::export('employee_department', $ldap->getEmployeeDepartments());
$exportToJson::export('uesrs', $ldap->getAllUsers());

/*
$ad = new Adldap\Adldap();
$ad->addProvider($configuration, 'connection1');

$unitData = new \app\Employee\UnitData();
$employeeData = new \app\Employee\EmployeeData();
$employyes = array();
$managers = array();
$units = array();
$departments = array();

try {
    $provider = $ad->connect('connection1');
    $paginator = $provider->search()
        ->users()
        ->where('company', '=', 'Atos IT Solutions and Services')
        ->paginate(500)
        ->getResults();
    //$users = $provider->search()->users()->where('company', '=', 'Atos IT Solutions and Services')->get();

    foreach ($paginator as $user){
        $temp_user = new \app\Employee\Employee();
        $temp_user->title = $user->getTitle();
        $temp_user->login = $user['samaccountname'][0];
        $temp_user->c_das_id = $user['samaccountname'][0];
        $temp_user->sys_updated_at = $user->getUpdatedAtDate();
        $temp_user->sys_created_at = $user->getCreatedAtDate();
        $temp_user->active = $user->getUserAccountControl() == 514 ? false : true;

        if(!is_null($user->getTelephoneNumber())){
            $temp_user->business_phone = str_replace(" ", "", $user->getTelephoneNumber());
        }
        if(!is_null($user->getMobileNumber())){
            $temp_user->mobile_phone = str_replace(" ", "", $user->getMobileNumber());
        }

        $temp_user->company = $user->getCompany();
        $temp_user->loc = $user->getPhysicalDeliveryOfficeName();
        $temp_user->first_name = $user->getFirstName();
        $temp_user->last_name = $user->getLastName();
        $temp_user->display_name = $user->getDisplayName();
        $temp_user->note = $user->getDescription();
        $temp_user->employeeNumber = $user->getEmployeeNumber();
        $temp_user->unit = $user->getDepartment();
        $temp_user->userprincipalname = $user->getUserPrincipalName();
        $temp_user->manager = $user->getManager();
        $temp_user->language_id = mb_strtolower($user['c'][0]);
        $temp_user->email = $user->getEmail();
        $location = $user->getLocale();
        if($location == 'Voronezh'){
            $temp_user->location = 'Воронеж';
        }elseif ($location == 'Krasnodar'){
            $temp_user->location = 'Краснодар';
        }elseif ($location == 'Moscow'){
            $temp_user->location = 'Москва';
        }

        $temp_user->department = $user['extensionattribute5'][0];
        $temp_user->cost_center_code = $user['extensionattribute4'][0];
        $temp_user->cost_center_number = $user->getEmployeeId();
        array_push($employyes, $temp_user);

        if(!is_null($user->getManager())){
            array_push($managers, new \app\Employee\Manager($user['samaccountname'][0], $user->getManager()));
        }

        if(!is_null($user->getDepartment())) {
            array_push($units, new \app\Employee\Unit($user->getDepartment()));
        }
    }


    $unitData->org_unit = array_unique($units);
    $employeeData->employee = $employyes;
    $managerData = new \app\Employee\ManagerData();
    $managerData->employee = $managers;
    $pathManager = 'C:\ldap\managers.json';
    $fp = fopen($pathManager, 'w');
    fwrite($fp, json_encode($managerData));
    fclose($fp);

    $path = 'C:\ldap\users.json';
    //echo json_encode($users);
    $userFile = fopen($path, 'w');
    //print_r($fp);
    fwrite($userFile, json_encode($employeeData));
    fclose($userFile);

    // Great, we're connected!
} catch (Adldap\Auth\BindException $e) {
    // Failed to connect.
}

*/
