<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Intervention\Image\Facades\Image;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Blog controller
 */
class BlogController extends Controller
{

    /**
     * Show records for page 'show'
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $info = Blog::where('approved', 1)->orderBy('created_at', 'desc')->paginate(2);

        return view('blog/show', [
            'info' => $info
        ]);
    }

    /**
     * Sorting records by parameters
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function sort(Request $request)
    {
        $sort = $request->input('sort');
        $info = Blog::orderBy('created_at', 'desc')->paginate(10);

        if (isset($sort)) {
            if ($sort == 'created_at') {
                $info = Blog::orderBy($sort, 'desc')->paginate(10);
            } elseif ($sort != 'created_at') {
                $info = Blog::orderBy($sort, 'asc')->paginate(10);
            }
        }

        return view('blog/show', [
            'info' => $info
        ]);
    }

    /**
     * Saving records to the database
     * Saving and resize pictures
     *
     * @param BlogRequest $request
     * @return mixed
     */
    public function save(BlogRequest $request)
    {

        $name = $request->input('name');
        $email = $request->input('email');
        $text = $request->input('description');

        $image = $request->file('image');
        $filename = time() . '.' . $image->extension();

        $destinationPath = public_path('/image');
        $img = Image::make($image->path());
        $img->resize(320, 240, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $filename);


        $blog = new Blog([
            'name' => $name,
            'email' => $email,
            'image' => $filename,
            'text' => $text,
        ]);
        $blog->save();

        return redirect()->back()->withSuccess('Запис успішно створений');
    }
}
