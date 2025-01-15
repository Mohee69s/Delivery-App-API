<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
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
      text-align: center;
    }
    h1 {
      color: #333;
      margin-bottom: 20px;
    }
    a {
      display: block;
      margin: 10px 0;
      padding: 12px 0;
      background-color: #2196F3;
      color: white;
      text-decoration: none;
      font-size: 16px;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }
    a:hover {
      background-color: #1976D2;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Admin Dashboard</h1>
    <a href="/addastore">Add Store</a>
    <a href="/deleteastore">Delete a Store</a>
    <a href="/addaproduct">Add a Product</a>
    <a href="/editaproduct">Edit a Product</a>
    <a href="/deleteaproduct">Delete a Product</a>
      @if(session('message'))
          {{session('message')}}
      @endif
  </div>
</body>
</html>
