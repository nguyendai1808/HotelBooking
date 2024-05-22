<?php
class Session
{
    public static function start()
    {
        session_set_cookie_params(604800, '/', '', true, true);
        session_start();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
    }
}

// Khởi tạo session khi bắt đầu ứng dụng
Session::start();
