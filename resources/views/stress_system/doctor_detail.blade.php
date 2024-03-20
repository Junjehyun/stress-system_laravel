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
    <form action="{{ route('saveDoctor')}}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="USER_ID" class="form-label">社員ＩＤ</label>
                <div class="input-group">
                    <input type="text" id="USER_ID" value="{{ $user->USER_ID ?? '' }}" name="USER_ID" class="form-control" maxlength="14" required>

                    <div class="btn btn-primary" id="searchBtn" onclick="search()">検索</div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="name" class="form-label">氏名</label>
                <input type="text" id="name" name="name"
                value="{{ $user->name ?? '' }}" class="form-control">
            </div>
        </div>

      <div class="row mb-3">
        <div class="col-md-6">
            <label for="KAISYA_NAME" class="form-label">会社名</label>
            <input type="text" id="KAISYA_CODE" name="KAISYA_CODE"
            value="{{ $user->KAISYA_CODE ?? '' }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="SOSHIKI_NAME" class="form-label">組織名</label>
            <input type="text" id="SOSHIKI_CODE" name="SOSHIKI_CODE"
            value="{{ $user->SOSHIKI_CODE ?? '' }}" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
            <label>権限区分</label>
        <div>
            <input type="radio" id="all" name="permission" value="all">
            <label for="all">全社</label>
            <input type="radio" id="self" name="permission" value="self">
            <label for="self">自社</label>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">確定</button>
    <a href="{{ route('stress_system.doctor_list') }}"
    class="btn btn-primary">戻る</a>
 </form>
 <div class="text-center">
</div>
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
</script>
</body>
</html>
