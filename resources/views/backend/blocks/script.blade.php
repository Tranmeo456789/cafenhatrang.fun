<script src="{{ asset('template/js/jquery.min.js') }}"></script>
<script src="{{ asset('template/js/nprogress.js') }}"></script>
<script src="{{ asset('template/js/toastr.min.js') }}"></script>
<script src="{{ asset('template/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('template/js/bootstrap-datepicker.vi.min.js') }}"></script>
<script src="{{ asset('template/js/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('template/js/select2.full.min.js') }}"></script>
<script src="{{ asset('template/js/jquery.uploadPreviewer.js') }}"></script>
<script src="{{ asset('template/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/js/moment.min.js') }}"></script>
<script src="{{ asset('backend/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('template/js/adminlte.min.js') }}"></script>
<script src="{{asset('vendor/laravel-filemanager/js/lfm.js')}}"> </script>
<script src="{{ asset('backend/js/my-js.js') }}?ts={{time()}}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    // Gọi API để lấy dữ liệu từ Laravel
    fetch('get-chart-data')
        .then(response => response.json())
        .then(data => {
            // Sử dụng Highcharts để vẽ biểu đồ
            Highcharts.chart('chart-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Biểu đồ doanh thu theo tháng'
                },
                xAxis: {
                    categories: data.categories
                },
                yAxis: {
                    title: {
                        text: 'Doanh thu (VNĐ)'
                    }
                },
                series: data.series,
                accessibility: {
                    enabled: true // Hoặc false nếu bạn muốn tắt module
                 }
            });
        });
</script>   