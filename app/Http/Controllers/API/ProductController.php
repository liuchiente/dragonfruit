<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function category(Request $request)
    {
        $json_str='{
           "is_done":true,
           "payload":[
              {
                 "featured":true,
                 "icon_url":"assets/icons/Discount.svg",
                 "name":"MS電磁開關"
              },
              {
                 "featured":false,
                 "icon_url":"assets/icons/High-heels.svg",
                 "name":"樓宇自動化控制"
              },
              {
                 "featured":false,
                 "icon_url":"assets/icons/Woman-dress.svg",
                 "name":"機電產品"
              },
              {
                 "featured":false,
                 "icon_url":"assets/icons/Man-Clothes.svg",
                 "name":"手工具"
              },
              {
                 "featured":false,
                 "icon_url":"assets/icons/Man-Pants.svg",
                 "name":"感測器"
              },
              {
                 "featured":false,
                 "icon_url":"assets/icons/Man-Shoes.svg",
                 "name":"接線盒"
              }
           ]
        }';
        return response()->json(json_decode($json_str,true));
    }
}
