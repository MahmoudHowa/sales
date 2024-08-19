@extends('layouts.admin')

@section('title')
    تعديل بيانات خزنة
@endsection

@section('contentheader')
    الخزن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">الخزن</a>
@endsection

@section('contentheaderactive')
    تعديل
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل بيانات خزنة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(@isset($data) && !@empty($data))
                        <form action="{{ route('admin.treasuries.update', $data['id']) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>اسم الخزنة</label>
                                <input name="name" id="name" class="form-control" value=" {{ old('name',$data['name']) }} " placeholder="أدخل إسم الخزنة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>هل الخزنة رئيسية؟</label>
                                <select name="is_master" id="is_master" class="form-control" name="" id="">
                                    <option value="">اختر النوع</option>
                                    <option @if(@isset($_POST['is_master']))
                                                @if(old('is_master')==1 and old('is_master')!="")
                                                    selected="selected"
                                                @endif
                                            @else
                                                @if($data['is_master']==1)
                                                    selected="selected"
                                                @endif
                                            @endif
                                                value="1">نعم
                                    </option>
                                    <option @if(@isset($_POST['is_master']))
                                                @if(old('is_master')==0 and old('is_master')!="")
                                                    selected="selected"
                                                @endif
                                            @else
                                                @if($data['is_master']==0)
                                                    selected="selected"
                                                @endif
                                            @endif
                                                value="0">لا
                                    </option>
                                </select>
                                @error('is_master')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>آخر رقم إيصال صرف نقدية لهذه الخزنة</label>
                                <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_isal_exchange" id="last_isal_exchange" class="form-control" value=" {{ old('last_isal_exchange',$data['last_isal_exchange']) }} " placeholder="أدخل آخر رقم إيصال صرف نقدية لهذه الخزنة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('last_isal_exchange')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>آخر رقم إيصال تحصيل نقدية لهذه الخزنة</label>
                                <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_isal_collect" id="last_isal_collect" class="form-control" value=" {{ old('last_isal_collect',$data['last_isal_collect']) }} " placeholder="أدخل آخر رقم إيصال تحصيل نقدية لهذه الخزنة" oninvalid="setCustomValidity('هذا الحقل مطلوب')" onchange="try{setCustomValidity('')}catch(e){}">
                                @error('last_isal_collect')
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
                                <a href="{{ route('admin.treasuries.index') }}" class="btn btn-sm btn-danger">إلغاء</a>
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
