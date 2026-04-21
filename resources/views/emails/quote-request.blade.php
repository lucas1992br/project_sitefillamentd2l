<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Solicitação de Orçamento</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f1f5f9; margin: 0; padding: 24px; color: #1e293b; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: #0f172a; padding: 28px 32px; }
        .header h1 { color: #ffffff; font-size: 20px; margin: 0 0 4px; }
        .header p { color: #60a5fa; font-size: 13px; margin: 0; }
        .body { padding: 32px; }
        .label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #64748b; margin-bottom: 4px; }
        .value { font-size: 15px; color: #1e293b; margin-bottom: 20px; }
        .message-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; font-size: 14px; line-height: 1.6; color: #334155; margin-bottom: 20px; white-space: pre-wrap; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 32px; font-size: 12px; color: #94a3b8; text-align: center; }
        .divider { height: 1px; background: #e2e8f0; margin: 24px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nova Solicitação de Orçamento</h1>
            <p>D2L — Soluções Metálicas</p>
        </div>
        <div class="body">
            <div class="label">Nome</div>
            <div class="value">{{ $senderName }}</div>

            <div class="label">E-mail</div>
            <div class="value"><a href="mailto:{{ $senderEmail }}" style="color:#3b82f6;">{{ $senderEmail }}</a></div>

            @if($phone)
            <div class="label">Telefone</div>
            <div class="value">{{ $phone }}</div>
            @endif

            <div class="label">Empresa</div>
            <div class="value">{{ $company }}</div>

            <div class="label">Serviço Solicitado</div>
            <div class="value">{{ $service }}</div>

            <div class="divider"></div>

            <div class="label">Detalhes do Projeto</div>
            <div class="message-box">{{ $messageBody }}</div>
        </div>
        <div class="footer">
            Este e-mail foi enviado automaticamente pelo formulário de contato do site D2L.
        </div>
    </div>
</body>
</html>
