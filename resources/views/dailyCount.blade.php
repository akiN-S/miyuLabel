<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            @if (session('flash_message'))
                $(function () {
                        toastr.warning('{{ session('flash_message') }}');
                });
            @endif
        </script>

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 100vh;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .content {
                text-align: center;
            }
            .title {
                font-size: 84px;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <script>
        window.onload = drawGraph;
        
        function drawGraph(){
        
            var ctx = document.getElementById("canvas");
            var myBar = new Chart(ctx, {
                type: 'bar',                           //◆棒グラフ
                data: {                                //◆データ
                    labels:  @json($dailyCountLabel),     //ラベル名
                    datasets: [{                       //データ設定
                        data: @json($dailyCountData),        //データ内容
                        backgroundColor: '#FF4444'  //背景色
                    }],
                },
                options: {                             //◆オプション
                    responsive: true,                  //グラフ自動設定
                    legend: {                          //凡例設定
                        display: false                 //表示設定
                    },
                    title: {                           //タイトル設定
                        display: true,                 //表示設定
                        text: '{{ $datesInfo['targetYear'].'年'.$datesInfo['targetMonth'].'月の日別グラフ' }}'               //ラベル
                    },
                    scales: {                          //軸設定
                        yAxes: [{                      //y軸設定
                            display: true,             //表示設定
                            scaleLabel: {              //軸ラベル設定
                                display: true,          //表示設定
                                labelString: '個数',  //ラベル
                            }, ticks: {
                                min: 0,
                            },
                        }],
                        xAxes: [{                         //x軸設定
                            display: true,                //表示設定
                            scaleLabel: {                 //軸ラベル設定
                                display: true,             //表示設定
                                labelString: '日付',  //ラベル
                            },
                        }],
                    },
                    layout: {                             //レイアウト
                        padding: {                          //余白設定
                            left: 100,
                            right: 50,
                            top: 0,
                            bottom: 0
                        }
                    },
                }
            });

            Chart.plugins.register({
                afterDatasetsDraw: function (chart, easing) {
                    // To only draw at the end of animation, check for easing === 1
                    var ctx = chart.ctx;

                    chart.data.datasets.forEach(function (dataset, i) {
                        var meta = chart.getDatasetMeta(i);
                        if (!meta.hidden) {
                            meta.data.forEach(function (element, index) {
                                // Draw the text in black, with the specified font
                                ctx.fillStyle = 'rgb(0, 0, 0)';

                                var fontSize = 16;
                                var fontStyle = 'normal';
                                var fontFamily = 'Helvetica Neue';
                                ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                                // Just naively convert to string for now
                                var dataString = dataset.data[index].toString();

                                // Make sure alignment settings are correct
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';

                                var padding = 5;
                                var position = element.tooltipPosition();
                                ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                            });
                        }
                    });
                }
            });

        }
    </script>

    <body>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-group row">
                                <div class="col-md-2"> <a href="{{ action('LabelNumController@show') }}">美雪の内職のお手伝いトップ</a></div>
                                <div class="col-md-4"> <a href="{{ action('LabelNumController@dailyCount') }}">日別個数グラフの表示</a></div>
                            </div>
                        </div>


                        <div class="card-body">
                            <form method="GET" action="{{ action('LabelNumController@dailyCount') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-2 col-7">
                                        {{ Form::select('year', $datesInfo['selectionYear'], $datesInfo['targetYear']) }} 年
                                        {{ Form::select('month', $datesInfo['selectionMonth'], $datesInfo['targetMonth']) }} 月
                                    </div>
                                    <div class="col-md-4 col-5">
                                        <button type="submit" class="btn btn-primary col-md-2 col-6" name="done" value="done">表示</button>
                                    </div>
                                </div>

                            </form>
                            <canvas id="canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>