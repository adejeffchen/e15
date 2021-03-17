@extends('layouts/main')

@section('content')
<h1>Life’s Runway - when will I run out of money?</h1>
<p>When can I retire? It is a common question but not many has the answer.
    This retirement calculator will help you to understand if you can afford
    your current lifestyle at the age you want to retire.
    It's all about if you have enough money to cover your yearly expense from retirement age to age 100!</p>
<h2>Philosophy behind the calculation</h2>
<ul>
    <li>To forecast your expense at retirement, the assumption is that the yearly expense will increase by 2.5% per year (to match the inflation rate) </li>
    <li>If renting, your rent will increase with inflation. If owning, your (fixed rate) mortgage payment will stay the same until you pay it off.</li>
    <li>Your total liquid assets include all your cash, savings, and investment portfolio. It will continue to grow until you retire.
        Growth can come from capital gains, salary gains, or passive incomes.
        For this calculation, we are assuming your total liquid assets have an average annual growth of 7%. </li>
    <li>Once you retire, you can withdraw from the investment portfolio to cover the expense and the remaining will continue to grow 3% annually.</li>
</ul>

<div id='app' v-cloak>
    <div class="border rounded-sm bg-light">
        <form class="p-3" method="POST" action="/calculate">
            {{ csrf_field() }}
            {{-- Current Age --}}
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="currentAge">Current age</label>
                        <select class="form-control" id="currentAge" name="currentAge">
                            @foreach($ageSelects as $ageSelect)
                            @if ($ageSelect == old("currentAge"))
                            <option selected="selected">{{$ageSelect}}</option>
                            @else
                            <option>{{$ageSelect}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Planned retired age --}}
                <div class="col">
                    <div class="form-group">
                        <label for="retiredAge">Planned retired age</label>
                        <select class="form-control" id="retiredAge" name="retiredAge">
                            @foreach($retiredAgeSelects as $retiredAgeSelect)
                            @if ($retiredAgeSelect == old("retiredAge", 65))
                            <option selected="selected">{{$retiredAgeSelect}}</option>
                            @else
                            <option>{{$retiredAgeSelect}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{-- Current Expense --}}
            <div class="form-group">
                <label for="currentExpense">Current yearly expense</label>
                <input class="form-control" id="currentExpense" name="currentExpense" placeholder="e.g. 50000 (including rent or mortgage payment)" value={{old("currentExpense")}}>
                {{-- if validation fails --}}
                @if($errors->get('currentExpense'))
                <div class='text-danger'>{{ $errors->first('currentExpense') }}</div>
                @endif
            </div>
            {{-- Renting or Owning --}}
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rentOrOwn" v-model="rentOrOwn" id="rent" value="rent" {{ (old("rentOrOwn") == 'rent') ? 'checked' : '' }}>
                    <label class="form-check-label" for="rent">Renting</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rentOrOwn" v-model="rentOrOwn" id="own" value="own" {{ (old("rentOrOwn") == 'own') ? 'checked' : '' }}>
                    <label class="form-check-label" for="own">Owning</label>
                </div>
            </div>
            <div class="form-group">
                <div v-show="rentOrOwn == 'own'">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="mortgage">Yearly mortgage payment</label>
                                <input class="form-control" id="mortgage" name="mortgage" placeholder="e.g. 50000" value={{old("mortgage", 0)}}>
                            </div>
                        </div>
                        {{-- Mortgage last age dropdown --}}
                        <div class="col">
                            <div class="form-group">
                                <label for="mortgageLastAge">Age when mortgage is paid off</label>
                                <select class="form-control" id="mortgageLastAge" name="mortgageLastAge">
                                    {{-- Reusing retiredAgeSelects variable range as mortgage last age dropdown  --}}
                                    @foreach($retiredAgeSelects as $retiredAgeSelect)
                                    @if ($retiredAgeSelect == old("mortgageLastAge", 60) )
                                    <option selected="selected">{{$retiredAgeSelect}}</option>
                                    @else
                                    <option>{{$retiredAgeSelect}}</option>
                                    @endif

                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- if validation fails --}}
                    @if($errors->get('mortgage'))
                    <div class='text-danger'>{{ $errors->first('mortgage') }}</div>
                    @endif
                </div>
            </div>
            {{-- Total liquid assets balance  --}}
            <div class="form-group">
                <label for="currentInvestment">Current total liquid assets</label>
                <input class="form-control" id="currentInvestment" name="currentInvestment" placeholder="e.g. 100000" value={{old("currentInvestment")}}>
                {{-- if validation fails --}}
                @if($errors->get('currentInvestment'))
                <div class='text-danger'>{{ $errors->first('currentInvestment') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>
    </div>

    @isset($expenseForecast)
    {{-- result section --}}
    <div class="border rounded-sm bg-light mt-3 pt-3">
        <div class="container">
            <h3>Result</h3>
            <p>When you retire at age {{old("retiredAge")}},
                your yearly forecasted expense will be around {{$retiredExpense}} and your forecasted total liquid assets will be around {{$retiredFund}}.</p>
            @if($runOutAge==0)
            <p>Congratulations! You will not run out of money before age 100! </p>
            @else
            <p>You will run out of money around age {{$runOutAge}}! </p>
            @endif
        </div>
    </div>

    {{-- script section for the chart  --}}
    <script type="application/javascript" src=' /js/chart.js' defer></script>
    <script type="application/javascript">
        // set data for the chart 
        var agesRange = @json($agesRange);
        var expenseForecast = @json($expenseForecast);
        var investmentForecast = @json($investmentForecast);

    </script>
    <canvas id="myChart"></canvas>
    @endisset

</div>

<script type="application/javascript">
    var app = new Vue({
        el: '#app'
        , data: {
            rentOrOwn: @json(old("rentOrOwn", "rent"))
        , }
    , });

</script>

@endsection
