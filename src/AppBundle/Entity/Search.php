<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Search
 *
 * @ORM\Table(name="search")
 * @ORM\Entity
 */
class Search
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Answer
     *
     * @ORM\OneToOne(targetEntity="Answer")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $answer;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Answer
     *
     * @return Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set Answer
     *
     * @param Answer $answer
     *
     * @return $this
     */
    public function setAnswer(Answer $answer)
    {
        $this->answer = $answer;

        return $this;
    }
}

