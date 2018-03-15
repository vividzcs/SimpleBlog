<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Comment extends Model
{
    protected $table = 'comment';
    protected $primaryKey = 'comment_id';
    public $timestamps = false;
    protected $guarded = [];

    /**
    * 查出一个文章下的所有评论
    * @param int $pid 从哪一个开始找
    * @return array 数组
    */
    public function getComment($art_id){
        $coms = $this::where('art_id',$art_id)->get();
        $comsmenu = [];
        $n = 0;
        foreach($coms as $c){
            if($c->parent_id == 0){
                $comsmenu[$n][0] = $c;
                foreach($coms as $v) {
                    if($v->parent_id == $c->comment_id) {
                        $comsmenu[$n][1][] = $v;
                    }
                }
                $n++;
            }
        }
        
        return $comsmenu;

    }



}
