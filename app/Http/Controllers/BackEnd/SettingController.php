<?php

namespace App\Http\Controllers\BackEnd;

use App\Model\SettingModel as MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BackEnd\BackEndController;
use App\Http\Requests\SettingRequest as MainRequest;

use App\Helpers\MyFunction;
use Illuminate\Support\Facades\Storage;
use DB;
use Session;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
class SettingController extends BackEndController
{
    public function __construct()
    {
        $this->controllerName     = 'setting';
        $this->pathViewController = "$this->moduleName.pages.$this->controllerName.";
        $this->pageTitle          = 'Cài đặt trang chủ';
        $this->model = new MainModel();
        parent::__construct();
    }
    
    public function formInfomation(Request $request)
    {
        $item = null;     
        $params["id"] = 1;
        $item = $this->model->getItem($params, ['task' => 'get-item']);
           
        return view($this->pathViewController . 'formInfomation', compact(
            'item',
        ));
    }
    public function saveInfomation(MainRequest $request)
    {
        if (!$request->ajax()) return view("errors." .  'notfound', []);
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $request->validator->errors()
            ]);
        }
        if ($request->method() == 'POST') {
            $params = $request->all();        
            $params['user_id']=Auth::id();          
            $task   = "edit-item";
            $notify = "Cập nhật thông tin thành công!";
            $filename = 'logo.png';
            if($request->hasFile('file')){
                $file=$request->file;
                $filePath = 'images/logo.png'.$filename;

                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $file->move('public/images', $filename);
            }else{
                $item = $this->model->getItem($params, ['task' => 'get-item']);
                $filename=$item['logo'];
            }
            $params['logo']=$filename;
            $this->model->saveItem($params, ['task' => $task]);
            $request->session()->put('app_notify', $notify);
                return response()->json([
                    'fail' => false,
                    'redirect_url' => route("$this->controllerName.infomation"),
                    'message'      => $notify,
                ]);
            
        }
    }
    
}
