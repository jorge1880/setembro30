<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Upload de imagem com validação
     */
    public static function uploadImage(UploadedFile $file, $path = 'imagens')
    {
        try {
            // Validar tipo de arquivo
            $allowedTypes = [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif',
                'image/webp',
                'image/bmp',
                'image/svg+xml',
                'image/avif',
            ];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                throw new \Exception('Tipo de arquivo não permitido. Use apenas JPG, PNG, GIF ou WEBP.');
            }

            // Validar tamanho (máximo 5MB)
            if ($file->getSize() > 5 * 1024 * 1024) {
                throw new \Exception('Arquivo muito grande. Máximo 5MB permitido.');
            }

            // Gerar nome único
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Salvar arquivo
            $file->storeAs("public/{$path}", $fileName);

            // Retornar caminho relativo
            return "{$path}/{$fileName}";
        } catch (\Exception $e) {
            \Log::error('Erro no upload de imagem: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Deletar imagem
     */
    public static function deleteImage($imagePath)
    {
        try {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar imagem: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Gerar URL da imagem
     */
    public static function getImageUrl($imagePath, $defaultImage = 'img/profileestude.webp')
    {
        try {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                $url = asset("storage/{$imagePath}");
                \Log::info("URL da imagem gerada: {$url}");
                return $url;
            }

            $defaultUrl = asset($defaultImage);
            \Log::info("Usando imagem padrão: {$defaultUrl}");
            return $defaultUrl;
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar URL da imagem: ' . $e->getMessage());
            return asset($defaultImage);
        }
    }

    /**
     * Verificar se imagem existe
     */
    public static function imageExists($imagePath)
    {
        return $imagePath && Storage::disk('public')->exists($imagePath);
    }

    /**
     * Obter dimensões da imagem
     */
    public static function getImageDimensions($imagePath)
    {
        try {
            $fullPath = storage_path("app/public/{$imagePath}");
            if (file_exists($fullPath)) {
                $imageInfo = getimagesize($fullPath);
                return [
                    'width' => $imageInfo[0],
                    'height' => $imageInfo[1],
                    'mime' => $imageInfo['mime']
                ];
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
