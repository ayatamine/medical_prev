<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdsResource extends JsonResource
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
            'id'=>$this->id,
            'title'=>$this->title,
            'title_ar'=>$this->title_ar,
            'image'=>$this->image,
            'text'=>$this->text,
            'text_ar'=>$this->text_ar,
            'publish_date'=>$this->publish_date,
            'duration'=>$this->duration.' Day',
        ];
    }
}
