<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4
 * Time: 9:44
 */
class FTP
{
    //FTP上传配置
    private $config = [
        'host' => '',
        'port' => 21,
        'timeout' => 90,
        'username' => '',
        'password' => ''
    ];
    //连接句柄
    private $link;
    //异常处理
    private $error;

    //上传根目录：
    private $rootPath;


    //构造方法：
    public function __construct(array $config)
    {
        //将用户配置与用户默认配置合并
        $this->config = array_merge($this->config, $config);
        //进行登录：
        if (!$this->login()) {
            exit($this->error);
        }
    }

    //检测上传根目录
    public function checkRootPath($rootpath)
    {
        $this->rootPath = ftp_pwd($this->link) . '/' . ltrim($rootpath,'/');
        if(!@ftp_chdir($this->link,$this->rootPath)){
            $this->error = '上传根目录不存在';
            return false;
        }
        return true;
    }

    //检测创建上传目录
    public function checkSavePath($savepath)
    {
         if(!$this->mkdir($savepath)){
             $this->error = '上传目录创建失败';
             return false;
         }
         return true;
    }

    //创建目录
    public function mkdir($dirname)
    {
        $dir = $this->rootPath . $dirname;
        if(ftp_chdir($this->link,$dir)){
            return true;
        }
        if(ftp_mkdir($this->link,$dir)){
            return true;
        }elseif($this->mkdir($dirname)&&ftp_mkdir($this->link,$dir)){
            return true;
        }else{
            $this->error = '目录创建失败';
            return false;
        }
    }

    //保存文件
    public function save($file)
    {
        //服务器端保存文件名
        $filename = $this->rootPath . '/' . $file['savepath'] . '/' . $file['savename'];
        //移动文件
        if(!ftp_put($this->link,$filename,$file['tmp_name'],FTP_BINARY)){
            $this->error = '文件保存失败';
            return false;
        }
        return true;
    }


    //返回错误信息：
    public function getError(){
        return $this->error;
    }

    //登录
    public function login()
    {
        //解析当前配置信息中符号表到内存
        extract($this->config);
        //连接
        $this->link = ftp_connect($host, $port, $timeout);
        if (!$this->link) {
            $this->error = "无法连接到FTP服务器{$host}";
            return false;
        }
        //登录验证：
        if (ftp_login($this->link, $username, $password)) {
            return true;
        }else{
            $this->error = "登录验证失败username:{$username}";
            return false;
        }
    }

    //析构方法：
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        ftp_close($this->link);
    }


}