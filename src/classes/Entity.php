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
        $ret =  '<date>'.$this->work_interval().'</date><strong>'.$this->complete_title().'</strong>' ;
        if(method_exists(get_class($this), 'tasks_to_html' )){
            $ret .= $this->tasks_to_html();
        }
        return $ret ;
        
    }
    
    /**
     * Returned a formated time intervall 
     * @return string
     */
    protected function work_interval():string{
        if( property_exists(get_class($this), 'date' )){
            return $this->date ? $this->date->format('Y') : "?";
        }else{
            // if begin & end year is the same, we only print year
            if($this->end && $this->begin->format('Y') == $this->end->format('Y')){
                return $this->begin->format('Y');
            
            // elseif different but we have an end year, print both in '2015-16' format
            }elseif ($this->end && $this->begin ) {
                return $this->begin->format('Y').'-'.$this->end->format('y');
                
            // else print in '2015-16' format with current year
            }else{
                return $this->begin ? $this->begin->format('Y').'→' : "?";
            }
        }
    }
    
    protected function complete_title(){
        throw new NotImplementedException();
    }
}


class NotImplementedException extends \RuntimeException { }