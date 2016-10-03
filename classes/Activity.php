<?php
require_once('lib/Parsedown.php');
/**
* An activity is a task done during a job. 
* it contains a picture & a description
*/
class Activity
{
	public $name;
	public $description;
	public $begin;
	public $picture;

	private $parent ;

	function __construct($parent, $name, $details)
	{
		$this->parent = $parent;
		$this->begin = DateTime::createFromFormat('Y-m-d',$details['begin']);
		$this->name = $name;
		$this->picture = $details['img'];
		$this->description = array_key_exists('description' , $details ) ? $details['description'] : null ;
	}

	function title(){
		if($this->parent->professional_exp){
			return $this->name.'<small> chez '.$this->parent->name.' <date>'.$this->begin->format('m/Y').'</date></small>' ;
		}else{return $this->name.'<small> (experience personnelle) <date>'.$this->begin->format('m/Y').'</date></small>';}
	}

	function description(){
		$Parsedown = new Parsedown();
		return $Parsedown->line($this->description);
	}

	// return Activity's picture in <img/> tag 
	function picture(){
		return '<img src="img/'.$this->picture.'" alt="logo of this Activity" >';
	}

	// return Activty in list item with its picture & description
	function to_html(){
		$Parsedown = new Parsedown();
		return '<li>'.$this->picture().$Parsedown->text($this->description).'</li>';
	}

	function to_array(){
		$Parsedown = new Parsedown();
		$ret = array();
		$ret['name'] = $this->title();
		if($this->description){$ret['description'] = $Parsedown->text($this->description) ;}
		$ret['img'] = 'img/'.$this->picture ;
		$begin = $this->begin ? $this->begin : new DateTime() ;
		$ret['date'] = $begin->format('Y-m-d');
		return $ret ;
	}
}