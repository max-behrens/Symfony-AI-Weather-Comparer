<?php

namespace App\Controller;

use App\Entity\Calculation;
use App\Form\WeatherSearchType;
use App\Form\CalculationType;
use App\Service\WeatherService;
use App\Service\WeatherCalculationService;
use App\Service\CalculationService;
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
    private $calculationService;
    private $logger;
    private $entityManager;

    public function __construct(
        WeatherService $weatherService, 
        WeatherCalculationService $weatherCalculationService,
        CalculationService $calculationService,
        LoggerInterface $logger, 
        EntityManagerInterface $entityManager
        )
    {
        $this->weatherService = $weatherService;
        $this->weatherCalculationService = $weatherCalculationService;
        $this->calculationService = $calculationService;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    #[Route('/calculations', name: 'list', methods: ['GET', 'POST'])]
    public function listCalculations(Request $request, CalculationService $calculationService): Response
    {
        // Create a fresh Calculation object.
        $calculation = new Calculation();
    
        // Create the form
        $form = $this->createForm(CalculationType::class, $calculation);
        
        // Handle the form submission.
        $form->handleRequest($request);
    
        // Get the current page (default is 1).
        $page = (int) $request->get('page', 1);
    
        // Get paginated calculations using the service method.
        $calculations = $calculationService->getCalculations($page);
    
        // Get the total number of calculations to calculate the total pages.
        $totalCalculations = $calculationService->getTotalCalculations();
        $limit = 5;
        $totalPages = ceil($totalCalculations / $limit);
    
        // If form is submitted and valid, process the data
        if ($form->isSubmitted() && $form->isValid()) {
            $calculation = $form->getData();
    
            // Persist the calculation using EntityManager
            $this->entityManager->persist($calculation);
            $this->entityManager->flush();
    
            // Add a flash message
            $this->addFlash('success', 'Form submitted successfully!');
    
            // Redirect to the same route to avoid resubmission of the form
            return $this->redirectToRoute('list');
        }
    
        // Render the form and calculations to the Twig template
        return $this->render('calculations/calculation-overview.html.twig', [
            'formSave' => $form->createView(),
            'calculations' => $calculations,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }
    


    #[Route('/calculations/create', name: 'create', methods: ['POST', 'GET'])]
    public function createCalculation(Request $request): Response
    {
        // Create a new Calculation object
        $calculation = new Calculation();

        // Create the form
        $formSave = $this->createForm(CalculationType::class, $calculation);

        // Handle the request (bind the form data to the $calculation object)
        $formSave->handleRequest($request);

        // Check if the form was submitted and is valid
        if ($formSave->isSubmitted() && $formSave->isValid()) {

            if (!$calculation->getCalculations()) {
                $temperatureChanges = $request->query->get('temperatureChanges', 'N/A');
                $averageTemperatureChanges = $request->query->get('averageTemperatureChanges', 'N/A');
                $humidityChanges = $request->query->get('humidityChanges', 'N/A');
                $averageHumidityChanges = $request->query->get('averageHumidityChanges', 'N/A');
                $pressureChanges = $request->query->get('pressureChanges', 'N/A');
                $averagePressureChanges = $request->query->get('averagePressureChanges', 'N/A');
                $city = $request->query->get('city', 'N/A');



                // Concatenate all parameters into a single formatted string
                $calculationsData = sprintf(
                    "Temperature Changes: %s\nAverage Temperature Changes: %s\nHumidity Changes: %s\nAverage Humidity Changes: %s\nPressure Changes: %s\nAverage Pressure Changes: %s",
                    $temperatureChanges,
                    $averageTemperatureChanges,
                    $humidityChanges,
                    $averageHumidityChanges,
                    $pressureChanges,
                    $averagePressureChanges
                );

                $calculation->setCalculations($calculationsData);
            }

            // Set the AI Response and Country (fallback if empty)
            if (!$calculation->getAiResponse()) {
                $temperatureExplanation = $request->query->get('temperatureExplanation', 'N/A');
                $humidityExplanation = $request->query->get('humidityExplanation', 'N/A');
                $pressureExplanation = $request->query->get('pressureExplanation', 'N/A');

                $aiResponseData = sprintf(
                    "Temperature Explanation: %s\nHumidity Explanation: %s\nPressure Explanation: %s",
                    $temperatureExplanation,
                    $humidityExplanation,
                    $pressureExplanation,
                );

                $calculation->setAiResponse($aiResponseData);
            }

            if (!$calculation->getCountry()) {
                $calculation->setCountry($request->query->get('city', 'N/A'));  // Set country (fallback to city from query params)
            }

            // Persist the entity
            $this->entityManager->persist($calculation);
            $this->entityManager->flush();

            // Add a success message
            $this->addFlash('success', 'Calculation created successfully!');

            // Redirect to another page (e.g., a list of calculations)
            return $this->redirectToRoute('calculation_list');
        }

        // Render the form view
        return $this->render('calculations/create-calculation.html.twig', [
            'formSave' => $formSave->createView(),
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
