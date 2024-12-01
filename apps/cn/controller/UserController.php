<?php
namespace app\cn\controller; 
use think\Db;
use think\Controller;
use think\Session;
class UserController extends BaseController{	
    public function _initialize(){
        parent::_initialize();
        $this->uid = session('userid');
    }
    public function getnum(){
        if(input('ty') == 'yesterdayhit' ){
            $yhit = Db::table('tbl_hit')->where(['uid'=>$this->uid])->whereTime('ctime','yesterday')->count(); 
            return returnsuccess($yhit);
        }
        if(input('ty') == 'hit' ){
            $hit  = Db::table('tbl_hit')->where(['uid'=>$this->uid])->whereTime('ctime', 'today')->count(); 
            return returnsuccess($hit);
        }
        if(input('ty') == 'todaymoney'){
            $todaymoney = Db::table('tbl_order')->where(['uid'=>$this->uid,'status'=>2])->whereTime('paytime', 'today')->sum('allamount') +Db::table('tbl_order')->where(['fid'=>$this->uid,'status'=>2])->whereTime('paytime', 'today')->sum('fee');
           return returnsuccess(number_format($todaymoney/100,2,'.',''));
        }
        if(input('ty') == 'yesterdaymoney'){
             $yesterdaymoney = Db::table('tbl_order')->where(['uid'=>$this->uid,'status'=>2])->whereTime('paytime','yesterday')->sum('allamount') + Db::table('tbl_order')->where(['fid'=>$this->uid,'status'=>2])->whereTime('paytime','yesterday')->sum('fee');
             return returnsuccess(number_format($yesterdaymoney/100,2,'.',''));
        }
        if(input('ty') == 'money'){
            $money = Db::table('tbl_user')->where(['id'=>$this->uid])->value('money');
            return returnsuccess(number_format($money/100,2,'.',''));
        }
        if(input('ty') == 'todaynum'){
            $todaynum  = Db::table('tbl_order')->where(['uid'=>$this->uid,'status'=>2])->whereTime('paytime', 'today')->count() +Db::table('tbl_order')->where(['fid'=>$this->uid,'status'=>2])->whereTime('paytime', 'today')->count();
            return returnsuccess($todaynum);
        }
        if(input('ty') == 'yesterdaynum'){
            $yesterdaynum = Db::table('tbl_order')->where(['uid'=>$this->uid,'status'=>2])->whereTime('paytime','yesterday')->count() + Db::table('tbl_order')->where(['fid'=>$this->uid,'status'=>2])->whereTime('paytime','yesterday')->count();
            return returnsuccess($yesterdaynum);
        }
        if(input('ty') == 'usernum'){
            $usernum  =   Db::table('tbl_order')->where(['uid'=>$this->uid,'status'=>2])->group('buyid')->count();
            return returnsuccess($usernum);
        }
        if(input('ty') == 'allordernum'){
            $allordernum = Db::table('tbl_order')->where(['uid'=>$this->uid,'status'=>2])->count();
            return returnsuccess($allordernum);
        }
    }
    public function index(){  
        $weekmonety = array_column(Db::query("SELECT DATE_FORMAT(paytime,'%Y-%m-%d') as time,sum(allamount) as  money FROM tbl_order WHERE uid = ".$this->uid." and status =2 and    paytime > '".( date('Y-m-d 00:00:00',strtotime(date('Y-m-d 23:59:59'))-86400*7)) ."'  GROUP BY  time  "), 'money','time');
        $weekmonety2 = array_column(Db::query("SELECT DATE_FORMAT(paytime,'%Y-%m-%d') as time,sum(fee) as  money FROM tbl_order WHERE fid = ".$this->uid." and status =2 and paytime > '".( date('Y-m-d 00:00:00',strtotime(date('Y-m-d 23:59:59'))-86400*7)) ."'  GROUP BY  time  "), 'money','time'); 

        $timelist  = [];

        $time = strtotime(date('Y-m-d 00:00:00',time()));

        for($i=6;$i>=0;$i--){

            $timelist[] = date('Y-m-d',$time- $i*86400);

        }
        foreach($timelist as $k=>$v){
            $price = 0;
            if(isset($weekmonety[$v])){
                $price += $weekmonety[$v];
            }
            if(isset($weekmonety2[$v])){
                $price += $weekmonety2[$v];
            }
            $money[] = number_format($price/100,2, '.', '');
        }   
   
        $newlist = Db::table('tbl_news')->order('id desc')->field('id,title,ctime')->limit(5)->select();
        if(!empty($newlist)){
            foreach($newlist as &$v){
                $v['ctime'] = date('Y-m-d',$v['ctime']);
                if(mb_strlen($v['title']) >=10){
                    $v['title'] = mb_substr($v['title'],0,10).'...';
                }
                
            }
        }

        $daymoney =  array_column(Db::query("SELECT DATE_FORMAT(ctime,'%Y-%m-%d %H') as time,count(ip) as  ip FROM tbl_hit WHERE  uid = ".session('userid')." and   ctime > '".(date('Y-m-d H:00:00',time()-86400)) ."'  GROUP BY  time  "), 'ip','time');
        $dayordernumber = array_column(Db::query("SELECT DATE_FORMAT(paytime,'%Y-%m-%d %H') as time,count(id) as  id FROM tbl_order WHERE  uid = ".session('userid')." and   paytime > '".(date('Y-m-d H:00:00',time()-86400)) ."'  GROUP BY  time  "), 'id','time');

        $newtime = time();
        $daymoneys = [];
        $daytime = [];
        $dayorder = [];
        for($i=24;$i>0;$i--){
            $daytime[] = date('Y-m-d H',$newtime - 3600 * $i);
        }

        foreach($daytime as $k=>&$v){
            if(isset($daymoney[$v])){
                $daymoneys[] = number_format($daymoney[$v]);
               

            }else{
                $daymoneys[] =number_format(0);
               
            }
            if(isset($dayordernumber[$v])){
                $dayorder[] = number_format($dayordernumber[$v]);
               

            }else{
                $dayorder[] =number_format(0);
               
            }

            
            
            $rdaytime[] =  date('H',strtotime($v.':00:00')).":00";
        }  
        
        $this->assign('daymoney',json_encode($daymoneys));
        $this->assign('dayorder',json_encode($dayorder));
        $this->assign('daytime',json_encode($rdaytime));
        $this->assign('newslist',$newlist);
    	$this->assign('money',json_encode($money));
  		$this->assign('date',json_encode($timelist));
    	return view();
    }
    public function edit(){
        if(is_ajax()){
            $data['mini'] = (int)(trim((float)input('mini'))*100);
            $data['max'] = (int)(trim((float)input('max'))*100);
            $data['is_fixed'] = trim(input('is_fixed'));
            $data['uptime'] = time();
            $data['dayopen'] = input('dayopen')?1:2;
            $data['weekopen'] = input('weekopen')?1:2;
            $data['moonopen'] = input('moonopen')?1:2;
            $data['tc'] = input('tc')?1:2;
			 $data['tcurl'] = input('tcurl');
            $data['dayamount']  =(int)(trim((float)input('dayamount'))*100);
            $data['weekamount'] =(int)(trim((float)input('weekamount'))*100);
            $data['moonamount'] =(int)(trim((float)input('moonamount'))*100);
            if(input('password')){
                $data['password'] = password(trim(input('password')));
            }


            $data['utime'] = time();
            if($data['mini'] <= 0 || $data['max'] <= 0 || ($data['dayopen'] == 1 && $data['dayamount'] <= 0) || ($data['weekopen'] == 1 && $data['weekamount'] <= 0) || ($data['moonopen']==1 && $data['moonamount'] <= 0)){
                return returnerror('金额不能小于0');
            }
            if($data['mini'] > $data['max']){
                return returnerror('最小金额不能大于最大金额');
            }
            if(Db::table('tbl_user')->where(['id'=>$this->uid])->update($data)){
                return returnsuccess('修改成功');
            }
            return returnerror('修改失败');
        }else{
            $uinfo = Db::table('tbl_user')->where(['id'=>$this->uid])->find();
            $uinfo['mini'] = $uinfo['mini']/100;
            $uinfo['max'] = $uinfo['max']/100;
            $this->assign('vid',vid());
            $this->assign('uinfo',$uinfo);
            return view();
        }
    }
    public function member(){
        if(is_ajax()){
            $where['fid']=$this->uid;
            $keys = trim(input('keys'));
            if($keys ){
                $where['username'] = $keys;
            }
            $list   = Db::table('tbl_user')->where($where)->order('id desc')->field('id,username,hit,fee,money,ctime,getmoney,status')->page(input('page'), input('limit'))->select();
            foreach($list as &$v){
                $v['fee'] = $v['fee'].'%';
                $v['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
                $v['money'] = number_format($v['money']/100,2);
                $v['getmoney']=  number_format($v['getmoney']/100,2);
                $v['fuck'] = '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="edit('.$v['id'].')">设置</button>';
                if($v['status'] == 0){
                    $v['fuck'] .= '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal layui-btn-danger " onclick="stat('.$v['id'].','.$v['status'].')">禁用</button>';
                }
                if($v['status'] == 1){
                    $v['fuck'] .= '<button type="button"  class="layui-btn layui-btn-sm layui-btn-normal" onclick="stat('.$v['id'].','.$v['status'].')">启用</button>';
                }
            }
            $toole = Db::table('tbl_user')->where($where)->order('id desc')->count();
            return returnlaydate('获取成功',$list,$toole);
        }


        $this->assign('url','http://'.$_SERVER['HTTP_HOST'].'/cn/home/register?i='.ssl_encode($this->uid));
        return view();
    }
    public function adduser(){
        $uinfo = [];
        $uinfo['username'] = '';
       $data['is_all'] = 1;
        
        $id= input('id','');
        if(is_ajax()){
            $id = input('id');
            if($id == ''){
                if(input('username') == ''){
                    return returnerror('账号不能为空');
                }
                $data['username'] = trim(input('username'));
                   if(Db::table('tbl_user')->where(['username'=>$data['username']])->field('id')->find()){
                    return returnerror('此账户已被使用');
                   }
            }

            if(input('password') =='' && $id ==''){
                return returnerror('密码不能为空');
            }
            if(input('password')!= ''){
                $data['password'] = password(trim(input('password'))); 
            }
           
           
            $fee = Db::table('tbl_user')->where(['id'=>$this->uid])->field('fee,is_all,ptfee')->find();
            if($fee['is_all'] != 2){
                return returnerror('无权操作');
            }
            if($id ==''){
                Db::startTrans();
                  $config =Db::table('tbl_config')->where(['id'=>1])->field('kou,kounum,is_code,maxamount,miniamount')->find();
                
                $data['fid'] = $this->uid;
                $data['ctime'] = time();
                $data['fee'] = $fee['fee'];
                $data['ptfee'] = $fee['ptfee'];
                $data['max'] = $config['maxamount'];
                $data['mini'] = $config['miniamount'];
                $ename = Db::table('tbl_ename_index')->where(['status'=>1])->field('id,ename')->find();
                if(empty($ename)){
                    Db::rollback();
                    return returnerror('无主域名可用');
                }
                $data['ename'] = $ename['ename']; 
                $uid = Db::table('tbl_user')->insertGetId($data);
                $ename_data['utime'] = date('Y-m-d H:i:s');
                $ename_data['status']= 1;
                $ename_data['uid'] = $uid;
                if($config['kou'] == 2){
                    $kou_data['num'] = $config['kounum'];
                    $kou_data['surplus'] = $config['kounum'];
                    $kou_data['uid']=$uid;
                    Db::table('tbl_cus')->insert($kou_data);
                }
                if($config['is_code'] == 2){
                    $code = Db::table('tbl_code')->where(['status'=>1,'uid'=>session('userid')])->field('id')->find();
                    if(empty($code)){
                        Db::rollback();
                        return returnerror('无可用邀请码');
                    }
                    $code_data = [];
                    $code_data['utime'] = time();
                    $code_data['userid'] = $uid;
                    $code_data['status'] = 2;
                    if(!Db::table('tbl_code')->where(['id'=>$code['id']])->update($code_data)){
                        Db::rollback();
                        return returnerror('注册失败');
                    }
                }
                if(!Db::table('tbl_ename_index')->where(['id'=>$ename['id']])->update($ename_data)){
                    Db::rollback();
                    return returnerror('注册失败');
                }
                Db::commit();
                return returnsuccess('创建成功');
            }else{
                $data['uptime'] = time();
                if(Db::table('tbl_user')->where(['id'=>$id])->update($data)){
                    return returnsuccess('修改成功');
                }
            }
            return returnerror('写入失败请检查啊数据');
        }
        if($id != ''){
            $uinfo = Db::table('tbl_user')->where(['id'=>$id,'fid'=>$this->uid])->field('username,mini,max,is_fixed,vid,dayopen,weekopen,moonopen,dayamount,weekamount,moonamount')->find();
            $uinfo['mini'] = $uinfo['mini']/100;
            $uinfo['max'] = $uinfo['max']/100;
            $uinfo['dayamount'] = $uinfo['dayamount']/100;
            $uinfo['weekamount'] = $uinfo['weekamount']/100;
            $uinfo['moonamount'] = $uinfo['moonamount']/100;
        }
        $this->assign('vid',vid());
        $this->assign('id',$id);
        $this->assign('uinfo',$uinfo);
        return view();
    }
    public function stat(){
        $id  = input('id');
        $data['status'] = abs(input('st')-1);
        $data['utime'] = time();
        if(Db::table('tbl_user')->where(['id'=>$id])->update($data)){
            return returnsuccess('修改成功');
        }
        return returnerror('修改失败');
    }
    public function getnews(){
        $id = input('id');

        $res = Db::table('tbl_news')->where(['id'=>$id])->find();

        if(!empty($res)){
            $res['ctime'] = date('Y-m-d H:i:s',$res['ctime']);
            $res['content'] = htmlspecialchars_decode($res['content']);
        }
        echo json_encode(['code'=>1,'data'=>$res]);die();

    }
    public function sviews(){
        if(is_ajax()){
            $data['utime'] = time();
            $data['vid'] = (int)input('vid');
            if(Db::table('tbl_user')->where(['id'=>$this->uid])->update($data)){
                return returnsuccess('修改成功');
            }
            return returnerror('修改失败');
        }
        $vid = Db::table('tbl_user')->where(['id'=>$this->uid])->value('vid');
        $this->assign('vid',$vid);
        return view();
    }
    public function rukou(){
        $uinfo = Db::table('tbl_user')->where(['id'=>session('userid')])->find();
        if(is_ajax()){
            $id = input('id');
            if($id == 2){
               return returnerror('未开放');
            }
            $amount = Db::table('tbl_config')->where(['id'=>1])->field('kzamount,enameamount')->find();

            $price = 0;
            $aname = '';
            if($id == 1){
                $aname = '普通';
                $price = $amount['enameamount'];
            }else{
                $aname = '抖音';
                $price = $amount['kzamount'];
            }
            if($uinfo['money'] - $price < 0){
                return returnerror('金额不足');
            }
            Db::startTrans();
            $enamelist = Db::table('tbl_ename_index')->where(['status'=>1])->find();

            $u_data = [];
            $u_data['utime'] = time();
            $u_data['ename'] = $enamelist['ename'];

            $e_data = [];
            $e_data['status'] = '2';
            $e_data['utime'] = date('Y-m-d H:i:s');
            $e_data['uid'] = session('userid');

            $o_data['ordersn'] = ordersn();
            $o_data['ctime'] =  time();
            $o_data['amount'] = $price;
            $o_data['uid'] =session('userid') ;

            $o_data['msg'] = '购买'.$aname.'入口域名 ：'.$enamelist['ename'].' ,花费 :'.($price/100).'元';
            $o_data['status'] = 2;


            if(!Db::table('tbl_user')->where(['id'=>session('userid')])->update($u_data)){
                Db::rollback();
                return returnerror('修改数据失败');
            }

            if(!Db::table('tbl_ename_index')->where(['id'=>$enamelist['id'],'status'=>1])->update($e_data)){
                Db::rollback();
                return returnerror('修改数据失败');
            }
            if($price > 0){
                if(!Db::table('tbl_user')->where(['id'=>session('userid')])->setDec('money',$price)){
                    Db::rollback();
                    return returnerror('修改数据失败');
                }

                if(!Db::table('tbl_sys_order')->insert($o_data)){
                    Db::rollback();
                    return returnerror('修改数据失败');
                }
            }
            Db::commit();
            return returnsuccess('购买成功');
        }
        $this->assign('uinfo',$uinfo);
        return view();
    }
    public function code(){
        if(is_ajax()){
            $where['uid'] = session('userid');

            $list = Db::table('tbl_code')->where($where)->order('id desc')->field('code,uid,ctime,utime,userid,status')->page(input('page'), input('limit'))->select();
            foreach($list as &$v){
                $v['ctime'] = date('Y-m-d H:i:s',$v['ctime']);

                if($v['status'] == 1){
                    $v['status'] = '未使用';
                    $v['utime'] = '-';
                    $v['userid'] = '-';
                }
                if($v['status'] == 2){
                     $v['utime'] = date('Y-m-d H:i:s',$v['utime']);
                    $v['status'] = '已使用';;

                }   
            }
            $toole = Db::table('tbl_code')->where($where)->order('id desc')->count();
            return returnlaydate('获取成功',$list,$toole);
        }
        $code_price = Db::table('tbl_config')->where(['id'=>1])->value('code_price');
        $this->assign('code_price',$code_price/100);
        return view();
    }
    public function buycode(){
        if(is_ajax()){
            $p = (int)input('p');
            if($p <=0){
                return returnerror('请输入正确的购买数量');
            }
            Db::startTrans();
            $code_price = Db::table('tbl_config')->where(['id'=>1])->value('code_price');
            $money = Db::table('tbl_user')->where(['id'=> $this->uid])->value('money');
            if($money - $p* $code_price < 0){
                 Db::rollback();
                return returnerror('金额不足 无法购买');
            }
            $data = [];
            $time = time();
            for($i=0;$i<$p;$i++){
                $one = [];
                $one['code'] = strtoupper(md5(uniqid().rand(1,10000)));
                $one['uid'] =  $this->uid ;
                $one['ctime'] = $time;
                $one['status']  = 1;
                $data[] = $one;
            }
            $sys_order = [];
            $sys_order['ordersn'] = ordersn();
            $sys_order['ctime'] = time();
            $sys_order['amount'] =  $p* $code_price ;
            $sys_order['uid'] = $this->uid;
            $sys_order['msg'] = '购买邀请买：'.number_format(($p* $code_price)/100,2).'元';
            $sys_order['status'] =2;
            $sys_order['utime'] = date('Y-m-d H:i:s');




            if(!Db::table('tbl_user')->where(['id'=>$this->uid])->setDec('money',($p* $code_price))){
                Db::rollback();
                return returnerror('购买失败 请重试');
            }
            if(!Db::table('tbl_code')->insertAll($data)){
                Db::rollback();
                return returnerror('购买邀请码失败');
            }
            if(!Db::table('tbl_sys_order')->insert($sys_order)){
                Db::rollback();
                return returnerror('购买失败 请重试1');
            }
            Db::commit();
            return returnsuccess('购买成功');
        }
    }
	 
}
