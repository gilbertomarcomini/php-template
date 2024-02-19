<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $categories = $this->categoryService->findPaginate(10);

        return view('category.index', compact('categories'));
    }

    /**
     * @return View
     */
    public function add(): View
    {
        return view('category.add');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|min:10|max:255',
            'image' => 'required|file'
        ]);

        $this->categoryService->create($request->all());

        return redirect()->route('category.index');
    }

    /**
     * @param $id
     * @return View|RedirectResponse
     */
    public function edit($id): View|RedirectResponse
    {
        $category = $this->categoryService->find($id);

        if (!empty($category)) {
            return view('category.edit', compact('category'));
        }
        return redirect()->route('category.index');
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'sometimes|min:1|max:255',
            'image' => 'sometimes|file',
            'deleted_image' => 'sometimes|string',
        ]);

        $this->categoryService->update($id, $request->all());

        return redirect()->route('category.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        $this->categoryService->delete($id);

        return redirect()->route('category.index');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function search(Request $request): View
    {
        $request->validate([
            'name' => 'sometimes|min:1|max:255',
        ]);
        $search = $request->get('name');
        $categories = $this->categoryService->search($search);

        return view('category.index', compact('categories', 'search'));
    }

    /**
     * @return JsonResponse
     */
    public function api(): JsonResponse
    {
        $categories = $this->categoryService->findAll();
        return response()->json($categories);
    }
}
