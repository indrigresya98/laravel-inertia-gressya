<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Menampilkan daftar postingan dengan dukungan pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $posts = Post::when($search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        })
        ->latest()
        ->get();

        return Inertia::render('Post/Index', [
            'posts'   => $posts,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    /**
     * Menampilkan form tambah post.
     */
    public function create()
    {
        return Inertia::render('Post/Create');
    }

    /**
     * Menyimpan post baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Post::create([
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return Redirect::route('posts.index')->with('message', 'Data Berhasil Disimpan!');
    }

    /**
     * Menampilkan form edit post.
     */
    public function edit(Post $post)
    {
        return Inertia::render('Post/Edit', [
            'post' => $post,
        ]);
    }

    /**
     * Memperbarui data post yang ada.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return Redirect::route('posts.index')->with('message', 'Data Berhasil Diperbarui!');
    }

    /**
     * Menghapus data post.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return Redirect::route('posts.index')->with('message', 'Data Berhasil Dihapus!');
    }

    /**
     * Method tambahan khusus pencarian.
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }
}