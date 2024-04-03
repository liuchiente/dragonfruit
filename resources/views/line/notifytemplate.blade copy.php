<x-app-layout>
   
    <x-slot name="header">
        <h1 class="mt-4">顯示所有可用設計器
        </h1> 
    </x-slot>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Line Notify 設計器</li>
    </ol>
    

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            我的所有卡片
        </div>
        <div class="card-body">
            <table id="cards">
                <thead>
                    <tr>
                        <th>名稱</th>
                        <th>誰能看到</th>
                        <th> <i class="fas fa-gear me-1"></i></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>名稱</th>
                        <th>誰能看到</th>
                        <th></th>
                    </tr>
                </tfoot>

                <tbody>
                @forelse ($cards as $card)
                        <tr>
                        <td><a href="{{$card->designer}}">{{$card->suject}}</a></td>
                        <td>{{$card->shared}}</td>
                        <td><a class="btn btn-outline-primary" role="button" href="{{$card->designer}}"><i class="fas fa-pencil me-1"></a></td>
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
        const designers = document.getElementById('cards');
        if (designers) {
            new simpleDatatables.DataTable(designers);
        }
    });
 </script>   
</x-app-layout>
