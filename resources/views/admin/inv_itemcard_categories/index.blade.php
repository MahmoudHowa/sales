@extends('layouts.admin')

@section('title')
    فئات الأصناف
@endsection

@section('contentheader')
    فئات الأصناف
@endsection

@section('contentheaderlink')
    <a href="{{ route('Inv_itemcard_categories.index') }}">فئات الأصناف</a>
@endsection

@section('contentheaderactive')
    عرض
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات فئات الأصناف</h3>
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.treasuries.ajax_search') }}">
                    <a class="btn btn-sm btn-secondary" href="{{ route('Inv_itemcard_categories.create') }}">إضافة فئة</a>
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
                                <th>رقم فئة الصنف</th>
                                <th>اسم فئة الصنف</th>
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
                                        <a href=" {{ route('Inv_itemcard_categories.edit', $info->id) }} " class="btn btn-sm btn-primary">تعديل</a>
                                        <a href=" {{ route('admin.Inv_itemcard_categories.delete', $info->id) }} " class="btn btn-sm btn-danger are_you_shu">حذف</a>
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
