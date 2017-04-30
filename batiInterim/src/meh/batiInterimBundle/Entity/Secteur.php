<?php

namespace meh\batiInterimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secteur
 *
 * @ORM\Table(name="secteur")
 * @ORM\Entity(repositoryClass="meh\batiInterimBundle\Entity\SecteurRepository")
 */
class Secteur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idSecteur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsecteur;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=50, nullable=true)
     */
    private $libelle;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Entrepreneur", inversedBy="idsecteur")
     * @ORM\JoinTable(name="rattacher",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idSecteur", referencedColumnName="idSecteur")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idEntrepreneur", referencedColumnName="idEntrepreneur")
     *   }
     * )
     */
    private $identrepreneur;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->identrepreneur = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idsecteur
     *
     * @return integer 
     */
    public function getIdsecteur()
    {
        return $this->idsecteur;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Secteur
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
     * Add identrepreneur
     *
     * @param \meh\batiInterimBundle\Entity\Entrepreneur $identrepreneur
     * @return Secteur
     */
    public function addIdentrepreneur(\meh\batiInterimBundle\Entity\Entrepreneur $identrepreneur)
    {
        $this->identrepreneur[] = $identrepreneur;

        return $this;
    }

    /**
     * Remove identrepreneur
     *
     * @param \meh\batiInterimBundle\Entity\Entrepreneur $identrepreneur
     */
    public function removeIdentrepreneur(\meh\batiInterimBundle\Entity\Entrepreneur $identrepreneur)
    {
        $this->identrepreneur->removeElement($identrepreneur);
    }

    /**
     * Get identrepreneur
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdentrepreneur()
    {
        return $this->identrepreneur;
    }
}
