<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Pokemon;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PokemonController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    #[Route('/pokemon/add', name: 'pokemon_add_form', methods: ['GET'])]
    public function addForm(): Response
    {
        return $this->render('pokemon/add.html.twig', [
            'isEdit' => false,
        ]);
    }

    #[Route('/pokemon/add', name: 'pokemon_add', methods: ['POST'])]
    public function add(Request $request): Response
    {
        $pokemon = new Pokemon();
        $this->handlePokemonData($request, $pokemon);

        $errors = $this->validator->validate($pokemon);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }
            return $this->redirectToRoute('pokemon_add_form');
        }

        $this->entityManager->persist($pokemon);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_home', [
            'successMessage' => 'Pokémon added successfully!'
        ]);
    }

    #[Route('/pokemon/edit/{id}', name: 'pokemon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        $pokemon = $this->entityManager->getRepository(Pokemon::class)->find($id);

        if (!$pokemon) {
            throw $this->createNotFoundException('Pokémon not found.');
        }

        if ($request->isMethod('POST')) {
            $this->handlePokemonData($request, $pokemon);

            $errors = $this->validator->validate($pokemon);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
                return $this->redirectToRoute('pokemon_edit', ['id' => $id]);
            }

            $this->entityManager->flush();
            return $this->redirectToRoute('app_home', ['successMessage' => 'Pokémon updated successfully!']);
        }

        return $this->render('pokemon/add.html.twig', [
            'pokemon' => $pokemon,
            'isEdit' => true,
        ]);
    }

    #[Route('/pokemon/delete/{id}', name: 'pokemon_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        $pokemon = $this->entityManager->getRepository(Pokemon::class)->find($id);

        if ($pokemon) {
            $this->entityManager->remove($pokemon);
            $this->entityManager->flush();
            $this->addFlash('success', 'Pokémon deleted successfully!');
        } else {
            $this->addFlash('error', 'Pokémon not found.');
        }

        return $this->redirectToRoute('app_home');
    }

    private function handlePokemonData(Request $request, Pokemon $pokemon): void
    {
        $pokemon->setName($request->request->get('name'));
        $pokemon->setHeight((int)$request->request->get('height'));
        $pokemon->setWeight((int)$request->request->get('weight'));
        $pokemon->setTypes(explode(',', $request->request->get('types')));
        $pokemon->setAbilities(explode(',', $request->request->get('abilities')));
        $pokemon->setImageUrl($request->request->get('imageUrl'));
    }
}
