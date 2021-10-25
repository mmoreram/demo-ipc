<?php

namespace App\Controller;

use App\Domain\Command\DeleteKeyValue;
use Drift\CommandBus\Bus\CommandBus;
use React\Http\Message\Response;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PutKeyValueController
 *
 * DELETE /values/{key}
 */
class DeleteKeyValueController
{
    private CommandBus $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @param string $key
     *
     * @return PromiseInterface
     */
    public function __invoke(
        Request $request,
        string $key
    ) : PromiseInterface
    {
        $command = new DeleteKeyValue($key);

        return $this
            ->commandBus
            ->execute($command)
            ->then(function() {
                return new Response();
            });
    }
}
