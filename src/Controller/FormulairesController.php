<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // Assurez-vous d'ajouter cette ligne
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormulairesController extends AbstractController
{
    #[Route('/formulaires', name: 'app_formulaires')]
    public function index(): Response
    {
        return $this->render('formulaires/index.html.twig', [
            'controller_name' => 'FormulairesController',
        ]);
    }

    #[Route('/handle_inscription', name: 'handle_inscription', methods: ['POST'])]
    public function handleInscription(Request $request): Response
    {
        // Récupérer les données du formulaire
        $nom = $request->request->get('nom');
        $email = $request->request->get('email');

        // Faire quelque chose avec les données (par exemple, les enregistrer en base de données)

        // Rediriger vers la page de confirmation en passant le nom comme paramètre
        return $this->redirectToRoute('confirmation1', ['nom' => $nom]);
    }

    #[Route('/confirmation1', name: 'confirmation1')]
    public function confirmation(Request $request): Response
    {
        // Récupérer le nom depuis les paramètres de la requête
        $nom = $request->query->get('nom');

        // Afficher le nom (vous pouvez également passer le nom à la vue Twig ici)
        return $this->render('formulaires/confirmation.html.twig', ['nom' => $nom]);
    }
}
