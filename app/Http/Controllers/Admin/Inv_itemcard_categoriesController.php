<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inv_itemcard_categoriesRequest;
use App\Models\Admin;
use App\Models\Inv_itemcard_category;
use Illuminate\Http\Request;

class Inv_itemcard_categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Inv_itemcard_category::select()->orderby('id','ASC')->paginate(PAGINATION_COUNT);
        if(!empty($data)){
            foreach ($data as $info){
                $info->added_by_admin = Admin::where('id',$info->added_by)->value('name');
                if($info->updated_by > 0 && $info->updated_by != null){
                    $info->updated_by_admin = Admin::where('id',$info->updated_by)->value('name');
                }
            }
        }
        return view('admin.inv_itemcard_categories.index',['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.inv_itemcard_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Inv_itemcard_categoriesRequest $request)
    {
        try{
            $com_code = auth()->user()->com_code;
            // check if not exist
            $checkExists=Inv_itemcard_category::where(['name'=>$request->name,'com_code'=>$com_code])->first();
            if($checkExists==null){
                $data['name']=$request->name;
                $data['active']=$request->active;
                $data['created_at']=date("Y-m-d H:i:s");
                $data['added_by']=auth()->user()->id;
                $data['com_code']=$com_code;
                $data['date']=date("Y-m-d");
                Inv_itemcard_category::create($data);
                return redirect()->route('Inv_itemcard_categories.index')->with(['success'=> 'تم إضافة بيانات الفئة بنجاح'] );

            }else{
                return redirect()->back()->with(['error'=> 'عفواً اسم الفئة موجود  بالفعل'])->withInput();
            }
        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=> 'عفواً حدث خطأ ما'.'  '.$ex->getMessage()] )->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Inv_itemcard_category::select()->find($id);
        return view('admin.inv_itemcard_categories.edit', ['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Inv_itemcard_categoriesRequest $request, $id)
    {
        try{
            $com_code = auth()->user()->com_code;
            $data=Inv_itemcard_category::select()->find($id);
            if(empty($data)){
            return redirect()->route('Inv_itemcard_categories.index')->with(['error'=> 'عفواً لا يمكن الوصول الى البيانات المطلوبة'] );
            }
            $checkExists=Inv_itemcard_category::where(['name'=>$request->name,'com_code'=>$com_code])->where('id','!=',$id)->first();
            if($checkExists!=null){
                return redirect()->back()->with(['error'=> 'عفواً الفئة موجودة بالفعل'])->withInput();
            }
            $data_to_update['name']=$request->name;
            $data_to_update['active']=$request->active;
            $data_to_update['updated_by']=auth()->user()->id;
            $data_to_update['updated_at']=date("Y-m-d H:i:s");
            Inv_itemcard_category::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
            return redirect()->route('Inv_itemcard_categories.index')->with(['success'=> 'تم تعديل البيانات بنجاح'] );

        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=> 'عفواً حدث خطأ ما'.'  '.$ex->getMessage()] )->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {}
    public function delete($id)
    {
        try{
            $store_row=Inv_itemcard_category::find($id);
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
