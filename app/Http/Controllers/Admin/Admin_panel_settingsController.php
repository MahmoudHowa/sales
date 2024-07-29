<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin_panel_setting;
use App\Models\Admin;

class Admin_panel_settingsController extends Controller
{
    public function index(){
        $data=Admin_panel_setting::where('com_code',auth()->user()->com_code)->first();
        if(!empty($data)){
            if($data['updated_by'] > 0 && $data['updated_by'] != null){
                $data['updated_by_admin'] = Admin::where('id',$data['updated_by'])->value('name');
            }
        }
        return View('admin.admin_panel_settings.index',['data'=>$data]);
    }
}
