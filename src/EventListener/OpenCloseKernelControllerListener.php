<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Routing\RouterInterface;
use App\Controller\ClientController;

class OpenCloseKernelControllerListener
{
    private $router;
    private $clientController;

    public function __construct(RouterInterface $router, ClientController $clientController)
    {
        $this->router = $router;
        $this->clientController = $clientController;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $currentRouteName = $event->getRequest()->attributes->get('_route');

        if ($currentRouteName === null) {
            return;
        }

        $currentRoute = $this->router->getRouteCollection()->get($currentRouteName);

        if ($currentRoute && $currentRouteName === 'client_prenom') {
            $options = $currentRoute->getOptions();
            $startHour = isset($options['startHour']) ? (int)$options['startHour'] : null;
            $endHour = isset($options['endHour']) ? (int)$options['endHour'] : null;

            if ($startHour !== null && $endHour !== null) {
                $currentHour = (int)date('G');

                if ($currentHour < $startHour || $currentHour >= $endHour) {
                    $event->setController([$this->clientController, 'ferme']);
                }
            }
        }
    }
}
?>