<?php
// Clear session data
session_start();
session_destroy();

// Clear localStorage data via JavaScript
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Keluar - eLesen</title>
    <style>
        body {
            font-family: 'Inter', system-ui, Arial, sans-serif;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .logout-container {
            text-align: center;
            background: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #8659cf;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <div class="spinner"></div>
        <h3>Log Keluar...</h3>
        <p>Memadamkan data sesi anda...</p>
    </div>

    <script>
        // Clear localStorage data
        localStorage.removeItem('sessionToken');
        localStorage.removeItem('userData');
        localStorage.removeItem('sessionExpires');
        
        // Call logout API to invalidate session
        const sessionToken = localStorage.getItem('sessionToken');
        if (sessionToken) {
            fetch('../api/auth/logout.php', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${sessionToken}`
                }
            }).catch(error => {
                console.log('Logout API call failed:', error);
            });
        }
        
        // Redirect to login page after a short delay
        setTimeout(() => {
            window.location.href = 'login.php';
        }, 2000);
    </script>
</body>
</html> 