<?php

/**
* Langage is 
*/
class Langage
{
	public $name;
	public $picture;

	public $speaken;
	public $writen;
	public $listen;
	public $read;

	
	function __construct($name, $details)
	{
		$this->name = $name;
		$this->picture = $details['picture'];
		$this->speaken = $details['notes']['speaken'];
		$this->writen = $details['notes']['writen'];
		$this->listen = $details['notes']['listen'];
		$this->read = $details['notes']['read'];
	}

	public function to_html(){
		return '<ul>'.
			$this->note_to_html('parlé', $this->speaken).
			$this->note_to_html('écris', $this->writen).
			$this->note_to_html('écouté', $this->listen).
			$this->note_to_html('lu', $this->read).
		'</ul>';
	}

	private function note_to_html($text, $note){
		return '<li><strong>'.$text.'</strong><progress value='.$note.' max="5">'.$note.'/5</progress></li>';
	}
}