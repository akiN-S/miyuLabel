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
                        <div class="card-header">製品管理 - 入力</div>

                        <div class="card-body">
                            <form method="POST" action="{{ action('LabelSettingController@save') }}">
                                @csrf
                                <input type="hidden" name="settingId" value="{{ $labelNum->settingId }}">
                                
                                <div class="form-group row">
                                    <label for="isSelected" class="col-md-2  col-6 col-form-label text-md-right">作業中：</label>
                                    <div class="col-md-2 col-6">
                                        <div class="col-md-2 col-6">
                                            @if ($labelNum->isSelected == true)
                                                <input class="form-check-input" type="checkbox" id="isSelected" name="isSelected" checked="checked">
                                            @else
                                                <input class="form-check-input" type="checkbox" id="isSelected" name="isSelected">
                                            @endif
                                            
                                        </div>    
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="settingName" class="col-md-2  col-6 col-form-label text-md-right">名前：</label>
                                    <div class="col-md-2 col-6">
                                        <input id="settingName" type="text" class="form-control @error('settingName') is-invalid @enderror" name="settingName" value="{{ $labelNum->name }}" required>
                                        
                                        @error('settingName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="startDate" class="col-md-2  col-6 col-form-label text-md-right">開始日：</label>
                                    <div class="col-md-2 col-6">
                                        <input id="startDate" type="date" class="form-control @error('startDate') is-invalid @enderror" name="startDate" value="{{ $labelNum->startDate }}" required>
                                        
                                        @error('startDate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                
                                <div class="form-group row">
                                    <label for="deliveryDate" class="col-md-2  col-6 col-form-label text-md-right">納品日：</label>
                                    <div class="col-md-2 col-6">
                                        <input id="deliveryDate" type="date" class="form-control @error('deliveryDate') is-invalid @enderror" name="deliveryDate" value="{{ $labelNum->deliveryDate }}" required>
                                        
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
                                    <div class="col-md-2 col-6">
                                        <input id="labelNumInBox" type="number" class="form-control @error('labelNumInBox') is-invalid @enderror" name="labelNumInBox" value="{{ $labelNum->numInBox }}" required>
                                        
                                        @error('labelNumInBox')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="unitPrice" class="col-md-2 col-6 col-form-label text-md-right">単価：</label>
                                    <div class="col-md-2 col-6">
                                        <input id="unitPrice" type="number" class="form-control @error('unitPrice') is-invalid @enderror" name="unitPrice" value="{{ $labelNum->unitPrice }}" required>
                                        
                                        @error('unitPrice')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-2 col-2"></div>
                                    <button type="button" class="btn btn-secondary col-md-3 col-4" onclick="location.href='{{ action('LabelSettingController@show') }}'">戻る</button>
                                    <button type="submit" class="btn btn-primary col-md-3 col-4" name="save" value="save">保存</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>