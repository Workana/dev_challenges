<?php 

declare(strict_types=1);

namespace Tests\Unit\Application\Handlers\Auth;

use App\Application\Commands\Issues\GetIssueQuery;
use App\Application\Exceptions\EntityNotFoundException;
use App\Application\Handlers\Issues\GetIssueHandler;
use App\Domain\Entities\Issue;
use App\Infrastructure\Persistence\MockRepositories\MockIssueRepository;
use PHPUnit\Framework\TestCase;

final class GetIssueHandlerTest extends TestCase
{
    private GetIssueHandler $sut;

    public function initialize()
    {
        $this->sut = new GetIssueHandler(
            new MockIssueRepository()
        );
    }

    public function testCanGetValidIssueStatusVoting(): void
    {
        $this->initialize();

        $query = new GetIssueQuery(
            1
        );
        
        $result = $this->sut->handle($query);

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
                        'status' => 'Voted'
                    ],
                    [
                        'user' => 'Agos',
                        'status' => 'Waiting'
                    ],
                ],
                'Voting'
            ),
            $result
        );
    }

    public function testCanGetValidIssueStatusFinished(): void
    {
        $this->initialize();

        $query = new GetIssueQuery(
            2
        );
        
        $result = $this->sut->handle($query);

        $this->assertEquals(
            new Issue(
                2,
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
                        'vote' => 5
                    ],
                ],
                'Finished',
                6.5
            ),
            $result
        );
    }


    public function testCanNotGetUnexistingIssue(): void
    {
        $this->initialize();

        $query = new GetIssueQuery(
            3
        );
        
        $this->expectException(EntityNotFoundException::class);
        
        $this->sut->handle($query);
    }
}


