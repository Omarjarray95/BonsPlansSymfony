<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\EvaluationRepository")
 */
class Evaluation
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
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User", inversedBy="evaluations")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Etablissement", inversedBy="evaluations")
     * @ORM\JoinColumn(name="id_etablissement", referencedColumnName="id")
     */
    private $id_etablissement;

    /**
     * @return mixed
     */
    public function getNbrStars()
    {
        return $this->nbrStars;
    }

    /**
     * @param mixed $nbrStars
     */
    public function setNbrStars($nbrStars)
    {
        $this->nbrStars = $nbrStars;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrStars;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    /**
     * @ORM\Column(type="string")
     */

    private $description;

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getIdEtablissement()
    {
        return $this->id_etablissement;
    }

    /**
     * @param mixed $id_etablissement
     */
    public function setIdEtablissement($id_etablissement)
    {
        $this->id_etablissement = $id_etablissement;
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
