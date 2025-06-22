<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialApoio extends Model
{
    use HasFactory;
    protected $fillable = [
        'aula_id', 'professor_id', 'titulo', 'arquivo', 'link', 'tipo', 'descricao'
    ];
    protected $table = 'materiais_apoio';

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }
    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function getIconClassAttribute()
    {
        if ($this->tipo === 'link') {
            if (str_contains($this->link, 'youtube.com') || str_contains($this->link, 'youtu.be')) {
                return 'bi-youtube';
            }
            return 'bi-link-45deg';
        }

        if ($this->tipo === 'arquivo') {
            $extension = pathinfo($this->arquivo, PATHINFO_EXTENSION);
            switch (strtolower($extension)) {
                case 'pdf':
                    return 'bi-file-earmark-pdf-fill';
                case 'doc':
                case 'docx':
                    return 'bi-file-earmark-word-fill';
                case 'ppt':
                case 'pptx':
                    return 'bi-file-earmark-ppt-fill';
                case 'zip':
                case 'rar':
                    return 'bi-file-earmark-zip-fill';
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    return 'bi-file-earmark-image-fill';
                default:
                    return 'bi-file-earmark-fill';
            }
        }

        return 'bi-question-circle-fill';
    }

    public function getYoutubeThumbnailAttribute()
    {
        if ($this->tipo !== 'link' || (!str_contains($this->link, 'youtube.com') && !str_contains($this->link, 'youtu.be'))) {
            return null;
        }

        $videoId = null;
        if (preg_match('/watch\?v=([^\&\?\/]+)/', $this->link, $matches)) {
            $videoId = $matches[1];
        } elseif (preg_match('/youtu.be\/([^\&\?\/]+)/', $this->link, $matches)) {
            $videoId = $matches[1];
        } elseif (preg_match('/embed\/([^\&\?\/]+)/', $this->link, $matches)) {
            $videoId = $matches[1];
        }

        return $videoId ? "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg" : null;
    }
} 