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


	/* 
	* create a Html picture of user from gravatar (snippet from https://fr.gravatar.com/site/implement/images/php)
	* @return string as html image tag from gravatar.com
	*/
	function title(){
		if($this->parent->professional_exp){
			return $this->name.'<small> chez '.$this->parent->name .'</small>';
		}else{return $this->name.'<small> (experience personnelle)</small>';}
	}


	/* 
	* create an Html <date> formated
	* @return String
	*/
	function date(){
		return '<date>'.$this->begin->format('m/Y').'</date>';
	}


	/* 
	* create an Html description parsed in Markdown
	* @return String
	*/
	function description(){
		$Parsedown = new Parsedown();
		return $Parsedown->line($this->description);
	}


	/* 
	* create a Html picture of user from gravatar (snippet from https://fr.gravatar.com/site/implement/images/php)
	* @return string as html image tag from gravatar.com
	*/
	function picture(){
		return '<img src="img/'.$this->picture.'" alt="logo of this Activity" >';
	}


	/*
	* create a complete Html <div> with all information about this object
	* @return String
	*/
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