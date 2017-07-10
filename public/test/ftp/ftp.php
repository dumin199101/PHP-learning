<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/29
 * Time: 10:19
 * Description:FTP测试
 */
//配置信息
$ftp_server = '********';
$ftp_port = 21;
$ftp_timeout = 90;
$username = '********';
$pwd = '*********';
//连接
$link = ftp_connect($ftp_server,$ftp_port,$ftp_timeout) or die("Couldn't connect to {$ftp_server}");
//登录
$res = ftp_login($link,$username,$pwd);
//设置被动传送
ftp_pasv($link,1);
if($res){
    //返回当前的目录名：
   /* $dir = ftp_pwd($link);
    echo $dir . "\n";
    exit;*/
    //返回目录列表
    /*$filelist = ftp_rawlist($link,ftp_pwd($link));
    var_dump($filelist);
    die;*/
    //注意权限问题：首先给予根目录当前用户的写权限
    if(!ftp_chdir($link,'FTP/Upload')){
        $string = ftp_mkdir($link,'FTP/Upload');
        var_dump($string);
    }

    //切换目录：
    ftp_chdir($link,"FTP/Upload");

    //判断父级目录是否存在：
    $dir = ftp_pwd($link) . DIRECTORY_SEPARATOR . date("Ymd",time());
    if(@!ftp_chdir($link,$dir)){
       ftp_mkdir($link,$dir);
    }
    //上传：
    if(ftp_put($link, $dir . DIRECTORY_SEPARATOR . 'ftp_good.jpg','demo.jpg',FTP_BINARY)){
        echo "Success\n";
    }else{
        echo "Failed\n";
    }
}else{
    die("FTP验证失败");
}
//关闭连接：
ftp_close($link);








