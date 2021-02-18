<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Import de vos données!</h1>
@if (count($errors) > 0)
    <div style="color:dodgerblue;">
        <ul>
            @foreach ($errors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <input type="submit" value="submit">
</form>
</body>
</html>
