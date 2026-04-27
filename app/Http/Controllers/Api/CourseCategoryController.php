<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Courses_Categories;

use Illuminate\Http\Request;

class CourseCategoryController extends Controller

{
    public function index()
    {
        $categories = Courses_Categories::with('courses')->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|string',
        ]);

        $category = Courses_Categories::create($validated);

        return response()->json([
            'message' => 'تمت إضافة التصنيف بنجاح ✅',
            'category' => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Courses_Categories::with('courses')->find($id);

        if (!$category) {
            return response()->json(['message' => 'التصنيف غير موجود ❌'], 404);
        }

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Courses_Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'التصنيف غير موجود ❌'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'image' => 'nullable|string',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'تم تحديث التصنيف بنجاح ✅',
            'category' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Courses_Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'التصنيف غير موجود ❌'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'تم حذف التصنيف بنجاح 🗑️']);
    }
}
 