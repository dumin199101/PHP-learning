<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4
 * Time: 14:20
 */

namespace app\index\controller;
use think\Config;
use think\Controller;
use think\Upload;

class File extends Controller
{
    //本地文件上传
     public function index(){
         //其中md5和sha1规则会自动以散列值的前两个字符作为子目录，后面的散列值作为文件名。
         if(request()->isPost()){
            $file = request()->file('image');
            $info = $file->rule('sha1')->validate(['size'=>500000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads'); //设置文件上传目录
            if($info){
                echo $info->getExtension(); //txt
                echo '<br/>';
                echo $info->getSaveName(); //20170704/873870092339127455276ee0500490cb.txt
                echo '<br/>';
                echo $info->getFilename(); //873870092339127455276ee0500490cb.txt
                echo '<br/>';
                echo $info->sha1();
            }else{
                echo $file->getError();
            }
         }else{
             return $this->fetch();
         }
     }

    //FTP文件上传
    public function ftp()
    {
        if(request()->isPost()){
            //做上传
            //本地上传测试：
            $config = [
                'savePath'=>'/images/avatar/',
            ];
            $config = array_merge(Config::get('local'),$config);
            $upload = new Upload($config);

            //ftp上传测试：
            $config = [
                'rootPath'   =>    'FTP', //以入口文件所在的目录为准
                'savePath'   =>    '/Upload/images/',
            ];
            $config = array_merge(Config::get('local'),$config);
            $ftpConfig = Config::get('ftp');
            $upload = new Upload($config,'Ftp',$ftpConfig);// 实例化上传类



            // 上传文件
            $info   =   $upload->upload();

            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功 获取上传文件信息
                foreach($info as $file){
                    echo $file['savepath'].$file['savename'];
                }
            }
        }else{
            return $this->fetch('index');
        }
    }
}