<?php
namespace forms;

use Core\FormRequest;

class phoneNumber extends FormRequest{
  public function rule(){
    return array(
      'callnumber' => array('callnumber' => array()),
      'city' => array('city' => array()),
    );
  }

  public function doData(){
    if($this->Confirm() > 0){
      return array('code' => '11' ,'msg' => '输入错误');
    }
    return $this->dealData();
  }

  public function dealData(){
    $_db = new \Lib\DatabaseAPI();
    $openid = isset($_SESSION['openid'])?$_SESSION['openid']:'';
    if(!$openid)
      return array('code' => '2' ,'msg' => '您还未登陆');
    if($time = $_db->checkTrytimes($openid, $this->getdata['city'])){
      if(isset($time->trytimes) && $time->trytimes > 3)
        return array('code' => '7' ,'msg' => '您已经超过注册次数');
    }
    if($info = $_db->findFileByOpenid($openid, $this->getdata['city'])){
      if(isset($info->awardcode) && $info->awardcode)
        return array('code' => '6' ,'msg' => '您已经注册过');
    }
    $result = $_db->registerAward($openid, $this->getdata['callnumber'], $this->getdata['city']);
    if($result == 'A')
      return array('code' => '9' ,'msg' => '号码不存在');
    if($result == 'B')
      return array('code' => '8' ,'msg' => '该号码已领取电子邀请函');
    if($result == 'C')
      return array('code' => '10' ,'msg' => '注册成功');
    if($result == 'E')
      return array('code' => '5' ,'msg' => '请刷新页面');
    return array('code' => '4' ,'msg' => '注册错误');
  }

  public function callnumber_Ckeck($key){
    return (bool)preg_match("/^[0-9]{6}+$/" ,trim($key));
  }

  public function city_Ckeck($key){
    $key = trim($key);
    $citytrans = require_once dirname(__FILE__).'/../config/citytranslate.php';
    $citylist = require_once dirname(__FILE__).'/../config/citylist.php';
    if(isset($citytrans[$key])){
      $this->getdata['city'] = $citytrans[$key];
      $key = $citytrans[$key];
    }
    if(in_array($key, $citylist))
      return true;
    return false;
  }

}
