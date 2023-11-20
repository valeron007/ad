<?php

namespace app\Export;

class ExportJson
{
    public static $data;
    private $path;

    public function __construct($path, $name){
        $this->path = $path . $name . '.json';
    }

    public function setData($data){
        $this->data = $data;
    }

    public static function export($name, $data){
        //$file = fopen($path . $name . '.json', 'w');
        $path = 'C:\ldap\\' . $name . '.json';

        $file = fopen($path, 'w');
        fwrite($file, json_encode($data));
        fclose($file);
    }
}