<?php

namespace meh\batiInterimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Corpsmetier
 *
 * @ORM\Table(name="corpsMetier")
 * @ORM\Entity(repositoryClass="meh\batiInterimBundle\Entity\CorpsmetierRepository")
 */
class Corpsmetier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCorpMetier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcorpmetier;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=50, nullable=true)
     */
    private $libelle;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Artisan", mappedBy="idcorpmetier")
     */
    private $idartisan;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Mission", mappedBy="idcorpmetier")
     */
    private $idmission;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idartisan = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idmission = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idcorpmetier
     *
     * @return integer 
     */
    public function getIdcorpmetier()
    {
        return $this->idcorpmetier;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Corpsmetier
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Add idartisan
     *
     * @param \meh\batiInterimBundle\Entity\Artisan $idartisan
     * @return Corpsmetier
     */
    public function addIdartisan(\meh\batiInterimBundle\Entity\Artisan $idartisan)
    {
        $this->idartisan[] = $idartisan;

        return $this;
    }

    /**
     * Remove idartisan
     *
     * @param \meh\batiInterimBundle\Entity\Artisan $idartisan
     */
    public function removeIdartisan(\meh\batiInterimBundle\Entity\Artisan $idartisan)
    {
        $this->idartisan->removeElement($idartisan);
    }

    /**
     * Get idartisan
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdartisan()
    {
        return $this->idartisan;
    }

    /**
     * Add idmission
     *
     * @param \meh\batiInterimBundle\Entity\Mission $idmission
     * @return Corpsmetier
     */
    public function addIdmission(\meh\batiInterimBundle\Entity\Mission $idmission)
    {
        $this->idmission[] = $idmission;

        return $this;
    }

    /**
     * Remove idmission
     *
     * @param \meh\batiInterimBundle\Entity\Mission $idmission
     */
    public function removeIdmission(\meh\batiInterimBundle\Entity\Mission $idmission)
    {
        $this->idmission->removeElement($idmission);
    }

    /**
     * Get idmission
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdmission()
    {
        return $this->idmission;
    }
}
