<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 10/02/2018
 * Time: 22:34
 */

namespace MainBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Doctrine\ORM\Mapping as ORM;
use MainBundle\Entity\Etablissement;
use Mgilet\NotificationBundle\NotifiableInterface;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @Notifiable(name="user")
 */
class User extends BaseUser implements NotifiableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $nom;

    /**
     * @var string
     * @ORM\Column(type="string", name="Sexe")
     */
    protected $sexe;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=TRUE)
     */
    protected $datedenaissance;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $ville;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $phone;

    /**
     * @var
     * @ORM\Column(name="URL", nullable=TRUE)
     */
    protected $url;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=TRUE,length=2000)
     */
    protected $intro;

    /**
     * @ORM\ManyToMany(targetEntity="MainBundle\Entity\Etablissement", inversedBy="id")
     * @ORM\JoinTable(name="favoris")
     */
    protected $etablissements;

    /**
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Evaluation", mappedBy="id_user")
     */
    protected $evaluations;

    /**
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Reservation", mappedBy="user")
     */
    protected $reservations;

    /**
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\SharedExperience", mappedBy="user")
     */
    protected $sharedExperiences;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add etablissement
     *
     * @param Etablissement $etablissement
     *
     * @return User
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

    /**
     * Add evaluation
     *
     * @param \MainBundle\Entity\Evaluation $evaluation
     *
     * @return User
     */
    public function addEvaluation(\MainBundle\Entity\Evaluation $evaluation)
    {
        $this->evaluations[] = $evaluation;

        return $this;
    }

    /**
     * Remove evaluation
     *
     * @param \MainBundle\Entity\Evaluation $evaluation
     */
    public function removeEvaluation(\MainBundle\Entity\Evaluation $evaluation)
    {
        $this->evaluations->removeElement($evaluation);
    }

    /**
     * Get evaluations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }

    /**
     * Add reservation
     *
     * @param \MainBundle\Entity\Reservation $reservation
     *
     * @return User
     */
    public function addReservation(\MainBundle\Entity\Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \MainBundle\Entity\Reservation $reservation
     */
    public function removeReservation(\MainBundle\Entity\Reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
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

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set datedenaissance
     *
     * @param \DateTime $datedenaissance
     *
     * @return User
     */
    public function setDatedenaissance($datedenaissance)
    {
        $this->datedenaissance = $datedenaissance;

        return $this;
    }

    /**
     * Get datedenaissance
     *
     * @return \DateTime
     */
    public function getDatedenaissance()
    {
        return $this->datedenaissance;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set intro
     *
     * @param string $intro
     *
     * @return User
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;

        return $this;
    }

    /**
     * Get intro
     *
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return User
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Add sharedExperience
     *
     * @param \MainBundle\Entity\SharedExperience $sharedExperience
     *
     * @return User
     */
    public function addSharedExperience(\MainBundle\Entity\SharedExperience $sharedExperience)
    {
        $this->sharedExperiences[] = $sharedExperience;

        return $this;
    }

    /**
     * Remove sharedExperience
     *
     * @param \MainBundle\Entity\SharedExperience $sharedExperience
     */
    public function removeSharedExperience(\MainBundle\Entity\SharedExperience $sharedExperience)
    {
        $this->sharedExperiences->removeElement($sharedExperience);
    }

    /**
     * Get sharedExperiences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSharedExperiences()
    {
        return $this->sharedExperiences;
    }
}
