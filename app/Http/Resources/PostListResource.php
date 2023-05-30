<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Config;

class PostListResource extends JsonResource
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
			"title" => $this->title,
			"url_title" => $this->url_title,
			"created_at" => $this->created_at->format( Config::$DateFormattingString ),
//			"updated_at" => $this->updated_at->format( Config::$DateFormattingString ),
			"author" => $this->author,
			"body" => $this->body,
		];
    }
}
