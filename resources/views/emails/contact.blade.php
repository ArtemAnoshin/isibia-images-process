<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Новое сообщение с лендинга</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #1a202c;
            background: #f7fafc;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .header {
            border-bottom: 3px solid #f59e0b;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #1a202c;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: 600;
            color: #4a5568;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .field-value {
            font-size: 16px;
            color: #2d3748;
            background: #f7fafc;
            padding: 12px 16px;
            border-radius: 6px;
            border-left: 4px solid #f59e0b;
        }
        .meta {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 13px;
            color: #718096;
        }
        .meta p {
            margin: 4px 0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: #a0aec0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📩 Новое сообщение с лендинга</h1>
            <p style="color: #718096; margin-top: 4px;">От </p>
        </div>

        <div class="field">
            <div class="field-label">👤 Имя</div>
            <div class="field-value">{{ $userName }}</div>
        </div>

        <div class="field">
            <div class="field-label">📱 Контакт (email)</div>
            <div class="field-value">{{ $userEmail }}</div>
        </div>

        <div class="field">
            <div class="field-label">💬 Сообщение</div>
            <div class="field-value" style="white-space: pre-wrap;">{{ $userMessage }}</div>
        </div>

        <div class="meta">
            <p>🌐 IP: {{ $ip ?? 'Не определен' }}</p>
            <p>🖥️ User Agent: {{ $userAgent ?? 'Не определен' }}</p>
            <p>📅 Время: {{ now()->format('d.m.Y H:i:s') }}</p>
        </div>

        <div class="footer">
            <p>Это письмо отправлено автоматически с лендинга Артема Аношина</p>
        </div>
    </div>
</body>
</html>
