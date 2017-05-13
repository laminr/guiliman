<?php

namespace AdminBundle\Manager;

use AdminBundle\Entity\Person;
use AdminBundle\Entity\Poll;
use Doctrine\Common\Persistence\ObjectManager;

class PersonManager extends BaseManager
{
    protected $em;
    private $class;

    public function __construct(ObjectManager $em, $class)
    {
        $this->em = $em;
        $this->class = $class;
    }

    public function findAll() {
        return $this->getRepository()->findAll();
    }

    public function findById($id) {
        return $this->getRepository()->findOneById($id);
    }

    public function getPersonForUser($userId) {
        return $this->getRepository()->getPersonForUser($userId);
    }

    public function getNbPerson() {
        return $this->getRepository()->getNbPerson();
    }

    public function getTotalShare() {
        return $this->getRepository()->getTotalShare();
    }

    /**
     * Save Project entity
     *
     * @param Person $person
     * @internal param Poll $poll
     * @internal param Project $project
     */
    public function save(Person $person)
    {
        $this->persistAndFlush($person);
    }

    public function getRepository()
    {
        return $this->em->getRepository($this->class);
    }

}