<?php

namespace App\GraphQL\Resolver\Query;

use App\Repository\ProjectRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class SearchProjectsResolver implements ResolverInterface
{
    private $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Argument $args): Connection
    {
        [$orderBy, $categories, $platforms, $languages, $operator] = [
            $args->offsetGet('orderBy'),
            $args->offsetGet('categories'),
            $args->offsetGet('platforms'),
            $args->offsetGet('languages'),
            $args->offsetGet('operator'),
        ];

        $projects = $this->repository->search($categories, $platforms, $languages, $orderBy, $operator);

        $connection = ConnectionBuilder::connectionFromArray($projects, $args);
        $connection->totalCount = \count($projects);

        return $connection;
    }
}