<?php

namespace App\Controller;

use App\Domain\Command\PutKeyValue;
use Drift\CommandBus\Bus\CommandBus;
use React\Http\Message\Response;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\Request;
use function React\Promise\resolve;

/**
 * Class PutKeyValueController
 *
 * PUT /values/{key}/{value}
 */
class PutKeyValueController
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
     * @param string $value
     *
     * @return PromiseInterface
     */
    public function __invoke(
        Request $request,
        string $key,
        string $value
    ) : PromiseInterface
    {
        $command = new PutKeyValue($key, $value);

        return $this
            ->commandBus
            ->execute($command)
            ->then(function() {
                return new Response();
            });
    }
}
