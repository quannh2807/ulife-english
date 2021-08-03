<?php

use Carbon\Carbon;

// ex: {{ changeDateFormat(date('Y-m-d'),'m/d/Y')  }}
function changeDateFormat($date, $date_format)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);
}

function thumbImagePath($thumb)
{
    if (!empty($thumb)) {
        if (file_exists('storage/' . $thumb)) {
            return asset('storage/' . $thumb);
        } else {
            return asset('images/no-image-upload.png');
        }
    } else {
        return asset('images/image-not-available.png');
    }
}

function htmlStatus($status)
{
    return $status === 0 ? '<label id="status" class="noActive">Không kích hoạt</label>'
        : '<label id="status" class="active">Kích hoạt</label>';
}
