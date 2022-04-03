<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;


class PhoneNumberApiController extends AbstractFOSRestController
{

  /**
   * @Rest\Get("/api/phonenumbers")
   * this action was a trial for another solution, but didn't go for it
   *
   * @param Request $request
   * @return \FOS\RestBundle\View\View
   */
  public function getAction(Request $request, CustomerRepository $customerRepository, PaginatorInterface $paginator)
  {
    $page = $request->query->get('page', 1);

    $pagination = $paginator->paginate(
      $customerRepository->findCustomersPhoneNumbers( $request->query->all()), /* query NOT result */
      $request->query->getInt('page', $page)/*page number*/,
      10/*limit per page*/
    );

    return $this->view($pagination);
  }

}