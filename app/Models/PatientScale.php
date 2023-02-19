<?php

namespace App\Models;
/* Imports */
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientScale extends Model
{
    use HasFactory;
protected $table = 'patient_scale';
    
    protected $fillable = [
        'scale_questions_answers',
        'patient_id',
        'scale_id',
    
    ];
    
    
    
    protected $dates = [
            'created_at',
        'updated_at',
    ];

    protected $appends = ["api_route", "can"];

    /* ************************ ACCESSOR ************************* */

    public function getApiRouteAttribute() {
        return route("api.patient-scales.index");
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
    /**
    * Many to One Relationship to \App\Models\Patient::class
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function patient() {
        return $this->belongsTo(\App\Models\Patient::class,"patient_id","id");
    }
    /**
    * Many to One Relationship to \App\Models\Scale::class
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function scale() {
        return $this->belongsTo(\App\Models\Scale::class,"scale_id","id");
    }
}