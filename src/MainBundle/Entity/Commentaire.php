<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string")
     */
    private $comment;

    /**
     * @var
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Etablissement", inversedBy="comments")
     */
    protected $etablissement;

    /**
     * @var
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * Commentaire constructor.
     * @param $created
     */
    public function __construct()
    {
        $this->created =(new \DateTime('now'));

    }


    public function getId()
    {
        return $this->id;
    }



    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Commentaire
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }



    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Commentaire
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Commentaire
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }


    /**
     * Set etablissement
     *
     * @param \MainBundle\Entity\Etablissement $etablissement
     *
     * @return Commentaire
     */
    public function setEtablissement(\MainBundle\Entity\Etablissement $etablissement = null)
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * Get etablissement
     *
     * @return \MainBundle\Entity\Etablissement
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Set user
     *
     * @param \MainBundle\Entity\User $user
     *
     * @return Commentaire
     */
    public function setUser(\MainBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Commentaire
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    //public function getUpdatedAt()
    //{
    //  return $this->updatedAt;
    //}

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
