<canvas id="myChart" width="100%" height="20%"></canvas>
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            @foreach ($pricevalues as $value)

              "{{ $value->getTime() }}",

            @endforeach
        ],
        datasets: [{
            label: '{{ $label }}',
            data: [
                @foreach ($pricevalues as $value)

                  "{{ $value->price }}",

                @endforeach
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
            ],
            borderColor: [
                'rgba(255,99,132,1)',
            ],
            borderWidth: 1,
            fill: 'start',
            pointRadius: 0,
            lineTension: 0,
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    suggestedMin: {{ $minPrice }},
                    suggestedMax: {{ $maxPrice }},
                    maxTicksLimit: 5
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Price in USD'
                }
            }],
            xAxes: [{
                ticks: {
                    maxTicksLimit: 10,
                    source: 'labels'
                },
                distribution: 'series'
            }]
        },
        tooltips: {
            enabled: true,
        }
    }
});
</script>
