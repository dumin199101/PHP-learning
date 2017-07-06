<?php
namespace app\index\controller;

use app\common\model\Article;
use app\common\model\User;
use app\common\model\Category;
use think\Controller;

use think\Db;
use think\db\Query;
use think\Exception;
use think\Request;
use think\Url;


class Index extends Controller
{
    public function index()
    {
        return "Hello World";
    }

    /**
     * 生成Guid
     * @param $trim
     * @return string
     */
    public function guid($trim)
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        } else {
            mt_srand((double)microtime() * 10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);                  // "-"
            $lbrace = $trim ? "" : chr(123);    // "{"
            $rbrace = $trim ? "" : chr(125);    // "}"
            $guidv4 = $lbrace .
                substr($charid, 0, 8) . $hyphen .
                substr($charid, 8, 4) . $hyphen .
                substr($charid, 12, 4) . $hyphen .
                substr($charid, 16, 4) . $hyphen .
                substr($charid, 20, 12) .
                $rbrace;
            return $guidv4;
        }
    }

    //路由测试
    public function hello()
    {
        $name = $this->request->param('name', '');
        return 'Hello:' . $name;
    }

    public function today($year, $month)
    {
        return "today is {$year}年{$month}月";
    }

    //生成url
    public function url()
    {
        echo Url::build('index', ['name' => 'du', 'age' => 2]);
        echo '<br/>';
        echo url('admin/index/index', ['name' => 'du']);
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
        $this->request->bind('username', 'du');
        //输出
        echo $this->request->username . '<br/>';
        //助手函数：
        echo request()->url() . '<br/>';
        //获取变量：
        dump($this->request->param());
        //input助手
        echo input('param.name') . '<br/>';
        //默认：
        echo $this->request->param('age', 22, 'intval');
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
            'name' => 'dudu',
            'age' => 22
        ];
        return $data;  //更改default_return_type:json/xml
        return json($data); //json助手函数
        return xml($data); //xml助手函数
    }

    //跳转重定向
    public function response2()
    {
        $this->success('处理成功', 'index/index/index', ['name' => 'du'], 5);
        $this->error('处理失败', 'index/index/index', ['age' => 22], 2);
        $this->redirect('index/index/index', ['name' => 'hello']);
    }


    //数据库操作
    public function db()
    {
        //添加：
//        $res = Db::execute("INSERT INTO `tb_tag`(`v_tag_name`) VALUES('Angulrar.js')");
//        halt($res);
        //修改：编译预处理
//        $res = Db::execute("UPDATE `tb_tag` set v_tag_name = 'Angular' where n_id=?",[13]);
//        halt($res);
//          $res = Db::execute("UPDATE `tb_tag` set v_tag_name = 'AngularJS' where n_id=:id",['id'=>13]);
//          halt($res);
        //查询：
//        $res = Db::query("SELECT * FROM tb_tag");
//        halt($res);
        //跨库查询：
//        $list = Db::connect('db2')->query('SELECT `account` FROM  `tp_admin_user`');
//        halt($list);
    }

    //链式操作，查询构建器，事务
    public function db2()
    {
        $list = Db::table('tb_tag')->field('v_tag_name')
            ->where('n_id', 'gt', 5)
            ->order('n_id desc')
            ->limit(0, 3)
            ->select();
        dump($list);

        //自动提交事务
        Db::transaction(function () {
            Db::name('tag')->insert([
                'v_tag_name' => 'Go'
            ]);
            Db::name('tag')->update(
                [
                    'v_tag_name' => 'Angular',
                    'n_id' => 13
                ]
            );
        });

        //手动提交事务：
        Db::startTrans();
        try {
            Db::name('tag')->insert([
                'v_tag_name' => 'Vue'
            ]);
            Db::name('tag')->update(
                [
                    'v_tag_name' => 'Angular JS',
                    'n_id' => 13
                ]
            );
            Db::commit();
        } catch (Exception $e) {
            Db::rollback();
        }
    }

    //数据库查询（上）
    public function db3()
    {
        //where条件查询
//        $info = Db::name('tag')->where('n_id',4)->find();
//        halt($info);
        //条件可以是：> < >= <= <> in between
//        $info = Db::name('tag')->where('n_id','=',4)->find();
//        $info = Db::name('tag')->where('n_id','<>',4)->select();
//        $info = Db::name('tag')->where('n_id','between',[3,6])->select();
//        $info = Db::name('tag')->where('n_id','in',[2,3,4])->select();
//        halt($info);

        //查询某个字段为null
//        $info = Db::name('tag')->where('v_tag_name',null)->select();
//        halt($info);

        //使用EXP表达式执行原生查询
//        $info = Db::name('tag')->where('n_id','exp','in (2,3,5)')->select();
//        halt($info);

        //多个字段查询
//        $info = Db::name('article')->where('n_id','>','3')->where('v_title','like','%文章%')->select();
//        halt($info);

        //or查询：
//        $info = Db::name('article')->where('n_id','>',7)->whereOr('v_title','蚊帐')->select();
//        halt($info);

        //快捷查询：
//        $info = Db::name('article')->where('n_browse_count&n_update_time','>',0)->select();
//        halt($info);
    }

    //视图：相当于将查询结果缓存起来，使用Query对象查询
    public function db4()
    {
        //Query对象
//        $query = new Query();
//        $query->name('tag')->where('n_id','>',10);
//        $result = Db::select($query);
//        halt($result);
        //视图
        //create view my_view(id,name) as select id name from article
//        $info = Db::view('article',['n_id','n_cat_id'])
//            ->view('category',['n_id'=>'n_cat_id','v_cat_name'],'article.n_cat_id = category.n_id')
//            ->where('article.n_id','>',4)
//            ->select();
//        halt($info);
    }


    //查询日期，某行，某列，分块查询
    public function db5()
    {
        //获取某行某列
//        $value = Db::name('tag')->where('n_id',6)->value('v_tag_name');
//        halt($value);

        //获取某列
//        $values = Db::name('tag')->where('n_id','>',10)->column('v_tag_name');
//        halt($values);

        //获取id跟val的键值对数组
//        $values = Db::name('tag')->where('n_id','>',10)->column('v_tag_name','n_id');
//        halt($values);

        //获取ID跟整条数据的键值对
//        $values = Db::name('category')->where('n_id','>',2)->column('*','n_id');
//        halt($values);

        //聚合查询
//        $values = Db::name('category')->where('n_id','>',2)->column('*','n_id');
//        halt($count);

//          $max = Db::name('category')->where('n_id','>',2)->max('n_id');
//          halt($max);

        //日期查询：（int类型存储）
//        $list = Db::name('article')->whereTime('n_update_time','>','2017-05-02')->select();
//        halt($list);

        //查询本周：this week last week today yesterday
//        $list = Db::name('article')->whereTime('n_update_time','>','this week')->select();
//        halt($list);

        //查询两天前
//        $list = Db::name('article')->whereTime('n_update_time','>','-2 days')->select();
//        halt($list);

        //查询时间段
//        $list = Db::name('article')->whereTime('n_update_time','between',['2016-04-02','2017-04-02'])->select();
//        halt($list);

        //分块查询：假设有100万条数据，同时加载到内存就有问题了。返回值为boolean
//       Db::name('article')->field(['n_id','v_title'])->chunk(2,function($list){
//            //数据处理
//            foreach($list as &$v){
//                $v['v_title'] = $v['v_title'] . '---chunk';
//            }
//        });


    }

    //模型和关联
    public function relation()
    {
        //插入数据：save方法返回值为boolean，如果想获取自增ID：$user->n_id
//        $user = new User();
//        $user->v_username = 'lieyan2';
//        $user->v_password = 'S4cj77RLvgCEeGK2WujphQ==';
//        $res = $user->save();
//        halt($res);
//        halt($user->n_id);

        //插入数据2：
//        $data['v_username'] = 'lieyan3';
//        $data['v_password'] = 'S4cj77RLvgCEeGK2WujphQ==';
//        if($result = User::create($data)){
//            echo $result->v_username . '---' . $result->v_password . '---' . $result->n_id;
//        }

        //批量新增：
//        $user = new User();
//        $data = [
//            ['v_username'=>'lieyan4','v_password'=>'S4cj77RLvgCEeGK2WujphQ=='],
//            ['v_username'=>'lieyan5','v_password'=>'S4cj77RLvgCEeGK2WujphQ=='],
//            ['v_username'=>'lieyan6','v_password'=>'S4cj77RLvgCEeGK2WujphQ==']
//        ];
//        if($user->saveAll($data)){
//            echo '批量新增成功';
//        }

        //查询：
        //根据主键查询
//          $user = User::get(1);
//          echo $user->v_username . '<br/>';
//          echo $user['v_password'] . '<br/>';  //底层实现ArrayAccess接口，可以以数组方式访问

        //getByXxx
//          $user = User::getByVUsername('admin');
//          halt($user->v_password);

        //根据查询条件：
//          $user = User::get(['v_username'=>'admin']);
//          $user = User::where(['v_username'=>'admin'])->find();
//          halt($user->v_password);

//        $users = User::all(); //查询所有数据
//            $users = User::all(['v_password'=>'S4cj77RLvgCEeGK2WujphQ==']);
//            $users = User::where('v_password','S4cj77RLvgCEeGK2WujphQ==')->select();
//
//        foreach ($users as $user) {
//            echo $user->v_username . '<br/>';
//        }

        //修改
//        $user = User::get(2);
//        $user->v_username = 'lieyan123';
//        if(false!==$user->save()){
//            echo '更新成功';
//        }

        //插入：
//        $user = User::get(2);
//        $user->v_username = 'lieyan123';
//        $user->n_id = null;
//        if(false!==$user->isUpdate(false)->save()){
//            echo '添加成功';
//        }

        //根据条件更新：
//        User::update(['v_username'=>'lieyan888'],['n_id'=>2]);

        //删除：
//        User::get(7)->delete();
//        User::destroy(8);

    }

    //读取器跟修改器：
    public function getter()
    {
        $user = User::get(2);
        echo $user->v_username;
    }

    public function setter()
    {
        $user = User::get(2);
        $user->v_username = 'lieyan111';
        echo $user->v_username;
    }

    //类型转换自动完成
    public function transfer()
    {
        $article = new Article();
        $article->v_title = '类型转换';
        $article->v_author = '烈焰';
        $article->v_digest = 'TP5中模型类型转换';
        $article->v_desc = 'TP5中模型类型转换，查询或写入时类型自动转换';
//        $article->n_isrecycle = 'is';
        $article->n_create_time = '2017-07-02';
        $article->v_cover_src = 'http://blog.lieyan.com/uploads/20170603/9045dd14162260167e06488a68e87f92.jpg';
//        halt($article->toArray());
        $article->save();
    }

    //查询范围
    public function scoper()
    {
        /*$list = User::scope('name')->find();
        halt($list->toArray());*/

        //直接使用闭包形式
        /*$list = User::scope(function($query){
            $query->where('v_username','=','admin');
        })->find();

        halt($list->toArray());*/

        //全局查询范围：
       /* $list = Article::all();
        halt($list);*/


    }

    //验证器：
    public function valid()
    {
        if(request()->isPost()){
            $user = new User();
            $res = $user->allowField(true)->validate(true)->save(input('post.'));
            if($res){
                echo '添加成功';
            }else{
                $this->error($user->getError());
            }
        }else{
            return $this->fetch();
        }
    }
    
    //关联（一对多）
    public function relation1()
    {
        $category = Category::get(1);
        //执行两次查询：1查询分类为1的分类信息，2查询分类为1的文章信息
        $articles = $category->article; //读取article属性,等到使用的时候才会去数据库查询,返回的是一个集合
        foreach($articles as $article){
            echo $article->v_title . '<br/>';
            echo $article->v_author . '<br/>';
        }
        //进行条件查询：这个地方调用方法返回的是一个关联模型
        $info = $category->article()->where('n_update_time','>',0)->find();
//        halt($info->v_title);
        //关联新增：
        $category->article()->save([
            'v_title'=>'测试123',
            'v_author'=>'哈哈',
            'v_digest'=>'测试关联模型',
            'v_desc'=>'内容',
            'v_cover_src'=>'http://blog.lieyan.com/uploads/20170603/9045dd14162260167e06488a68e87f92.jpg',
            'n_user_id'=>1,
        ]);
        //批量关联新增：
        $category->article()->saveAll([
            [
                'v_title'=>'测试123',
                'v_author'=>'哈哈',
                'v_digest'=>'测试关联模型',
                'v_desc'=>'内容',
                'v_cover_src'=>'http://blog.lieyan.com/uploads/20170603/9045dd14162260167e06488a68e87f92.jpg',
                'n_user_id'=>1,
            ],
            [
                'v_title'=>'测试345',
                'v_author'=>'哈哈',
                'v_digest'=>'测试关联模型',
                'v_desc'=>'内容',
                'v_cover_src'=>'http://blog.lieyan.com/uploads/20170603/9045dd14162260167e06488a68e87f92.jpg',
                'n_user_id'=>1,
            ],

        ]);
    }

    public function relation2()
    {
        //查询按分类分组后大于4篇的文章
//        $list = Category::has('article','>=',4)->select();
//        halt($list);

//        $list = Category::hasWhere('article',['v_author'=>'烈焰'])->select();
//        halt($list);

        //关联更新：
//        $category = Category::get(1);
//        $article = $category->article()->getByVAuthor('杜民');
//        $article->v_author = '嘟嘟';
//        $article->save();

        //关联删除：
        $category = Category::get(2);
        $category->article()->delete();

    }
     

}
