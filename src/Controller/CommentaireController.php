<?php

namespace App\Controller;

use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commentaire;
use Doctrine\ORM\EntityManagerInterface;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function createComm(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder()
        ->add('name')
        ->add('email')
        ->add('comment')
        ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $data = $form->getData();
            $comm = new Commentaire;
            $comm -> setName($data['name']);
            $comm -> setEmail($data['email']);
            $comm -> setComment($data['comment']);
            $em->persist($comm);
            $em->flush();
        }
        return $this->render('commentaire/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
