<?php
    // Include the authorization check
    require_once "auth_session.php";

    // Assuming your authorization.php sets the $_SESSION['username'] upon successful login
    // Ensure the user is authenticated before showing the dashboard
    if(!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }else{
        header("Location: http://127.0.0.1:5000");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eye Health App</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>
    <div class="container">
        <h2>Eye Infection Diagnosis</h2>
        <form id="uploadForm" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" value="Upload and Diagnose">
        </form>
        <div class="diagnosis">
            <h3>Diagnosis Result:</h3>
            <p id="diagnosis-result">Waiting for diagnosis...</p>
        </div>
    </div>

    <!-- JavaScript to handle form submission and display diagnosis result -->
    <script>
        // Function to handle form submission
        async function handleSubmit(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('uploadForm'));

            try {
                const response = await fetch('/predict', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                document.getElementById('diagnosis-result').innerHTML = `<strong>Class:</strong> ${data.class}<br><strong>Confidence:</strong> ${data.confidence}`;
                
                // Refresh the page after 5 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 10000);
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Attach event listener to form submission
        document.getElementById('uploadForm').addEventListener('submit', handleSubmit);
    </script>
</body>
</html>
