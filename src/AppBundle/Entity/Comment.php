<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity
 */
class Comment
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
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="has_files", type="boolean")
     */
    protected $hasFiles = false;

    /**
     * @var Answer
     *
     * @ORM\ManyToOne(targetEntity="Answer", inversedBy="comments")
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
     * Set content
     *
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set hasFiles
     *
     * @param boolean $hasFiles
     *
     * @return $this
     */
    public function setHasFiles($hasFiles)
    {
        $this->hasFiles = $hasFiles;

        return $this;
    }

    /**
     * Get hasFiles
     *
     * @return boolean
     */
    public function getHasFiles()
    {
        return $this->hasFiles;
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

