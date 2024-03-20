<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stress Diagnostic System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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

        .container {
            display: flex;
            padding: 20px;
        }
        .menu {
            margin-right: 20px;
        }
        .menu a {
            display: block;
            color: blue;
            text-decoration: none;
            padding: 5px;
            margin-bottom: 5px;
        }
        .menu a:hover {
            background-color: lightgray;
        }
        .notice {
            margin-left: auto;
            padding: 20px;
            background-color: lightgray;
            border-radius: 10px;
        }
        @media screen and (max-width: 600px) {
            .container {
                flex-direction: column;
            }
            .menu {
                margin-right: 0;
            }
            .notice {
                margin-left: 0;
                margin-top: 20px;
            }
        }
    </style>

</head>
<body>
    <header>
        <h1>ストレス診断システム<br>Stress Diagnostic System</h1>
    </header>
    <div class="container">
        <div class="menu">
            <a href="{{ route('stress_system.blank') }}">■ 教育新規作成</a>
            <a href="{{ route('stress_system.blank') }}">■ 教育一覧</a>
            <a href="{{ route('stress_system.blank') }}">■ 全般設定</a>
            {{-- 産業医登録は後でページ設定変更する。 --}}
            <a href="{{ route('stress_system.doctor_list') }}">■ 産業医登録</a>
            <a href="{{ route('stress_system.blank') }}">■ 管理者登録</a>
            <a href="{{ route('stress_system.blank') }}">■ 未受診者一覧</a>
            <a href="{{ route('stress_system.blank') }}">■ 受診者一覧</a>
            <a href="{{ route('stress_system.blank') }}">■ 診断の削除</a>
        </div>
        <div class="notice">
            <p>お知らせです。: 内容を追加.</p>
        </div>
    </div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</body>
</html>
