<?php
declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Handlers\FlashMessageHandler;
use App\Application\Handlers\RedirectHandler;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Models\User\User;
use Exception;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Symfony\Contracts\Translation\TranslatorInterface;
use Tagliatti\SlimValidation\ValidatorInterface;

abstract class Action
{
    use RedirectHandler, FlashMessageHandler;

    protected LoggerInterface $logger;

    protected Request $request;

    protected Response $response;

    protected array $args;

    protected Twig $twig;

    protected ResponseFactoryInterface $responseFactory;

    protected Messages $messages;

    protected TranslatorInterface $translator;

    protected ValidatorInterface $validator;

    public function __construct(
        LoggerInterface          $logger,
        Twig                     $twig,
        ResponseFactoryInterface $responseFactory,
        Messages                 $messages,
        TranslatorInterface      $translator,
        ValidatorInterface       $validator
    )
    {
        $this->logger = $logger;
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->messages = $messages;
        $this->translator = $translator;
        $this->validator = $validator;
    }

    /**
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    abstract protected function action(): Response;

    /**
     * @return array|object
     */
    protected function getFormData(): object|array
    {
        return $this->request->getParsedBody();
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function resolveArg(string $name): mixed
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }

    /**
     * @param object|array|null $data
     */
    protected function respondWithData(object|array $data = null, int $statusCode = 200): Response
    {
        $payload = new ActionPayload($statusCode, $data);

        return $this->respond($payload);
    }

    /**
     * @param ActionPayload $payload
     * @return Response
     */
    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        $this->response->getBody()->write($json);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->getStatusCode());
    }

    /**
     * @param string $viewPath
     * @param object|array|null $data
     * @return Response
     */
    protected function respondWithView(string $viewPath, object|array $data = null): Response
    {
        try {
            return $this->twig->render($this->response, $viewPath, $data);
        } catch (Exception $e) {
            throw new HttpInternalServerErrorException($this->request, $e->getMessage());
        }
    }

    /**
     * Get user from attribute (coming from AuthMiddleware)
     * returns null if user not set in attributes
     * @return User|null
     */
    protected function user(): ?User
    {
        return $this->request->getAttribute('user');
    }
}
