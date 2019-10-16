<?php
/**
 * Lutheran Lectionary Project
 *
 * Copyright (c) 2019 Stan Lemon <http://www.stanlemon.com>
 * Licensed under MIT
 *
 * The Lutheran Lectionary Project provides an abstracted mechanism for 
 * developing lectionary algorithims for calculating a given Sunday of
 * the church year.
 *
 * @license http://opensource.org/licenses/mit-license.php The MIT License
 * @package	Lectionary
 */
namespace Lutheran\Lectionary\Calculator;

use Lutheran\Lectionary\Calculator;
use Lutheran\Lectionary\Calculator\Historic;

class ThreeYear extends Historic implements Calculator {

	public function getTransfiguration() {
		$transfiguration = $this->getEaster();
		$transfiguration->modify('-7 weeks');

		return $transfiguration;
	}

	public function isPrivilidged() {
		$week = $this->getWeek();

		return ($week <= 7 || ($week < 15 && $week > 22)) ? true : false;
	}

	public function getSeries() {
		$year = $this->getAdvent()->format("Y");
		
		switch ( $year % 3 ) {
			case 0:
				return 'A';
			case 1:
				return 'B';
			case 2:
				return 'C';
		}		
	}
}
