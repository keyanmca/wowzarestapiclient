<?php
namespace WowzaRestApi;

class WowzaApplicationModule
{
    public $order;
    public $name;
    public $description;
    public $class;

    public function __construct($object = null)
    {
        if (!is_null($object) && is_object($object)) {
            $this->order = $object['order'];
            $this->name = $object['name'];
            $this->description = $object['description'];
            $this->class = $object['class'];
        }
    }
}
