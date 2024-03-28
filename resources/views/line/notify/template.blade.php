@extends('layouts.admin')

@section('main-content')
   <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ __('Line Notify Templates') }}</h1>
    <p class="mb-4"></p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Line Notify Templates') }}</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
             <form method="POST" action="{{ route('notify.template.save') }}" name="templat-form" class="needs-validation" novalidate>
                @csrf
                <div class="form-group">
                    <label for="comment">主題</label>
                    <input type="text" class="form-control" id="plan_title" name="plan_title" value="{{$template->plan_title ?? Constant::blank()}}" placeholder="取個好記的名字吧, 例如我家群組的通知" required>
                    <label for="plan_id">範本編號</label>
                    <input type="text" class="form-control" id="plan_id" name="plan_id" value="{{$template->plan_id ?? Constant::blank()}}" readonly>
                </div>
                <div class="form-group">
                    <label for="channel">發送頻道</label>
                    <select class="form-control" id="channel" name="channel" readonly required>
                    @foreach($channels as $channel)
                        <option value="{{$channel->id}}">{{$channel->chi_title}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="schedule_cron">發送規則</label>
                    <div class="row cron-ui"></div>
                    <p></p>
                    <input type="text" class="form-control" id="scheduler_cron" name="scheduler_cron" value="{{$template->scheduler_cron ?? '1 1 1 1 *'}}" readonly>
                </div>
                <div class="form-group" method="POST" action="{{ route('notify.template.save') }}">
                    <label for="status">啟用狀態</label>
                    <select class="form-control" id="status" name="status" required>
                    <option value="1">啟用</option>
                    <option value="2">停用</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="plan_context">範本內容</label>
                    <textarea class="form-control" id="plan_context" name="plan_context" rows="12" required>{{$template->plan_context ?? Constant::blank()}}</textarea>
                </div>
                <div class="form-group">
                    <label for="created_at">新增時間</label>
                    <input type="text" class="form-control" id="created_at" name="created_at" value="{{$template->created_at ?? Constant::now()}}" readonly>
                    <label for="created_at">修改時間</label>
                    <input type="text" class="form-control" id="updated_at" name="updated_at" value="{{$template->updated_at ?? Constant::now()}}" readonly>
                    <label for="created_at">發送時間</label>
                    <input type="text" class="form-control" id="send_at" name="send_at" value="{{$template->send_at ?? Constant::blank()}}" readonly>
                    <input type="hidden" id="plan_status_value" name="plan_status_value" value="{{$template->plan_status ?? Constant::zero()}}" readonly>
                    <input type="hidden" id="plain_channel_value" name="plain_channel_value" value="{{$template->plain_channel ?? Constant::zero()}}" readonly>
                    <input type="hidden" id="scheduler" name="scheduler" value="{{$template->scheduler ?? Constant::zero() }}" readonly> 
                    <input type="hidden" id="template" name="template" value="{{$template->id ?? Constant::zero() }}" readonly> 
                </div>
                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-check"></i>{{ __('Save') }}</button>
                <a class="btn btn-outline-secondary mb-2" href="{{ route('notify.template.show') }}"><i class="fa fa-undo"></i>{{ __('Back') }}</a>
            </form>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}" type="module"></script>
    <script src="{{ asset('vendor/bootstrap-cronui/jquery.cronui.js') }}" type="module"></script>
    <script src="{{ asset('vendor/bootstrap-cronui/i18n/jquery.cronui-zh-TW.js') }}" type="module"></script>
    <script type="module">
        $(function () {
            $('#status').val($('#plan_status_value').val());
            $('#channel').val($('#plain_channel_value').val());
            $('.cron-ui').cronui({
                initial : $('#scheduler_cron').val(),
                dropDownStyledFlat: false,
                resultOutputId: 'scheduler_cron',
                lang: 'zh-TW'
            });           
        });
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
                });
            }, false);
        })();
    </script>  
@endsection
