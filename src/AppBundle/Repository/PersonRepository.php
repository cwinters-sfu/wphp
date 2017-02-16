<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Person;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Func;

/**
 * PersonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonRepository extends EntityRepository {

    /**
     * Return the next firm by ID.
     * 
     * @param Person $person
     * @return Person|Null
     */
    public function next(Person $person) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere('e.id > :id');
        $qb->setParameter('id', $person->getId());
        $qb->addOrderBy('e.id', 'ASC');
        $qb->setMaxResults(1);
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    /**
     * Return the next firm by ID.
     * 
     * @param Person $person
     * @return Person|Null
     */
    public function previous(Person $person) {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere('e.id < :id');
        $qb->setParameter('id', $person->getId());
        $qb->addOrderBy('e.id', 'DESC');
        $qb->setMaxResults(1);
        return $qb->getQuery()->getOneOrNullResult();
    }    
    
	public function searchQuery($q) {
		$qb = $this->createQueryBuilder('e');
		$qb->where(
				$qb->expr()->like(
						new Func('CONCAT', array(
							'e.lastName', 
							'e.firstName', 
							'e.title'
						)
					),
					"'%$q%'"
				)
		);
		return $qb->getQuery();
	}

	public function fulltextQuery($q) {
		$qb = $this->createQueryBuilder('e');
		$qb->addSelect("MATCH_AGAINST (e.lastName, e.firstName, e.dob, e.dod, :q 'IN BOOLEAN MODE') as score");
		$qb->add('where', "MATCH_AGAINST (e.lastName, e.firstName, e.dob, e.dod, :q 'IN BOOLEAN MODE') > 0.5");
		$qb->orderBy('score', 'desc');
		$qb->setParameter('q', $q);
		return $qb->getQuery();
	}

    public function random($limit) {
        $qb = $this->createQueryBuilder('e');
        $qb->orderBy('RAND()');
        $qb->setMaxResults($limit);
        return $qb->getQuery()->execute();
    }
}
