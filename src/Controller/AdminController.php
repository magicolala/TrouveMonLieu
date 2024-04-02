<?php 

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/cities', name: 'admin_cities')]
    public function cities(CityRepository $cityRepository): Response
    {
        $cities = $cityRepository->findAll();

        return $this->render('admin/cities.html.twig', [
            'cities' => $cities,
        ]);
    }

    #[Route('/city/new', name: 'admin_city_new', methods: ['GET', 'POST'])]
    public function newCity(Request $request, CityRepository $cityRepository): Response
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cityRepository->save($city, true);

            return $this->redirectToRoute('admin_cities');
        }

        return $this->render('admin/city_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/city/{id}/edit', name: 'admin_city_edit', methods: ['GET', 'POST'])]
    public function editCity(Request $request, City $city, CityRepository $cityRepository): Response
    {
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cityRepository->save($city, true);

            return $this->redirectToRoute('admin_cities');
        }

        return $this->render('admin/city_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/city/{id}/delete', name: 'admin_city_delete', methods: ['POST'])]
    public function deleteCity(Request $request, City $city, CityRepository $cityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$city->getId(), $request->request->get('_token'))) {
            $cityRepository->remove($city, true);
        }

        return $this->redirectToRoute('admin_cities');
    }

    #[Route("/game/{id}", name: "admin_city_play", methods: "GET")]
    public function play(City $city): Response
    {
        if (!$city) {
            throw $this->createNotFoundException('La ville demandée n\'existe pas.');
        }

        return $this->render('app/index.html.twig', [
            'city' => $city,
        ]);
    }
}
