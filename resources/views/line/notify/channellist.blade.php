@extends('layouts.admin')

@section('main-content')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.jqueryui.css" />
   <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ __('Line Notify Channels') }}</h1>
    <p class="mb-4"></p>
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Line Notify Channels') }}</h6>
        </div>
        <div class="card-body">
            <p></p>
                <a href="{{route('notify.token.add')}}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                新增一組頻道
                </a>
            <p></p>
            <div class="table-responsive">
                <table class="table table-bordered" id="channelTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>編號</th>
                            <th>主題</th>    
                            <th>頻道金鑰</th>
                            <th>頻道類型</th>
                            <th>啟用狀態</th>
                            <th>新增時間</th>                       
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        @foreach($channels as $channel)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td><a href="{{route('notify.token.edit',['channel' => $channel->id])}}">{{$channel->chl_id}}</a></td>
                            <td>{{$channel->chl_title}}</td>
                            <td>{{$channel->chl_tag}}</td>
                            <td>{{$channel->chl_type}}</td>
                            <td>{{ Constant::enable($channel->chl_status) }}</td>
                            <td>{{$channel->created_at}}</td>
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
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script>
        $('#channelTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/zh-HANT.json',
        }});
    </script>  
@endsection
