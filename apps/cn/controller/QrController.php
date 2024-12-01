<?php

namespace app\cn\controller; 
use think\Controller;
class QrController extends BaseController{	
    public function _initialize(){
        parent::_initialize();
        $this->uid = session('userid');
    }
    public function index(){
        header('Content-Disposition:attachment;filename=qr.png');

        require_once('./vendor/composer/phpqrcode.php'); 
        $value = input('url','http://www.baidu.com');         //二维码内容
        $errorCorrectionLevel = 'L';  //容错级别
        $matrixPointSize = 5;      //生成图片大小
        $QR = \QRcode::png($value,false,$errorCorrectionLevel, $matrixPointSize, 2);
        exit();
    }
   
}
