<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model{
    use HasFactory;
    protected $table = 'parts';

    protected $fillable = [
        'part_no', 'part_name', 'short_name', 'brand', 'model', 
        'unit', 'part_price', 'part_search', 'part_ord', 'is_on', 
        'hits', 'link', 'link_o', 'thumb', 'id_o'
    ];

    public function categories()
    {
       return $this->belongsToMany(Category::class, 'category_parts', 'part_id', 'category_id');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'parts_attachment', 'part_id', 'attachment_id');
    }

    
}

?>