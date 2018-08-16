<?php

namespace App\GraphQL\Resolver;

use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use App\Repository\LanguageRepository;
use App\Repository\PlatformRepository;
use App\Repository\ProjectRepository;
use App\Repository\TagRepository;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Error\UserError;

class GlobalIdResolver implements ResolverInterface
{

    private $categoryRepository;
    private $imageRepository;
    private $languageRepository;
    private $platformRepository;
    private $projectRepository;
    private $tagRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        ImageRepository $imageRepository,
        LanguageRepository $languageRepository,
        PlatformRepository $platformRepository,
        ProjectRepository $projectRepository,
        TagRepository $tagRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->imageRepository = $imageRepository;
        $this->languageRepository = $languageRepository;
        $this->platformRepository = $platformRepository;
        $this->projectRepository = $projectRepository;
        $this->tagRepository = $tagRepository;
    }

    public function __invoke(string $id)
    {
        $node = $this->categoryRepository->find($id);

        if (!$node) {
            $node = $this->imageRepository->find($id);
        }

        if (!$node) {
            $node = $this->languageRepository->find($id);
        }

        if (!$node) {
            $node = $this->platformRepository->find($id);
        }

        if (!$node) {
            $node = $this->projectRepository->find($id);
        }

        if (!$node) {
            $node = $this->tagRepository->find($id);
        }

        if (!$node) {
            throw new UserError('Could not find node!');
        }

        return $node;
    }

}