<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps=false;
    use HasFactory;
    static public function allProducts()
    {
        $Arr=[];
        foreach (Product::where('status',1)->get() as $k => $p) {
           $Arr[$k] =$p->slug;
        //    $Arr[$k] =  preg_replace(['/-/'],[' '], $p->slug);
        }
        return $Arr;
    }
}
