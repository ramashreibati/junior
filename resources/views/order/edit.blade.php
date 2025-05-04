<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="{{ route('order.update', $order) }}" method="POST">
    @csrf
    @method('PUT')
    
    <label>Name:</label>
    <input type="text" name="name" value="{{ $order->name }}" required>

    <label>quantity:</label>
    <input type="text" name="quantity" value="{{ $order->quantity }}" required>

    <button type="submit">Update order</button>
</form>

</body>
</html>

