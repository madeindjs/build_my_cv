<?php
namespace BuildMyCV\classes ;


/**
* a qualification is a diplomas or a Formation
*/
class Qualification extends Entity
{
    
    private $place;
    protected $date;
        
	
    /**
     * Build a qualification
     * @param type $details
     */
    function __construct(array $details){
            $this->title= $details['title'];
            $this->date= \DateTime::createFromFormat('Y-m-d',$details['date']);
            $this->place= $details['place'];
    }
    
    /**
    * create title with job title & company
    * @return String
    */
    protected function complete_title():string{
        return $this->title.' @ '.$this->place ;
    }
}