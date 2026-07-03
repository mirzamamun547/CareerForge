<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'CareerForge') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif !important;
                background-color: #F8FAFC;
            }

            .auth-card {
                background: #FFFFFF;
                border: 1px solid #E2E8F0;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.025);
            }

            .auth-input:focus {
                outline: none;
                border-color: #2563EB !important;
                box-shadow: 0 0 0 1px #2563EB !important;
            }

            .password-toggle {
                position: absolute;
                right: 14px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                color: #94A3B8;
                transition: color 0.15s;
                background: none;
                border: none;
                padding: 0;
                display: flex;
                align-items: center;
            }
            .password-toggle:hover { color: #2563EB; }

            .upload-area {
                border: 1px dashed #CBD5E1;
                transition: all 0.2s;
                display: flex;
                flex-direction: column;
                align-items: center;
                cursor: pointer;
            }
            .upload-area:hover {
                border-color: #2563EB;
                background-color: rgba(37, 99, 235, 0.02);
            }

            .selection-card {
                transition: all 0.2s ease-in-out;
            }
            .selection-card:hover {
                border-color: #2563EB !important;
                background-color: #F8FAFC;
            }
        </style>
    </head>
    <body class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6">
        <!-- Main Auth Content -->
        <div class="w-full" style="max-width: 480px;">
            {{ $slot }}
        </div>

        <script>
            // Password visibility toggle
            function togglePassword(inputId, btn) {
                const input = document.getElementById(inputId);
                const open  = btn.querySelector('.eye-open');
                const shut  = btn.querySelector('.eye-closed');
                if (input.type === 'password') {
                    input.type = 'text';
                    open.classList.add('hidden');
                    shut.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    open.classList.remove('hidden');
                    shut.classList.add('hidden');
                }
            }

            // File upload preview
            function previewFile(input, previewId) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.getElementById(previewId);
                        img.src = e.target.result;
                        img.classList.remove('hidden');
                        const placeholder = input.closest('.upload-area').querySelector('.upload-placeholder');
                        if (placeholder) placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </body>
</html>
