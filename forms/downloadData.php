<?php
namespace forms;

class downloadData{

  public function doData(){
    $data = $this->getDatas();
    $name = 'MeetRegister@'.date("Y-m-d H:i:s");
    $excel = new \DB\myphpExcel();
    return $excel->excelfile($data,$name);
  }

  public function getDatas(){
    $_db = new \Lib\DatabaseAPI();
    return $_db->allAwardInfo();
  }

  public function doData2(){
    $data = $this->getDatas2();
    $name = 'system@'.date("Y-m-d H:i:s");
    $excel = new \DB\myphpExcel();
    return $excel->excelfile2($data,$name);
  }

  public function getDatas2(){
    $_db = new \Lib\DatabaseAPI();
    return $_db->allAwardInfo2();
  }

  public function translate($in){
    $tr = array(
      "memname" => "名字",
      "city" => "城市",
      "sex" => "性别",
      "callnumber" => "手机号",
      "meettime" => "入场场次",
      "meet1status" => "13：30签到状态",
      "meet2status" => "15：30签到状态",
      "inmeettime" => "实际到场时间"
    );
    return (isset($tr[$in]))?$tr[$in]:$in;
  }


}
