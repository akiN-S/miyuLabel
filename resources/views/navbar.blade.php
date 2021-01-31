<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
 
    <!-- スマホやタブレットで表示した時のメニューボタン -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
 
    <!-- メニュー -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- 左寄せメニュー -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ action('LabelNumController@show') }}">トップ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ action('LabelNumController@dailyCount') }}">日別個数グラフ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ action('LabelSettingController@show') }}">製品管理</a>
            </li>
        </ul>
 
 
        <!-- ドロップダウンメニュー -->
        <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            User Name <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Logout</a>
        </div>
        </li> -->
    </ul>
    </div>
    </div>
</nav>