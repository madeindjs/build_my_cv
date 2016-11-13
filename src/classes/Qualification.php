<?php
namespace BuildMyCV\classes ;


/**
* a qualification is a diplomas
*/
class Qualification extends Experience
{
	private $place;
	
        /**
         * Build a qualification with array details and title
         * @param type $title
         * @param type $details
         */
	function __construct(string $title, array $details){
		$this->name= $title;
		$this->begin= \DateTime::createFromFormat('Y-m-d',$details['begin']);
		$this->place= $details['place'];
	}
}