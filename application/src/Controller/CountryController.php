<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Request\CountrySearchRequest;
use App\Form\CountrySearchType;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/")
 */
class CountryController extends AbstractController
{
    /**
     * @Route("/", name="country_search", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function index(Request $request): Response
    {
        $searchRequestModel = new CountrySearchRequest();
        $form = $this->createForm(CountrySearchType::class, $searchRequestModel);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // SHOW VALIDATE
            if (!$form->isValid()) {
                return $this->json($form->getErrors(true, true), 400);
            }

            /** @var CountryRepository $countryRepository */
            $countryRepository = $this->getDoctrine()->getRepository(Country::class);
            return $this->json([
                'data' => $countryRepository->search($form->getData())
            ]);
        }

        return $this->render('country/index.html.twig', [
            'country' => $searchRequestModel,
            'form' => $form->createView(),
        ]);
    }
}
