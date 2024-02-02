<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{city}', name: 'app_weather', requirements: ['city' => '.+'])]
    public function city(
        string $city,
        LocationRepository $locationRepository,
        MeasurementRepository $measurementRepository
    ): Response
    {
        $location = $locationRepository->findOneByCityAndCountryCode($city);

        if (!$location) {
            throw $this->createNotFoundException('The location does not exist');
        }

        $measurements = $measurementRepository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
