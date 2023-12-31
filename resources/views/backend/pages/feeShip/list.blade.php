<table class="table table-bordered table-striped table-hover table-head-fixed text-wrap" id="tbList">
    <thead>
        <tr class="row-heading">
            <th>STT</th>
            <th>Địa điểm nhận</th>
            <th>Phí ship</th>
            <th>Tác vụ</th>
        </tr>
    </thead>
    @php
    $temp=0;
    @endphp
    <tbody>
        @foreach ($items as $val)
        @php
        $temp++;
        $province = isset($val->province->type) ? $val->province->type .' '. $val->province->name : 'Toàn quốc';
        $district = isset($val->district->name) ? $val->district->name.', ' : '';
        $ward = isset($val->ward->name) ? $val->ward->name.', ' : '';
        $adrress = $ward.$district.$province;
        @endphp
        <tr>
            <th scope="row" style="width: 10%" class="text-center">{{$temp}}</th>
            <td style="width: 50%" class=''>{{$adrress}}</td>
            <td style="width: 20%" class='text-center'>{{number_format($val->fee_ship, 0, "" ,"." )}}đ</td>
            <td style="width: 20%" class='text-center'>
                <a href="{{route("$controllerName.edit",$val->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Sửa"><i class="fa fa-edit"></i></a>
                @if($val['id'] != 1)
                <a data-href="{{route("$controllerName.delete",$val->id)}}" class="btn btn-sm btn-danger btn-delete text-white" data-id="{{$val->id}}" data-toggle="tooltip" data-placement="top" title="Xóa"  data-token="{{csrf_token()}}" >
                    <i class="fa fa-trash"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>