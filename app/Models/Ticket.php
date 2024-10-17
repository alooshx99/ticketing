<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\TicketStatusEnum;
use App\Enums\CategoryEnum;
use App\Models\Reply;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'category',
        'status',
        'image_url',
        'closed_at',
        'receiver_id',
        'SID',
        'attached_files',
    ];

    protected $hidden = ['user_id'];

    protected $casts = [
        'status' => TicketStatusEnum::class,
        'category' => CategoryEnum::class,
    ];

    protected $table = 'tickets';

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }



}
