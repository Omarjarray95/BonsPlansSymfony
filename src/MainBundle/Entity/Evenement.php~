<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;
/**
 * Evenement
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */

    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @return mixed
     */
    public function getInteresses()
    {
        return $this->interesses;
    }

    /**
     * @param mixed $interesses
     */
    public function setInteresses($interesses)
    {
        $this->interesses = $interesses;
    }
    /**
     * @ORM\Column(type="integer" ,nullable=TRUE)
     */
    public $interesses;

    /**
     * @return mixed
     */
    public function getNbrPersonnes()
    {
        return $this->nbr_personnes;
    }

    /**
     * @param mixed $nbr_personnes
     */
    public function setNbrPersonnes($nbr_personnes)
    {
        $this->nbr_personnes = $nbr_personnes;
    }
    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Etablissement")
     * @ORM\JoinColumn(name="id_etablissement",referencedColumnName="id")
     */
    private $etablissement;
    /**
     * @ORM\Column(type="integer", nullable=TRUE)
     */
    public $nbr_personnes;

    /**
     * @return mixed
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * @param mixed $etablissement
     */
    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;
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

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Evenement
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Evenement
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Evenement
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
}
