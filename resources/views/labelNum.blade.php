<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            @if (session('flash_message'))
                $(function () {
                        toastr.success('{{ session('flash_message') }}');
                });
            @endif
        </script>


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
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-group row">
                                <div class="col-md-2"> <a href="{{ action('LabelNumController@show') }}">美雪の内職のお手伝いトップ</a></div>
                                <div class="col-md-4"> <a href="{{ action('LabelNumController@dailyCount') }}">日別個数グラフの表示</a></div>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ action('LabelNumController@input') }}">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-md-2"></div>
                                    <button type="submit" class="btn btn-primary col-md-6" name="input" value="input">手動入力内容確定</button>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="labelNumOnGoing" class="col-md-2 col-12 col-form-label text-md-right">作業中の個数：</label>

                                    <div class="col-md-4 col-6">
                                        <input id="labelNumOnGoing" type="number" class="form-control @error('labelNumOnGoing') is-invalid @enderror" name="labelNumOnGoing" required value="{{ $labelNum->ongoing }}">
                                        
                                        @error('labelNumOnGoing')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary col-md-2 col-6" name="done" value="done">完了</button>


                                        <!-- <button type="submit" class="btn btn-primary col-md-4" name="inputOnGoing" value="inputOnGoing">修正</button> -->
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-2"></div>
                                    <button type="submit" class="btn btn-success col-md-2 col-6" name="plus" value="plus">プラス10</button>
                                    <button type="submit" class="btn btn-danger col-md-2 col-6" name="minus" value="minus">マイナス10</button>
                                </div>


                                <div class="form-group row">

                                    <label for="labelNumDone" class="col-md-2 col-6 col-form-label text-md-right">完了済の個数：</label>
                                    <div class="col-md-2 col-6">
                                        <input id="labelNumDone" type="number" class="form-control @error('labelNumDone') is-invalid @enderror" name="labelNumDone" value="{{ $labelNum->done }}" required>
                                        
                                        @error('labelNumDone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <label for="labelNumDoneBox" class="col-md-2 col-6 col-form-label text-md-right">完了済の箱数：</label>
                                    <div class="col-md-2 col-6 col-form-label">
                                        <strong>{{ $labelNum->doneBox }}</strong>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="labelNumLeft" class="col-md-2 col-6 col-form-label text-md-right">残個数：</label>
                                    <div class="col-md-2 col-6 col-form-label">
                                        <strong>{{ $labelNum->left  }} </strong>
                                    </div>

                                    <label for="labelNumLeftBox" class="col-md-2 col-6 col-form-label text-md-right">残箱数：</label>
                                    <div class="col-md-2 col-6 col-form-label">
                                        <strong>{{ $labelNum->leftBox  }} </strong>
                                    </div>
                                </div>



                                <div class="form-group row">

                                    <label for="quotaPerDay" class="col-md-2 col-6 col-form-label text-md-right">必要個数／日：</label>
                                    <div class="col-md-2 col-6 col-form-label">
                                        <strong>{{ round($labelNum->quotaPerDay) }} </strong>
                                    </div>
                                </div>


                                <div class="form-group row"> <!-- 空行 --></div>

                                <div class="form-group row"> 
                                    <label for="labelNumInBox" class="col-md-2 col-6 col-form-label text-md-right">設定</label>
                                </div>

                                <div class="form-group row">

                                    <label for="deliveryDate" class="col-md-2  col-6 col-form-label text-md-right">納品日：</label>
                                    <div class="col-md-2 col-6">
                                        <input id="deliveryDate" type="date" class="form-control @error('deliveryDate') is-invalid @enderror" name="deliveryDate" value="{{ $labelNum->deliveryDateStr }}" required>
                                        
                                        @error('deliveryDate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <label for="daysUntilDelivery" class="col-md-2 col-6 col-form-label text-md-right">残日数</label>
                                    <div class="col-md-2 col-6 col-form-label">
                                        <strong>{{ $labelNum->daysUntilDelivery }} </strong> ※今日を含む
                                    </div>
                                </div>


                                <div class="form-group row">

                                    <label for="labelNumQuota " class="col-md-2  col-6 col-form-label text-md-right">ノルマの個数：</label>
                                    <div class="col-md-2 col-6">
                                        <input id="labelNumQuota" type="number" class="form-control @error('labelNumQuota') is-invalid @enderror" name="labelNumQuota" value="{{ $labelNum->quota }}" required>
                                        
                                        @error('labelNumQuota')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <label for="labelNumQuotaBox " class="col-md-2  col-6 col-form-label text-md-right">ノルマの箱数：</label>
                                    <div class="col-md-2 col-6 col-form-label">
                                        <strong>{{ $labelNum->quotaBox }} </strong>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="labelNumInBox" class="col-md-2 col-6 col-form-label text-md-right">1箱当たりの個数：</label>
                                    <div class="col-md-6 col-6">
                                        <input id="labelNumInBox" type="number" class="form-control @error('labelNumInBox') is-invalid @enderror" name="labelNumInBox" value="{{ $labelNum->numInBox }}" required>
                                        
                                        @error('labelNumInBox')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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