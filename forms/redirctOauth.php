<?php
namespace forms;

use Core\FormRequest;

class redirctOauth extends FormRequest{
  public function rule(){
    return array(
      'callnumber' => array('callnumber' => array()),
    );
  }

  public function doData(){
    if($this->Confirm() > 0){
      return array('code' => '11' ,'msg' => 'callnumber error');
    }
    return $this->dealData();
  }

  public function dealData(){
    $HTTP_HOST = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'127.0.0.1:9301';
    $REQUEST_URI = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
    $cuurl = urlencode($HTTP_HOST.$REQUEST_URI);
    $redirect = array(
      "callback_url":"http://yourapp.curio.im/getdata",
      "redirect_url":"http://yourapp.curio.im",
      "scope":"userinfo"
    );
  }

  public function post_data($url, $param, $is_file = false, $return_array = true){
    if (! $is_file && is_array ( $param )) {
      $param = json_encode($param, JSON_UNESCAPED_UNICODE);
    }
    if ($is_file) {
      $header [] = "content-type: multipart/form-data; charset=UTF-8";
    } else {
      $header [] = "content-type: application/json; charset=UTF-8";
    }
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
    curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
    curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
    curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    $res = curl_exec ( $ch );

    // 	$flat = curl_errno ( $ch );
    // 	if ($flat) {
    // 		$data = curl_error ( $ch );
    // 		addWeixinLog ( $flat, 'post_data flat' );
    // 		addWeixinLog ( $data, 'post_data msg' );
    // 	}

    curl_close ( $ch );

    if($return_array)
      $res = json_decode ( $res, true );
    return $res;
  }

  public function callnumber_Ckeck($key){
    return (bool)preg_match("/^[0-9]{6}+$/" ,trim($key))
  }
}
