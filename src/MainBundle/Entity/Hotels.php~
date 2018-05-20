<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hotels
 *
 * @ORM\Table(name="hotels")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\HotelsRepository")
 */
class Hotels extends Etablissement
{

    /**
     * @var int
     * @ORM\Column(name="nbrStars", type="integer")
     */
    protected $nbrStars;



    /**
     * Set nbrStars
     *
     * @param integer $nbrStars
     *
     * @return Hotels
     */
    public function setNbrStars($nbrStars)
    {
        $this->nbrStars = $nbrStars;

        return $this;
    }

    /**
     * Get nbrStars
     *
     * @return int
     */
    public function getNbrStars()
    {
        return $this->nbrStars;
    }

    /**
     * Add evaluation
     *
     * @param \MainBundle\Entity\Evaluation $evaluation
     *
     * @return Hotels
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
     * @return Hotels
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
     * @return Hotels
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
     * @return Hotels
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
     * @return Hotels
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
     * @return Hotels
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
     * @return Hotels
     */
    public function setHoraireOuverture($horaireOuverture)
    {
        $this->horaire_ouverture = $horaireOuverture;

        return $this;
    }

    /**
     * Get horaireOuverture
     *
     * @return string
     */
    public function getHoraireOuverture()
    {
        return $this->horaire_ouverture;
    }

    /**
     * Set horaireFermeture
     *
     * @param string $horaireFermeture
     *
     * @return Hotels
     */
    public function setHoraireFermeture($horaireFermeture)
    {
        $this->horaire_fermeture = $horaireFermeture;

        return $this;
    }

    /**
     * Get horaireFermeture
     *
     * @return string
     */
    public function getHoraireFermeture()
    {
        return $this->horaire_fermeture;
    }

    /**
     * Set numTel
     *
     * @param string $numTel
     *
     * @return Hotels
     */
    public function setNumTel($numTel)
    {
        $this->num_tel = $numTel;

        return $this;
    }

    /**
     * Get numTel
     *
     * @return string
     */
    public function getNumTel()
    {
        return $this->num_tel;
    }

    /**
     * Set imagePrincipale
     *
     * @param string $imagePrincipale
     *
     * @return Hotels
     */
    public function setImagePrincipale($imagePrincipale)
    {
        $this->image_principale = $imagePrincipale;

        return $this;
    }

    /**
     * Get imagePrincipale
     *
     * @return string
     */
    public function getImagePrincipale()
    {
        return $this->image_principale;
    }

    /**
     * Set uRL
     *
     * @param string $uRL
     *
     * @return Hotels
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
     * @return Hotels
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
     * @return Hotels
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
     * @return Hotels
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
     * @return Hotels
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
     * @return Hotels
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
     * @return Hotels
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
