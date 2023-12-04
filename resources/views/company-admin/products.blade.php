<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products Overview</title>
</head>
<body>
    @foreach ($products as $product)
        <h1>{{ $product->title }}</h1>
        <img src="{{ $product->productImages()->where('width', 708)->first()->url }}" alt="{{ $product->title }}">
    @endforeach
</body>
</html>
