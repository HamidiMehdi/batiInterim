<?php

namespace meh\batiInterimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entrepreneur
 *
 * @ORM\Table(name="Entrepreneur")
 * @ORM\Entity(repositoryClass="meh\batiInterimBundle\Entity\EntrepreneurRepository")
 */
class Entrepreneur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idEntrepreneur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $identrepreneur;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=60, nullable=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=150, nullable=true)
     */
    private $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="nomSociete", type="string", length=100, nullable=true)
     */
    private $nomsociete;

    /**
     * @var integer
     *
     * @ORM\Column(name="numTel", type="integer", nullable=true)
     */
    private $numtel;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=100, nullable=true)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="cp", type="integer", nullable=true)
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="nomChef", type="string", length=25, nullable=true)
     */
    private $nomchef;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomChef", type="string", length=25, nullable=true)
     */
    private $prenomchef;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mdpChanger", type="boolean", nullable=false)
     */
    private $mdpchanger;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Secteur", mappedBy="identrepreneur")
     */
    private $idsecteur;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idsecteur = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get identrepreneur
     *
     * @return integer 
     */
    public function getIdentrepreneur()
    {
        return $this->identrepreneur;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Entrepreneur
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set mdp
     *
     * @param string $mdp
     * @return Entrepreneur
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get mdp
     *
     * @return string 
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Set nomsociete
     *
     * @param string $nomsociete
     * @return Entrepreneur
     */
    public function setNomsociete($nomsociete)
    {
        $this->nomsociete = $nomsociete;

        return $this;
    }

    /**
     * Get nomsociete
     *
     * @return string 
     */
    public function getNomsociete()
    {
        return $this->nomsociete;
    }

    /**
     * Set numtel
     *
     * @param integer $numtel
     * @return Entrepreneur
     */
    public function setNumtel($numtel)
    {
        $this->numtel = $numtel;

        return $this;
    }

    /**
     * Get numtel
     *
     * @return integer 
     */
    public function getNumtel()
    {
        return $this->numtel;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Entrepreneur
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
     * Set cp
     *
     * @param integer $cp
     * @return Entrepreneur
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set nomchef
     *
     * @param string $nomchef
     * @return Entrepreneur
     */
    public function setNomchef($nomchef)
    {
        $this->nomchef = $nomchef;

        return $this;
    }

    /**
     * Get nomchef
     *
     * @return string 
     */
    public function getNomchef()
    {
        return $this->nomchef;
    }

    /**
     * Set prenomchef
     *
     * @param string $prenomchef
     * @return Entrepreneur
     */
    public function setPrenomchef($prenomchef)
    {
        $this->prenomchef = $prenomchef;

        return $this;
    }

    /**
     * Get prenomchef
     *
     * @return string 
     */
    public function getPrenomchef()
    {
        return $this->prenomchef;
    }

    /**
     * Set mdpchanger
     *
     * @param boolean $mdpchanger
     * @return Entrepreneur
     */
    public function setMdpchanger($mdpchanger)
    {
        $this->mdpchanger = $mdpchanger;

        return $this;
    }

    /**
     * Get mdpchanger
     *
     * @return boolean 
     */
    public function getMdpchanger()
    {
        return $this->mdpchanger;
    }

    /**
     * Add idsecteur
     *
     * @param \meh\batiInterimBundle\Entity\Secteur $idsecteur
     * @return Entrepreneur
     */
    public function addIdsecteur(\meh\batiInterimBundle\Entity\Secteur $idsecteur)
    {
        $this->idsecteur[] = $idsecteur;

        return $this;
    }

    /**
     * Remove idsecteur
     *
     * @param \meh\batiInterimBundle\Entity\Secteur $idsecteur
     */
    public function removeIdsecteur(\meh\batiInterimBundle\Entity\Secteur $idsecteur)
    {
        $this->idsecteur->removeElement($idsecteur);
    }

    /**
     * Get idsecteur
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdsecteur()
    {
        return $this->idsecteur;
    }
}
