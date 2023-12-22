<?php
// src/Controller/ClientController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController
{
    
 
    public function info($prenom): Response
    {
     
        return new Response('Prénom spécifié : ' . $prenom);
    }
    /**
     * Méthode affichée lorsque le site n'est pas ouvert.
     *
     * @return Response
     */
    public function ferme(): Response
    {
        return new Response("Nous sommes fermé");
    }
}