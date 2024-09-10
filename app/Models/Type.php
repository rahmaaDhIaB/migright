<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_fr' ,
        'type_en' ,
        'type_ar' ,
        'category'
    ] ;

    public function demands() : BelongsToMany
    {
        return $this->belongsToMany(Demand::class);
    }

    public static function getTestimonialTypes($locale = 'en'){
        switch ($locale) {
            case 'fr':
                $types =  self::Select('id' , 'type_fr as name')->where('category','testimony')->get();
                break;
            case 'en':
                $types =  self::Select('id' , 'type_en as name')->where('category','testimony')->get();
                break;
            default:
                $types =  self::Select('id' , 'type_ar as name')->where('category','testimony')->get();
        }
        return $types;
    }

    public static function getAssistanceTypes($locale = 'en'){
        switch ($locale) {
            case 'fr':
                $types =  self::Select('id' , 'type_fr as name')->where('category','assistance')->get();
                break;
            case 'en':
                $types =  self::Select('id' , 'type_en as name')->where('category','assistance')->get();
                break;
            default:
                $types =  self::Select('id' , 'type_ar as name')->where('category','assistance')->get();
        }
        return $types;
    }

    public static function getLostPersonTypes($locale = 'en'){
        switch ($locale) {
            case 'fr':
                $types =  self::Select('id' , 'type_fr as name')->where('category','lost-person')->get();
                break;
            case 'en':
                $types =  self::Select('id' , 'type_en as name')->where('category','lost-person')->get();
                break;
            default:
                $types =  self::Select('id' , 'type_ar as name')->where('category','lost-person')->get();
        }
        return $types;
    }
}
