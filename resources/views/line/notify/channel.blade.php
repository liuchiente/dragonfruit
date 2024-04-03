@extends('layouts.admin')

@section('main-content')
   <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ __('Line Notify Channels') }}</h1>
    <p class="mb-4"></p>
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Line Notify Channels') }}</h6>
        </div>
        <div class="card-body">
             <form method="POST" action="{{ route('notify.token.save') }}" class="needs-validation" novalidate>
                @csrf
                <div class="form-group">
                    <label for="comment">主題</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{$channel->chl_title}}" placeholder="取個好記的名字吧, 例如我家群組的通知" required>
                </div>
                <div class="form-group">
                    <label for="chl_type">頻道類型</label>
                    <select class="form-control" id="type" name="type" readonly>
                    <option value="1">Line Notify</option>
                    </select>
                </div>
                <div class="form-group" method="POST" action="{{ route('notify.template.save') }}">
                    <label for="status">啟用狀態</label>
                    <select class="form-control" id="status" name="status" required>
                    <option value="1">啟用</option>
                    <option value="2">停用</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="token">頻道金鑰</label>
                    <input type="text" class="form-control" id="token" namme="token" value="{{$channel->chl_tag}}" readonly>
                </div>
                <div class="form-group">
                    <label for="created_at">新增時間</label>
                    <input type="text" class="form-control" id="created_at" name="created_at" value="{{$channel->created_at}}" readonly>
                    <label for="created_at">修改時間</label>
                    <input type="text" class="form-control" id="updated_at" name="updated_at" value="{{$channel->updated_at}}" readonly>
                    <input type="hidden" id="chl_type_value" name="chl_type_value" value="{{$channel->chl_type}}" readonly>
                    <input type="hidden" id="chl_status_value" name="chl_status_value" value="{{$channel->chl_status}}" readonly>
                    <input type="hidden" id="channel" name="channel" value="{{$channel->id}}" readonly> 
                </div>
                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-check"></i>儲存</button>
                <a class="btn btn-outline-secondary mb-2" href="{{ route('notify.token.show') }}"><i class="fa fa-undo"></i>返回</a>
            </form>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
     <script>
        $('#status').val($('#chl_status_value').val());
        $('#type').val($('#chl_type_value').val());
    </script>  
@endsection
