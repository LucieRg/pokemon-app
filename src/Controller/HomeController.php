<?php

namespace App\Controller;

use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PokeApiService;

class HomeController extends AbstractController
{
    private PokeApiService $pokeApiService;
    private EntityManagerInterface $entityManager;

    public function __construct(PokeApiService $pokeApiService, EntityManagerInterface $entityManager)
    {
        $this->pokeApiService = $pokeApiService;
        $this->entityManager = $entityManager;
    }

    #[Route('/home/{id}', name: 'app_home', defaults: ['id' => 1])]
    public function index(int $id): Response
    {
        $pokemons = $this->entityManager->getRepository(Pokemon::class)->findBy([], ['name' => 'ASC']);
        $totalPokemons = count($pokemons);
        $pokemon = $this->entityManager->getRepository(Pokemon::class)->find($id);

        return $this->render('home/index.html.twig', [
            'pokemons' => $pokemons,
            'totalPokemons' => $totalPokemons,
            'pokemon' => $pokemon,
        ]);
    }

    #[Route('/pokemon/search', name: 'pokemon_search', methods: ['POST'])]
    public function search(Request $request): Response
    {
        $searchTerm = $request->request->get('pokemonNameOrId');
        $pokemonRepository = $this->entityManager->getRepository(Pokemon::class);
        $pokemons = $pokemonRepository->createQueryBuilder('p')
            ->where('p.name LIKE :name')
            ->setParameter('name', $searchTerm . '%')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();

        if (empty($pokemons)) {
            return $this->redirectToRoute('app_home');
        }

        $pokemon = $pokemons[0];

        return $this->render('home/index.html.twig', [
            'pokemons' => $pokemons,
            'pokemon' => $pokemon,
            'totalPokemons' => count($pokemons),
        ]);
    }
}