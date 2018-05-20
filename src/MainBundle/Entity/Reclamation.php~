<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ReclamationRepository")
 */
class Reclamation
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
     * @ORM\Column(name="Sujet", type="string", length=255)
     */

    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu_reclamation", type="string", length=255)
     */
    private $contenu_reclamation;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Etablissement")
     * @ORM\JoinColumn(name="id_etab",referencedColumnName="id")
     */
    private $id_etab;

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
     * Set sujet
     *
     * @param string $sujet
     *
     * @return Reclamation
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * @return string
     */
    public function getContenuReclamation()
    {
        return $this->contenu_reclamation;
    }

    /**
     * @param string $contenu_reclamation
     */
    public function setContenuReclamation($contenu_reclamation)
    {
        $this->contenu_reclamation = $contenu_reclamation;
    }

    /**
     * Set idUser
     *
     * @param \MainBundle\Entity\User $idUser
     *
     * @return Reclamation
     */
    public function setIdUser(\MainBundle\Entity\User $idUser = null)
    {
        $this->id_user = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \MainBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * Set idEtab
     *
     * @param \MainBundle\Entity\Etablissement $idEtab
     *
     * @return Reclamation
     */
    public function setIdEtab(\MainBundle\Entity\Etablissement $idEtab = null)
    {
        $this->id_etab = $idEtab;

        return $this;
    }

    /**
     * Get idEtab
     *
     * @return \MainBundle\Entity\Etablissement
     */
    public function getIdEtab()
    {
        return $this->id_etab;
    }
}
