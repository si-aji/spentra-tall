<?php

/**
 * Generate Random String
 */
function generateRandomString($length = 6)
{
    $numeric = range(0, 9);
    $alpha = range('a', 'z');
    $alpha_b = range('A', 'Z');

    // Join Array
    $mix = implode('', $numeric).implode('', $alpha).implode('', $alpha_b);
    // Shuffle Joined Array
    $mixShuffle = str_shuffle($mix);

    // Generate Random Character
    $string = [];
    for ($i = 0; $i < $length; $i++) {
        str_shuffle($mixShuffle);
        array_push($string, $mixShuffle[rand(0, $length - 1)]);
    }

    return str_shuffle(implode('', $string));
}

/**
 * Siacryption
 */
function siacryption($value, $encrypt = false)
{
    $method = new \Illuminate\Encryption\Encrypter(env('APP_PRIVATE_KEY'), config('app.cipher'));
    $data = null;
    if ($encrypt) {
        $data = $method->encrypt($value);
    } elseif (! ($encrypt)) {
        try {
            $data = $method->decrypt($value);
        } catch (\RuntimeException $e) {
            $data = $value;

            \Log::debug("[Custom Helper] Check Decryption, fail to decrypt ~ app\Helper\function@haercryption", [
                'value' => $value,
                'exception' => $e,
            ]);
        }
    }

    return $data;
}

/**
 * Format Rupiah
 *
 * Print number in Indonesian Rupiah
 */
function formatRupiah($number = 0, $prefix = true)
{
    $number = round($number, 2);
    $decimal = null;
    $checkDecimal = explode('.', $number);
    if (count($checkDecimal) > 1) {
        $decimal = $checkDecimal[1];
    }

    return ($prefix ? 'Rp ' : '').number_format((int) $number, 0, ',', '.').(! empty($decimal) ? ','.$decimal : '');
}

/**
 * Date Format
 */
function dateFormat($rawDate, $type = 'days')
{
    $date = date('Y-m-d H:i:s', strtotime($rawDate));
    $result = '';

    switch ($type) {
        case 'days':
            $result = date('l', strtotime($date));
            switch ($result) {
                case 'Monday':
                    $result = 'Senin';
                    break;
                case 'Tuesday':
                    $result = 'Selasa';
                    break;
                case 'Wednesday':
                    $result = 'Rabu';
                    break;
                case 'Thursday':
                    $result = 'Kamis';
                    break;
                case 'Friday':
                    $result = "Jum'at";
                    break;
                case 'Saturday':
                    $result = 'Sabtu';
                    break;
                case 'Sunday':
                    $result = 'Minggu';
                    break;
            }
            break;
        case 'months':
            $result = date('F', strtotime($date));
            switch ($result) {
                case 'January':
                    $result = 'Januari';
                    break;
                case 'February':
                    $result = 'Februari';
                    break;
                case 'March':
                    $result = 'Maret';
                    break;
                case 'April':
                    $result = 'April';
                    break;
                case 'May':
                    $result = 'Mei';
                    break;
                case 'June':
                    $result = 'Juni';
                    break;
                case 'July':
                    $result = 'Juli';
                    break;
                case 'August':
                    $result = 'Agustus';
                    break;
                case 'September':
                    $result = 'September';
                    break;
                case 'October':
                    $result = 'Oktober';
                    break;
                case 'November':
                    $result = 'November';
                    break;
                case 'December':
                    $result = 'Desember';
                    break;
            }
            break;
    }

    return $result;
}

/**
 * Convert related date to utc based on offset
 */
function convertToUtc($datetime, $offset, $utc = true)
{
    $original = $datetime;
    $originalOffset = $offset;

    // Convert to UTC
    if ($utc) {
        $offset *= -1;
    }
    $offsetInSeconds = ($offset * -1) * 60;
    $utc = date('Y-m-d H:i:s', strtotime($datetime) + $offsetInSeconds);

    return $utc;
}

/**
 * Validate String to match certain date format
 *
 * Source: https://www.codexworld.com/how-to/validate-date-input-string-in-php/
 */
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);

    return $d && $d->format($format) === $date;
}
