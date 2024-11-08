<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JournalDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'transaction_code' => $this->transaction_code,
            'description' => $this->description,
            'journal_details' => JournalDetailItemResource::collection($this->journal_details)
        ];
    }
}
