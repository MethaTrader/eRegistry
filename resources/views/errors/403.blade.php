<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Доступ ограничен</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700">
    <style>
        html, body {
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 100vw;
            background: #eceff1;
            font-family: Montserrat, sans-serif;
        }
        .container {
            background: white;
            width: 40vw;
            padding: 1.5rem;
            box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
            border-radius: 0.5rem;
            text-align: center;
        }
        .container h1 {
            font-size: 1.25rem;
            margin: 0;
            margin-top: 1rem;
            color: #263238;
            opacity: 0;
            transform: translateX(-0.1rem);
            animation: fadeIn 1s forwards 1.5s;
        }
        .container p {
            margin: 0;
            margin-top: 0.5rem;
            color: #546e7a;
            opacity: 0;
            transform: translateX(-0.1rem);
            animation: fadeIn 1s forwards 1.75s;
        }
        .error-message {
            margin-top: 1rem;
            color: #d32f2f;
            font-weight: bold;
            animation: fadeIn 1s forwards 2s;
        }
        .back-btn {
            margin-top: 1.5rem;
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #d32f2f;
            color: #fff;
            text-decoration: none;
            border-radius: 0.25rem;
            transition: background-color 0.3s;
        }
        .back-btn:hover {
            background-color: #b71c1c;
        }
        @media screen and (max-width: 768px) { .container { width: 50vw; } }
        @media screen and (max-width: 600px) { .container { width: 60vw; } }
        @media screen and (max-width: 500px) { .container { width: 80vw; } }
        @keyframes fadeIn {
            from { transform: translateY(1rem); opacity: 0; }
            to { transform: translateY(0rem); opacity: 1; }
        }
        .forbidden-sign {
            margin: auto;
            width: 4.66667rem;
            height: 4.66667rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ef5350;
            animation: grow 1s forwards;
            position: relative;
        }
        @keyframes grow {
            from { transform: scale(1); }
            to { transform: scale(1); }
        }
        .forbidden-sign::before {
            position: absolute;
            background-color: white;
            border-radius: 50%;
            content: "";
            width: 4rem;
            height: 4rem;
            transform: scale(0);
            animation: grow2 0.5s forwards 0.5s;
        }
        @keyframes grow2 {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }
        .forbidden-sign::after {
            content: "";
            z-index: 2;
            position: absolute;
            width: 4rem;
            height: 0.33333rem;
            transform: scaleY(0) rotateZ(0deg);
            background: #ef5350;
            animation: grow3 0.5s forwards 1s;
        }
        @keyframes grow3 {
            from { transform: scaleY(0) rotateZ(0deg); }
            to { transform: scaleY(1) rotateZ(-45deg); }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="forbidden-sign"></div>
    <h1>Access to this page is restricted.</h1>
    <p>Ensure you have sufficient permissions to access the same.</p>
    @if(isset($message))
        <p class="error-message">{{ $message }}</p>
    @endif
    <a href="javascript:window.history.back();" class="back-btn">Back</a>
</div>
</body>
</html>
