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
namespace Lutheran\Lectionary;

interface Calculator {

	public function getDate();

	public function setDate(\DateTime $date = null);

	public function getWeek();
		
	public function getEndOfYear();
	
	public function getLastSunday();
	
	public function getAdvent();

	public function getEpiphany();

	public function getTransfiguration();
	
	public function getLent();
	
	public function getEaster();
	
	public function getPentecost();
	
	public function isPrivileged();
}
