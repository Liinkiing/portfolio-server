<?php


namespace App\GraphQL\Resolver\Query;


use App\Entity\Project;
use App\Repository\ProjectRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Error\UserError;

class ProjectResolver implements ResolverInterface
{

    private $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Argument $args): Project
    {
        $slug = $args->offsetGet('slug');

        $project = $this->repository->findOneBy(compact('slug'));

        if (!$project) {
            throw new UserError("Ce projet n'existe pas !");
        }

        return $project;
    }

}