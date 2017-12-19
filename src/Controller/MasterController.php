<?php
/**
 * Created by IntelliJ IDEA.
 * User: Etudiant
 * Date: 18/12/2017
 * Time: 10:51
 */
namespace Controller;
abstract class MasterController
{

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager ($app) {
        return $app['orm.em'] ;
    }

    public static function getAuthorizedUser($app)
    {
        // Get current authentication token
        $token = $app['security.token_storage']->getToken();

        if ($token !== null) {
            $user = $token->getUser();
            return $user;// Get user from token
        }
        return null;
    }

    /**
     * @param Application $app
     * @return null|array
     */
    public static function getAuthorizedUserAsArray($app)
    {
        // Get current authentication token
        $user = self::getAuthorizedUser($app);
        return $user ? $user->toArray($app) : null;
    }

}