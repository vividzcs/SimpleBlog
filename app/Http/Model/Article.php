<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use App\Http\Model\Category;

class Article extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'art_id';
    public $timestamps = false;
    protected $guarded = [];

    /**
    * 得到一个栏目下的所有文章，包括子栏目的文章
    */
    public function getCateArticle($cate_id) {
    	/*where('article.cate_id',$cate_id)->join('category','article.cate_id','=','category.cate_id')
    	->select('article.*','category.cate_name')->orderBy('art_time','desc')->paginate(4);*/
    	$submenu = (new Category)->getSub($cate_id);
    	$cate_ids[] = $cate_id;
    	// dd($submenu);
    	foreach($submenu as $v) {
    		$cate_ids[] = $v->cate_id;
    	}
    	$article = $this::whereIn('article.cate_id',$cate_ids)->join('category','article.cate_id','=','category.cate_id')->select('article.*','category.cate_name')->orderBy('art_time','desc')->paginate(8);

    	// dd($article);
    	return $article;
    	
    }



}
