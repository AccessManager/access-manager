<?php 
/** 
 * standalone class for Encryption 
 *  
 * Features : 
 * This class facilitates encoding data to pass between two can be used for 
 * encoding & decoding for cookie value or url param. 
 *   
 * @author sudhir vishwakarma <sudhir.vis@gmail.com> 
 * @copyright Sudhir Vishwakarma  
 *  
 * @version 0.1 27102008 
 * 
 */ 
class Encryption { 
    /** 
     *  Set any difficult Key for guessing 
     * 
     *  @access public 
     */ 
    var $skey = "7d5c65ac0557c2f047c02cfd62980fa0"; 
    /** 
     *  This makes url or cookie value safe after encrypting any value 
     * 
     *  @access public 
     */ 
    public  function safe_b64encode($string) { 
        $data = base64_encode($string); 
        $data = str_replace(array('+','/','='),array('-','_',''),$data); 
        return $data; 
    } 
    /** 
     *  This makes url or cookie value safe after decrypting any value 
     * 
     *  @access public 
     */ 
    public function safe_b64decode($string) { 
        $data = str_replace(array('-','_'),array('+','/'),$string); 
        $mod4 = strlen($data) % 4; 
        if ($mod4) { 
            $data .= substr('====', $mod4); 
        } 
        return base64_decode($data); 
    } 
    /** 
     *  mcrypt libreary required 
     * 
     *  @access public 
     */ 
    public  function enc($value){ 
        if(!$value){return false;} 
        $text = $value; 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB); 
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv); 
        return trim($this->safe_b64encode($crypttext));  
    } 
    /** 
     *  mcrypt libreary required 
     * 
     *  @access public 
     */ 
    public function dec($value){ 
        if(!$value){return false;} 
        $crypttext = $this->safe_b64decode($value);  
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB); 
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv); 
        return trim($decrypttext); 
    } 
} 