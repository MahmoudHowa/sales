@extends('layouts.admin')

@section('title')
    إضافة مخزن جديد
@endsection

@section('contentheader')
    المخازن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.stores.index') }}">المخازن</a>
@endsection

@section('contentheaderactive')
    إضافة
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">إضافة مخزن جديد</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                        <form action="{{ route('admin.stores.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>اسم المخزن</label>
                                <input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="أدخل إسم المخزن" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>هاتف المخزن</label>
                                <input name="phones" id="phones" class="form-control" value="{{ old('phones') }}" placeholder="أدخل رقم هاتف المخزن" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('phones')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>عنوان المخزن</label>
                                <input name="address" id="address" class="form-control" value="{{ old('address') }}" placeholder="أدخل عنوان المخزن" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>حالة التفعيل</label>
                                <select name="active" id="active " class="form-control" name="" id="">
                                    <option selected value="">اختر الحالة</option>
                                    <option @if(old('active')==1) selected="selected" @endif value="1">مفعل</option>
                                    <option @if(old('active')==0 and old('active')!="") selected="selected" @endif value="0">معطل</option>
                                </select>
                                @error('active')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-sm">حفظ</button>
                                <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-danger">إلغاء</a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

@endsection
