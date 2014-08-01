<?php 
/** 
* Simple TemplateParser Class 
* 
* @author  :  MA Razzaque Rupom <rupom_315@yahoo.com>, <rupom.bd@gmail.com> 
*             Moderator, phpResource (http://groups.yahoo.com/group/phpresource/) 
*             URL: http://www.rupom.info   
* @version :  1.0 
* Purpose  :  Parsing Simple Template File and Data that Contains Macros 
*/ 

class TemplateParser 
{ 
     var $data; 
      
     /** 
     * Initializes "macro=>value" array 
     * @param Array "macro=>value" array 
     * @return none 
     */ 
   function initData($data) 
   { 
      $this->data = array();        
      $this->data = $data;        
   } 
    
   /** 
     * Parses template file 
     * @param template filename 
     * @return parsed template 
     */ 
   function parseTemplateFile($templateFile) 
   { 
      $searchPattern          = "/\{([a-zA-Z0-9_]+)\}/i"; // macro delimiter "{" and "}" 
      $replacementFunction    = array(&$this, 'parseMatchedText');  //Method callbacks are performed this way  
      $fileData               = file_get_contents($templateFile);                         
      $parsedTemplate         = preg_replace_callback($searchPattern, $replacementFunction, $fileData); 
       
      return $parsedTemplate; 
   } 
  
   /** 
     * Parses template data 
     * @param template data 
     * @return parsed data 
     */ 
   function parseTemplateData($templateData) 
   { 
      $searchPattern          = "/\{([a-zA-Z0-9_]+)\}/i"; //macro delimiter "{" and "}" 
      $replacementFunction    = array(&$this, 'parseMatchedText');  //Method callbacks are performed this way        
      $parsedTemplate         = preg_replace_callback($searchPattern, $replacementFunction, $templateData); 
       
      return $parsedTemplate; 
   } 
    
   /** 
   * Callback function that returns value of a matching macro  
   * @param Array $matches 
   * @return String value of matching macro 
   */ 
   function parseMatchedText($matches) 
   { 
      return $this->data[$matches[1]];     
   } 

} //End Of Class 