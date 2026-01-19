<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'equip_local_id' => $this->equip_local_id,
            'equip_visitant_id' => $this->equip_visitant_id,
            'data_partit' => $this->data_partit,
            'gols_local' => $this->gols_local,
            'gols_visitant' => $this->gols_visitant,
        ];
    }
}