<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * SharedExperience
 *
 * @ORM\Table(name="shared_experience")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\SharedExperienceRepository")
 * @Vich\Uploadable
 */

class SharedExperience
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
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User", inversedBy="sharedExperiences")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Etablissement", inversedBy="sharedExperiences")
     * @ORM\JoinColumn(name="id_etablissement", referencedColumnName="id")
     */
    private $etablissement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="checkInDate", type="date")
     */
    private $checkInDate;

    /**
     * @var string
     *
     * @ORM\Column(name="impression", type="string", length=2500)
     */
    private $impression;
    /**
     * @ORM\Column(type="datetime",nullable=TRUE)
     *
     * @var \DateTime
     */
    private $updatedAt;
    /**
     * @Vich\UploadableField(mapping="sharedExperience", fileNameProperty="sharedExperienceName")
     *
     * @var File
     */
    private $sharedExperienceFile;

    /**
     * @ORM\Column(type="string", length=255,nullable=TRUE)
     *
     * @var string
     */
    private $sharedExperienceName;

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $sharedExperience
     *
     * @return SharedExperience
     */
    public function setSharedExperienceFile(File $sharedExperience = null)
    {
        $this->sharedExperienceFile = $sharedExperience;

        if ($sharedExperience)
            $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    /**
     * @return File|null
     */
    public function getSharedExperienceFile()
    {
        return $this->sharedExperienceFile;
    }

    /**
     * @param string $sharedExprienceName
     * @return SharedExperience
     */

    public function setSharedExperienceName($sharedExprienceName)
    {
        $this->sharedExperienceName = $sharedExprienceName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSharedExperienceName()
    {
        return $this->sharedExperienceName;
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
     * Set checkInDate
     *
     * @param \DateTime $checkInDate
     *
     * @return SharedExperience
     */
    public function setCheckInDate($checkInDate)
    {
        $this->checkInDate = $checkInDate;

        return $this;
    }

    /**
     * Get checkInDate
     *
     * @return \DateTime
     */
    public function getCheckInDate()
    {
        return $this->checkInDate;
    }

    /**
     * Set impression
     *
     * @param string $impression
     *
     * @return SharedExperience
     */
    public function setImpression($impression)
    {
        $this->impression = $impression;

        return $this;
    }

    /**
     * Get impression
     *
     * @return string
     */
    public function getImpression()
    {
        return $this->impression;
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return SharedExperience
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
