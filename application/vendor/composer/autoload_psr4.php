<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Service\\' => array($baseDir . '/services'),
    'ServiceZenvia\\' => array($baseDir . '/services'),
    'ServiceSms\\' => array($baseDir . '/services'),
    'Mongo\\' => array($baseDir . '/services/mongo'),
    'Modules\\Storage\\Create_folder_user\\' => array($baseDir . '/services/modules/storage'),
    'Modules\\Account\\RestoreAccount\\' => array($baseDir . '/services/modules/account'),
);
