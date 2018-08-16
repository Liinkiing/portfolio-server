<?php

namespace App\GraphQL\Resolver\Type;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Language;
use App\Entity\Platform;
use App\Entity\Project;
use App\Entity\Tag;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Error\UserError;
use Overblog\GraphQLBundle\Resolver\TypeResolver;

class NodeTypeResolver implements ResolverInterface
{

    private $resolver;

    public function __construct(TypeResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __invoke($node)
    {
        if ($node instanceof Category) {
            return $this->resolver->resolve('Category');
        }
        if ($node instanceof Image) {
            return $this->resolver->resolve('Image');
        }
        if ($node instanceof Language) {
            return $this->resolver->resolve('Language');
        }
        if ($node instanceof Platform) {
            return $this->resolver->resolve('Platform');
        }
        if ($node instanceof Project) {
            return $this->resolver->resolve('Project');
        }
        if ($node instanceof Tag) {
            return $this->resolver->resolve('Tag');
        }

        throw new UserError("Can't resolve node type!");
    }

}