<?php

namespace app\Employee;

class Employee
{
    //field $whenchanged - sys_updated_at
    public $sys_updated_at;
    //field whencreated - sys_created_at
    public $sys_created_at;

    //field $description
    public $note;
    //employeetype - employeetype
    public $employeetype;
    //manager - manager
    public $manager;
    //mobile - mobile_phone
    public $mobile_phone;

    //useraccountcontrol - active
    public $active;
    //telephonenumber - business_phone
    public $business_phone;
    //field sn
    public $last_name;
    //field physicaldeliveryofficename - loc
    public $loc;
    public $name;
    //field l - location
    public $location;
    //givename - first_name
    public $first_name;
    //public $personaltitle;
    //employeenumber - employeenumber
    public $employeeNumber;
    
    //extensionAttribute6 - manager id;
    public $manager_id;
    //field displayname - display_name, cn
    public $display_name;
    // department - unit
    public $unit;
    // company - company
    public $company;

    //field cn - display name
    public $cn;
    //field c - language_id
    public $language_id;
    //samaccountname - das id
    public $c_das_id;

    //Cost Center
    //employeeid - cost center object МВЗ - cost_center_number
    public $cost_center_number;
    //extensionattribute13 - cost_center_number
    public $cost_center_number13;
    //extensionAttribute4 - cost_center_code;
    public $extensionAttribute4;
    //extensionattribute15 -  cost_center_code
    public $cost_center_code;
    //Cost center

    //department
    ////department
    //extensionAttribute5 - department;
    public $department;

    //field mail - email
    public $email;
    //Login - das id
    public  $login;
    public $title;
    //не используемые

    public $co;
    public $userprincipalname;
    public $distinguishedname;
    public $preferredlanguage;

}
