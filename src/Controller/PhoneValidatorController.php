<?php

namespace App\Controller;

use App\Entity\PhoneValidator;
use App\Form\PhoneValidatorType;
use App\Repository\PhoneValidatorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/phone/validator")
 */
class PhoneValidatorController extends AbstractController
{
    /**
     * @Route("/", name="app_phone_validator_index", methods={"GET"})
     */
    public function index(PhoneValidatorRepository $phoneValidatorRepository): Response
    {
        return $this->render('phone_validator/index.html.twig', [
            'phone_validators' => $phoneValidatorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_phone_validator_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PhoneValidatorRepository $phoneValidatorRepository): Response
    {
        $phoneValidator = new PhoneValidator();
        $form = $this->createForm(PhoneValidatorType::class, $phoneValidator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phoneValidatorRepository->add($phoneValidator);
            return $this->redirectToRoute('app_phone_validator_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('phone_validator/new.html.twig', [
            'phone_validator' => $phoneValidator,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_phone_validator_show", methods={"GET"})
     */
    public function show(PhoneValidator $phoneValidator): Response
    {
        return $this->render('phone_validator/show.html.twig', [
            'phone_validator' => $phoneValidator,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_phone_validator_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PhoneValidator $phoneValidator, PhoneValidatorRepository $phoneValidatorRepository): Response
    {
        $form = $this->createForm(PhoneValidatorType::class, $phoneValidator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phoneValidatorRepository->add($phoneValidator);
            return $this->redirectToRoute('app_phone_validator_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('phone_validator/edit.html.twig', [
            'phone_validator' => $phoneValidator,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_phone_validator_delete", methods={"POST"})
     */
    public function delete(Request $request, PhoneValidator $phoneValidator, PhoneValidatorRepository $phoneValidatorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$phoneValidator->getId(), $request->request->get('_token'))) {
            $phoneValidatorRepository->remove($phoneValidator);
        }

        return $this->redirectToRoute('app_phone_validator_index', [], Response::HTTP_SEE_OTHER);
    }
}
