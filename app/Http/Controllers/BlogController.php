<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();
        return view('blogs.index', compact('blogs'));
    }

    public function create()
    {
        $availableServices = Service::whereDoesntHave('blog')->get();
        $categories=Category::all();
        return view('blogs.create',compact('categories','availableServices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:published,draft',
            'category_id' => 'required|exists:categories,id',
            'service_id'=>'required|exists:services,id',
        ]);

        $data = $request->only(['title', 'content', 'status', 'category_id','service_id']);


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }

        Blog::create($data);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully!');
    }
    public function show($id)
    {
        $blog = Blog::with('comments.user')->findOrFail($id);
        //dd($blog);

        return view('blogs.show', compact('blog'));
    }
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = Category::all();
        $availableServices = Service::all();
        return view('blogs.edit', compact('blog', 'categories','availableServices'));
    }

    public function update(Request $request, $id)
    {

        $blog = Blog::findOrFail($id);


        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:published,draft',
           'category_id' => 'required|exists:categories,id',
           'service_id' => 'required|exists:services,id',
        ]);


        $data = $request->only(['title', 'content', 'status', 'category_id', 'service_id']);


        if ($request->hasFile('image')) {

            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }


            $data['image'] = $request->file('image')->store('images', 'public');
        }


        $blog->update($data);


        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }



    public function destroy($id)
    {

        $blog = Blog::findOrFail($id);


        $blog->delete();


        return redirect()->route('blogs.index')->with('success', 'تم حذف المدونة بنجاح.');
    }
    public function like($id)
    {
        $user = auth()->user();
        $blog = Blog::findOrFail($id);

        if ($user->likedBlogs()->where('blog_id', $id)->exists()) {

            $user->likedBlogs()->detach($id);
            return redirect()->back()->with('success', 'Like removed.');
        } else {

            $user->likedBlogs()->attach($id);
            return redirect()->back()->with('success', 'Blog liked.');
        }
    }

}
