<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class OrderDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    // protected $fillable = [
    //     'order_id', 'package_id', 'quantity'
    // ];

    protected $guarded = ['id'];

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->id = str_replace('-','',Uuid::uuid4()->getHex());
        });
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
