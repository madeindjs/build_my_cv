<?php
namespace BuildMyCV\classes ;


/**
* a qualification is a diplomas
*/
class Qualification extends Experience
{
	public $place;
	
	function __construct($title, $details)
	{
		$this->name= $title;
		$this->begin= \DateTime::createFromFormat('Y-m-d',$details['begin']);
		$this->place= $details['place'];
	}
}