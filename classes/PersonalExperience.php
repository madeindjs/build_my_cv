<?php
require_once('Experience.php');
require_once('Activity.php');
/**
* a PersonalExperience is a moment passed in one personnal project. It has
* a begining date & an ending date. It also include multiple a Activities
*/
class PersonalExperience extends Experience
{

	public $activities = array();
	
	function __construct($name, $details)
	{
		$this->name = $name;
		$this->begin = DateTime::createFromFormat('Y-m-d',$details['begin']);

		foreach ($details["activities"] as $picture => $description) {
			array_push($this->activities, new Activity($picture, $description )) ;
		}

	}

}




