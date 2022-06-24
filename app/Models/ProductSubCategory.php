<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;


class ProductSubCategory extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable;
    protected $fillable = [
        'slug','subcategory_name','created_by','category_id'
    ];




    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function productcategory()
    {
        return $this->belongsTo(productcategory::class);
    }
    public $timestamps = false;

    /**

     * Boot the model.

     */

    protected static function boot()
    {
        parent::boot();

        static::created(function ($ProductSubCategory) {

            $ProductSubCategory->slug = $ProductSubCategory->createSlug($ProductSubCategory->subcategory_name);

            $ProductSubCategory->save();
        });
    }

    /** 
     * Write code on Method
     *
     * @return response()
     */
    private function createSlug($subcategory_name)
    {
        if (static::whereSlug($slug = Str::slug($subcategory_name))->exists()) {

            $max = static::whereName($subcategory_name)->latest('id')->skip(1)->value('slug');

            if (isset($max[-1]) && is_numeric($max[-1])) {

                return preg_replace_callback('/(\d+)$/', function ($mathces) {

                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
