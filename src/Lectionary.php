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
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Exception.php';

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Calculator' . DIRECTORY_SEPARATOR . 'Lectionary.php';


final class Lectionary {

	private function __construct() {}

	private function __clone() {}

	public static function factory( $calculator ) {
		$class = $calculator . '_Calculator';
		
		if ( !include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Calculator' . DIRECTORY_SEPARATOR . $calculator . '.php') ) {
			throw new Lectionary_Exception("Unable to load lectionary calculator.");
		} else {
			$lectionary = new $class();
			
			if ( !$lectionary instanceof Lectionary_Calculator ) {
				throw new Lectionary_Exception("Calculator class is not an instance of the Lectionary_Calendar, who knows what will happen!");
			} else {
				return $lectionary;
			}
		}
	}
}
