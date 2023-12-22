<?php
// src/Controller/RegistrationController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/register", name="account_register")
     */
    public function register(Request $request, SessionInterface $session): Response
    {
        $request->setlocale($request->getPreferredLanguage()) ;
        $formData = [];

        $form = $this->createFormBuilder($formData)
            ->add('email')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => $this->translator->trans('Les mots de passe ne correspondent pas'),
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => $this->translator->trans('Mot de passe')],
                'second_options' => ['label' => $this->translator->trans('Répéter le mot de passe')],
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/',
                        'message' => $this->translator->trans('Entrez un mot de passe fort'),
                    ]),
                ],
            ])
            ->getForm();

            // Définir la locale du traducteur sur la langue du navigateur


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            // Vérifier si le mot de passe est correct (ajoutez votre logique ici)
            if ($this->isPasswordValid($formData['password'])) {
                // Stocker dans la session
                $session->set('login', $formData['email']);
                $session->set('password', $formData['password']);

                // Rediriger vers la page de confirmation
                return $this->redirectToRoute('account_confirmation');
            }

            // Mot de passe incorrect, vous pouvez ajouter un message d'erreur au formulaire
            $form->addError(new \Symfony\Component\Form\FormError('Mot de passe incorrect.'));
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/confirmation", name="account_confirmation")
     */
    public function confirmation(SessionInterface $session)
    {
        // Récupérer l'adresse e-mail depuis la session
        $userEmail = $session->get('login');

        return $this->render('registration/confirmation.html.twig', [
            'login' => $userEmail,
        ]);
    }

    /**
     * Vérifier si le mot de passe est valide (ajoutez votre logique de validation ici)
     */
    private function isPasswordValid($password)
    {
        // Ajoutez votre logique de validation de mot de passe ici
        // Par exemple, vérifiez s'il répond à certaines conditions

        return true; // Remplacez cela par votre logique réelle
    }
}
