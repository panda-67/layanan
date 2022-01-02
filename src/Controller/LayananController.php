<?php

namespace App\Controller;

use App\Entity\Layanan;
use App\Form\LayananType;
use App\Form\SearchType;
use App\Repository\LayananRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/layanan')]
class LayananController extends AbstractController
{
    #[Route('/', name: 'layanan_index', methods: ['GET'])]
    public function index(LayananRepository $layananRepository): Response
    {                
        return $this->renderForm('layanan/index.html.twig', [
            'title' => 'Layanan',
            'layanans' => $layananRepository->Layanans(),
            'statistic' => $layananRepository->Statistic(),
            'mapping' => $layananRepository->Mapping(),
        ]);
    }
    
    #[Route('/new', name: 'layanan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $layanan = new Layanan();
        $form = $this->createForm(LayananType::class, $layanan);
        $form->handleRequest($request);
        $slugName = $form->get('name')->getData();
        $lslug = str_replace(' ', '-', strtolower($slugName));

        $file = $form->get('image')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            if ($file) {
                $newFilename = $lslug . '-' . uniqid() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('img_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $layanan->setImage($newFilename);
            }
            $layanan->setCreated(new \DateTime('now'));
            $entityManager->persist($layanan);
            $entityManager->flush();
            return $this->redirectToRoute('layanan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('layanan/new.html.twig', [
            'layanan' => $layanan,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'layanan_show', methods: ['GET'])]
    public function show(Layanan $layanan): Response
    {
        return $this->render('layanan/show.html.twig', [
            'layanan' => $layanan,
        ]);
    }

    #[Route('/{id}/edit', name: 'layanan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Layanan $layanan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LayananType::class, $layanan);
        $form->handleRequest($request);
        $slugName = $form->get('name')->getData();
        $lslug = str_replace(' ', '-', strtolower($slugName));

        $file = $form->get('image')->getData();
        $fs = new Filesystem();
        if ($form->isSubmitted() && $form->isValid()) {
            if ($file) {
                $fname = $layanan->getImage();
                $fs->remove($this->getParameter('public_dir') . '/img/' . $fname);
                $newFilename = $lslug . '-' . uniqid() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('img_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $layanan->setImage($newFilename);
            }
            $layanan->setUpdated(new \DateTime('now'));
            $entityManager->flush();
            return $this->redirectToRoute('layanan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('layanan/edit.html.twig', [
            'layanan' => $layanan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'layanan_delete', methods: ['POST'])]
    public function delete(Request $request, Layanan $layanan, EntityManagerInterface $entityManager): Response
    {
        $fs = new Filesystem();
        if ($layanan->getImage()) {
            $fname = $layanan->getImage();
            $fs->remove($this->getParameter('public_dir') . '/img/' . $fname);
        }
        if ($this->isCsrfTokenValid('delete' . $layanan->getId(), $request->request->get('_token'))) {
            $entityManager->remove($layanan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('layanan_index', [], Response::HTTP_SEE_OTHER);
    }
}
