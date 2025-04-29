<?php

if (!function_exists('check_auth')) {
    function check_auth()
    {
        if (!auth()->user()->id) {
            return redirect()->route('auth.login');
        }
    }
}
