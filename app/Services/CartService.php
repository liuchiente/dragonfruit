<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Models\Part;

class CartService
{
    
    private const __DEFAULT_ROWS=10;
    private const __DEFAULT_PAGE=1;
  
    /**
     * 產品清單
     */
    public function getList($opt=[],$param=[]){
        //初始化條件
        $opt['order']=isset($opt['order'])?$opt['order']:"id";
        $opt['asc']=isset($opt['asc'])?$opt['asc']:"desc";
        $opt['row']=(int)(isset($opt['row'])?$opt['row']:self::__DEFAULT_ROWS);
        $opt['page']=(int)(isset($opt['page'])?$opt['page']:self::__DEFAULT_PAGE);
        $opt['query']=isset($opt['query'])?$opt['query']:"";

        $offset=$opt['page']*$opt['row'];

        //$parts=Part::where('is_on',1)->skip($offset)->take($opt['row'])->get();

        //$partList=Part::select('id','suject','content','publisher','link_o')->offset($offset)->limit($opt['page'])->orderBy($opt['orderBy'],$opt['asc'])->get();
        return $newsList;
    }

    /**
     * 產品細節
     */
    public function getDetail($id){
      return Part::find($id);
    }

}