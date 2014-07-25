<?php

namespace Troiswa\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Film
 *
 * @ORM\Table(name="film")
 * @ORM\Entity(repositoryClass="Troiswa\PublicBundle\Entity\FilmRepository")
 */
class Film
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Troiswa\PublicBundle\Entity\Categorie", inversedBy="films")
     */
    private $categorie;



    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


    /** @Assert\Image(
    *     maxSize = "1024k",
    *     maxSizeMessage = "Attention"
    * )
    */
    private $fichier;

    /**
     * @var string
     *
     * @ORM\Column(name="spectateur", type="string")
     */
    private $spectateur;
    /**
     * @var string
     *
     * @ORM\Column(name="synopsis", type="text")
     */
    private $synopsis;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */

    private $dateCreation;

    /**
     * Get id
     *
     * @return integer 
     */
   

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Film
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set synopsis
     *
     * @param string $synopsis
     * @return Film
     */
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    /**
     * Get synopsis
     *
     * @return string 
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }


    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Film
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set spectateur
     *
     * @param string $spectateur
     * @return Film
     */
    public function setSpectateur($spectateur)
    {
        $this->spectateur = $spectateur;

        return $this;
    }

    /**
     * Get spectateur
     *
     * @return string 
     */
    public function getSpectateur()
    {
        return $this->spectateur;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Film
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    public function getfichier()
    {
        return $this->fichier;
    }
    public function setfichier($fichier)
    {
        return $this->fichier=$fichier;
    }

    public function upload()
    {
        if(null ===$this->fichier)
        {
            return;
        }

        $namefile=$this->titre.'-'.$this->spectateur.'-'.uniqid().'.'.$this->fichier->guessExtension();
        $this->fichier->move($this->getUploadDir(),$namefile);
        $this->image=$namefile;






    }

    public function getUploadDir()
    {
        return "upload/Films";
    }

    public function getwebPath()
    {
        if(null ===$this->image)
        {
            return null;
        }
        return $this->getUploadDir()."/".$this->image;
    }




    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }




    /**
     * Set categorie
     *
     * @param \Troiswa\PublicBundle\Entity\Categorie $categorie
     * @return Film
     */
    public function setCategorie(\Troiswa\PublicBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Troiswa\PublicBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
