<?php
declare(strict_types=1);

namespace Tests\Application\Actions;

use App\Application\Actions\Action;
use App\Application\Actions\ActionPayload;
use DateTimeImmutable;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Symfony\Contracts\Translation\TranslatorInterface;
use Tagliatti\SlimValidation\ValidatorInterface;
use Tests\TestCase;

class ActionTest extends TestCase
{
/*    public function testActionSetsHttpCodeInRespond()
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $logger = $container->get(LoggerInterface::class);
        $twig = $container->get(Twig::class);
        $responseFactory = $container->get(ResponseFactoryInterface::class);
        $messages = $container->get(Messages::class);
        $translator = $container->get(TranslatorInterface::class);
        $validator = $container->get(ValidatorInterface::class);

        $testAction = new class($logger, $twig, $responseFactory, $messages, $translator, $validator) extends Action {
            public function __construct(
                LoggerInterface          $logger,
                Twig                     $twig,
                ResponseFactoryInterface $responseFactory,
                Messages                 $messages,
                TranslatorInterface      $translator,
                ValidatorInterface       $validator
            ) {
                parent::__construct($logger, $twig, $responseFactory, $messages, $translator, $validator);
            }

            public function action(): Response
            {
                return $this->respond(
                    new ActionPayload(
                        202,
                        [
                            'willBeDoneAt' => (new DateTimeImmutable())->format(DateTimeImmutable::ATOM)
                        ]
                    )
                );
            }
        };

        $app->get('/test-action-response-code', $testAction);
        $request = $this->createRequest('GET', '/test-action-response-code');
        $response = $app->handle($request);

        $this->assertEquals(202, $response->getStatusCode());
    }

    public function testActionSetsHttpCodeRespondData()
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $logger = $container->get(LoggerInterface::class);
        $twig = $container->get(Twig::class);
        $responseFactory = $container->get(ResponseFactoryInterface::class);
        $messages = $container->get(Messages::class);
        $translator = $container->get(TranslatorInterface::class);
        $validator = $container->get(ValidatorInterface::class);

        $testAction = new class($logger, $twig, $responseFactory, $messages, $translator, $validator) extends Action {
            public function __construct(
                LoggerInterface          $logger,
                Twig                     $twig,
                ResponseFactoryInterface $responseFactory,
                Messages                 $messages,
                TranslatorInterface      $translator,
                ValidatorInterface       $validator
            ) {
                parent::__construct($logger, $twig, $responseFactory, $messages, $translator, $validator);
            }

            public function action(): Response
            {
                return $this->respondWithData(
                    [
                        'willBeDoneAt' => (new DateTimeImmutable())->format(DateTimeImmutable::ATOM)
                    ],
                    202
                );
            }
        };

        $app->get('/test-action-response-code', $testAction);
        $request = $this->createRequest('GET', '/test-action-response-code');
        $response = $app->handle($request);

        $this->assertEquals(202, $response->getStatusCode());
    }*/
}
