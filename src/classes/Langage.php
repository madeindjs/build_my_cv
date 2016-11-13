<?php
namespace BuildMyCV\classes ;


/**
* Langage is a compentence master by user
*/
class Langage
{
	public $name;
	public $picture;

	public $speaken;
	public $writen;
	public $listen;
	public $read;

	
        /**
         * Initialize a Langage
         * @param string $name
         * @param array $details
         */
	function __construct(string $name, array $details){
		$this->name = $name;
		$this->hydrate($details);
	}

	/**
	* create a complete Html <div> with all information about this object
	* @return String
	*/
	public function to_html():string{
		return '<div class="langage">'.
			'<img src="img/'.$this->picture.'" alt="logo of '.$this->name.' langage"/><ul>'.
			$this->note_to_html('parlé', $this->speaken).
			$this->note_to_html('écris', $this->writen).
			$this->note_to_html('écouté', $this->listen).
			$this->note_to_html('lu', $this->read).
		'</ul></div>';
	}

	/**
         * create html <li> tag with information about one note
         * @param type $text as displayed text
         * @param type $note as note betwenn 1 and 5
         * @return string
         */
	private function note_to_html(string $text, int $note):string{
		return '<li><strong>'.$text.'</strong><progress value='.$note.' max="5">'.$note.'/5</progress></li>';
	}

	/**
         * set up object properties in loop
         * @param array $data
         */
	private function hydrate(array $data){
		// setup user informations
		foreach ($data["notes"] as $key => $value) {
			if( property_exists(get_class($this), $key )){
				$this->$key = $value ;
			}
		}
		$this->picture = $data['picture'];
	}
}