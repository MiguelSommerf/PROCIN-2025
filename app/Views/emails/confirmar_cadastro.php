<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f4f4f4; padding: 10px; text-align: center; }
        .conteudo { padding: 20px; }
        .footer { background: #f4f4f4; padding: 10px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Confirme o seu cadastro</h1>
        </div>
        <div class="conteudo">
            <p>Olá, <?= $nome ?>,</p>
            <p>Insira esse código para confirmar que é você:</p>
            <p>000000</p>
            <p>Se não foi você, ignore este e-mail.</p>
        </div>
        <div class="footer">
            <p>Atenciosamente,</p>
            <p>SOMA</p>
        </div>
    </div>
</body>
</html>