<?php

namespace App\Command;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetCustomerPhoneStateCommand extends Command
{
  /** @var CustomerRepository $customerRepository */
  private $customerRepository;

  /** @var EntityManager $entityManager */
  private $entityManager;

  // the name of the command (the part after "bin/console")
  protected static $defaultName = 'customer:set-phone-state';

  public function __construct(CustomerRepository $customerRepository, ContainerInterface $container)
  {
    $this->customerRepository = $customerRepository;
    $this->entityManager = $container->get('doctrine')->getManager();
    parent::__construct();
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $customersQuery = $this->customerRepository->findCustomersPhoneNumbers();
    $customers = $customersQuery->getQuery()->execute();
    foreach ($customers as $customer) {
      $phoneRegex = $customer['regex'];
      $isValidPhoneNumber = preg_match(sprintf('/%s/', $phoneRegex), $customer['phone']);
      /** @var Customer $customerObject */
      $customerObject = $this->customerRepository->find($customer['id']);
      $customerObject->setState($isValidPhoneNumber);
      $this->entityManager->persist($customerObject);
      $output->writeln(sprintf('<info> [%s] </info> <comment>[%s]</comment>', $customer['phone'], $isValidPhoneNumber));
    }
    $this->entityManager->flush();

    $output->writeln('### FINISHED ###');
    return 0;
  }

}