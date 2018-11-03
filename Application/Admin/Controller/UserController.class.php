<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

/**
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class UserController extends AdminController {

    /**
     * 用户管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        $nickname       =   I('nickname');
        $map['status']  =   array('egt',0);
        if(is_numeric($nickname)){
            $map['uid|nickname']=   array(intval($nickname),array('like','%'.$nickname.'%'),'_multi'=>true);
        }else{
            $map['nickname']    =   array('like', '%'.(string)$nickname.'%');
        }

        $list   = $this->lists('Member', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '用户信息';
        $this->display();
    }

    /**
     * 修改昵称初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updateNickname(){
        $nickname = M('Member')->getFieldByUid(UID, 'nickname');
        $this->assign('nickname', $nickname);
        $this->meta_title = '修改昵称';
        $this->display('updatenickname');
    }

    /**
     * 修改昵称提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitNickname(){
        //获取参数
        $nickname = I('post.nickname');
        $password = I('post.password');
        empty($nickname) && $this->error('请输入昵称');
        empty($password) && $this->error('请输入密码');

        //密码验证
        $User   =   new UserApi();
        $uid    =   $User->login(UID, $password, 4);
        ($uid == -2) && $this->error('密码不正确');

        $Member =   D('Member');
        $data   =   $Member->create(array('nickname'=>$nickname));
        if(!$data){
            $this->error($Member->getError());
        }

        $res = $Member->where(array('uid'=>$uid))->save($data);

        if($res){
            $user               =   session('user_auth');
            $user['username']   =   $data['nickname'];
            session('user_auth', $user);
            session('user_auth_sign', data_auth_sign($user));
            $this->success('修改昵称成功！');
        }else{
            $this->error('修改昵称失败！');
        }
    }

    /**
     * 修改密码初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updatePassword(){
        $this->meta_title = '修改密码';
        $this->display('updatepassword');
    }

    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitPassword(){
        //获取参数
        $password   =   I('post.old');
        empty($password) && $this->error('请输入原密码');
        $data['password'] = I('post.password');
        empty($data['password']) && $this->error('请输入新密码');
        $repassword = I('post.repassword');
        empty($repassword) && $this->error('请输入确认密码');

        if($data['password'] !== $repassword){
            $this->error('您输入的新密码与确认密码不一致');
        }

        $Api    =   new UserApi();
        $res    =   $Api->updateInfo(UID, $password, $data);
        if($res['status']){
            $this->success('修改密码成功！');
        }else{
            $this->error($res['info']);
        }
    }

    /**
     * 用户行为列表
     * @author huajie <banhuajie@163.com>
     */
    public function action(){
        //获取列表数据
        $Action =   M('Action')->where(array('status'=>array('gt',-1)));
        $list   =   $this->lists($Action);
        int_to_string($list);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $this->assign('_list', $list);
        $this->meta_title = '用户行为';
        $this->display();
    }

    /**
     * 新增行为
     * @author huajie <banhuajie@163.com>
     */
    public function addAction(){
        $this->meta_title = '新增行为';
        $this->assign('data',null);
        $this->display('editaction');
    }

    /**
     * 编辑行为
     * @author huajie <banhuajie@163.com>
     */
    public function editAction(){
        $id = I('get.id');
        empty($id) && $this->error('参数不能为空！');
        $data = M('Action')->field(true)->find($id);

        $this->assign('data',$data);
        $this->meta_title = '编辑行为';
        $this->display('editaction');
    }

    /**
     * 更新行为
     * @author huajie <banhuajie@163.com>
     */
    public function saveAction(){
        $res = D('Action')->update();
        if(!$res){
            $this->error(D('Action')->getError());
        }else{
            $this->success($res['id']?'更新成功！':'新增成功！', Cookie('__forward__'));
        }
    }

    /**
     * 会员状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        if( in_array(C('USER_ADMINISTRATOR'), $id)){
            $this->error("不允许对超级管理员执行该操作!");
        }
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['uid'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'forbiduser':
                $this->forbid('Member', $map );
                break;
            case 'resumeuser':
                $this->resume('Member', $map );
                break;
            case 'deleteuser':
                $this->delete('Member', $map );
                break;
            default:
                $this->error('参数非法');
        }
    }

    public function add($username = '', $password = '', $repassword = '', $email = ''){
        if(IS_POST){
            /* 检测密码 */
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }

            /* 调用注册接口注册用户 */
            $User   =   new UserApi;
            $uid    =   $User->register($username, $password, $email);
            if(0 < $uid){ //注册成功
                $user = array('uid' => $uid, 'nickname' => $username, 'status' => 1);
                 $group['group_id']=$_POST['auth'];
                $group['uid']=$uid;
                $group['houtai']=$_POST['houtai'];
                if(!M('Member')->add($user)){
                    $this->error('用户添加失败！');
                } else {
                  M('AuthGroupAccess')->add($group);
                    $this->success('用户添加成功！',U('index'));
                }
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
          $auth=M('AuthGroup')->where("status !=-1")->select();
            $this->assign('auth',$auth);
            $this->meta_title = '新增用户';
            $this->display();
        }
    }
   public function edit($id){
    if(IS_POST){
      $Member=D('UcenterMember');
        $mem=D('Member');
        $au=D('AuthGroupAccess');
        $map['id']=$id;
        $maps['uid']=$id;
        $info['username']=$_POST['username'];
        $in['nickname']=$_POST['username'];
        $pwd=$_POST['password'];
        $rpwd=$Member->where(array('id'=>$id))->find();
        $oldpwd=$rpwd['password'];
        $User = new UserApi;
        $info['password']= $pwd==$oldpwd?$oldpwd:$this->think_ucenter_md5($pwd,UC_AUTH_KEY);
        $info['email']=$_POST['email'];
        $ss['group_id']=$_POST['auth'];
        $ss['houtai']=$_POST['houtai'];
        $smember=$Member->where($map)->save($info);
        $meb=$mem->where($maps)->save($in);
        if($au->where(array('uid'=>$id))->find()){
        $ag=$au->where(array('uid'=>$id))->save($ss);
        }else{
            $ss['uid']=$id;
          $ag=$au->add($ss);
        }
        
        if($smember||$meb||$ag){
            $this->success('修改成功!',U('User/index'));
        }else{  
            $this->error('修改失败！',U('User/index'));
        }
    }else{
        $map['id']=$_GET['id'];
        $Member=D('UcenterMember')->where($map)->find();
        $au=D('AuthGroupAccess')->where(array('uid'=>$_GET['id']))->find();
        $this->assign("authid",$au["group_id"]);
        $this->assign("houtai",$au["houtai"]);
        $list=D('AuthGroup')->select();
        $username=$_POST['username'];
        $password=$_POST['password'];
        $this->assign('lists',$list);
        $this->assign('list',$Member);
        $this->assign('sd',$group);
        $this->display();
    }
}
/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string 
 */
