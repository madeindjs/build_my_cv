<?php
require_once('Job.php');
/**
* a ProfessionalExperience is a moment passed in one Organization. It has
* a begining date & an ending date. It also include multiple a job title 
*/
class ProfessionalExperience
{
	public $entreprise;
	public $begin;
	public $end;

	public $jobs = array();
	
	function __construct($entreprise, $details)
	{
		$this->entreprise = $entreprise;
		$this->begin = $details['begin'];

		foreach ($details["jobs"] as $title => $details) {
			array_push($this->jobs, new Job($title, $details )) ;
		}

	}

	function title(){
		return $this->entreprise.'depuis'.$this->begin;
	}
}




