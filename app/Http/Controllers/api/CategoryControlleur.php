<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryControlleur extends Controller
{
    public function __construct() {
        $this->middleware('is.admin')->except('index');
    }

    public function index()
    {
        $categories = Category::all();

        return response($categories, 200);
    }

    public function store(Request $req)
    {
        $data = $req->all();

        $rules = [
            'label' => 'required|max:255|unique:categories',
            'description' => 'required|max:255',
        ];

        $data = Validator::make($data, $rules);

        if ($data->fails()) {
            return response($data->messages()->first(), 422);
        } else {
            $category = new Category();

            $category->label = $req->label;
            $category->description = $req->description;

            $category->save();

            return response($category, 201);
        }
    }

    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response('Category not found', 404);
        }

        return response($category, 200);
    }

    public function update(Request $req, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response('Category not found', 404);
        }

        $data = $req->all();

        $rules = [
            'label' => 'required|max:255|unique:categories',
            'description' => 'required|max:255',
        ];

        $data = Validator::make($data, $rules);

        if ($data->fails()) {
            return response($data->messages()->first(), 422);
        } else {
            $category->label = $req->label ?? $category->label;
            $category->description = $req->description ?? $category->description;

            $category->save();

            return response($category, 200);
        }
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response('Category not found', 404);
        }

        $category->delete();
        return response('Category deleted successfully', 200);
    }
}
