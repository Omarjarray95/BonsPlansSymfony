<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User", inversedBy="reservations")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Etablissement", inversedBy="reservations")
     * @ORM\JoinColumn(name="id_etablissement", referencedColumnName="id")
     */
    private $etablissement;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nom;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $prenom;
    /**
     * @var
     * @ORM\Column(name="Numero")
     * @Assert\Length(
     *      min = 8,
     *      max = 8
     * )
     */
    private $numtel;
    /**
     * @var int
     * @ORM\Column(name="nbre_chambres", type="integer", nullable=TRUE)
     */
    private $nbreChambres;
    /**
     * @var int
     * @ORM\Column(name="nbre_adultes", type="integer", nullable=TRUE)
     */
    private $nbreAdultes;
    /**
     * @var int
     * @ORM\Column(name="nbre_enfants", type="integer", nullable=TRUE)
     */
    private $nbreEnfants;


    /**
     * @ORM\Column(name="nbre_personnes",type="integer",nullable=TRUE)
     */
    private $nbrePersonnes;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_reservation", type="date",nullable=TRUE)
     */
    private $datedereservation;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arrivée", type="date",nullable=TRUE)
     */
    private $arrivee;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heuredereservation", type="datetime",nullable=TRUE)
     */
    private $heuredereservation;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="départ", type="date",nullable=TRUE)
     */
    private $depart;
    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getNumtel()
    {
        return $this->numtel;
    }

    /**
     * @param mixed $numtel
     */
    public function setNumtel($numtel)
    {
        $this->numtel = $numtel;
    }

    /**
     * @return int
     */
    public function getNbreChambres()
    {
        return $this->nbreChambres;
    }

    /**
     * @param int $nbreChambres
     */
    public function setNbreChambres($nbreChambres)
    {
        $this->nbreChambres = $nbreChambres;
    }

    /**
     * @return string
     */
    public function getHeuredereservation()
    {
        return $this->heuredereservation;
    }

    /**
     * @param string $heuredereservation
     */
    public function setHeuredereservation($heuredereservation)
    {
        $this->heuredereservation = $heuredereservation;
    }

    /**
     * @return int
     */
    public function getNbreAdultes()
    {
        return $this->nbreAdultes;
    }

    /**
     * @param int $nbreAdultes
     */
    public function setNbreAdultes($nbreAdultes)
    {
        $this->nbreAdultes = $nbreAdultes;
    }

    /**
     * @return int
     */
    public function getNbreEnfants()
    {
        return $this->nbreEnfants;
    }

    /**
     * @param int $nbreEnfants
     */
    public function setNbreEnfants($nbreEnfants)
    {
        $this->nbreEnfants = $nbreEnfants;
    }


    /**
     * @return mixed
     */
    public function getNbrePersonnes()
    {
        return $this->nbrePersonnes;
    }

    /**
     * @param mixed $nbrePersonnes
     */
    public function setNbrePersonnes($nbrePersonnes)
    {
        $this->nbrePersonnes = $nbrePersonnes;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

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
     * Set datedereservation
     *
     * @param \DateTime $datedereservation
     *
     * @return Reservation
     */
    public function setDatedereservation($datedereservation)
    {
        $this->datedereservation = $datedereservation;

        return $this;
    }

    /**
     * Get datedereservation
     *
     * @return \DateTime
     */
    public function getDatedereservation()
    {
        return $this->datedereservation;
    }

    /**
     * Set arrivee
     *
     * @param \DateTime $arrivee
     *
     * @return Reservation
     */
    public function setArrivee($arrivee)
    {
        $this->arrivee = $arrivee;

        return $this;
    }

    /**
     * Get arrivee
     *
     * @return \DateTime
     */
    public function getArrivee()
    {
        return $this->arrivee;
    }

    /**
     * Set depart
     *
     * @param \DateTime $depart
     *
     * @return Reservation
     */
    public function setDepart($depart)
    {
        $this->depart = $depart;

        return $this;
    }

    /**
     * Get depart
     *
     * @return \DateTime
     */
    public function getDepart()
    {
        return $this->depart;
    }
}
