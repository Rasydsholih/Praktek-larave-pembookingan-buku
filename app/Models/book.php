<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'books';
    
    protected $fillable = [
        'penerbit',
        'penulis',
        'peminjam',
        'judul',
        'tgl_pinjam',
        'status',
        'stock',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'peminjam', 'id');
    }

    public function histories()
    {
        return $this->hasMany(BookHistory::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
    
    
    

}
