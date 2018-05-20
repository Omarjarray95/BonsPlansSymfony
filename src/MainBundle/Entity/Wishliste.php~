<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishliste
 *
 * @ORM\Table(name="wishliste")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\WishlisteRepository")
 */
class Wishliste
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
     *
     * @var User $user
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     */
    private $user;
    /**
     * @var Etablissement $favoris
     *
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Etablissement")
     */
    private $favoris;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getFavoris()
    {
        return $this->favoris;
    }

    /**
     * @param mixed $favoris
     */
    public function setFavoris($favoris)
    {
        $this->favoris = $favoris;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
