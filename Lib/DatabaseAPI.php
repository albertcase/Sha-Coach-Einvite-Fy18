<?php
namespace Lib;
/**
 * DatabaseAPI class
 */
class DatabaseAPI {

	private $db;

	/**
	 * Initialize
	 */
	public function __construct(){
		$connect = new \mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
		$this->db = $connect;
		$this->db->query('SET NAMES UTF8');
	}

	public function findFileByOpenid($openid, $city = ''){
		$sql = "SELECT coach_award.awardcode,coach_award.meettime FROM coach_award WHERE coach_award.openid = ? AND  coach_award.city = ?";
		// $sql = "SELECT `awardcode`, FROM `coach_einvite` WHERE `openid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("ss", $openid, $city);
		$res->execute();
		$res->bind_result($awardcode,$meettime);
		if($res->fetch()) {
			$result = new \stdClass();
			$result->awardcode = $awardcode;
			$result->meettime = $meettime;
			return $result;
		}
		return false;
	}

	public function registerAward($openid, $callnumber, $city = ''){
		if(!$res = $this->checkCallnumber($callnumber, $city)){
			$this->insertTry($openid, $city);
			return 'A';//not have this callnumber;
		}
		if($res->openid)
			return 'B';//alread registered
		if($this->insertTry($openid, $city) === 'A')
			return 'E';//not have this openid
		$sql = "UPDATE `coach_award` SET `openid` = ?,`awardcode` = ? WHERE `city` = ? AND `callnumber` LIKE '%{$callnumber}'";
		$res = $this->db->prepare($sql);
		$code = md5('openid'.$openid.$city);
		$res->bind_param("sss", $openid, $code, $city);
		if($res->execute())
			return 'C';//update success
		return 'D';//update errors
	}

	public function insertTry($openid, $city){
		if(!$this->checkOpenid($openid))
			return 'A';//not have this user
		if(!$this->checkTrytimes($openid, $city)){
			$this->firstTry($openid, $city);
		}
		$sql = "UPDATE `coach_trytimes` SET `trytimes` = `trytimes` + 1 WHERE `openid` = ? AND `city` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("ss", $openid, $city);
		if($res->execute())
			return true;
		return false;
	}

	public function firstTry($openid, $city){
		$sql = "INSERT INTO `coach_trytimes` SET `openid` = ?, `city` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("ss", $openid, $city);
		if($res->execute())
			return true;
		return false;
	}


	public function insertNewUser($data){
		if($this->checkOpenid($data['openid']))
			return false;
		$sql = "INSERT INTO `coach_userinfo` SET `openid` = ?,`username` = ? ,`userhandurl` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("sss", $data['openid'], $data['nickname'], $data['headimgurl']);
		if($res->execute())
			return $res->insert_id;
		return false;
	}

	public function checkOpenid($openid){
		$sql = "SELECT `id` FROM `coach_userinfo` WHERE `openid` = ? ";
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

	public function checkTrytimes($openid, $city = ''){
		$sql = "SELECT `id`,`openid`,`trytimes` FROM `coach_trytimes` WHERE `openid` = ? AND `city` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("ss", $openid, $city);
		$res->execute();
		$res->bind_result($id, $openid, $trytimes);
		if($res->fetch()) {
			$result = new \stdClass();
			$result->id = $id;
			$result->openid = $openid;
			$result->trytimes = $trytimes;
			return $result;
		}
		return false;
	}

	public function checkAwardOpenid($openid){
		$sql = "SELECT `openid` FROM `coach_award` WHERE `openid` = ? ";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $openid);
		$res->execute();
		$res->bind_result($ropenid);
		if($res->fetch()) {
			$result = new \stdClass();
			$result->openid = $ropenid;
			return $result;
		}
		return false;
	}

