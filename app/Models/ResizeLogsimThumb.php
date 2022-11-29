<?php namespace App\models;


use Illuminate\Database\Eloquent\Model;

class ResizeLogsimThumb extends Model {
    
    public $timestamps = false;
    protected $table = "resizelogsimthumb";
    protected $fillable = ['ID','done'];
    
}