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

    <form class="form-inline" action="{{ route('hyoji_search') }}" method="POST" >
        @csrf

        <div class="container">
            <div class="search-bar">

                    <!-- 会社名 -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="companyCheck" name="companyCheck"
                    {{ old('companyCheck', $companyCheck) ? 'checked' : '' }}>

                    <label class="form-check-label" for="companyCheck">会社名</label>

                    <input type="text" class="form-control" placeholder="" id="companyNameInput"
                     name="companyNameInput" value="{{ !empty($companyName)? $companyName: '' }}">

                    <button type="button" class="btn btn-primary" id="AjaxCompany">検索</button>

                    <select id="companyNameOutput" name="companyNameOutput" class="form-control">
                        <option value="">会社名選択</option>
                    </select>

                </div>

                <!-- 対象組織 -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="soshikiCheck" name="soshikiCheck"
                    {{ old('soshikiCheck', $soshikiCheck) ? 'checked' : '' }}>

                    <label class="form-check-label" for="soshikiCheck">対象組織</label>

                    <input type="text" class="form-control" placeholder="" id="soshikiNameInput"
                    name="soshikiNameInput" value="{{ !empty($soshikiName)? $soshikiName: ''}}">

                    <button type="button" class="btn btn-primary" id="AjaxSoshiki">検索</button>

                    <select id="soshikiNameOutput" name="soshikiNameOutput" class="form-control">
                        <option value="">組織名選択</option>
                    </select>

                    {{-- <input type="text" class="form-control" placeholder="" id="soshikiNameOutput"
                    name="soshikiNameOutput" value="{{ !empty($soshikiNameOut)? $soshikiNameOut: '' }}"> --}}
                </div>

             <div class="form-check">
                <input class="form-check-input" type="checkbox" id="authorityCheck" name="authorityCheck"
                {{ old('authorityCheck', $authorityCheck) ? 'checked' : '' }}>

                <label class="form-check-label" for="authorityCheck">権限区分</label>

                <!-- 権限区分 라디오 버튼 -->
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kengenKubun" id="allCompany"
                    value="1" {{ old('authorityCheck', $authorityCheck) ? '' : 'disabled' }} {{ old("kengenKubun", $kengenKubun) == 1 ? "checked" : "" }}>
                    <label class="form-check-label" for="allCompany">全社</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kengenKubun" id="myCompany"
                    value="2" {{ old('authorityCheck', $authorityCheck) ? '' : 'disabled' }} {{ old("kengenKubun", $kengenKubun) == 2 ? "checked" : "" }}>
                    <label class="form-check-label" for="myCompany">自社</label>
                </div>

            </div>

        </div>
    </div>
</div>
    <!--表示ボタン-->
    <div class="button-group d-flex justify-content-center mt-4">
      <button type="submit" class="btn btn-primary">表示する</button>
    </form>
    <!--追加ボタン-->
    <a href="{{ route('stress_system.doctor_detail') }}"
    class="btn btn-primary">追加する</a>
    </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>利用者ID</th>
                    <th>名前</th>
                    <th>会社名</th>
                    <th>組織名</th>
                    <th>権限区分</th>
                    <th></th>
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
                    <td>{{ $user->KENGEN_KUBUN == 1 ? '全社' : '自社' }}</td> <!--権限区分-->

                    <td>
                        <a href="{{ route('detail',
                        [$user->USER_ID]) }}" class="btn btn-success">変更</a>

                        <a href="{{ route('delete',
                        [$user->USER_ID]) }}"
                        type="submit" class="btn btn-danger">削除</a>
                     </td>
                </tr>

                @empty
                    <p>会社名または組織名の結果がありません。</p>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $results->links() }}
        </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!----------------------------------------------------------------------------------------------->

    <!--ajaxCompany-->
<script>

