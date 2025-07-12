<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Log Masuk - eLesen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', system-ui, Arial, sans-serif;
            background: #fff;
        }
        .login-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #f1f1f1;
            max-width: 450px;
            width: 100%;
        }
        .login-header {
            text-align: center;
            padding: 2rem 2rem 1rem 2rem;
            border-bottom: 1px solid #f1f1f1;
        }
        .login-icon {
            background: #dc35451a;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #dc3545;
            margin: 0 auto 1rem auto;
        }
        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .login-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
        }
        .login-body {
            padding: 2rem;
        }
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .form-control {
            border-radius: 0.6rem;
            border: 1px solid #e0e0e0;
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        .btn-primary {
            background: #dc3545;
            border-color: #dc3545;
            font-weight: 500;
            font-size: 1.05rem;
            border-radius: 0.6rem;
            padding: 0.75rem 2rem;
            width: 100%;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: #c82333;
            border-color: #c82333;
        }
        .btn-primary:disabled {
            background: #6c757d;
            border-color: #6c757d;
        }
        .form-check-input:checked {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .forgot-link {
            color: #dc3545;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .forgot-link:hover {
            color: #c82333;
            text-decoration: underline;
        }
        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f1f1;
        }
        .signup-link a {
            color: #dc3545;
            text-decoration: none;
            font-weight: 500;
        }
        .signup-link a:hover {
            color: #c82333;
            text-decoration: underline;
        }
        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-right: none;
            color: #6c757d;
        }
        .input-group .form-control {
            border-left: none;
        }
        .input-group .form-control:focus {
            border-left: none;
        }
        .alert {
            border-radius: 0.6rem;
            border: none;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }
        .alert-success {
            background: #d1edff;
            color: #0c5460;
        }
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
        .admin-badge {
            background: #dc3545;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1rem;
            display: inline-block;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <div class="admin-badge">
                    <i class="bi bi-shield-check me-1"></i>
                    Admin Panel
                </div>
                <h1 class="login-title">Log Masuk Admin</h1>
                <p class="login-subtitle">Masuk ke panel pentadbir eLesen</p>
            </div>
            <div class="login-body">
                <!-- Alert for messages -->
                <div id="alertContainer"></div>
                
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan nama pengguna" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Laluan</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata laluan" required>
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3" id="loginBtn">
                        <span id="loginBtnText">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Log Masuk
                        </span>
                        <span id="loginBtnSpinner" class="spinner-border spinner-border-sm me-2" style="display: none;"></span>
                    </button>
                    <div class="text-center">
                        <a href="#" class="forgot-link">Lupa kata laluan?</a>
                    </div>
                </form>
                <div class="signup-link">
                    <span style="color: #6c757d;">Pengguna biasa? </span>
                    <a href="login.php">Log masuk sebagai pengguna</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const loginBtnText = document.getElementById('loginBtnText');
            const loginBtnSpinner = document.getElementById('loginBtnSpinner');
            const alertContainer = document.getElementById('alertContainer');

            function showAlert(message, type = 'danger') {
                alertContainer.innerHTML = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
            }

            function setLoading(loading) {
                if (loading) {
                    loginBtn.disabled = true;
                    loginBtnText.style.display = 'none';
                    loginBtnSpinner.style.display = 'inline-block';
                } else {
                    loginBtn.disabled = false;
                    loginBtnText.style.display = 'inline-block';
                    loginBtnSpinner.style.display = 'none';
                }
            }

            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const username = document.getElementById('username').value.trim();
                const password = document.getElementById('password').value;
                const remember = document.getElementById('remember').checked;

                if (!username || !password) {
                    showAlert('Sila isi semua medan yang diperlukan');
                    return;
                }

                setLoading(true);

                try {
                    const response = await fetch('../api/auth/admin_login.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            username: username,
                            password: password
                        })
                    });

                    const data = await response.json();

                    if (data.status === 200) {
                        // Store session data
                        localStorage.setItem('adminSessionToken', data.data.session.token);
                        localStorage.setItem('adminData', JSON.stringify(data.data.admin));
                        
                        if (remember) {
                            localStorage.setItem('adminRemember', 'true');
                        }

                        showAlert('Log masuk berjaya! Menuju ke dashboard...', 'success');
                        
                        // Redirect to admin dashboard
                        setTimeout(() => {
                            window.location.href = 'admin_dashboard.php';
                        }, 1500);
                    } else {
                        showAlert(data.message || 'Ralat semasa log masuk');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('Ralat rangkaian. Sila cuba lagi.');
                } finally {
                    setLoading(false);
                }
            });
        });
    </script>
</body>
</html> 