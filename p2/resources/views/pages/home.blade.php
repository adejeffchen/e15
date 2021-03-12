@extends('layouts/main')

@section('content')
<h1>Can I retire yet?</h1>
<p>When can I retire? It is a common question but not many has the answer.
    This retirement calculator will help you understand if you can afford
    your current lifestyle at the age you want to retire.
    It's all about if you have enough money to cover your yearly expense from retirement age to age 100!</p>
<h2>Philosophy of this retirement calculator</h2>
<ul>
    <li>To forecast your expense at retirement, the assumption is that the yearly expense will increase by 4% per year (to match the inflation rate) </li>
    <li>If renting, your rent will increase with inflation. If owning, your mortgage payment will stay the same until you pay it off.</li>
    <li>Your investment portfolio will continue to grow until you retire (assuming average annual growth = 7%). </li>
    <li>Once you retire, you can withdraw from the investment portfolio to cover the expense and the remaining will continue to grow 3%.</li>
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
                            @if ($ageSelect == $currentAge )
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
                            @if ($retiredAgeSelect == $retiredAge )
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
                <input type="number" class="form-control" id="currentExpense" name="currentExpense" placeholder="e.g. 50000 (including rent or mortgage payment)" value={{$currentExpense}}>
            </div>
            {{-- Renting or Owning --}}
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rentOrOwn" v-model="rentOrOwn" id="rent" value="rent" {{ ($rentOrOwn == 'rent' or is_null($rentOrOwn)) ? 'checked' : '' }}>
                    <label class="form-check-label" for="rent">Renting</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rentOrOwn" v-model="rentOrOwn" id="own" value="own" {{ ($rentOrOwn == 'own') ? 'checked' : '' }}>
                    <label class="form-check-label" for="own">Owning</label>
                </div>
            </div>
            <div class="form-group">
                <div v-show="rentOrOwn == 'own'">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="mortgage">Yearly mortgage payment</label>
                                <input type="number" class="form-control" id="mortgage" name="mortgage" placeholder="e.g. 50000" value={{$mortgage}}>
                            </div>
                        </div>
                        {{-- Mortgage last age dropdown --}}
                        <div class="col">
                            <div class="form-group">
                                <label for="mortgageLastAge">Age when mortgage is paid off</label>
                                <select class="form-control" id="mortgageLastAge" name="mortgageLastAge">
                                    {{-- Reusing retiredAgeSelects variable range as mortgage last age dropdown  --}}
                                    @foreach($retiredAgeSelects as $retiredAgeSelect)
                                    @if ($retiredAgeSelect == $mortgageLastAge )
                                    <option selected="selected">{{$retiredAgeSelect}}</option>
                                    @else
                                    <option>{{$retiredAgeSelect}}</option>
                                    @endif

                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Current investment portfolio balance  --}}
            <div class="form-group">
                <label for="currentInvestment">Current investment portfolio</label>
                <input type="number" class="form-control" id="currentInvestment" name="currentInvestment" placeholder="e.g. 100000" value={{$currentInvestment}}>
            </div>
            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>
    </div>

    @isset($currentAge)
    <div class="border rounded-sm bg-light mt-3 pt-3">
        <div class="container">
            <h3>Result</h3>
            <p>Current Age: {{$currentAge}}</p>
        </div>
    </div>

    {{-- script section for the chart  --}}
    <script type="application/javascript" src=' /js/chart.js' defer></script>
    <script type="application/javascript">
        // set data for the chart 
        var agesRange = @json($agesRange);
        var expenseForecast = @json($expenseForecast);
        var investmentForecast = @json($investmentForecast);
        //var rentOrOwn = @json($rentOrOwn);

    </script>
    <canvas id="myChart"></canvas>
    @endisset

</div>

<script type="application/javascript">
    var app = new Vue({
        el: '#app'
        , data: {
            rentOrOwn: @json($rentOrOwn)
        , }
    , });

</script>

@endsection
