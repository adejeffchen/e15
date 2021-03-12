<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $ageSelects = range(30, 75);
        $retiredAgeSelects = range(45, 85);
        
        return view('pages/home', [
            'ageSelects' => $ageSelects,
            'retiredAgeSelects' => $retiredAgeSelects,
            'currentAge' => session('currentAge', null),
            'retiredAge' => session('retiredAge', 65),
            'agesRange' => session('agesRange', null),
            'rentOrOwn' => session('rentOrOwn', "rent"),
            'currentExpense' => session('currentExpense', null),
            'currentInvestment' => session('currentInvestment', null),
            'mortgage' => session('mortgage', null),
            'mortgageLastAge' => session('mortgageLastAge', null),
            'expenseForecast' => session('expenseForecast', null),
            'investmentForecast' => session('investmentForecast', null),
        ]);
    }

    // POST /calculate
    // calculate when the person will run out of money
    public function calculate(Request $request)
    {
        // $ageSelects = range(30, 75);
        // $retiredAgeSelects = range(45, 85);

        // data from form
        $currentAge = $request->input('currentAge');
        $currentExpense = (int)$request->input('currentExpense');
        $retiredAge = $request->input('retiredAge');
        $currentInvestment = $request->input('currentInvestment');
        $rentOrOwn = $request->input('rentOrOwn');
        if ($rentOrOwn == 'own') {
            $mortgage = $request->input('mortgage');
            $mortgageLastAge = $request->input('mortgageLastAge');
        } else {
            $mortgage = null;
            $mortgageLastAge = null;
        }

        $agesRange = range($currentAge, 100);
        $expenseForecast = $this->forecastExpense($currentAge, $currentExpense, $mortgage, $mortgageLastAge);
        $investmentForecast = $this->forecastInvestment($currentAge, $retiredAge, $currentInvestment, $expenseForecast);

        // return view('pages/home', [
        //     'ageSelects' => $ageSelects,
        //     'retiredAgeSelects' => $retiredAgeSelects,
        //     'currentAge' => $currentAge,
        //     'agesRange' => $agesRange,
        //     'expenseForecast' => $expenseForecast,
        //     'investmentForecast' => $investmentForecast,
        // ]);
        return redirect('/')->with([
            'currentAge' => $currentAge,
            'retiredAge' => $retiredAge,
            'agesRange' => $agesRange,
            'rentOrOwn' => $rentOrOwn,
            'currentExpense' => $currentExpense,
            'currentInvestment' => $currentInvestment,
            'mortgage' => $mortgage,
            'mortgageLastAge' => $mortgageLastAge,
            'expenseForecast' => $expenseForecast,
            'investmentForecast' => $investmentForecast,
        ]);
    }

    private function forecastExpense($currentAge, $startingExpense, $mortgage, $mortgageLastAge)
    {
        $expenseForecast = [];
        $expenseForecast[] = $startingExpense;
        $counter = 0;
        $inflationRate = 0.04;
        while ($counter < (100-$currentAge)) {
            $counter++;
            if ($mortgage != 0) {
                // there is mortgage, take it out from inflation rate increase
                if (($currentAge + $counter) <= $mortgageLastAge) {
                    // before mortgage payoff, need to include it in total expense
                    $expenseForecast[] = round(($startingExpense-$mortgage) * pow((1+$inflationRate), $counter))+$mortgage;
                } else {
                    // after mortgage payoff, need to exclude it from total expense
                    $expenseForecast[] = round(($startingExpense-$mortgage) * pow((1+$inflationRate), $counter));
                }
            } else {
                // there is no mortgage, calculate as is
                $expenseForecast[] = round($startingExpense * pow((1+$inflationRate), $counter));
            }
        }
        return $expenseForecast;
    }

    private function forecastInvestment($currentAge, $retiredAge, $currentInvestment, $expenseForecast)
    {
        $investmentForecast = [];
        $investmentForecast[] = $currentInvestment;
        $counter = 0;
        $growthRate = 0.07;
        while ($counter < ($retiredAge-$currentAge)) {
            $counter++;
            $investmentForecast[] = round($currentInvestment * pow((1+$growthRate), $counter));
        }
        
        while ($counter < (100-$currentAge)) {
            // once retired, use investment to cover expense first, the rest grow 3% per year
            $counter++;
            $investmentForecast[] = round((end($investmentForecast) - $expenseForecast[$counter])*1.03);
        }
        return $investmentForecast;
    }
}