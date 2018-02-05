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
  	<link rel="stylesheet" type="text/css" href="/vfile/datatable/css/jquery.dataTables.css">
    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" language="javascript" src="/vfile/datatable/js/jquery.dataTables.js"></script>
</head>
<body>
  <style>
  tbody>tr>td:nth-child(1)~td{
    text-align: center;
  }
  </style>
  <script>
	function delcookie(){
		console.log("aaaaaa");
		var name = 'PHPSESSID';
		var nowdate = new Date();
		nowdate.setTime(-1000);
		document.cookie=name+"='';expiress="+nowdate.toGMTString();
	}
  $(document).ready(function() {
  $('#userinfo').DataTable( {
        "ajax": {
          "url": "/api/sourcejson",
          "dataSrc": ""
        },
        "columns": [
          { "data": "memname" },
					{ "data": "awardcode"},
          { "data": "sex" },
          { "data": "callnumber" },
          { "data": "guide" },
          { "data": "meettime" },
          { "data": "meet1status" },
          { "data": "meet2status" },
          { "data": "inmeettime" },
					{ "data": "city" }
        ]
      } );
    } );
  </script>
  <div style="width:1200px;margin:10px auto">
		<div style="text-align:center"><img src="/vfile/img/coach-newlogo-ny.png"></div>
		<div style="text-align:right;"><a href="/loginlist?action=logout" style="color:red">注销</a></div><br>
    <table id="userinfo" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>名字</th>
						<th>是否领取</th>
						<th>性别</th>
						<th>手机号</th>
            <th>SA</th>
						<th>入场场次</th>
						<th>13：30签到状态</th>
            <th>15：30签到状态</th>
						<th>实际到场时间</th>
						<th>城市</th>
					</tr>
				</thead>
			</table>
      <div style="font-size:120%;text-align:right;color:blue"><a href="/api/downloaduserinfo">点击下载</a><div>
  </div>
</body>
</html>
