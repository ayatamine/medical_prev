<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ScaleResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'scale_id'=> $this->id,
            'scale_title'=>$this->title,
            'scale_title_ar'=>$this->title_ar,
            'scale_short_description'=>$this->short_description,
            'scale_short_description_ar'=>$this->short_description_ar,
        ];
    }
}
