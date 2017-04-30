<?php

namespace meh\batiInterimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Artisan
 *
 * @ORM\Table(name="Artisan")
 * @ORM\Entity(repositoryClass="meh\batiInterimBundle\Entity\ArtisanRepository")
 */
class Artisan
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idArtisan", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idartisan;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50, nullable=true)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date", nullable=true)
     */
    private $datenaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuNaissance", type="string", length=200, nullable=true)
     */
    private $lieunaissance;

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
     * @var boolean
     *
     * @ORM\Column(name="mdpChanger", type="boolean", nullable=false)
     */
    private $mdpchanger;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Corpsmetier", inversedBy="idartisan")
     * @ORM\JoinTable(name="appartenir",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idArtisan", referencedColumnName="idArtisan")
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
     * Get idartisan
     *
     * @return integer 
     */
    public function getIdartisan()
    {
        return $this->idartisan;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Artisan
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
     * Set prenom
     *
     * @param string $prenom
     * @return Artisan
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set datenaissance
     *
     * @param \DateTime $datenaissance
     * @return Artisan
     */
    public function setDatenaissance($datenaissance)
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    /**
     * Get datenaissance
     *
     * @return \DateTime 
     */
    public function getDatenaissance()
    {
        return $this->datenaissance;
    }

    /**
     * Set lieunaissance
     *
     * @param string $lieunaissance
     * @return Artisan
     */
    public function setLieunaissance($lieunaissance)
    {
        $this->lieunaissance = $lieunaissance;

        return $this;
    }

    /**
     * Get lieunaissance
     *
     * @return string 
     */
    public function getLieunaissance()
    {
        return $this->lieunaissance;
    }

    /**
     * Set numtel
     *
     * @param integer $numtel
     * @return Artisan
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
     * @return Artisan
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
     * @return Artisan
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
     * Set login
     *
     * @param string $login
     * @return Artisan
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
     * @return Artisan
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
     * Set mdpchanger
     *
     * @param boolean $mdpchanger
     * @return Artisan
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
     * Add idcorpmetier
     *
     * @param \meh\batiInterimBundle\Entity\Corpsmetier $idcorpmetier
     * @return Artisan
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
