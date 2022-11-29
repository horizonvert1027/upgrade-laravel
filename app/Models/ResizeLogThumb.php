<?php namespace App\models;


use Illuminate\Database\Eloquent\Model;

class ResizeLogThumb extends Model {
    
    public $timestamps = false;
    protected $table = "resizelogthumb";
    protected $fillable = ['ID','done'];
    
}