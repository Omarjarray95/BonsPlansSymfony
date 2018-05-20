<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DemandeAjout
 *
 * @ORM\Table(name="demande_ajout")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\DemandeAjoutRepository")
 */
class DemandeAjout
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="type_shops", type="string", columnDefinition="enum('Grande surface', 'Parfumerie','Boutique','Patisserie','Librairie','Fleuriste','Candy Shop','Autre')", nullable=TRUE)
     */
    protected $typeShops;
    /**
     * @ORM\Column(name="type_resto", type="string", columnDefinition="enum('Restaurant', 'Bar','Cafe','Fast-Food','Autre')", nullable=TRUE)
     */
    protected $typeResto;


    /**
     * @var int
     * @ORM\Column(name="nbrStars", type="integer", nullable=TRUE)
     */
    protected $nbrStars;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $id_user;

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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
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
     * @ORM\Column(name="Description", type="string", length=255)
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
     * @ORM\Column(name="Horaire_Fermeture", type="string", length=255)
     */
    protected $horaireFermeture;

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
     * @ORM\Column(name="image_principale", type="string", nullable=TRUE)
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
     * @return string
     */
    public function getHoraireOuverture()
    {
        return $this->horaireOuverture;
    }

    /**
     * @param string $horaireOuverture
     */
    public function setHoraireOuverture($horaireOuverture)
    {
        $this->horaireOuverture = $horaireOuverture;
    }

    /**
     * @return mixed
     */
    public function getHoraireFermeture()
    {
        return $this->horaireFermeture;
    }

    /**
     * @param mixed $horaireFermeture
     */
    public function setHoraireFermeture($horaireFermeture)
    {
        $this->horaireFermeture = $horaireFermeture;
    }

    /**
     * @return mixed
     */
    public function getNumTel()
    {
        return $this->numTel;
    }

    /**
     * @param mixed $numTel
     */
    public function setNumTel($numTel)
    {
        $this->numTel = $numTel;
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
     * Set imagePrincipale
     *
     * @param string $imagePrincipale
     *
     * @return DemandeAjout
     */
    public function setImagePrincipale($imagePrincipale)
    {
        $this->imagePrincipale = $imagePrincipale;
    }

    /**
     * @return mixed
     */
    public function getURL()
    {
        return $this->URL;
    }

    /**
     * @param mixed $URL
     */
    public function setURL($URL)
    {
        $this->URL = $URL;
    }

    /**
     * @return mixed
     */
    public function getBudgetmoyen()
    {
        return $this->budgetmoyen;
    }

    /**
     * @param mixed $budgetmoyen
     */
    public function setBudgetmoyen($budgetmoyen)
    {
        $this->budgetmoyen = $budgetmoyen;
    }

    /**
     * @var
     * @ORM\Column(name="Budget_Moyen", nullable=TRUE)
     */
    protected $budgetmoyen;
    /**
     * * @ORM\Column(name="type_loisirs", type="string", columnDefinition="enum('Cinema', 'Salle de sport','Parc d attraction','Spa','Salon de coiffure','Centre de beaute','Salle de jeux','Autre')")
     */
    protected $typeLoisirs;
    /**
     * @return mixed
     */
    public function getTypeLoisirs()
    {
        return $this->typeLoisirs;
    }

    /**
     * @param mixed $typeLoisirs
     */
    public function setTypeLoisirs($typeLoisirs)
    {
        $this->typeLoisirs = $typeLoisirs;
    }







    /**
     * Set typeShops
     *
     * @param string $typeShops
     *
     * @return DemandeAjout
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
     * Set typeResto
     *
     * @param string $typeResto
     *
     * @return DemandeAjout
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
     * Set nbrStars
     *
     * @param integer $nbrStars
     *
     * @return DemandeAjout
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
}
