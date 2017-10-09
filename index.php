<?php
require 'vendor/autoload.php';

$cPanel = new \Codemax\cPanelPHP\Cpanel(array(
    'host'        =>  'https://200.201.136.177:2087', // ip or domain complete with its protocol and port
    'username'    =>  'codemax', // username of your server, it usually root.
    'auth_type'   =>  'password', // set 'hash' or 'password'
    'password'    =>  'lucm871g.', // long hash or your user's password
));

//$accounts = $cPanel->createAccount('gerentepro.com.br', 'gerentep', 'abc,123', 'codemax_plano_1GB');
# WORK

//$accounts = $cPanel->destroyAccount('gerentep');
# WORK

//$accounts = $cPanel->detailsAccount('gerentep');
# WORK
//$accounts = $cPanel->listSuspended();
/*
$args = [
    'disk_limit' => '1000',
    'bw_limit' => '10000',
    'ip' => 'y',
    'cgi' => 1,
    'frontpage' => 1,
    'theme' => 'x3',
    'mails' => 'unlimited',
    'domains' => 0,
    'domains_park' => 'unlimited',
    'sql_limit' => 'unlimited'
];
*/
//$pkg = $cPanel->changePackage('gerentep','Mega 2GB');

$pkg = $cPanel->gethostname();
print_r($pkg);