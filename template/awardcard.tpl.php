<!DOCTYPE HTML>
<html>
<head>
	<title>Coach</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="format-detection" content="telephone=no">
	<!--禁用手机号码链接(for iPhone)-->
	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimum-scale=1.0,maximum-scale=1.0,minimal-ui" />
	<!--自适应设备宽度-->
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<!--控制全屏时顶部状态栏的外，默认白色-->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="Keywords" content="">
	<meta name="Description" content="...">

	<link rel="stylesheet" type="text/css" href="/vfile/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="/vfile/css/style.css" />
</head>
<?php
	$city = isset($city)?$city:'';
	if($city == "suzhou" || $city == "xian" || $city == "kunming"){
		
	}else{
		$city = "other";
	}
?>

<body class="<?php print $city;?>">
<script src="http://coach.samesamechina.com/api/v1/js/049df0b9-8261-45ca-8d27-f860d7e7452b/wechat?v=001"></script>
<script src="/vfile/js/jquery.js"></script>

<!-- 横屏代码 -->
<div id="orientLayer" class="mod-orient-layer">
    <div class="mod-orient-layer__content">
        <i class="icon mod-orient-layer__icon-orient"></i>
        <div class="mod-orient-layer__desc">为了更好的体验，请使用竖屏浏览</div>
    </div>
</div>


<div class="dreambox ycenter">
	<div class="container">
		<img src="/vfile/img/logo.png" width="100%" alt="coach" class="logo">
		<img src="/vfile/img/<?php print $city;?>/text-1.png" width="100%" >
		<div class="modelcon" id="conscroll">
			<div class="infoCon">
				<div class="infoText">
					<!-- <a href="tel:021-20676111"></a> -->	
					<img src="/vfile/img/<?php print $city;?>/info-<?php print isset($meettime)?$meettime:'1';?>.png" width="100%" >
				</div>
			</div>
			<div class="qr-ctn" id="qrcodeCanvas"></div>
			<img src="/vfile/img/jpTips.png" width="100%" >

			<?php
				if($city != "suzhou"){
						echo '<a class="ruleLink_inside" href="http://mp.weixin.qq.com/s/5kqTKrpxTk0SuwEtSJzBVg" target="_blank"><img src="/vfile/img/rulelink.png" width="25%" /></a>';
				}
			?>
			
		</div>

	</div>
</div>

<script src="/vfile/js/public.js"></script>
<script type="text/javascript" src="/vfile/js/jquery.qrcode.min.js"></script>
<script>
	window.onload = function(){
    var time = "<?php print $meettime;?>";

		jQuery('#qrcodeCanvas').qrcode({
		    text: "<?php print $awardcode;?>",
			width: 100,
			height: 100
		});

		pfun.overscroll(document.querySelector('#conscroll'));

	}
	pfun.init();
	</script>
</body>
</html>
