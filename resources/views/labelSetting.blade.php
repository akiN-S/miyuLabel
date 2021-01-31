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

   

    <body>
        @include('navbar')
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-12">
                    <div class="card">
                        <div class="card-header">製品管理</a></div>

                        <div class="card-body">
                            <form method="GET" action="{{ action('LabelNumController@dailyCount') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-12 col-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>選択中</th>
                                                    <th>名前</th>
                                                    <th>開始日</th>
                                                    <th>納品日</th>
                                                    <th>ノルマ</th>
                                                    <th>1箱の個数</th>
                                                    <th>単価</th>
                                                    <th>完了済個数</th>
                                                    <th>合計金額</th>
                                                </tr>
                                            </thead>
                                            @foreach ($labelNums as $labelNum)
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $labelNum->isSelected }}</td>
                                                        <td>{{ $labelNum->name }}</td>
                                                        <td>{{ $labelNum->startDateStr }}</td>
                                                        <td>{{ $labelNum->deliveryDateStr }}</td>
                                                        <td>{{ $labelNum->quota }}</td>
                                                        <td>{{ $labelNum->numInBox }}</td>
                                                        <td>{{ $labelNum->done }}</td>
                                                        <td>{{ $labelNum->unitPrice }}</td>
                                                        <td>{{ $labelNum->price }}</td>
                                                    </tr>
                                                </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>