<?php

namespace App\Models;
/* Imports */
use DateTimeInterface;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'birth_date',
        'thumbnail',
        'phone_number',
        'otp_verification_code',
        'gender',
        'address',
        'other_problems',
        'height',
        'weight',
        'otp_expire_at',
        'notification_status',
        'has_physical_activity',
        'has_cancer_screening',
        'has_depression_screening',
        'account_status',
        'age',
        'allergy_id',
        'chronic_diseases_id',
        'family_history_id',
    
    ];
    
    
    protected $casts = [
        'notification_status' => 'boolean',
        'has_physical_activity' => 'boolean',
        'has_cancer_screening' => 'boolean',
        'has_depression_screening' => 'boolean',
        'account_status' => 'boolean',
        'other_problems'=>'array'
    
    ];
    
    protected $dates = [
            'otp_expire_at',
        'created_at',
        'updated_at',
    ];

    protected $appends = ["api_route", "can"];

    /* ************************ ACCESSOR ************************* */

    public function getApiRouteAttribute() {
        return route("api.patients.index");
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
    * Many to One Relationship to \App\Models\ChronicDisease::class
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function chronicDisease() {
        return $this->belongsTo(\App\Models\ChronicDisease::class,"chronic_diseases_id","id");
    }
    /**
    * Many to One Relationship to \App\Models\Allergy::class
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function allergy() {
        return $this->belongsTo(\App\Models\Allergy::class,"allergy_id","id");
    }
    /**
    * Many to One Relationship to \App\Models\FamilyHistory::class
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function familyHistory() {
        return $this->belongsTo(\App\Models\FamilyHistory::class,"family_history_id","id");
    }
   
    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function otherProblems(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode(json_decode($value,true)),
        );
    } 
    public function getThumbnailAttribute($value){
        return Storage::disk('public')->url($value);
    }
}
