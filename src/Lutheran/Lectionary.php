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
namespace Lutheran;

use Lutheran\Lectionary\Exception;
use Lutheran\Lectionary\Calculator;

class Lectionary {

	public static function factory($calculator) {
		$class = 'Lutheran\\Lectionary\\Calculator\\' . $calculator;
		
		if (!class_exists($class)) {
			throw new Exception("Unable to load lectionary calculator.");
		} else {
			$lectionary = new $class();
			
			if (!$lectionary instanceof Calculator) {
				throw new Exception("Calculator class is not an instance of the Lutheran\\Lectionary\\Calendar");
			} else {
				return $lectionary;
			}
		}
	}
}
