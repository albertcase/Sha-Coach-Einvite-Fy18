<?php

//Redis config info
define("REDIS_HOST", '127.0.0.1');
define("REDIS_PORT", '6379');

define("BASE_URL", 'http://127.0.0.1:9201/');
define("TEMPLATE_ROOT", dirname(__FILE__) . '/../template');
//Wechat config info
define("TOKEN", '????');
define("APPID", '????');
define("APPSECRET", '????');
define("NOWTIME", time());
define("AHEADTIME", '100');

define("NONCESTR", '????');

//Wechat Authorize
define("CALLBACK", 'wechat/ws/callback');
define("SCOPE", 'snsapi_base');

//Account Access
define("OAUTH_ACCESS", '{
	"esprit_dance": "samesamechina.com"
}');
define("JSSDK_ACCESS", '{
	"esprit_dance": "samesamechina.com"
}');

//Database config info
define("DBHOST", '127.0.0.1');
define("DBUSER", 'root');
define("DBPASS", '');
define("DBNAME", 'coach_einvite_fy18');

define("ENCRYPT_KEY", '29FB77CB8E94B358');
define("ENCRYPT_IV", '6E4CAB2EAAF32E90');

define("QRG_HOST", 'http://121.41.47.28:84/');
define("FILE_PATH", dirname(__FILE__) . '/../files');


define("COACH_NAME", 'admin');
define("COACH_PWD", 'coachsamesamechina');
