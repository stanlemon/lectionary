<?php

/**
 * Lutheran Lectionary Project
 *
 * Copyright (c) 2008 Stan Lemon <http://www.stanlemon.net>
 * Licensed under LGPL
 *
 * The Lutheran Lectionary Project provides an abstracted mechanism for 
 * developing lectionary algorithims for calculating a given Sunday of
 * the church year.
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package	Lectionary
 */

/**
 */
class Michelmas_Calculator extends Historic_Calculator implements Lectionary_Calculator {

	public function getEndOfYear() {
		$endOfYear = $this->getLastSunday();
		$endOfYear->modify("-9 weeks");
	
		return $endOfYear;
	}
}

?>