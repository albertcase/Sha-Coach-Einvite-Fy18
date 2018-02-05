<?php
namespace EInviteBundle;

use Core\Controller;


class SiteController extends Controller {

	public function oauth2Action(){
		if(isset($_GET['openid']))
			$_SESSION['openid'] = $_GET['openid'];
		if(isset($_GET['callback'])){
			$_SESSION['callback'] = ($_GET['callback'])?$_GET['callback']:'/';
		}
		$oau = isset($_SESSION['oauthuser'])?$_SESSION['oauthuser']:'1';
		if(intval($oau) > 1){
			if(isset($_SESSION['openid'])){
				unset($_SESSION['oauthuser']);
				$insql = array(
					'openid' => isset($_SESSION['openid'])?$_SESSION['openid']:'',
					'nickname' => '',
					'headimgurl' => '',
				);
				$_db = new \Lib\DatabaseAPI();
				$_db->insertNewUser($insql);
				$callback_url = isset($_SESSION['callback'])?urldecode($_SESSION['callback']):'/';
				return $this->redirect($callback_url);
			}
			if(intval($oau) > 4){//the more oauth error times;
				unset($_SESSION['oauthuser']);
				return $this->dataPrint('Oauth Error');
			}
		}
		$_SESSION['oauthuser'] = intval($oau)+1;
		// return $this->redirect("http://coach.samesamechina.com/api/wechat/oauth/auth/7e172a57-ee93-4d02-bc85-7c9b3fcd28cb");//userinfo
		return $this->redirect("http://coach.samesamechina.com/api/wechat/oauth/auth/00e04201-01ae-4e1d-b8f4-d5b10f1f6f11");//base
	}

	public function registercardAction() {
		$city = isset($_GET['city'])?$_GET['city']:'suzhou';
		if(!isset($_SESSION['openid'])){
			unset($_SESSION['oauthuser']);
			$callback_url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'/';
			return $this->redirect('/oauth2?callback='.urlencode($callback_url));
		}
		$_db = new \Lib\DatabaseAPI();
		$openid = isset($_SESSION['openid'])?$_SESSION['openid']:'';
		$public = new \Lib\PublicFun();
		$needSubscribe = $public->checkNeedSubscribe($openid, $city);
		if(!$_db->checkOpenid($openid))
			return $this->render('registernumber', array('trytimes' => '0', 'needSubscribe' => $needSubscribe, 'city' => $city));
		if($info = $_db->findFileByOpenid($openid, $city)){
			if(isset($info->awardcode) && $info->awardcode)
				return $this->render('awardcard', array('awardcode' => $info->awardcode,'meettime' => $info->meettime, 'city' => $city));
		}
		if($times = $_db->checkTrytimes($openid, $city)){
			if($times->trytimes > 3){
				$_trytimes = 0;
			}else{
				$_trytimes = intval(3 - $times->trytimes);
			}
		}else{
			$_trytimes = 3;
		}
		return $this->render('registernumber', array('trytimes' => $_trytimes, 'needSubscribe' => $needSubscribe, 'city' => $city));
	}

	public function loginlistAction(){
		if(isset($_SESSION['logout'])){
			if($_SERVER['PHP_AUTH_USER'] == COACH_NAME && $_SERVER['PHP_AUTH_PW'] == COACH_PWD){
				unset($_SESSION['logout']);
				return $this->redirect('/loginlist');
			}
		}
		if(!isset($_GET['action']) || $_GET['action'] != 'logout'){
			if (isset($_SERVER['PHP_AUTH_USER'])) {
				if($_SERVER['PHP_AUTH_USER'] == COACH_NAME && $_SERVER['PHP_AUTH_PW'] == COACH_PWD){
					unset($_SESSION['logout']);
					return $this->render('loginlist');
				}
			}
		}
		$_SESSION['logout'] = 'logout';
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
	}

	public function oauth3Action(){
		if(!isset($_SESSION['openid'])){
			unset($_SESSION['oauthuser']);
			$callback_url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'/';
			return $this->redirect('/oauth2?callback='.urlencode($callback_url));
		}
		return $this->dataPrint("\nsuccess");
	}

	public function homeAction(){
		$city = isset($_GET['city'])?$_GET['city']:'suzhou';
		return $this->render('home',array('city' => $city));
	}

	public function registernumberAction() {
		$city = isset($_GET['city'])?$_GET['city']:'suzhou';
		return $this->render('registernumber', array('trytimes' => 2, 'city' =>$city ));
	}

	public function awardcardAction() {
		return $this->render('awardcard', array('awardcode' => 'wwwwwwwwwwwwwwwoooooooooooo','meettime' => 1));
	}

}
