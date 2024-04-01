<!-- resources/views/doctor/detail.blade.php -->

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>産業医詳細</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50; /* Adjusted color code */
            color: white;
            padding: 10px 0;
            text-align: center;
        }

    </style>

</head>
<body>
    {{-- Header情報 --}}
    <header>
        <h1>ストレス診断システム<br>Stress Diagnostic System</h1>
        <div>
            <a href="{{ route('stress_system.operator_menu') }}">メニュー</a>
            <a href="#">ログアウト</a>
        </div>
    </header>

    <h1 style="text-align:center;">産業医詳細</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- 基本情報 -->
<div class="container mt-4">
    <div class="card">
        <div class="card-body">

<form action="{{ (!empty($user))? route('updateDoctor', $user->USER_ID): route('saveDoctor') }}"
        method="POST">

        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="USER_ID" class="form-label">社員ＩＤ</label>
                <div class="input-group">
                    <input type="text" id="USER_ID" name="USER_ID" class="form-control"
                    value="{{ old('USER_ID', $user->USER_ID ?? '')  }}"
                     {{ isset($user) ? 'disabled' : '' }}>
                    <div class="btn btn-primary" id="searchBtn" onclick="search()">検索</div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="name" class="form-label">氏名</label>
                <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', $user->name ?? '')}}" >
            </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="KAISYA_CODE" class="form-label">会社名</label>
            <input type="text" id="KAISYA_CODE" name="KAISYA_CODE" class="form-control"
                        value="{{ old('KAISYA_CODE', $user->KAISYA_CODE ?? '')}}" >
        </div>
        <div class="col-md-6">
            <label for="SOSHIKI_CODE" class="form-label">組織名</label>
            <input type="text" id="SOSHIKI_CODE" name="SOSHIKI_CODE" class="form-control"
                        value="{{ old('SOSHIKI_CODE', $user->SOSHIKI_CODE ?? '') }}" >
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">

            <label>権限区分</label>
            <div>

                <input type="radio" id="allCompany" name="KENGEN_KUBUN" value="1"
                {{ old('KENGEN_KUBUN', (isset($user) ? $user->KENGEN_KUBUN : '')) == 1 ? 'checked' : '' }}>
                {{-- {{ (isset($user) && $user->KENGEN_KUBUN == 1) ? 'checked' : '' }}> --}}
                <label for="allCompany">全社</label>

                <input type="radio" id="myCompany" name="KENGEN_KUBUN" value="2"
                {{ old('KENGEN_KUBUN', (isset($user) ? $user->KENGEN_KUBUN : '')) == 2 ? 'checked' : '' }}>
                {{-- {{ (isset($user) && $user->KENGEN_KUBUN == 2) ? 'checked' : '' }}> --}}
                <label for="myCompany">自社</label>

            </div>

        </div>
    </div>


    {{-- 確定ボタンは修正するものだから、UpdateDoctorだ。 --}}
    <button type="submit" class="btn btn-primary">確定</button>
 </form>

<form action="{{ route('stress_system.doctor_list') }}" id="goBackToDoctorList" method="GET">

    <!--회사명 체크박스 元 companyCheck-->
    <input type="hidden" name="companyCheck" id="companyCheck" value="{{ $companyCheck ?? '' }}">
    <!--회사명 인풋 元companyNameInput-->
    <input type="hidden" name="companyNameInput" id="companyNameInput" value="{{ $companyNameIn ?? '' }}">
    <!-- 회사명 아웃풋 元companyNameOutput -->
     <input type="hidden" name="companyNameOutput" id="companyNameOutput" value="{{ $companyNameOut ?? '' }}">

    <!-- 조직명 체크박스 元 soshikiCheck -->
     <input type="hidden" name="soshikiCheck" id="soshikiCheck" value="{{ $soCheck ?? '' }}">
    <!--조직명 인풋 元soshikiNameInput-->
     <input type="hidden" name="soshikiNameInput" id="soshikiNameInput" value="{{ $soshikiNameIn ?? '' }}">
    <!--조직명 아웃풋 元soshikiNameOutput-->
     <input type="hidden" name="soshikiNameOutput" id="soshikiNameOutput" value="{{ $soshikiNameOut ?? '' }}">

    <!--권한구분 체크박스 元authorityCheck-->
     <input type="hidden" name="authorityCheck" id="authorityCheck" value="{{ $kengenCheck ?? '' }}">
    <!--젠샤 라디오버튼 元allCompany-->
     <input type="hidden" name="kengenKubun" id="kengenKubun" value="{{ $kengenKubun ?? '' }}">
    <!--지샤 라디오버튼 元myCompany-->

     <input type="hidden" name="USER_ID" id="USER_ID" value="{{ $user->USER_ID ?? '' }}">

        <button class="btn btn-primary" id="returnBtn">戻る</button>

</form>

</div>
</div>
</div>

<script>

    const search = () => {

        const user_id = $('#USER_ID').val();
        console.log(user_id);
        $.ajax( {
            url: "{{ route('detailSearch') }}",
            method: "GET",
            data: { USER_ID: user_id },
            dataType: "json",
        }).done( function (res) {
            let name = document.querySelector(`#name`);
            let companyName = document.querySelector(`#KAISYA_CODE`);
            let orgName = document.querySelector(`#SOSHIKI_CODE`);
            name.value = res.name;
            companyName.value = res.KAISYA_CODE;
            orgName.value = res.SOSHIKI_CODE;

        }).fail( function () {
            alert ( '通信が失敗しました。' );
        });
    }

        // function submitToDoctorList() {

        //     // 'doctor_detail' 페이지에서 현재의 값을 가져와서
        //     // 'doctor_list'로 돌아갈 때 사용할 hidden input 필드에 설정
        //     $('#companyCheck').val($('#comCheck').is(':checked') ? 'on' : '');
        //     $('#companyNameInput').val($('#companyNameInput').val());
        //     $('#companyNameOutput').val($('#companyNameOutput').find(':selected').val());

        //     $('#soshikiCheck').val($('#soshikiCheck').is(':checked') ? 'on' : '');
        //     $('#soshikiNameInput').val($('#soshikiNameInput').val());
        //     $('#soshikiNameOutput').val($('#soshikiNameOutput').find(':selected').val());

        //     $('#authorityCheck').val($('#authorityCheck').is(':checked') ? 'on' : '');
        //     $('#allCom').val($('input[name="kengenKubun"]:checked').val() === '1' ? 'all' : '');
        //     $('#myCom').val($('input[name="kengenKubun"]:checked').val() === '2' ? 'my' : '');

        //     // 'doctor_list' 페이지로 돌아가기 위한 form 제출
        //     $('#goBackToDoctorList').submit(); // 해당 form의 ID로 교체해야 합니다.
        // }

        $(document).ready(function() {
            // `戻る` 버튼에 클릭 이벤트 리스너를 추가
            $('#returnBtn').on('click', function() {
                // 현재 설정된 검색 조건들을 hidden form에 설정
                // 예시 코드: 위에서 설명한 `returnToList()` 함수를 호출
                submitToDoctorList();
            });
        });





</script>

</body>

</html>
