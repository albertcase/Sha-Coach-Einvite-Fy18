<?php
namespace Core;

class FormRequest{
  private $mothed;
  public $getdata;
  private $rule = array();
  public $cError = array();

  public function __construct($mothed = 'POST'){
    $this->mothed = 'POST';
    if($mothed != 'POST'){
      $this->mothed = 'GET';
    }
    $this->rule = $this->rule();
    $this->GetData();
  }

  public function rule(){}

  public function GetData(){
    foreach($this->rule as $x => $x_val){
      if($this->mothed == 'POST'){
        $this->getdata[$x] = isset($_POST[$x])?$_POST[$x]:'';
      }else{
        $this->getdata[$x] = isset($_GET[$x])?$_GET[$x]:'';
      }
    }
  }

  public function Confirm(){
    $this->validateValue();
    return count($this->cError);
  }

  /**
   * @param $rule
   * $rule[$param][0] = ckeck function
   * $rule[$param][2] = ckeck theother param
   *   The type of $entity; e.g. 'node' or 'user'.
   **/
  public function validateValue(){
    foreach($this->getdata as $x => $x_val){
      if(is_array($x_val) && isset($this->rule[$x])){
        $this->mckeck($x_val, $this->rule[$x]);
      }else{
        if(isset($this->rule[$x])){
          $this->subckeck($x_val, $this->rule[$x]);
        }
      }
    }
    return true;
  }

  public function mckeck($param, $check){
    foreach($param as $x => $x_val){
      if(is_array($x_val) && !count($x_val) && isset($check[$x])){
        $this->mckeck($x_val, $check[$x]);
      }else{
        if(isset($check[$x])){
          $this->subckeck($x_val, $check[$x]);
        }
      }
    }
    return true;
  }

  public function subckeck($data,$check){
    foreach($check as $x => $x_l){
      if(method_exists($this, $x.'_Ckeck')){
        if(!call_user_func_array(array($this, $x.'_Ckeck'), array($data, $x_l)))
          array_push($this->cError, isset($check['fbMsg'])?$check['fbMsg']:$x.'error'.$data);
      }
    }
    return true;
  }

  public function email_Ckeck($mail) {
    return (bool)filter_var($mail, FILTER_VALIDATE_EMAIL);
  }

  public function url_Ckeck($url, $absolute) {
    if (count($absolute)) {
      return (bool)preg_match("
        /^                                                      # Start at the beginning of the text
        (?:ftp|https?|feed):\/\/                                # Look for ftp, http, https or feed schemes
        (?:                                                     # Userinfo (optional) which is typically
          (?:(?:[\w\.\-\+!$&'\(\)*\+,;=]|%[0-9a-f]{2})+:)*      # a username or a username and password
          (?:[\w\.\-\+%!$&'\(\)*\+,;=]|%[0-9a-f]{2})+@          # combination
        )?
        (?:
          (?:[a-z0-9\-\.]|%[0-9a-f]{2})+                        # A domain name or a IPv4 address
          |(?:\[(?:[0-9a-f]{0,4}:)*(?:[0-9a-f]{0,4})\])         # or a well formed IPv6 address
        )
        (?::[0-9]+)?                                            # Server port number (optional)
        (?:[\/|\?]
          (?:[\w#!:\.\?\+=&@$'~*,;\/\(\)\[\]\-]|%[0-9a-f]{2})   # The path and query (optional)
        *)?
      $/xi", $url);
    }
    else {
      return (bool)preg_match("/^(?:[\w#!:\.\?\+=&@$'~*,;\/\(\)\[\]\-]|%[0-9a-f]{2})+$/i", $url);
    }
  }
}
