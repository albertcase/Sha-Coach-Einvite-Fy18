<?php
namespace Lib;

class PublicFun {

 public function checkNeedSubscribe($openid, $city){
  if(!$this->needSubscribe($city))
    return FALSE;
  $url = "http://coach.samesamechina.com/v2/wx/users/no_cache/{$openid}?access_token=zcBpBLWyAFy6xs3e7HeMPL9zWrd7Xy";
  $userinfo = file_get_contents($url);
  $userinfo = json_decode($userinfo, true);
  if(isset($userinfo['subscribe']) && $userinfo['subscribe']){
      return FALSE;
  }
  return TRUE;
 }

 public function needSubscribe($city){
   $needcitys = require_once dirname(__FILE__).'/../config/needcitys.php';
   if(in_array($city, $needcitys))
    return TRUE;
  return FALSE;
 }

}
