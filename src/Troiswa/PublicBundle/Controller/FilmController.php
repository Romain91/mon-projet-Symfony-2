<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Troiswa\PublicBundle\Form\FilmType;
use Troiswa\PublicBundle\Entity\Film;
use Symfony\Component\HttpFoundation\Request;


class FilmController extends Controller
{


    public function filmsAction()
    {
    /*$films=array('1'=> array
    ('titre'=>'L\'Armée des 12 singes','synopsis'=>'Nous sommes en l\'an 2035. Les quelques milliers d\'habitants qui restent sur notre planète sont contraints de vivre sous terre. La surface du globe est devenue inhabitable à la suite d\'un virus ayant décimé 99% de la population. Les survivants mettent tous leurs espoirs dans un voyage à travers le temps pour découvrir les causes de la catastrophe et la prévenir. C\'est James Cole, hanté depuis des années par une image incompréhensible, qui est désigné pour cette mission.', 'genre'=>'Drame','Science fiction','Thriller'),
    '2'=> array('titre'=>'Fight Club','synopsis'=>'Le narrateur, sans identité précise, vit seul, travaille seul, dort seul, mange seul ses plateaux-repas pour une personne comme beaucoup d\'autres personnes seules qui connaissent la misère humaine, morale et sexuelle. C\'est pourquoi il va devenir membre du Fight club, un lieu clandestin ou il va pouvoir retrouver sa virilité, l\'échange et la communication. Ce club est dirigé par Tyler Durden, une sorte d\'anarchiste entre gourou et philosophe qui prêche l\'amour de son prochain.','genre'=>'Thriller'),
    '3'=> array('titre'=>'Seven', 'synopsis'=>'Pour conclure sa carrière, l\'inspecteur Somerset, vieux flic blasé, tombe à sept jours de la retraite sur un criminel peu ordinaire. John Doe, c\'est ainsi que se fait appeler l\'assassin, a decidé de nettoyer la societé des maux qui la rongent en commettant sept meurtres basés sur les sept pechés capitaux: la gourmandise, l\'avarice, la paresse, l\'orgueil, la luxure, l\'envie et la colère.','genre'=>'Thriller')
    );
    //die(var_dump($films));
    return $this->render('TroiswaPublicBundle:Films:films.html.twig',array('films'=>$films));
*/

        $em=$this->getDoctrine()->getManager();
        $films= $em->getRepository('TroiswaPublicBundle:Film')->findAll();
    //die(\Doctrine\Common\Util\Debug::dump($films));
        return $this->render('TroiswaPublicBundle:Films:films.html.twig',array('films'=>$films));
    }

    public function filmAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $film= $em->getRepository('TroiswaPublicBundle:Film')->find($id);
        return $this->render('TroiswaPublicBundle:Films:film.html.twig',array('film'=>$film));
    }
    public function ajouterAction(Request $request)
    {
        $film=new Film();
        $formfilm=$this->createForm(new FilmType(),$film)
            ->add('fichier', 'file')
            ->add('ajouter','submit');



        if ("POST" === $request->getMethod())
        {
            // die('POST');
            $formfilm->bind($request);
            if($formfilm->isvalid())
            {

                $film->upload();

                $em=$this->getDoctrine()->getManager();
                $em->persist($film);
                $em->flush();
                $session= $request->getSession();
                $session->getFlashBag()->add('info','Fiche Film crée');
                return $this->redirect($this->generateUrl('troiswa_admin_film'));
            }
        }
        return $this->render('TroiswaPublicBundle:Films:ajouter.html.twig', array('formfilm'=>$formfilm->createView()));

    }

    public function updateAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $film= $em->getRepository('TroiswaPublicBundle:Film')->find($id);

        $formfilm=$this->createForm(new FilmType(),$film)

            ->add('valider','submit');

        if ("POST" === $request->getMethod())
        {
            // die('POST');
            $formfilm->bind($request);
            if($formfilm->isvalid())
            {
                $film->upload();


                $em=$this->getDoctrine()->getManager();
                $em->persist($film);
                $em->flush();
                $session= $request->getSession();
                $session->getFlashBag()->add('info','film mis à jour');
                return $this->redirect($this->generateUrl('troiswa_admin_film_update', array('id' =>$film->getId())));
            }
        }

        return $this->render('TroiswaPublicBundle:Films:update.html.twig', array('formfilm'=>$formfilm->createView()));

    }


}


