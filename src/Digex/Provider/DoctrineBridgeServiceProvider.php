<?php

namespace Digex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Digex\ManagerRegistry;

/**
 * Enable UniqueEntity validation constraint (http://symfony.com/doc/current/reference/constraints/UniqueEntity.html) from Doctrine Bridge.
 *
 * Get Doctrine Bridge :
 *
 *    composer require symfony/doctrine-bridge
 *
 * And add the following to your app:
 *
 *     $app->register(new Digex\Provider\DoctrineBridgeServiceProvider());
 *
 * @author    Damien Pitard <damien.pitard@digitaslbi.fr>
 * @copyright 2012 DigitasLBi
 */
class DoctrineBridgeServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['validator.validator_service_ids'] = array('doctrine.orm.validator.unique' => 'doctrine.orm.validator.unique');

        $app['doctrine.manager_registry'] = $app->share(function() use ($app){

            return new ManagerRegistry($app);
        });

        $app['doctrine.orm.validator.unique'] = $app->share(function() use ($app){

            return new UniqueEntityValidator($app['doctrine.manager_registry']);
        });
    }

    public function boot(Application $app) {}
}