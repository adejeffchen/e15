<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // GET '/'
    public function index()
    {
        $ageSelects = range(30, 75);
        $retiredAgeSelects = range(45, 85);
        
        return view('pages/home', [
            'ageSelects' => $ageSelects,
            'retiredAgeSelects' => $retiredAgeSelects,
            'agesRange' => session('agesRange', null),
            'expenseForecast' => session('expenseForecast', null),
            'investmentForecast' => session('investmentForecast', null),
            'retiredExpense' => session('retiredExpense', null),
            'retiredFund' => session('retiredFund', null),
            'runOutAge' => session('runOutAge', null),
        ]);
    }

    // POST '/calculate'
    // calculate when the person will run out of money
    public function calculate(Request $request)
    {
        // validation
        $request->validate([
            'currentAge' => 'required|numeric|gte:30',
            'retiredAge' => 'required|numeric|gte:45',
            'currentExpense' => 'required|numeric|gt:0',
            'currentInvestment' => 'required|numeric|gte:0',
            'mortgage' => 'numeric|gte:0',
        ]);
        // when failed, redirect back to '/'

        // data from form
        $currentAge = $request->input('currentAge');
        $currentExpense = $request->input('currentExpense');
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

        // agesRange = x axis for the chart
        $agesRange = range($currentAge, 100);
        $expenseForecast = $this->forecastExpense($currentAge, $currentExpense, $mortgage, $mortgageLastAge);
        $investmentForecast = $this->forecastInvestment($currentAge, $retiredAge, $currentInvestment, $expenseForecast);
        
        // get expense and funds available at retired age
        $retiredExpense = number_format($expenseForecast[$retiredAge-$currentAge]);
        $retiredFund = number_format($investmentForecast[$retiredAge-$currentAge]);
        $runOutAge = 0;

        // calculate age of money running out expense > fund
        for ($ageIndex = 0; $ageIndex < count($expenseForecast); $ageIndex++) {
            if ($expenseForecast[$ageIndex] > $investmentForecast[$ageIndex]) {
                $runOutAge = $ageIndex + $currentAge;
                break;
            }
        }
        
        return redirect('/')->with([
            'agesRange' => $agesRange,
            'expenseForecast' => $expenseForecast,
            'investmentForecast' => $investmentForecast,
            'retiredExpense' => $retiredExpense,
            'retiredFund' => $retiredFund,
            'runOutAge' => $runOutAge,
        ])->withInput();
    }

    private function forecastExpense($currentAge, $startingExpense, $mortgage, $mortgageLastAge)
    {
        $expenseForecast = [];
        $expenseForecast[] = $startingExpense;
        $counter = 0;
        $inflationRate = 0.025;
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