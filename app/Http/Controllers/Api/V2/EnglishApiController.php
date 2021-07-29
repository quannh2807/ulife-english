<?php
/**
 * Class EnglishApiController
 * Created by nguyendx.
 * Date: 7/22/21
 */

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnglishApiController extends Controller
{

    public function __construct()
    {
    }

    public function getBooks(Request $request)
    {

        $entries = [
            [
                "isbn" => "9781593275846",
                "title" => "Eloquent JavaScript, Second Edition -- VERSION 22222",
                "author" => "Marijn Haverbeke"
            ],
            [
                "isbn" => "9781449331818",
                "title" => "Learning JavaScript Design Patterns",
                "author" => "Addy Osmani"
            ],
            [
                "isbn" => "9781449365035",
                "title" => "Speaking JavaScript",
                "author" => "Axel Rauschmayer",
            ],
            [
                "isbn" => "9781491950296",
                "title" => "Programming JavaScript Applications",
                "author" => "Eric Elliott"
            ]
        ];

        return response()->json($entries, 200);
    }
}
