<?php

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\Exceptions\AlreadyExistsException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Requests\User\CreateUserRequest;
use App\Domain\Services\Models\User\CreateUserService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpInternalServerErrorException;

/**
 * @OA\Post(
 *     path="/api/users",
 *     @OA\RequestBody(
 *         description="User object",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Creates an User",
 *          @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 *     @OA\Response(response="400", description="Given arguments not passed trough validator."),
 *     @OA\Response(response="403", description="This user already existe"),
 *     @OA\Response(response="500", description="Repository (database) error")
 * )
 */
class CreateUserAction extends Action
{
    /**
     * @Inject
     * @var CreateUserService
     */
    private CreateUserService $createUserService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new CreateUserRequest(
            formData: $this->getFormData()
        );

        try {
            $user = $this->createUserService->create($request);
        } catch (AlreadyExistsException $e) {
            throw new HttpException($this->request, $e->getMessage(), 409);
        } catch (RepositorySaveException $e) {
            throw new HttpInternalServerErrorException($this->request, $e->getMessage());
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($this->request, $e->getErrors());
        }

        return $this->respondWithData($user);
    }
}