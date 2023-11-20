<?php

namespace app\AD;
use Adldap;
use app\Employee\CostCenter;
use app\Employee\CostOwner;
use app\Employee\Department;
use app\Employee\EmployeeData;
use app\Employee\Unit;
use app\Mapping\EmployeeMap;
use DateInterval;
use DateTime;
use DateTimeZone;
use Exception;


class ADConnect
{
    private $provider;
    private $ad;
    private $paginator;
    public $from;
    public $to;
       

    function __construct()
    {
        $this->config = new ADConfig();
        $this->ad = new Adldap\Adldap();
        $this->ad->addProvider($this->config->getConfig(), "connection1");
        try{
            $this->provider = $this->ad->connect('connection1', 'INT\A828835', 'Rfgbnfk0792!');
            //$this->provider = $this->ad->connect('connection1');
        }catch (Exception $ex){
            echo $ex->getMessage();
        }

        $this->paginator = $this->provider
            ->search()
            ->users()
            ->where('company', '=', 'Atos IT Solutions and Services')
            ->paginate(500)
            ->getResults();

        $this->to = new DateTime(null,  new DateTimeZone('Europe/Moscow'));
        $hour = DateInterval::createFromDateString('1 hour');
        $this->from = new DateTime($this->to->format('Y-m-d H:i:s'),  new DateTimeZone('Europe/Moscow'));
    }

    public function getForMonth(){
        $employeeData = new EmployeeData();
        $month = DateInterval::createFromDateString('1 months');
        $this->from->sub($month);

        $pag = $this->provider
            ->search()
            ->users()
            ->rawFilter("(&(objectClass=User)(objectCategory=person)(company=Atos IT Solutions and Services*)(|(whenChanged>={$this->from->format('YmdHis.0\Z')})(whenCreated>={$this->from->format('YmdHis.0\Z')})))")
            ->paginate(5000);

        $users = $pag->getResults();

        foreach ($users as $user){
            $employee = EmployeeMap::Map($user);
            array_push($employeeData->employee, $employee);
        }

        return $employeeData;
    }

    public function getByDate(){
        $employeeData = new EmployeeData();

        $hour = DateInterval::createFromDateString('1 hour');
        $this->from->sub($hour);

        $users = $this->provider
            ->search()
            ->users()
            ->rawFilter("(&(objectClass=User)(objectCategory=person)(company=Atos IT Solutions and Services*)(|(whenChanged>={$this->from->format('YmdHis.0\Z')})(whenCreated>={$this->from->format('YmdHis.0\Z')})))")
            ->paginate(500)
            ->getResults();

        foreach ($users as $user){
            $employee = EmployeeMap::Map($user);
            array_push($employeeData->employee, $employee);
        }

        return $employeeData;
    }

    public function getAllUsers()
    {
        $employeeData = new EmployeeData();
        foreach ($this->paginator as $user) {
            $temp_user = EmployeeMap::Map($user);
            array_push($employeeData->employee, $temp_user);
        }
        return $employeeData;
    }

    public function getManagers(){
        $managerData = new \app\Employee\ManagerData();
        foreach ($this->paginator as $user) {
            if (!is_null($user->getManager())) {
                array_push($managerData->employee, new \app\Employee\Manager($user['samaccountname'][0], $user->getManager()));
            }
        }
    }

    public function hasUnit(array $objects, $value): bool {
        foreach ($objects as $object) {
            if ($object->name === $value) {
                return true;
            }
        }
        return false;
    }

    public function hasCost(array $objects, $value): bool {
        foreach ($objects as $object) {
            if ($object->number === $value) {
                return true;
            }
        }
        return false;
    }

    public function getUnits(){
        $unitData = new \app\Employee\UnitData();
        $units = array();
        foreach ($this->paginator as $user) {
            if(!is_null($user->getDepartment())) {
                if(!$this->hasUnit($units, $user->getDepartment())){
                    array_push($units, new Unit($user->getDepartment()));
                }
            }
        }

        $unitData->org_unit = $units;
        return $unitData;
    }

    public function getUnitEmployee(){
        $unitEmployeeData = new \app\Employee\UnitEmployee();
        $employee_unit = array();
        foreach ($this->paginator as $user) {
            $unit = new Unit($user->getDepartment());
            $unit->login = $user['samaccountname'][0];
            array_push($employee_unit, $unit);
        }

        $unitEmployeeData->employee = $employee_unit;
        return $unitEmployeeData;
    }

    public function getDepartments(){
        $departmentData = new \app\Employee\DepartmentData();
        $departments = array();
        foreach ($this->paginator as $user) {
            if(!is_null($user['extensionattribute4'])) {
                $department_name = mb_strtolower($user['extensionattribute5'][0], 'UTF-8');
                if(!$this->hasUnit($departments, $user['extensionattribute4'][0])){
                    $department = new Department($user['extensionattribute4'][0]);
                    $department->depart_name = $department_name;
                    array_push($departments, $department);
                }
            }
        }
        $departmentData->org_department = $departments;
        return $departmentData;
    }

    public function getEmployeeDepartments(){
        $departmentEmployee = new \app\Employee\DepartmentEmployee();
        $departments = array();
        foreach ($this->paginator as $user) {
            if(!is_null($user['extensionattribute4'])) {
                $department = new Department($user['extensionattribute4'][0]);
                $department->login = $user['samaccountname'][0];
                array_push($departments, $department);
            }
        }
        $departmentEmployee->employee = $departments;
        return $departmentEmployee;
    }

    public function getCosts() {
        $cost_center = new \app\Employee\CostCenterData();
        $costs = array();
        foreach ($this->paginator as $user) {
            if(!is_null($user['extensionattribute13'])) {
                if(!$this->hasCost($costs, $user['extensionattribute13'][0])) {
                    $costCenter = new CostCenter($user['extensionattribute13'][0]);
                    $costCenter->department = !is_null($user['extensionattribute4']) ? $user['extensionattribute4'][0] : null;
                    array_push($costs, $costCenter);
                }
            }
        }

        $cost_center->c_cost_centers = $costs;
        return $cost_center;
    }

    public function getCostOwner() {
        $cost_owner_data = new \app\Employee\CostOwnerData();
        $costs = array();
        foreach ($this->paginator as $user) {
            if(!is_null($user['extensionattribute13'])) {
                $cost = new CostOwner($user['samaccountname'][0], $user['extensionattribute13'][0]);
                array_push($costs, $cost);
            }
        }

        $cost_owner_data->c_cost_center_owner = $costs;
        return $cost_owner_data;
    }

}
