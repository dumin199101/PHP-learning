<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4
 * Time: 11:16
 */
$config = [
    'host'=>'**********',
    'port'=>21,
    'timeout'=>30,
    'username'=>'**********',
    'password'=>'**********'
];

//判断文件是否是POST方式上传
if(is_uploaded_file($_FILES['uploadfile']['tmp_name']))
{
    $link = ftp_connect($config['host'],$config['port'],$config['timeout']);
    if(!$link){
        exit('Connect Failed');
    }
    if(!ftp_login($link,$config['username'],$config['password'])){
        exit('Auth Failed');
    }



    //设置被动传送
    ftp_pasv($link,1);

    //切换到上传目录：
    ftp_chdir($link,'./FTP/Upload');

    $remote_file = $_FILES['uploadfile']['name'];
    $local_file = $_FILES['uploadfile']['tmp_name'];

    if(ftp_put($link,$remote_file,$local_file,FTP_BINARY)){
        echo 'Success';
    }else{
        echo 'Failed';
    }

    ftp_close($link);


}
