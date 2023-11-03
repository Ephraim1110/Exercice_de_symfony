<?php
// src/Controller/ClientController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController
{
    /**
     * @Route("/client/prenom/{prenom}", name="client_prenom", methods={"GET", "HEAD"})
     */
    public function info($prenom): Response
    {
        if (strpos($prenom, '-') !== false) {
            // Le prénom contient un tiret, renvoyez un message d'erreur
            $errorResponse = new Response('Le prénom ne doit pas contenir de tirets.');
            $errorResponse->setStatusCode(Response::HTTP_BAD_REQUEST); // Code d'erreur 400 Bad Request
            return $errorResponse;
        }
        return new Response('Prénom spécifié : ' . $prenom);
    }
}
