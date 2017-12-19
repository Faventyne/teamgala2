<?php
/**
 * Created by IntelliJ IDEA.
 * User: Faventyne
 * Date: 17/12/2017
 * Time: 00:08
 */
namespace Repository;
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllActive(){

        $qb=$this->getEntityManager()->createQueryBuilder();
        return
            $qb->select('u')
            ->from('Model\User','u')
            ->where($qb->expr()->isNull('u.deleted'))
            ->orderBy('u.lastname','ASC')
            ->getQuery()
            ->getResult();

    }
}