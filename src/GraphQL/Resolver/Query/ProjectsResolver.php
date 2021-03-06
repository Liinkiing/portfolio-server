<?php

namespace App\GraphQL\Resolver\Query;

use App\Repository\ProjectRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class ProjectsResolver implements ResolverInterface
{
    private $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Argument $args): Connection
    {
        $orderBy = $args->offsetGet('orderBy');
        $projects = $this->repository->findBy(
            [],
            [$orderBy['field'] => $orderBy['direction']]
        );
        $connection = ConnectionBuilder::connectionFromArray($projects, $args);
        $connection->totalCount = \count($projects);

        return $connection;
    }
}