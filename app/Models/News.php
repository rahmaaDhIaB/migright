<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_fr' ,
        'description_fr' ,
        'title_en' ,
        'description_en' ,
        'title_ar' ,
        'description_ar' ,
        'image',
        'is_archive'
    ] ;

    public static function getPopularNews($locale = 'en'){
        switch ($locale) {
            case 'fr':
                $news =  self::Select('id' , 'title_fr as title', 'description_fr as description' ,'image')->where('is_archive',0)->orderBy('created_at', 'desc')->take(3)->get();
                break;
            case 'ar':
                $news =  self::Select('id' , 'title_ar as title', 'description_ar as description', 'image')->where('is_archive',0)->orderBy('created_at', 'desc')->take(3)->get();
                break;
            default:
                $news =  self::Select('id' , 'title_en as title', 'description_en as description', 'image')->where('is_archive',0)->orderBy('created_at', 'desc')->take(3)->get();
        }
        return $news;
    }

    public static function getNews($locale = 'en' , $perPage = 5){
        switch ($locale) {
            case 'fr':
                $news =  self::Select('id' , 'title_fr as title', 'description_fr as description' ,'image')->where('is_archive',0)->orderBy('created_at', 'desc')->cursorPaginate($perPage);
                break;
            case 'ar':
                $news =  self::Select('id' , 'title_ar as title', 'description_ar as description', 'image')->where('is_archive',0)->orderBy('created_at', 'desc')->cursorPaginate($perPage);
                break;
            default:
                $news =  self::Select('id' , 'title_en as title', 'description_en as description', 'image')->where('is_archive',0)->orderBy('created_at', 'desc')->cursorPaginate($perPage);
        }
        return $news;
    }

    public static function findNewsById($newsId,$locale = 'en'){
        switch ($locale) {
            case 'fr':
                $news =  self::Select('id' , 'title_fr as title', 'description_fr as description' ,'image')->findOrFail($newsId);
                break;
            case 'ar':
                $news =  self::Select('id' , 'title_ar as title', 'description_ar as description', 'image')->findOrFail($newsId);
                break;
            default:
                $news =  self::Select('id' , 'title_en as title', 'description_en as description', 'image')->findOrFail($newsId);
        }
        return $news;
    }
}
