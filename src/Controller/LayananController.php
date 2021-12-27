<?php

namespace App\Controller;

use App\Entity\Layanan;
use App\Form\LayananType;
use App\Repository\LayananRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

// #[Route('/layanan')]
class LayananController extends AbstractController
{
    #[Route('/', name: 'layanan_index', methods: ['GET'])]
    public function index(LayananRepository $layananRepository): Response
    {
        return $this->render('layanan/index.html.twig', [
            'layanans' => $layananRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'layanan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $layanan = new Layanan();
        $form = $this->createForm(LayananType::class, $layanan);
        $form->handleRequest($request);
        $layanan->setCreated(new \DateTime('now'));
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
            // dd($layanan);
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
    public function show(Layanan $layanan, $slug): Response
    {
        return $this->render('layanan/show.html.twig', [
            'layanan' => $layanan,
            'slug' => $slug,
        ]);
    }

    #[Route('/{id}/edit', name: 'layanan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Layanan $layanan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LayananType::class, $layanan);
        $form->handleRequest($request);
        $layanan->setUpdated(new \DateTime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            // dd($layanan);
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
        if ($this->isCsrfTokenValid('delete' . $layanan->getId(), $request->request->get('_token'))) {
            $entityManager->remove($layanan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('layanan_index', [], Response::HTTP_SEE_OTHER);
    }
}
