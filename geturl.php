<?
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
//Mysql数据库信息
define('HOST','localhost');
define('USER','dscom');
define('PWD','As5kkKidxYacp3pE');
define('DATABASES','dscom');
define('TABLE','tbl_ename');
function connect(){
    $mysqli = new mysqli();
    $mysqli->connect(HOST,USER,PWD,DATABASES);
    if(mysqli_connect_errno()){
        die('db connect fail');
    }
    return $mysqli;
}

$db = connect();
$domain = [];
$res = $db->query("select * from ".TABLE);
while($row = mysqli_fetch_assoc($res)){
    $domain[] = $row['ename'];
}

$token = $_GET['token'];
$domain = $domain?:json_decode($_GET['domain'],true);

$tzurl = $domain[rand(0,count($domain)-1)];
echo $tzurl;die;