	public function checkCallnumber($number, $city){
		$number = intval($number);
		$sql = "SELECT `openid`,`callnumber` FROM `coach_award` WHERE `city` = ? AND `callnumber` LIKE '%{$number}' ";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $city);
		$res->execute();
		$res->bind_result($openid,$callnumber);
		if($res->fetch()) {
			$result = new \stdClass();
			$result->openid = $openid;
			$result->callnumber = $callnumber;
			return $result;
		}
		return false;
	}

	public function checkinActive($code){
		$sql = "SELECT `openid`,`awardcode`,`callnumber`,`meettime`,`checkinstatus`,`giftstatus`,`dinnerstatus`,`guide`,`memname` FROM `coach_award` WHERE `awardcode` = ? ";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $code);
		$res->execute();
		$res->bind_result($openid,$awardcode,$callnumber,$meettime,$checkinstatus,$giftstatus,$dinnerstatus,$guide,$memname);
		if($res->fetch()) {
			$result = new \stdClass();
			$result->awardcode = $awardcode;
			$result->callnumber = $callnumber;
			$result->checkinstatus = (string) $checkinstatus;
			$result->giftstatus = (string) $giftstatus;
			// $result->dinnerstatus = $dinnerstatus;
			$result->guide = $guide;
			$result->memname = $memname;
			return $result;
		}
		return false;
	}

	public function active1Meets($awardcode){
		if(!$status = $this->ckeckMeet1status($awardcode))
			return false;
		if($status->meet1status){
				$ms = '0';
		}else{
				$ms = '1';
		}
		$sql = "UPDATE `coach_award` SET `meet1status` = ? ,`inmeettime` = ? WHERE `awardcode` = ? ";
		$res = $this->db->prepare($sql);
		$time = time();
		$res->bind_param("sss", $ms,$time,$awardcode);
		if($res->execute())
			return true;
		return false;
	}

	public function active2Meets($awardcode){
		if(!$status = $this->ckeckMeet2status($awardcode))
			return false;
		if($status->meet2status){
				$ms = '0';
		}else{
				$ms = '1';
		}
		$sql = "UPDATE `coach_award` SET `meet2status` = ? ,`inmeettime` = ? WHERE `awardcode` = ? ";
		$res = $this->db->prepare($sql);
		$time = time();
		$res->bind_param("sss", $ms,$time,$awardcode);
		if($res->execute())
			return true;
		return false;
	}

	public function ckeckMeet1status($awardcode){
		$sql = "SELECT `meet1status` FROM `coach_award` WHERE `awardcode` = ? ";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $awardcode);
		$res->execute();
		$res->bind_result($meet1status);
		if($res->fetch()) {
			$result = new \stdClass();
			$result->awardcode = $awardcode;
			$result->meet1status = $meet1status;
			return $result;
		}
		return false;
	}

	public function ckeckMeet2status($awardcode){
		$sql = "SELECT `meet2status` FROM `coach_award` WHERE `awardcode` = ? ";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $awardcode);
		$res->execute();
		$res->bind_result($meet2status);
		if($res->fetch()) {
			$result = new \stdClass();
			$result->meet2status = $meet2status;
			return $result;
		}
		return false;
	}

	public function ckeckDinners($awardcode){
		$sql = "SELECT `dinnerstatus` FROM `coach_award` WHERE `awardcode` = ? ";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $awardcode);
		$res->execute();
		$res->bind_result($dinnerstatus);
		if($res->fetch()) {
			$result = new \stdClass();
			$result->dinnerstatus = $dinnerstatus;
			return $result;
		}
		return false;
	}


	public function activeDinners($awardcode){
		if(!$status = $this->ckeckDinners($awardcode))
			return false;
		if($status->dinnerstatus){
				$ms = '0';
		}else{
				$ms = '1';
		};
		$sql = "UPDATE `coach_award` SET `dinnerstatus` = ? ,`indinnertime` = ? WHERE `awardcode` = ? ";
		$res = $this->db->prepare($sql);
		$time = time();
		$res->bind_param("sss", $ms,$time,$awardcode);
		if($res->execute())
			return true;
		return false;
	}

	public function insertIntoUser($data){
		$sql = "INSERT INTO `coach_award` SET `meettime` = ?, `guide` = ?, `sex` = ?, `memname` = ?, `callnumber` = ? ";
		$res = $this->db->prepare($sql);
		$res->bind_param("ssss", $meettime, $guide, $sex,$memname,$callnumber);
		if($res->execute())
			return $res->insert_id;
		else
			return FALSE;
	}

	public function allAwardInfo(){
		$sql = "SELECT `memname`, `city`,`sex`,`callnumber`,`meettime`,`meet1status`,`meet2status`,`inmeettime`,`guide`,`awardcode` FROM `coach_award`";
		$res = $this->db->prepare($sql);
		$res->execute();
		$res->bind_result($memname, $city ,$sex, $callnumber, $meettime, $meet1status, $meet2status, $inmeettime, $guide, $awardcode);
		$out = array();
		while($res->fetch()) {
			array_push($out, array(
				'memname' => $memname,
				'awardcode' => ($awardcode)?'已领':'未领',
				'sex' => ($sex)?(($sex==1)?'男':'女'):'',
				'callnumber' => $callnumber,
				'guide' => $guide,
				'meettime' => ($meettime)?(($meettime==1)?'13:30':'15:30'):'',
				'meet1status' => ($meet1status)?'已签到':'未签到',
				'meet2status' => ($meet2status)?'已签到':'未签到',
				'inmeettime' => ($inmeettime)?date('Y-m-d H:i:s', $inmeettime):'',
				'city' => $city,
			));
		}
		return $out;
	}

	public function allAwardInfo2(){
		$sql = "SELECT `memname`, `city` ,`sex`,`callnumber`,`meettime`,`meet1status`,`meet2status`,`inmeettime`,`guide`,`awardcode`,`openid` FROM `coach_award`";
		$res = $this->db->prepare($sql);
		$res->execute();
		$res->bind_result($memname, $city, $sex, $callnumber, $meettime, $meet1status, $meet2status, $inmeettime, $guide, $awardcode, $openid);
		$out = array();
		while($res->fetch()) {
			array_push($out, array(
				'memname' => $memname,
				'openid' => $openid,
				'awardcode' => ($awardcode)?'已领':'未领',
				'sex' => ($sex)?(($sex==1)?'男':'女'):'',
				'callnumber' => $callnumber,
				'guide' => $guide,
				'meettime' => ($meettime)?(($meettime==1)?'13:30':'15:30'):'',
				'meet1status' => ($meet1status)?'已签到':'未签到',
				'meet2status' => ($meet2status)?'已签到':'未签到',
				'inmeettime' => ($inmeettime)?date('Y-m-d H:i:s', $inmeettime):'',
				'city' => $city,
			));
		}
		return $out;
	}
	//////

	public function watchdog($type, $data){
		$nowtime = NOWTIME;
		$sql = "INSERT INTO `watchdog` SET `type` = ?, `data` = ?, `created` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("sss", $type, $data, $nowtime);
		if($res->execute())
			return $res->insert_id;
		else
			return FALSE;
	}

	public function findFileByFid($fid){
		$sql = "SELECT `fid`, `filename` FROM `file` WHERE `fid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $fid);
		$res->execute();
		$res->bind_result($fid, $filename);
		if($res->fetch()) {
			$file = new \stdClass();
			$file->fid = $fid;
			$file->filename = $filename;
			return $file;
		}
		return NULL;
	}

	public function findVideoByVid($vid){
		$sql = "SELECT `vid`, `fid`, `id` FROM `video` WHERE `vid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $vid);
		$res->execute();
		$res->bind_result($vid, $fid, $id);
		if($res->fetch()) {
			$video = new \stdClass();
			$video->vid = $vid;
			$video->fid = $fid;
			$video->id = $id;
			return $video;
		}
		return NULL;
	}

	public function findVideoById($id){
		$sql = "SELECT `vid`, `fid`, `id`, `ballot` FROM `video` WHERE `id` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $id);
		$res->execute();
		$res->bind_result($vid, $fid, $id, $ballot);
		if($res->fetch()) {
			$video = new \stdClass();
			$video->vid = $vid;
			$video->fid = $fid;
			$video->id = $id;
			$video->ballot = $ballot;
			return $video;
		}
		return NULL;
	}

	public function updateVideo($file){
		$sql = "UPDATE `video` SET `status` = 1 WHERE `fid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $file->fid);
		if($res->execute())
			return $file;
		else
			return FALSE;
	}

	public function getUserVideo($vid) {
		$sql = "SELECT uid FROM `user_video` WHERE `vid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $vid);
		$res->execute();
		$res->bind_result($uid);
		if($res->fetch()) {
			return $uid;
		}
		return 0;
	}

	public function bindVideo($uid, $vid) {
		$sql = "INSERT INTO `user_video` SET `uid` = ?, `vid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("ss", $uid, $vid);
		if ($res->execute()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function insertUser($openid) {
		$user = $this->findUserByOpenid($openid);
		if ($user) {
			return $user;
		}
		$sql = "INSERT INTO `user` SET `openid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $openid);
		if ($res->execute()) {
			return $this->findUserByOpenid($openid);
		} else {
			return FALSE;
		}
	}

	public function findUserByOpenid($openid) {
		$sql = "SELECT `id`, `openid`, `mobile` FROM `user` WHERE `openid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $openid);
		$res->execute();
		$res->bind_result($uid, $openid, $mobile);
		if($res->fetch()) {
			$user = new \stdClass();
			$user->uid = $uid;
			$user->openid = $openid;
			$user->mobile = $mobile;
			$_SESSION['user'] = $user;
			return $user;
		}
		return NULL;
	}

	public function userLoad(){
		if(isset($_SESSION['user'])){
			return $_SESSION['user'];
		}
		return NULL;

	}

	public function saveMobile($uid, $mobile) {
		$sql = "UPDATE `user` SET `mobile` = ? WHERE `id` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("ss", $mobile, $uid);
		if ($res->execute()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function ballot($uid, $vid) {
		$sql = "SELECT `id` FROM `ballot` WHERE `uid` = ? and `vid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("ss", $uid, $vid);
		$res->execute();
		$res->bind_result($id);
		if($res->fetch()) {
			return FALSE;
		}
		$sql = "INSERT INTO `ballot` SET `uid` = ?, `vid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("ss", $uid, $vid);
		if ($res->execute()) {
			//投票成功
			$sql = "UPDATE `video` SET `ballot` = ballot+1 WHERE `vid` = ?";
			$res2 = $this->db->prepare($sql);
			$res2->bind_param("s", $vid);
			$res2->execute();
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function isballot($uid, $vid) {
		$sql = "SELECT `id` FROM `ballot` WHERE `uid` = ? and `vid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("ss", $uid, $vid);
		$res->execute();
		$res->bind_result($id);
		if($res->fetch()) {
			return 1;
		}
		return 0;
	}

	public function getballot($vid) {
		$sql = "SELECT count(`id`) FROM `ballot` WHERE `vid` = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $vid);
		$res->execute();
		$res->bind_result($num);
		if($res->fetch()) {
			return $num;
		}
		return 0;
	}

	public function isCheckIn($awardcode) {
		$sql = "SELECT `checkinstatus` FROM `coach_award` WHERE `awardcode` = ? ";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $awardcode);
		$res->execute();
		$res->bind_result($checkinstatus);
		if($res->fetch()) {
			$result = new \stdClass();
			$result->checkinstatus = $checkinstatus;
			return $result;
		}
		return false;
	}

	public function checkin($awardcode, $status) {
		$sql = "UPDATE `coach_award` SET `checkinstatus` = ? WHERE `awardcode` = ? ";
		$res = $this->db->prepare($sql);
		$time = time();
		$res->bind_param("ss", $status, $awardcode);
		if($res->execute())
			return true;
		return false;
	}

	public function isGift($awardcode) {
		$sql = "SELECT `giftstatus` FROM `coach_award` WHERE `awardcode` = ? ";
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $awardcode);
		$res->execute();
		$res->bind_result($giftstatus);
		if($res->fetch()) {
			$result = new \stdClass();
			$result->giftstatus = $giftstatus;
			return $result;
		}
		return false;
	}

	public function getGift($awardcode, $status) {
		$sql = "UPDATE `coach_award` SET `giftstatus` = ? WHERE `awardcode` = ? ";
		$res = $this->db->prepare($sql);
		$time = time();
		$res->bind_param("ss", $status, $awardcode);
		if($res->execute())
			return true;
		return false;
	}
}
