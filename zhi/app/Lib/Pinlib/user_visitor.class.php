<?php
/**
 * 访问者
 *
 * @author andery
 */
class user_visitor {

    public $is_login = false; //登录状态
    public $info = null;

    public function __construct() {
        if (session('?user_info')) {
            //已经登录
            $this->info = session('user_info');
            $this->is_login = true;
        } elseif ($user_info = (array)cookie('user_info')) {
            $user_info = M('user')->field('id,username')->where(array('id'=>$user_info['id'], 'password'=>$user_info['password']))->find();
            if ($user_info) {
                //记住登录状态
                $this->assign_info($user_info);
                $this->is_login = true;
            }
        } else {
            $this->is_login = false;
        }
    }

    /**
     * 登录会话
     */
    public function assign_info($user_info) {
        session('user_info', $user_info);
        $this->info = $user_info;
    }

    /**
     * 记住密码
     */
    public function remember($user_info, $remember = null) {
        if ($remember) {
            $time = 3600 * 24 * 14; //两周
            cookie('user_info', array('id'=>$user_info['id'], 'password'=>$user_info['password']), $time);
        }
    }

    /**
     * 获取用户信息
     */
    public function get($key = null) {
        $info = null;
        if (is_null($key) && $this->info['id']) {
            $info = M('user')->find($this->info['id']);
        } else {
            if (isset($this->info[$key])) {
                return $this->info[$key];
            } else {
                //获取用户表字段
                $fields = M('user')->getDbFields();
                if (!is_null(array_search($key, $fields))) {
                    $info = M('user')->where(array('id' => $this->info['id']))->getField($key);
                }
            }
        }
        return $info;
    }

    /**
     * 登录
     */
    public function login($uid, $remember = null) {
        $user_mod = M('user');
        //更新用户信息
        $user_mod->where(array('id' => $uid))->save(array('last_time' => time(), 'last_ip' => get_client_ip()));
        $user_info = $user_mod->field('id,username,password')->find($uid);
        //保持状态
        $this->assign_info($user_info);
        $this->remember($user_info, $remember);
    }

    /**
     * 退出
     */
    public function logout() {
        session('user_info', null);
        cookie('user_info', null);
    }
    public function check_ipban($user_info){
        $where="(name='$user_info[username]' and type='uname') or (name='$user_info[email]' and type='email')";
        if(M("ipban")->where("name='$user_info[username]' and type='uname'")->count()>0){
            $info="用户名被列入黑名单";
        }
        if(M("ipban")->where("name='$user_info[email]' and type='email'")->count()>0){
            $info="邮箱被列入黑名单";
        }
        if(M("ipban")->where("name='$_SERVER[REMOTE_ADDR]' and type='ip'")->count()>0){
            $info="IP被列入黑名单";
        }
        $this->logout();
        if($info) return $info;
        return false;
    }
}