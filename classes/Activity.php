<?php
/**
* An activity is a task done during a job. 
* it contains a picture & a description
*/
class Activity
{
	public $picture;
	public $description;

	function __construct($picture, $description)
	{
		$this->picture = $picture;
		$this->description = $description;
	}

	// return Activity's picture in <img/> tag 
	function picture(){
		return '<img src="img/'.$this->picture.'" alt="logo of this Activity" >';
	}
}