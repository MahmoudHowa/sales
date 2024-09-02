<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sales_material_types;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\SalesMaterialTypesRequest;


class Sales_material_typesController extends Controller
{
    public function index(){
        $data = Sales_material_types::select()->orderby('id','ASC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){
            foreach ($data as $info){
                $info->added_by_admin = Admin::where('id',$info->added_by)->value('name');
                if($info->updated_by > 0 && $info->updated_by != null){
                    $info->updated_by_admin = Admin::where('id',$info->updated_by)->value('name');
                }
            }
        }
        return view('admin.sales_material_types.index',['data' => $data]);
    }

    public function create(){
        return view('admin.sales_material_types.create');
    }

    public function store(SalesMaterialTypesRequest $request){
        try{
            $com_code = auth()->user()->com_code;
            // check if not exist
            $checkExists=Sales_material_types::where(['name'=>$request->name,'com_code'=>$com_code])->first();
            if($checkExists==null){
                $data['name']=$request->name;
                $data['active']=$request->active;
                $data['created_at']=date("Y-m-d H:i:s");
                $data['added_by']=auth()->user()->id;
                $data['com_code']=$com_code;
                $data['date']=date("Y-m-d");
                Sales_material_types::create($data);
                return redirect()->route('admin.sales_material_types.index')->with(['success'=> 'تم إضافة الفئة بنجاح'] );

            }else{
                return redirect()->back()->with(['error'=> 'عفواً اسم الفئة موجود  بالفعل'])->withInput();
            }
        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=> 'عفواً حدث خطأ ما'.'  '.$ex->getMessage()] )->withInput();
        }
    }

    public function edit($id){
        $data = Sales_material_types::select()->find($id);
        return view('admin.sales_material_types.edit', ['data'=>$data]);
    }

    public function update($id,SalesMaterialTypesRequest $request){
        try{
            $com_code = auth()->user()->com_code;
            $data=Sales_material_types::select()->find($id);
            if(empty($data)){
            return redirect()->route('admin.sales_material_types.index')->with(['error'=> 'عفواً لا يمكن الوصول الى البيانات المطلوبة'] );
            }
            $checkExists=Sales_material_types::where(['name'=>$request->name,'com_code'=>$com_code])->where('id','!=',$id)->first();
            if($checkExists!=null){
                return redirect()->back()->with(['error'=> 'عفواً اسم فئة الفواتير موجود  بالفعل'])->withInput();
            }
            $data_to_update['name']=$request->name;
            $data_to_update['active']=$request->active;
            $data_to_update['updated_by']=auth()->user()->id;
            $data_to_update['updated_at']=date("Y-m-d H:i:s");
            Sales_material_types::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
            return redirect()->route('admin.sales_material_types.index')->with(['success'=> 'تم تعديل البيانات بنجاح'] );

        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=> 'عفواً حدث خطأ ما'.'  '.$ex->getMessage()] )->withInput();
        }
    }
    
    public function delete_material_types ($id){
        try{
            $sales_material_types_row=Sales_material_types::find($id);
            if(!empty($sales_material_types_row)){
                $flag=$sales_material_types_row->delete();
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
