<?php

namespace App\Http\Resources;

use App\Models\Sticker;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Sticker */
class StickerResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_en' => $this->name_en,
            'code' => $this->code,
            'barcode' => $this->barcode,
            'composition' => $this->composition,
            'country' => $this->country,
            'manufacturer' => $this->manufacturer,
            'description' => $this->description,
            'manufacturer_country' => $this->manufacturer_country,
            'manufacturer_phone' => $this->manufacturer_phone,
            'manufacturer_address' => $this->manufacturer_address,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'image_count' => $this->image_count,
            'media_count' => $this->media_count,
            'registerMediaConversionsUsingModelInstance' => $this->registerMediaConversionsUsingModelInstance,

            'images' => ImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
