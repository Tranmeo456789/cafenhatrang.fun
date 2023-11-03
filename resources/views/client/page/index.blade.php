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
	var defaultCoord = [12.279412, 109.191011]; // coord mặc định, 9 giữa HCMC
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
        var marker = L.marker([12.279412, 109.191011]).addTo(mapObj);
        var popup = L.popup();
		popup.setContent("The moonlight cafe");
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
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3898.5389387603173!2d109.18873377419399!3d12.279449429676832!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31706773419ae29b%3A0x3b80deef511a2ec8!2sThe%20MoonLight.%20Coffee%20%26%20Tr%C3%A0%20S%E1%BB%AFa!5e0!3m2!1svi!2s!4v1698975805418!5m2!1svi!2s" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>			<div id="sethPhatMap"></div>
    </div>
</div>

@endsection
