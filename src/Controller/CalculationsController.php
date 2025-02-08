<?php

namespace App\Controller;

use App\Entity\Calculation;
use App\Form\WeatherSearchType;
use App\Form\CalculationType;
use App\Service\WeatherService;
use App\Service\WeatherCalculationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/calculations', name: 'calculation_')]
class CalculationsController extends AbstractController
{
    private $weatherService;
    private $weatherCalculationService;
    private $logger;
    private $entityManager;

    public function __construct(WeatherService $weatherService, WeatherCalculationService $weatherCalculationService, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->weatherService = $weatherService;
        $this->weatherCalculationService = $weatherCalculationService;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    #[Route('/_overview', name: 'overview', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        // Create a fresh Calculation object
        $calculation = new Calculation();

        // Create the form
        $form = $this->createForm(CalculationType::class, $calculation);
        
        // Handle the form submission
        $form->handleRequest($request);
        
        // Fetch all calculations from the database using EntityManager
        $calculations = $this->entityManager->getRepository(Calculation::class)->findAll();

        // If form is submitted and valid, process the data
        if ($form->isSubmitted() && $form->isValid()) {
            $calculation = $form->getData();

            // Persist the calculation using EntityManager
            $this->entityManager->persist($calculation);
            $this->entityManager->flush();

            // Add a flash message
            $this->addFlash('success', 'Form submitted successfully!');

            // Redirect to the same route to avoid resubmission of the form
            return $this->redirectToRoute('calculation_overview');
        }

        // Render the form and calculations to the Twig template
        return $this->render('calculations/calculation-overview.html.twig', [
            'form' => $form->createView(),
            'calculations' => $calculations, // Pass the calculations to the template
        ]);
    }


    #[Route('/calculations', name: 'list', methods: ['GET'])]
    public function listCalculations(): Response
    {
        // Fetch all calculations from the database using EntityManager
        $calculations = $this->entityManager->getRepository(Calculation::class)->findAll();

        return $this->render('calculations/calculation-overview.html.twig', [
            'calculations' => $calculations,
            'form' => $this->createForm(CalculationType::class)->createView(),
        ]);
    }

    #[Route('/calculations/create', name: 'create', methods: ['POST'])]
    public function createCalculation(Request $request): Response
    {
        $calculation = new Calculation();
        $form = $this->createForm(CalculationType::class, $calculation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the calculation using EntityManager
            $this->entityManager->persist($calculation);
            $this->entityManager->flush();

            // Add a flash message indicating success
            $this->addFlash('success', 'Calculation created successfully!');

            // Redirect to calculation list after creation
            return $this->redirectToRoute('calculation_list');
        }

        // Render the form and the calculation list if form is not submitted or not valid
        return $this->render('calculations/calculation-overview.html.twig', [
            'form' => $form->createView(),
            'calculations' => $this->entityManager->getRepository(Calculation::class)->findAll(),
        ]);
    }

    #[Route('/calculations/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function editCalculation(Request $request, Calculation $calculation): Response
    {
        // Create the form and bind it to the Calculation object
        $form = $this->createForm(CalculationType::class, $calculation);
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Use EntityManager to flush the changes to the database
            $this->entityManager->flush();

            // Add a success flash message
            $this->addFlash('success', 'Calculation updated successfully!');

            // Redirect to the calculation list page after successful update
            return $this->redirectToRoute('calculation_list');
        }

        // Render the edit form with the calculation data
        return $this->render('calculations/edit-calculation.html.twig', [
            'form' => $form->createView(),
            'calculation' => $calculation, // Pass the calculation to the template
        ]);
    }


    #[Route('/calculations/delete/{id}', name: 'delete', methods: ['POST'])]
    public function deleteCalculation(Calculation $calculation): Response
    {
        // Remove the calculation using EntityManager
        $this->entityManager->remove($calculation);
        $this->entityManager->flush();

        $this->addFlash('success', 'Calculation deleted successfully!');
        return $this->redirectToRoute('calculation_list');
    }
}
