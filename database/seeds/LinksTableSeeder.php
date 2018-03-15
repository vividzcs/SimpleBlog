<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$data = [
    		[
    			'link_name' => '六维空间',
    			'link_title' => '一个自学网站',
    			'link_url' => 'http://ilearnspace.cn',
    			'link_order' => 1,
    		],
    		[
    			'link_name' => '百度',
    			'link_title' => '搜索引擎',
    			'link_url' => 'http://baidu.com',
    			'link_order' => 2,
    		]
    	];
        DB::table('links')->insert($data);
    }
}
