<?php

use Illuminate\Support\Facades\Request;

if (!function_exists('setActive')) {

    /**
     * setActive
     *
     * @param  string $routeName  Nama route
     * @param  string|null $type  Optional type untuk query string
     * @return string
     */
    function setActive($routeName, $type = null)
    {
        // Ambil route saat ini
        $currentRoute = request()->route()->getName();
        $currentType  = request()->get('type');

        // Jika tipe disediakan, cek route + query string type
        if ($type) {
            return ($currentRoute === $routeName && $currentType === $type) ? ' active' : '';
        }

        // Jika tidak ada type, cek path (supaya kompatibel menu kategori/submenu)
        return Request::is($routeName . '*') ? ' active' : '';
    }

}
