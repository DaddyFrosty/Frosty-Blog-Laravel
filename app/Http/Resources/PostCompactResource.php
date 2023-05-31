<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Config;

class PostCompactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) : Array
    {
		return [
			"title" => mb_strlen( $this->title ) > Config::$SidebarPostTitleMaxLength
				? mb_substr( $this->title, 0, Config::$SidebarPostTitleMaxLength ) . "..."
				: $this->title,
			"url_title" => $this->url_title
		];
    }
}
