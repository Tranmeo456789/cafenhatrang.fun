@php
use App\Model\PageModel;

$params['slug']=$slugpage;
$page=(new PageModel)->getItem($params,['task'=>'get-item-in-slug']);

@endphp

@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    var mapObj = null;
	var defaultCoord = [11.987858, 109.194340]; // coord mặc định, 9 giữa HCMC
	var zoomLevel = 15;
	var mapConfig = {
		attributionControl: false, // để ko hiện watermark nữa
		center: defaultCoord, // vị trí map mặc định hiện tại
		zoom: zoomLevel, // level zoom
	};
	
	window.onload = function() {
		// init map
		mapObj = L.map('sethPhatMap', {attributionControl: false}).setView(defaultCoord, zoomLevel);
		// add tile để map có thể hoạt động, xài free từ OSM
		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '© <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(mapObj);
        var marker = L.marker([11.987858, 109.194340]).addTo(mapObj);
        var popup = L.popup();
		popup.setContent("Cửa hàng anh thức");
		marker.bindPopup(popup);
        marker.openPopup();
	};
</script>
<style>
		#sethPhatMap {
			width:100%;
			height: 400px;
		}
	</style>
<div class="wp-inner">
    {!!$page->content!!}
    <h6 class="mt-3">Địa chỉ liên hệ</h6>
    <div class='wp-google-map' style="width: 100%;">
        <!-- c1 thêm map -->
        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3902.808205830573!2d109.19176497418952!3d11.987769235685523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31708cd69b5ef2c9%3A0xd05031d03046bbe4!2zMTYyIE5ndXnhu4VuIENow60gVGhhbmgsIENhbSBOZ2jEqWEsIENhbSBSYW5oLCBLaMOhbmggSMOyYSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1698911051790!5m2!1svi!2s"
            height="450"
            style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe> -->
        <div id="sethPhatMap"></div>
    </div>
</div>

@endsection
