@extends('layouts.admin')

@section('title')
    المخازن
@endsection

@section('contentheader')
    المخازن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.stores.index') }}">المخازن</a>
@endsection

@section('contentheaderactive')
    عرض
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات المخازن </h3>
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.treasuries.ajax_search') }}">
                    <a class="btn btn-sm btn-secondary" href="{{ route('admin.stores.create') }}">إضافة مخزن</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div id="ajax_responce_searchDiv">
                        @if(@isset($data) && !@empty($data))
                        @php
                            $i=1;
                        @endphp
                        <table id="example2" style="text-align: center" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <th>رقم المخزن</th>
                                <th>اسم المخزن</th>
                                <th>أرقام هواتف المخزن</th>
                                <th>عنوان المخزن</th>
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
                                    <td>{{ $info->phones }}</td>
                                    <td>{{ $info->address }}</td>
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
                                            {{ $info->updated_by_admin }}
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
                                        <a href=" {{ route('admin.stores.edit', $info->id) }} " class="btn btn-sm btn-primary">تعديل</a>
                                        <a href=" {{ route('admin.stores.delete_stores', $info->id) }} " class="btn btn-sm btn-danger">حذف</a>
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

@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/treasuries.js') }}"></script>
@endsection
