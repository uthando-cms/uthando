<?php
namespace Application\Service\Factory;

use BjyProfiler\Db\Profiler\Profiler;
use BjyProfiler\Db\Adapter\ProfilingAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbProfilerAdapterServiceFactory implements FactoryInterface
{
    /**
     * Create db adapter service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ProfilingAdapter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $dbParams = $config['db'];
        
        $adapter = new ProfilingAdapter(array(
        	'driver'    => 'pdo',
        	'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'],
        	'database'  => $dbParams['database'],
        	'username'  => $dbParams['username'],
        	'password'  => $dbParams['password'],
        	'hostname'  => $dbParams['hostname'],
        ));
        
        $adapter->setProfiler(new Profiler);
        $adapter->injectProfilingStatementPrototype();
        return $adapter;
    }
}
