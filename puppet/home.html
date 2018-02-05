<!DOCTYPE HTML>
<html>
<head>
	<title>Coach</title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="format-detection" content="telephone=no">
	<!--自适应设备宽度-->
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<!--控制全屏时顶部状态栏的外，默认白色-->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="Keywords" content="">
	<meta name="Description" content="...">

	<link rel="stylesheet" type="text/css" href="./vfile/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="./vfile/pc/css/style.css" />
</head>
<body>

<script src="./vfile/js/jquery.js"></script>
<script src="./vfile/js/PxLoader.js"></script>
<script src="./vfile/js/public.js"></script>


<div class="loading">
	<div class="loading_con">
		<img src="./vfile/img/logo.png" class="car">

		<div class="spinner">
			<div class="bounce1"></div>
			<div class="bounce2"></div>
			<div class="bounce3"></div>
		</div>
		<p>目前涌入的小伙伴过多<br>页面正在跳转中，请耐心等待。</p>
	</div>
</div>

<div class="dreambox ycenter">
	<div class="container ycenter">
		
		<div class="pagecon">
			<a href="javascript:;" class="logo">
				<img src="./vfile/pc/img/logo.png" >
			</a>
			<div class="slogan">
				<img src="./vfile/pc/img/slogan.png" >
			</div>
			<div class="slidecon">
	
				<div class="slideModel checkin">
					<p>
						尊敬的<span class="uname">--</span>欢迎您出席<span class="ntime">--</span>的活动
					</p>
					<p>
						SA: <span class="usa">--</span>
					</p>

					<ul class="checklist">
						<li>13: 30活动签到</li>
						<li>15: 30活动签到</li>
						<li style="display: none;">晚宴签到</li>
					</ul>
				</div>

				<div class="slideModel errorTips">无法识别该二维码</div>
				<div class="inputArea">
					<input type="text" id="identifier">
				</div>
				<p class="inputTips">请扫描二维码进行识别</p>

			</div>
			
		</div>
		
	</div>
</div>



<script type="text/javascript">
	
	var eventMethod = {
		scanStatus: false,
		ajaxSrcArr: ["./api/loginmeets1", "./api/loginmeets2", "./api/logindinner"],
		ntArr: ["", "13：30", "15：30"], 
		visibleFun: function(n){
			$(".slideModel").css({"visibility": "hidden"});
			$(n).css({"visibility": "visible"});
		},
		identifierIsPass: function(n){
			if(n == ""){
				return false;
			}else{
				return true;
			}
		},
		conRewrite: function(n){
			//console.log(n);
			$(".uname").html(n['uname']);
			$(".usa").html(n['usa']);
			console.log(n);
			$(".checklist li").removeClass("active");
			if(n['ci0'] != "0"){
				$(".checklist li").eq(0).addClass("active");
			}

			if(n['ci1'] != "0"){
				$(".checklist li").eq(1).addClass("active");
			}

			if(n['ci2'] != "0"){
				$(".checklist li").eq(2).addClass("active");
			}

			$(".ntime").html(this.ntArr[n['nt']]);

			$(".checklist").attr("data-code", n['tel']);

			$(".checklist").attr("data-awardcode", n['awardcode']);

			this.visibleFun(".checkin");
		},
		focusFun: function(n){
			$(n).focus();
		},
		stopBubble: function(e){
			if(e && e.stopPropagation){//如果不是IE浏览器  
		        e.stopPropagation();      
		    }else{//是IE浏览器  
		        window.event.cancelBubble=true;   
		    }  
		}
	}

	eventMethod.focusFun("#identifier");

	var LoadingImg = [
        "/vfile/pc/img/bg.jpg",
         "/vfile/pc/img/slogan.png",
        "/vfile/pc/img/logo.png"
    ],setT;

    pfun.loadingFnDoing(LoadingImg, function(){
    	$(".loading").css({"visibility": "hidden"});
    })


    $(window).resize(function(){
    	var domw = parseInt($(document).width(), 10),
    		domh = parseInt($(document).height(), 10)
	    if(domw < 1200){
	    	$("body").addClass('heightbg100');
	    }else{
	    	$("body").removeClass('heightbg100');
	    }
	});

	$(window).resize();


	$(document).keypress(function (e) {
		eventMethod.focusFun("#identifier");
		//console.log(e.keyCode); //32空格  13回车
		var identifier = $("#identifier").val(),
			guestinfoPushData = {
				awardcode: identifier
			};
        if (e.keyCode == 13 || e.keyCode == 32){
        	if(eventMethod.scanStatus) return false;
        	eventMethod.scanStatus = true;
        	$(".slideModel").css({"visibility": "hidden"});
        	clearTimeout(setT);
        	
    		if(eventMethod.identifierIsPass(identifier)){
    			console.log(identifier);
        		pfun.ajaxFun("post", "./api/guestinfo", guestinfoPushData, "json", guestinfoCallback);
        		//eventMethod.visibleFun(".checkin");
        	}else{
        		eventMethod.visibleFun(".errorTips");
        		setT = setTimeout(function(){
        			$(".slideModel").css({"visibility": "hidden"});
        			eventMethod.focusFun("#identifier");
        		},2000);

        		eventMethod.scanStatus = false;
        		
        	}
        	
        	
        }
     })

    function guestinfoCallback(result){
        if(result.code == 10){
        	var databox = {
        		'uname': result.data.memname, 
        		'usa': result.data.guide, 
        		'ci0': result.data.meet1status, 
        		'ci1': result.data.meet2status, 
        		'ci2': result.data.dinnerstatus, 
        		'nt': result.data.meettime,
        		'tel': result.data.callnumber,
        		'awardcode': result.data.awardcode
        	}
        	eventMethod.conRewrite(databox);

        }else{
        	pfun.formErrorTips(result.msg);
        	eventMethod.visibleFun(".errorTips");
    		setT = setTimeout(function(){
    			$(".slideModel").css({"visibility": "hidden"});
    			eventMethod.focusFun("#identifier");
    		},2000);
        }

        $("#identifier").val("");
        eventMethod.scanStatus = false;
    } 

  

    

    $(".checklist").delegate("li", "click", function(event){

    	var self = $(this),
	    	lmPushData = {
		    	awardcode: $(".checklist").attr("data-awardcode")
		    },
		    _index = self.index();
    	
    	if(self.hasClass("disable")) return false;

    	self.addClass("disable");

    	pfun.ajaxFun("post", eventMethod.ajaxSrcArr[_index], lmPushData, "json", lmCallback);

    	function lmCallback(data){

    		if(data.code == 10){
    			if(self.hasClass('active')){
		    		self.removeClass('active');
		    	}else{
		    		self.addClass('active')
		    	}
    		}else{
    			pfun.formErrorTips(data.msg);
    		}

    		self.removeClass("disable");

    		eventMethod.focusFun("#identifier");
    	}

    	eventMethod.stopBubble(event);//组织冒泡  
    	
    })




    $("document").on("click", function(){
    	eventMethod.focusFun("#identifier");
    })


</script>



</body>
</html>
