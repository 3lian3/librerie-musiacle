<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlbumController extends AbstractController
{
    #[Route('/admin/albums', name: 'admin_albums', methods: ['GET'])]
    public function listeAlbums(AlbumRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $albums = $paginator->paginate(
            $repo->listeAlbumsCompletePaginee(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('admin/album/listeAlbums.html.twig', [
            'lesAlbums' => $albums,
        ]);
    }

    #[Route('/admin/album/ajout', name: 'admin_album_ajout', methods: ['GET', 'POST'])]
    #[Route('/admin/album/modif/{id}', name: 'admin_album_modif', methods: ['GET', 'POST'])]
    public function ajoutModifAlbums(Album $album = null, Request $request, EntityManagerInterface $manager): Response
    {
        if ($album == null) {
            $album = new Album();
            $mode = "ajouté";
        } else {
            $mode = "modifié";
        }
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on recupere l'image selectionnée
            $fichierImage = $form->get('imageFile')->getData();
            if($fichierImage !=null){
                //on supprime l'ancien fichier
                if($album->getImage() != "pochetteAlbum.jpg"){
                    \unlink($this->getParameter('imagesAlbumsDestination') . $album->getImage());
                }
                //on créer le nom du nouveau fichier
                $fichier=md5(\uniqid()) . "." . $fichierImage->guessExtension();
                //déplace le fichier charger dans le dossier public
                $fichierImage->move(
                    $this->getParameter('imagesAlbumsDestination'),
                    $fichier
                );
                $album->setImage($fichier);
            }
            $manager->persist($album);
            $manager->flush();
            $this->addFlash('success', 'L\'album a bien été $mode');
            return $this->redirectToRoute('admin_albums');
        }
        return $this->render('admin/album/formAjoutModifAlbum.html.twig', [
            'formAlbum' => $form->createView(),
        ]);
    }

    #[Route('/admin/album/suppression/{id}', name: 'admin_album_suppression', methods: ['GET'])]
    public function suppressionAlbums(Album $album, EntityManagerInterface $manager): Response
    {
        $nbMorceaux = $album->getMorceaux()->count();
        if ($nbMorceaux > 0) {
            $this->addFlash("danger", "Impossible de supprimer cet album car $nbMorceaux Morceau(x) y sont associés");
        } else {
            $manager->remove($album);
            $manager->flush();
            $this->addFlash('success', 'L\'album a bien été supprimé');
        }

        return $this->redirectToRoute('admin_albums');
    }
}
