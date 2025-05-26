@extends('layouts.admin')

@section('title')
    تعديل بيانات فئة صنف
@endsection

@section('contentheader')
    فئات الأصناف
@endsection

@section('contentheaderlink')
    <a href="{{ route('Inv_itemcard_categories.index') }}">فئات الأصناف</a>
@endsection

@section('contentheaderactive')
    تعديل
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل بيانات فئة صنف</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(@isset($data) && !@empty($data))
                        <form action="{{ route('Inv_itemcard_categories.update', $data['id']) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label>اسم الفئة</label>
                                <input name="name" id="name" class="form-control" value=" {{ old('name',$data['name']) }} " placeholder="أدخل إسم الخزنة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>حالة التفعيل</label>
                                <select name="active" id="active " class="form-control">
                                    <option selected value="">اختر الحالة</option>
                                    <option @if(@isset($_POST['active']))
                                                @if(old('active')==1 and old('active')!="")
                                                    selected="selected"
                                                @endif
                                            @else
                                                @if($data['active']==1)
                                                    selected="selected"
                                                @endif
                                            @endif
                                                value="1">مفعلة
                                    </option>
                                    <option @if(@isset($_POST['active']))
                                                @if(old('active')==0 and old('active')!="")
                                                    selected="selected"
                                                @endif
                                            @else
                                                @if($data['active']==0)
                                                    selected="selected"
                                                @endif
                                            @endif
                                                value="0">معطلة
                                    </option>
                                </select>
                                @error('active')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
                                <a href="{{ route('Inv_itemcard_categories.index') }}" class="btn btn-sm btn-danger">إلغاء</a>
                            </div>
                        </form>
                    @else
                    <div class="alert alert-danger">
                        !!!  لا يوجد بيانات لعرضها
                    </div>

                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
