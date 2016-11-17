<?php
/**
 * 
 * toHtml Class
 * Takes data from an executed Statement and returns it the html required element from the defined functions
 * Table or Select
 * 
 * @author Ing. Victor Alfonso Rivera Anzures
 * 
 */

class toHtml{
    
    private $element; 
    /**
     * @var array Receives data as an array separated by user defined separator __SEPARATOR
     */
    private $data;
    /**
     * @var int Length of the data array 
     */
    private $dataLen;
    
    public function __construct($data) {
        $this->data = $data;
        $this->dataLen = count($this->data);
    }
    
    /**
     *
     * @param string $id The id of the select element
     * @param string $class The class of the select element
     * @param string $event Events of the select element (i.e. onclick, onselect, onchange, ...)
     * @param string $addAttr Additional attributes of the select element (i.e. name, rel, ...)
     * @param integer $defaultIndex in case of a default selected index
     * @param boolean $optionsOnly to define if we only want the option tags or the whole select tag structure
     * @param boolean $emptyValue to define if we want to start the options with an empty value (i.e. option value='')
     * 
     */

    public function toSelect($id = "", $class = "", $event = "", $addAttr = "", $defaultIndex = "", $optionsOnly = false, $emptyValue = true){
        
        for($i = 0; $i<$this->dataLen; $i++){
            
            list($elemId, $elemName) = explode(__SEPARATOR, $this->data[$i]);
            
            $selected = ($defaultIndex != "" && $defaultIndex == $elemId) ? "selected='selected'" : "";
            
            $this->element .= "<option value='{$elemId}' {$selected}>".utf8_encode($elemName)."</option>";
        }
        
        if(!$optionsOnly){
            $openSelTag = "<select id='{$id}' class='{$class}' {$addAttr} {$event}>";
            $closeSelTag = "</select>";
        }else{
            $openSelTag = "";
            $closeSelTag = "";
        }
        $optionZero = ($emptyValue == true) ?  "<option value=''>---</option>" : "";
        
        return $openSelTag.$optionZero.$this->element.$closeSelTag;
        
    }
    
    /**
     * @TODO finish function to create html tables
     * @param type $id The id of the table element
     * @param type $class The class of the table element
     * @param type $addAttr Additional attributes of the table element
     * @param type $numCols Number of columns of the table element
     * 
     */
    
    public function toTable($id = "", $class = "", $addAttr = "", $numCols = 1){
        
        $this->element = "<table id='{$id}' class='{$class}' {$addAttr}>";
        
        foreach($numCols as $cols){
            
        }
        
        
        
    }
    
    public function __destruct() {
        unset($this->element);
        unset($this->data);
        unset($this->dataLen);
    }
    
}
?>