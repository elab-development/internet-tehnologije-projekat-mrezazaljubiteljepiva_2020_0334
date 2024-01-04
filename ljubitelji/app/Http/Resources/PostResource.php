<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'post';
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id'=>$this->resource->id,
            'text'=>$this->resource->text,
            'post_title'=>$this->resource->post_title,
            //'user'=>$this->resource->user
            'user'=> new UserResource($this->resource->user) // za vracanje full usera
        ];
    }
}
