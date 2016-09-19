<?php
require_once('Experience.php');
require_once('Job.php');
/**
* a ProfessionalExperience is a moment passed in one Organization. It has
* a begining date & an ending date. It also include multiple a job title 
*/
class ProfessionalExperience  extends Experience
{
	public $jobs = array();
	
	function __construct($name, $details)
	{
		$this->name = $name;
		$this->begin = DateTime::createFromFormat('Y-m-d',$details['begin']);

		foreach ($details["jobs"] as $title => $details) {
			array_push($this->jobs, new Job($title, $details )) ;
		}

	}

	
}




