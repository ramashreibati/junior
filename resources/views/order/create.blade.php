<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<h1>Add order</h1>

<form action="{{ route('order.store') }}" method="POST">
    @csrf
    <label>Name:</label>
    <input type="text" name="name" required>
    
    <label>quantity:</label>
    <input type="text" name="quantity" required>



<button type="submit">Add order</button>
</form>

</body>
</html>