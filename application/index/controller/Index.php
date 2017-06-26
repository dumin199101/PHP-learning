<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Url;

class Index extends Controller
{
    public function index()
    {
        return 'Hello World';
    }

    //路由测试
    public function hello()
    {
        $name = $this->request->param('name','');
        return  'Hello:' . $name;
    }

    public function today($year,$month)
    {
        return "today is {$year}年{$month}月";
    }

    //生成url
    public function url()
    {
        echo Url::build('index',['name'=>'du','age'=>2]);
        echo '<br/>';
        echo url('admin/index/index',['name'=>'du']);
        echo '<br/>';
        echo url('today/2017/07'); //路由转换
        echo '<br/>';
        echo url('admin/HelloWorld/index'); //url自动转换
    }

    //请求：
    public function request()
    {
        //方式1
        $request = Request::instance();
        //获取当前URL
        echo $request->url() . '<br/>';
        //方式2
        echo $this->request->url() . '<br/>';
        //绑定参数
        $this->request->bind('username','du');
        //输出
        echo $this->request->username . '<br/>';
        //助手函数：
        echo request()->url() . '<br/>';
        //获取变量：
        dump($this->request->param());
        //input助手
        echo input('param.name') . '<br/>';
        //默认：
        echo $this->request->param('age',22,'intval');
        //获取GET/POST/COOKIE/SESSION/FILE参数

        //request其它参数：
        echo '<hr/>';
        echo "请求方法：" . $this->request->method() . '<br/>';
        echo "请求IP：" . $this->request->ip() . '<br/>';
        echo "是否ajax请求：" . $this->request->isAjax() . '<br/>';
        echo "当前域名：" . $this->request->domain() . '<br/>';
        echo "入口文件：" . $this->request->baseFile() . '<br/>';
        echo "完整URL：" . $this->request->url(true) . '<br/>';
        echo "URL不含querystring：" . $this->request->baseUrl() . '<br/>';
        echo "pathinfo信息：" . $this->request->pathinfo() . '<br/>';
        echo "后缀：" . $this->request->ext() . '<br/>';
        echo "模块：" . $this->request->module() . '<br/>';
        echo "控制器：" . $this->request->controller() . '<br/>';
        echo "方法：" . $this->request->action() . '<br/>';








    }

    //响应：
    public function response()
    {
        $data = [
            'name'=>'dudu',
            'age'=>22
        ];
        return $data;  //更改default_return_type:json/xml
        return json($data); //json助手函数
        return xml($data); //xml助手函数
    }

    //跳转重定向
    public function response2()
    {
        $this->success('处理成功','index/index/index',['name'=>'du'],5);
        $this->error('处理失败','index/index/index',['age'=>22],2);
        $this->redirect('index/index/index',['name'=>'hello']);
    }



}
