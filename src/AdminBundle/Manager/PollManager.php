<?php

namespace AdminBundle\Manager;

use AdminBundle\Entity\Poll;
use Doctrine\Common\Persistence\ObjectManager;

class PollManager extends BaseManager
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

    public function findByPerson($questionId, $person) {
        return $this->getRepository()->findOneBy(['question' => $questionId, 'person' => $person]);
    }

    /**
     * Save Project entity
     *
     * @param Poll $poll
     * @internal param Project $project
     */
    public function save(Poll $poll)
    {
        $this->persistAndFlush($poll);
    }

    public function getRepository()
    {
        return $this->em->getRepository($this->class);
    }

}