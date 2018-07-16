<?php

namespace App\Http\Resources;

use App\Http\Resources\Group as GroupResource;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
          'id' => $this->id,
          'name' => $this->name,
          'email' => $this->email,
          'groups' => $this->groups
      ];
    }
}
