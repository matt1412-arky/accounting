<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<section class="vh-100" style="background-color: #9A616D;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card h-100 overflow-hidden" style="border-radius: 1rem;">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="/assets/img/background/login-bg.png" alt="login form" class="img-fluid h-100" style="border-radius: 1rem 0 0 1rem;" />
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex">
                            <div class="card-body p-4 h-100 text-black align-item-center">

                                <form>

                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                        <span class="h1 fw-bold mb-0">Logo</span>
                                    </div>

                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Masuk ke akun Anda</h5>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="emailLabel">Email</label>
                                        <input type="email" name="email" class="form-control form-control-lg" />
                                        <label id="emailError" class="text-danger" style="font-size: 12px; font-style: italic"></label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="passwordLabel">Password</label>
                                        <input type="password" name="password" class="form-control form-control-lg" />
                                        <label id="passError" class="text-danger" style="font-size: 12px; font-style: italic"></label>
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-dark btn-lg btn-block w-100" type="button" onclick="login()">Login</button>
                                        <label id="locked" class="text-danger" style="font-size: 12px; font-style: italic"></label>
                                    </div>

                                    <a class="small text-muted" href="#!">Lupa password?</a>
                                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Belum punya akun? <a href="#!" style="color: #393f81;">Register disini</a></p>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function login() {
        const inputEmail = document.querySelector('input[name="email"]');
        const inputPass = document.querySelector('input[name="password"]');
        const emailError = $('#emailError');
        const passError = $('#passError');
        const lockedError = $('#locked');

        inputEmail.addEventListener('input', function() {
            if (inputEmail.value === '') {
                emailError.html('*Email harus diisi');
            } else {
                emailError.html('');
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                emailError.html('*Format email tidak valid');
                return;
            } else {
                emailError.html('');
            }
        });

        inputPass.addEventListener('input', function() {
            if (inputPass.value === '') {
                passError.html('*Password harus diisi');
            } else {
                passError.html('');
            }
        });

        const email = inputEmail.value;
        const password = inputPass.value;

        if (email.length == 0) {
            emailError.html('*Email harus diisi');
            return;
        } else {
            emailError.html('');
        }

        if (password.length == 0) {
            passError.html('*Password harus diisi');
            return;
        } else {
            passError.html('');
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            emailError.html('*Format email tidak valid');
            return;
        } else {
            emailError.html('');
        }

        $.ajax({
            url: 'http://localhost:8000/api/login/submit',
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            success: function(masuk) {
                console.log(masuk);

                $.ajax({
                    url: 'http://localhost:8000/api/login/currentuser/' + email,
                    type: 'GET',
                    success: function(currentUser) {
                        localStorage.setItem('user_id', currentUser.user_id);
                        localStorage.setItem('username', currentUser.username);
                        localStorage.setItem('role_id', currentUser.role_id);
                        localStorage.setItem('user_email', currentUser.email);
                        window.location.href = "http://localhost:8000";
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            },
            error: function(error) {
                console.error(error.responseText);
                const errorMessage = error.responseJSON.message;
                if (errorMessage === 'Email atau password salah.') {
                    emailError.html('*Email atau password salah');
                    passError.html('*Email atau password salah');
                } else if (errorMessage === 'Email atau password tidak valid.') {
                    emailError.html('*Email atau password tidak valid');
                    passError.html('*Email atau password tidak valid');
                } else if (errorMessage === 'Akun terkunci. Hubungi admin.') {
                    lockedError.html('*Akun terkunci. Hubungi admin.');
                }
            }
        });
    }
</script>