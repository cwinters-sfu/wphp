<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Format;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * LoadFormat form.
 */
class LoadFormat extends Fixture implements FixtureGroupInterface {

    const DATA = array(
        ["folio","fo"],
        ["quarto","4to"],
        ["sexto","6to"],
        ["octavo","8vo"],
        ["duodecimo","12mo"],
        ["sextodecimo","16mo"],
        ["octodecimo","18mo"],
        ["vicesimo-quarto","24mo"],
        ["trigesimo-secundo","32mo"],
        ["quadragesimo-octavo","48mo"],
        ["sexagesimo-quarto","64mo"],
        ["broadside","bs"],
    );

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em) {
        for ($i = 0; $i < 4; $i++) {
            $fixture = new Format();
            $fixture->setName('Name ' . $i);
            $fixture->setAbbreviation('A' . $i);

            $em->persist($fixture);
            $this->setReference('format.' . $i, $fixture);
        }

        foreach(self::DATA as $row) {
            $fixture = new Format();
            $fixture->setName($row[0]);
            $fixture->setAbbreviation($row[1]);
            $em->persist($fixture);
        }

        $em->flush();
    }

    public static function getGroups(): array {
        return array('test');
    }
}
