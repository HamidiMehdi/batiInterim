<?php

namespace meh\batiInterimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chantier
 *
 * @ORM\Table(name="chantier", indexes={@ORM\Index(name="FK_chantier_idChefChantier", columns={"idChefChantier"}), @ORM\Index(name="FK_chantier_idEntrepreneur", columns={"idEntrepreneur"})})
 * @ORM\Entity(repositoryClass="meh\batiInterimBundle\Entity\ChantierRepository")
 */
class Chantier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idChantier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idchantier;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=25, nullable=true)
     */
    private $nom;

    /**
     * @var \Entrepreneur
     *
     * @ORM\ManyToOne(targetEntity="Entrepreneur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEntrepreneur", referencedColumnName="idEntrepreneur")
     * })
     */
    private $identrepreneur;

    /**
     * @var \Chefchantier
     *
     * @ORM\ManyToOne(targetEntity="Chefchantier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idChefChantier", referencedColumnName="idChefChantier")
     * })
     */
    private $idchefchantier;



    /**
     * Get idchantier
     *
     * @return integer 
     */
    public function getIdchantier()
    {
        return $this->idchantier;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Chantier
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
     * Set identrepreneur
     *
     * @param \meh\batiInterimBundle\Entity\Entrepreneur $identrepreneur
     * @return Chantier
     */
    public function setIdentrepreneur(\meh\batiInterimBundle\Entity\Entrepreneur $identrepreneur = null)
    {
        $this->identrepreneur = $identrepreneur;

        return $this;
    }

    /**
     * Get identrepreneur
     *
     * @return \meh\batiInterimBundle\Entity\Entrepreneur 
     */
    public function getIdentrepreneur()
    {
        return $this->identrepreneur;
    }

    /**
     * Set idchefchantier
     *
     * @param \meh\batiInterimBundle\Entity\Chefchantier $idchefchantier
     * @return Chantier
     */
    public function setIdchefchantier(\meh\batiInterimBundle\Entity\Chefchantier $idchefchantier = null)
    {
        $this->idchefchantier = $idchefchantier;

        return $this;
    }

    /**
     * Get idchefchantier
     *
     * @return \meh\batiInterimBundle\Entity\Chefchantier 
     */
    public function getIdchefchantier()
    {
        return $this->idchefchantier;
    }
}
