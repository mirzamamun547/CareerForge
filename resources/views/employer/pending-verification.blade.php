<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending Verification — CareerForge</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated background blobs */
        body::before {
            content: '';
            position: fixed;
            top: -30%;
            left: -20%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            right: -15%;
            width: 50%;
            height: 50%;
            background: radial-gradient(circle, rgba(168,85,247,0.2) 0%, transparent 70%);
            animation: float 10s ease-in-out infinite reverse;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }

        .card-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 520px;
            padding: 1.5rem;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            text-align: center;
            animation: slideUp 0.6s ease forwards;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: white;
        }

        .logo-text {
            font-weight: 800;
            font-size: 1.25rem;
            color: white;
            letter-spacing: -0.02em;
        }

        .logo-text span {
            background: linear-gradient(135deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(251,191,36,0.2), rgba(245,158,11,0.15));
            border: 2px solid rgba(251,191,36,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.75rem;
            animation: pulse-ring 2.5s ease-in-out infinite;
        }

        @keyframes pulse-ring {
            0%, 100% { box-shadow: 0 0 0 0 rgba(251,191,36,0.3); }
            50% { box-shadow: 0 0 0 18px rgba(251,191,36,0); }
        }

        .icon-circle i {
            font-size: 2.5rem;
            color: #fbbf24;
        }

        h1 {
            color: white;
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.75rem;
        }

        .subtitle {
            color: rgba(255,255,255,0.55);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .steps-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: left;
        }

        .steps-title {
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 1rem;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            margin-bottom: 0.85rem;
        }

        .step-item:last-child {
            margin-bottom: 0;
        }

        .step-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .step-dot.done {
            background: rgba(74,222,128,0.15);
            color: #4ade80;
            border: 1.5px solid rgba(74,222,128,0.3);
        }

        .step-dot.pending {
            background: rgba(251,191,36,0.15);
            color: #fbbf24;
            border: 1.5px solid rgba(251,191,36,0.3);
        }

        .step-dot.waiting {
            background: rgba(148,163,184,0.1);
            color: rgba(255,255,255,0.35);
            border: 1.5px solid rgba(255,255,255,0.1);
        }

        .step-content {
            flex: 1;
        }

        .step-label {
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .step-desc {
            color: rgba(255,255,255,0.4);
            font-size: 0.775rem;
            margin-top: 2px;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.85rem 1.5rem;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            color: rgba(255,255,255,0.7);
            font-size: 0.875rem;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: rgba(239,68,68,0.15);
            border-color: rgba(239,68,68,0.3);
            color: #fca5a5;
            transform: translateY(-1px);
        }

        .refresh-note {
            margin-top: 1.25rem;
            color: rgba(255,255,255,0.3);
            font-size: 0.75rem;
        }

        .refresh-note a {
            color: rgba(129,140,248,0.8);
            text-decoration: none;
            font-weight: 500;
        }

        .refresh-note a:hover {
            color: #818cf8;
        }
    </style>
</head>
<body>
    <div class="card-wrapper">
        <div class="glass-card">
            <!-- Logo -->
            <div class="logo">
                <div class="logo-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                <div class="logo-text">Career<span>Forge</span></div>
            </div>

            <!-- Status Icon -->
            <div class="icon-circle">
                <i class="bi bi-hourglass-split"></i>
            </div>

            <!-- Heading -->
            <h1>Account Under Review</h1>
            <p class="subtitle">
                Your employer account has been submitted and is currently awaiting admin approval.
                You'll gain full access once verified.
            </p>

            <!-- Progress Steps -->
            <div class="steps-card">
                <div class="steps-title">Verification Progress</div>

                <div class="step-item">
                    <div class="step-dot done">
                        <i class="bi bi-check"></i>
                    </div>
                    <div class="step-content">
                        <div class="step-label">Account Created</div>
                        <div class="step-desc">Your employer account is registered successfully</div>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-dot pending">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="step-content">
                        <div class="step-label">Admin Review — In Progress</div>
                        <div class="step-desc">Our team is reviewing your account details</div>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-dot waiting">3</div>
                    <div class="step-content">
                        <div class="step-label">Access Granted</div>
                        <div class="step-desc">Post jobs and connect with candidates</div>
                    </div>
                </div>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-left"></i>
                    Sign Out
                </button>
            </form>

            <p class="refresh-note">
                Already approved? <a href="{{ route('employer.dashboard') }}">Refresh your dashboard</a>
            </p>
        </div>
    </div>
</body>
</html>
