<?php
require '../vendor/autoload.php';
require 'Client.php';

$c=new WowzaRestApi\Client();

$res=$c->getApplicationList();
var_dump($res);
