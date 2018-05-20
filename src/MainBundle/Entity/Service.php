<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MainBundle\Entity\Etablissement;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ServiceRepository")
 */
class Service
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
     * @ORM\ManyToMany(targetEntity="MainBundle\Entity\Etablissement", inversedBy="id")
     * * @ORM\JoinTable(name="etablissements_services")
     */
    private $etablissements;

    /**
     * @ORM\Column(name="type_service", type="string", columnDefinition="enum('Wifi', 'Parking','Espace kids','Utilites handicapes','Music','Espace fumeur','autre')")
     */
    private $typeService;

    /**
     * @return mixed
     */
    public function getTypeService()
    {
        return $this->typeService;
    }

    /**
     * @param mixed $typeService
     */
    public function setTypeService($typeService)
    {
        $this->typeService = $typeService;
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
     * Constructor
     */
    public function __construct()
    {
        $this->etablissements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add etablissement
     *
     * @param Etablissement $etablissement
     *
     * @return Service
     */
    public function addEtablissement(Etablissement $etablissement)
    {
        $this->etablissements[] = $etablissement;

        return $this;
    }

    /**
     * Remove etablissement
     *
     * @param Etablissement $etablissement
     */
    public function removeEtablissement(Etablissement $etablissement)
    {
        $this->etablissements->removeElement($etablissement);
    }

    /**
     * Get etablissements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtablissements()
    {
        return $this->etablissements;
    }
}
