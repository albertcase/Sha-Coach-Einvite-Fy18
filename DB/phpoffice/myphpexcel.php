
<?php
ini_set('display_errors','on');
require_once dirname(__FILE__).'/Classes/PHPExcel.php';
require_once dirname(__FILE__).'/Classes/PHPExcel/IOFactory.php';

  class myphpexcel{

    public function __construct(){
      $connect = new \mysqli('127.0.0.1', 'root', '', 'coach_einvite');
      $this->db = $connect;
      $this->db->query('SET NAMES UTF8');
    }

    public function insertIntoUser($data){
      // print_r($data);
      $sql = "INSERT INTO `coach_award` SET `meettime` = ?, `guide` = ?, `sex` = ?, `memname` = ?, `callnumber` = ? , `city` = ?";
      $res = $this->db->prepare($sql);
      $res->bind_param("ssssss", $data['meettime'], $data['guide'], $data['sex'], $data['memname'], $data['callnumber'], $data['city']);
      if($res->execute())
        return $res->insert_id;
      else
        return FALSE;
    }

    public function loadexcel5($file){
      $PHPExcel = PHPExcel_IOFactory::load($file);
      $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
      $highestRow = $sheet->getHighestRow(); // 取得总行数
      $highestColumm = $sheet->getHighestColumn(); // 取得总列数
      return array(
        'sheet' => $sheet,
        'highestRow' => $highestRow,
        'highestColumm' => $highestColumm,
      );
    }

    public function insertintoSql(){
      $file = $_FILES;
      if(!isset($file["coachvip"]))
        return array('code' => '9', 'msg' => 'upload file errors');
      $uploadname = dirname(__FILE__)."/r1018.xls";
      $result = move_uploaded_file($file["coachvip"]["tmp_name"],$uploadname);
      $result = true;
      if($result){
        $excel = $this->loadexcel5(realpath($uploadname));
        $sheet = $excel['sheet'];
        $highestRow = $excel['highestRow'];
        $highestColumm = $excel['highestColumm'];
        for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
            for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
                $title[$column] = $this->translate(trim($sheet->getCell($column.$row)->getValue()));
            }
            if(!in_array('',$title)){//$title is the keys
            break;
            }
        }
        $row++;
        $out = array(
          'del' => array(),
          'add' => array(),
        );
        $data = array();
        for ($row ; $row <= $highestRow; $row++){
            for ($column = 'A'; $column <= $highestColumm; $column++) {
              $col = $title[$column];
              if(in_array($col, array('callnumber','memname','sex', 'guide', 'meettime', 'city')))//control insert datas
                $data[$col] = $this->translate(trim($sheet->getCell($column.$row)->getValue()));
            }
            if(implode($data)!=""){
              $this->insertIntoUser($data);
            }
        }
        // unlink($uploadname);
        return array('code' => '10', 'msg' => 'success');
      }
      // unlink($uploadname);
      return array('code' => '9', 'msg' => 'upload file errors');
    }

    public function translate($key){
      $strings = array(
        '手机号码后四位' => 'callnumber',
        '会员姓名' => 'memname',
        '性别' => 'sex',
        '负责人员' => 'guide',
        'VIP场次' => 'meettime',
        '4点' => 2,
        '2点' => 1,
        '16:30:00' => 2,
        '14:30:00' => 1,
        '女' => 2,
        '男' => 1,
        '城市' => 'city',
        '苏州' => 'suzhou',
        '西安' => 'xian',
        '昆明' => 'kunming'
      );
      if(isset($strings[$key]))
        return $strings[$key];
      return $key;
    }
}

$myphpexcel = new myphpexcel();
print_r(json_encode($myphpexcel->insertintoSql()));
?>
