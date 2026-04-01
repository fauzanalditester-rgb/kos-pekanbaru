<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppTemplate extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_templates';

    protected $fillable = [
        'name',
        'tag',
        'content',
        'icon',
        'icon_color',
        'tag_color',
    ];

    protected $casts = [
        'icon_color' => 'string',
        'tag_color' => 'string',
    ];
}
