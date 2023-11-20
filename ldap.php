<?php
#php -S localhost:8000
$ldapuri = "LDAP://abxads002.int.atosbox.ru:389";
$login = "INT\A828835";
$pwd = "Gtlhbkj0792!";
// Connecting to LDAP
$ldapconn = ldap_connect($ldapuri) or die("That LDAP-URI was not parseable");
ldap_bind($ldapconn, $login, $pwd);
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
#filter by users (&(objectCategory=person)(objectClass=user)(!primaryGroupID=513))
#Configure search filter
#OU=Users,OU=ABX,OU=OU_Root,DC=int,DC=atosbox,DC=ru
$dn = 'OU=Users,OU=ABX,OU=OU_Root,DC=int,DC=atosbox,DC=ru';
$filter = '(|(objectClass=user))';
//$justthese = array('ou', 'sn', 'givenname', 'mail');
$justthese = array(    
    'whenchanged', 'whencreated',
    'employeetype', 'manager', 'preferredlanguage', 'extensionAttribute5',
    'extensionAttribute4', 'mobile', 'distinguishedname', 'userprincipalname',
    'useraccountcontrol', 'telephonenumber', 'sn',
    'physicaldeliveryofficename', 'name', 'mail',
    'l', 'givenname', 'title', 'employeeNumber',
    'employeeid', 'msrtcsip-userenabled',
    'extensionAttribute13', 'displayname', 'department',
    'company', 'co', 'cn', 'c', 'samaccountname', 'description');

// enable pagination with a page size of 100.
$pageSize = 500;
$cookie = '';
$mergeArray = array();
$users = array();

class User
{
    //public $extensionattribute11;
    public $whenchanged;
    public $whencreated;
    public $description;
    public $msrtcsipuserenabled;
    public $employeetype;
    public $manager;    
    public $extensionAttribute5;
    public $extensionAttribute4;
    public $mobile;
    public $distinguishedname;
    public $userprincipalname;
    public $useraccountcontrol;
    public $telephonenumber;
    public $sn;
    public $physicaldeliveryofficename;
    public $name;
    public $l;
    public $givenname;
    
    public $employeeNumber;
    public $extensionattribute13;
    public $displayname;
    public $department;
    public $company;
    public $co;
    public $cn;

    public $c;
    public $samAccountname;
    public $title;

    public $employeeid;

}

do {
    ldap_control_paged_result($ldapconn, $pageSize, true, $cookie);

    $result = ldap_search($ldapconn, $dn, $filter, $justthese);
    $entries = ldap_get_entries($ldapconn, $result);

    foreach ($entries as $employee) {
        if (isset($employee['company']) && $employee['company'][0] != 'Atos IT Solutions and Services') {
            continue;
        }

        if (is_null($employee['company'][0])) {
            continue;
        }

        $user = new User();
        if(isset($employee['msrtcsip-userenabled'])){
            $user->msrtcsipuserenabled = $employee['msrtcsip-userenabled'][0];
        }
        if (isset($employee['cn'])) {
            $user->cn = $employee['cn'][0];
        }

        if (isset($employee['sn'])) {
            $user->sn = $employee['sn'][0];
        }

        $user->whenchanged = $employee['whenchanged'][0];
        $user->whencreated = $employee['whencreated'][0];

        if (isset($employee['employeetype'])) {
            $user->employeetype = $employee['employeetype'][0];
        }

        if (isset($employee['manager'])) {
            $user->manager = $employee['manager'][0];
        }
        //$user->preferredlanguage = $employee['preferredlanguage'][0];
        if (isset($employee['extensionattribute5'])) {
            $user->extensionAttribute5 = $employee['extensionattribute5'][0];
        }

        if (isset($employee['extensionattribute4'])) {
            $user->extensionAttribute4 = $employee['extensionattribute4'][0];
        }

        if (isset($employee['mobile'])) {
            $user->mobile = $employee['mobile'][0];
        }

        $user->distinguishedname = $employee['distinguishedname'][0];
        $user->userprincipalname = $employee['userprincipalname'][0];
        $user->useraccountcontrol = $employee['useraccountcontrol'][0];
        if (isset($employee['telephonenumber'])) {
            $user->telephonenumber = $employee['telephonenumber'][0];
        }

        if (isset($employee['physicaldeliveryofficename'])) {
            $user->physicaldeliveryofficename = $employee['physicaldeliveryofficename'][0];
        }

        $user->name = $employee['name'][0];
        $user->l = $employee['l'][0];
        $user->givenname = $employee['givenname'][0];
        $user->title = $employee['title'][0];
        if (isset($employee['employeenumber'])) {
            $user->employeeNumber = $employee['employeenumber'][0];
        }

        $user->displayname = $employee['displayname'][0];
        $user->department = $employee['department'][0];
        if (isset($employee['company'])) {
            $user->company = $employee['company'][0];
        }

        if (isset($employee['description'])) {
            $user->description = $employee['description'][0];
        }

        if (isset($employee['co'])) {
            $user->co = $employee['co'][0];
        }
        if (isset($employee['c'])) {

            $user->c = $employee['c'][0];
        }

        if (isset($employee['employeeid'])) {
            $user->employeeid = $employee['employeeid'][0];
        }

        if (isset($employee['extensionattribute13'])) {
            $user->extensionattribute13 = $employee['extensionattribute13'][0];
        }
        
        if (isset($employee['samaccountname'])) {
            $user->samAccountname = $employee['samaccountname'][0];
        }

        array_push($users, $user);
        unset($user);
    }

    ldap_control_paged_result_response($ldapconn, $result, $cookie);

} while ($cookie !== null && $cookie != '');

$path = 'C:\Users\administrator\Desktop\scripts\users.json';
echo json_encode($users);
$fp = fopen($path, 'w');
fwrite($fp, json_encode($users));
fclose($fp);
