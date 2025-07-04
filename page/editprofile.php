<?php 
include '../includes/dashboard_header.php'; 
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - eLesen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', system-ui, Arial, sans-serif;
            background: #f8f9fa;
        }
        .editprofile-container {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }
        .editprofile-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #f1f1f1;
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
        }
        .editprofile-header {
            text-align: center;
            padding: 2rem 2rem 1rem 2rem;
            border-bottom: 1px solid #f1f1f1;
        }
        .editprofile-icon {
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
        .editprofile-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .editprofile-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
        }
        .editprofile-body {
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
        }
        .btn-primary:hover, .btn-primary:focus {
            background: #7a4fc7;
            border-color: #7a4fc7;
        }
        .btn-secondary {
            background: #6c757d;
            border-color: #6c757d;
            font-weight: 500;
            font-size: 1.05rem;
            border-radius: 0.6rem;
            padding: 0.75rem 2rem;
        }
        .btn-secondary:hover, .btn-secondary:focus {
            background: #5a6268;
            border-color: #5a6268;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f1f1f1;
        }
        .alert {
            border-radius: 0.6rem;
            border: none;
        }
        .alert-success {
            background: #d1edff;
            color: #0c5460;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }
        .form-text {
            color: #6c757d;
            font-size: 0.85rem;
        }
        .readonly-field {
            background-color: #f8f9fa;
            color: #6c757d;
        }
        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }
        .spinner-border {
            color: #8659cf;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Loading Screen -->
    <div id="loadingScreen" class="loading-container">
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Memuatkan maklumat profil...</p>
        </div>
    </div>

    <!-- Edit Profile Content -->
    <div id="editProfileContent" style="display: none;">
        <div class="editprofile-container">
            <div class="editprofile-card">
                <div class="editprofile-header">
                    <div class="editprofile-icon">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    <h1 class="editprofile-title">Edit Profil</h1>
                    <p class="editprofile-subtitle">Kemaskini maklumat peribadi anda</p>
                </div>
                <div class="editprofile-body">
                    <div id="messageContainer"></div>

                    <form id="editProfileForm">
                        <!-- Personal Information Section -->
                        <div class="section-title">
                            <i class="bi bi-person me-2"></i>
                            Maklumat Peribadi
                        </div>
                        
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Nama Penuh</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" 
                                   placeholder="Masukkan nama penuh anda" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="icNumber" class="form-label">Nombor Kad Pengenalan</label>
                            <input type="text" class="form-control readonly-field" id="icNumber" name="icNumber" 
                                   placeholder="Contoh: 900101015432" maxlength="12" readonly>
                            <div class="form-text">Nombor IC tidak boleh diubah</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nombor Telefon</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   placeholder="Contoh: 0123456789" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat E-mel (Pilihan)</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="Masukkan alamat e-mel anda (jika ada)">
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
                            <textarea class="form-control" id="address" name="address" rows="3" 
                                      placeholder="Masukkan alamat penuh anda" required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="postcode" class="form-label">Poskod</label>
                                <input type="text" class="form-control" id="postcode" name="postcode" 
                                       placeholder="Contoh: 17000" maxlength="5" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">Bandar</label>
                                <input type="text" class="form-control" id="city" name="city" 
                                       placeholder="Contoh: Pasir Mas" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">Negeri</label>
                                <select class="form-control" id="state" name="state" required>
                                    <option value="">Pilih Negeri</option>
                                    <option value="Johor">Johor</option>
                                    <option value="Kedah">Kedah</option>
                                    <option value="Kelantan">Kelantan</option>
                                    <option value="Melaka">Melaka</option>
                                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                                    <option value="Pahang">Pahang</option>
                                    <option value="Perak">Perak</option>
                                    <option value="Perlis">Perlis</option>
                                    <option value="Pulau Pinang">Pulau Pinang</option>
                                    <option value="Sabah">Sabah</option>
                                    <option value="Sarawak">Sarawak</option>
                                    <option value="Selangor">Selangor</option>
                                    <option value="Terengganu">Terengganu</option>
                                    <option value="Kuala Lumpur">Kuala Lumpur</option>
                                    <option value="Labuan">Labuan</option>
                                    <option value="Putrajaya">Putrajaya</option>
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-check-circle me-2"></i>
                                Simpan Perubahan
                            </button>
                            <a href="dashboard.php" class="btn btn-secondary flex-fill">
                                <i class="bi bi-arrow-left me-2"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is logged in
            const sessionToken = localStorage.getItem('sessionToken');
            const userData = localStorage.getItem('userData');
            const sessionExpires = localStorage.getItem('sessionExpires');
            
            if (!sessionToken || !userData || !sessionExpires) {
                // No session data, redirect to login
                window.location.href = 'login.php';
                return;
            }
            
            // Check if session has expired
            if (new Date(sessionExpires) < new Date()) {
                // Session expired, clear data and redirect to login
                localStorage.removeItem('sessionToken');
                localStorage.removeItem('userData');
                localStorage.removeItem('sessionExpires');
                window.location.href = 'login.php';
                return;
            }
            
            // Load user data and populate form
            loadUserData();
        });
        
        async function loadUserData() {
            try {
                const userData = localStorage.getItem('userData');
                if (userData) {
                    const user = JSON.parse(userData);
                    populateForm(user);
                    showEditProfile();
                } else {
                    // If no cached data, validate session and get fresh data
                    const sessionToken = localStorage.getItem('sessionToken');
                    const response = await fetch('../api/auth/validate.php', {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${sessionToken}`
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok && data.status === 200) {
                        const user = data.data.user;
                        populateForm(user);
                        showEditProfile();
                    } else {
                        window.location.href = 'login.php';
                    }
                }
            } catch (error) {
                console.error('Error loading user data:', error);
                showMessage('Ralat memuatkan maklumat pengguna', 'danger');
            }
        }
        
        function populateForm(user) {
            document.getElementById('fullName').value = user.full_name || '';
            document.getElementById('icNumber').value = user.ic_number || '';
            document.getElementById('phone').value = user.phone || '';
            document.getElementById('email').value = user.email || '';
            document.getElementById('address').value = user.address || '';
            document.getElementById('postcode').value = user.postcode || '';
            document.getElementById('city').value = user.city || '';
            document.getElementById('state').value = user.state || '';
            document.getElementById('warnaKadPengenalan').value = user.warna_kad_pengenalan || '';
            document.getElementById('tarikhLahir').value = user.tarikh_lahir || '';
            document.getElementById('umur').value = user.umur || '';
            document.getElementById('agama').value = user.agama || '';
        }
        
        function showEditProfile() {
            document.getElementById('loadingScreen').style.display = 'none';
            document.getElementById('editProfileContent').style.display = 'block';
        }
        
        function showMessage(message, type = 'success') {
            const messageContainer = document.getElementById('messageContainer');
            messageContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }
        
        // Form submission
        document.getElementById('editProfileForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = {
                fullName: document.getElementById('fullName').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                email: document.getElementById('email').value.trim(),
                address: document.getElementById('address').value.trim(),
                postcode: document.getElementById('postcode').value.trim(),
                city: document.getElementById('city').value.trim(),
                state: document.getElementById('state').value,
                warna_kad_pengenalan: document.getElementById('warnaKadPengenalan').value,
                tarikh_lahir: document.getElementById('tarikhLahir').value,
                umur: document.getElementById('umur').value,
                agama: document.getElementById('agama').value
            };
            
            // Basic validation
            if (!formData.fullName || !formData.phone || !formData.address || !formData.postcode || !formData.city || !formData.state) {
                showMessage('Sila isi semua medan yang diperlukan.', 'danger');
                return;
            }
            
            // Phone number validation (Malaysian format)
            const phoneRegex = /^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/;
            if (!phoneRegex.test(formData.phone)) {
                showMessage('Sila masukkan nombor telefon yang sah.', 'danger');
                return;
            }
            
            // Postcode validation
            const postcodeRegex = /^\d{5}$/;
            if (!postcodeRegex.test(formData.postcode)) {
                showMessage('Sila masukkan poskod yang sah (5 digit).', 'danger');
                return;
            }
            
            try {
                const sessionToken = localStorage.getItem('sessionToken');
                const response = await fetch('../api/profile/update_profile.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${sessionToken}`
                    },
                    body: JSON.stringify(formData)
                });
                
                const data = await response.json();
                
                if (response.ok && data.status === 200) {
                    // Update localStorage with new user data
                    localStorage.setItem('userData', JSON.stringify(data.data.user));
                    
                    showMessage('Profil berjaya dikemas kini!', 'success');
                    
                    // Redirect to dashboard after 2 seconds
                    setTimeout(() => {
                        window.location.href = 'dashboard.php';
                    }, 2000);
                } else {
                    showMessage(data.message || 'Ralat mengemas kini profil.', 'danger');
                }
            } catch (error) {
                console.error('Error updating profile:', error);
                showMessage('Ralat rangkaian. Sila cuba lagi.', 'danger');
            }
        });
        
        // Auto-format phone number
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.startsWith('60')) {
                    value = value.substring(2);
                }
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }
            }
            e.target.value = value;
        });
        
        // Auto-format postcode
        document.getElementById('postcode').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substring(0, 5);
            }
            e.target.value = value;
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
    </script>
</body>
</html>
<?php include '../includes/footer.php'; ?>
