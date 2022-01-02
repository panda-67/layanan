<?php

namespace App\Controller;

use App\Repository\LayananRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

#[Route('/search')]
class SearchController extends AbstractController
{
    #[Route(name: 'search_index')]
    public function index(): Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('search_result'))
            ->setMethod('POST')
            ->add('search_query', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Search...',],
            ])
            ->add('search', SubmitType::class, [
                'row_attr' => ['class' => 'position-absolute end-0'],
                'attr' => ['class' => 'btn btn-info'],
            ])->getForm();

        return $this->renderForm('search/index.html.twig', [            
            'form' => $form
        ]);
    }

    #[Route('/result', name: 'search_result', methods: ['GET', 'POST'])]
    public function search(Request $request, LayananRepository $layananRepository): Response
    {
        // dd($request->request);

        $search_query = $request->request->get('form')['search_query'];
        dd($search_query);
        if ($search_query) {
            $layanans = $layananRepository->search($search_query);
        }

        return $this->render('layanan/index.html.twig', [
            'layanans' => $layanans,
        ]);
    }
}
