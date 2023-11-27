<?php

// src/Controller/ImageController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class ImageController extends AbstractController
{
    /**
     * @Route("/image/home", name="image_home")
     */
    public function home(): Response
    {
        return $this->render('image/home.html.twig');
    }
   /**
    * @Route("/data/Images/{reference)}" ,name="image_affiche" )
    */
    public function affiche(string $reference):BinaryFileResponse
    {
        $cheminImage = $this->getParameter('kernel.project_dir') . '/data/Images/' . $reference;

        // Vérifier si le fichier existe
        if (!file_exists($cheminImage)) {
            // Gérer l'erreur si l'image n'existe pas
            throw $this->createNotFoundException('L\'image n\'existe pas.');
        }

        // Utiliser BinaryFileResponse pour renvoyer le fichier en tant que réponse
        $response = new BinaryFileResponse($cheminImage);

        // Ajouter un en-tête Content-Type
        $response->headers->set('Content-Type', 'image/jpg'); // Remplacez par le type MIME correct

        // Ajouter un en-tête pour afficher l'image dans le navigateur
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE);

        return $response;
    }
    
        public function menu(): Response
        {
            $directory = $this->getParameter('kernel.project_dir') . '/data/Images';
            $files = scandir($directory);

            $images = array_filter($files, function ($file) use ($directory) {
                return !is_dir($directory . '/' . $file);
            });

            return $this->render('image/menu.html.twig', [
                'images' => $images,
            ]);
    
}
}

