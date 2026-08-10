<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Артем Аношин — Full‑stack разработчик</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
    <style>
        /* ===== RESET & BASE ===== */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --dark: #0b1120;
            --dark-card: #131e33;
            --gray-text: #94a3b8;
            --light: #f1f5f9;
            --accent: #f59e0b;
            --accent-hover: #d97706;
            --border-color: #1e2a45;
            --radius: 16px;
            --transition: 0.3s ease;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--dark);
            color: var(--light);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 24px;
        }

        img {
            max-width: 100%;
            display: block;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* ===== TYPOGRAPHY ===== */
        h1 {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        h2 {
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 700;
            letter-spacing: -0.01em;
            margin-bottom: 32px;
        }

        h2 .highlight {
            color: var(--accent);
        }

        .subtitle {
            font-size: clamp(1rem, 1.2vw, 1.2rem);
            color: var(--gray-text);
            font-weight: 500;
            margin-bottom: 20px;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            display: inline-block;
            background: var(--accent);
            color: var(--dark);
            font-weight: 700;
            font-size: 1rem;
            padding: 14px 36px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            letter-spacing: 0.3px;
            box-shadow: 0 4px 20px rgba(245, 158, 11, 0.25);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(245, 158, 11, 0.35);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* ===== SECTION SPACING ===== */
        section {
            padding: 72px 0;
        }

        /* ============================================================
                   HERO (Первый экран)
                   ============================================================ */
        .hero {
            padding: 60px 0 40px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: radial-gradient(ellipse at 70% 20%, #1a2a4a 0%, var(--dark) 70%);
        }

        .hero-wrapper {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 48px;
            align-items: center;
        }

        .hero-photo {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-photo img {
            width: 100%;
            max-width: 400px;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--accent);
            box-shadow: 0 0 60px rgba(245, 158, 11, 0.15);
            transition: var(--transition);
        }

        .hero-photo img:hover {
            transform: scale(1.01);
            box-shadow: 0 0 80px rgba(245, 158, 11, 0.25);
        }

        .hero-text .usp {
            font-size: 1.05rem;
            color: var(--gray-text);
            margin: 20px 0 28px 0;
            max-width: 520px;
        }

        /* Технологические тэги */
        .tech-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 16px 0 8px 0;
        }

        .tech-tags span {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-color);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--gray-text);
            letter-spacing: 0.2px;
            transition: var(--transition);
        }

        .tech-tags span:hover {
            background: rgba(245, 158, 11, 0.12);
            border-color: var(--accent);
            color: var(--light);
        }

        /* ============================================================
                   КОМПЕТЕНЦИИ
                   ============================================================ */
        .competencies {
            background: var(--dark-card);
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .grid-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }

        .comp-item {
            background: rgba(255, 255, 255, 0.03);
            padding: 28px 30px;
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .comp-item:hover {
            border-color: var(--accent);
            transform: translateY(-4px);
            background: rgba(245, 158, 11, 0.04);
        }

        .comp-item h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--light);
        }

        .comp-item p {
            color: var(--gray-text);
            font-size: 0.95rem;
        }

        /* ============================================================
                   ОПЫТ (КЕЙСЫ)
                   ============================================================ */
        .experience {
            background: var(--dark);
        }

        .exp-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .exp-list li {
            background: rgba(255, 255, 255, 0.02);
            padding: 20px 28px;
            border-radius: var(--radius);
            border-left: 4px solid var(--accent);
            font-size: 1rem;
            color: var(--gray-text);
            transition: var(--transition);
        }

        .exp-list li:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(6px);
        }

        .exp-list li strong {
            color: var(--light);
            font-weight: 600;
        }

        /* ============================================================
                   СТЕК (БЕЙДЖИ)
                   ============================================================ */
        .tech-stack {
            background: var(--dark-card);
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .stack-group {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .badge {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            padding: 10px 24px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--gray-text);
            transition: var(--transition);
            letter-spacing: 0.2px;
        }

        .badge:hover {
            background: rgba(245, 158, 11, 0.12);
            border-color: var(--accent);
            color: var(--light);
            transform: translateY(-2px);
        }

        /* ============================================================
                   КОНТАКТЫ / ФОРМА
                   ============================================================ */
        .contact {
            background: var(--dark);
        }

        .contact p {
            color: var(--gray-text);
            margin-bottom: 28px;
            font-size: 1.05rem;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            max-width: 560px;
        }

        .contact-form input,
        .contact-form textarea {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 20px;
            font-family: inherit;
            font-size: 1rem;
            color: var(--light);
            transition: var(--transition);
            outline: none;
        }

        .contact-form input::placeholder,
        .contact-form textarea::placeholder {
            color: var(--gray-text);
            opacity: 0.6;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.07);
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.08);
        }

        .contact-form textarea {
            resize: vertical;
            min-height: 120px;
        }

        .contact-form .btn-primary {
            align-self: flex-start;
            margin-top: 8px;
        }

        .social-links {
            margin-top: 32px;
            font-size: 1rem;
            color: var(--gray-text);
        }

        .social-links a {
            color: var(--gray-text);
            font-weight: 500;
            transition: var(--transition);
            border-bottom: 1px solid transparent;
        }

        .social-links a:hover {
            color: var(--accent);
            border-bottom-color: var(--accent);
        }

        /* ============================================================
                   FOOTER
                   ============================================================ */
        .footer {
            padding: 32px 0;
            border-top: 1px solid var(--border-color);
            text-align: center;
            font-size: 0.85rem;
            color: var(--gray-text);
            opacity: 0.6;
        }

        /* ============================================================
                   ADAPTIVE (Mobile First)
                   ============================================================ */
        @media (max-width: 992px) {
            .hero-wrapper {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-photo img {
                max-width: 260px;
            }

            .hero-text .usp {
                margin-left: auto;
                margin-right: auto;
            }

            .tech-tags {
                justify-content: center;
            }

            .contact-form .btn-primary {
                align-self: center;
            }

            .contact-form {
                margin: 0 auto;
            }

            .contact {
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            section {
                padding: 48px 0;
            }

            .hero {
                padding: 32px 0;
                min-height: auto;
            }

            .grid-2col {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .comp-item {
                padding: 20px 24px;
            }

            .exp-list li {
                padding: 16px 20px;
                font-size: 0.92rem;
            }

            .badge {
                padding: 6px 16px;
                font-size: 0.78rem;
            }

            .contact-form .btn-primary {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .hero-photo img {
                max-width: 200px;
            }

            .tech-tags span {
                font-size: 0.7rem;
                padding: 4px 12px;
            }

            .btn-primary {
                padding: 12px 28px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    <!-- ============================================================
    HERO — ПЕРВЫЙ ЭКРАН
    ============================================================ -->
    <section class="hero">
        <div class="container">
            <div class="hero-wrapper">

                <!-- ФОТО -->
                <div class="hero-photo">
                    <!-- Замени src на путь к своему фото -->
                    <img src="{{ asset('images/artem-main-image.jpg') }}" alt="Артем Аношин — Full‑stack разработчик" />
                </div>

                <!-- ТЕКСТ -->
                <div class="hero-text">
                    <h1>Артем Аношин</h1>
                    <p class="subtitle">Full‑stack разработчик · 12 лет коммерческого опыта</p>

                    <div class="tech-tags">
                        <span>PHP / Laravel / Yii2</span>
                        <span>Wordpress / Opencart</span>
                        <span>VueJs / Nuxt</span>
                        <span>Docker / Redis</span>
                        <span>RabbitMQ</span>
                        <span>MySQL / PostgreSQL</span>
                    </div>

                    <p class="usp">
                        Развиваю, улучшаю проекты любой сложности.
                        Гибкие форматы сотрудничества — part-time, full-time.
                    </p>

                    <a href="#contact" class="btn-primary">Обсудить проект →</a>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================
    КОМПЕТЕНЦИИ
    ============================================================ -->
    <section class="competencies">
        <div class="container">
            <h2>Как я решаю задачи заказчика</h2>
            <div class="grid-2col">
                <div class="comp-item">
                    <h3>📐 Системный подход</h3>
                    <p>Как системный аналитик проектирую ТЗ и архитектуру так, чтобы не переделывать дважды.</p>
                </div>
                <div class="comp-item">
                    <h3>🔧 Техническая экспертиза</h3>
                    <p>Сайты любой сложности PHP и Javascript. Точечный и безопасный рефакторинг, легко работаю с legacy.</p>
                </div>
                <div class="comp-item">
                    <h3>🤝 Усиление команды</h3>
                    <p>Подключаю дизайнеров, SEO‑специалистов и программистов, когда нужен комплексный результат.</p>
                </div>
                <div class="comp-item">
                    <h3>⏳ Гибкие форматы</h3>
                    <p>Работаю почасово или попроектно. Поддержка, доработка или старт с нуля — выбираете вы.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
    ОПЫТ (КЕЙСЫ)
    ============================================================ -->
    <section class="experience">
        <div class="container">
            <h2>Ключевые проекты</h2>
            <ul class="exp-list">
                <li>
                    <strong>Whitewill (элитная недвижимость):</strong> спроектировал билдер лендингов для маркетинга, оптимизировал выгрузку объектов на дочерние сайты, реализовал мультиязычность и мультидоменность.
                </li>
                <li>
                    <strong>CleanTalk (SaaS):</strong> разрабатывал плагины для security-решений, развивал CRM для клиентов, проектировал API для doBoard (стартап проект).
                </li>
                <li>
                    <strong>Умназия (EdTech):</strong> разрабатывал функционал уроков, статистику по прогрессу для учеников, дашборды и лендинги.
                </li>
                <li>
                    <strong>Агентства + фриланс:</strong> более 100 проектов — интернет‑магазины, конфигураторы, блоги, интеграции с API и многое другое.
                </li>
            </ul>
        </div>
    </section>

    <!-- ============================================================
    СТЕК ТЕХНОЛОГИЙ
    ============================================================ -->
    <section class="tech-stack">
        <div class="container">
            <h2>Мой стек</h2>
            <div class="stack-group">
                <span class="badge">PHP 7.x / 8.x</span>
                <span class="badge">Laravel</span>
                <span class="badge">Yii2</span>
                <span class="badge">Symfony</span>
                <span class="badge">WordPress</span>
                <span class="badge">Vue.js</span>
                <span class="badge">Nuxt</span>
                <span class="badge">JavaScript (ES6+)</span>
                <span class="badge">MySQL</span>
                <span class="badge">PostgreSQL</span>
                <span class="badge">Redis</span>
                <span class="badge">Docker</span>
                <span class="badge">RabbitMQ</span>
                <span class="badge">REST API</span>
                <span class="badge">SOLID</span>
                <span class="badge">Git / CI/CD</span>
            </div>
        </div>
    </section>

    <!-- ============================================================
    КОНТАКТЫ И ФОРМА
    ============================================================ -->
    <section id="contact" class="contact">
        <div class="container">
            <h2>Давайте обсудим <span class="highlight">ваш проект</span></h2>
            <p>Напишите — я отвечу оперативно. Работаю с юридическими и физическими лицами.</p>

            <!-- Вывод flash-сообщений -->
            @if(session('success'))
                <div class="alert alert-success" style="background: rgba(245, 158, 11, 0.15); border: 1px solid #f59e0b; color: #f59e0b; padding: 16px 24px; border-radius: 12px; max-width: 560px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error" style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #ef4444; padding: 16px 24px; border-radius: 12px; max-width: 560px; margin-bottom: 20px;">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error" style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #ef4444; padding: 16px 24px; border-radius: 12px; max-width: 560px; margin-bottom: 20px;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form class="contact-form" action="{{ route('contact.send') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Ваше имя" value="{{ old('name') }}" required />
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                <textarea name="message" rows="4" placeholder="Кратко опишите задачу или идею" required>{{ old('message') }}</textarea>
                <button type="submit" class="btn-primary">Отправить →</button>
            </form>

            <div class="social-links">
                <a href="https://t.me/artem_anoshin" target="_blank" rel="noopener noreferrer">Telegram</a> &middot;
                <a href="mailto:artem.anoshin@gmail.com">Email</a>
            </div>
        </div>
    </section>

    <!-- ============================================================
    FOOTER
    ============================================================ -->
    <div class="footer">
        <div class="container">
            &copy; {{ date('Y') }} Артем Аношин. Все права защищены.
        </div>
    </div>

</body>
</html>
