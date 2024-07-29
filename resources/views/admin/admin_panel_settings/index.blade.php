@extends('layouts.admin')

@section('title')
    الضبط العام
@endsection

@section('contentheader')
    الضبط
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.adminPanelSetting.index') }}">الضبط</a>
@endsection

@section('contentheaderactive')
    عرض
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">بيانات الضبط العام</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(@isset($data) && !@empty($data))
                    <table id="example2" style="text-align: center" class="table table-bordered table-hover">
                            <tr>
                                <td>اسم الشركة</td>
                                <td>{{ $data['system_name'] }}</td>
                            </tr>
                            <tr>
                                <td>كود الشركة</td>
                                <td>{{ $data['com_code'] }}</td>
                            </tr>
                            <tr>
                                <td>حالة الشركة</td>
                                <td>@if($data['active']==1) مفعل @else معطل @endif</td>
                            </tr>
                            <tr>
                                <td>عنوان الشركة</td>
                                <td>{{ $data['address'] }}</td>
                            </tr>
                            <tr>
                                <td>هاتف الشركة</td>
                                <td>{{ $data['phone'] }}</td>
                            </tr>
                            <tr>
                                <td>رسالة تنبيه اعلى الشاشة للشركة</td>
                                <td>{{ $data['general_alert'] }}</td>
                            </tr>
                            <tr>
                                <td>لوغو الشركة</td>
                                <td><div class="image"><img src="{{ asset('assets/admin/uploads').'/'.$data['photo'] }}" alt="لوغو الشركة" class="custom_img"></div></td>
                            </tr>
                            <tr>
                                <td>تاريخ آخر تحديث</td>
                                <td>
                                    @if ($data['updated_by']>0 && $data['updated_by']!=null)
                                        @php
                                        $dt=new DateTime($data['updated_at']);
                                        $date=$dt->format("Y-m-d");
                                        $time=$dt->format("H:i");
                                        $newDateTime=date("A",strtotime($time));
                                        $newDateTimeType= (($newDateTime == 'AM') ? 'صباحاً' : 'مساءً');
                                        @endphp

                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newDateTimeType }}
                                        بواسطة
                                        {{ $data['updated_by_admin'] }}

                                    @else
                                        لا يوجد تحديث
                                    @endif
                                </td>
                            </tr>
                        <tbody>
                        </tbody>
                    </table>
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
