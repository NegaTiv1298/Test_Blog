<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    /**
     * Show info for page 'show'
     *
     * @return Application|Factory|View
     */
    public function adminShow()
    {
        $info = Blog::orderBy('created_at', 'desc')->paginate(10);

        return view('admin/show', [
            'info' => $info
        ]);
    }

    /**
     * Show records by ID
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function cardForAdmin($id)
    {
        $info = Blog::where('id', $id)->get();

        return view('blog/card', [
            'info' => $info
        ]);
    }

    /**
     * Editing a record by an administrator
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function editForAdmin(Request $request, $id)
    {
        $text = $request->input('description');
        Blog::where('id', $id)->update(['text' => $text, 'admin_edit' => 1]);

        return redirect()->back()->withSuccess('Запис успішно обновлений');
    }

    /**
     * Approved record
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function approvedComment(Request $request, $id)
    {
        Blog::where('id', $id)->update(['approved' => 1]);

        return redirect()->back();

    }
}
