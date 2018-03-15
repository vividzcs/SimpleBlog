<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];

    /**
    * tree取出所有数据
    */
    public function tree(){
    	$category = $this::orderBy('cate_order')->get();
		//dd($category);
		//调用gettree将分类排序
		$data = $this->getTree($category);
		return $data;
    }

    /**
    * getTree()将传过来的数据进行排序
    * @param array $data 要排序的数组 
    */
    /*public function getTree($data){
    	//dd($data);
    	$arr = array();  //用来防排序后的数组
    	foreach($data as $k => $v){
    		//找pid为0的
    		if($v->cate_pid == 0) {
    			$arr[$k] = $v;
    		}
    		//再来一次循环取pid等于上个父循环的cate_id
    		foreach($data as $m =>$n) {
    			if($n->cate_pid == $v->cate_id) {
    				$arr[$m] = $n;
    			}
    		}
    	}
    	dd($arr);
    }*/
    //递归方法来做
    /**
    * 有顺序的排列所有栏目
    * @param array $data 待排序的数组
    * @param int $pid 从哪一个栏目开始往下排
    * @param int $lev 用于显示时增加层次感
    * @return array 排序后的数组
    */
    public function getTree($data,$pid=0,$lev=0) {
    	$arr = array();
    	foreach($data as $v) {
    		if($v->cate_pid == $pid) {
    			$v['lev'] = $lev;
    			$arr[] = $v;
    			$arr = array_merge($arr,$this->getTree($data,$v->cate_id,$lev+1));
    		}
    	}
    	return $arr;
    }
    /**
    * 查出一个栏目的子孙树
    * @param int $pid 从哪一个开始找
    * @return array 数组
    */
    public function getSub($pid = 0){
        $sub = $this::find($pid);
        $subs = $this::all();
        $submenu = [];
        foreach($subs as $v){
            if($v->cate_pid == $sub->cate_id){
                $submenu[] = $v;
                $submenu = array_merge($submenu,$this->getSub($v->cate_id));
            }
        }
        return $submenu;
    }

    /**
    * 面包屑导航
    * @param int $cate_id 文章所属栏目id
    * @return array 返回一顺序的栏目
    */
    public function getPar($cate_id){
        
        $cates = Category::all();
        $par = array();
        while($cate_id != 0){
            foreach($cates as $v){
                if($v->cate_id == $cate_id){
                    $par[] = $v;
                    $cate_id = $v->cate_pid;
                    break;
                }
            }
        }
        return array_reverse($par);
    }


}
