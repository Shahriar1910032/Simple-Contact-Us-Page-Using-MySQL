<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $conn = new mysqli("localhost", "root", "", "contact_system");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO queries (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        $acknowledgement = "Thank you, $name! Your query has been submitted successfully.";
        $alert_class = "success";
    } else {
        $acknowledgement = "An error occurred while submitting your query. Please try again.";
        $alert_class = "error";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            font-size: 2em;
            color: #4c4cfc;
        }
        form label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        form button {
            width: 100%;
            padding: 12px;
            background: #4c4cfc;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover {
            background: #3c3cfc;
        }
        .alert {
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .alert.success {
            background: #d4edda;
            color: #155724;
        }
        .alert.error {
            background: #f8d7da;
            color: #721c24;
        }
        nav {
            background: #4c4cfc;
            padding: 10px 20px;
            text-align: center;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }
        nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
    <nav>
        <a href="admin.php">Admin Dashboard</a>
    </nav>
        <h1>Contact Us</h1>
        <?php if (isset($acknowledgement)): ?>
            <div class="alert <?php echo $alert_class; ?>">
                <?php echo $acknowledgement; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Your Name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Your Email" required>

            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" placeholder="Subject" required>

            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Your Message" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
