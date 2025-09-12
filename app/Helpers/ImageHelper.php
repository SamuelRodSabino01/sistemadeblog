<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    /**
     * Upload e redimensiona uma imagem
     *
     * @param UploadedFile $file
     * @param string $type (posts, categories, users)
     * @param int|null $maxWidth
     * @param int|null $maxHeight
     * @return string|null
     */
    public static function uploadAndResize(UploadedFile $file, string $type, ?int $maxWidth = null, ?int $maxHeight = null): ?string
    {
        try {
            // Obtém as configurações para o tipo de imagem
            $config = config("images.dimensions.{$type}");
            $maxWidth = $maxWidth ?? $config['max_width'] ?? 800;
            $maxHeight = $maxHeight ?? $config['max_height'] ?? 600;
            $quality = config('images.quality', 85);
            
            // Gera um nome único para o arquivo
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Define o caminho usando a configuração
            $folder = config("images.paths.{$type}", "images/{$type}");
            $path = "{$folder}/{$filename}";
            
            // Redimensiona a imagem mantendo a proporção
            $image = Image::make($file)
                ->resize($maxWidth, $maxHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode(null, $quality);
            
            // Salva a imagem no storage público
            Storage::disk('public')->put($path, (string) $image);
            
            // Cria thumbnail automaticamente se configurado
            if (config('images.auto_thumbnail', true)) {
                self::createThumbnail($path, $type);
            }
            
            return $path;
        } catch (\Exception $e) {
            \Log::error('Erro ao fazer upload da imagem: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Cria uma thumbnail da imagem
     *
     * @param string $imagePath
     * @param string $type
     * @param int|null $width
     * @param int|null $height
     * @return string|null
     */
    public static function createThumbnail(string $imagePath, string $type, ?int $width = null, ?int $height = null): ?string
    {
        try {
            // Obtém as configurações para o tipo de imagem
            $config = config("images.dimensions.{$type}");
            $width = $width ?? $config['thumbnail_width'] ?? 300;
            $height = $height ?? $config['thumbnail_height'] ?? 200;
            $quality = config('images.quality', 85);
            
            $fullPath = Storage::disk('public')->path($imagePath);
            
            if (!file_exists($fullPath)) {
                return null;
            }
            
            // Gera o nome do thumbnail
            $pathInfo = pathinfo($imagePath);
            $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
            
            // Cria o thumbnail
            $thumbnail = Image::make($fullPath)
                ->fit($width, $height)
                ->encode(null, $quality);
            
            // Salva o thumbnail
            Storage::disk('public')->put($thumbnailPath, (string) $thumbnail);
            
            return $thumbnailPath;
        } catch (\Exception $e) {
            \Log::error('Erro ao criar thumbnail: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Remove uma imagem e seu thumbnail
     *
     * @param string|null $imagePath
     * @return bool
     */
    public static function deleteImage(?string $imagePath): bool
    {
        if (!$imagePath) {
            return true;
        }
        
        try {
            // Remove a imagem principal
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            // Remove o thumbnail se existir
            $pathInfo = pathinfo($imagePath);
            $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
            
            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar imagem: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Valida se o arquivo é uma imagem válida
     *
     * @param UploadedFile $file
     * @return bool
     */
    public static function isValidImage(UploadedFile $file): bool
    {
        $allowedMimes = config('images.allowed_mimes', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
        $allowedExtensions = config('images.allowed_extensions', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        $maxSize = config('images.max_file_size', 5 * 1024 * 1024);
        
        return in_array($file->getMimeType(), $allowedMimes) && 
               in_array(strtolower($file->getClientOriginalExtension()), $allowedExtensions) &&
               $file->getSize() <= $maxSize;
    }
    
    /**
     * Obtém a URL pública da imagem
     *
     * @param string|null $imagePath
     * @return string|null
     */
    public static function getImageUrl(?string $imagePath): ?string
    {
        if (!$imagePath) {
            return null;
        }
        
        return Storage::disk('public')->url($imagePath);
    }
    
    /**
     * Obtém a URL do thumbnail
     *
     * @param string|null $imagePath
     * @return string|null
     */
    public static function getThumbnailUrl(?string $imagePath): ?string
    {
        if (!$imagePath) {
            return null;
        }
        
        $pathInfo = pathinfo($imagePath);
        $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
        
        if (Storage::disk('public')->exists($thumbnailPath)) {
            return Storage::disk('public')->url($thumbnailPath);
        }
        
        return self::getImageUrl($imagePath);
    }
}