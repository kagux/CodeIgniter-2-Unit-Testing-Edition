<?php
use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Configuration;

define('DEBUGGING', TRUE);

class Doctrine {

    public $em = null;

    public function __construct()
    {
        // load database configuration and custom config from CodeIgniter
        require APPPATH . 'config/database.php';

        // Set up class loading.
        require_once APPPATH . 'libraries/Doctrine/Common/ClassLoader.php';

        $doctrineClassLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPPATH . 'libraries');
        $doctrineClassLoader->register();

        $entitiesClassLoader = new \Doctrine\Common\ClassLoader('entities', APPPATH.'models');
        $entitiesClassLoader->register();

        $repositoryClassLoader = new \Doctrine\Common\ClassLoader("repositories", APPPATH.'models');
        $repositoryClassLoader->register();

        $proxiesClassLoader = new \Doctrine\Common\ClassLoader('Proxies', APPPATH . 'models');
        $proxiesClassLoader->register();

        $symfonyClassLoader = new \Doctrine\Common\ClassLoader('Symfony', APPPATH . 'libraries/Doctrine');
        $symfonyClassLoader->register();

        // Choose caching method based on application mode (ENVIRONMENT is defined in /index.php)
        if (ENVIRONMENT == 'development' ||  ENVIRONMENT == 'testing') {
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        } else {
            $cache = new \Doctrine\Common\Cache\ApcCache;
        }

        // Set some configuration options
        $config = new Configuration;

        // Metadata driver
        $driverImpl = $config->newDefaultAnnotationDriver(APPPATH . 'models/entities');
        $config->setMetadataDriverImpl($driverImpl);

        // Caching
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);

        // Proxies
        $config->setProxyDir(APPPATH . 'models/Proxies');
        $config->setProxyNamespace('Proxies');

        if (ENVIRONMENT == 'development') {
            $config->setAutoGenerateProxyClasses(TRUE);
        } else {
            $config->setAutoGenerateProxyClasses(FALSE);
        }

        // SQL query logger
        if (DEBUGGING && ENVIRONMENT != 'testing')
        {
            $logger = new \Doctrine\DBAL\Logging\EchoSQLLogger;
            $config->setSQLLogger($logger);
        }

        // Database connection information
        switch(ENVIRONMENT) {
            case 'testing':
                     $connectionOptions = array(
                            'driver' => 'pdo_sqlite',
                            'memory' =>'true'
                         );
                     break;
            default:
                    $connectionOptions = array(
                        'driver' => 'pdo_mysql',
                        'user' => $db['default']['username'],
                        'password' => $db['default']['password'],
                        'host' => $db['default']['hostname'],
                        'dbname' => $db['default']['database'],
                        'charset' => 'utf8',
                        'driverOptions' => array(
                                1002=>'SET NAMES utf8'
                        )
                    );


        }

        // Create EntityManager
        $this->em = EntityManager::create($connectionOptions, $config);
    }
}
?>