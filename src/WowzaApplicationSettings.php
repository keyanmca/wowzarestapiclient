<?php
namespace WowzaRestApi;

class WowzaApplicationSettings
{
    public $name;
    public $modules = array();

    public function __construct($object = null)
    {
        if (!is_null($object) && is_object($object)) {
            $this->modules = array();
            foreach ($object->modules->moduleList as $module) {
                $this->modules[] = new WowzaModule($module);
            }
        }
    }
}