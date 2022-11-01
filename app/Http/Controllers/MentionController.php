<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MentionController extends Controller
{
    public function __invoke(Request $request): Collection
    {
        $except = (int)\request('except') ?? null;
        return DB::table('users')->select(['id', 'name'])->where('name', 'LIKE', '%' . \request('name') . '%')->whereNot('id', '=', $except)->get();
    }
}
