<?php
require_once('Experience.php');
/**
* a qualification is a diplomas
*/
class Qualification extends Experience
{
	public $place;
	
	function __construct($title, $details)
	{
		$this->name= $title;
		$this->begin= $details['begin'];
		$this->place= $details['place'];
	}
}