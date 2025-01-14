<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'students' => $this->students->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'class_name' => $student->class->name,
                ];
            }),
        ];
    }
}
