@extends('layouts.admin')

@section('title')
    إضافة فئة جديدة
@endsection

@section('contentheader')
    فئات الفواتير
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.sales_material_types.index') }}">فئات الفواتير</a>
@endsection

@section('contentheaderactive')
    إضافة
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">إضافة فئة فواتير جديدة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                        <form action="{{ route('admin.sales_material_types.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>اسم فئة الفواتير</label>
                                <input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="أدخل إسم الفئة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>حالة التفعيل</label>
                                <select name="active" id="active " class="form-control" name="" id="">
                                    <option selected value="">اختر الحالة</option>
                                    <option @if(old('active')==1) selected="selected" @endif value="1">مفعلة</option>
                                    <option @if(old('active')==0 and old('active')!="") selected="selected" @endif value="0">معطلة</option>
                                </select>
                                @error('active')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-sm">حفظ</button>
                                <a href="{{ route('admin.sales_material_types.index') }}" class="btn btn-sm btn-danger">إلغاء</a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

@endsection
