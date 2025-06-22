<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function imageGallery()
    {
        $images = [];

        // Buscar imagens da pasta public/img
        $publicImgPath = public_path('img');
        if (is_dir($publicImgPath)) {
            $files = glob($publicImgPath . '/*.{jpg,jpeg,png,gif,webp,bmp,svg}', GLOB_BRACE);
            foreach ($files as $file) {
                $filename = basename($file);
                $images[] = [
                    'name' => $filename,
                    'path' => 'img/' . $filename,
                    'url' => asset('img/' . $filename)
                ];
            }
        }

        // Buscar imagens da pasta storage/app/public/imagens
        $storageImgPath = storage_path('app/public/imagens');
        if (is_dir($storageImgPath)) {
            $files = glob($storageImgPath . '/*.{jpg,jpeg,png,gif,webp,bmp,svg}', GLOB_BRACE);
            foreach ($files as $file) {
                $filename = basename($file);
                $images[] = [
                    'name' => $filename,
                    'path' => 'storage/imagens/' . $filename,
                    'url' => asset('storage/imagens/' . $filename)
                ];
            }
        }

        return response()->json(['images' => $images]);
    }
}
