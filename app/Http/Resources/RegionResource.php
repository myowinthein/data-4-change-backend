<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang = $request->input('lang', 'en');

        return [
            'region' => [
                'id' => $this->id,
                'name' => $this->{'name_'. $lang}
            ],
            'cities' => CityResource::collection($this->cities)
        ];
    }
}