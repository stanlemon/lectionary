<?php
namespace Lutheran\Lectionary\Calculator;

use Lutheran\Lectionary;
use Lutheran\Lectionary\Sundays;
use PHPUnit\Framework\TestCase;

class HistoricTest extends TestCase {

	protected function checkDatesAndWeek($dates, $week) {
		$calculator = Lectionary::factory('Historic');

		foreach ($dates as $date) {
			$calculator->setDate(new \DateTime($date));
			$this->assertEquals(
				$week,
				$calculator->getWeek()
			);
		}
	}

	public function testTrinity20() {
		$dates = array(
			"11/03/2019",
			"10/25/2020",
		);

		$this->checkDatesAndWeek($dates, Sundays::TRINITY_20);
	}

	public function testTrinity22() {
		$dates = array(
			"11/04/2012",
			"10/31/2010",
			"10/19/2008",
			"11/04/2007",
		);

		$this->checkDatesAndWeek($dates, Sundays::TRINITY_22);
	}

	public function testTrinity23() {
		$dates = array(
			"11/04/2018",
		);

		$this->checkDatesAndWeek($dates, Sundays::TRINITY_23);
	}

	public function testEaster() {
		$calculator = Lectionary::factory('Historic');

		$calculator->setDate(new \DateTime("01/01/2000"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"04/23/2000"
		);
		
		$calculator->setDate(new \DateTime("01/01/2001"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"04/15/2001"
		);

		$calculator->setDate(new \DateTime("01/01/2002"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"03/31/2002"
		);

		$calculator->setDate(new \DateTime("01/01/2003"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"04/20/2003"
		);

		$calculator->setDate(new \DateTime("01/01/2004"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"04/11/2004"
		);


		$calculator->setDate(new \DateTime("01/01/2005"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"03/27/2005"
		);

		$calculator->setDate(new \DateTime("01/01/2006"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"04/16/2006"
		);

		$calculator->setDate(new \DateTime("01/01/2007"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"04/08/2007"
		);

		$calculator->setDate(new \DateTime("01/01/2008"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"03/23/2008"
		);

		$calculator->setDate(new \DateTime("01/01/2009"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"04/12/2009"
		);

		$calculator->setDate(new \DateTime("01/01/2010"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"04/04/2010"
		);

		$calculator->setDate(new \DateTime("01/01/2011"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"04/24/2011"
		);

		$calculator->setDate(new \DateTime("01/01/2012"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"04/08/2012"
		);

		$calculator->setDate(new \DateTime("01/01/2013"));
		$this->assertEquals(
			$calculator->getEaster()->format("m/d/Y"),
			"03/31/2013"
		);

	}
}
