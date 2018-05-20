<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visited
 *
 * @ORM\Table(name="visited")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\VisitedRepository")
 */
class Visited
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
