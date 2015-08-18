<?php
namespace WowzaRestApi;

require __DIR__ . '/../vendor/autoload.php';

$c = new WowzaApiClient();

$res=$c->getApplicationList();
foreach ($res as $app) {
    $c->getApplicationSettings($app->name);
}
