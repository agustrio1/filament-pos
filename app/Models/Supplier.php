<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['company_name', 'name_sales', 'contact_name', 'contact_email', 'contact_phone', 'address'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
