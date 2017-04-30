<?php

namespace meh\batiInterimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conger
 *
 * @ORM\Table(name="conger", indexes={@ORM\Index(name="FK_conger_idArtisan", columns={"idArtisan"}), @ORM\Index(name="FK_conger_idGestionnaire", columns={"idGestionnaire"})})
 * @ORM\Entity(repositoryClass="meh\batiInterimBundle\Entity\CongerRepository")
 */
class Conger
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idConger", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idconger;

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
     * @ORM\Column(name="valider", type="string", length=30, nullable=true)
     */
    private $valider;

    /**
     * @var \Gestionnaire
     *
     * @ORM\ManyToOne(targetEntity="Gestionnaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idGestionnaire", referencedColumnName="idGestionnaire")
     * })
     */
    private $idgestionnaire;

    /**
     * @var \Artisan
     *
     * @ORM\ManyToOne(targetEntity="Artisan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idArtisan", referencedColumnName="idArtisan")
     * })
     */
    private $idartisan;



    /**
     * Get idconger
     *
     * @return integer 
     */
    public function getIdconger()
    {
        return $this->idconger;
    }

    /**
     * Set datedebut
     *
     * @param \DateTime $datedebut
     * @return Conger
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
     * @return Conger
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
     * Set valider
     *
     * @param string $valider
     * @return Conger
     */
    public function setValider($valider)
    {
        $this->valider = $valider;

        return $this;
    }

    /**
     * Get valider
     *
     * @return string 
     */
    public function getValider()
    {
        return $this->valider;
    }

    /**
     * Set idgestionnaire
     *
     * @param \meh\batiInterimBundle\Entity\Gestionnaire $idgestionnaire
     * @return Conger
     */
    public function setIdgestionnaire(\meh\batiInterimBundle\Entity\Gestionnaire $idgestionnaire = null)
    {
        $this->idgestionnaire = $idgestionnaire;

        return $this;
    }

    /**
     * Get idgestionnaire
     *
     * @return \meh\batiInterimBundle\Entity\Gestionnaire 
     */
    public function getIdgestionnaire()
    {
        return $this->idgestionnaire;
    }

    /**
     * Set idartisan
     *
     * @param \meh\batiInterimBundle\Entity\Artisan $idartisan
     * @return Conger
     */
    public function setIdartisan(\meh\batiInterimBundle\Entity\Artisan $idartisan = null)
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
}
