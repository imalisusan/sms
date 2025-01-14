<?php

namespace App\Http\Controllers;

use App\Http\Resources\ParentResource;
use App\Models\User;

class ParentController extends Controller
{
    public function getAllParentsGroupedByClass()
    {
        $parents = User::whereHas('roles', function ($query) {
            $query->where('name', 'parent');
        })->with('students.class')->get();

        $groupedParents = $parents->groupBy(function ($parent) {
            return $parent->students->pluck('class.name')->unique();
        });

        return response()->json($groupedParents->map(function ($group, $key) {
            return [
                'class_name' => $key,
                'parents' => ParentResource::collection($group),
            ];
        }));
    }
}
