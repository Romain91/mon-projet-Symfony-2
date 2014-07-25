<?php

namespace Troiswa\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acteurs
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\PublicBundle\Entity\ActeursRepository")
 */
class Acteurs
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
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     * @Assert\NotBlank(message="le champs doit être remplie")
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $prenom;

    /**
     * @var string
     * @Assert\Length(
     *      min = "5",
     *      max = "50",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank(message="le champs doit être remplie")
     */
    private $nom;

    /**
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


    private $fichier;



    /**
     * @var \DateTime
     * @ORM\Column(name="dateNaissance", type="datetime")
     */
    private $dateNaissance;

    /**
     * @var string
     * @Assert\Choice(choices = {"0", "1"}, message = "Choisissez un genre valide.")

     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalité", type="string", length=255)
     * @Assert\NotBlank(message="le champs doit être remplie")
     */
    private $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="biography", type="text")
     * @Assert\NotBlank(message="le champs doit être remplie")
     */
    private $biography;


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
     * Set prenom
     *
     * @param string $prenom
     * @return Acteurs
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


    public function getGender()
    {
        if($this->sexe==1)
            {
                return "homme";
            };
        return "femme";
    }

    public function getShortBiography($length=50, $last="...")
    {
        if(strlen($this->biography)<$length)
        {
            return $this->biography;
        }
        $string = substr($this->biography,0,$length);
        $pos = strrpos($string," ");
        return substr($string,0,$pos).$last;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Acteurs
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
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Acteurs
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return Acteurs
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set nationalité
     *
     * @param string $nationalité
     * @return Acteurs
     */
    public function setNationalite($nationalité)
    {
        $this->nationalite = $nationalité;

        return $this;
    }

    /**
     * Get nationalité
     *
     * @return string 
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set biography
     *
     * @param string $biography
     * @return Acteurs
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * Get biography
     *
     * @return string 
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Acteurs
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

        $namefile=$this->prenom.'-'.$this->nom.'-'.uniqid().'.'.$this->fichier->guessExtension();
        $this->fichier->move($this->getUploadDir(),$namefile);
        $this->image=$namefile;


        $this->fichier->move($this->getUploadRootDir(),
        $this->fichier->getClientOriginalName());
        $this->image=$this->fichier->getClientOriginalName();


    }

    public function getUploadDir()
    {
        return "upload/Acteurs";
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
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }



}
