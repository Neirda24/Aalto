<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnswerRepository")
 */
class Answer
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="has_files", type="boolean")
     */
    protected $hasFiles = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbBestResult", type="integer")
     */
    protected $nbBestResult = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbComments", type="integer")
     */
    protected $nbComments = 0;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="answer", orphanRemoval=true, cascade={"all"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $comments;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
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
     * Set nbBestResult
     *
     * @param integer $nbBestResult
     *
     * @return $this
     */
    public function setNbBestResult($nbBestResult)
    {
        $this->nbBestResult = $nbBestResult;

        return $this;
    }

    /**
     * Get nbBestResult
     *
     * @return integer
     */
    public function getNbBestResult()
    {
        return $this->nbBestResult;
    }

    /**
     * Increase by one the number of times this answer came up as the best answer.
     *
     * @return $this
     */
    public function increaseNbBestResult()
    {
        $this->nbBestResult++;

        return $this;
    }

    /**
     * Set nbComments
     *
     * @param integer $nbComments
     *
     * @return $this
     */
    public function setNbComments($nbComments)
    {
        $this->nbComments = $nbComments;

        return $this;
    }

    /**
     * Get nbComments
     *
     * @return integer
     */
    public function getNbComments()
    {
        return $this->nbComments;
    }

    /**
     * Get Comments
     *
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set Comments
     *
     * @param array $comments
     *
     * @return $this
     */
    public function setComments(array $comments)
    {
        $this->comments   = new ArrayCollection($comments);
        $this->nbComments = $this->comments->count();

        return $this;
    }

    /**
     * Add a comment
     *
     * @param Comment $comment
     *
     * @return $this
     */
    public function addComments(Comment $comment)
    {
        $this->comments->add($comment);
        $this->nbComments++;

        return $this;
    }

    /**
     * Get User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set User
     *
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get Created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set Created
     *
     * @param \DateTime $created
     *
     * @return $this
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }
}

