<?php
class Session
{
    public static function start()
    {
        session_set_cookie_params(604800, '/', '', true, true);
        session_start();
    }

    public static function set($key, $value, $expiration = null)
    {
        $_SESSION[$key] = [
            'value' => $value,
            'expiration' => $expiration ? time() + $expiration : null
        ];
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            if ($_SESSION[$key]['expiration'] === null || $_SESSION[$key]['expiration'] > time()) {
                return $_SESSION[$key]['value'];
            } else {
                unset($_SESSION[$key]);
                return null;
            }
        }
        return null;
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
