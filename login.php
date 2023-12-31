<?php
session_start();
$connect=mysqli_connect("localhost", "root", "","shortenerlink");
if(isset($_POST['Login'])){
    $username =$_POST['Username'];
    $password =$_POST['Password'];
    $query="SELECT * FROM username WHERE Username='$username' AND Password='$password';";
    $gas=mysqli_query($connect, $query);
    if($gas->num_rows>0){
        header('Location:Main.php');
    }
        else{
            echo'
            <script>
                alert("Login Failed");
            </script>';
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            width: 320px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login to ShortenerLink</h1>
        <form method="POST">
            <input type="text" name="Username" placeholder="Username" required>
            <input type="password" name="Password" placeholder="Password" required>
            <input type="submit" name="Login" value="Login">
        </form>
    </div>
</body>
</html>
