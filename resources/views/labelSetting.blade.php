<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
    </head>
   

    <body>
        @include('navbar')
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-12">
                    <div class="card">
                        <div class="card-header">製品管理</a></div>

                        <div class="card-body">
                            <form method="GET" action="{{ action('LabelSettingController@input') }}">
                                @csrf
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-primary col-md-3 col-4" name="new" value="new">新規登録</button>
                                    <button type="submit" class="btn btn-primary col-md-3 col-4" name="edit" value="edit">編集</button>
                                </div>
                                <div class="form-group row table-responsive">
                                    <div class="col-md-12 col-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap">選択</th>
                                                    <th class="text-nowrap">作業中</th>
                                                    <th class="text-nowrap">名前</th>
                                                    <th class="text-nowrap">開始日</th>
                                                    <th class="text-nowrap">納品日</th>
                                                    <th class="text-nowrap">ノルマ</th>
                                                    <th class="text-nowrap">1箱の個数</th>
                                                    <th class="text-nowrap">単価</th>
                                                    <th class="text-nowrap">完了済個数</th>
                                                    <th class="text-nowrap">合計金額</th>
                                                </tr>
                                            </thead>
                                            @foreach ($labelNums as $labelNum)
                                                <tbody>
                                                    <tr>
                                                        <td>{{ Form::radio('settingId', $labelNum->settingId, $labelNum->isSelected, array('id'=>'settingId'))}}</td> <!-- based on $labelNum->isSelected, it is also selected on radio button -->
                                                        @if ($labelNum->isSelected == true)
                                                            <td>作業中</td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                        <td>{{ $labelNum->name }}</td>
                                                        <td>{{ $labelNum->startDate }}</td>
                                                        <td>{{ $labelNum->deliveryDate }}</td>
                                                        <td>{{ $labelNum->quota }}</td>
                                                        <td>{{ $labelNum->numInBox }}</td>
                                                        <td>{{ $labelNum->unitPrice }}</td>
                                                        <td>{{ $labelNum->done }}</td>
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