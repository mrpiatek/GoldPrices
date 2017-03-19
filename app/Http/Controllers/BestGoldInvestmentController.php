<?php

namespace GoldPrices\Http\Controllers;

use Carbon\Carbon;
use GoldPrices\Core\ExtremesFinder\ExtremesFinderRequestor;
use GoldPrices\Core\ExtremesFinder\ExtremesFinderResponder;
use GoldPrices\Core\ExtremesFinder\ExtremesFinderService;
use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingInterface;
use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingRequestor;
use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BestGoldInvestmentController extends Controller
{
    const INVESTMENT_VALUE = 600000;
    /** @var  GoldPricesFetchingInterface */
    protected $dataFetcher;

    /** @var  ExtremesFinderService */
    protected $extremesFinder;

    /**
     * BestGoldInvestmentController constructor.
     * @param GoldPricesFetchingInterface $dataFetcher
     * @param ExtremesFinderService $extremesFinder
     */
    public function __construct(GoldPricesFetchingInterface $dataFetcher, ExtremesFinderService $extremesFinder)
    {
        $this->dataFetcher = $dataFetcher;
        $this->extremesFinder = $extremesFinder;
    }


    public function lastTenYearsBestInvestment(Request $request)
    {
        if (Cache::has('gold_prices')) {
            $goldPrices = Cache::get('gold_prices');
        } else {
            /** @var GoldPricesFetchingResponder $dataResponder */
            $dataResponder = $this->dataFetcher->getGoldPrices(
                new GoldPricesFetchingRequestor(
                    new \DateTime('-10 years'),
                    new \DateTime()
                )
            );

            $goldPrices = $dataResponder->getGoldPrices();
            Cache::put('gold_prices', $goldPrices, Carbon::now()->addDay());
        }

        /** @var ExtremesFinderResponder $extremes */
        $extremes = $this->extremesFinder->findExtremes(
            new ExtremesFinderRequestor(
                $goldPrices
            )
        );

        $investmentOutcome = round(
            self::INVESTMENT_VALUE / $extremes->getMinValue() * $extremes->getMaxValue() - self::INVESTMENT_VALUE,
            2
        );

        $dates = array_keys($goldPrices);


        return response()->json(
            [
                'data' => [
                    'best_buy_date' => $extremes->getMinIndex(),
                    'best_buy_price' => $extremes->getMinValue(),
                    'best_sell_date' => $extremes->getMaxIndex(),
                    'best_sell_price' => $extremes->getMaxValue(),
                    'investment_outcome' => '+'.$investmentOutcome.' PLN',
                    'effective_start_date' => $dates[0],
                    'effective_end_date' => end($dates),
                ],
            ]
        );
    }
}
