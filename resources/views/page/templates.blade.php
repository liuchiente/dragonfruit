@extends('layouts.admin')

@section('main-content')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.jqueryui.css" />

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Line卡片設計器</h1>
<p class="mb-4"></p>
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">已開放使用的設計器</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="designers" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>序號</th>
                        <th>名稱</th>
                        <th>類型</th>
                        <th>用途</th>
                        <th>有效期限</th>      
                    </tr>
                </thead>
                <tbody>
                @foreach ($templates as $template)
                        <tr>
                        <td>{{$loop->index+1}}</a></td>
                        <td>{{$template->serial}}</td>
                        <td><a href="{{$template->designer}}">{{$template->subject}}</a></td>
                        <td>{{$template->type_name}}</td>
                        <td>{{$template->model_name}}</td>
                        <td>{{$template->expired_at}}</td>
                    </tr>
                @endforeach        
                </tbody>
            </table>
        </div>
    </div>
</div>
@if(Session::has('active-message'))
<script type="module">
    Swal.fire({
    title:"{{Session::get('active-title')}}",
    text:"{{Session::get('active-message')}}",
    icon: "info"
    });
</script> 
@endif

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $('#designers').DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/zh-HANT.json',
    }});
</script> 
@endsection
