<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            // 'post'=> [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'path_image' => $this->path_image,
                'created_at' => $this->created_at->format('Y - M - d'),
                'updated_at' => $this->updated_at->format('Y - M - d'),
            //  ],
            // 'error' => 'false',
            // 'message' =>  'post',
            ];
    }
}
