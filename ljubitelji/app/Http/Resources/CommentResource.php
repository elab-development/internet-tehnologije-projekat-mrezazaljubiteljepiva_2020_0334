<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'comment';
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'text'=>$this->resource->text,
            'user'=>new UserResource($this->resource->user),
            // 'post'=>new PostResource($this->resource->post), // za prikaz svih podataka sa posta 
            'post_id'=>$this->resource->post_id
        ];
    }
}
