<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction()
    {

        $em=$this->getDoctrine()->getManager();
        $allFilmsCategorie=$em->getRepository('TroiswaPublicBundle:Film')->getNBFilmByCategorie();

        return $this->render('TroiswaPublicBundle:Main:index.html.twig', array('allFilmsCategorie'=>$allFilmsCategorie));
    }

    public function troiswaAction()
    {
        $em=$this->getDoctrine()->getManager();
        $allFilmsCategorie=$em->getRepository('TroiswaPublicBundle:Film')->getNBFilmByCategorie();

        return $this->render('TroiswaPublicBundle:Main:bonjour.html.twig');

    }
    public function ageAction($number)
    {
        return $this->render('TroiswaPublicBundle:Main:age.html.twig',array('mon_age'=>$number));
    }
    public function competenceAction()
    {
        $competences=array('php' => array('note'=>10, 'couleur'=>'#66cc66'),'html' => array('note'=>7, 'couleur'=>'red'),'css' => array('note'=>8, 'couleur'=>'blue'),'js' => array('note'=>9, 'couleur'=>'green'));

        return $this->render('TroiswaPublicBundle:Main:competence.html.twig',array('competences'=>$competences));

    }
    public function contactAction(Request $request)
    {
        $formcontact= $this->createFormBuilder()
                            ->add('name')
                            ->add('email')
                            ->add('phone')
                            ->add('message','textarea')
                            ->add('ajouter','submit')
                            ->getForm()
         ;

        if ("POST" === $request->getMethod())
        {
            // die('POST');
            $formcontact->bind($request);
            if($formcontact->isvalid())
            {
                $email=$formcontact->get('email')->getData();
                $name=$formcontact->get('name')->getData();
                $mail= \Swift_Message::newInstance()
                        ->setSubject('Formulaire de contact')
                        ->setFrom($email)
                        ->setTo("exemple@laposte")
                        ->setBody($this->renderView('TroiswaPublicBundle:Mail:contact.html.twig', array('name'=>$name)));

                $this->get('mailer')->send($mail);
                $session= $request->getSession();
                $session->getFlashBag()->add('info','Formulaire envoyé');
                return $this->redirect($this->generateUrl('troiswa_public_contact'));
            }
        }

        return $this->render('TroiswaPublicBundle:Main:contact.html.twig', array('formcontact'=>$formcontact->createView()));



    }



}
