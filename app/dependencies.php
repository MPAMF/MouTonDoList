<?php
declare(strict_types=1);

use App\Domain\Auth\AuthInterface;
use App\Domain\Settings\SettingsInterface;
use App\Infrastructure\Security\Auth;
use App\Infrastructure\Security\CsrfExtension;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\DatabaseManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Csrf\Guard;
use Slim\Views\Twig;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\JsonFileLoader;
use Symfony\Component\Translation\Translator;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Twig::class => function (ContainerInterface $c) {
            // creates the Translator
            $translator = new Translator('fr');
            // somehow load some translations into it
            $translator->addLoader('json', new JsonFileLoader());

            // Add resources
            $translator->addResource(
                'json',
                __DIR__ . '/../resources/translations/translations.en.json',
                'en'
            );

            $translator->addResource(
                'json',
                __DIR__ . '/../resources/translations/translations.fr.json',
                'fr'
            );

            // PROD :  return Twig::create(__DIR__ . '/../src/Application/Views', ['cache' => __DIR__ . '/../var/cache']);
            $twig = Twig::create(__DIR__ . '/../src/Application/Views', ['cache' => false]);
            $twig->addExtension(new TranslationExtension($translator));
            //$twig->addExtension(new CsrfExtension($c->get('csrf')));
            return $twig;
        },
        Manager::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $capsule = new Manager;
            $capsule->addConnection($settings->get('db'));

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            return $capsule;
        },
        DatabaseManager::class => function (ContainerInterface $c) {
            $capsule = $c->get(Manager::class);
            return $capsule->getDatabaseManager();
        },
        Guard::class => function (ContainerInterface $c) {
            // Temp array to avoid session_start()
            // Session storage is then set in SessionMiddleware
            $array = array();
            return new Guard(
                $c->get(ResponseFactoryInterface::class),
                storage: $array
            );
        },
        AuthInterface::class => autowire(Auth::class)
    ]);
};
