<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// ex: {{ changeDateFormat(date('Y-m-d'),'m/d/Y')  }}
function changeDateFormat($date, $date_format)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);
}

function thumbImagePath($thumb)
{
    if (!empty($thumb)) {
        if (isUrl($thumb)) {
            return $thumb;
        } else {
            if (file_exists('storage/' . $thumb)) {
                return asset('storage/' . $thumb);
            } else {
                return asset('images/no-image-upload.png');
            }
        }
    } else {
        return asset('images/image-not-available.png');
    }
}

function getPathImage($thumb)
{
    if (!empty($thumb)) {
        if (isUrl($thumb)) {
            return $thumb;
        } else {
            if (file_exists('storage/' . $thumb)) {
                return asset('storage/' . $thumb);
            } else {
                return $thumb;
            }
        }
    } else {
        return $thumb;
    }
}

function isUrl($text)
{
    if (filter_var($text, FILTER_VALIDATE_URL)) {
        return true;
    } else {
        return false;
    }
}

function htmlStatus($status)
{
    return $status === 0 ? '<span class="badge badge-danger">Không kích hoạt</span>'
        : '<span class="badge badge-success">Kích hoạt</span>';
}

function htmlTypeVideo($type)
{
    if ($type == 1) {
        return '<span class="badge bg-success">Grammar</span>';
    } else if ($type == 2) {
        return '<span class="badge bg-info">Lesson</span>';
    } elseif ($type == 3) {
        return '<span class="badge bg-primary">Video</span>';
    } else {
        return '<span class="badge bg-secondary">Không có</span>';
    }
}

function formatTimeSub($time, $format)
{
    return \Carbon\Carbon::parse((int)$time)->format($format);
}

function formatTimeSubtitle($times)
{
    $seconds = 0;
    $seconds += $times['hours'] * 3600;
    $seconds += $times['minutes'] * 60;
    $seconds += $times['seconds'];
    $milliseconds = $times['milliseconds'] / 1000;

    return $seconds + $milliseconds;
}

function parseTimeSubtitle($time)
{
    /*list($hours, $minutes, $seconds) = explode(":", $time);
    $times = [];
    $times['hours'] = (int)$hours;
    $times['minutes'] = (int)$minutes;
    $times['seconds'] = (int)$seconds;
    $times['milliseconds'] = 0;*/

    //$time = explode(',', $time, 2);
    $time = explode('.', $time, 2);
    $milliseconds = $time[1];
    $splitTime = explode(':', $time[0], 3);

    $times = [];
    $times['hours'] = (int)$splitTime[0];
    $times['minutes'] = (int)$splitTime[1];
    $times['seconds'] = (int)$splitTime[2];
    $times['milliseconds'] = (int)$milliseconds;
    return $times;
}

function stringHoursToFloat($times)
{
    if (empty($times)) {
        return 0;
    } else {
        return formatTimeSubtitle(parseTimeSubtitle($times));
    }
}

function seconds2SRT($seconds)
{
    $hours = 0;
    $whole = floor($seconds);
    $fraction = $seconds - $whole;
    $milliseconds = number_format($fraction, 3, '.', ',');
    $milliseconds_array = explode('.', strval($milliseconds));
    $milliseconds = $milliseconds_array[1];

    if ($seconds > 3600) {
        $hours = floor($seconds / 3600);
    }
    $seconds = $seconds % 3600;

    return str_pad($hours, 2, '0', STR_PAD_LEFT)
        . gmdate(':i:s', $seconds)
        . ($milliseconds ? ",$milliseconds" : '');
}

function videoHasQuestionSub($videoId)
{
    if (!empty($videoId) && $videoId > 0) {
        $data = DB::table('questions')->where('video_id', $videoId)->count();
        return $data > 0 ? true : false;
    } else {
        return false;
    }
}

function httpResponseCode($code = NULL)
{
    if ($code !== NULL) {
        switch ($code) {
            case 100:
                $text = 'Continue';
                break;
            case 101:
                $text = 'Switching Protocols';
                break;
            case 200:
                $text = 'OK';
                break;
            case 201:
                $text = 'Created';
                break;
            case 202:
                $text = 'Accepted';
                break;
            case 203:
                $text = 'Non-Authoritative Information';
                break;
            case 204:
                $text = 'No Content';
                break;
            case 205:
                $text = 'Reset Content';
                break;
            case 206:
                $text = 'Partial Content';
                break;
            case 300:
                $text = 'Multiple Choices';
                break;
            case 301:
                $text = 'Moved Permanently';
                break;
            case 302:
                $text = 'Moved Temporarily';
                break;
            case 303:
                $text = 'See Other';
                break;
            case 304:
                $text = 'Not Modified';
                break;
            case 305:
                $text = 'Use Proxy';
                break;
            case 400:
                $text = 'Bad Request';
                break;
            case 401:
                $text = 'Unauthorized';
                break;
            case 402:
                $text = 'Payment Required';
                break;
            case 403:
                $text = 'Forbidden';
                break;
            case 404:
                $text = 'Not Found';
                break;
            case 405:
                $text = 'Method Not Allowed';
                break;
            case 406:
                $text = 'Not Acceptable';
                break;
            case 407:
                $text = 'Proxy Authentication Required';
                break;
            case 408:
                $text = 'Request Time-out';
                break;
            case 409:
                $text = 'Conflict';
                break;
            case 410:
                $text = 'Gone';
                break;
            case 411:
                $text = 'Length Required';
                break;
            case 412:
                $text = 'Precondition Failed';
                break;
            case 413:
                $text = 'Request Entity Too Large';
                break;
            case 414:
                $text = 'Request-URI Too Large';
                break;
            case 415:
                $text = 'Unsupported Media Type';
                break;
            case 500:
                $text = 'Internal Server Error';
                break;
            case 501:
                $text = 'Not Implemented';
                break;
            case 502:
                $text = 'Bad Gateway';
                break;
            case 503:
                $text = 'Service Unavailable';
                break;
            case 504:
                $text = 'Gateway Time-out';
                break;
            case 505:
                $text = 'HTTP Version not supported';
                break;
            default:
                exit('Unknown http status code "' . htmlentities($code) . '"');
                break;
        }
        $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        header($protocol . ' ' . $code . ' ' . $text);
        $GLOBALS['http_response_code'] = $code;
    } else {
        $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
    }
    return $code;
}


function getCorrectTextExercises($exercises)
{
    if (!empty($exercises)) {
        $answerCorrect = $exercises->answer_correct;
        if ($answerCorrect == '1') {
            return $exercises->answer_1;
        } elseif ($answerCorrect == '2') {
            return $exercises->answer_2;
        } elseif ($answerCorrect == '3') {
            return $exercises->answer_3;
        } elseif ($answerCorrect == '4') {
            return $exercises->answer_4;
        } else {
            return '';
        }
    } else {
        return '';
    }
}
