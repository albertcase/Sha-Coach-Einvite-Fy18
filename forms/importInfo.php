<?php
ini_set('display_errors', 1);
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once dirname(dirname(__FILE__)).'/DB/phpoffice/Classes/PHPExcel.php';
require_once dirname(dirname(__FILE__)).'/DB/phpoffice/Classes/PHPExcel/IOFactory.php';

class importInfo
{
    private $db;
    public function __construct()
    {
        $connect = new \mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        $this->db = $connect;
        $this->db->query('SET NAMES UTF8');
    }

    public function loadexcel5($file){
        $PHPExcel = PHPExcel_IOFactory::load($file);
        $objWorksheet = $PHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); // 取得总行数
        $highestColumn = $objWorksheet->getHighestColumn(); // 取得总列数
        $arr = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z');
        //echo $highestRow.$highestColumn;
        // 一次读取一列
        $res = array();
        for ($row = 2; $row <= $highestRow; $row++) {
            for ($column = 1; $arr[$column] != 'I'; $column++) {
                $val = $objWorksheet->getCellByColumnAndRow($column-1, $row)->getValue();
                $res[$row-2][$column] = $val;
            }
        }
        return $res;
    }

    public function checkOpenid($openid)
    {
        $sql = "SELECT `id` FROM `coach_award` WHERE `openid` = ?";
        $res = $this->db->prepare($sql);
        $res->bind_param("s", $openid);
        $res->execute();
        $res->bind_result($id);
        if($res->fetch()) {
            $result = new \stdClass();
            $result->id = $id;
            return $result;
        }
        return false;
    }

    public function updateInfo($info)
    {
        $sql = "UPDATE `coach_award` SET `memname` = ? ,`guide` = ? WHERE `openid` = ? ";
        $res = $this->db->prepare($sql);
        $time = time();
        $res->bind_param("sss", $info->memname, $info->guide, $info->openid);
        if($res->execute())
            return true;
        return false;
    }

}

$import = new importInfo();
$res = $import->loadexcel5("./checkin.xlsx");
foreach ($res as $k => $v) {
    $isOpenid = $import->checkOpenid($v[1]);
    if($isOpenid) {
        $info = new \stdClass();
        $info->openid = $v[1];
        $info->memname = $v[4];
        $info->guide = $v[8];
        $upstatus = $import->updateInfo($info);
        if($upstatus) {
            echo "openid:{$info->openid} 导入信息成功！\n";
        } else {
            echo "openid:{$info->openid} 导入信息失败！\n";
        }
    }
}

