<?php

/**
* 
*/
class ProfessionalExperience
{
	public $entreprise;
	public $begin;

	public $functions = array();
	
	function __construct($entreprise, $details)
	{
		$this->entreprise = $entreprise;
		$this->begin = $details['begin'];

		foreach ($details["functions"] as $key => $value) {
			$this->functions[$key] = $value;
		}

	}

	function title(){
		return $this->entreprise.'depuis'.$this->begin;
	}
}




