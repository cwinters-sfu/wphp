<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EstcRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EstcMarcRepository extends EntityRepository
{
    public function indexQuery() {
        $qb = $this->createQueryBuilder('m');
        $qb->where("m.field = 'ldr'");
        return $qb->getQuery();
    }

    public function searchQuery($q) {
        $dql = <<<"ENDSQL"
SELECT e.titleId, max(MATCH (e.fieldData) AGAINST (:q BOOLEAN)) as HIDDEN score
FROM AppBundle:EstcMarc e
WHERE MATCH (e.fieldData) AGAINST (:q BOOLEAN) > 0 AND e.field IN ('245' , '100')
group by e.titleId order by score desc
ENDSQL;
        $query = $this->_em->createQuery($dql);
        $query->setParameter('q', $q);
        return $query->execute();
    }

    public function imprintSearchQuery($q) {
        $dql = <<<"ENDSQL"
SELECT e.titleId, max(MATCH (e.fieldData) AGAINST (:q BOOLEAN)) as HIDDEN score
FROM AppBundle:EstcMarc e
WHERE MATCH (e.fieldData) AGAINST (:q BOOLEAN) > 0 AND e.field = '260' and e.subfield = 'b'
group by e.titleId order by score desc
ENDSQL;
        $query = $this->_em->createQuery($dql);
        $query->setParameter('q', $q);
        return $query->execute();
    }
}
