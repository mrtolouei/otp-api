<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function __invoke(Request $request)
    {
        $path = $request->query('path');
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path);
        }
        abort(404);
    }
}
