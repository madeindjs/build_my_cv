<?php
require_once('Activity.php');

/**
* and Experience is an abstract class for PersonalExperience, ProfessionalExperience & Qualification
*/
class Experience
{
	public $name;
	public $begin;
	public $end;

	public $activities = array();
	
	function __construct($name, $details)
	{
		$this->name = $name;
		$this->begin = DateTime::createFromFormat('Y-m-d',$details['begin']);

		foreach ($details["activities"] as $picture => $description) {
			array_push($this->activities, new Activity($picture, $description )) ;
		}

	}


	function title(){
		if($this->begin) {
			return $this->name.' <small>depuis <time datetime="'.$this->begin->format('Y-m-d').'">'.$this->begin->format('d/m/Y').'</time></small>';
		}else{
			return $this->name;
		}
	}

	function to_json(){
		$json = array();
		foreach ($this->activities as $activity) {
			array_push( $json, $activity->to_array() );
		}
		return json_encode( $json , JSON_PRETTY_PRINT);
	}
}