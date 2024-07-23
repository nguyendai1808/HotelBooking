<?php
class Validate
{
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1?api_key=" . EMAIL_API_KEY . "&email=$email",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            return false;
        }

        $data = json_decode($response, true);

        if ($data === null || $data['deliverability'] === "UNDELIVERABLE" || $data["is_disposable_email"]["value"] === true) {
            return false;
        }

        return true;
    }

    public static function checkPhone($phone)
    {
        if (strpos($phone, '0') === 0) {
            $phone = '+84' . substr($phone, 1);
        }

        if (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
            return false;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://phonevalidation.abstractapi.com/v1/?api_key=" . PHONE_API_KEY . "&phone=$phone",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            return false;
        }

        $data = json_decode($response, true);

        if ($data === null || $data['valid'] === false) {
            return false;
        }

        return true;
    }
}
