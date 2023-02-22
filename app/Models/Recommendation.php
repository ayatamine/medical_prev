<?php

namespace App\Models;
/* Imports */
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = ['title','title_ar','content','content_ar','duration', 'publish_date', 'sex', 'min_age', 'max_age'];
    
    
    
    protected $dates = [
        ];
    public $timestamps = false;
    
    protected $appends = ["api_route", "can"];

    /* ************************ ACCESSOR ************************* */

    public function getApiRouteAttribute() {
        return route("api.recommendations.index");
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
    public function scopeByAgeAndSex($query, $sex, $age)
    {
        return $query->where('sex', $sex)
                     ->where('min_age', '<=', $age)
                     ->where('max_age', '>=', $age);
    }
    public function scopePublishable($query)
    {
        return $query->where(function ($query) {
            $query->whereDate('publish_date', '<=', Carbon::today())
                  ->whereDate('publish_date', '<', Carbon::today()->subDays($this->duration));
        });
    }
}
