<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class BlogController extends Controller
{

    public function index()
    {
        $data = Cache::remember('blogs-page-' . request('page', 1), 60 * 60 * 24, function () {
            return Blog::latest()->paginate(20);
        });

        return view('blogs.index')->with('blogs', $data);
    }

    public function create(Blog $blog)
    {
        Gate::authorize('create', $blog);

        return view('blogs.create');
    }


    public function store(StoreBlogRequest $request, Blog $blog)
    {
        Gate::authorize('create', $blog);

        $today = Carbon::now()->format('Y-m-d');

        $borders = Auth::user()->blogs()->latest()->take(3)->get();
        $border = 0;
        foreach ($borders as $sato) {
            $blog_time = $sato->created_at->format('Y-m-d');
            if ($blog_time == $today) {
                $border += 1;
            }
        }
        if ($border < 3) {
            Blog::create($request->validated());

            Cache::delete('blogs-page-' . request('page', 1));
            Cache::delete('user_blogs-page-' . request('page', 1));

            return redirect()->route('dashboard')
                ->with('success', 'Blog created successfully.');
        } else {
            return redirect()->back()->with('border', $border);
        }
    }


    public function show($blog)
    {
        $blog = Blog::where('slug', $blog)->first();

        if ($blog) {
            return view('blogs.show')->with('blog', $blog);
        } else {
            abort(404, 'Error');
        }
    }


    public function edit($blog)
    {
        $blog = Blog::where('slug', $blog)->first();

        Gate::authorize('create', $blog);


        return view('blogs.edit')->with('blog', $blog);
    }


    public function update(UpdateBlogRequest $request, $blog)
    {
        $blog = Blog::where('slug', $blog)->first();

        Gate::authorize('create', $blog);

        Cache::delete('blogs-page-' . request('page', 1));
        Cache::delete('user_blogs-page-' . request('page', 1));

        $blog->update($request->validated());


        return redirect()->route('dashboard')
            ->with([
                'success' => 'Blog updated successfully',
            ]);
    }


    public function destroy($blog)
    {
        $blog = Blog::where('slug', $blog)->first();

        Gate::authorize('delete', $blog);


        Cache::put('blogs-page-' . request('page', 1), $blog->id, 0);
        Cache::put('user_blogs-page-' . request('page', 1), $blog->id, 0);

        $blog->delete();

        return redirect()->back()
            ->with('success', 'Blog deleted successfully');
    }

    public function user_blog()
    {
        $data = Cache::remember('user_blogs-page-' . request('page', 1), 60 * 60 * 24, function () {
            return Auth::user()->blogs()->latest()->paginate(3);
        });

        return view('dashboard')->with('blogs', $data);
    }
}
