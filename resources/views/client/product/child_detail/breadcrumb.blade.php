@php
use App\Model\CatProductModel;
$catId=$productCurrent['cat_id'];
$catParentProduct=(new CatProductModel)->getItem(['id'=>$catId],['task'=>'get-item']);
@endphp
<div class="secion-detail">
    <ul class="list-item clearfix">
        <li><a href="{{url('/')}}" title="">Trang chủ</a></li>
        <li>
            <a href="{{url('san-pham')}}" title="">Sản phẩm</a>
        </li>   
        <li>
            <a href="{{route('cat0.product',$catParentProduct->slug)}}" title="">{{$catParentProduct['name']}}</a>
        </li>
    </ul>
</div>