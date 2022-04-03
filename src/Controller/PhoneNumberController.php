<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Repository\PhoneValidatorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PhoneNumberController extends AbstractController
{

  /**
   * @Route("/phonenumbers", name="list_phone_numbers")
   * @return Response
   */
  public function index(
    CustomerRepository $customerRepository,
    PhoneValidatorRepository $phoneValidatorRepository,
    PaginatorInterface $paginator,
    Request $request): Response
  {
    $allAvailableCountries = $phoneValidatorRepository->findAll();
    $pagination = $paginator->paginate(
      $customerRepository->findCustomersPhoneNumbers($request->query->all()), /* query NOT result */
      $request->query->getInt('page', 1)/*page number*/,
      10/*limit per page*/
    );

    return $this->render('Phone_number/index.html.twig',
      [
        'pagination' => $pagination,
        'countries'  => $allAvailableCountries,
        'parameters' => $request->query->all()
      ]);
  }

}