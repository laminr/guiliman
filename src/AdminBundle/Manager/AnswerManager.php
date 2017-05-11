<?php

namespace AdminBundle\Manager;

use AdminBundle\Entity\Answer;
use AdminBundle\Entity\Poll;
use Doctrine\Common\Persistence\ObjectManager;

class AnswerManager extends BaseManager
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
     * @param Poll $ans
     * @internal param Project $project
     */
    public function save(Answer $answer)
    {
        $this->persistAndFlush($answer);
    }

    public function getRepository()
    {
        return $this->em->getRepository($this->class);
    }

}