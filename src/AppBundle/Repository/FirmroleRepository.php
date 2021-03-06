<?php

namespace AppBundle\Repository;

use AppBundle\Entity\TitleFirmrole;
use AppBundle\Entity\Firmrole;
use Doctrine\ORM\EntityRepository;

/**
 * FirmroleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FirmroleRepository extends EntityRepository {

    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere("e.name LIKE :q");
        $qb->orderBy('e.name');
        $qb->setParameter('q', "{$q}%");
        return $qb->getQuery()->execute();
    }

    public function countFirms(Firmrole $firmrole) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(1)');
        $qb->andWhere('titlefirmrole.firmrole = :firmrole');
        $qb->setParameter('firmrole', $firmrole);
        $qb->from(TitleFirmrole::class, 'titlefirmrole');
        return $qb->getQuery()->getSingleScalarResult();
    }

}
