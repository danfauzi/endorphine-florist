<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(): View
    {
        $slides = HeroSlide::orderBy('slot')->get();

        return view('owner.hero_slides.index', compact('slides'));
    }

    public function update(Request $request, HeroSlide $heroSlide): RedirectResponse
    {
        $validated = $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:150'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($heroSlide->image && !str_starts_with($heroSlide->image, 'products/')) {
                Storage::disk('public')->delete($heroSlide->image);
            }

            $validated['image'] = $request->file('image')->store('hero-slides', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $heroSlide->update($validated);

        return back()->with('success', "Slide {$heroSlide->slot} berhasil diperbarui.");
    }
}
