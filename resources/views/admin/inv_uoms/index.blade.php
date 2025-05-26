@extends('layouts.admin')

@section('title')
    الوحدات
@endsection

@section('contentheader')
    الوحدات
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.uoms.index') }}">الوحدات</a>
@endsection

@section('contentheaderactive')
    عرض
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات وحدات الأصناف </h3>
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.uoms.ajax_search') }}">
                    <a class="btn btn-sm btn-secondary" href="{{ route('admin.uoms.create') }}">إضافة وحدة</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="search_by_text" placeholder="بحث بالإسم" class="form-control"><br>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="is_master_search" id="is_master_search" class="form-control" name="" id="">
                                    <option value="all">بحث بالكل</option>
                                    <option value="1">وحدة رئيسية</option>
                                    <option value="0">وحدة تجزئة</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="ajax_responce_searchDiv">
                                @if(@isset($data) && !@empty($data))
                                @php
                                    $i=1;
                                @endphp
                                <table id="example2" style="text-align: center" class="table table-bordered table-hover">
                                    <thead class="custom_thead">
                                        <th>رقم الوحدة</th>
                                        <th>اسم الوحدة</th>
                                        <th>نوع الوحدة </th>
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
                                            <td>@if($info->is_master == 1) رئيسية @else تجزئة @endif</td>
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
                                                    {{ $info->added_by_admin }}
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
                                                <a href=" {{ route('admin.uoms.edit', $info->id) }} " class="btn btn-sm btn-primary">تعديل</a>
                                                <a href=" {{ route('admin.uoms.delete', $info->id) }} " class="btn btn-sm btn-danger are_you_shu">حذف</a>
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
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
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/inv_uoms.js') }}"></script>
@endsection
