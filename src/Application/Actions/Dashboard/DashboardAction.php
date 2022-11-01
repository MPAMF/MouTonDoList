<?php
declare(strict_types=1);

namespace App\Application\Actions\Dashboard;

use App\Application\Actions\Action;
use DI\Container;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

abstract class DashboardAction extends Action
{
    protected Twig $twig;

    public function __construct(LoggerInterface $logger, Container $container)
    {
        parent::__construct($logger);
        $this->twig = $container->get('view');
    }
}
