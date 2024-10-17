<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'ticket_id',
        'next_reply_id',
        'user_id',
        'SID',
        'attached_files',
        'sender',
    ];

    protected $table = 'replies';

    protected $hidden = [
        'id',
        'ticket_id',
        'user_id',];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
