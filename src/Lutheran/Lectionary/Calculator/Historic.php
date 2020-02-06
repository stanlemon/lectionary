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
use Lutheran\Lectionary\Exception;
use Lutheran\Lectionary\Sundays;

class Historic implements Calculator {

	protected $date;

	public function __construct() {} 
	
	public function getDate() {
		return $this->date;
	}
	
	public function setDate(\DateTime $date = null) {
		// Create a new instance of the datetime object from one passed in, or default to right now.
		$this->date = ($date === null) ? new \DateTime("now") : new \DateTime($date->format("r"));
		// Clear out the time stamp on our date.
		$this->date->setTime(0, 0, 0);
		return $this;
	}

	public function getWeek() {
		$sunday = $this->getSunday();
		$advent = $this->getAdvent();
		$christmas = $this->getChristmas();
		$epiphany = $this->getEpiphany();
		$transfiguration = $this->getTransfiguration();

		// If Christmas Day is not a Sunday
		if ($sunday->format("Ymd") == $this->getChristmas()->format("Ymd")) {
			// Why null? Because this one requires special handling by your code. Check for 12/25!
			return null;
		// After Advent
		} elseif ($sunday >= $advent) {
			return $this->getWeekDifference( $advent , $sunday );
		// After Epiphany, Before Transfiguration
		} elseif ($sunday >= $epiphany && $sunday < $transfiguration) {
			return $this->getWeekDifference( $epiphany , $sunday) + 5;
		// Before Epiphany
		} elseif ($sunday < $epiphany) {
			return 8 - $this->getWeekDifference( $sunday , $epiphany );
		// After Transfiguration before End of Church Year
		} elseif ($sunday >= $transfiguration && $sunday <= $this->getEndOfYear()) {
			return $this->getWeekDifference( $this->getTransfiguration() , $sunday ) + 11;
		// The end of the Church Year to Last Sunday (ie. Third Last - Last or this could be re-written for Michelmas)
		} else {
			$week = 58 - $this->getWeekDifference( $sunday , $this->getLastSunday() );
			return $week;
		}
	}


	public function getEndOfYear() {
		$endOfYear = $this->getLastSunday();
		$endOfYear->modify("-2 weeks");
		
		return $endOfYear;
	}

	public function getLastSunday() {
		$lastSunday = $this->getAdvent();
		$lastSunday->modify("-1 week");

		return $lastSunday;
	}

	public function getAdvent() {
		$advent = new \DateTime();
		$advent->setDate($this->date->format('Y'), 12, 25);
		$advent->setTime(0,0,0);

		if ($advent->format('w') == 0) {
			$advent->modify('-4 weeks');
		} else {
			$advent->modify('last sunday');
			$advent->modify('-3 weeks');
		}

		return $advent;
	}

	public function getChristmas() {
		$christmas = new \DateTime();
		$christmas->setDate($this->date->format('Y'), 12, 25);
		$christmas->setTime(0,0,0);
		
		return $christmas;
	}

	public function getEpiphany() {
		$epiphany = new \DateTime();
		$epiphany->setDate($this->date->format('Y'), 1, 6);
		$epiphany->setTime(0, 0, 0);
		
		return $epiphany;
	}

	public function getTransfiguration() {
		$transfiguration = $this->getEaster();
		$transfiguration->modify('-10 weeks');
	
		return $transfiguration;
	}

	public function getAshWednesday() {
		$ashWednesday = $this->getLent();
		$ashWednesday->modify("last Wednesday");
		return $ashWednesday;
	}

	public function getLent() {
		$lent = $this->getEaster();
		$lent->modify('-5 weeks');
		
		return $lent;
	}

	public function getEaster() {
		$year = $this->date->format('Y');

		$a = $year % 19;
		$b = floor($year / 100);
		$c = $year % 100;
		$d = floor($b / 4);
		$e = $b % 4;
		$f = floor(($b + 8) / 25);
		$g = floor(($b - $f + 1) / 3);
		$h = (19 * $a + $b - $d - $g + 15) % 30;
		$i = floor($c / 4);
		$k = $c % 4;
		$l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
		$m = floor(($a + 11 * $h + 22 * $l) / 451);
		$n = ($h + $l - 7 * $m + 114);

		$month = floor($n / 31);
		$day = $n % 31 + 1;

		$easter = new \DateTime();
		$easter->setDate($year, $month, $day);
		$easter->setTime(0, 0, 0); // It concerns me that I have to set this.
		
		return $easter;
	}

	public function getTrinity() {
		$trinity = $this->getEaster();
		$trinity->modify('+6 weeks');
		return $trinity;
	}

	public function getPentecost() {
		$pentecost = $this->getEaster();
		$pentecost->modify('+7 weeks');
		return $pentecost;
	}
	
	public function isPrivileged() {
		$overrides = array(
			'12-24',
			'12-25',
			'12-26',
			'12-27',
			'12-28',
			'01-06'
		);

		$week = $this->getWeek();
		$sunday = $this->getSunday();

		$isOverride = in_array($this->getSunday()->format('m-d'), $overrides);

		// These days trump any privilige, eg. Always celebrate Epiphany
		if ($isOverride) {
			return false;
		}

		// Transfiguration (which is between the baptism and lent 1) is privilieged 
		if ($week != Sundays::TRANSFIGURATION) {
			return true;
		}

		// After the baptism of our lord and before lent 1 nothing is priviliged
		if ($week > Sundays::THE_BAPTISM_OF_OUR_LORD && $week < Sundays::LENT_1) {
			return false;
		}

		// After trinity sunday and before the last sunday nothing is privileged
		if ($week > Sundays::TRINITY_SUNDAY && $week < Sundays::LAST_SUNDAY) {
			return false;
		}

		return true;
	}

	protected function getSunday() {
		if ($this->date->format('w') != 0) {
			$sunday = clone $this->date;
			$sunday->modify('last sunday');

			return $sunday;
		} else {
			return clone $this->date;
		}
	}
	
	protected function getWeekDifference(\DateTime $week1 , \DateTime $week2) {
		if ( $week1->format("Ymd") > $week2->format("Ymd") ) {
			throw new Exception("Cannot calculate difference of a week ({$week1->format('Y-m-d')}) which exists after it's comparing week ({$week2->format('Y-m-d')}).");
		} else {
			$found = false;
			$weeks = 0;

			while ($found === false) {
				if ( $week1->format("Ymd") >= $week2->format("Ymd") ) {
					$found = true;
				} else {
					$week1->modify('+1 week');
				}
				
				$weeks++;
			}
			
			return $weeks;
		}
	}
}
