<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user" => $this->user_id,
            "tittle" => $this->tittle,
            "detail" => $this->detail,
            "color" => $this->color,
            "creationDate" => $this->created_at
        ];
    }
}
