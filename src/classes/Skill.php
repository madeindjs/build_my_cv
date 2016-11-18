<?php
namespace BuildMyCV\classes ;
/**
 * A skill is a programming Langage or a Framework mastered by user
 */
class Skill{
    private $name;
    private $score;
    
    const MAX = 10 ;
    const PICTURE_EXTENSIONS = ['png', 'svg', 'jpeg', 'jpg', 'gif'];
    const SANITIZED_WORDS = ['#'=>'sharp','+'=>'plus'  ];
    
    function __construct(string $name, int $score = null) {
        $this->name = $name;
        $this->score = $score;
    }
    
    function __toString(){
        return $this->name.'('.$this->score.')'; 
    }
    
    function get_name():string{return $this->name;}
    
    /**
     * Return Skill name sanitized for basename file (like for C# -> Csharp)
     * @return string
     */
    function get_name_sanitized():string{
        $sanitize_name = $this->name ;
        foreach (self::SANITIZED_WORDS as $old => $new) {
            $sanitize_name = str_replace($old, $new, $sanitize_name);
        }
        return $sanitize_name;
    }
    
    /**
     * Create an html picture tag for this skill
     * @param type $class as CSS class ('skill-picture' by default)
     * @return string/null as an Html picture tag or null if not founded
     */
    function picture_to_html($class="skill-picture"){
        if($src = $this->picture_src()){
            $filename = pathinfo($src, PATHINFO_BASENAME);
            return '<img class="'.$class.'" src="/img/'.$filename.'" alt="picture of '.$this->name.'" />';
        }else{
            return false;
        }
    }

    /**
     * Check if a picture was uploaded or not
     * @return string/null as picture path or null if not founded
     */
    private function picture_src(){
        foreach (self::PICTURE_EXTENSIONS as $extension){
            $file = UPLOADS.$this->get_name_sanitized().'.'.$extension;
            if(file_exists($file)){
                return $file;
            }
        }
        return false;
    }
    
    /**
     * Upload given file
     * @param \Psr\Http\Message\UploadedFileInterface $file
     * @return bool true if success
     */
    function upload_picture(\Psr\Http\Message\UploadedFileInterface $file){
        $this->delete_old_picture();
        $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        if(in_array($extension, self::PICTURE_EXTENSIONS)){
            $targetPath = UPLOADS.$this->get_name_sanitized().'.'.$extension;
            $file->moveTo($targetPath);
            return file_exists($targetPath);
        }
        return false;
    }
    
    /**
     * Delete old pictures who match with this Skill's name
     */
    private function delete_old_picture(){
        foreach ( glob( UPLOADS.$this->get_name_sanitized().'.*' ) as $picture ){
            if(is_writable($picture)){unlink($picture);}
        }
    }
    
    /**
     * Render this skill to Html (name + progress bar)
     * @return string as Html tag
     */
    function to_html():string{
        return $this->name.$this->progress_bar_html();
    }
    
    /**
     * Render an Html progress bar for the score
     * @return string as Html tag
     */
    private function progress_bar_html():string{
        return '<progress value='.$this->score.' max="'.self::MAX.'">'.$this->score.'/'.self::MAX.'</progress>';
    }
}
