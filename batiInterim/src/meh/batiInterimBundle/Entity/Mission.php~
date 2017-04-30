<?php

namespace meh\batiInterimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mission
 *
 * @ORM\Table(name="mission", indexes={@ORM\Index(name="FK_mission_idChantier", columns={"idChantier"})})
 * @ORM\Entity(repositoryClass="meh\batiInterimBundle\Entity\MissionRepository")
 */
class Mission
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idMission", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmission;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="date", nullable=true)
     */
    private $datedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date", nullable=true)
     */
    private $datefin;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=50, nullable=true)
     */
    private $intitule;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbArtisans", type="integer", nullable=true)
     */
    private $nbartisans;

    /**
     * @var float
     *
     * @ORM\Column(name="prixParJour", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixparjour;

    /**
     * @var \Chantier
     *
     * @ORM\ManyToOne(targetEntity="Chantier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idChantier", referencedColumnName="idChantier")
     * })
     */
    private $idchantier;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Corpsmetier", inversedBy="idmission")
     * @ORM\JoinTable(name="caracteriser",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idMission", referencedColumnName="idMission")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idCorpMetier", referencedColumnName="idCorpMetier")
     *   }
     * )
     */
    private $idcorpmetier;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcorpmetier = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idmission
     *
     * @return integer 
     */
    public function getIdmission()
    {
        return $this->idmission;
    }

    /**
     * Set datedebut
     *
     * @param \DateTime $datedebut
     * @return Mission
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime 
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin
     *
     * @param \DateTime $datefin
     * @return Mission
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return \DateTime 
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set intitule
     *
     * @param string $intitule
     * @return Mission
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string 
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set nbartisans
     *
     * @param integer $nbartisans
     * @return Mission
     */
    public function setNbartisans($nbartisans)
    {
        $this->nbartisans = $nbartisans;

        return $this;
    }

    /**
     * Get nbartisans
     *
     * @return integer 
     */
    public function getNbartisans()
    {
        return $this->nbartisans;
    }

    /**
     * Set prixparjour
     *
     * @param float $prixparjour
     * @return Mission
     */
    public function setPrixparjour($prixparjour)
    {
        $this->prixparjour = $prixparjour;

        return $this;
    }

    /**
     * Get prixparjour
     *
     * @return float 
     */
    public function getPrixparjour()
    {
        return $this->prixparjour;
    }

    /**
     * Set idchantier
     *
     * @param \meh\batiInterimBundle\Entity\Chantier $idchantier
     * @return Mission
     */
    public function setIdchantier(\meh\batiInterimBundle\Entity\Chantier $idchantier = null)
    {
        $this->idchantier = $idchantier;

        return $this;
    }

    /**
     * Get idchantier
     *
     * @return \meh\batiInterimBundle\Entity\Chantier 
     */
    public function getIdchantier()
    {
        return $this->idchantier;
    }

    /**
     * Add idcorpmetier
     *
     * @param \meh\batiInterimBundle\Entity\Corpsmetier $idcorpmetier
     * @return Mission
     */
    public function addIdcorpmetier(\meh\batiInterimBundle\Entity\Corpsmetier $idcorpmetier)
    {
        $this->idcorpmetier[] = $idcorpmetier;

        return $this;
    }

    /**
     * Remove idcorpmetier
     *
     * @param \meh\batiInterimBundle\Entity\Corpsmetier $idcorpmetier
     */
    public function removeIdcorpmetier(\meh\batiInterimBundle\Entity\Corpsmetier $idcorpmetier)
    {
        $this->idcorpmetier->removeElement($idcorpmetier);
    }

    /**
     * Get idcorpmetier
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdcorpmetier()
    {
        return $this->idcorpmetier;
    }
}
