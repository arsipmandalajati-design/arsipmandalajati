<?php

if (!function_exists('menuActive')) {
    /**
     * Mengecek apakah rute saat ini aktif untuk memberikan class CSS 'active'
     * 
     * @param string|array $routeName
     * @param string $output
     * @return string
     */
    function menuActive($routeName, $output = 'active')
    {
        if (request()->routeIs($routeName)) {
            return $output;
        }
        return '';
    }
}

if (!function_exists('activeMenu')) {
    /**
     * Alternatif pengecekan URL aktif berdasarkan segment atau path
     * 
     * @param string $path
     * @return string
     */
    function activeMenu($path)
    {
        return request()->is($path . '*') ? 'active' : '';
    }
}