<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->{'name_'. $lang}
        ];
    }
}
