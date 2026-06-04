<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&display=swap');

        :root {
            --c-deepest: #060b34;
            --c-dark: #0e2157;
            --c-mid: #122f71;
            --c-gray: #898989;
            --c-light: #f4f5f8;
            --c-white: #ffffff;
            --c-border: #dde1ea;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--c-white);
        }

        /* ───────────── SHELL ───────────── */
        .ls {
            display: flex;
            min-height: 100vh;
        }

        /* ───────────── LEFT — BRAND PANEL ───────────── */
        .ls__brand {
            width: 42%;
            flex-shrink: 0;
            background: var(--c-deepest);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3.25rem 3rem;
            animation: panelLeft .65s cubic-bezier(.22, .68, 0, 1.05) both;
        }

        /* gradient overlay */
        .ls__brand::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(155deg, var(--c-deepest) 0%, var(--c-dark) 52%, var(--c-mid) 100%);
            z-index: 0;
        }

        /* diagonal line texture */
        .ls__brand::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(-55deg,
                    transparent 0px, transparent 38px,
                    rgba(255, 255, 255, .028) 38px, rgba(255, 255, 255, .028) 39px);
            z-index: 1;
        }

        /* large ring — top right */
        .ls__ring-a {
            position: absolute;
            top: -120px;
            right: -120px;
            width: 380px;
            height: 380px;
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 50%;
            z-index: 2;
        }

        /* large ring — bottom left */
        .ls__ring-b {
            position: absolute;
            bottom: -160px;
            left: -80px;
            width: 440px;
            height: 440px;
            border: 1px solid rgba(255, 255, 255, .05);
            border-radius: 50%;
            z-index: 2;
        }

        /* horizontal accent line */
        .ls__hline {
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, .06), transparent);
            z-index: 2;
        }

        .ls__brand-inner {
            position: relative;
            z-index: 3;
            display: flex;
            flex-direction: column;
            height: 100%;
            justify-content: space-between;
        }

        .ls__logo {
            height: 98px;
            width: auto;
            object-fit: contain;
            object-position: left;
        }

        .ls__copy {}

        .ls__copy-rule {
            width: 32px;
            height: 2px;
            background: rgba(255, 255, 255, .4);
            margin-bottom: 1.25rem;
        }

        .ls__copy-heading {
            font-size: clamp(1.6rem, 2.5vw, 2.1rem);
            font-weight: 900;
            color: var(--c-white);
            line-height: 1.12;
            letter-spacing: -.03em;
            text-transform: uppercase;
            margin-bottom: 1.1rem;
        }

        .ls__copy-sub {
            font-size: .72rem;
            font-weight: 400;
            color: rgba(255, 255, 255, .45);
            letter-spacing: .1em;
            text-transform: uppercase;
            line-height: 1.8;
        }

        /* ───────────── RIGHT — FORM PANEL ───────────── */
        .ls__form-wrap {
            flex: 1;
            background: var(--c-light);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            position: relative;
            animation: panelRight .65s cubic-bezier(.22, .68, 0, 1.05) .08s both;
        }

        /* subtle vertical separator */
        .ls__form-wrap::before {
            content: '';
            position: absolute;
            left: 0;
            top: 12%;
            height: 76%;
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(18, 47, 113, .18) 40%, rgba(18, 47, 113, .18) 60%, transparent);
        }

        .ls__form-card {
            background: var(--c-white);
            border: 1px solid var(--c-border);
            border-radius: 4px;
            padding: 2.75rem 2.5rem 2.25rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 4px 32px rgba(6, 11, 52, .07), 0 1px 4px rgba(6, 11, 52, .04);
            animation: cardUp .55s cubic-bezier(.22, .68, 0, 1.05) .22s both;
        }

        /* top accent bar */
        .ls__form-card::before {
            content: '';
            display: block;
            height: 3px;
            background: linear-gradient(to right, var(--c-deepest), var(--c-mid));
            border-radius: 2px 2px 0 0;
            margin: -2.75rem -2.5rem 2rem;
        }

        .ls__form-eyebrow {
            font-size: .62rem;
            font-weight: 600;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--c-gray);
            margin-bottom: .6rem;
        }

        .ls__form-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--c-deepest);
            letter-spacing: -.025em;
            margin-bottom: .35rem;
        }

        .ls__form-desc {
            font-size: .75rem;
            color: var(--c-gray);
            font-weight: 400;
            margin-bottom: 1.75rem;
            line-height: 1.6;
        }

        /* ── Field label (header text only) ── */
        .ls__form div[name="form.wrapper.header"] label {
            font-size: .62rem !important;
            font-weight: 700 !important;
            letter-spacing: .14em !important;
            text-transform: uppercase !important;
            color: var(--c-dark) !important;
            font-family: 'Montserrat', sans-serif !important;
        }

        /* ── WireUI input container <label> ──
   WireUI renders the visual box on a <label> element using Tailwind ring-*.
   We zero out its ring system and use inset box-shadow as a border so height stays stable.
*/
        .ls__form label[data-name="form.wrapper.container"] {
            display: flex !important;
            align-items: center !important;
            height: 44px !important;
            padding: 0 0.85rem !important;
            background: var(--c-light) !important;
            border-radius: 3px !important;
            /* Zero WireUI ring — use inset shadow as border */
            --tw-ring-shadow: none !important;
            --tw-ring-offset-shadow: none !important;
            box-shadow: inset 0 0 0 1px var(--c-border) !important;
            transition: box-shadow .18s, background .18s !important;
        }

        .ls__form label[data-name="form.wrapper.container"]:focus-within {
            background: var(--c-white) !important;
            box-shadow: inset 0 0 0 1.5px var(--c-mid), 0 0 0 3px rgba(18, 47, 113, .1) !important;
        }

        /* ── Raw input inside the container (transparent, no border) ── */
        .ls__form input[type="email"],
        .ls__form input[type="password"],
        .ls__form input[type="text"] {
            flex: 1 1 auto !important;
            min-width: 0 !important;
            height: 100% !important;
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
            outline: none !important;
            box-shadow: none !important;
            font-family: 'Montserrat', sans-serif !important;
            font-size: .85rem !important;
            color: var(--c-deepest) !important;
        }

        .ls__form input::placeholder {
            color: #b8bcc8 !important;
            font-size: .8rem !important;
        }

        /* Submit button */
        .ls__form button[type="submit"] {
            width: 100% !important;
            background: var(--c-deepest) !important;
            border: none !important;
            border-radius: 3px !important;
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 700 !important;
            font-size: .72rem !important;
            letter-spacing: .18em !important;
            text-transform: uppercase !important;
            padding: .85rem 1.5rem !important;
            color: var(--c-white) !important;
            cursor: pointer !important;
            transition: background .2s, transform .15s, box-shadow .2s !important;
        }

        .ls__form button[type="submit"]:hover {
            background: var(--c-dark) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 20px rgba(6, 11, 52, .2) !important;
        }

        .ls__form button[type="submit"]:active {
            transform: translateY(0) !important;
        }

        /* Forgot password link */
        .ls__forgot {
            font-size: .72rem !important;
            font-weight: 500 !important;
            color: var(--c-mid) !important;
            text-decoration: none !important;
            transition: color .18s !important;
            font-family: 'Montserrat', sans-serif !important;
        }

        .ls__forgot:hover {
            color: var(--c-deepest) !important;
        }

        /* Checkbox label */
        .ls__form label[for="remember_me"],
        .ls__form .text-sm {
            font-size: .72rem !important;
            font-weight: 500 !important;
            letter-spacing: .04em !important;
            text-transform: none !important;
            color: var(--c-gray) !important;
        }

        /* Separator */
        .ls__sep {
            display: flex;
            align-items: center;
            gap: .85rem;
            margin: 1.5rem 0;
        }

        .ls__sep::before,
        .ls__sep::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--c-border);
        }

        .ls__sep span {
            font-size: .58rem;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: #c8ccda;
        }

        /* Security notice */
        .ls__security {
            display: flex;
            align-items: flex-start;
            gap: .65rem;
            padding: .75rem .9rem;
            background: rgba(6, 11, 52, .04);
            border-left: 2px solid var(--c-mid);
            border-radius: 0 3px 3px 0;
        }

        .ls__security-icon {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            color: var(--c-mid);
            margin-top: 1px;
        }

        .ls__security p {
            font-size: .68rem;
            color: var(--c-dark);
            font-weight: 500;
            line-height: 1.55;
            letter-spacing: .01em;
        }

        /* Footer */
        .ls__footer {
            margin-top: 1.75rem;
            text-align: center;
            font-size: .62rem;
            color: #b8bcc8;
            letter-spacing: .07em;
            font-weight: 400;
        }

        /* ───────────── ANIMATIONS ───────────── */
        @keyframes panelLeft {
            from {
                opacity: 0;
                transform: translateX(-24px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes panelRight {
            from {
                opacity: 0;
                transform: translateX(24px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes cardUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ───────────── RESPONSIVE ───────────── */
        @media (max-width: 860px) {
            .ls {
                flex-direction: column;
                min-height: 100vh;
            }

            .ls__brand {
                width: 100%;
                min-height: auto;
                padding: 1.5rem 2rem;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .ls__brand-inner {
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: auto;
                width: 100%;
            }

            .ls__logo {
                height: 56px;
                object-position: center;
            }

            .ls__copy {
                display: none;
            }

            .ls__ring-a,
            .ls__ring-b,
            .ls__hline {
                display: none;
            }

            .ls__form-wrap {
                flex: 1;
                padding: 2rem 1.25rem;
                align-items: center;
                justify-content: center;
            }

            .ls__form-wrap::before {
                display: none;
            }

            .ls__form-card {
                padding: 2rem 1.5rem 1.75rem;
            }

            .ls__form-card::before {
                margin: -2rem -1.5rem 1.75rem;
            }
        }
    </style>

    <div class="ls">

        {{-- ── LEFT: Brand Panel ── --}}
        <aside class="ls__brand">
            <div class="ls__ring-a"></div>
            <div class="ls__ring-b"></div>
            <div class="ls__hline"></div>

            <div class="ls__brand-inner">
                <img src="{{ asset('images/logo-2-1.png') }}" alt="Talentus" class="ls__logo">

                <div class="ls__copy">
                    <div class="ls__copy-rule"></div>
                    <h2 class="ls__copy-heading">
                        Gestión<br>Empresarial<br>Integrada
                    </h2>
                    <p class="ls__copy-sub">
                        Sistema de administración<br>y control operativo
                    </p>
                </div>
            </div>
        </aside>

        {{-- ── RIGHT: Form Panel ── --}}
        <main class="ls__form-wrap">
            <div class="ls__form-card">
                <p class="ls__form-eyebrow">Acceso al sistema</p>
                <h1 class="ls__form-title">Iniciar Sesión</h1>
                <p class="ls__form-desc">Ingresa tus credenciales para acceder al panel</p>

                @if (session('status'))
                    <x-form.alert class="mb-5" positive>{{ session('status') }}</x-form.alert>
                @endif

                <x-form.errors class="mb-4" />

                <form method="POST" action="{{ route('login') }}" class="ls__form space-y-5">
                    @csrf

                    <x-form.input label="Correo electrónico" name="email" type="email"
                        placeholder="correo@empresa.com" value="{{ old('email') }}" required autofocus />

                    <x-form.password label="Contraseña" name="password" placeholder="••••••••" required
                        autocomplete="current-password" />

                    <div class="flex items-center justify-between">
                        <x-form.checkbox id="remember_me" name="remember" label="Recordar sesión" />

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="ls__forgot">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <x-form.button type="submit" primary class="w-full border-0" right-icon="arrow-right">
                        Ingresar al sistema
                    </x-form.button>
                </form>

                <div class="ls__sep"><span>Seguridad</span></div>

                <div class="ls__security">
                    <svg class="ls__security-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    <p>Panel exclusivo para administradores y personal autorizado</p>
                </div>

                <p class="ls__footer">
                    © {{ date('Y') }} Talentus &nbsp;&mdash;&nbsp; Todos los derechos reservados
                </p>
            </div>
        </main>

    </div>
</x-guest-layout>
