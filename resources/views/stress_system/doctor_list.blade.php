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

    <!--hyoji_search フォームタグ-->
<form class="form-inline" action="{{ route('hyoji_search') }}" method="POST" >
        @csrf

        <div class="container">
            <div class="search-bar">

                    <!-- 会社名 -->
                <div class="form-check">
                    <!--会社名を選択チェックボックス-->
                    <input class="form-check-input" type="checkbox" id="companyCheck" name="companyCheck"
                    {{ old('companyCheck', $companyCheck) ? 'checked' : '' }}>
                    <label class="form-check-label" for="companyCheck">会社名</label>

                    <!--会社名を入力するInput-->
                    <input type="text" class="form-control" placeholder="" id="companyNameInput"
                     name="companyNameInput" value="{{ !empty($companyName)? $companyName: '' }}">

                    <!--会社名を入力した後、押すボタン-->
                    <button type="button" class="btn btn-primary" id="AjaxCompany">検索</button>

                    <!--会社名の結果が出るセレクトボックス-->
                    <select id="companyNameOutput" name="companyNameOutput" class="form-control">
                        <option value="">会社を選択</option>
                        @foreach ($haisyaList as $haisya)
                        <option value="{{ $haisya->KAISYA_CODE }}" {{ ($companyNameOut == $haisya->KAISYA_CODE) ? 'selected' : '' }}>
                            {{ $haisya->KAISYA_NAME_JPN }}</option>
                        @endforeach
                    </select>

                </div>

                <!-- 対象組織 -->
                <div class="form-check">
                    <!--対象組織を選択チェックボックス-->
                    <input class="form-check-input" type="checkbox" id="soshikiCheck" name="soshikiCheck"
                    {{ old('soshikiCheck', $soshikiCheck) ? 'checked' : '' }}>
                    <label class="form-check-label" for="soshikiCheck">対象組織</label>

                    <!--対象組織を入力するInput-->
                    <input type="text" class="form-control" placeholder="" id="soshikiNameInput"
                    name="soshikiNameInput" value="{{ !empty($soshikiName)? $soshikiName: ''}}">

                     <!--対象組織を入力した後、押すボタン-->
                    <button type="button" class="btn btn-primary" id="AjaxSoshiki">検索</button>

                    <!--対象組織の結果が出るセレクトボックス-->
                    <select id="soshikiNameOutput" name="soshikiNameOutput" class="form-control">
                        <option value="">組織名選択</option>
                         @foreach ($soshikiList as $soshiki)
                <option value="{{ $soshiki->SOSHIKI_CODE }}" {{ ($soshikiNameOut == $soshiki->SOSHIKI_CODE) ? 'selected' : '' }}>
                    {{ $soshiki->SOSHIKI_NAME_JPN ?? '' }}</option>
                     @endforeach
                    </select>

                </div>
                <!--権限区分チェックボックス-->
             <div class="form-check">
                <input class="form-check-input" type="checkbox" id="authorityCheck" name="authorityCheck"
                {{ old('authorityCheck', $authorityCheck) ? 'checked' : '' }}>
                <label class="form-check-label" for="authorityCheck">権限区分</label>

                <!-- 権限区分ラヂオボタン 全社-->
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kengenKubun" id="allCompany"
                    value="1" {{ old('authorityCheck', $authorityCheck) ? '' : 'disabled' }} {{ old("kengenKubun", $kengenKubun) == 1 ? "checked" : "" }}>
                    <label class="form-check-label" for="allCompany">全社</label>
                </div>

                <!-- 権限区分ラヂオボタン 自社-->
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

        <!--検索結果が出るデータのテーブル-->
        <table class="table table-striped table-hover">

            <!--テーブルのフォーム-->
            <thead>
                <tr>
                    <th>No.</th> <!--順番を表示する-->
                    <th>利用者ID</th> <!--USER_ID-->
                    <th>名前</th> <!--name-->
                    <th>会社名</th> <!--company_name-->
                    <th>組織名</th> <!--organization_name-->
                    <th>権限区分</th> <!--KENGEN_KUBUN-->
                    <th></th> <!--変更、削除ボタンがある行-->
                </tr>
            </thead>

            <tbody>

                <!-- 検索結果を出す。 -->
                 @forelse($results as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td> <!-- 番号 -->
                    <td>{{ $user->USER_ID }}</td> <!-- 利用者ID -->
                    <td>{{ $user->name }}</td> <!-- 名前 -->
                    <td>{{ $user->company_name ?? '' }}</td> <!--会社名-->
                    <td>{{ $user->organization_name ?? '' }}</td> <!--組織名-->
                    <td>{{ $user->KENGEN_KUBUN == 1 ? '全社' : '自社' }}</td> <!--権限区分-->

                    <!--変更、削除ボタン-->
                    <td>
                        <button class="btn btn-success" id="updateBtn"
                        onclick="clickUpdate('{{ $user->USER_ID }}')">変更</button>

                        <a href="{{ route('delete',
                        [$user->USER_ID]) }}"
                        type="submit" class="btn btn-danger">削除</a>
                     </td>

                </tr>

                <!--検索結果がなかった場合-->
                @empty
                    <p>会社名または組織名の結果がありません。</p>
                @endforelse
            </tbody>

        </table>
        <form action="{{ route('detail') }}" method="GET" id="updateForm">

                <!--회사명 체크박스 元 companyCheck-->
            <input type="hidden" name="comCheck" id="comCheck">
                <!--회사명 인풋 元companyNameInput-->
            <input type="hidden" name="companyNameIn" id="companyNameIn">
                <!-- 회사명 아웃풋 元companyNameOutput -->
			<input type="hidden" name="companyNameOut" id="companyNameOut">

                <!-- 조직명 체크박스 元 soshikiCheck -->
			<input type="hidden" name="soCheck" id="soCheck">
                <!--조직명 인풋 元soshikiNameInput-->
			<input type="hidden" name="soshikiNameIn" id="soshikiNameIn">
                <!--조직명 아웃풋 元soshikiNameOutput-->
			<input type="hidden" name="soshikiNameOut" id="soshikiNameOut">
                <!--권한구분 체크박스 元authorityCheck-->
			<input type="hidden" name="kengenCheck" id="kengenCheck">
                <!--젠샤 라디오버튼 元allCompany-->
			<input type="hidden" name="kengenKubun" id="kengenKubun">
                <!--지샤 라디오버튼 元myCompany-->

            <input type="hidden" name="USER_ID" id="USER_ID" value="{{ $user->USER_ID ?? '' }}">

        </form>

        <!--ページネーション設定-->
        <div class="d-flex justify-content-center">
            {{ $results->links() }}
        </div>

    <!-- Bootstrap JS and dependencies 追加-->
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
        url: "{{ route('AjaxCompany') }}",
        method: "POST",
        data: { CompanyName: kaishaName },
        dataType: "json",
    }).done(function (res) {
        var $companySelect = $('#companyNameOutput');
        $companySelect.empty();
        $companySelect.append($('<option>', { value: "", text: "会社名を選んでください" }));

        $.each(res, function (index, company) {
            $companySelect.append($('<option>', {
                value: company.KAISYA_CODE,
                text: company.KAISYA_NAME
            }));
        });

        $companySelect.prop('disabled', false);
    }).fail(function () {
        alert('通信が失敗しました。');
    });
});

