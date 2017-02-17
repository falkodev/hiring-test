<?php

namespace FalkoDev\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FalkoDev\UtilisateurBundle\Entity\Utilisateur;
use FalkoDev\UtilisateurBundle\Form\UtilisateurType;
use FalkoDev\UtilisateurBundle\Form\UtilisateurEditType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateurs = $em->getRepository('FalkoDevUtilisateurBundle:Utilisateur')->findAll();
        return $this->render('FalkoDevUtilisateurBundle:Default:index.html.twig', array('utilisateurs' => $utilisateurs));
    }
    
    public function creerAction(Request $request)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(new UtilisateurType(), $utilisateur);

        if ($form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($utilisateur);
          $em->flush();

          $request->getSession()->getFlashBag()->add('success', 'Utilisateur créé');

          return $this->redirect($this->generateUrl('modifierUtilisateur', array('id' => $utilisateur->getId())));
        }

        return $this->render('FalkoDevUtilisateurBundle:Default:user.html.twig', array('form' => $form->createView(),
                                                                                    'type' => 'création'));
    }
    
    public function modifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('FalkoDevUtilisateurBundle:Utilisateur')->find($id);

        if (null === $utilisateur) {
          throw new NotFoundHttpException("L'utilisateur ".$id." n'existe pas");
        }

        $form = $this->createForm(new UtilisateurEditType(), $utilisateur);
        if ($form->handleRequest($request)->isValid()) {
            if ($form->get('delete')->isClicked()) {
                return $this->redirect($this->generateUrl('supprimerUtilisateur', array('id' => $id)));
            }
          $em->flush();
          $request->getSession()->getFlashBag()->add('success', 'Utilisateur modifié');
          return $this->redirect($this->generateUrl('modifierUtilisateur', array('id' => $utilisateur->getId())));
        }

        return $this->render('FalkoDevUtilisateurBundle:Default:user.html.twig', array('form' => $form->createView(),
                                                                                        'type' => 'modification',
                                                                                        'utilisateur' => $utilisateur));
    }
    
    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('FalkoDevUtilisateurBundle:Utilisateur')->find($id);
        if (null === $utilisateur) {
          throw new NotFoundHttpException("L'utilisateur ".$id." n'existe pas.");
        }
        
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'utilisateur contre cette faille
        $form = $this->createFormBuilder()->getForm();
        if ($form->handleRequest($request)->isValid()) {
          $em->remove($utilisateur);
          $em->flush();
          $request->getSession()->getFlashBag()->add('success', "Utilisateur supprimé");
          return $this->redirect($this->generateUrl('liste'));
        }

        // On affiche une page de confirmation avant de supprimer
        return $this->render('FalkoDevUtilisateurBundle:Default:user.html.twig', array(
            'form' => $form->createView(),
            'utilisateur' => $utilisateur,
            'type' => 'suppression',
            'message' => "Confirmez-vous la suppression de l'utilisateur $id ?"));
    }
}
