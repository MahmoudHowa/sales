@extends('layouts.admin')

@section('title')
    تعديل الضبط العام
@endsection

@section('contentheader')
    الضبط
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.adminPanelSetting.index') }}">الضبط</a>
@endsection

@section('contentheaderactive')
    تعديل
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل بيانات الضبط العام</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(@isset($data) && !@empty($data))
                        <form action="{{ route('admin.adminPanelSetting.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>اسم الشركة</label>
                                <input name="system_name" id="system_name" class="form-control" value="{{ $data['system_name'] }}" placeholder="أدخل إسم الشركة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('system_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>عنوان الشركة</label>
                                <input name="address" id="address" class="form-control" value="{{ $data['address'] }}" placeholder="أدخل عنوان الشركة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>هاتف الشركة</label>
                                <input name="phone" id="phone" class="form-control" value="{{ $data['phone'] }}" placeholder="أدخل هاتف الشركة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>رسالة التنبيه أعلى الشاشة للشركة </label>
                                <input name="general_alert" id="general_alert" class="form-control" value="{{ $data['general_alert'] }}" placeholder="أدخل رسالة التنبيه للشركة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                            </div>
                            <div class="form-group">
                                <label>شعار الشركة</label>
                                <div class="image card_title_center">
                                    <img src="{{ asset('assets/admin/uploads').'/'.$data['photo'] }}" alt="لوغو الشركة" class="custom_img">
                                    <br><br>
                                    <button class="btn btn-sm btn-danger" id="update_image">تغيير الصورة</button>
                                    <button class="btn btn-sm btn-danger" style="display: none;" id="cancel_update_image">الغاء تغيير </button>
                                </div>
                                <div id="oldimage">

                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
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
