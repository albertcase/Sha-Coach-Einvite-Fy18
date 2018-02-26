<?php

$routers = array();
$routers['/'] = array('EInviteBundle\Site', 'registercard');
$routers['/registernumber'] = array('EInviteBundle\Site', 'registernumber');
$routers['/awardcard'] = array('EInviteBundle\Site', 'awardcard');
$routers['/oauth2'] = array('EInviteBundle\Site', 'oauth2');
$routers['/oauth3'] = array('EInviteBundle\Site', 'oauth3');
$routers['/loginlist'] = array('EInviteBundle\Site', 'loginlist');
$routers['/home'] = array('EInviteBundle\Site', 'home');

// $routers['/api/demonlogin'] = array('EInviteBundle\Api', 'demonlogin');
$routers['/api/submit'] = array('EInviteBundle\Api', 'submit');
$routers['/api/userinfocallback'] = array('EInviteBundle\Api', 'userinfocallback');
$routers['/api/register'] = array('EInviteBundle\Api', 'register');
$routers['/api/logindinner'] = array('EInviteBundle\Api', 'logindinner');
$routers['/api/loginmeets1'] = array('EInviteBundle\Api', 'loginmeets1');
$routers['/api/loginmeets2'] = array('EInviteBundle\Api', 'loginmeets2');
$routers['/api/guestinfo'] = array('EInviteBundle\Api', 'guestinfo');
$routers['/api/sourcejson'] = array('EInviteBundle\Api', 'sourcejson');
$routers['/api/downloaduserinfo'] = array('EInviteBundle\Api', 'downloaduserinfo');
$routers['/api/downloaduserinfo2'] = array('EInviteBundle\Api', 'downloaduserinfo2');
$routers['/api/logout'] = array('EInviteBundle\Api', 'logout');
// $routers['/test/%/aa/%'] = array('EInviteBundle\Site', 'test');

//入场选择操作
$routers['/api/entrance'] = array('EInviteBundle\Api', 'entrance');