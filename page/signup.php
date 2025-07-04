<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akaun - eLesen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', system-ui, Arial, sans-serif;
            background: #fff;
        }
        .signup-container {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }
        .signup-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #f1f1f1;
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
        }
        .signup-header {
            text-align: center;
            padding: 2rem 2rem 1rem 2rem;
            border-bottom: 1px solid #f1f1f1;
        }
        .signup-icon {
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
        .signup-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .signup-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
        }
        .signup-body {
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
        .form-check-input:checked {
            background-color: #8659cf;
            border-color: #8659cf;
        }
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f1f1;
        }
        .login-link a {
            color: #8659cf;
            text-decoration: none;
            font-weight: 500;
        }
        .login-link a:hover {
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
        .password-requirements {
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #6c757d;
        }
        .requirement-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.25rem;
        }
        .requirement-item i {
            margin-right: 0.5rem;
            font-size: 0.75rem;
        }
        .requirement-item.valid {
            color: #198754;
        }
        .requirement-item.invalid {
            color: #dc3545;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f1f1f1;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="signup-container">
        <div class="signup-card">
            <div class="signup-header">
                <div class="signup-icon">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h1 class="signup-title">Daftar Akaun</h1>
                <p class="signup-subtitle">Buat akaun eLesen baharu anda</p>
            </div>
            <div class="signup-body">
                <form id="signupForm">
                    <!-- Personal Information Section -->
                    <div class="section-title">
                        <i class="bi bi-person me-2"></i>
                        Maklumat Peribadi
                    </div>
                    
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Nama Penuh</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Masukkan nama penuh anda" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="icNumber" class="form-label">Nombor Kad Pengenalan</label>
                        <input type="text" class="form-control" id="icNumber" name="icNumber" placeholder="Contoh: 900101015432" maxlength="12" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nombor Telefon</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Contoh: 0123456789" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat E-mel (Pilihan)</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan alamat e-mel anda (jika ada)">
                    </div>
                    
                    <div class="mb-3">
                        <label for="warnaKadPengenalan" class="form-label">Warna Kad Pengenalan</label>
                        <select class="form-control" id="warnaKadPengenalan" name="warnaKadPengenalan" required>
                            <option value="">Pilih warna kad</option>
                            <option value="Biru">Biru</option>
                            <option value="Merah">Merah</option>
                            <option value="Hijau">Hijau</option>
                            <option value="Kuning">Kuning</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tarikhLahir" class="form-label">Tarikh Lahir</label>
                        <input type="date" class="form-control" id="tarikhLahir" name="tarikhLahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="umur" class="form-label">Umur</label>
                        <input type="number" class="form-control" id="umur" name="umur" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="agama" class="form-label">Agama</label>
                        <select class="form-control" id="agama" name="agama" required>
                            <option value="">Pilih agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristian">Kristian</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>
                    
                    <!-- Address Section -->
                    <div class="section-title mt-4">
                        <i class="bi bi-geo-alt me-2"></i>
                        Alamat
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Penuh</label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Masukkan alamat penuh anda" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="postcode" class="form-label">Poskod</label>
                            <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Contoh: 17000" maxlength="5" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">Bandar</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Contoh: Pasir Mas" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="state" class="form-label">Negeri</label>
                        <select class="form-control" id="state" name="state" required>
                            <option value="">Pilih negeri</option>
                            <option value="Kelantan">Kelantan</option>
                            <option value="Terengganu">Terengganu</option>
                            <option value="Pahang">Pahang</option>
                            <option value="Perak">Perak</option>
                            <option value="Selangor">Selangor</option>
                            <option value="Kuala Lumpur">Kuala Lumpur</option>
                            <option value="Putrajaya">Putrajaya</option>
                            <option value="Negeri Sembilan">Negeri Sembilan</option>
                            <option value="Melaka">Melaka</option>
                            <option value="Johor">Johor</option>
                            <option value="Kedah">Kedah</option>
                            <option value="Perlis">Perlis</option>
                            <option value="Pulau Pinang">Pulau Pinang</option>
                            <option value="Sabah">Sabah</option>
                            <option value="Sarawak">Sarawak</option>
                        </select>
                    </div>
                    
                    <!-- Account Security Section -->
                    <div class="section-title mt-4">
                        <i class="bi bi-shield-lock me-2"></i>
                        Keselamatan Akaun
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Laluan</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata laluan" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Sahkan Kata Laluan</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Masukkan semula kata laluan" required>
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya bersetuju dengan <a href="#" style="color: #8659cf;">Terma dan Syarat</a> serta <a href="#" style="color: #8659cf;">Dasar Privasi</a> eLesen
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mb-3" id="signupBtn">
                        <span id="signupBtnText">
                            <i class="bi bi-person-plus me-2"></i>
                            Daftar Akaun
                        </span>
                        <span id="signupBtnSpinner" class="spinner-border spinner-border-sm me-2" style="display: none;"></span>
                    </button>
                </form>
                <div id="signupAlert" class="mt-3"></div>
                <div class="login-link">
                    <span style="color: #6c757d;">Sudah ada akaun? </span>
                    <a href="login.php">Log masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const signupForm = document.getElementById('signupForm');
            const signupBtn = document.getElementById('signupBtn');
            const signupBtnText = document.getElementById('signupBtnText');
            const signupBtnSpinner = document.getElementById('signupBtnSpinner');
            const signupAlert = document.getElementById('signupAlert');
            
            function showSignupAlert(message, type = 'danger') {
                signupAlert.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`;
            }
            function clearSignupAlert() { signupAlert.innerHTML = ''; }
            function setSignupLoading(loading) {
                if (loading) {
                    signupBtn.disabled = true;
                    signupBtnText.style.display = 'none';
                    signupBtnSpinner.style.display = 'inline-block';
                } else {
                    signupBtn.disabled = false;
                    signupBtnText.style.display = 'inline';
                    signupBtnSpinner.style.display = 'none';
                }
            }
            signupForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                clearSignupAlert();
                setSignupLoading(true);
                const formData = new FormData(signupForm);
                const data = {
                    full_name: formData.get('fullName').trim(),
                    ic_number: formData.get('icNumber').trim(),
                    phone: formData.get('phone').trim(),
                    email: formData.get('email').trim(),
                    address: formData.get('address').trim(),
                    postcode: formData.get('postcode').trim(),
                    city: formData.get('city').trim(),
                    state: formData.get('state').trim(),
                    warna_kad_pengenalan: formData.get('warnaKadPengenalan'),
                    tarikh_lahir: formData.get('tarikhLahir'),
                    umur: formData.get('umur'),
                    agama: formData.get('agama'),
                    password: formData.get('password')
                };
                const confirmPassword = formData.get('confirmPassword');
                if (data.password !== confirmPassword) {
                    showSignupAlert('Kata laluan dan pengesahan tidak sepadan.');
                    setSignupLoading(false);
                    return;
                }
                try {
                    const response = await fetch('../api/auth/register.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(data)
                    });
                    const resData = await response.json();
                    if (response.ok && (resData.status === 201 || resData.status === 200)) {
                        showSignupAlert('Pendaftaran berjaya! Anda akan dialihkan ke halaman log masuk...', 'success');
                        setTimeout(() => { window.location.href = 'login.php'; }, 2000);
                    } else {
                        let errorMsg = resData.message || 'Pendaftaran gagal.';
                        if (resData.error && Array.isArray(resData.error)) errorMsg += '<br>' + resData.error.join('<br>');
                        showSignupAlert(errorMsg);
                    }
                } catch (err) {
                    showSignupAlert('Ralat rangkaian. Sila cuba lagi.');
                } finally {
                    setSignupLoading(false);
                }
            });

            // Auto-calculate umur from tarikh lahir
            document.getElementById('tarikhLahir').addEventListener('change', function() {
                const tarikhLahir = this.value;
                const umurInput = document.getElementById('umur');
                if (tarikhLahir) {
                    const today = new Date();
                    const birthDate = new Date(tarikhLahir);
                    let umur = today.getFullYear() - birthDate.getFullYear();
                    const m = today.getMonth() - birthDate.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                        umur--;
                    }
                    umurInput.value = umur > 0 ? umur : 0;
                } else {
                    umurInput.value = '';
                }
            });
        });
    </script>
</body>
</html>
<?php include '../includes/footer.php'; ?>
