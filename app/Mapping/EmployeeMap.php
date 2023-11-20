<?php

namespace app\Mapping;

class EmployeeMap
{
    public static function Map($user){
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
        if(!is_null($user->getManager())){
            $manager = new \app\Employee\Manager($user['samaccountname'][0], $user->getManager());
            $temp_user->manager = $manager->manager;
        }
        $temp_user->language_id = mb_strtolower($user['c'][0]);
        $temp_user->email = $user->getEmail();
        $location = $user->getLocale();
        if ($location == 'Voronezh') {
            $temp_user->location = 'Воронеж';
        } elseif ($location == 'Krasnodar') {
            $temp_user->location = 'Краснодар';
        } elseif ($location == 'Moscow') {
            $temp_user->location = 'Москва';
        }

        $temp_user->department = $user['extensionattribute5'][0];
        $temp_user->cost_center_code = $user['extensionattribute4'][0];
        $temp_user->manager_id = $user['extensionattribute6'][0];
        $temp_user->cost_center_number = $user->getEmployeeId();
        return $temp_user;
    }
}