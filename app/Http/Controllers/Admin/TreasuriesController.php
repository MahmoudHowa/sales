<?php

namespace App\Http\Controllers\Admin;

use App\Models\Treasuries;
use App\Http\Controllers\Controller;
use App\Http\Requests\TreasuriesRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use PhpParser\Builder\Trait_;
use PhpParser\Node\Stmt\TryCatch;

use function Ramsey\Uuid\v1;

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

    public function create(){
        return view('admin.treasuries.create');
    }

    public function store(TreasuriesRequest $request){
        try{
            $com_code = auth()->user()->com_code;
            // check if not exist
            $checkExists=Treasuries::where(['name'=>$request->name,'com_code'=>$com_code])->first();
            if($checkExists==null){
                if($request->is_master==1){
                    $checkExists_isMaster=Treasuries::where(['is_master'=>1,'com_code'=>$com_code])->first();
                    if($checkExists_isMaster!=null){
                        return redirect()->back()->with(['error'=> 'عفواً هناك خزنة رئيسية بالفعل لايمكن أن يكون هناك أكثرمن خزنة رئيسية واحدة'] )->withInput();
                    }
                }
                $data['name']=$request->name;
                $data['is_master']=$request->is_master;
                $data['last_isal_exchange']=$request->last_isal_exchange;
                $data['last_isal_collect']=$request->last_isal_collect;
                $data['active']=$request->active;
                $data['created_at']=date("Y-m-d H:i:s");
                $data['added_by']=auth()->user()->id;
                $data['com_code']=$com_code;
                $data['date']=date("Y-m-d");
                Treasuries::create($data);
                return redirect()->route('admin.treasuries.index')->with(['success'=> 'تم إضافة البيانات بنجاح'] );

            }else{
                return redirect()->back()->with(['error'=> 'عفواً اسم الخزنة موجود  بالفعل'])->withInput();
            }
        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=> 'عفواً حدث خطأ ما'.'  '.$ex->getMessage()] )->withInput();
        }
    }

    public function edit($id){
        $data = Treasuries::select()->find($id);
        return view('admin.treasuries.edit', ['data'=>$data]);
    }

    public function update($id,TreasuriesRequest $request){
        try{
            $com_code = auth()->user()->com_code;
            $data=Treasuries::select()->find($id);
            if(empty($data)){
            return redirect()->route('admin.treasuries.index')->with(['error'=> 'عفواً لا يمكن الوصول الى البيانات المطلوبة'] );
            }
            $checkExists=Treasuries::where(['name'=>$request->name,'com_code'=>$com_code])->where('id','!=',$id)->first();
            if($checkExists!=null){
                return redirect()->back()->with(['error'=> 'عفواً اسم الخزنة موجود  بالفعل'])->withInput();
            }
            if($request->is_master==1){
                $checkExists_isMaster=Treasuries::where(['is_master'=>1,'com_code'=>$com_code])->where('id','!=',$id)->first();
                if($checkExists_isMaster!=null){
                    return redirect()->back()->with(['error'=> 'عفواً هناك خزنة رئيسية بالفعل لايمكن أن يكون هناك أكثرمن خزنة رئيسية واحدة'] )->withInput();
                }
            }
            $data_to_update['name']=$request->name;
            $data_to_update['is_master']=$request->is_master;
            $data_to_update['last_isal_exchange']=$request->last_isal_exchange;
            $data_to_update['last_isal_collect']=$request->last_isal_collect;
            $data_to_update['active']=$request->active;
            $data_to_update['updated_by']=auth()->user()->id;
            $data_to_update['updated_at']=date("Y-m-d H:i:s");
            Treasuries::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
            return redirect()->route('admin.treasuries.index')->with(['success'=> 'تم تعديل البيانات بنجاح'] );

        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=> 'عفواً حدث خطأ ما'.'  '.$ex->getMessage()] )->withInput();
        }
    }
}
