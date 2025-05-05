<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;


class ImageController extends Controller
{

    public function upload(Request $request)
    {
        // 驗證：圖片且最大不超過 10MB (max:10240 = 10240 KB = 10 MB)
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);


        $file = $request->file('image');
        $originalSize      = $file->getSize();                      // bytes
        $originalExtension = $file->getClientOriginalExtension();   // 副檔名
        $basename          = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename          = uniqid($basename . '_') . '.' . $originalExtension;

        // 建立 uploads 目錄 (若不存在)
        $uploadDir = public_path('uploads');
        if (! File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        // 判斷是否大於 2MB
        $threshold = 2 * 1024 * 1024; // 2 MB
        $publicPath = $uploadDir . DIRECTORY_SEPARATOR . $filename;
        if ($originalSize <= $threshold) {
            // 小於等於 2MB：直接搬移
            $file->move($uploadDir, $filename);
        } else {
            // 大於 2MB：先壓縮 (限制寬度 640px，等比例縮放)，再存檔
            
           $image=Image::read($file)->resize(640, null, function ($constraint) {
                $constraint->aspectRatio(); // 保持原始比例
                $constraint->upsize();      // 避免小圖被放大（可選）
            });
            $image = $image->toPng();
            $image->save($publicPath);
        }

        // 回傳可公開存取的 URL
        $url = asset('uploads/' . $filename);

        return response()->json([
            'metadata' => [
                'url' => $url,
                'size_kb' => round($originalSize / 1024, 2),
                'compressed' => $originalSize > $threshold,
            ],
        ]);
    }
}
