<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\CategoryService;
use App\Interfaces\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FileController extends Controller
{
    public function __construct(
        private Request $request,
        private CategoryService $categoryService,
        private FileService $fileService
    ) {}

    public function all(): View
    {
        $files = $this->fileService->getAllByUser(Auth::user());

        return view('files.index', [
            'files' => $files,
        ]);
    }

    public function upload(int $categoryId): JsonResponse
    {
        $file = $this->request->file('file-upload');

        return response()->json($this->fileService->save($file, $categoryId));
    }

    public function getById(int $id)
    {
        $this->request->validate(['version' => 'required|integer']);

        $file = $this->fileService->findById($id);
        $name = $this->fileService->getNameWithVersion((int) $this->request->version, $file);

        return Storage::download($name, $file->visible_name);
    }

    public function getByCategory(int $categoryId): JsonResponse
    {        
        $files = $this->fileService->getByCategoryId($categoryId);

        $view = view('files.list', ['files' => $files])->render();

        return response()->json($view);
    }
}
