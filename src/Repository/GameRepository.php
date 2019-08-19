<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @return mixed
     */
    public function findLastGame()
    {
        return $this->createQueryBuilder('g')
            ->select('g.id')
            ->orderBy('g.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function findPlayersInGame(string $value)
    {
        return $this->createQueryBuilder('g')
            ->select('g.id')
            ->addSelect('players.id')
            ->leftJoin('g.players', 'players')
            ->where('g.id = :gid')
            ->setParameter('gid', $value)
            ->getQuery()
            ->getResult();
    }
}
