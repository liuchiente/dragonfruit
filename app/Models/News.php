<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news'; // 若非預設可明確指定

    protected $fillable = [
        'publisher_from', 'publisher', 'subject', 'content', 'content_rich',
        'link', 'link_o', 'id_o', 'publisher_o', 'publish_at', 'expired_at'
    ];

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'news_attachment', 'news_id', 'attachment_id');
    }
}
