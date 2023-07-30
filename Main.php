<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        h1 {
            text-align: center;
            margin: 40px 0;
            color: #333333;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
            color: #555555;
        }

        input[type="text"], input[type="password"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
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
    <h1>URL Shortener</h1>
    <div class="container">
        <form method="post">
            <label for="original_url">Enter your long URL:</label>
            <input type="text" name="original_url" id="original_url" required>
            <label for="short_code">Custom short slug (optional):</label>
            <input type="text" name="short_code" id="short_code">
            <input type="submit" value="Shorten">
        </form>
    </div>
</body>
</html>


    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $original_url = $_POST['original_url'];
        $short_code = $_POST['short_code'] ?? '';

        // Validate the URL
        if (filter_var($original_url, FILTER_VALIDATE_URL)) {
            $connect = mysqli_connect("localhost", "root", "", "shortenerlink");

            if (!$connect) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Check if the custom short slug is already in use
            if (!empty($short_code)) {
                $query = "SELECT * FROM urlshort WHERE short_code = '$short_code'";
                $result = mysqli_query($connect, $query);

                if (mysqli_num_rows($result) > 0) {
                    echo "Custom short slug is already in use. Please choose a different one.";
                    exit;
                }
            } else {
                // Generate a random short code
                $length = 6;
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $short_code = '';

                for ($i = 0; $i < $length; $i++) {
                    $random_index = mt_rand(0, strlen($characters) - 1);
                    $short_code .= $characters[$random_index];
                }
            }

            // Save the original URL and short code in the database
            $query = "INSERT INTO urlshort (original_url, short_code, visit_count) VALUES ('$original_url', '$short_code', 0)";
            $result = mysqli_query($connect, $query);

            if ($result) {
                $shortened_url = "http://your_web_domain.com/$short_code"; // Replace 'your_web_domain.com' with your actual domain
                
                echo "<p>Shortened URL: <a href='$shortened_url'>$shortened_url</a></p>";
                echo "<ul><li>Original URL: <a href='$original_url' target='_blank'>$original_url</a></li></ul>";
            } else {
                echo "Error saving data: " . mysqli_error($connect);
            }

            mysqli_close($connect);
        } else {
            echo "Invalid URL. Please enter a valid URL.";
        }
    }
    ?>
</body>
</html>
