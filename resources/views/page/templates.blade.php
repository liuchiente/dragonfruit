<x-app-layout>
   
    <x-slot name="header">
        <h1 class="mt-4">顯示所有可用設計器
        </h1> 
    </x-slot>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Line卡片設計器</li>
    </ol>
    

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            已開放使用的設計器
        </div>
        <div class="card-body">
            <table id="designers">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>名稱</th>
                        <th>類型</th>
                        <th>用途</th>
                        <th>有效期限</th>
                        <th> <i class="fas fa-gear me-1"></i></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>名稱</th>
                        <th>類型</th>
                        <th>用途</th>
                        <th>有效期限</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                @forelse ($templates as $template)
                        <tr>
                        <td>{{$template->serial}}</td>
                        <td><a href="{{$template->designer}}">{{$template->subject}}</a></td>
                        <td>{{$template->type_name}}</td>
                        <td>{{$template->model_name}}</td>
                        <td>{{$template->expired_at}}</td>
                        <td><a class="btn btn-outline-primary" role="button" href="{{$template->designer}}"><i class="fas fa-pencil me-1"></a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">目前沒有資料</td>
                    </tr>
                @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>

   
 <script>
    window.addEventListener('DOMContentLoaded', event => {
        const designers = document.getElementById('designers');
        if (designers) {
            new simpleDatatables.DataTable(designers);
        }
    });
 </script>   
</x-app-layout>