$('#companyNameOutput').change(function() {
    var companyNameSelected = $(this).val();
    sessionStorage.setItem('companyNameSelected', companyNameSelected);
});
    //ajaxSoshiki
    $('#AjaxSoshiki').on('click', function () {
    var soshikiName = $('#soshikiNameInput').val();

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content") }
    });

    $.ajax({
        url: "{{ route('AjaxSoshiki') }}",
        method: "POST",
        data: { SoshikiName: soshikiName },
        dataType: "json",
    }).done(function (res) {
        var $soshikiSelect = $('#soshikiNameOutput');
        $soshikiSelect.empty();
        $soshikiSelect.append($('<option>', { value: "", text: "組織名を選んでください" }));

        $.each(res, function (index, soshiki) {
            $soshikiSelect.append($('<option>', {
                value: soshiki.SOSHIKI_CODE,
                text: soshiki.SOSHIKI_NAME
            }));
        });

        $soshikiSelect.prop('disabled', false);
    }).fail(function () {
        alert('通信が失敗しました。');
    });
});

    // 権限区分のチェックによる、ボタンの状態を設定する
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

    $('#companyCheck').change(function() {
        var checked = $(this).is(':checked');
        $('#companyNameInput').prop('disabled', !checked);
        $('#companyNameOutput').prop('disabled', !checked);
    });

    $('#soshikiCheck').change(function() {
        var checked = $(this).is(':checked');
        $('#soshikiNameInput').prop('disabled', !checked);
        $('#soshikiNameOutput').prop('disabled', !checked);
    });

    $('#companyCheck').trigger('change');
    $('#soshikiCheck').trigger('change');
    });

    function clickUpdate(userId) {

        // 회사명 체크박스
        $('#comCheck').val($('#companyCheck').val());

        // 회사명 인풋
        $('#companyNameIn').val($('#companyNameInput').val());

        // 회사명 아웃풋
        $('#companyNameOut').val($('#companyNameOutput').val());

        // 조직명 체크박스
        $('#soCheck').val($('#soshikiCheck').val());

        // 조직명 인풋
        $('#soshikiNameIn').val($('#soshikiNameInput').val());

        // 조직명 아웃풋
        $('#soshikiNameOut').val($('#soshikiNameOutput').val());

        // 권한구분 체크박스
        $('#kengenCheck').val($('#authorityCheck').val());

        if (document.querySelector('#allCompany').checked) {
            $('#kengenKubun').val($('#allCompany').val());
        } else if (document.querySelector('#myCompany').checked) {
            $('#kengenKubun').val($('#myCompany').val());
        }
        // 젠샤 라디오버튼
        // 지샤 라디오버튼
        $('#USER_ID').val($('#USER_ID').val());

        $('#updateForm').submit();

    }

</script>

</body>
