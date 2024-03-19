<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Models\LineChat;

class MediaService
{
    
    private const __DEFAULT_ROWS=10;
    private const __DEFAULT_PAGE=1;
  
    /**
     * 多媒體清單
     */
    public function getList($opt=[]){
        //初始化條件
        $opt['orderBy']=isset($opt['orderBy'])?$opt['orderBy']:"id";
        $opt['asc']=isset($opt['asc'])?$opt['asc']:"desc";
        $opt['row']=(int)(isset($opt['row'])?$opt['row']:self::__DEFAULT_ROWS);
        $opt['page']=(int)(isset($opt['page'])?$opt['page']:self::__DEFAULT_PAGE);

        $offset=$opt['page']*$opt['row'];

        //主題、內容、發佈人、超連結
        $newsList=News::select('id','suject','content','publisher','link_o')->offset($offset)->limit($opt['page'])->orderBy($opt['orderBy'],$opt['asc'])->get();
        return $newsList;
    }

    /**
     * 公告細節
     */
    public function getDetail($id){
      return News::find($id);
    }
    
}