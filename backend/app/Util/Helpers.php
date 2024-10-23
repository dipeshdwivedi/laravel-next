<?php

namespace App\Util;

class Helpers {

    public function isAdmin() {
        return request()->user()->role == 'admin';
    }
}
