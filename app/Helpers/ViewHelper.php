<?php

namespace App\Helpers;

class ViewHelper
{
    /**
     * Exibe imagem do usuário com fallback
     */
    public static function userImage($user, $size = '50px', $class = '')
    {
        $imageUrl = ImageHelper::getImageUrl($user->imagem ?? null);
        $alt = $user->nome ?? 'Usuário';
        
        return "<img src=\"{$imageUrl}\" alt=\"{$alt}\" style=\"width: {$size}; height: {$size}; object-fit: cover; border-radius: 50%;\" class=\"{$class}\">";
    }
    
    /**
     * Exibe imagem do usuário como HTML
     */
    public static function userImageHtml($user, $size = '50px', $class = '')
    {
        if ($user->imagem && ImageHelper::imageExists($user->imagem)) {
            return "<img src=\"" . asset("storage/{$user->imagem}") . "\" alt=\"{$user->nome}\" style=\"width: {$size}; height: {$size}; object-fit: cover; border-radius: 50%;\" class=\"{$class}\">";
        } else {
            return "<i class=\"material-icons\" style=\"font-size: {$size}; color: #ccc;\" class=\"{$class}\">account_circle</i>";
        }
    }
    
    /**
     * Exibe imagem do usuário como Blade
     */
    public static function userImageBlade($user, $size = '50px', $class = '')
    {
        if ($user->imagem && ImageHelper::imageExists($user->imagem)) {
            return "<img src=\"" . asset("storage/{$user->imagem}") . "\" alt=\"{$user->nome}\" style=\"width: {$size}; height: {$size}; object-fit: cover; border-radius: 50%;\" class=\"{$class}\">";
        } else {
            return "<i class=\"material-icons\" style=\"font-size: {$size}; color: #ccc;\" class=\"{$class}\">account_circle</i>";
        }
    }
    
    /**
     * Exibe imagem grande para perfil
     */
    public static function profileImage($user, $size = '200px', $class = '')
    {
        if ($user->imagem && ImageHelper::imageExists($user->imagem)) {
            return "<img src=\"" . asset("storage/{$user->imagem}") . "\" alt=\"{$user->nome}\" style=\"width: {$size}; height: {$size}; object-fit: cover; border-radius: 50%;\" class=\"{$class}\">";
        } else {
            return "<i class=\"material-icons\" style=\"font-size: {$size}; color: #ccc;\" class=\"{$class}\">account_circle</i>";
        }
    }
    
    /**
     * Exibe imagem média para cards
     */
    public static function cardImage($user, $size = '100px', $class = '')
    {
        if ($user->imagem && ImageHelper::imageExists($user->imagem)) {
            return "<img src=\"" . asset("storage/{$user->imagem}") . "\" alt=\"{$user->nome}\" style=\"width: {$size}; height: {$size}; object-fit: cover; border-radius: 50%;\" class=\"{$class}\">";
        } else {
            return "<i class=\"material-icons\" style=\"font-size: {$size}; color: #ccc;\" class=\"{$class}\">account_circle</i>";
        }
    }
    
    /**
     * Exibir imagem do usuário com fallback
     */
    public static function displayUserImage($user, $size = '250px', $class = '')
    {
        $imageUrl = ImageHelper::getImageUrl($user->imagem ?? null, 'img/profileestude.webp');
        
        $style = "width:{$size}; height:{$size}; border-radius:100%; object-fit:cover; border: 3px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);";
        
        return "<img src=\"{$imageUrl}\" alt=\"Foto do usuário\" style=\"{$style}\" class=\"{$class}\">";
    }
    
    /**
     * Exibir imagem pequena para listas
     */
    public static function displayUserThumbnail($user, $size = '40px', $class = '')
    {
        $imageUrl = ImageHelper::getImageUrl($user->imagem ?? null, 'img/profileestude.webp');
        
        $style = "width:{$size}; height:{$size}; border-radius:50%; object-fit:cover; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);";
        
        return "<img src=\"{$imageUrl}\" alt=\"Foto do usuário\" style=\"{$style}\" class=\"{$class}\">";
    }
    
    /**
     * Exibir imagem circular para cards
     */
    public static function displayUserCardImage($user, $size = '60px', $class = '')
    {
        $imageUrl = ImageHelper::getImageUrl($user->imagem ?? null, 'img/profileestude.webp');
        
        $style = "width:{$size}; height:{$size}; border-radius:50%; object-fit:cover; border: 2px solid #26a69a; box-shadow: 0 3px 6px rgba(0,0,0,0.15);";
        
        return "<img src=\"{$imageUrl}\" alt=\"Foto do usuário\" style=\"{$style}\" class=\"{$class}\">";
    }
    
    /**
     * Obter URL da imagem do usuário
     */
    public static function getUserImageUrl($user, $defaultImage = 'img/profileestude.webp')
    {
        return ImageHelper::getImageUrl($user->imagem ?? null, $defaultImage);
    }
    
    /**
     * Verificar se usuário tem imagem
     */
    public static function userHasImage($user)
    {
        return $user->imagem && ImageHelper::imageExists($user->imagem);
    }
} 