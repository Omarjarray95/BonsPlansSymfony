<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MainBundle\Entity\Tag;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Etablissement
 *
 * @ORM\Table(name="etablissement")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\EtablissementRepository")
 */
class Etablissement
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    protected $nom;

    /**
     * @var string
     * @ORM\Column(name="Type", type="string", length=255)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=255, nullable=true)
     */
    protected $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=2000)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Horaire_Ouverture", type="string", length=255)
     */
    protected $horaireOuverture;

    /**
     * @var
     * @ORM\Column(name="Horaire_Fermeture")
     */
    protected $horaireFermeture;
    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     */
    protected $representant;

    /**
     * @return mixed
     */
    public function getRepresentant()
    {
        return $this->representant;
    }

    /**
     * @param mixed $representant
     */
    public function setRepresentant($representant)
    {
        $this->representant = $representant;
    }

    /**
     * @var
     * @ORM\Column(name="Numero")
     * @Assert\Length(
     *      min = 8,
     *      max = 8
     * )
     */
    protected $numTel;

    /**
     * @ORM\Column(type="string", nullable=TRUE)
     * @Assert\NotBlank(message="Please, upload the image as a PNG file.")
     * @Assert\File(mimeTypes={ "image/png","image/jpeg","image/jpg","image/gif" })
     */
    protected $imagePrincipale;

    /**
     * @var
     * @ORM\Column(name="URL", nullable=TRUE)
     */
    protected $URL;

    /**
     * @var
     * @ORM\Column(name="Budget_Moyen", nullable=TRUE)
     */
    protected $budgetmoyen;

    /**
     * @ORM\ManyToMany(targetEntity="MainBundle\Entity\Tag", cascade={"persist"})
     */
    protected $tags;

    /**
     * @ORM\ManyToMany(targetEntity="MainBundle\Entity\Service",mappedBy="etablissements")
     */
    protected $services;

    /**
     * @ORM\ManyToMany(targetEntity="MainBundle\Entity\User", mappedBy="etablissements")
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Evaluation", mappedBy="id_etablissement")
     */
    protected $evaluations;

    /**
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Reservation", mappedBy="etablissement")
     */
    protected $reservations;

    /**
     * * @ORM\Column(name="type_loisirs", type="string", columnDefinition="enum('Cinema', 'Salle de sport','Parc d attraction','Spa','Salon de coiffure','Centre de beaute','Salle de jeux','Autre')", nullable=TRUE)
     */
    protected $typeLoisirs;

    /**
     * @ORM\Column(name="type_shops", type="string", columnDefinition="enum('Grande surface', 'Parfumerie','Boutique','Patisserie','Librairie','Fleuriste','Candy Shop','Autre')", nullable=TRUE)
     */
    protected $typeShops;

    /**
     * @var int
     * @ORM\Column(name="nbrStars", type="integer", nullable=TRUE)
     */
    protected $nbrStars;

    /**
     * @var int
     * @ORM\Column(name="partenaire", type="integer", nullable=TRUE)
*/
    protected $partenaire;

    /**
     * @return mixed
     */
    public function getPartenaire()
    {
        return $this->partenaire;
    }

    /**
     * @param mixed $partenaire
     */
    public function setPartenaire($partenaire)
    {
        $this->partenaire = $partenaire;
    }
    /**
     * @ORM\Column(name="type_resto", type="string", columnDefinition="enum('Restaurant', 'Bar','Cafe','Fast-Food','Autre')", nullable=TRUE)
     */
    protected $typeResto;

    /**
     * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="etablissement")
     */
    protected $comments;

    /**
     * @var int
     * @ORM\Column(name="rating", type="integer", nullable=TRUE)
     */
    protected $rating;

    /**
     * @var int
     * @ORM\Column(name="nbrrating", type="integer", nullable=TRUE)
     */
    protected $nbrrating;

    /**
     * @var int
     * @ORM\Column(name="nbruser", type="integer", nullable=TRUE)
     */
    protected $nbruser;

    /**
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\SharedExperience", mappedBy="etablissement")
     */
    protected $sharedExperiences;


    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add tag
     *
     * @param \MainBundle\Entity\Tag $tag
     *
     * @return Etablissement
     */
    public function addTag(\MainBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \MainBundle\Entity\Tag $tag
     */
    public function removeTag(\MainBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param mixed $services
     */
    public function setServices($services)
    {
        $this->services = $services;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Etablissement
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Etablissement
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Etablissement
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
     * Constructor
     */
    public function __construct()
    {
        $this->services = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add service
     *
     * @param \MainBundle\Entity\Service $service
     *
     * @return Etablissement
     */
    public function addService(\MainBundle\Entity\Service $service)
    {
        $this->services[] = $service;

        return $this;
    }

    /**
     * Remove service
     *
     * @param \MainBundle\Entity\Service $service
     */
    public function removeService(\MainBundle\Entity\Service $service)
    {
        $this->services->removeElement($service);
    }

    /**
     * Add user
     *
     * @param \MainBundle\Entity\User $user
     *
     * @return Etablissement
     */
    public function addUser(\MainBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \MainBundle\Entity\User $user
     */
    public function removeUser(\MainBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Add evaluation
     *
     * @param \MainBundle\Entity\Evaluation $evaluation
     *
     * @return Etablissement
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
     * @return Etablissement
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
     * Set typeLoisirs
     *
     * @param string $typeLoisirs
     *
     * @return Etablissement
     */
    public function setTypeLoisirs($typeLoisirs)
    {
        $this->typeLoisirs = $typeLoisirs;

        return $this;
    }

    /**
     * Get typeLoisirs
     *
     * @return string
     */
    public function getTypeLoisirs()
    {
        return $this->typeLoisirs;
    }

    /**
     * Set typeShops
     *
     * @param string $typeShops
     *
     * @return Etablissement
     */
    public function setTypeShops($typeShops)
    {
        $this->typeShops = $typeShops;

        return $this;
    }

    /**
     * Get typeShops
     *
     * @return string
     */
    public function getTypeShops()
    {
        return $this->typeShops;
    }

    /**
     * Set nbrStars
     *
     * @param integer $nbrStars
     *
     * @return Etablissement
     */
    public function setNbrStars($nbrStars)
    {
        $this->nbrStars = $nbrStars;

        return $this;
    }

    /**
     * Get nbrStars
     *
     * @return integer
     */
    public function getNbrStars()
    {
        return $this->nbrStars;
    }

    /**
     * Set typeResto
     *
     * @param string $typeResto
     *
     * @return Etablissement
     */
    public function setTypeResto($typeResto)
    {
        $this->typeResto = $typeResto;

        return $this;
    }

    /**
     * Get typeResto
     *
     * @return string
     */
    public function getTypeResto()
    {
        return $this->typeResto;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Etablissement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set horaireOuverture
     *
     * @param string $horaireOuverture
     *
     * @return Etablissement
     */
    public function setHoraireOuverture($horaireOuverture)
    {
        $this->horaireOuverture = $horaireOuverture;

        return $this;
    }

    /**
     * Get horaireOuverture
     *
     * @return string
     */
    public function getHoraireOuverture()
    {
        return $this->horaireOuverture;
    }

    /**
     * Set horaireFermeture
     *
     * @param string $horaireFermeture
     *
     * @return Etablissement
     */
    public function setHoraireFermeture($horaireFermeture)
    {
        $this->horaireFermeture = $horaireFermeture;

        return $this;
    }

    /**
     * Get horaireFermeture
     *
     * @return string
     */
    public function getHoraireFermeture()
    {
        return $this->horaireFermeture;
    }

    /**
     * Set numTel
     *
     * @param string $numTel
     *
     * @return Etablissement
     */
    public function setNumTel($numTel)
    {
        $this->numTel = $numTel;

        return $this;
    }

    /**
     * Get numTel
     *
     * @return string
     */
    public function getNumTel()
    {
        return $this->numTel;
    }

    /**
     * Set imagePrincipale
     *
     * @param string $imagePrincipale
     *
     * @return Etablissement
     */
    public function setImagePrincipale($imagePrincipale)
    {
        $this->imagePrincipale = $imagePrincipale;

        return $this;
    }

    /**
     * Get imagePrincipale
     *
     * @return string
     */
    public function getImagePrincipale()
    {
        return $this->imagePrincipale;
    }

    /**
     * Set uRL
     *
     * @param string $uRL
     *
     * @return Etablissement
     */
    public function setURL($uRL)
    {
        $this->URL = $uRL;

        return $this;
    }

    /**
     * Get uRL
     *
     * @return string
     */
    public function getURL()
    {
        return $this->URL;
    }

    /**
     * Set budgetmoyen
     *
     * @param string $budgetmoyen
     *
     * @return Etablissement
     */
    public function setBudgetmoyen($budgetmoyen)
    {
        $this->budgetmoyen = $budgetmoyen;

        return $this;
    }

    /**
     * Get budgetmoyen
     *
     * @return string
     */
    public function getBudgetmoyen()
    {
        return $this->budgetmoyen;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return Etablissement
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set nbrrating
     *
     * @param integer $nbrrating
     *
     * @return Etablissement
     */
    public function setNbrrating($nbrrating)
    {
        $this->nbrrating = $nbrrating;

        return $this;
    }

    /**
     * Get nbrrating
     *
     * @return integer
     */
    public function getNbrrating()
    {
        return $this->nbrrating;
    }

    /**
     * Add comment
     *
     * @param \MainBundle\Entity\Commentaire $comment
     *
     * @return Etablissement
     */
    public function addComment(\MainBundle\Entity\Commentaire $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \MainBundle\Entity\Commentaire $comment
     */
    public function removeComment(\MainBundle\Entity\Commentaire $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set nbruser
     *
     * @param integer $nbruser
     *
     * @return Etablissement
     */
    public function setNbruser($nbruser)
    {
        $this->nbruser = $nbruser;

        return $this;
    }

    /**
     * Get nbruser
     *
     * @return integer
     */
    public function getNbruser()
    {
        return $this->nbruser;
    }

    /**
     * Add sharedExperience
     *
     * @param \MainBundle\Entity\SharedExperience $sharedExperience
     *
     * @return Etablissement
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
