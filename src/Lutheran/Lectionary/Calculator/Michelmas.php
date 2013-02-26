<?php
/**
 * Lutheran Lectionary Project
 *
 * Copyright (c) 2013 Stan Lemon <http://www.stanlemon.net>
 * Licensed under LGPL
 *
 * The Lutheran Lectionary Project provides an abstracted mechanism for 
 * developing lectionary algorithims for calculating a given Sunday of
 * the church year.
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
