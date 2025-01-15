<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            height: 150px;
        }
        button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #2196F3;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Product</h2>
    <form action="/admin/products" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <label for="id">Product Id</label>
        <input type="text" id="id" name="id" required>

        <label for="name">Product Name</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea>

        <label for="price">Price ($)</label>
        <input type="number" id="price" name="price" required min="0" step="0.01">

        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity" required min="0">

        <label for="image">Product Image</label>
        <input type="file" id="image" name="image" accept="image/*">

        <button type="submit">Save Changes</button>
    </form>
</div>

</body>
</html>
