<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Reset default styles */
body, html {
  margin: 0;
  padding: 0;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

form {
  width: 300px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
}

h2 {
  margin-top: 0;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="email"] {
  width: 100%;
  padding: 8px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

button {
  padding: 8px 15px;
  font-size: 14px;
  border: none;
  border-radius: 3px;
  background-color: #3498db;
  color: white;
  cursor: pointer;
}

button:hover {
  background-color: #2980b9;
}

  </style>
</head>
<body>
  <div class="container">
    @if ($errors->any())
    <div class="alert alart-danger">
          <ul>
            @foreach ( $errors->all() as $item)
             <li>{{ $item }}</li>
            @endforeach
          </ul>
    </div>
    @endif
    @if (Session::get('success'))
    <div class="alert alart-success alert-dismissible fade show">
          <ul>
         <li>{{ Session::get('success') }}</li>
          </ul>
    </div>
    @endif
    <form action="{{route('forget.password.post')}}" method="post">
        @csrf
      <h2>Forgot Password</h2>
      <p>Enter your email address below to reset your password.</p>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <button type="submit">Reset Password</button>
      </div>
    </form>
  </div>
</body>
</html>
