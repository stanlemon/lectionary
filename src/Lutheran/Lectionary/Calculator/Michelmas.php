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
 
class Michelmas extends Historic implements Calculator {

	public function getEndOfYear() {
		$endOfYear = $this->getLastSunday();
		$endOfYear->modify("-9 weeks");
	
		return $endOfYear;
	}
}
