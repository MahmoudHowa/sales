@if(@isset($data) && !@empty($data))
@php
    $i=1;
@endphp
    <table id="example2" style="text-align: center" class="table table-bordered table-hover">
        <thead class="custom_thead">
            <th>رقم الوحدة</th>
            <th>اسم الوحدة</th>
            <th>نوع الوحدة</th>
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
                        {{ $info->added_by_name }}
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
                    <a href=" {{ route('admin.uoms.delete', $info->id) }} " class="btn btn-sm btn-danger">حذف</a>
                </td>
            </tr>
            @php
                $i++;
            @endphp
            @endforeach
        </tbody>
    </table>
    <br>
    <div class="col-md-12" id="ajax_pagination_in_search">
        {{ $data->links() }}
    </div>
    @else
    <div class="alert alert-danger">
    عفواً لا يوجد بيانات لعرضها   !!!
    </div>
@endif
