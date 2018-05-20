<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partenariat
 *
 * @ORM\Table(name="partenariat")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\PartenariatRepository")
 */
class Partenariat
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
     * @var Etablissement $favoris
     *
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Etablissement")
     */
    private $favoris;
    /**
     *
     * @var User $user
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     */
    private $user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=2000)
     */
    protected $description;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Etablissement
     */
    public function getFavoris()
    {
        return $this->favoris;
    }

    /**
     * @param Etablissement $favoris
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
