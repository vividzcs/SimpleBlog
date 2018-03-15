<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Config;
use Illuminate\Support\Facades\Input;
use Validator;

class ConfigController extends Controller
{
    /**
	* get admin.config
	*/
	public function index(){
		$data = Config::orderBy('conf_order','asc')->get();
		foreach($data as $v){
			switch ($v['field_type']) {
				case 'input':
					$v['_html'] = '<input type="text" name="conf_content[]" class="lg" value="' . $v['conf_content'] . '">';
					break;
				
				case 'textarea':
					$v['_html'] = '<textarea name="conf_content[]" class="lg" cols="30" rows="10">' . $v['conf_content'] . '</textarea>';
					break;
				
				case 'radio':
					$arr = explode(',', $v['field_value']);
					$str = '';
					foreach($arr as $m){
						$r = explode('|', $m);
						if($v['conf_content'] == $r[0]){
							$c = ' checked ';
						}else{
							$c='';
						}
						$str .= '<input type="radio" name="conf_content[]" value="' . $r[0] . '"' . $c . '>' . $r[1] . '　';
					}
					$v['_html'] = $str;
					break;
				
				default:
					$v['_html'] = '';
					break;
			};
		}
		//dd($data->configs());
		return view('admin.configs.index',compact('data'));
	}
	/**
	* get admin.configs/{configs}
	*/
	public function show(){}

	/**
	* 异步排序
	*/
	public function order(){
		$input = Input::all();
		$configs = Config::find($input['conf_id']);
		$configs['conf_order'] = $input['conf_order'];
		$rs = $configs->update();

		if($rs) {
			$data = [
				'status' => 1,
				'msg' => '更改成功'
			];
		}else{
			$data = [
				'status' => 1,
				'msg' => '更改成功'
			];
		}
		return $data;
	}

	/**
	* 将配置项读入文件中，并实时更新
	*
	*/
	public function putFile(){
		$config = Config::pluck('conf_content','conf_name')->all();
		$path = base_path() . '/config/web.php';
		$str = '<?php return ' . var_export($config,true) . ';?>';
		file_put_contents($path, $str);
	}
	/**
	* 修改conf_content
	*/
	public function changeContent(){
		$input = Input::all();
		foreach($input['conf_id'] as $k => $v){
			Config::where('conf_id',$v)->update(['conf_content' => $input['conf_content'][$k]]);
		}
		$this->putFile();
		return back()->with('errors','更新成功');
	}

	/**
	* get admin.configs.create
	*/
	public function create(){
		return view('admin.configs.add');
	}

	/**
	* post admin.configs
	*/
	public function store(){
		$input = Input::except('_token');
		//dd($input);
		//验证
		$rules = [
			'conf_name' => 'required',
			'conf_title' => 'required',
			'field_type' => 'required'
		];
		$message = [
			'conf_name.required' => '配置项名不能为空',
			'conf_title.required' => '配置项标题不能为空',
			'field_type.required' => '配置项类型不能为空'
		];
		$validator = Validator::make($input,$rules,$message);
		if(!$validator->passes()){
			return back()->withErrors($validator);
		}else{
			$rs = Config::create($input);
			if($rs) {
				return redirect('admin/config');
			}else{
				return back()->with('errors','添加配置项失败!');
			}
		}
	}

	/**
	* delete admin.config/{config}
	*/
	public function destroy($conf_id){
		$rs = Config::where('conf_id',$conf_id)->delete();
		if($rs) {
			$this->putFile();
			$msg = [
				'status' => 1,
				'msg' => '配置项删除成功!'
			];
		}else{
			$msg = [
				'status' => 0,
				'msg' => '配置项删除失败!'
			];
		}
		return $msg;
	}

	/**
	* get admin.configs/{configs}/edit
	*/
	public function edit($conf_id){
		//echo $cate_id;
		$configs = Config::find($conf_id);
		//dd($cates);
		return view('admin.configs.edit',compact('configs'));
	}

	/**
	*put admin.configs/{configs}
	*/
	public function update($conf_id){
		//接收表单信息
		$input = Input::except('_token','_method');
		//dd($input);
		//接收成功，开始验证
		$rules = [
			'conf_name' => 'required',
			'conf_title' => 'required',
			'field_type' => 'required'
		];
		$message = [
			'conf_name.required' => '配置项名不能为空',
			'conf_title.required' => '配置项标题不能为空',
			'field_type.required' => '配置项类型不能为空'
		];
		$validator = Validator::make($input,$rules,$message);
		//dd($validator);
		if(!$validator->passes()){
			return back()->withErrors($validator);
		}else{
			//通过验证
			$rs = Config::where('conf_id',$conf_id)->update($input);
			if($rs){
				$this->putFile();
				return redirect('admin/config');
			}else{
				return back()->with('errors','更新失败');
			}
		}

	}
}
