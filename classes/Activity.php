<?php
require_once('lib/Parsedown.php');
/**
* An activity is a task done during a job. 
* it contains a picture & a description
*/
class Activity
{
	public $picture;
	public $description;
	private $Parsedown ;

	function __construct($picture, $description)
	{
		$this->Parsedown = new Parsedown();
		$this->picture = $picture;
		$this->description = $description;
	}

	// return Activity's picture in <img/> tag 
	function picture(){
		return '<img src="img/'.$this->picture.'" alt="logo of this Activity" >';
	}

	// return Activty in list item with its picture & description
	function to_html(){
		return '<li>'.$this->picture().$this->Parsedown->text($this->description).'</li>';
	}
}