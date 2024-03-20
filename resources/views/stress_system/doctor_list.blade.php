<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>産業医一覧</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!--JQuery Add -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!--csrf token 生成-->
    <meta name = "csrf-token" content = "{{ csrf_token() }}" >

    <!--Style追加-->
    <style>
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
        }
        .search-bar {
            padding: 16px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 16px;
        }
        .search-bar input,
        .search-bar select,
        .search-bar button {
            margin-right: 10px;
        }
        .search-bar button {
            min-width: 100px;
        }
        table {
            background-color: white;
            border-collapse: collapse;
            width: 100%;
        }
        table th, table td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }
        table th {
            background-color: #f0f0f0;
        }
    </style>

</head>
<body>

    <div class="header text-center">
        <h1>ストレス診断システム<br>Stress Diagnostic System</h1>
    </div>

<div class="container mt-4">
    <form class="form-inline" action="{{ route('search') }}" method="GET" >

        <div class="container">
            <div class="search-bar">

                    <!-- 会社名 -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="companyCheck" checked>
                    <label class="form-check-label" for="companyCheck">会社名</label>
                    <input type="text" class="form-control" placeholder="会社名" id="companyNameInput" name="companyNameInput">
                    <button type="button" class="btn btn-primary" id="AjaxCompany">検索</button>
                    <input type="text" class="form-control" placeholder="" id="companyNameOutput" name="companyNameOutput">
                </div>

                <!-- 対象組織 -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="soshikiCheck" checked>
                    <label class="form-check-label" for="soshikiCheck">対象組織</label>
                    <input type="text" class="form-control" placeholder="組織名" id="soshikiNameInput" name="soshikiNameInput">
                    <button type="button" class="btn btn-primary" id="AjaxSoshiki">検索</button>
                    <input type="text" class="form-control" placeholder="" id="soshikiNameOutput" name="soshikiNameOutput">
                </div>

             <!-- 権限区分 -->
             <div class="form-check">
                <input class="form-check-input" type="checkbox" id="authorityCheck" checked>
                <label class="form-check-label" for="authorityCheck">権限区分</label>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="authorityOptions" id="allCompany" value="all" checked>
                    <label class="form-check-label" for="allCompany">全社</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="authorityOptions" id="myCompany" value="my">
                    <label class="form-check-label" for="myCompany">自社</label>
                </div>
            </div>

        </div>
    </div>
</form>
</div>
<!----------------------------------------------------------------------------------------------->
<div class="button-group d-flex justify-content-center mt-4">
    <!--表示ボタン-->
    <form class="form-inline "action="{{ route('hyoji_search') }}" method="POST">
        @csrf
      <button type="submit" class="btn btn-primary">表示する</button>
    </form>

    <!--追加ボタン-->
    <a href="{{ route('stress_system.doctor_detail') }}" class="btn btn-primary">追加する</a>
</div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>利用者ID</th>
                    <th>名前</th>
                    <th>会社名</th>
                    <th>組織名</th>
                    <th>備考</th>
                </tr>
            </thead>

            <tbody>

                <!-- 検索結果を出す。 -->
                 @forelse($results as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td> <!-- 番号 -->
                    <td>{{ $user->USER_ID }}</td> <!-- 利用者ID -->
                    <td>{{ $user->name }}</td> <!-- 名前 -->
                    <td>{{ $user->KAISYA_CODE }}</td> <!-- 会社名 -->
                    <td>{{ $user->SOSHIKI_CODE }}</td> <!-- 組織名 -->

                    <td>
                        <a href="{{ route('detail',
                        [$user->USER_ID]) }}" class="btn btn-success">変更</a>

                        <a href="{{ route('delete',
                        [$user->USER_ID]) }}"
                        type="submit" class="btn btn-danger">削除</a>
                     </td>
                </tr>

                @empty
                    <p>No List</p>
                @endforelse
            </tbody>
        </table>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!----------------------------------------------------------------------------------------------->

    <!--ajaxCompany-->
    <script>

        $( '#AjaxCompany' ).on( 'click' , function () {
            //alert('ddd');
            var kaishaName = $('#companyNameInput').val();

            $.ajaxSetup({
            headers: {  'X-CSRF-TOKEN' : $( "[name='csrf-token']" ).attr( "content" ) }
            });

            $.ajax( {
                url: "{{ route('AjaxCompany') }}",
                method: "POST",
                data: { CompanyName : kaishaName },
                dataType: "json",
            }).done( function (res) {
                    console.log(res);
                    $('#companyNameOutput').val(res.KAISYA_CODE);
            }).fail( function () {
                alert ( '通信が失敗しました。' );
            });
        } );

    </script>

    <!--ajaxSoshiki-->
    <script>
        $( '#AjaxSoshiki' ).on( 'click', function() {
            var soshikiName = $('#soshikiNameInput').val();

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN' : $( "[name='csrf-token']" ).attr( "content" ) }
            });

            $.ajax({
                url: "{{ route('AjaxSoshiki') }}" ,
                method: "POST" ,
                data: { SoshikiName: soshikiName } ,
                dataType: "json" ,
            }).done( function (res) {
                console.log(res);
                $('#soshikiNameOutput').val(res.SOSHIKI_CODE);
            }).fail( function () {
                alert ( '通信が失敗しました。' );
            });
        });
    </script>
</body>

<!----------------------------------------------------------------------------------------------->
