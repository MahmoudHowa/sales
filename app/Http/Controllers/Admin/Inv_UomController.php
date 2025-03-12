<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inv_uomRequest;
use App\Models\Admin;
use App\Models\Inv_uom;
use Illuminate\Http\Request;

class Inv_UomController extends Controller
{
    public function index(){
        $data = Inv_uom::select()->orderby('id','ASC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){
            foreach ($data as $info){
                $info->added_by_admin = Admin ::where('id',$info->added_by)->value('name');
                if($info->updated_by > 0 && $info->updated_by != null){
                    $info->updated_by_admin = Admin::where('id',$info->updated_by)->value('name');
                }
            }
        }
        return view('admin.inv_uoms.index',['data' => $data]);
    }

    public function create(){
        return view('admin.inv_uoms.create');
    }

    public function store(Inv_uomRequest $request){
        try{
            $com_code = auth()->user()->com_code;
            // check if not exist
            $checkExists=Inv_uom::where(['name'=>$request->name,'com_code'=>$com_code])->first();
            if($checkExists==null){
                $data['name']=$request->name;
                $data['is_master']=$request->is_master;
                $data['active']=$request->active;
                $data['created_at']=date("Y-m-d H:i:s");
                $data['added_by']=auth()->user()->id;
                $data['com_code']=$com_code;
                $data['date']=date("Y-m-d");
                Inv_uom::create($data);
                return redirect()->route('admin.uoms.index')->with(['success'=> 'تم إضافة بيانات الوحدة بنجاح'] );

            }else{
                return redirect()->back()->with(['error'=> 'عفواً اسم الوحدة موجود  بالفعل'])->withInput();
            }
        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=> 'عفواً حدث خطأ ما'.'  '.$ex->getMessage()] )->withInput();
        }
    }

    public function edit($id){
        $data = Inv_uom::select()->find($id);
        return view('admin.inv_uoms.edit', ['data'=>$data]);
    }

    public function update($id,Inv_uomRequest $request){
        try{
            $com_code = auth()->user()->com_code;
            $data=Inv_uom::select()->find($id);
            if(empty($data)){
            return redirect()->route('admin.uoms.index')->with(['error'=> 'عفواً لا يمكن الوصول الى البيانات المطلوبة'] );
            }
            $checkExists=Inv_uom::where(['name'=>$request->name,'com_code'=>$com_code])->where('id','!=',$id)->first();
            if($checkExists!=null){
                return redirect()->back()->with(['error'=> 'عفواً المخزن موجود  بالفعل'])->withInput();
            }
            $data_to_update['name']=$request->name;
            $data_to_update['is_master']=$request->is_master;
            $data_to_update['active']=$request->active;
            $data_to_update['updated_by']=auth()->user()->id;
            $data_to_update['updated_at']=date("Y-m-d H:i:s");
            Inv_uom::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
            return redirect()->route('admin.uoms.index')->with(['success'=> 'تم تعديل البيانات بنجاح'] );

        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=> 'عفواً حدث خطأ ما'.'  '.$ex->getMessage()] )->withInput();
        }
    }

    public function ajax_search(Request $request){
        if($request->ajax()){
            $search_by_text=$request->search_by_text;
            if($search_by_text==''){
                $field1="id";
                $operator1=">";
                $value1=0;
            }else{
                $field1="name";
                $operator1="LIKE";
                $value1="%{$search_by_text}%";
            }

            $is_master_search=$request->is_master_search;
            if($is_master_search=='all'){
                $field2="id";
                $operator2=">";
                $value2=0;
            }else{
                $field2="is_master";
                $operator2="=";
                $value2=$is_master_search;
            }

            $data=Inv_uom::where($field1,$operator1,$value1)->where($field2,$operator2,$value2)->orderBy('id','ASC')->paginate(PAGINATION_COUNT);
            if(!empty($data)){
                foreach ($data as $info){
                    $info->added_by_admin = Admin ::where('id',$info->added_by)->value('name');
                    if($info->updated_by > 0 && $info->updated_by != null){
                        $info->updated_by_admin = Admin::where('id',$info->updated_by)->value('name');
                    }
                }
            }
            return view('admin.inv_uoms.ajax_search',['data'=>$data]);
        }
    }

    public function delete ($id){
        try{
            $store_row=Inv_uom::find($id);
            if(!empty($store_row)){
                $flag=$store_row->delete();
                if($flag){
                    return redirect()->back()->with(['success'=>'تم الحذف بنجاح']);
                }else{
                    return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما']);
                }
            }else{
                return redirect()->back()->with(['error'=>'عفوا لايمكن الوصول للبيانات المطلوبة']);
            }
        }
        catch(\Exception $ex){
            return redirect()->back()->with(['error'=> 'عفواً حدث خطأ ما'.'  '.$ex->getMessage()] );
        }
    }
}
