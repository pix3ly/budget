@extends('layout')

@section('body')
    <div class="wrapper my-3">
        <h2>Weekly Report {{ $year }}</h2>
        <div class="row mt-1">
            <a class="mr-1" href="{{ route('reports.show', ['slug' => 'weekly-report']) }}?year={{ $year - 1 }}">Previous</a>
            <a href="{{ route('reports.show', ['slug' => 'weekly-report']) }}?year={{ $year + 1 }}">Next</a>
        </div>
        <div class="box mt-3">
            <div class="box__section">
                <div class="ct-chart ct-major-twelfth"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function getWeeksInMonth(year, month) {
            var firstOfMonth = new Date(year, month - 1, 1);
            var lastOfMonth = new Date(year, month, 0);

            var used = firstOfMonth.getDay() + lastOfMonth.getDate();

            return Math.ceil(used / 7);
        }

        var data = {
            labels: [{!! implode(',', array_keys($weeks)) !!}],
            series: [[{!! '"' . implode('","', $weeks) . '"' !!}]]
        };

        var currentYear = new Date().getFullYear();
        var currentMonth = 1;
        var offset = 0;
        var months = [];

        for (var i = 1; i <= 12; i ++) {
            months[i] = getWeeksInMonth(currentYear, i);
        }

        new Chartist.Line('.ct-chart', data, {
            showPoint: false,
            lineSmooth: false,

            axisX: {
                labelInterpolationFnc: function (value, index) {
                    offset ++;

                    if (months[currentMonth] == offset) {
                        currentMonth ++;
                        offset = 1;

                        return currentMonth - 1;
                    }

                    return null;
                }
            }
        });
    </script>
@endsection
