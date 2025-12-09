<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JugadoraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
        */
        public function toArray($request)
        {
            return [
                'id' => $this->id,
                'nom' => $this->nom,
                'equip' => $this->equip,
                'posicio' => $this->posicio,
                'dorsal' => $this->dorsal,
                'edat' => $this->edat,
            ];
        }
    }
