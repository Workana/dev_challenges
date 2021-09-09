<?php 

declare(strict_types=1);

namespace Tests\Unit\Application\Handlers\Auth;

use App\Application\Commands\Issues\JoinIssueCommand;
use App\Application\Handlers\Issues\JoinIssueHandler;
use App\Application\Services\CurrentUserService;
use App\Domain\Entities\Issue;
use App\Domain\Entities\User;
use App\Infrastructure\Persistence\MockRepositories\MockIssueRepository;
use Assert\AssertionFailedException;
use DomainException;
use PHPUnit\Framework\TestCase;
use Tests\Utils\MockWebSocketService;

final class JoinIssueHandlerTest extends TestCase
{
    private JoinIssueHandler $sut;

    public function initialize(?string $name = 'AnotherUser')
    {
        $currentUserService = new CurrentUserService();
        $currentUserService->setUser(new User($name));

        $this->sut = new JoinIssueHandler(
            $currentUserService,
            new MockIssueRepository(),
            new MockWebSocketService()
        );
    }

    public function testCanJoinIssue(): void
    {
        $this->initialize();

        $command = new JoinIssueCommand(
            1
        );
        
        $result = $this->sut->handle($command);

        $this->assertEquals(
            new Issue(
                1,
                [
                    'David',
                    'Agos',
                    'AnotherUser'
                ],
                [
                    [
                        'user' => 'David',
                        'status' => 'Voted',
                        'vote' => 8
                    ],
                    [
                        'user' => 'Agos',
                        'status' => 'Waiting',
                        'vote' => null
                    ],
                    [
                        'user' => 'AnotherUser',
                        'status' => 'Waiting',
                        'vote' => null
                    ],
                ],
                'Voting'
                ),
                $result
        );
    }

    public function testCanJoinUnexistingIssue(): void
    {
        $this->initialize();

        $command = new JoinIssueCommand(
            3
        );

        $result = $this->sut->handle($command);

        $this->assertEquals(
            new Issue(
                3,
                [
                    'AnotherUser'
                ],
                [
                    [
                        'user' => 'AnotherUser',
                        'status' => 'Waiting',
                        'vote' => null
                    ],
                ],
                'Voting'
                ),
                $result
        );
    }

    public function testCanNotJoinFinishedIssue(): void
    {
        $this->initialize();

        $command = new JoinIssueCommand(
            2
        );

        $this->expectException(DomainException::class);
        
        $this->sut->handle($command);
    }

    public function testCanNotJoinTwiceAnIssue(): void
    {
        $this->initialize('David');

        $command = new JoinIssueCommand(
            1
        );

        $this->expectException(AssertionFailedException::class);
        
        $this->sut->handle($command);
    }
}


