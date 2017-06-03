<?php

namespace AdminBundle\Repository;

use AdminBundle\Entity\Person;

/**
 * AnswerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPersonForUser($userId = 0)
    {

        $sql = 'SELECT p as nbr FROM ' . Person::CLASS_NAME . ' p '
            . ' WHERE p.user = :userId';

        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter('userId', $userId);

        return $query->getResult()[0] ?? null;

    }

    public function getNbPerson()
    {

        $sql = 'SELECT COUNT(p) as nbr FROM ' . Person::CLASS_NAME . ' p ';
        $query = $this->getEntityManager()->createQuery($sql);

        return $query->getResult()[0];

    }
    public function getTotalShare()
    {

        $sql = 'SELECT SUM(p.action + p.obligation) as nbr FROM ' . Person::CLASS_NAME . ' p ';
        $query = $this->getEntityManager()->createQuery($sql);

        return $query->getResult()[0];

    }
}
