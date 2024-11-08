<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'category_name' => $this->subcategory->category->name,
            'subcategory_name' => $this->subcategory->name,
            'account_name' => $this->name,
            'initial_balance' => $this->initial_balance,
            'initial_daate_balance' => $this->initial_balance_date,
            'balance' => $this->balance
        ];
    }
}
