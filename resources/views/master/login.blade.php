<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <title>Login| Desa Alat</title>
        <link rel="icon" href="{{ asset('img/Logo/HST.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <style>
        .auth-wrapper {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;

            /* Latar Belakang Foto dengan Overlay Gradient khas Emerald */
            background: linear-gradient(135deg, rgba(18, 61, 50, 0.88), rgba(11, 42, 33, 0.95)),
                        url("{{ asset('img/Background/S1.jpg') }}") center/cover no-repeat fixed;
        }
        /* Tombol Kembali Floating di Kanan/Kiri Atas */
        .btn-back-home {
            position: absolute;
            top: 24px;
            left: 24px;
            z-index: 10;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: rgba(18, 61, 50, 0.6);
            border: 1px solid var(--gold);
            color: #ffffff;
            font-size: 0.75rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            font-weight: 600;
            text-decoration: none;
            backdrop-filter: blur(8px);
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .btn-back-home:hover {
            background: var(--gold);
            color: var(--emerald);
            transform: translateY(-2px);
        }

        /* Card Form Transparan (Glassmorphic) */
        .auth-card {
            width: 100%;
            max-width: 440px;
            background: rgba(22, 38, 31, 0.75);
            border: 1px solid rgba(198, 167, 106, 0.35);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 2.5rem;
            border-radius: 8px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            color: #fff;
            position: relative;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header img {
            width: 50px;
            height: 50px;
            margin: 0 auto 1rem;
        }

        .auth-header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
            color: #fff;
        }

        .auth-header p {
            font-size: 0.85rem;
            color: var(--sage);
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.75rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(14, 26, 22, 0.6);
            border: 1px solid rgba(198, 167, 106, 0.3);
            border-radius: 4px;
            color: #fff;
            font-family: var(--sans);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--gold);
            background: rgba(14, 26, 22, 0.9);
            box-shadow: 0 0 10px rgba(198, 167, 106, 0.2);
        }

        .form-input::placeholder {
            color: rgba(168, 181, 163, 0.5);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--sage);
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            accent-color: var(--gold);
        }

        .link-toggle {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            cursor: pointer;
        }

        .link-toggle:hover {
            text-decoration: underline;
            color: #fff;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--gold);
            color: var(--emerald);
            border: 1px solid var(--gold);
            font-size: 0.8rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 4px;
        }

        .btn-submit:hover {
            background: #d8bb80;
            color: var(--emerald);
            transform: translateY(-2px);
        }

        /* State Switcher for Forgot Password */
        .auth-form {
            display: block;
        }

        .auth-form.hidden {
            display: none;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 1.8rem;
            }
            .btn-back-home {
                top: 16px;
                left: 16px;
                padding: 8px 12px;
                font-size: 0.7rem;
            }
        }
    </style>
    </head>

    <body>

        <div class="auth-wrapper">
            <!-- Tombol Kembali ke Beranda -->
            <a href="{{ route('beranda') }}" class="btn-back-home" title="Kembali ke Beranda">
                ← <span>Beranda</span>
            </a>

            <div class="auth-card">
                <!-- ===== FORM 1: LOGIN ===== -->
                <form id="loginForm" class="auth-form" action="" method="POST">
                    @csrf
                    <div class="auth-header">
                        <img src="{{ asset('img/Logo/HST.png') }}" alt="Logo Kabupaten HST">
                        <span class="eyebrow">Dashboard Sistem</span>
                        <h1>Login</h1>
                        <p>Silakan masuk menggunakan kredensial Anda.</p>
                    </div>

                    <div class="form-group">
                        <label for="login_email">Email / Username</label>
                        <input type="text" id="login_email" name="email" class="form-input" placeholder="masukkan email atau username" required autocomplete="username">
                    </div>

                    <div class="form-group">
                        <label for="login_password">Kata Sandi</label>
                        <input type="password" id="login_password" name="password" class="form-input" placeholder="••••••••" required autocomplete="current-password">
                    </div>

                    <div class="form-actions">
                        <label class="remember-me">
                            <input type="checkbox" name="remember"> Ingat Saya
                        </label>
                        <a type="button" class="link-toggle" onclick="toggleForm('reset')">Lupa Sandi?</a>
                    </div>

                    <button type="submit" class="btn-submit">Dashboard Sistem</button>
                </form>

                <!-- ===== FORM 2: LUPA PASSWORD ===== -->
                <form id="resetForm" class="auth-form hidden" action="" method="POST">
                    @csrf
                    <div class="auth-header">
                        <img src="{{ asset('img/Logo/HST.png') }}" alt="Logo Kabupaten HST">
                        <span class="eyebrow">Pemulihan Akun</span>
                        <h1>Lupa Kata Sandi</h1>
                        <p>Masukkan email terdaftar untuk menerima tautan pemulihan kata sandi.</p>
                    </div>

                    <div class="form-group">
                        <label for="reset_email">Email Terdaftar</label>
                        <input type="email" id="reset_email" name="email" class="form-input" placeholder="contoh: user@desa-alat.id" required autocomplete="email">
                    </div>

                    <div class="form-actions" style="justify-content: flex-end;">
                        <a type="button" class="link-toggle" onclick="toggleForm('login')">← Kembali ke Login</a>
                    </div>

                    <button type="submit" class="btn-submit">Kirim Tautan Pemulihan</button>
                </form>
            </div>
        </div>

        <!-- Script sederhana untuk switch antar form -->
        <script>
            function toggleForm(target) {
                const loginForm = document.getElementById('loginForm');
                const resetForm = document.getElementById('resetForm');

                if (target === 'reset') {
                    loginForm.classList.add('hidden');
                    resetForm.classList.remove('hidden');
                } else {
                    resetForm.classList.add('hidden');
                    loginForm.classList.remove('hidden');
                }
            }
        </script>
    </body>
</html>
