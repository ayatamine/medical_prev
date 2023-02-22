<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientScaleResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       return [
            'scale_id'=> $this->scale->id,
            'scale_title'=>$this->scale->title,
            'scale_title_ar'=>$this->scale->title_ar,
            'scale_short_description'=>$this->scale->short_description,
            'scale_short_description_ar'=>$this->scale->short_description_ar,
            'choosed_answers'=> json_decode($this->scale_questions_answers)
       ];
    }
}
