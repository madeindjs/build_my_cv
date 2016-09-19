<?php

/**
* and Experience is an abstract class for PersonalExperience, ProfessionalExperience & Qualification
*/
class Experience
{
	public $name;
	public $begin;
	public $end;



	function title(){
		if($this->begin) {
			return $this->name.' <small>depuis <time datetime="'.$this->begin->format('Y-m-d').'">'.$this->begin->format('d/m/Y').'</time></small>';
		}else{
			return $this->name;
		}
	}
}