<?php
namespace BuildMyCV\classes ;


/**
* a qualification is a diplomas or a Formation
*/
class Qualification extends Entity{
    
    private $place;
    protected $date;
    private $kind;

        
    const KIND_DIPLOMAS = "Diplomas";
    const KIND_TRAINING = "Trainings";
    const KIND_OTHER = "Other";
    
    /**
     * Build a qualification
     * @param type $details
     */
    function __construct(array $details){
            $this->title= $details['title'] ?? null;
            $this->date= \DateTime::createFromFormat('Y-m-d',$details['date']);
            $this->place= $details['place'] ?? null;
            $this->kind= $details['kind'] ?? null;
    }
    
    function get_kind(){return $this->kind;}
    
    /**
    * create title with job title & company
    * @return String
    */
    protected function complete_title():string{
        return $this->title.' @ '.$this->place ;
    }
}