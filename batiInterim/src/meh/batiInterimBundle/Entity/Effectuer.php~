<?php

namespace meh\batiInterimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Effectuer
 *
 * @ORM\Table(name="effectuer", indexes={@ORM\Index(name="FK_effectuer_idMission", columns={"idMission"}), @ORM\Index(name="FK_effectuer_idEtat", columns={"idEtat"}), @ORM\Index(name="IDX_985281502CD96121", columns={"idArtisan"})})
 * @ORM\Entity(repositoryClass="meh\batiInterimBundle\Entity\EffectuerRepository")
 */
class Effectuer
{
    /**
     * @var \Etat
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Etat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEtat", referencedColumnName="idEtat")
     * })
     */
    private $idetat;

    /**
     * @var \Artisan
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Artisan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idArtisan", referencedColumnName="idArtisan")
     * })
     */
    private $idartisan;

    /**
     * @var \Mission
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Mission")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idMission", referencedColumnName="idMission")
     * })
     */
    private $idmission;



    /**
     * Set idetat
     *
     * @param \meh\batiInterimBundle\Entity\Etat $idetat
     * @return Effectuer
     */
    public function setIdetat(\meh\batiInterimBundle\Entity\Etat $idetat)
    {
        $this->idetat = $idetat;

        return $this;
    }

    /**
     * Get idetat
     *
     * @return \meh\batiInterimBundle\Entity\Etat 
     */
    public function getIdetat()
    {
        return $this->idetat;
    }

    /**
     * Set idartisan
     *
     * @param \meh\batiInterimBundle\Entity\Artisan $idartisan
     * @return Effectuer
     */
    public function setIdartisan(\meh\batiInterimBundle\Entity\Artisan $idartisan)
    {
        $this->idartisan = $idartisan;

        return $this;
    }

    /**
     * Get idartisan
     *
     * @return \meh\batiInterimBundle\Entity\Artisan 
     */
    public function getIdartisan()
    {
        return $this->idartisan;
    }

    /**
     * Set idmission
     *
     * @param \meh\batiInterimBundle\Entity\Mission $idmission
     * @return Effectuer
     */
    public function setIdmission(\meh\batiInterimBundle\Entity\Mission $idmission)
    {
        $this->idmission = $idmission;

        return $this;
    }

    /**
     * Get idmission
     *
     * @return \meh\batiInterimBundle\Entity\Mission 
     */
    public function getIdmission()
    {
        return $this->idmission;
    }
}
