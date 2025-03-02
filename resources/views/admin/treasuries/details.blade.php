@extends('layouts.admin')

@section('title')
    تفاصيل الخزنة
@endsection

@section('contentheader')
    الخزن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">الخزن</a>
@endsection

@section('contentheaderactive')
    عرض التفاصيل
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تفاصيل الخزنة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(@isset($data) && !@empty($data))
                    <table id="example2" style="text-align: center" class="table table-bordered table-hover">
                            <tr>
                                <td>اسم الخزنة</td>
                                <td>{{ $data['name'] }}</td>
                            </tr>
                            <tr>
                                <td>آخر إيصال صرف</td>
                                <td>{{ $data['last_isal_exchange'] }}</td>
                            </tr>
                            <tr>
                                <td>آخر إيصال تحصيل</td>
                                <td>{{ $data['last_isal_collect'] }}</td>
                            </tr>
                            <tr>
                                <td>حالة تفعيل الخزنة</td>
                                <td>@if($data['active']==1) مفعل @else معطل @endif</td>
                            </tr>
                            <tr>
                                <td>رئيسية أم لا</td>
                                <td>@if($data['is_master']==1) رئيسية @else فرعية @endif</td>
                            </tr>
                            <tr>
                                <td>تاريخ الإضافة</td>
                                <td>
                                    @php
                                    $dt=new DateTime($data['created_at']);
                                    $date=$dt->format("Y-m-d");
                                    $time=$dt->format("h:i");
                                    $newDateTime=date("A",strtotime($time));
                                    $newDateTimeType= (($newDateTime == 'AM') ? 'صباحاً' : 'مساءً');
                                    @endphp

                                    {{ $date }}
                                    {{ $time }}
                                    {{ $newDateTimeType }}
                                    بواسطة
                                    {{ $data['added_by_admin'] }}
                                </td>
                            </tr>
                            <tr>
                                <td>تاريخ آخر تحديث</td>
                                <td>
                                    @if ($data['updated_by']>0 && $data['updated_by']!=null)
                                        @php
                                        $dt=new DateTime($data['updated_at']);
                                        $date=$dt->format("Y-m-d");
                                        $time=$dt->format("h:i");
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
                                    <a href="{{ route('admin.treasuries.edit',$data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
                                </td>
                            </tr>
                        <tbody>
                        </tbody>
                    </table>

                    <!-- treasuries_delivery -->

                    <div class="card-header">
                        <h4 class="card-title card_title_center">الخزن الفرعية التي تسلم عهدتها الى الخزنة ({{ $data['name'] }})</h4>
                        <a href="{{ route('admin.treasuries.add_treasuries_delivery',$data['id']) }}" class="btn btn-sm btn-info">إضافة خزنة تسليم</a>
                    </div>
                    <div id="ajax_responce_searchDiv">
                        @if(@isset($treasuries_delivery) && !@empty($treasuries_delivery))
                        @php
                            $i=1;
                        @endphp
                        <table id="example2" style="text-align: center" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <th>رقم الخزنة</th>
                                <th>اسم الخزنة</th>
                                <th>----</th>
                                <th>تاريخ الإضافة</th>
                                <th>تاريخ آخر تحديث</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($treasuries_delivery as $info)
                                <tr>
                                    <td>{{ $info->treasuries_can_delivery_id }}</td>
                                    <td>{{ $info->name }}</td>
                                    <td>------</td>
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
                                        <a href="{{ route('admin.treasuries.delete_treasuries_delivery',$info->id) }}" class="btn btn-sm btn-danger  are_you_shu">حذف</a>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                        {{--  <br>
                        {{ $data->links() }}  --}}
                        @else
                        <div class="alert alert-danger">
                            عفواً لا يوجد بيانات لعرضها   !!!
                        </div>
                        @endif
                    </div>

                    <!-- End treasuries_delivery -->

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
