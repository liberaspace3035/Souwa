<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'link',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_published' => 'boolean',
    ];

    /**
     * 画像URLを取得
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        $disk = config('filesystems.images', 'public');
        $storage = Storage::disk($disk);
        
        // S3/R2の場合
        if (in_array($disk, ['s3', 'r2'])) {
            $url = config("filesystems.disks.{$disk}.url");
            if ($url) {
                // AWS_URLが設定されている場合（カスタムドメインまたはPublic Development URL）
                return rtrim($url, '/') . '/' . ltrim($this->image, '/');
            } else {
                // AWS_URLが設定されていない場合、Public Development URLを構築
                // R2のPublic Development URL形式: https://<bucket-name>.<account-id>.r2.dev
                $bucket = config("filesystems.disks.{$disk}.bucket");
                $endpoint = config("filesystems.disks.{$disk}.endpoint");
                
                // エンドポイントからアカウントIDを抽出
                if ($endpoint && preg_match('/https:\/\/([a-f0-9]+)\.r2\.cloudflarestorage\.com/', $endpoint, $matches)) {
                    $accountId = $matches[1];
                    // Public Development URLを構築
                    $publicUrl = "https://{$bucket}.{$accountId}.r2.dev";
                    return rtrim($publicUrl, '/') . '/' . ltrim($this->image, '/');
                }
                
                // フォールバック: 一時的な署名付きURLを生成（1時間有効）
                return $storage->temporaryUrl($this->image, now()->addHours(1));
            }
        }
        
        return $storage->url($this->image);
    }
}
