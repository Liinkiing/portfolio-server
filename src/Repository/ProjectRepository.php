<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * @param array|null $categories
     * @param array|null $platforms
     * @param array|null $languages
     * @param array|null $orderBy
     * @param string $operator
     * @return Project[]|null
     */
    public function search(?array $categories, ?array $platforms, ?array $languages, array $orderBy, string $operator = 'AND'): ?array
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->innerJoin('p.categories', 'categories')
            ->innerJoin('p.platforms', 'platforms')
            ->innerJoin('p.languages', 'languages');

        if ($categories) {
            if ($operator === 'AND') {
                $qb->andWhere(
                    $qb->expr()->in('categories.slug', $categories)
                );
            } elseif ($operator === 'OR') {
                $qb->orWhere(
                    $qb->expr()->in('categories.slug', $categories)
                );
            }
        }

        if ($languages) {
            if ($operator === 'AND') {
                $qb->andWhere(
                    $qb->expr()->in('languages.slug', $languages)
                );
            } elseif ($operator === 'OR') {
                $qb->orWhere(
                    $qb->expr()->in('languages.slug', $languages)
                );
            }
        }

        if ($platforms) {
            if ($operator === 'AND') {
                $qb->andWhere(
                    $qb->expr()->in('platforms.slug', $platforms)
                );
            } elseif ($operator === 'OR') {
                $qb->orWhere(
                    $qb->expr()->in('platforms.slug', $platforms)
                );
            }
        }

        $qb
            ->addOrderBy('p.' . $orderBy['field'], $orderBy['direction']);

        return $qb
            ->getQuery()
            ->getResult();
    }

}
