<?php
namespace BuildMyCV\classes;

/**
 * An entity can be:
 * - a professionnal experience
 * - a peronnal experience
 * - a diplomas
 * - a training 
 */
abstract class Entity {
    
    protected $title;
    
    
    function to_html():string{
        $ret =  '<date>'.$this->work_interval().'</date> '.$this->complete_title() ;
        if(method_exists(get_class($this), 'tasks_to_html' )){
            $ret .= $this->tasks_to_html();
        }
        return $ret ;
        
    }
    
    protected function work_interval():string{
        if( property_exists(get_class($this), 'date' )){
            return $this->date->format('Y');
        }else{
            return $this->end ? $this->begin->format('m/Y').'-'.$this->end->format('m/Y') : $this->begin->format('m/Y').'- now';
        }
        
    }
    
    protected function complete_title(){
        throw new NotImplementedException();
    }
}


class NotImplementedException extends \RuntimeException { }