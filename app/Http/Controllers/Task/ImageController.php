<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;


class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // 限制最大10MB
        ]);

        $file = $request->file('image');
        $originalSize = $file->getSize(); // bytes

        // 建立檔案名稱與路徑
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = 'uploads/' . $filename;

        if ($originalSize > 1 * 1024 * 1024) { // > 1MB
            // 壓縮圖片

            $image=Image::read($file)->resize(640, null, function ($constraint) {
                $constraint->aspectRatio(); // 保持原始比例
                $constraint->upsize();      // 避免小圖被放大（可選）
            });

            // 壓縮成 JPEG 並設品質
            $image = $image->toPng(); // 可選 toWebp(80) or toPng()

            Storage::disk('public')->put($path, (string) $image);
        } else {
            // 不壓縮，直接儲存
            Storage::disk('public')->putFileAs('uploads', $file, $filename);
        }

        // 返回公開網址
        $url = Storage::disk('public')->url($path);

        return response()->json([
            'metadata'=>[
                 'url' => $url
            ]
        ]);
    }
}
