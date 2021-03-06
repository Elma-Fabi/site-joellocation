<?php

namespace App\Controller;

use App\Entity\Options;
use App\Form\OptionsType;
use App\Repository\OptionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OptionsController extends AbstractController
{

    private $optionsRepo;


    public function __construct(OptionsRepository $optionsRepo)
    {

        $this->optionsRepo = $optionsRepo;
    }

    /**
     * @Route("backoffice/options", name="options_index")
     */
    public function index(): Response
    {
        $options = $this->optionsRepo->findAll();

        return $this->render('admin/options/index.html.twig', [
            'options' => $options
        ]);
    }

    /**
     * @Route("backoffice/options/liste", name="listeOptions", methods={"GET"})
     */
    public function listeOptions(Request $request)
    {
        $data = array();
        $options = $this->optionsRepo->findAll();

        foreach ($options as $key => $option) {

            $data[$key]['id'] = $option->getId();
            $data[$key]['appelation'] = $option->getAppelation();
            $data[$key]['prix'] = $option->getPrix();
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("backoffice/options/new", name="options_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $option = new Options();
        $form = $this->createForm(OptionsType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($option);
            $entityManager->flush();

            return $this->redirectToRoute('options_index');
        }

        return $this->render('admin/options/new.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("backoffice/options/{id}", name="options_show", methods={"GET"})
     */
    public function show(Options $option): Response
    {
        return $this->render('admin/options/show.html.twig', [
            'option' => $option,
        ]);
    }

    /**
     * @Route("backoffice/options/{id}/edit", name="options_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Options $option): Response
    {
        $form = $this->createForm(OptionsType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('options_index');
        }

        return $this->render('admin/options/edit.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("backoffice/options/{id}", name="options_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Options $option): Response
    {
        if ($this->isCsrfTokenValid('delete' . $option->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($option);
            $entityManager->flush();
        }

        return $this->redirectToRoute('options_index');
    }
}
