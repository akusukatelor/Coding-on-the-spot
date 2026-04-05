<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIHEMAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; height: 100vh; display: flex; align-items: center; }
        .login-card { border: none; border-radius: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .btn-success { background-color: #10b981; border: none; padding: 12px; border-radius: 12px; }
        .btn-success:hover { background-color: #059669; }
        .form-control { padding: 12px; border-radius: 12px; background-color: #f1f5f9; border: none; }
        .form-control:focus { background-color: #fff; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); border: 1px solid #10b981; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="text-center mb-4">
                    <h2 class="text-success fw-bold">SIHEMAT</h2>
                    <p class="text-muted">Kelola finansial dengan cerdas.</p>
                </div>
                <div class="card login-card p-4">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Selamat Datang!</h4>
                        
                        @if($errors->any())
                            <div class="alert alert-danger small">{{ $errors->first() }}</div>
                        @endif

                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="admin@sihemat.com" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100 fw-bold shadow-sm">Masuk Sekarang</button>
                        </form>
                    </div>
                </div>
                <p class="text-center mt-4 text-muted small">&copy; 2026 SIHEMAT Academic Ledger</p>
            </div>
        </div>
    </div>
</body>
</html>