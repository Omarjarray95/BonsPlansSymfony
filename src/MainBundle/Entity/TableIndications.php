<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TableIndications
 *
 * @ORM\Table(name="table_indications")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\TableIndicationsRepository")
 */
class TableIndications
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
     * @var integer
     *
     * @ORM\Column(name="id_commentaire", type="integer")
     */
    private $idCommentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="indication", type="text")
     */
    private $indication;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return TableIndications
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return TableIndications
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set indication
     *
     * @param string $indication
     *
     * @return TableIndications
     */
    public function setIndication($indication)
    {
        $this->indication = $indication;

        return $this;
    }

    /**
     * Get indication
     *
     * @return string
     */
    public function getIndication()
    {
        return $this->indication;
    }

    /**
     * Set idCommentaire
     *
     * @param integer $idCommentaire
     *
     * @return TableIndications
     */
    public function setIdCommentaire($idCommentaire)
    {
        $this->idCommentaire = $idCommentaire;

        return $this;
    }

    /**
     * Get idCommentaire
     *
     * @return integer
     */
    public function getIdCommentaire()
    {
        return $this->idCommentaire;
    }

    /**
     * Set user
     *
     * @param \MainBundle\Entity\User $user
     *
     * @return TableIndications
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
}
