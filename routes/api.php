<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get(
    '/test/{start_date}/{end_date}',
    function (Request $request, $start_date, $end_date) {
        /** @var \GoldPrices\Core\NbpApi\NbpApiDateRangeChunker $chunker */
        $chunker = app(\GoldPrices\Core\NbpApi\NbpApiDateRangeChunker::class);
        var_dump(
            $chunker->chunk(
                new DateTime($start_date),
                new DateTime($end_date)
            )
        );

});
