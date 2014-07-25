<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategorieController extends Controller
{
    public function listeAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categories = $em->getRepository('TroiswaPublicBundle:Categorie')->findAll();

        return $this->render('TroiswaPublicBundle:Categories:categorie.html.twig',array('categories'=>$categories));
    }



}
