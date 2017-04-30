<?php

namespace meh\batiInterimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chefchantier
 *
 * @ORM\Table(name="chefChantier", indexes={@ORM\Index(name="FK_chefChantier_idEntrepreneur", columns={"idEntrepreneur"})})
 * @ORM\Entity(repositoryClass="meh\batiInterimBundle\Entity\ChefchantierRepository")
 */
class Chefchantier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idChefChantier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idchefchantier;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=35, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=35, nullable=true)
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
     * @ORM\Column(name="mdpChanger", type="boolean", nullable=true)
     */
    private $mdpchanger;

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
     * Get idchefchantier
     *
     * @return integer 
     */
    public function getIdchefchantier()
    {
        return $this->idchefchantier;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Chefchantier
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
     * @return Chefchantier
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
     * Set login
     *
     * @param string $login
     * @return Chefchantier
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
     * @return Chefchantier
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
     * @return Chefchantier
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
     * Set identrepreneur
     *
     * @param \meh\batiInterimBundle\Entity\Entrepreneur $identrepreneur
     * @return Chefchantier
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
}
