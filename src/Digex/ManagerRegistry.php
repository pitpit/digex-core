<?php

namespace Digex;

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Silex\Application;

class ManagerRegistry extends AbstractManagerRegistry
{
    /**
     * @var ContainerInterface
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        parent::__construct('default', array('default' => 'db'), array('default' => 'em'), 'default', 'default', 'Doctrine\ORM\Proxy\Proxy');
    }

    /**
     * @inheritdoc
     */
    protected function getService($name)
    {
        return $this->app[$name];
    }

    /**
     * @inheritdoc
     */
    protected function resetService($name)
    {
        unset($this->app[$name]);
    }

    /**
     * @inheritdoc
     */
    public function getAliasNamespace($alias)
    {
        try {
            return $this->app['em']->getConfiguration()->getEntityNamespace($alias);
        } catch (ORMException $e) {
        }

        throw ORMException::unknownEntityNamespace($alias);
    }
}
