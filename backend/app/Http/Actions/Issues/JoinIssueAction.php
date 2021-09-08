<?php

declare(strict_types=1);

namespace App\Http\Actions\Issues;

use App\Application\Commands\Issues\JoinIssueCommand;
use App\Application\Exceptions\InvalidBodyException;
use App\Application\Handlers\Issues\JoinIssueHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class JoinIssueAction
{
    private const ISSUE_PARAM = 'issue';
    
    public function __construct(
        private JoinIssueHandler $handler,
    ) { }
    
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        if (key_exists(self::ISSUE_PARAM, $args)) {
            $number = $args[self::ISSUE_PARAM] ?: null;
        } else {
            throw new InvalidBodyException('Missing argument: ' . self::ISSUE_PARAM);
        }
        
        if (!$number) {
            throw new InvalidBodyException('Missing argument: ' . self::ISSUE_PARAM);
        }

        $this->handler->handle(new JoinIssueCommand(
                (int) $number
            )
        );
        return $response;
    }
}