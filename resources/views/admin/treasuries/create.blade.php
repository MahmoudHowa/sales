@extends('layouts.admin')

@section('title')
    إضافة خزنة جديدة
@endsection

@section('contentheader')
    الخزن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">الخزن</a>
@endsection

@section('contentheaderactive')
    إضافة
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">إضافة خزنة جديدة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                        <form action="{{ route('admin.treasuries.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>اسم الخزنة</label>
                                <input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="أدخل إسم الخزنة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>هل الخزنة رئيسية؟</label>
                                <select name="is_master" id="is_master" class="form-control" name="" id="">
                                    <option value="">اختر النوع</option>
                                    <option @if(old('is_master')==1) selected="selected"  @endif value="1">نعم</option>
                                    <option @if(old('is_master')==0) selected="selected"  @endif value="0">لا</option>
                                </select>
                                @error('is_master')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>آخر رقم إيصال صرف نقدية لهذه الخزنة</label>
                                <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_isal_exchange" id="last_isal_exchange" class="form-control" value="{{ old('last_isal_exchange') }}" placeholder="أدخل هاتف الشركة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('last_isal_exchange')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>آخر رقم إيصال تحصيل نقدية لهذه الخزنة</label>
                                <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_isal_collect" id="last_isal_collect" class="form-control" value="{{ old('last_isal_collect') }}" placeholder="أدخل هاتف الشركة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('last_isal_collect')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>حالة التفعيل</label>
                                <select name="active" id="active " class="form-control" name="" id="">
                                    <option selected value="">اختر الحالة</option>
                                    <option @if(old('active')==1) selected="selected" @endif value="1">مفعلة</option>
                                    <option @if(old('active')==0) selected="selected" @endif value="0">معطلة</option>
                                </select>
                                @error('active')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{--  <div class="form-group">
                                <label>شعار الشركة</label>
                                <div class="image card_title_center">
                                    <img src="" alt="لوغو الشركة" class="custom_img">
                                    <br><br>
                                    <button class="btn btn-sm btn-danger" id="update_image">تغيير الصورة</button>
                                    <button class="btn btn-sm btn-danger" style="display: none;" id="cancel_update_image">الغاء تغيير </button>
                                </div>
                                <div id="oldimage">

                                </div>
                            </div>  --}}

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-sm">حفظ</button>
                                <a href="{{ route('admin.treasuries.index') }}" class="btn btn-sm btn-danger">إلغاء</a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

@endsection
