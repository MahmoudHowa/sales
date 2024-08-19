@extends('layouts.admin')

@section('title')
    الضبط العام
@endsection

@section('contentheader')
    الخزن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">الخزن</a>
@endsection

@section('contentheaderactive')
    عرض
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات الخزن</h3>
                    <a class="btn btn-sm btn-secondary" href="{{ route('admin.treasuries.create') }}">إضافة خزنة </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="col-md-4">
                        <input type="text" id="search_by_text" placeholder="بحث بالإسم" class="form-control"><br>
                    </div>
                    @if(@isset($data) && !@empty($data))
                    @php
                        $i=1;
                    @endphp

                    <div class="ajax_responce_searchDiv">
                        <table id="example2" style="text-align: center" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <th>رقم الخزنة</th>
                                <th>اسم الخزنة</th>
                                <th>رئيسية أم لا</th>
                                <th>آخر إيصال صرف</th>
                                <th>آخر إيصال تحصيل</th>
                                <th>حالة التفعيل</th>
                                <th>تاريخ الإضافة</th>
                                <th>تاريخ التحديث</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td>{{ $info->name }}</td>
                                    <td>@if($info->is_master == 1) رئيسية @else فرعية @endif</td>
                                    <td>{{ $info->last_isal_exchange }}</td>
                                    <td>{{ $info->last_isal_collect }}</td>
                                    <td>@if($info->active == 1) مفعلة @else معطلة @endif</td>
                                    <td>
                                            @php
                                            $dt=new DateTime($info->created_at);
                                            $date=$dt->format("Y-m-d");
                                            $time=$dt->format("h:i");
                                            $newDateTime=date("A",strtotime($time));
                                            $newDateTimeType= (($newDateTime == 'AM') ? 'صباحاً' : 'مساءً');
                                            @endphp

                                            {{ $date }}
                                            {{ $time }}
                                            {{ $newDateTimeType }}
                                            بواسطة
                                            {{ $info->updated_by_name }}
                                    </td>
                                    <td>
                                        @if ($info->updated_by > 0  and  $info->updated_by != null)
                                            @php
                                            $dt=new DateTime($info->updated_at);
                                            $date=$dt->format("Y-m-d");
                                            $time=$dt->format("h:i");
                                            $newDateTime=date("A",strtotime($time));
                                            $newDateTimeType= (($newDateTime == 'AM') ? 'صباحاً' : 'مساءً');
                                            @endphp

                                            {{ $date }}
                                            {{ $time }}
                                            {{ $newDateTimeType }}
                                            بواسطة
                                            {{ $info->updated_by_admin }}

                                        @else
                                            لا يوجد تحديث
                                        @endif
                                    </td>
                                    <td>
                                        <a href=" {{ route('admin.treasuries.edit', $info->id) }} " class="btn btn-sm btn-primary">تعديل</a>
                                        <button data-id="{{ $info->id }}" class="btn btn-sm btn-info">المزيد</button>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    {{ $data->links() }}
                    @else
                    <div class="alert alert-danger">
                        عفواً لا يوجد بيانات لعرضها   !!!
                    </div>

                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