function think_ucenter_md5($str, $key = 'ThinkUCenter'){
    return '' === $str ? '' : md5(sha1($str) . $key);
}
   
    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '用户名长度必须在16个字符以内！'; break;
            case -2:  $error = '用户名被禁止注册！'; break;
            case -3:  $error = '用户名被占用！'; break;
            case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
            case -5:  $error = '邮箱格式不正确！'; break;
            case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
            case -7:  $error = '邮箱被禁止注册！'; break;
            case -8:  $error = '邮箱被占用！'; break;
            case -9:  $error = '手机格式不正确！'; break;
            case -10: $error = '手机被禁止注册！'; break;
            case -11: $error = '手机号被占用！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }

    /**
     * 站内信展示
     * @author  whh 
     */
    
    public function letter(){
        $map=array();
        $map['status']=0;
        $row=10;
        $page = intval($_GET['p']);
        $page = $page ? $page : 1; //默认显示第一页数据
        $model=M('inside_letter','tab_');
        $data=$model
        ->where($map)
        ->order('id desc')
        ->page($page, 10)
        ->select();
        //print_r($data);exit;
        $count=$model
        ->where($map)
        ->count();
        if($count > $row){
            $page = new \Think\Page($count, $row);
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            $this->assign('_page', $page->show());
        }
        $this->assign('_list', $data);
        $this->display();

    }

    /**
     * 站内信添加
     * @author  whh 
     */
    
    public function letter_add(){
       //print_r($_POST);exit;
       //print_r(session());exit;
       if (IS_POST) {
           $data=I('post.');
           $data['create_time']=time();
           $data['send_account']=session('user_auth.username');
           $model=M('inside_letter','tab_');
           $model->add($data);
           $this->success('站内信添加成功！',U('letter'));
       } else {
           $this->display(); 
       }
       
    }

    /**
     * 站内信查看全文展示
     * @author  whh 
     */
    
   public function letter_contentlist(){
        $id=I('get.id');
        $where['id']=$id;
        $model=M('inside_letter','tab_');
        $data=$model->where($where)->find();
        //echo $model->getLastSql();
        //print_r($data);exit;
        $this->assign('list_data', $data);
        $this->display();
   }

    /**
     * 站内信修改
     * @author  whh 
     */
    
   public function letter_edit(){
        $id=I('get.id');
        $where['id']=$id;
        $model=M('inside_letter','tab_');
        if (IS_POST) {
            $data=I('post.');
            $data['send_account']=session('user_auth.username');  
            $model->where($where)->save($data);
            //echo $model->getLastSql();exit;
            $this->success('站内信修改成功！',U('letter'));
        } else {
            $data=$model->where($where)->find();
            $this->assign('list_data', $data);
            $this->display();
        }
  }

    /**
     * 站内信删除
     * @author  whh 
     */
    
  public function letter_delete(){
        $id=I('get.id');
        $where['id']=$id;
        $data['status']=1;
        $model=M('inside_letter','tab_');
            $model->where($where)->save($data);
            //echo $model->getLastSql();exit;
            $this->success('站内信删除成功！',U('letter'));
       
  }

  /**
     * IP列表展示
     * @author  whh 
     */
   public function forbip(){ 
        $map=array();
        if(isset($_REQUEST['forbid_ip'])){
            $map['forbid_ip'] = $_REQUEST['forbid_ip'];
        }
        //print_r($_REQUEST['forbid_ip']);exit;
       
        $row=10;
        $page = intval($_GET['p']);
        $page = $page ? $page : 1; //默认显示第一页数据
        $model=M('forbid','tab_');
        $data=$model
        ->where($map)
        ->order('id desc')
        ->page($page, 10)
        ->select();
        //print_r($data);exit;
        $count=$model
        ->where($map)
        ->count();
        if($count > $row){
            $page = new \Think\Page($count, $row);
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            $this->assign('_page', $page->show());
        }
        $this->assign('_list', $data);
        $this->meta_title = 'IP信息';
        $this->display();
    }
    /**
     * IP状态修改  禁用 解封
     * @author  whh 
     */
    public function forbid_edit($type,$id){
        if ( empty($id)) {
            $this->error('请选择要操作的数据或类型!');
        }
        switch ($type){
            case '0':
                $map['type']=1;
                break;
            case '1':
                $map['type']=0;
                break;
            default:
                $this->error('参数非法');
        }
        $map['update_time']=time();
        $where['id']=$id;
        $model=M('forbid','tab_');
        $return=$model->where($where)->save($map);
        if ($return === false) {
           $this->error('IP状态修改失败！',U('forbid'));
        } else {
           $this->success('IP状态修改成功！',U('forbid'));
        }
        

    }
    

    /**
     * IP状态修改  禁用 解封
     * @author  whh 
     */
    public function forbid_add(){
          if (IS_POST) {
            $ip=$_POST['forbid_ip'];
            if (empty($ip)) {
               $this->error('请填写IP!');
            } else {
               $iswhere['forbid_ip']=$ip;
               $is=M('forbid','tab_')->where($iswhere)->find();

               if (empty($is)) {
                   $data['forbid_ip']=$ip;
                   $data['create_time']=$data['update_time']=time();
                   $data['type']=0;
                   $where['register_ip']=$ip;
                   $count=M('User','tab_')
                         ->where($where)
                         ->count();
                   $data['reg_num']=$count;
                   $model=M('forbid','tab_');
                   $model->add($data);
                   $this->success('IP添加成功！',U('User/forbid'));
               } else {
                   $this->error('该IP已存在!',U('User/forbid'));
               }
               
               
            }
       } else {
           $this->display(); 
       }
          
    }
  
}