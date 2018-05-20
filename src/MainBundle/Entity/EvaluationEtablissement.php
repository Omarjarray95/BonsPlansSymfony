<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluationEtablissement
 *
 * @ORM\Table(name="evaluation_etablissement")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\EvaluationEtablissementRepository")
 */
class EvaluationEtablissement
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
     * @var string
     *
     * @ORM\Column(name="Aime", type="string", length=255)
     */
    private $aime;

    /**
     * @var string
     *
     * @ORM\Column(name="PasAime", type="string", length=255)
     */
    private $pasAime;

    /**
     * @var string
     *
     * @ORM\Column(name="cool", type="string", length=255)
     */
    private $cool;

    /**
     * @var string
     *
     * @ORM\Column(name="nulle", type="string", length=255)
     */
    private $nulle;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Etablissement")
     */
    protected $etablissement;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     */
    protected $user;


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
     * Set aime
     *
     * @param string $aime
     *
     * @return EvaluationEtablissement
     */
    public function setAime($aime)
    {
        $this->aime = $aime;

        return $this;
    }

    /**
     * Get aime
     *
     * @return string
     */
    public function getAime()
    {
        return $this->aime;
    }

    /**
     * Set pasAime
     *
     * @param string $pasAime
     *
     * @return EvaluationEtablissement
     */
    public function setPasAime($pasAime)
    {
        $this->pasAime = $pasAime;

        return $this;
    }

    /**
     * Get pasAime
     *
     * @return string
     */
    public function getPasAime()
    {
        return $this->pasAime;
    }

    /**
     * Set cool
     *
     * @param string $cool
     *
     * @return EvaluationEtablissement
     */
    public function setCool($cool)
    {
        $this->cool = $cool;

        return $this;
    }

    /**
     * Get cool
     *
     * @return string
     */
    public function getCool()
    {
        return $this->cool;
    }

    /**
     * Set nulle
     *
     * @param string $nulle
     *
     * @return EvaluationEtablissement
     */
    public function setNulle($nulle)
    {
        $this->nulle = $nulle;

        return $this;
    }

    /**
     * Get nulle
     *
     * @return string
     */
    public function getNulle()
    {
        return $this->nulle;
    }

    /**
     * Set etablissement
     *
     * @param \MainBundle\Entity\Etablissement $etablissement
     *
     * @return EvaluationEtablissement
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
     * @return EvaluationEtablissement
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