$('#AjaxCompany').on('click', function () {
    var kaishaName = $('#companyNameInput').val(); // ユーザーが入力した会社名を読み取る

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content") }
    });

    $.ajax({
        url: "{{ route('AjaxCompany') }}", // 요청을 보낼 서버의 URL
        method: "POST",
        data: { CompanyName: kaishaName }, // 서버로 보낼 데이터
        dataType: "json",
    }).done(function (res) {
        var $companySelect = $('#companyNameOutput'); // select 태그 선택
        $companySelect.empty(); // 기존의 옵션들을 비웁니다.
        $companySelect.append($('<option>', { value: "", text: "会社名を選んでください" })); // 기본 옵션 추가

        // 서버로부터 받은 응답에서 회사 목록을 select 태그에 옵션으로 추가합니다.
        $.each(res, function (index, company) {
            $companySelect.append($('<option>', {
                value: company.KAISYA_CODE, // KAISYA_CODE를 옵션의 값으로 사용합니다.
                text: company.KAISYA_NAME // KAISYA_NAME를 옵션의 텍스트로 사용합니다.
            }));
        });

        $companySelect.prop('disabled', false); // 선택 상자를 활성화합니다.
    }).fail(function () {
        alert('通信が失敗しました。');
    });
});




        //ajaxSoshiki
        $('#AjaxSoshiki').on('click', function () {
    var soshikiName = $('#soshikiNameInput').val(); // 사용자가 입력한 회사명을 가져옵니다.

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content") }
    });

    $.ajax({
        url: "{{ route('AjaxSoshiki') }}", // 요청을 보낼 서버의 URL
        method: "POST",
        data: { SoshikiName: soshikiName }, // 서버로 보낼 데이터
        dataType: "json",
    }).done(function (res) {
        var $soshikiSelect = $('#soshikiNameOutput'); // select 태그 선택
        $soshikiSelect.empty(); // 기존의 옵션들을 비웁니다.
        $soshikiSelect.append($('<option>', { value: "", text: "組織名を選んでください" })); // 기본 옵션 추가

        // 서버로부터 받은 응답에서 회사 목록을 select 태그에 옵션으로 추가합니다.
        $.each(res, function (index, soshiki) {
            $soshikiSelect.append($('<option>', {
                value: soshiki.SOSHIKI_CODE, // KAISYA_CODE를 옵션의 값으로 사용합니다.
                text: soshiki.SOSHIKI_NAME // KAISYA_NAME를 옵션의 텍스트로 사용합니다.
            }));
        });

        $soshikiSelect.prop('disabled', false); // 선택 상자를 활성화합니다.
    }).fail(function () {
        alert('通信が失敗しました。');
    });
});

    // 権限区分버튼 안눌렀을때, 디폴트값 비활성화
    const checkbox = document.getElementById('authorityCheck');
    const radio1 = document.getElementById('allCompany');
    const radio2 = document.getElementById('myCompany');

    checkbox.addEventListener('change', function() {
        if (authorityCheck.checked) {
            allCompany.disabled = false;
            myCompany.disabled = false;
        } else {
            allCompany.disabled = true;
            myCompany.disabled = true;
        }
    });


    $(document).ready(function() {
    // 회사명 체크박스 상태의 변경 이벤트 리스너
    $('#companyCheck').change(function() {
        var checked = $(this).is(':checked');
        $('#companyNameInput').prop('disabled', !checked);
        $('#companyNameOutput').prop('disabled', !checked);
    });

    // 조직명 체크박스 상태의 변경 이벤트 리스너
    $('#soshikiCheck').change(function() {
        var checked = $(this).is(':checked');
        $('#soshikiNameInput').prop('disabled', !checked);
        $('#soshikiNameOutput').prop('disabled', !checked);
    });

    // 페이지 로드할때, 체크박스 상태에 의한 입력창 초기설정
    $('#companyCheck').trigger('change');
    $('#soshikiCheck').trigger('change');
    });

</script>

</body>
