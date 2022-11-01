<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlaylistController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Playlists/Index', [
            'playlists' => Playlist::all()
        ]);
    }

    public function create(Playlist $playlist): Response
    {
        return Inertia::render('Playlists/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            //'description' => '',
        ]);

        $playlist = new Playlist();
        $playlist->title = request('title');
        $playlist->description = request('description');
        $playlist->owner_id = $request->user()->id;
        $playlist->save();

        return redirect()->route('playlists.show', $playlist);
    }

    public function show(Playlist $playlist): Response
    {
        $playlist->load(['owner', 'submissions']);

        $__meta_description = '';
        $__meta_title = '';
        if (\request('invite')) {
            $__meta_description .= 'You\'ve been invited to edit ' . $playlist->title . ' by ' . $playlist->owner->name;
        } else {
            $__meta_description = $playlist->description;
        }
        $__meta_title = $playlist->title . ' by ' . $playlist->owner->name;

        return Inertia::render('Playlists/Show', [
            'playlist' => $playlist,
            '__meta_description' => $__meta_description,
            '__meta_title' => $__meta_title,
        ]);
    }

    public function edit(Playlist $playlist)
    {
        //
    }

    public function update(Request $request, Playlist $playlist)
    {
        //
    }

    public function destroy(Playlist $playlist)
    {
        //
    }
}
