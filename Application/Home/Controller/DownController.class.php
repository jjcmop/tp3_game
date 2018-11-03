<?php

namespace Home\Controller;
use Think\Controller;

/**
 * 后台首页控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class DownController extends Controller {
	
	public function down_file($game_id=0,$promote_id=0,$type=1){
		$model = M('Apply','tab_');
		$map['game_id'] = $game_id;
		$map['promote_id'] = $promote_id;
		$data = $model->where($map)->find();
        if($data['status']!=1 || $data['enable_status'] !=1){
            $this->error('下载地址已禁用或未审核！请联系管理员');
            exit();
        }
        $game = M('Game','tab_')->where('id='.$game_id)->find();
        if(!empty($data['pack_url'])){
            $where['id'] =$game_id;
            M('game','tab_')->where($where)->setInc('dow_num',1);
            $model->where($map)->setInc('dow_num',1);
            
            //添加渠道下载记录
            $sdata['game_name']=$game['game_name'];
            $sdata['game_id']=$game_id;
            $sdata['promote_id']= $promote_id;
            $sdata['create_time']= time();
            $wherep['id']=$promote_id;
            $pname=M('promote','tab_')->where($wherep)->getField('account');
            $sdata['promote_account']= $pname;
            $sdata['down_way']=$type;//渠道0
            $downmodel=M('down_record','tab_')->add($sdata);

            $this->down($data['pack_url']);
        }
		else{
            if(empty($game['game_address'])){$this->error('游戏原包暂未上传!');}
            Header("HTTP/1.1 303 See Other");
            Header("Location: ".$game['game_address']); 
        }
        $game->where('id='.$game_id)->setInc('dow_num');
	}

    public function media_down_file($game_id=0,$type=1){
        $model = M('Game','tab_');
        $map['tab_game.id'] = $game_id;
        //$map['file_type'] = $type;
        $data = $model
        ->field('tab_game_source.*,tab_game.game_name,tab_game.game_address')
        ->join("left join tab_game_source on tab_game.id = tab_game_source.game_id")->where($map)->find();
        if(!varify_url($data['game_address'])){
            $this->down($data['file_url']);
        }
        else{
            Header("HTTP/1.1 303 See Other");
            Header("Location: ".$data['game_address']); 
        }
        M('Game','tab_')->where('id='.$game_id)->setInc('dow_num');
    }

	public function down($file, $isLarge = false, $rename = NULL)
	{
		if(headers_sent())return false;
        if(!$file) {
            $this->error('文件不存在哦 亲!');
            //exit('Error 404:The file not found!');
        }
        if($rename==NULL){
            if(strpos($file, '/')===false && strpos($file, '\\')===false)
                $filename = $file;
            else{
                $filename = basename($file);
            }
        }else{
            $filename = $rename;
        }
        header('Content-Description: File Transfer');
        header("Content-Type: application/force-download;");
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: binary");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: '.filesize($file));//$_SERVER['DOCUMENT_ROOT'].
        header("Pragma: no-cache"); //不缓存页面
        //ob_clean();
        flush();
        if($isLarge)
            self::readfileChunked($file);
        else
            // readfile($file);
            header("Location:$file");//大文件下载
    }
}
