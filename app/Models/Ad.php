<?php

namespace App\Models;
/* Imports */
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','title_ar','image','duration','text','text_ar','created_at','updated_at'
    ];
    
    
    
    protected $dates = [
        ];
public $timestamps = false;
    
    protected $appends = ["api_route", "can"];

    /* ************************ ACCESSOR ************************* */

    public function getApiRouteAttribute() {
        return route("api.ads.index");
    }
    public function getCanAttribute() {
        return [
            "view" => \Auth::check() && \Auth::user()->can("view", $this),
            "update" => \Auth::check() && \Auth::user()->can("update", $this),
            "delete" => \Auth::check() && \Auth::user()->can("delete", $this),
            "restore" => \Auth::check() && \Auth::user()->can("restore", $this),
            "forceDelete" => \Auth::check() && \Auth::user()->can("forceDelete", $this),
        ];
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    /* ************************ RELATIONS ************************ */
    public function scopePublishable($query)
    {
        return $query->where(function ($query) {
            $query->whereDate('publish_date', '<=', Carbon::today())
                  ->whereDate('publish_date', '<', Carbon::today()->subDays($this->duration));
        });
    }
    public function getImageAttribute($value){
        return Storage::disk('public')->url($value);
    }
}
