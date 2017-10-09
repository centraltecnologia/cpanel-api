<?php
require 'vendor/autoload.php';

$cPanel = new \Codemax\cPanelPHP\Cpanel(array(
    'host'        =>  'https://123.456.789.123:2087', // ip or domain complete with its protocol and port
    'username'    =>  'root', // username of your server, it usually root.
    'auth_type'   =>  'hash', // set 'hash' or 'password'
    'password'    =>  'password', // long hash or your user's password
));

//$accounts = $cPanel->createAccount('gerentepro2.com.br', 'gerentet', 'abc,123', 'gerentep');
# WORK

//$accounts = $cPanel->destroyAccount('gerentep');
# WORK

//$accounts = $cPanel->detailsAccount('gerentep');
# WORK
//$accounts = $cPanel->listSuspended();

$args = [
    'disk_limit' => '2000',
    'bw_limit' => '10000',
];

//$pkg = $cPanel->addPackage('Facil 1GB',$args);


//$pkg = $cPanel->editAccount('codemax', $args);
//$accounts = $cPanel->listAccounts();
$pkg = $cPanel->editAccount('gerentet', $args);
print_r($pkg);