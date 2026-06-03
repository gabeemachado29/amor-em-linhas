<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'nullable|string|max:255',
            'imagem' => 'required|image|max:2048'
        ]);

        $banner = new Banner();
        $banner->titulo = $request->input('titulo');

        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('banners', 'public');
            $banner->imagem_url = '/storage/' . $path;
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner adicionado com sucesso!');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'titulo' => 'nullable|string|max:255',
            'imagem' => 'nullable|image|max:2048'
        ]);

        $banner->titulo = $request->input('titulo');

        if ($request->hasFile('imagem')) {
            // Remove old
            if ($banner->imagem_url) {
                $oldPath = str_replace('/storage/', '', $banner->imagem_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('imagem')->store('banners', 'public');
            $banner->imagem_url = '/storage/' . $path;
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner atualizado com sucesso!');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->imagem_url) {
            $oldPath = str_replace('/storage/', '', $banner->imagem_url);
            Storage::disk('public')->delete($oldPath);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner excluído com sucesso!');
    }
}
