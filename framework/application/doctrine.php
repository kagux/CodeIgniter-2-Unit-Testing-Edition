<?php
 
define('APPPATH', dirname(__FILE__) . '/');
define('BASEPATH', APPPATH . '/../system/');
define('ENVIRONMENT', 'development'); // IMPORTANT! This should match the value in CodeIgniter's /index.php
 
chdir(APPPATH . '/libraries');
 
require_once 'Doctrine/Common/ClassLoader.php';
 
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine');
$classLoader->register();
 
$classLoader = new \Doctrine\Common\ClassLoader('Symfony', 'Doctrine');
$classLoader->register();
 
$configFile = getcwd() . '/Doctrine.php';
 
$helperSet = null;
if (file_exists($configFile)) {
    if ( ! is_readable($configFile)) {
        trigger_error(
            'Configuration file [' . $configFile . '] does not have read permission.', E_ERROR
        );
    }
 
    require $configFile;
 
    foreach ($GLOBALS as $helperSetCandidate) {
        if ($helperSetCandidate instanceof \Symfony\Component\Console\Helper\HelperSet) {
            $helperSet = $helperSetCandidate;
            break;
        }
    }
}
 
$doctrine = new Doctrine;
$em = $doctrine->em;
 
$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));
 
\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);