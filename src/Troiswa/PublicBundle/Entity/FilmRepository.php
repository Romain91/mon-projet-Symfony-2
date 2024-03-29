<?php

namespace Troiswa\PublicBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\Count;

/**
 * FilmRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FilmRepository extends EntityRepository
{
    public function getNBFilmByCategorie()
    {
        $req=$this->getEntityManager()->createQuery
        (
          "Select Count(f.id) as nbFilm, c.titre
          From TroiswaPublicBundle:Film f
          Left Join f.categorie c
          GROUP BY c.id"
        );

       return $req->getResult();
    }
}
