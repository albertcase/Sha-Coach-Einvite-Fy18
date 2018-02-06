<?php
namespace EInviteBundle;

use Core\Controller;


class ApiController extends Controller {

	public function submitAction() {
		$_db = new \forms\phoneNumber('POST');
		return $this->dataPrint($_db->doData());
	}

	public function logindinnerAction() {
		$_db = new \forms\activeDinners('POST');
		return $this->dataPrint($_db->doData());
	}

	public function loginmeets1Action() {
		$_db = new \forms\active1Meets('POST');
		return $this->dataPrint($_db->doData());
	}

	public function loginmeets2Action() {
		$_db = new \forms\active2Meets('POST');
		return $this->dataPrint($_db->doData());
	}

	public function guestinfoAction() {
		$_db = new \forms\guestInfo('POST');
		return $this->dataPrint($_db->doData());
	}

	public function userinfocallbackAction(){
		$postStr = json_decode($GLOBALS["HTTP_RAW_POST_DATA"], true);
		if(!is_array($postStr))
			return $this->dataPrint(array('code' => '11', 'msg' => 'no data'));
		if(isset($postStr['code']) && $postStr['code'] == '200' && isset($postStr['data'])){
			$insql = array(
				'openid' => isset($postStr['data']['openid'])?$postStr['data']['openid']:'',
				'nickname' => isset($postStr['data']['nickname'])?$postStr['data']['nickname']:'',
				'headimgurl' => isset($postStr['data']['headimgurl'])?$postStr['data']['headimgurl']:'',
			);
			$_db = new \Lib\DatabaseAPI();
			$_db->insertNewUser($insql);
		}
		return $this->dataPrint(array('code' => '10', 'msg' => 'success'));
	}

	public function sourcejsonAction(){
		$_db = new \Lib\DatabaseAPI();
		return $this->dataPrint($_db->allAwardInfo());
	}

	public function downloaduserinfoAction(){
		if (isset($_SERVER['PHP_AUTH_USER'])) {
			if($_SERVER['PHP_AUTH_USER'] == COACH_NAME && $_SERVER['PHP_AUTH_PW'] == COACH_PWD){
				$form = new \forms\downloadData();
				return $this->Response($form->doData());
			}
		}
		header('WWW-Authenticate: Basic realm="My Realm"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Text to send if user hits Cancel button';
		exit;
	}

	public function downloaduserinfo2Action(){
		if (isset($_SERVER['PHP_AUTH_USER'])) {
			if($_SERVER['PHP_AUTH_USER'] == COACH_NAME && $_SERVER['PHP_AUTH_PW'] == COACH_PWD){
				$form = new \forms\downloadData();
				return $this->Response($form->doData2());
			}
		}
		header('WWW-Authenticate: Basic realm="My Realm"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Text to send if user hits Cancel button';
		exit;
	}

	public function registerAction(){
		$data = array(
			'name' => 'jssdk for coach_einvite',
			'domain' => 'http://vipinvitation.samesamechina.com'
		);
		return $this->dataPrint($data);
	}

	public function demonloginAction() {
		$_SESSION['openid'] = 'wwssssssssssssssssadawdawad';
		$data = array(
			'openid' => 'oKCDxjivJ92ky4dxLT8dt1jcXtn4',
			'nickname' => 'nickname',
			'headimgurl' => 'http://test.com/oKCDxjivJ92ky4dxLT8dt1jcXtn4'
		);
		$_db = new \Lib\DatabaseAPI();
		$_db->insertNewUser($data);
		return $this->Response('success');
	}

	public function entranceAction() {
		$param = json_decode(file_get_contents("php://input"));
        if(is_null($param))
        	return $this->dataPrint(['status' => 101, "msg" => "参数错误！"]);
        $_db = new \Lib\DatabaseAPI();
        switch ($param->op) {
        	case 'checkin':
        		$checkinStatus = $_db->isCheckIn($param->awardcode);
        		//qrcode failed
        		if(!$checkinStatus)
        			return $this->dataPrint(['status' => 102, "msg" => "二维码无效！"]);

        		//签到和取消签到
        		if($checkinStatus->checkinstatus == 0){
        			$_db->checkin($param->awardcode, 1);
        			return $this->dataPrint(['status' => 200, "msg" => "签到成功！"]);
        		} else {
        			$_db->checkin($param->awardcode, 0);
    				return $this->dataPrint(['status' => 201, "msg" => "取消签到！"]);
        		}
        		break;
        	
        	case 'gift':
        		$giftStatus= $_db->isGift($param->awardcode);
        		//qrcode failed
        		if(!$giftStatus)
        			return $this->dataPrint(['status' => 102, "msg" => "二维码无效！"]);

        		//领取礼物
        		if($giftStatus->giftstatus == 0){
        			$_db->getGift($param->awardcode, 1);
        			return $this->dataPrint(['status' => 202, "msg" => "礼物领取成功！"]);
        		} else {
        			$_db->getGift($param->awardcode, 0);
    				return $this->dataPrint(['status' => 203, "msg" => "取消领取礼物！"]);
        		}
        		break;

        	default:
        		break;
        }
        exit;
	}

}
