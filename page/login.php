<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - eLesen</title>
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
            background: #8659cf1a;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #8659cf;
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
            border-color: #8659cf;
            box-shadow: 0 0 0 0.2rem rgba(134, 89, 207, 0.25);
        }
        .btn-primary {
            background: #8659cf;
            border-color: #8659cf;
            font-weight: 500;
            font-size: 1.05rem;
            border-radius: 0.6rem;
            padding: 0.75rem 2rem;
            width: 100%;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: #7a4fc7;
            border-color: #7a4fc7;
        }
        .btn-primary:disabled {
            background: #6c757d;
            border-color: #6c757d;
        }
        .form-check-input:checked {
            background-color: #8659cf;
            border-color: #8659cf;
        }
        .forgot-link {
            color: #8659cf;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .forgot-link:hover {
            color: #7a4fc7;
            text-decoration: underline;
        }
        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f1f1;
        }
        .signup-link a {
            color: #8659cf;
            text-decoration: none;
            font-weight: 500;
        }
        .signup-link a:hover {
            color: #7a4fc7;
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
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
                <h1 class="login-title">Log Masuk</h1>
                <p class="login-subtitle">Masuk ke akaun eLesen anda</p>
            </div>
            <div class="login-body">
                <!-- Alert for messages -->
                <div id="alertContainer"></div>
                
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="icNumber" class="form-label">Nombor Kad Pengenalan</label>
                        <input type="text" class="form-control" id="icNumber" name="icNumber" placeholder="Masukkan nombor kad pengenalan anda" maxlength="12" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Laluan</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata laluan anda" required>
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
                    <span style="color: #6c757d;">Tiada akaun? </span>
                    <a href="signup.php">Daftar akaun baru</a>
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
            
            // Show alert function
            function showAlert(message, type = 'danger') {
                alertContainer.innerHTML = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
            }
            
            // Clear alert function
            function clearAlert() {
                alertContainer.innerHTML = '';
            }
            
            // Set loading state
            function setLoading(loading) {
                if (loading) {
                    loginBtn.disabled = true;
                    loginBtnText.style.display = 'none';
                    loginBtnSpinner.style.display = 'inline-block';
                } else {
                    loginBtn.disabled = false;
                    loginBtnText.style.display = 'inline';
                    loginBtnSpinner.style.display = 'none';
                }
            }
            
            // Handle form submission
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                clearAlert();
                setLoading(true);
                
                const formData = new FormData(loginForm);
                const icNumber = formData.get('icNumber').trim();
                const password = formData.get('password');
                const remember = formData.get('remember') === 'on';
                
                // Basic validation
                if (!icNumber || !password) {
                    showAlert('Sila isi semua medan yang diperlukan.');
                    setLoading(false);
                    return;
                }
                
                if (icNumber.length !== 12 || !/^\d+$/.test(icNumber)) {
                    showAlert('Nombor kad pengenalan mestilah 12 digit nombor.');
                    setLoading(false);
                    return;
                }
                
                try {
                    const response = await fetch('../api/auth/login.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            ic_number: icNumber,
                            password: password
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok && data.status === 200) {
                        // Login successful
                        showAlert('Log masuk berjaya! Mengalihkan ke dashboard...', 'success');
                        
                        // Store session data
                        localStorage.setItem('sessionToken', data.data.session.token);
                        localStorage.setItem('userData', JSON.stringify(data.data.user));
                        localStorage.setItem('sessionExpires', data.data.session.expires_at);
                        
                        // Remember IC number if checkbox is checked
                        if (remember) {
                            localStorage.setItem('rememberedIC', icNumber);
                        } else {
                            localStorage.removeItem('rememberedIC');
                        }
                        
                        // Redirect to dashboard after a short delay
                        setTimeout(() => {
                            window.location.href = 'dashboard.php';
                        }, 1500);
                    } else {
                        // Login failed
                        let errorMessage = 'Log masuk gagal. Sila cuba lagi.';
                        
                        if (data.message) {
                            errorMessage = data.message;
                        }
                        
                        showAlert(errorMessage);
                    }
                    
                } catch (error) {
                    console.error('Login error:', error);
                    showAlert('Ralat rangkaian. Sila periksa sambungan internet anda dan cuba lagi.');
                } finally {
                    setLoading(false);
                }
            });
            
            // Auto-fill IC number if remembered
            const rememberedIC = localStorage.getItem('rememberedIC');
            if (rememberedIC) {
                document.getElementById('icNumber').value = rememberedIC;
                document.getElementById('remember').checked = true;
            }
        });
    </script>
</body>
</html>
<?php include '../includes/footer.php'; ?>
