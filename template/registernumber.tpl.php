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
	$needSubscribe = isset($needSubscribe)?$needSubscribe:FALSE;

	if($city == "suzhou" || $city == "xian" || $city == "kunming"){
		
	}else{
		$city = "other";
	}
?>

<body ng-app="app" class="<?php print $city;?>">
<script src="http://coach.samesamechina.com/api/v1/js/049df0b9-8261-45ca-8d27-f860d7e7452b/wechat?v=001"></script>
<script src="/vfile/js/jquery.js"></script>
<script src="/vfile/js/PxLoader.js"></script>

<div class="loading">
	<div class="loading_con">
		<img src="/vfile/img/logo.png" width="100%" class="car">

		<div class="spinner">
			<div class="bounce1"></div>
			<div class="bounce2"></div>
			<div class="bounce3"></div>
		</div>
		<p>目前涌入的小伙伴过多<br>页面正在跳转中，请耐心等待。</p>
	</div>
</div>

<!-- 横屏代码 -->
<div id="orientLayer" class="mod-orient-layer">
    <div class="mod-orient-layer__content">
        <i class="icon mod-orient-layer__icon-orient"></i>
        <div class="mod-orient-layer__desc">为了更好的体验，请使用竖屏浏览</div>
    </div>
</div>


<div class="dreambox ycenter">
<div style="font-size: 56px; color: #f60; position: absolute; left: 0;
top: 30%; z-index: 11; width: 100%;
 text-align: center; display: none;">
	<?php
		if($needSubscribe){
			echo "1";
		}else{
			echo "0";
		}
	?>
</div>
	
	<div class="container">
		<img src="/vfile/img/logo.png" width="100%" alt="coach" class="logo">

		<img src="/vfile/img/<?php print $city;?>/text-1.png" width="100%" >
		
		<div class="modelcon ycenter">
				<div class="telArea">
					<?php
						if(!$needSubscribe){
							echo '<img src="/vfile/img/text-2.png" width="100%" >
									<div class="telInput">
										<input type="tel" maxlength="6" size="6">
									</div>';
						}else{
							echo '<img src="/vfile/img/xian/attention.png" width="100%" >';
						}
					?>	

					
					<!-- <ul>
						<li>
							<input type="tel" maxlength="1" size="1">
						</li>
						<li>
							<input type="tel" maxlength="1" size="1">
						</li>
						<li>
							<input type="tel" maxlength="1" size="1">
						</li>
						<li>
							<input type="tel" maxlength="1" size="1">
						</li>
						<li>
							<input type="tel" maxlength="1" size="1">
						</li>
						<li>
							<input type="tel" maxlength="1" size="1">
						</li>
					</ul> -->
				</div>


				<!-- 错误提示 -->
				<div class="errorTips ycenter">
					<div class="etcon">
						<h2>很抱歉</h2><p>该号码验证失败<br>还有<em>2</em>次输入机会</p>
					</div>
				</div>


		</div>
	
		<?php
			if(!$needSubscribe){
				$str = '';
				if($city != "suzhou"){
					$str =  '<a class="ruleLink" href="http://mp.weixin.qq.com/s/5kqTKrpxTk0SuwEtSJzBVg" target="_blank"><img src="/vfile/img/rulelink.png" width="25%" /></a>';
				}
				echo '<div class="btnArea">
						<span class="btn receive-btn btnshow"><a href="javascript:;"></a><img src="/vfile/img/receive-btn.png" width="100%" alt="领取"></span>
						<span class="btn re-enter-btn"><a href="javascript:;"></a><img src="/vfile/img/re-enter-btn.png" width="100%" alt="重新输入"></span>
						'.$str.'
					</div>';
			}
		?>	

		

	</div>
</div>
<script src="/vfile/js/public.js"></script>

<script type="text/javascript">
	// needSubscribe 判断是否关注 0/1
	var city = "<?php print $city;?>"; 

	var LoadingImg = [
        "/vfile/img/other/bg.jpg",
        "/vfile/img/other/info-1.png",
        "/vfile/img/other/info-2.png",
        "/vfile/img/logo.png",
        "/vfile/img/re-enter-btn.png",
        "/vfile/img/receive-btn.png",
        "/vfile/img/share.png",
        "/vfile/img/other/text-1.png",
        "/vfile/img/text-2.png",
    ];

    pfun.loadingFnDoing(LoadingImg, function(){
    	if(coachEinviteMethod.count <= 0){
    		$(".errorTips .etcon em").html(coachEinviteMethod.count);
    		coachEinviteMethod.btnShow();
    		$(".errorTips").css({"visibility": "visible"});
    	}

    	$(".loading").css({"visibility": "hidden"});
    })

	var coachEinviteMethod = {
		count: "<?php print $trytimes;?>",
		getNum: function(){
			// var telLi = $(".telArea li");
			// return $.map(telLi, function(v, k){
			// 	return $(v).find("input").val();
			// }).join("");
			return $(".telInput input").val();
		},
		btnShow: function(n){
			$(".btn").removeClass("btnshow");
			if(n){
				$("." + n).addClass("btnshow");
			}
		},
		errorFun: function(n){
			var errorText = "<h2>很抱歉</h2><p>该号码验证失败<br /> 如有疑问，请联系微信客服</p>";
			if(n <=0){
				$(".errorTips .etcon").html(errorText);
				this.btnShow();
			}else{
				$(".errorTips .etcon em").html(n);
				this.btnShow('re-enter-btn');
			}
			$(".errorTips").css({"visibility": "visible"});
		},
		rewrite: function(){
			$(".errorTips").css({"visibility": "hidden"});
			this.btnShow('receive-btn');
			$(".telInput input").val("");
		}
	}


	$(".receive-btn").click(function(){
		if($(this).hasClass('disable')) return false;
		var _gn = coachEinviteMethod.getNum().replace(/\s/ig,'');
		if(_gn.length != 6){
			pfun.formErrorTips("请输入您手机的后六位验证！");
		}else{
			$(this).addClass('disable');
			var submitPushData = {
				"callnumber": _gn,
				"city": city
			}
			pfun.ajaxFun("POST", "/api/submit", submitPushData, "json", submitCallback);
		}
	})

	$(".re-enter-btn").click(function(){
		coachEinviteMethod.rewrite();
	})




	function submitCallback(data){
	    if(data.code == 10 || data.code == 6){
	    	location.reload();
	    }else{
			if(data.code != 8){
				coachEinviteMethod.count--;
	    		coachEinviteMethod.errorFun(coachEinviteMethod.count);
			}
	    }
	    pfun.formErrorTips(data.msg);
	    
	    $(".receive-btn").removeClass('disable');

	}

	pfun.init();
</script>



</body>
</html>
