<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="{{ route('order.destroy', $order->name) }}" method="POST">
            @csrf
            @method('DELETE')

            <label>Name:</label>
    <input type="text" name="name" value="{{ $order->name }}" required>
    <button type="submit">delete order</button>
        </form>
</body>
</html>