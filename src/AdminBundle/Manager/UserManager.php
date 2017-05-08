<?php

namespace AdminBundle\Manager;

use AdminBundle\Entity\Poll;
use AdminBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserManager extends BaseManager
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

    /**
     * Save Project entity
     *
     * @param User $user
     * @internal param Poll $poll
     * @internal param Project $project
     */
    public function save(User $user)
    {
        $this->persistAndFlush($user);
    }

    public function getRepository()
    {
        return $this->em->getRepository($this->class);
    }

}