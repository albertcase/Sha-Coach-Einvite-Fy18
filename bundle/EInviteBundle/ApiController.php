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
		// $data = array(
		// 	'code' => 200,
		// 	'data' => array(
		// 		'openid' => '1qazxsw23edc',
		// 		'nickname' => 'dirc',
		// 		'headimgurl' => 'asdasdasdasdasdasdasd'
		// 	)
		// );
		// print_r($_SERVER);
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

}
