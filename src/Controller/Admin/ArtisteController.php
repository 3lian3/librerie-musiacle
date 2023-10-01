<?php

namespace App\Controller\Admin;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtisteController extends AbstractController
{
    #[Route('/admin/artistes', name: 'admin_artistes', methods: ['GET'])]
    public function listeArtistes(ArtisteRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $artistes = $paginator->paginate(
            $repo->listeArtistesCompletePaginee(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            8 /*limit per page*/
        );

        return $this->render('admin/artiste/listeArtistes.html.twig', [
            'lesArtistes' => $artistes,
        ]);
    }

    #[Route('/admin/artiste/ajout', name: 'admin_artiste_ajout', methods: ['GET', 'POST'])]
    #[Route('/admin/artiste/modif/{id}', name: 'admin_artiste_modif', methods: ['GET', 'POST'])]
    public function ajoutModifArtistes(Artiste $artiste = null, Request $request, EntityManagerInterface $manager): Response
    {
        if ($artiste == null) {
            $artiste = new Artiste();
            $mode = "ajouté";
        } else {
            $mode = "modifié";
        }
        $form = $this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($artiste);
            $manager->flush();
            $this->addFlash('success', 'L\'artiste a bien été $mode');
            return $this->redirectToRoute('admin_artistes');
        }
        return $this->render('admin/artiste/formAjoutModifArtiste.html.twig', [
            'formArtiste' => $form->createView(),
        ]);
    }

    #[Route('/admin/artiste/suppression/{id}', name: 'admin_artiste_suppression', methods: ['GET'])]
    public function suppressionArtistes(Artiste $artiste, EntityManagerInterface $manager): Response
    {
        $nbAlbums = $artiste->getAlbums()->count();
        if ($nbAlbums > 0) {
            $this->addFlash("danger", "Impossible de supprimer cet artiste car $nbAlbums albums(s) y sont associés");

            // return $this->redirectToRoute('admin_artistes');
        } else {
            $manager->remove($artiste);
            $manager->flush();
            $this->addFlash('success', 'L\'artiste a bien été supprimé');
        }
        
        return $this->redirectToRoute('admin_artistes');
    }
}
