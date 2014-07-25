<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\PublicBundle\Entity\Acteurs;
use Troiswa\PublicBundle\Form\ActeursType;


class ActeursController extends Controller
{


    public function acteursAction()
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
        $acteurs= $em->getRepository('TroiswaPublicBundle:Acteurs')->findAll();
        //die(\Doctrine\Common\Util\Debug::dump($films));
        return $this->render('TroiswaPublicBundle:Acteurs:acteurs.html.twig',array('acteurs'=>$acteurs));
    }

    public function acteurAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $acteur= $em->getRepository('TroiswaPublicBundle:Acteurs')->find($id);
        return $this->render('TroiswaPublicBundle:Acteurs:acteur.html.twig',array('acteur'=>$acteur));
    }

    public function ajouterAction(Request $request)
    {
        $acteur=new Acteurs();
        $formActeurs=$this->createFormBuilder($acteur)
                          ->add('prenom', 'text', array('required'=>false))
                          ->add('nom','text', array('required'=>false))
                          ->add('dateNaissance','datetime',array('required'=>false) )
                          ->add('nationalite','text',array('required'=>false))
                          ->add('sexe', 'choice',
                     array(
                    'choices' => array(0=>'femme', 1=>'homme'),
                    'expanded'=>true,
                    'data'=>0
                ))
                          ->add('biography','text', array('required'=>false))
                          ->add('ajouter','submit')
                          ->add('fichier', 'file')
                          ->getForm();


        if ("POST" === $request->getMethod())
        {
               // die('POST');
            $formActeurs->bind($request);
            if($formActeurs->isvalid())
            {

                $acteur->upload();

                $em=$this->getDoctrine()->getManager();
                $em->persist($acteur);
                $em->flush();
                $session= $request->getSession();
                $session->getFlashBag()->add('info','acteur crée');
                return $this->redirect($this->generateUrl('troiswa_admin_acteur'));
            }
        }
        return $this->render('TroiswaPublicBundle:Acteurs:ajouter.html.twig', array('formActeurs'=>$formActeurs->createView()));

    }

    public function updateacteurAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $acteur= $em->getRepository('TroiswaPublicBundle:Acteurs')->find($id);

        $formActeurs=$this->createForm(new ActeursType(),$acteur)

            ->add('valider','submit');

        if ("POST" === $request->getMethod())
        {
            // die('POST');
            $formActeurs->bind($request);
            if($formActeurs->isvalid())
            {
                $acteur->upload();


                $em=$this->getDoctrine()->getManager();
                $em->persist($acteur);
                $em->flush();
                $session= $request->getSession();
                $session->getFlashBag()->add('info','acteur mis à jour');
                return $this->redirect($this->generateUrl('troiswa_admin_acteur_update', array('id' =>$acteur->getId())));
            }
        }

        return $this->render('TroiswaPublicBundle:Acteurs:update.html.twig', array('formActeurs'=>$formActeurs->createView()));

    }

}