<?php
namespace app\admins\controller;

use think\Db;
class UserController extends BaseController{	
	public function _initialize(){
		parent::_initialize();
	} 
    public function index(){ 

    	if(is_ajax()){
  			$where = [];
    		$keys = trim(input('keys'));
            if($keys){
                $where['username|id'] = $keys;
            }
    		$list = Db::table('tbl_user')->where($where)->order('id desc')->field('id,username,fid,is_all,money as umoney,getmoney,hit,fee,ctime,ptfee,ename,status')->page(input('page'),input('limit'))->select();
    		$idlist = array_column($list, 'id');
            $fidlist = array_column($list, 'fid');
            $flist = array_column(Db::table('tbl_user')->where(['id'=>['in',array_filter(array_unique($fidlist))]])->field('id,username')->select(), 'username','id');
			$todaymoney = array_column(Db::table('tbl_order')->where(['uid'=>['in',$idlist],'status'=>2])->whereTime('paytime', 'today')->field('uid,sum(allamount) as money')->group('uid')->select(), 'money','uid');
			$todaymoneyf = array_column(Db::table('tbl_order')->where(['fid'=>['in',$idlist],'status'=>2])->whereTime('paytime', 'today')->field('uid,sum(allamount) as money')->group('uid')->select(), 'money','uid');
			$yesterdaymoney =array_column( Db::table('tbl_order')->where(['uid'=>['in',$idlist],'status'=>2])->whereTime('paytime','yesterday')->field('uid,sum(allamount) as money')->group('uid')->select(), 'money','uid');
			$yesterdaymoneyf =  array_column(Db::table('tbl_order')->where(['fid'=>['in',$idlist],'status'=>2])->whereTime('paytime','yesterday')->field('uid,sum(allamount) as money')->group('uid')->select(), 'money','uid');
            foreach($list as &$v){
                $v['fuck'] = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="edit('.$v['id'].')">设置</button><button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="info('.$v['id'].')">财务详情</button><button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="deleteuser('.$v['id'].')">删除</button>';
                $v['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
                $v['hit'] = number_format($v['hit']);
                $v['money'] = 0;
                $v['yesmoney'] = 0;
                if(isset($todaymoney[$v['id']])){
                		$v['money'] += $todaymoney[$v['id']];
                }
                if(isset($todaymoneyf[$v['id']])){
                		$v['money'] += $todaymoneyf[$v['id']];
                }
				if(isset($yesterdaymoney[$v['id']])){
					  $v['yesmoney'] += $yesterdaymoney[$v['id']];
				}
				if(isset($yesterdaymoneyf[$v['id']])){
					 $v['yesmoney'] +=$yesterdaymoneyf[$v['id']] ;
				} 
                if($v['umoney'] > 0){
                    $v['umoney'] = '<span style ="color:red">'.number_format($v['umoney']/100,2)."<span>";
                }else{
                    $v['umoney'] ='0.00';
                }

                if($v['money'] > 0){
                    $v['money'] = '<span style ="color:red">'.number_format($v['money']/100,2)."<span>";
                }else{
                    $v['money'] ='0.00';
                }
                if($v['yesmoney'] > 0){
                    $v['yesmoney'] = '<span style ="color:red">'.number_format($v['yesmoney']/100,2)."<span>";
                }else{
                    $v['yesmoney'] ='0.00';
                }
                if($v['fid'] ==0){
                    $v['fid'] = '-';
                }else{
                    $v['fid'] = $flist[$v['fid']];
                }
                if($v['is_all'] == 2){
                    $v['fee']  = '-';
                }
                if($v['is_all'] == 1){
                    $v['fee'] = $v['fee'].'%';
                }
                $v['status'] = '<input type="checkbox"  '.($v['status'] == 1?'':'checked=""').'   name="'.$v['id'].'" lay-skin="switch"  lay-filter="pay"  lay-text="正常|禁用">';
                

                $v['ptfee'] = $v['ptfee'].'%';
                $v['is_all'] =$v['is_all'] == 1?'普通':'<span style ="color:red">代理<span>'; 
            }
			$toole =  Db::table('tbl_user')->where($where)->count();
			return returnlaydate('获取成功',$list,$toole);
    	}
	 	return view();
    }
    public function getmoney(){

    	if(is_ajax()){
  			$where = [];
    		$keys = trim(input('keys'));
    		if($keys ){
				$where['tbl_user_money.ordersn|tbl_user_money.uid|tbl_user.username'] = $keys;
			}
			$list	= Db::table('tbl_user_money')->join('tbl_user','tbl_user_money.uid=tbl_user.id')->where($where)->field('tbl_user_money.id,tbl_user_money.money,tbl_user_money.ctime,tbl_user_money.ordersn,tbl_user_money.img,tbl_user_money.dotime,tbl_user_money.status,tbl_user_money.uid,tbl_user.username')->order('tbl_user_money.status asc ,tbl_user_money.id desc ')->page(input('page'), input('limit'))->select();
		 	foreach($list as &$v){
		 		$v['username'] = $v['username'].' ('.$v['uid'].') ';
		 		$v['fuck'] = '-';
		 		$v['img'] =  '<img style= "width:100%;" src  = "'.$v['img'].'" class ="showimg" />';
		 		if($v['status'] == 1){
		 			$v['fuck'] = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="pass('.$v['id'].')">打款</button><button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="nopass('.$v['id'].')">拒绝</button>';
		 			$v['statuss'] = '未打款';
		 		}
		 		if($v['status'] == 2){
		 			$v['statuss'] = '<span style = "color:red">已打款</span>';
                    $v['fuck'] ='操作时间 :'.$v['dotime'];
		 		}
		 		if($v['status'] == 3){
		 			$v['statuss'] = '拒绝';
                    $v['fuck'] ='操作时间 :'.$v['dotime'];
		 		}
                $v['money'] =  number_format($v['money']/100,2) ;
		 	}
			$toole = Db::table('tbl_user_money')->join('tbl_user','tbl_user_money.uid=tbl_user.id')->where($where)->count();


 			$where['tbl_user_money.status'] = 2;
			$wheredopay =  Db::table('tbl_user_money')->join('tbl_user','tbl_user_money.uid=tbl_user.id')->where($where)->sum('tbl_user_money.money');
			$where['tbl_user_money.status'] = 1;
    		$wherenotpay = Db::table('tbl_user_money')->join('tbl_user','tbl_user_money.uid=tbl_user.id')->where($where)->sum('tbl_user_money.money');
			$data = [
			 	'code' => 0,
				'msg' => '数据获取成功',
				'data' => $list,
				'count' => $toole,
				'totalRow'=>[
					"money"=>number_format($wheredopay/100,2),
					"ctime"=>number_format($wherenotpay/100,2),

				]
			]; 
 			echo json_encode($data,256);die();
    	}
    	$dopay =  Db::table('tbl_user_money')->where(['status'=>2])->sum('money');
    	$notpay = Db::table('tbl_user_money')->where(['status'=>1])->sum('money');

    	 
    	$this->assign('dopay',number_format($dopay/100,2));
    	$this->assign('notpay',number_format($notpay/100,2));
    	return view();
    }
    public function ispass(){
    	$id  = input('id');
    	$st = input('st');
    	$minfo = Db::table('tbl_user_money')->where(['id'=>$id,'status'=>1])->find();
    	if(empty($minfo)){
    		return returnerror('无效数据');
    	}
    	if($st == 1){
    		if(Db::table('tbl_user_money')->where(['id'=>$id])->update(['status'=>2,'dotime'=>date('Y-m-d H:i:s')])){
    			return returnsuccess('打款成功');
    		}
    		return returnerror('设置失败');
    	}
    	if($st == 2){
    		try { 
				Db::table('tbl_user')->where(['id'=>$minfo['uid']])->setInc('money',$minfo['money']);
				Db::table('tbl_user')->where(['id'=>$minfo['uid']])->setDec('getmoney',$minfo['money']);
				Db::table('tbl_user_money')->where(['id'=>$id])->update(['status'=>3,'dotime'=>date('Y-m-d H:i:s')]);
    		} catch (Exception $e) {
    			return returnerror('拒绝失败');	
    		}
    		return returnsuccess('拒绝成功');
    	}
    	 
    }
    public function del(){
        $id= input('id');
        if(Db::table('tbl_cus')->where(['id'=>$id])->delete()){
            return returnsuccess('删除成功');
        }
        return returnerror('删除失败');
    }
    public function deleteuser(){
        $id= input('id');
        try {
            Db::table('tbl_user')->where(['id'=>$id])->delete();
            Db::table('tbl_cus')->where(['uid'=>$id])->delete();
            Db::table('tbl_hit')->where(['uid'=>$id])->delete();
            Db::table('tbl_order')->where(['uid'=>$id])->delete();
            Db::table('tbl_sys_order')->where(['uid'=>$id])->delete();
            Db::table('tbl_url')->where(['uid'=>$id])->delete();
            Db::table('tbl_user_get_money')->where(['uid'=>$id])->delete();
            Db::table('tbl_user_money')->where(['uid'=>$id])->delete();
            Db::table('tbl_code')->where(['uid'=>$id])->delete();
            Db::table('tbl_box_video')->where(['uid'=>$id])->delete();
            Db::table('tbl_ename_index')->where(['uid'=>$id])->update(['uid'=>0,'status'=>1]);
        } catch (Exception $e) {
            return returnerror('删除失败');
        }
        return returnsuccess('删除成功');
    }
     public function edit(){
        $id = input('id');
        $vinfo = Db::table('tbl_cus')->where(['id'=>$id])->find();
        if(empty($vinfo)){
            echo '暂无此数据';die();
        }
        if(is_ajax()){
            $id = input('id');
            $data['surplus'] = (int)$_POST['surplus'];
            $data['num'] = (int)$_POST['num'];
           	if($data['num'] <= 0){
    			return returnerror('当前值不能小于0');
    		}
    		if($data['surplus'] <= 0){
    			return returnerror('扣量值不能小于0');
    		}
            $data['utime'] = time();
            if(Db::table('tbl_cus')->where(['id'=>$id])->update($data)){
                return returnsuccess('修改成功');
            }
            return returnerror('修改失败');
        }
        $this->assign('username',Db::table('tbl_user')->where(['id'=>$vinfo['uid']])->value('username'));
        $this->assign('cinfo',$vinfo);
        return view();
    }
    public function adduser(){
        $config = Db::table('tbl_config')->where(['id'=>1])->field('fee,pfee,maxamount,miniamount')->find();
         if(is_ajax()){
            $id = input('id');
            $data = [];
            $data['fee'] = input('fee');
            $data['ptfee'] = input('ptfee');
            $data['money'] = trim(input('money'));
            $data['ename'] = trim(input('ename'));
            if(input('password') =='' && $id ==''){
                return returnerror('密码不能为空');
            }
            if(input('password')!= ''){
                $data['password'] = password(trim(input('password'))); 
            }
            $data['is_all'] = input('is_all');
            if($id == ''){
                if(input('username') == ''){
                    return returnerror('账号不能为空');
                }
                $data['username'] = trim(input('username'));
                   if(Db::table('tbl_user')->where(['username'=>$data['username']])->field('id')->find()){
                    return returnerror('此账户已被使用');
                   }
                $data['fid'] = 0;
                $data['ctime'] = time();
                
                $data['max'] = $config['maxamount'];
                $data['mini'] = $config['miniamount'];
                //查询域名
                $ename = Db::table('tbl_ename_index')->where(['status'=>1])->field('id,ename')->find();
                if(empty($ename)){
                    return returnerror('无主域名可用');
                }
                $data['ename'] = $ename['ename']; 
                $uid = Db::table('tbl_user')->insertGetId($data);
                $ename_data['utime'] = date('Y-m-d H:i:s');
                $ename_data['status']= 1;
                $ename_data['uid'] = $uid;
                if(Db::table('tbl_ename_index')->where(['id'=>$ename['id']])->update($ename_data)){
                    return returnsuccess('创建成功');
                }
            }else{
                $data['uptime'] = time();
                if(Db::table('tbl_user')->where(['id'=>$id])->update($data)){
                    return returnsuccess('修改成功');
                }
            }
            return returnerror('写入失败请检查啊数据');
        }else{
            $uinfo = [];
            $uinfo['username'] = '';
            $uinfo['is_all'] = 1;
            $uinfo['fee']=$config['fee'];
            $uinfo['ptfee'] = $config['pfee'];
            $uinfo['money'] ='';
            $uinfo['ename'] ='';
            $id= input('id','');
            if($id != ''){
                $uinfo = Db::table('tbl_user')->where(['id'=>$id])->field('username,is_fixed,is_all,fee,ptfee,kz,money,ename')->find();
            
               
            }
            $this->assign('id',$id);
            $this->assign('vid',vid());
            $this->assign('uinfo',$uinfo);
            return view();
        }
    }
    public function order(){
        if(is_ajax()){
            $where = [];
            $keys = trim(input('keys'));
            if($keys ){
                $where['ordersn'] = $keys;
            }
            if(input('stime')){
                $where['paytime'] = ['>',input('stime')];
            }
            if(input('etime')){
                $where['paytime'] = ['<',input('etime')];
            }
            if(input('stime') && input('etime')){
                $where['paytime'] = ['between',[input('stime'),input('etime')]];
            }

            if(input('uid')){
                $where['uid'] = input('uid');
            }
            $where['status'] = ['in',[2,3]];
            $list   = Db::table('tbl_order')->where($where)->order('id desc')->field('uid,ordersn,vid,buyid,payamount,amount,ctime,paytime,title,tos,status')->page(input('page'), input('limit'))->select();
            $uidlist = array_column($list, 'uid');
            $ulist = array_column(Db::table('tbl_user')->where(['id'=>['in',array_unique($uidlist)]])->field('id,username')->select(),'username','id');
            foreach($list as &$v){
                $v['uname'] = $ulist[$v['uid']] . ' ('.$v['uid'].')';
                if($v['status'] == 1){
                    $v['payamount'] = number_format($v['amount']/100,2);
                    $v['status'] = '<span class >未支付</span>';
                    $v['paytime'] = $v['ctime'];
                }
                if($v['status'] == 2){
                    $v['payamount'] = number_format($v['payamount']/100,2);
                    $v['status'] = '<span style= "color:red" >已支付</span>';;
                }   
                if($v['status'] == 3){
                     $v['payamount'] = number_format($v['payamount']/100,2);
                    $v['status'] = '<span  style= "color:#F0F">扣量订单</span>';;
                }
            }
            $toole = Db::table('tbl_order')->where($where)->order('id desc')->count();
            return returnlaydate('获取成功',$list,$toole);
        }
        return view();
    }
    public function sys(){
        if(is_ajax()){
            $where = [];
            $keys = trim(input('keys'));
            if($keys ){
                $where['ordersn'] = $keys;
            }
            if(input('stime')){
                $where['ctime'] = ['>',strtotime(input('stime'))];
            }
            if(input('etime')){
                $where['ctime'] = ['<',strtotime(input('etime'))];
            }
            if(input('stime') && input('etime')){
                $where['ctime'] = ['between',[strtotime(input('stime')),strtotime(input('etime'))]];
            }
            if(input('uid')){
                $where['uid'] = input('uid');
            }
            $list   = Db::table('tbl_sys_order')->where($where)->order('id desc')->field('ordersn,ctime,amount,uid,msg,status')->page(input('page'), input('limit'))->select();
            $uidlist = array_column($list, 'uid');
            $ulist = array_column(Db::table('tbl_user')->where(['id'=>['in',array_unique($uidlist)]])->field('id,username')->select(),'username','id');
            foreach($list as &$v){
                $v['uname'] = $ulist[$v['uid']] . ' ('.$v['uid'].') ';
                $v['amount'] = number_format($v['amount']/100,2);
                if($v['status'] == 1){
                    $v['status'] = '<span class ="fu">订单收入</span>';;
                }   
                if($v['status'] == 2){
                    $v['status'] = '<span class ="fu">系统购买</span>';;
                }   
                if($v['status'] == 3){
                    $v['status'] = '<span class ="fu">佣金</span>';;
                } 
                $v['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
            }
            $toole = Db::table('tbl_sys_order')->where($where)->order('id desc')->count();
            return returnlaydate('获取成功',$list,$toole);
        }
        return view();
    }
    public function userinfo(){
        $uid = input('id');

        $todaymoney     = Db::table('tbl_order')->where(['uid'=>$uid,'status'=>2])->whereTime('paytime', 'today')->sum('allamount') +Db::table('tbl_order')->where(['fid'=>$uid,'status'=>2])->whereTime('paytime', 'today')->sum('fee');
        $yesterdaymoney = Db::table('tbl_order')->where(['uid'=>$uid,'status'=>2])->whereTime('paytime','yesterday')->sum('allamount') + Db::table('tbl_order')->where(['fid'=>$uid,'status'=>2])->whereTime('paytime','yesterday')->sum('fee');
        $allamount      = Db::table('tbl_order')->where(['uid'=>$uid,'status'=>2])->sum('allamount') + Db::table('tbl_order')->where(['fid'=>$uid,'status'=>2])->sum('fee');
        $todaynum       = Db::table('tbl_order')->where(['uid'=>$uid,'status'=>2])->whereTime('paytime', 'today')->count() +Db::table('tbl_order')->where(['fid'=>$uid,'status'=>2])->whereTime('paytime', 'today')->count();
        $yesterdaynum   = Db::table('tbl_order')->where(['uid'=>$uid,'status'=>2])->whereTime('paytime','yesterday')->count() + Db::table('tbl_order')->where(['fid'=>$uid,'status'=>2])->whereTime('paytime','yesterday')->count();
        $todayusernum  =  Db::table('tbl_order')->where(['uid'=>$uid,'status'=>2])->whereTime('paytime', 'today')->group('buyid')->count();
        $yestadayusernum =Db::table('tbl_order')->where(['uid'=>$uid,'status'=>2])->whereTime('paytime','yesterday')->group('buyid')->count();
        $usernum        = Db::table('tbl_order')->where(['uid'=>$uid,'status'=>2])->group('buyid')->count();
        $allpayordernum = Db::table('tbl_order')->where(['uid'=>$uid,'status'=>2])->count();
        $hit            = Db::table('tbl_hit')->where(['uid'=>$uid])->whereTime('ctime', 'today')->count(); 
        $yesterdayhit   = Db::table('tbl_hit')->where(['uid'=>$uid])->whereTime('ctime','yesterday')->count() ;
        $allhit         = Db::table('tbl_hit')->where(['uid'=>$uid])->count();
        if($allhit < 1){
        	$allhit = 1;
        }
        $hitbuy = number_format(($usernum/$allhit)*100,2).'%';
       
       	$allordernum = Db::table('tbl_order')->where(['uid'=>$uid])->count();
       	if($allordernum < 1){
       		$allordernum =1;
       	}
        $uinfo = Db::table('tbl_user')->where(['id'=>$uid])->find();
        $buyor = number_format(($allpayordernum/$allordernum)*100).'%';
        $this->assign('todayusernum',number_format($todayusernum));
        $this->assign('yestadayusernum',number_format($yestadayusernum));
        $this->assign('buyor',$buyor);
        $this->assign('hitbuy',$hitbuy);
        $this->assign('allhit',number_format($allhit));
        $this->assign('allamount',number_format($allamount/100,2));
        $this->assign('hit',number_format($hit));
        $this->assign('yesterdayhit',number_format($yesterdayhit));
        $this->assign('todaynum',number_format($todaynum));
        $this->assign('yesterdaynum',number_format($yesterdaynum));
        $this->assign('usernum',number_format($usernum));
        $this->assign('allordernum',number_format($allordernum));
        $this->assign('todaymoney',number_format($todaymoney/100,2));
        $this->assign('yesterdaymoney',number_format($yesterdaymoney/100,2));
        $this->assign('uinfo',$uinfo);
        return view();
    }
    public function dday(){
        $number = (int)input('number');
        if($number < 2){
            return returnerror('最低删除两天前订单');
        }
        $time = strtotime(date('Y-m-d'))-$number*86400;
        if(Db::table('tbl_sys_order')->where(['ctime'=>['<',$time]])->delete()){
            return returnsuccess('删除成功');
        }
        return returnsuccess('删除失败');
    }
    public function deday(){
        $number = (int)input('number');
        if($number < 2){
            return returnerror('最低删除两天前订单');
        }
        $time = date('Y-m-d',strtotime(date('Y-m-d'))-$number*86400);
        if(Db::table('tbl_order')->where(['ctime'=>['<',$time]])->delete()){
            return returnsuccess('删除成功');
        }
        return returnsuccess('删除失败');
    }
    public function gminfo(){
    	$id = input('id');
    	$info = Db::table('tbl_user_money')->where(['id'=>$id])->find();
    	if(empty($info)){
    		return returnerror('暂无数据');
    	}
    	$uinfo = Db::table('tbl_user')->where(['id'=>$info['uid']])->field('username')->find();
    	$info['money'] = number_format($info['money']/100,2);
    	$this->assign('uinfo',$uinfo);
    	$this->assign('info',$info);
    	return view();
    }

    public function updes(){
        $a = input('a');
        $id = input('n');
        $data['uptime'] = time();


        if($a =='true'){
            $data['status'] = 0;
        }
        if($a =='false'){
            $data['status'] = 1;
        }
         if(Db::table('tbl_user')->where(['id'=>$id])->update($data)){
            return returnsuccess('修改成功');
        }
        return returnsuccess('修改失败');
    }
}
