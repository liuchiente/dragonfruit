@extends('layouts.admin')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Line卡片設計器</h1>
<p class="mb-4"></p>
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">我的所有卡片</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="cards" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>名稱</th>
                        <th>誰能看到</th>
                        <th>分享給別人</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($cards as $card)
                    <tr>
                        <td>{{$loop->index+1}}</a></td>
                        <td><a href="{{$card->designer}}">{{$card->subject}}</a></td>
                        <td>{{ $card->shared==0 ? '我自己' : '所有人' }}</td>
                        <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="shareCard_{{$card->id}}" name="shareCard" value="{{$card->id}}" {{ $card->shared==0 ? '' : 'checked' }}>
                                <label class="form-check-label" for="shareCard">點我共享</label>
                            </div>
                            <!--<a class="btn btn-outline-primary" role="button" href="{{$card->designer}}"><i class="fas fa-fw fa-pen"></a>-->
                        </td>
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
    $('#cards').DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/zh-HANT.json',
    }});

    $('input:checkbox[name="shareCard"]').change(function() {
        $.ajax({url: "share-card", type: 'POST',data: { _token: "{{ csrf_token() }}", card: $(this).val(), share: $(this).prop('checked') }, success: function(result){
            //location.reload();
        }});
    });
</script>  

@endsection