<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecommendationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_ar' => $this->title_ar,
            'content' => $this->content,
            'content_ar' => $this->content_ar,
            'duration' => $this->duration,
            'publish_date' => $this->publish_date,
            'sex' => $this->sex,
            'min_age' => $this->min_age,
            'max_age' => $this->max_age,
        ];
    }
}
