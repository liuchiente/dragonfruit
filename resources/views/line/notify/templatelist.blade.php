@extends('layouts.admin')

@section('main-content')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
   <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ __('Line Notify Templates') }}</h1>
    <p class="mb-4"></p>
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Line Notify Channels') }}</h6>
        </div>
        <div class="card-body">
            <p></p>
                <a href="{{route('notify.template.add')}}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                新增一組範本
                </a>
            <p></p>
            <div class="table-responsive">
                <table class="table table-bordered" id="templateTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>範本編號</th>
                            <th>範本內容</th>
                            <th>發送頻道</th>
                            <th>範本狀態</th>     
                            <th>新增時間</th>    
                            <th>修改時間</th>                      
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>           
                        @foreach($templates as $template)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td><a href="{{route('notify.template.edit',['template' => $template->id])}}">{{$template->plan_id}}</a></td>
                            <td>{{$template->plan_title}}</td>
                            <td>{{$template->plan_context}}</td>
                            <td>{{ Constant::enable($template->plan_status) }}</td>
                            <td>{{$template->created_at}}</td>
                            <td>{{$template->updated_at}}</td>
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
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}" type="module"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}" type="module"></script>
    <script type="module">
        $('#templateTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/zh-HANT.json',
            }
        });
    </script>
@endsection
