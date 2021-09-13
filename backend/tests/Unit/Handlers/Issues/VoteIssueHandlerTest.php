<?php 

declare(strict_types=1);

namespace Tests\Unit\Application\Handlers\Auth;

use App\Application\Commands\Issues\VoteIssueCommand;
use App\Application\Handlers\Issues\VoteIssueHandler;
use App\Application\Services\CurrentUserService;
use App\Domain\Entities\Issue;
use App\Domain\Entities\User;
use App\Infrastructure\Persistence\MockRepositories\MockIssueRepository;
use DomainException;
use PHPUnit\Framework\TestCase;
use Tests\Utils\MockWebSocketService;

final class VoteIssueHandlerTest extends TestCase
{
    private VoteIssueHandler $sut;

    public function initialize(string $username)
    {
        $currentUserService = new CurrentUserService();
        $currentUserService->setUser(new User($username));

        $this->sut = new VoteIssueHandler(
            $currentUserService,
            new MockIssueRepository(),
            new MockWebSocketService()
        );
    }

    public function testCanVoteIssueWithValue(): void
    {
        $this->initialize('Agos');

        $command = new VoteIssueCommand(
            1,
            8
        );
        
        $result = $this->sut->handle($command);

        $this->assertEquals(
            new Issue(
                1,
                [
                    'David',
                    'Agos'
                ],
                [
                    [
                        'user' => 'David',
                        'status' => 'Voted',
                        'vote' => 8
                    ],
                    [
                        'user' => 'Agos',
                        'status' => 'Voted',
                        'vote' => 8
                    ],
                ],
                'Finished',
                8
                ),
                $result
        );
    }

    public function testCanVoteIssueWithPassed(): void
    {
        $this->initialize('Agos');

        $command = new VoteIssueCommand(
            1,
            '?'
        );
        
        $result = $this->sut->handle($command);

        $this->assertEquals(
            new Issue(
                1,
                [
                    'David',
                    'Agos'
                ],
                [
                    [
                        'user' => 'David',
                        'status' => 'Voted',
                        'vote' => 8
                    ],
                    [
                        'user' => 'Agos',
                        'status' => 'Passed',
                        'vote' => null
                    ],
                ],
                'Finished',
                8
                ),
                $result
        );
        
    }

    public function testCanNotVoteUnexistingIssue(): void
    {
        $this->initialize('Agos');

        $command = new VoteIssueCommand(
            3,
            8
        );
        
        $this->expectException(DomainException::class);
        
        $this->sut->handle($command);
    }

    public function testCanNotVoteNotJoinedIssue(): void
    {
        $this->initialize('NotJoinedUser');

        $command = new VoteIssueCommand(
            1,
            8
        );

        $this->expectException(DomainException::class);
        
        $this->sut->handle($command);
    }
}


