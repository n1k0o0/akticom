<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @mixin Media
 * @method getUrl
 **/
class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'mime_type' => $this->mime_type,
            'file_name' => $this->file_name,
            'name' => $this->name,
            'url' => $this->getUrl(),
            'id' => $this->id
        ];
    }
}
