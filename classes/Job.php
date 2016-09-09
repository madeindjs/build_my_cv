<?php
require_once('Activity.php');
/**
* a job is a work did in a ProfessionalExperience 
*/
class Job
{
	public $title;
	public $activities = array();

	function __construct($job, $activities)
	{
		$this->title = $job ;
		foreach ($activities as $picture => $description) {
			array_push($this->activities, new Activity($picture, $description));
		}
	}
}