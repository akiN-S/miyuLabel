<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Styles -->
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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">美雪の内職のお手伝い</div>

                        <div class="card-body">
                            <form method="POST" action="{{ action('LabelNumController@testPost') }}">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <button type="submit" class="btn btn-primary col-md-6" name="done" value="done">手動入力内容確定</button>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="labelNumeOnGoing" class="col-md-4 col-form-label text-md-right">作業中の個数：</label>

                                    <div class="col-md-6">
                                        <input id="labelNumeOnGoing" type="number" class="form-control @error('labelNumeOnGoing') is-invalid @enderror" name="labelNumeOnGoing"  required value="{{ $nums[0]->labelNum}}">
                                        
                                        @error('labelNumeOnGoing')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>

                                        <!-- <button type="submit" class="btn btn-primary col-md-4" name="inputOnGoing" value="inputOnGoing">修正</button> -->
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <button type="submit" class="btn btn-success col-md-2" name="plus" value="plus">プラス10</button>
                                    <button type="submit" class="btn btn-danger col-md-2" name="minus" value="minus">マイナス10</button>
                                    <button type="submit" class="btn btn-primary col-md-2" name="done" value="done">完了</button>
                                </div>


                                <div class="form-group row">

                                    <label for="labelNumeDone" class="col-md-4 col-form-label text-md-right">完了済の個数：</label>

                                    <div class="col-md-6">
                                        <input id="labelNumeDone" type="number" class="form-control @error('labelNumeDone') is-invalid @enderror" name="labelNumeDone" value="{{ $nums[1]->labelNum}}" required>
                                        
                                        @error('labelNumeDone')
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