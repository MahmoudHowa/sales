<?php

namespace App\Http\Controllers\Admin;

use App\Models\Treasuries;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class TreasuriesController extends Controller
{
    public function index(){
        $data = Treasuries::select()->orderby('id','ASC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){
            foreach ($data as $info){
                $info->added_by_admin = Admin::where('id',$info->added_by)->value('name');
                if($info->updated_by > 0 && $info->updated_by != null){
                    $info->updated_by_admin = Admin::where('id',$info->updated_by)->value('name');
                }
            }
        }
        return view('admin.treasuries.index',['data' => $data]);
    }
}
