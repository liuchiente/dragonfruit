<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function category(Request $request){
        $response['is_done']=true;
        $response['data']=json_decode('[
          {
            "featured": true,
            "icon_url": "assets/icons/Discount.svg",
            "name": "MS電磁開關"
          },
          {
            "featured": false,
            "icon_url": "assets/icons/High-heels.svg",
            "name": "樓宇自動化控制"
          },
          {
            "featured": false,
            "icon_url": "assets/icons/Woman-dress.svg",
            "name": "機電產品"
          },
          {
            "featured": false,
            "icon_url": "assets/icons/Man-Clothes.svg",
            "name": "手工具"
          },
          {
            "featured": false,
            "icon_url": "assets/icons/Man-Pants.svg",
            "name": "感測器"
          },
          {
            "featured": false,
            "icon_url": "assets/icons/Man-Shoes.svg",
            "name": "接線盒"
          }
        ]',true);
        return $response;
    }

    public function cart(Request $request){
        $response['is_done']=true;
        $response['data']=json_decode('[
          {
            "image": [
              "assets/images/nikeblack.jpg",
              "assets/images/nikegrey.jpg"
        ],
            "name": "Nike Waffle One",
            "price": 1429000,
            "count": 1
          },
          {
            "image": [
              "assets/images/nikegrey.jpg",
              "assets/images/nikeblack.jpg"
        ],
            "name": "Nike Blazer Mid77 Vintage",
            "price": 1429000,
            "count": 1
          },
          {
            "image": [
              "assets/images/nikehoodie.jpg",
              "assets/images/nikehoodie.jpg"
        ],
            "name": "Nike Sportswear Swoosh",
            "price": 849000,
            "count": 1
          }
        ]',true);
        return $response;
    }

    public function message(Request $request){
        $response['is_done']=true;
        $response['data']=json_decode('[
          {
              "is_readed": true,
              "shop_logo_url": "assets/images/adidaslogo.jpg",
              "message": "Lorem ipsum sit dolor amet",
              "shop_name": "Adidas Indonesia"
          },
          {
              "is_readed": true,
              "shop_logo_url": "assets/images/nikelogo.jpg",
              "message": "Lorem ipsum sit dolor amet",
              "shop_name": "Nike Indonesia"
          },
          {
              "is_readed": false,
              "shop_logo_url": "assets/images/guccilogo.jpg",
              "message": "Lorem ipsum sit dolor amet",
              "shop_name": "Gucci"
          },
          {
              "is_readed": true,
              "shop_logo_url": "assets/images/zaralogo.jpg",
              "message": "Lorem ipsum sit dolor amet",
              "shop_name": "Zara Indonesia"
          }
          ]',true);
        return $response;
    }

    public function notification(Request $request){
        $response['is_done']=true;
        $response['data']=json_decode('[
          {
            "image_url": "assets/images/nikeblack.jpg",
            "title": "#21070 Order Status",
            "date_time": "${DateTime.now()}",
            "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. "
          },
          {
            "image_url": "assets/images/nikegrey.jpg",
            "title": "#30127 Order Canclelled",
            "date_time": "${DateTime.now()}",
            "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. "
          },
          {
            "image_url": "assets/images/nikehoodie.jpg",
            "title": "Payment Time limit for #1021820",
            "date_time": "${DateTime.now()}",
            "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. "
          },
          {
            "image_url": "assets/images/nikeblack.jpg",
            "title": "#21070 Order Status",
            "date_time": "${DateTime.now()}",
            "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. "
          }
        ]',true);
        return $response;
    }

    public function product(Request $request){
        $response['is_done']=true;
        $response['data']=json_decode('[
          {
            "image": [
              "assets/images/a30.jpg",
              "https://www.fonlee.com.tw/ad_webspec_2/3_PICTURE/1678/1707/1708/JWE0ERE4312W/JWE0ERE4312W.PNG"
            ],
            "name": "三菱<電容器>用接觸器 S-N65SC AC220V",
            "price": 1429000,
            "rating": 4,
            "description": "三菱<電容器>用接觸器 S-N65SC AC220V",
            "store_name": "豐立",
            "colors": [
              {
                "name": "black",
                "color": "0x000000"
              },
              {
                "name": "blueGrey",
                "color": "0xB0BEC5"
              },
              {
                "name": "pink",
                "color": "0xF8BBD0"
              },
              {
                "name": "white",
                "color": "0xFFFFFF"
              }
            ],
            "sizes": [
              {
                "size": "36.0",
                "name": "36"
              },
              {
                "size": "37.0",
                "name": "37"
              },
              {
                "size": "38.0",
                "name": "38"
              },
              {
                "size": "42.0",
                "name": "42"
              }
            ],
            "reviews": [
              {
                "photo_url": "assets/images/avatar1.jpg",
                "name": "Uchiha Sasuke",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar2.jpg",
                "name": "Uzumaki Naruto",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar3.jpg",
                "name": "Kurokooo Tetsuya",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              }
            ]
          },
          {
            "image": [
              "assets/images/a31.gif",
              "assets/images/a31.gif"
            ],
            "name": "三菱接觸器 SD-Q19 DC24V",
            "price": 1429000,
            "rating": 4,
            "description": "三菱接觸器 SD-Q19 DC24V",
            "store_name": "豐立",
            "colors": [
              {
                "name": "black",
                "color": "0x000000"
              },
              {
                "name": "blueGrey",
                "color": "0xB0BEC5"
              },
              {
                "name": "pink",
                "color": "0xF8BBD0"
              },
              {
                "name": "white",
                "color": "0xFFFFFF"
              }
            ],
            "sizes": [
              {
                "size": "36.0",
                "name": "36"
              },
              {
                "size": "37.0",
                "name": "37"
              },
              {
                "size": "38.0",
                "name": "38"
              },
              {
                "size": "42.0",
                "name": "42"
              }
            ],
            "reviews": [
              {
                "photo_url": "assets/images/avatar1.jpg",
                "name": "Uchiha Sasuke",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar2.jpg",
                "name": "Uzumaki Naruto",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar3.jpg",
                "name": "Kurokooo Tetsuya",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              }
            ]
          },
          {
            "image": [
              "assets/images/a32.jpg",
              "assets/images/a32.jpg"
            ],
            "name": "三菱<電容器>用接觸器 S-N80SC AC220V",
            "price": 849000,
            "rating": 4,
            "description": "三菱<電容器>用接觸器 S-N80SC AC220V",
            "store_name": "豐立",
            "colors": [
              {
                "name": "black",
                "color": "0x000000"
              },
              {
                "name": "blueGrey",
                "color": "0xB0BEC5"
              },
              {
                "name": "pink",
                "color": "0xF8BBD0"
              },
              {
                "name": "white",
                "color": "0xFFFFFF"
              }
            ],
            "sizes": [
              {
                "size": "36.0",
                "name": "36"
              },
              {
                "size": "37.0",
                "name": "37"
              },
              {
                "size": "38.0",
                "name": "38"
              },
              {
                "size": "42.0",
                "name": "42"
              }
            ],
            "reviews": [
              {
                "photo_url": "assets/images/avatar1.jpg",
                "name": "Uchiha Sasuke",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar2.jpg",
                "name": "Uzumaki Naruto",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar3.jpg",
                "name": "Kurokooo Tetsuya",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              }
            ]
          },
          {
            "image": [
              "assets/images/037.jpg",
              "assets/images/037.jpg"
            ],
            "name": "GUL HR-706D 自動收線器 12AWG/3C*10M",
            "price": 1900000,
            "rating": 4,
            "description": "GUL HR-706D 自動收線器 12AWG/3C*10M",
            "store_name": "豐立",
            "colors": [
              {
                "name": "black",
                "color": "0x000000"
              },
              {
                "name": "blueGrey",
                "color": "0xB0BEC5"
              },
              {
                "name": "pink",
                "color": "0xF8BBD0"
              },
              {
                "name": "white",
                "color": "0xFFFFFF"
              }
            ],
            "sizes": [
              {
                "size": "36.0",
                "name": "36"
              },
              {
                "size": "37.0",
                "name": "37"
              },
              {
                "size": "38.0",
                "name": "38"
              },
              {
                "size": "42.0",
                "name": "42"
              }
            ],
            "reviews": [
              {
                "photo_url": "assets/images/avatar1.jpg",
                "name": "Uchiha Sasuke",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar2.jpg",
                "name": "Uzumaki Naruto",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar3.jpg",
                "name": "Kurokooo Tetsuya",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              }
            ]
          }
        ]',true);
        return $response;
    }

    public function search(Request $request){
        $response['is_done']=true;
        $response['data']=json_decode('[
          {
            "image": [
              "assets/images/search/searchitem6.jpg",
              "assets/images/nikegrey.jpg"
            ],
            "name": "Air Jordan XXXVI SE PF",
            "price": 2729000,
            "rating": 4,
            "description": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
            "store_name": "Nike Indonesia",
            "colors": [
              {
                "name": "black",
                "color": "0x000000"
              },
              {
                "name": "blueGrey",
                "color": "0xB0BEC5"
              },
              {
                "name": "pink",
                "color": "0xF8BBD0"
              },
              {
                "name": "white",
                "color": "0xFFFFFF"
              }
            ],
            "sizes": [
              {
                "size": "36.0",
                "name": "36"
              },
              {
                "size": "37.0",
                "name": "37"
              },
              {
                "size": "38.0",
                "name": "38"
              },
              {
                "size": "42.0",
                "name": "42"
              }
            ],
            "reviews": [
              {
                "photo_url": "assets/images/avatar1.jpg",
                "name": "Uchiha Sasuke",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar2.jpg",
                "name": "Uzumaki Naruto",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar3.jpg",
                "name": "Kurokooo Tetsuya",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              }
            ]
          },
          {
            "image": [
              "assets/images/search/searchitem3.jpg",
              "assets/images/nikeblack.jpg"
            ],
            "name": "Air Jordan 1 Retro OG",
            "price": 1749000,
            "rating": 5,
            "description": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
            "store_name": "Nike Indonesia",
            "colors": [
              {
                "name": "black",
                "color": "0x000000"
              },
              {
                "name": "blueGrey",
                "color": "0xB0BEC5"
              },
              {
                "name": "pink",
                "color": "0xF8BBD0"
              },
              {
                "name": "white",
                "color": "0xFFFFFF"
              }
            ],
            "sizes": [
              {
                "size": "36.0",
                "name": "36"
              },
              {
                "size": "37.0",
                "name": "37"
              },
              {
                "size": "38.0",
                "name": "38"
              },
              {
                "size": "42.0",
                "name": "42"
              }
            ],
            "reviews": [
              {
                "photo_url": "assets/images/avatar1.jpg",
                "name": "Uchiha Sasuke",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar2.jpg",
                "name": "Uzumaki Naruto",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar3.jpg",
                "name": "Kurokooo Tetsuya",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              }
            ]
          },
          {
            "image": [
              "assets/images/search/searchitem5.jpg",
              "assets/images/nikeblack.jpg"
            ],
            "name": "Jordan Point Lane",
            "price": 2099000,
            "rating": 5,
            "description": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
            "store_name": "Nike Indonesia",
            "colors": [
              {
                "name": "black",
                "color": "0x000000"
              },
              {
                "name": "blueGrey",
                "color": "0xB0BEC5"
              },
              {
                "name": "pink",
                "color": "0xF8BBD0"
              },
              {
                "name": "white",
                "color": "0xFFFFFF"
              }
            ],
            "sizes": [
              {
                "size": "36.0",
                "name": "36"
              },
              {
                "size": "37.0",
                "name": "37"
              },
              {
                "size": "38.0",
                "name": "38"
              },
              {
                "size": "42.0",
                "name": "42"
              }
            ],
            "reviews": [
              {
                "photo_url": "assets/images/avatar1.jpg",
                "name": "Uchiha Sasuke",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar2.jpg",
                "name": "Uzumaki Naruto",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar3.jpg",
                "name": "Kurokooo Tetsuya",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              }
            ]
          },
          {
            "image": [
              "assets/images/search/searchitem2.jpg",
              "assets/images/nikeblack.jpg"
            ],
            "name": "Air Jordan 4 Crimson",
            "price": 2779000,
            "rating": 4,
            "description": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
            "store_name": "Nike Indonesia",
            "colors": [
              {
                "name": "black",
                "color": "0x000000"
              },
              {
                "name": "blueGrey",
                "color": "0xB0BEC5"
              },
              {
                "name": "pink",
                "color": "0xF8BBD0"
              },
              {
                "name": "white",
                "color": "0xFFFFFF"
              }
            ],
            "sizes": [
              {
                "size": "36.0",
                "name": "36"
              },
              {
                "size": "37.0",
                "name": "37"
              },
              {
                "size": "38.0",
                "name": "38"
              },
              {
                "size": "42.0",
                "name": "42"
              }
            ],
            "reviews": [
              {
                "photo_url": "assets/images/avatar1.jpg",
                "name": "Uchiha Sasuke",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar2.jpg",
                "name": "Uzumaki Naruto",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar3.jpg",
                "name": "Kurokooo Tetsuya",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              }
            ]
          },
          {
            "image": [
              "assets/images/search/searchitem4.jpg",
              "assets/images/nikeblack.jpg"
            ],
            "name": "Jordan Delta 2 SE",
            "price": 2099000,
            "rating": 5,
            "description": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
            "store_name": "Nike Indonesia",
            "colors": [
              {
                "name": "black",
                "color": "0x000000"
              },
              {
                "name": "blueGrey",
                "color": "0xB0BEC5"
              },
              {
                "name": "pink",
                "color": "0xF8BBD0"
              },
              {
                "name": "white",
                "color": "0xFFFFFF"
              }
            ],
            "sizes": [
              {
                "size": "36.0",
                "name": "36"
              },
              {
                "size": "37.0",
                "name": "37"
              },
              {
                "size": "38.0",
                "name": "38"
              },
              {
                "size": "42.0",
                "name": "42"
              }
            ],
            "reviews": [
              {
                "photo_url": "assets/images/avatar1.jpg",
                "name": "Uchiha Sasuke",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar2.jpg",
                "name": "Uzumaki Naruto",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar3.jpg",
                "name": "Kurokooo Tetsuya",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              }
            ]
          },
          {
            "image": [
              "assets/images/search/searchitem1.jpg",
              "assets/images/nikeblack.jpg"
            ],
            "name": "Jordan One Take 3",
            "price": 1099000,
            "rating": 4,
            "description": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
            "store_name": "Nike Indonesia",
            "colors": [
              {
                "name": "black",
                "color": "0x000000"
              },
              {
                "name": "blueGrey",
                "color": "0xB0BEC5"
              },
              {
                "name": "pink",
                "color": "0xF8BBD0"
              },
              {
                "name": "white",
                "color": "0xFFFFFF"
              }
            ],
            "sizes": [
              {
                "size": "36.0",
                "name": "36"
              },
              {
                "size": "37.0",
                "name": "37"
              },
              {
                "size": "38.0",
                "name": "38"
              },
              {
                "size": "42.0",
                "name": "42"
              }
            ],
            "reviews": [
              {
                "photo_url": "assets/images/avatar1.jpg",
                "name": "Uchiha Sasuke",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar2.jpg",
                "name": "Uzumaki Naruto",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              },
              {
                "photo_url": "assets/images/avatar3.jpg",
                "name": "Kurokooo Tetsuya",
                "review": "Bringing a new look to the Waffle sneaker family, the Nike Waffle One balances everything you love about heritage Nike running with fresh innovations.",
                "rating": 4
              }
            ]
          }
        ]',true);
        return $response;
    }

    public function popular(Request $request){
        $response['is_done']=true;
        $response['data']=json_decode('[
          {
            "title": "橫流扇 TF63610-2AS 80W(13CMM) 220V",
            "image_url": "assets/images/search/p00.jpg"
          },
          {
            "title": "公插頭(PLUGS) 16A/32A IP44",
            "image_url": "assets/images/search/p01.png"
          },
          {
            "title": "SCR電力調整器 靜態開關 積奇",
            "image_url": "assets/images/search/p02.jpg"
          },
          {
            "title": "天得鐵殼動力押扣開關(露出) TBSN-310",
            "image_url": "assets/images/search/p03.jpg"
          },
          {
            "title": "分流器 DC10A / DC50MV",
            "image_url": "assets/images/search/p04.jpg"
          },
          {
            "title": "HIKOKI 充電工具",
            "image_url": "assets/images/search/p05.gif"
          },
          {
            "title": "ProsKit 德式雙色鋼絲鉗 1PK-051DS ",
            "image_url": "assets/images/search/p06.jpg"
          },
          {
            "title": "EATON A-xxxx 離線式",
            "image_url": "assets/images/search/p07.gif"
          }
        ]',true);
        return $response;
    }

    public function news(Request $request){
        $response['is_done']=true;
        $response['data']=json_decode('[
          {
            "logo_url": "assets/images/logo.png",
            "image": "assets/images/s1.jpg",
            "store_name": "豐立",
            "caption": "致各位親愛的客戶:\n111 年 1 月 29 日 (六)～111 年 2 月 6 日(日)，為我司的春節連續假期。\n\n111 年 2 月 7 日 (一) ，為正常上班日。\n\n恭祝大家春節假期愉快！"
          },
          {
            "logo_url": "assets/images/logo.png",
            "image": "assets/images/s1.jpg",
            "store_name": "豐立",
            "caption":
                "2022休假通知-尾牙活動！\n本公司訂於1月8日(六)舉辦尾牙活動，\n\n當日暫不供貨(公休一日)，\n\n1月10日(一)恢復供貨，\n\n若需備料請盡早通知業務或助理，\n\n造成不便，敬請見諒！"
          }
        ]',true);
        return $response;
    }
}
