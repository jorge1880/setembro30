<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImageTrait
{
    /**
     * Upload e redimensiona uma imagem
     */
    public function uploadImage(UploadedFile $file, $path = 'imagens', $sizes = [])
    {
        try {
            // Gerar nome único para o arquivo
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Caminho completo onde salvar
            $fullPath = "public/{$path}/{$fileName}";
            
            // Salvar imagem original
            $file->storeAs("public/{$path}", $fileName);
            
            // Redimensionar se necessário
            if (!empty($sizes)) {
                $this->resizeImage($fullPath, $sizes);
            }
            
            // Retornar caminho relativo (sem 'public/')
            return "{$path}/{$fileName}";
            
        } catch (\Exception $e) {
            \Log::error('Erro ao fazer upload da imagem: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Redimensiona uma imagem para diferentes tamanhos
     */
    public function resizeImage($imagePath, $sizes = [])
    {
        try {
            $fullPath = storage_path("app/{$imagePath}");
            
            if (!file_exists($fullPath)) {
                throw new \Exception("Arquivo não encontrado: {$fullPath}");
            }
            
            $image = Image::make($fullPath);
            
            foreach ($sizes as $size => $dimensions) {
                $width = $dimensions['width'] ?? 300;
                $height = $dimensions['height'] ?? 300;
                $quality = $dimensions['quality'] ?? 80;
                
                // Criar versão redimensionada
                $resized = $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                // Salvar versão redimensionada
                $resized->save($fullPath, $quality);
            }
            
        } catch (\Exception $e) {
            \Log::error('Erro ao redimensionar imagem: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Remove uma imagem do storage
     */
    public function deleteImage($imagePath)
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
     * Gera URL para uma imagem
     */
    public function getImageUrl($imagePath, $defaultImage = null)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            return asset("storage/{$imagePath}");
        }
        
        return $defaultImage ? asset($defaultImage) : asset('img/default-avatar.png');
    }
    
    /**
     * Verifica se uma imagem existe
     */
    public function imageExists($imagePath)
    {
        return $imagePath && Storage::disk('public')->exists($imagePath);
    }
} 