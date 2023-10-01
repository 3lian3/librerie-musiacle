<?php

namespace App\Controller\Admin;

use App\Entity\Style;
use App\Form\StyleType;
use App\Repository\StyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StyleController extends AbstractController
{
    #[Route('/admin/styles', name: 'admin_styles', methods: ['GET'])]
    public function listeArtistes(StyleRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $Styles = $paginator->paginate(
            $repo->listeStylesCompletePaginee(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('admin/Style/listeStyles.html.twig', [
            'lesStyles' => $Styles,
        ]);
    }

    #[Route('/admin/style/ajout', name: 'admin_style_ajout', methods: ['GET', 'POST'])]
    #[Route('/admin/style/modif/{id}', name: 'admin_style_modif', methods: ['GET', 'POST'])]
    public function ajoutModifArtistes(Style $style = null, Request $request, EntityManagerInterface $manager): Response
    {
        if ($style == null) {
            $style = new Style();
            $mode = "ajouté";
        } else {
            $mode = "modifié";
        }
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($style);
            $manager->flush();
            $this->addFlash('success', 'Le style a bien été $mode');
            return $this->redirectToRoute('admin_styles');
        }
        return $this->render('admin/style/formAjoutModifStyle.html.twig', [
            'formStyle' => $form->createView(),
        ]);
    }

    #[Route('/admin/style/suppression/{id}', name: 'admin_style_suppression', methods: ['GET'])]
    public function suppressionStyles(Style $style, EntityManagerInterface $manager): Response
    {
        $nbAlbums = $style->getAlbums()->count();
        if ($nbAlbums > 0) {
            $this->addFlash("danger", "Impossible de supprimer ce style car $nbAlbums albums(s) y sont associés");

            return $this->redirectToRoute('admin_styles');
        } else {
            $manager->remove($style);
            $manager->flush();
            $this->addFlash('success', 'Le style a bien été supprimé');
        }

        return $this->redirectToRoute('admin_styles');
    }
}
