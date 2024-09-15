<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoresRequest;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function index(){
        $data = Store::select()->orderby('id','ASC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){
            foreach ($data as $info){
                $info->added_by_admin = Admin::where('id',$info->added_by)->value('name');
                if($info->updated_by > 0 && $info->updated_by != null){
                    $info->updated_by_admin = Admin::where('id',$info->updated_by)->value('name');
                }
            }
        }
        return view('admin.stores.index',['data' => $data]);
    }
    public function create(){
        return view('admin.stores.create');
    }

    public function store(StoresRequest $request){
        try{
            $com_code = auth()->user()->com_code;
            // check if not exist
            $checkExists=Store::where(['name'=>$request->name,'com_code'=>$com_code])->first();
            if($checkExists==null){
                $data['name']=$request->name;
                $data['phones']=$request->phones;
                $data['address']=$request->address;
                $data['active']=$request->active;
                $data['created_at']=date("Y-m-d H:i:s");
                $data['added_by']=auth()->user()->id;
                $data['com_code']=$com_code;
                $data['date']=date("Y-m-d");
                Store::create($data);
                return redirect()->route('admin.stores.index')->with(['success'=> 'تم إضافة المخزن بنجاح'] );

            }else{
                return redirect()->back()->with(['error'=> 'عفواً اسم المخزن موجود  بالفعل'])->withInput();
            }
        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=> 'عفواً حدث خطأ ما'.'  '.$ex->getMessage()] )->withInput();
        }
    }

    public function edit($id){
        $data = Store::select()->find($id);
        return view('admin.stores.edit', ['data'=>$data]);
    }

    public function update($id,StoresRequest $request){
        try{
            $com_code = auth()->user()->com_code;
            $data=Store::select()->find($id);
            if(empty($data)){
            return redirect()->route('admin.stores.index')->with(['error'=> 'عفواً لا يمكن الوصول الى البيانات المطلوبة'] );
            }
            $checkExists=Store::where(['name'=>$request->name,'com_code'=>$com_code])->where('id','!=',$id)->first();
            if($checkExists!=null){
                return redirect()->back()->with(['error'=> 'عفواً المخزن موجود  بالفعل'])->withInput();
            }
            $data_to_update['name']=$request->name;
            $data_to_update['phones']=$request->phones;
            $data_to_update['address']=$request->address;
            $data_to_update['active']=$request->active;
            $data_to_update['updated_by']=auth()->user()->id;
            $data_to_update['updated_at']=date("Y-m-d H:i:s");
            Store::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
            return redirect()->route('admin.stores.index')->with(['success'=> 'تم تعديل البيانات بنجاح'] );

        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=> 'عفواً حدث خطأ ما'.'  '.$ex->getMessage()] )->withInput();
        }
    }

    public function delete_stores ($id){
        try{
            $store_row=Store::find($id);
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
