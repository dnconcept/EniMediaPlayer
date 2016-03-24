<?php

namespace Eni\MediaBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Eni\MediaBundle\Entity\Media;

/**
 * Description of MediaRepository
 *
 * @author Administrateur
 */
class MediaRepository extends EntityRepository
{

    public function findAllWithUserAsArray()
    {
        $qb = $this->createQueryWithUser();
        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    public function findAllWithUser()
    {
        $qb = $this->createQueryWithUser();
        return $qb->getQuery()->getResult();
    }

    private function createQueryWithUser()
    {
        $qb = $this->createQueryBuilder("a");
        $qb
            ->select("m", "c", "g")
            ->from(Media::class, "m")
            ->leftJoin("m.createur", "c")
            ->leftJoin("m.genre", "g");
        return $qb;
    }

}
