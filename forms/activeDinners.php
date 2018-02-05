<?php
namespace forms;

use Core\FormRequest;

class activeDinners extends FormRequest{
  public function rule(){
    return array(
      'awardcode' => array('awardcode' => array()),
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
    if($_db->activeDinners($this->getdata['awardcode']))
      return array('code' => '10' ,'msg' => '晚宴签到成功');
    return array('code' => '9' ,'msg' => '晚宴签到失败');
  }

  public function awardcode_Ckeck($key){
    return (bool)preg_match("/^[0-9a-zA-Z]{32}+$/" ,trim($key));
  }
}
