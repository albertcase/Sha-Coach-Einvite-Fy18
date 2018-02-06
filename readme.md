###正式链接

**url:** : /

###页面调试链接（以下均为调试链接）

#####二维码显示页面
**url:** /awardcard

**position:** /template/awardcard.tpl.php  二维码显示页面

#####号码注册页面

**url:** /registernumber

**position:** /template/registernumber.tpl.php  成功后跳转至"/"

###模拟微信授权接口
**url:** /api/demonlogin

**Method:** GET

**param:** None

**feedbacks:**
	success

###提交接口
**url:** /api/submit

**Method:** POST

**param:**

	{
		callnumber: '123456'
	}

**feedbacks:**

	{
		code: '10',
		msg: '注册成功'
	}

	{
		code: '11',
		msg: '输入错误'
	}
	
    {
		code: '2',
		msg: '您还未登陆'
	}
	{
		code: '7',
		msg: '您已经超过注册次数'
	}
	{
		code: '6',
		msg: '您已经注册过'
	}
	{
		code: '9',
		msg: '号码不存在'
	}
	{
		code: '8',
		msg: '号码已经被注册'
	}
	{
		code: '5',
		msg: '请刷新页面'
	}
	{
		code: '4',
		msg: '注册错误'
	}
	
	
	
	
###获取用户信息
**url:** /api/guestinfo

**Method:** POST

**param:**

	{
		awardcode: '123456'
	}

**feedbacks:**

    {
    "code": "10",
    "msg": "获取成功",
    "data": {
        "awardcode": "87baf2d73bd0c36056978aa726517b35",
        "callnumber": "555555",
        "meettime": "1",//几点场次
        "checkinstatus": "0",//签到入场状态
        "giftstatus": "1",//领取礼物状态
        "guide": "小镇贵宾",//SA后参数
        "memname": "aaaa"，//用户名
      }
    }
	
	{
		code: '9',
		msg: '获取失败'
	}
	{
		code: '11',
		msg: '输入错误'
	}
	
###入场签到 & 领取礼物
**url:** /api/entrance

**Method:** POST

Content-Type: `application/json`

**param:**
签到入场
	{
		"awardcode": "123456",
		"op": "checkin"
	}
领取礼物
	{
		"awardcode": "123456",
		"op": "gift"
	}

**feedbacks:**

	{
		code: '101',
		msg: '参数错误！'
	}
	{
		code: '102',
		msg: '二维码无效！'
	}
	{
		code: '200',
		msg: '签到成功！'
	}
	{
		code: '201',
		msg: '取消签到成功！'
	}
	{
		code: '202',
		msg: '礼物领取成功！'
	}
	{
		code: '203',
		msg: '取消领取礼物成功！'
	}