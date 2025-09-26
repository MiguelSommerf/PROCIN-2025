<?php

namespace App\Services;

use Config\Email as EmailConfig;

class EmailService
{
    protected $email;
    protected $config;

    const TEMPLATE_BEM_VINDO = 'bem_vindo';
    const TEMPLATE_CONFIRMAR_CADASTRO = 'confirmar_cadastro';

    public function __construct()
    {
        $this->config = new EmailConfig();
        $this->email = \Config\Services::email();
    }

    // Esse método é responsável por setar a configuração do email.
    protected function setConfig(): void
    {
        $defaultConfig = [
            'protocol'   => $this->config->protocol,
            'SMTPHost'   => $this->config->SMTPHost,
            'SMTPUser'   => $this->config->SMTPUser,
            'SMTPPass'   => $this->config->SMTPPass,
            'SMTPPort'   => $this->config->SMTPPort,
            'SMTPCrypto' => $this->config->SMTPCrypto,
            'mailType'   => $this->config->mailType,
            'charset'    => $this->config->charset,
            'wordWrap'   => $this->config->wordWrap,
            'validate'   => $this->config->validate,
        ];

        $this->email->initialize($defaultConfig);
    }

    // Esse método é responsável pelo envio do email.
    public function sendEmail(array $opcoes): bool
    {
        try {
            // Usa as configurações padrão
            $this->setConfig();

            // Define quem está enviando (O padrão é o nosso email e nome do config/email.php)
            $this->email->setFrom(
                $opcoes['from_email'] ?? $this->config->fromEmail,
                $opcoes['from_nome'] ?? $this->config->fromName
            );

            // Define para quem o email vai ser enviado, o assunto e a mensagem
            $this->email->setTo($opcoes['email_para']);
            $this->email->setSubject($opcoes['assunto']);
            $this->email->setMessage($opcoes['mensagem']);

            // Define o reply_to se for especificado
            if (isset($opcoes['responder_para'])) {
                $this->email->setReplyTo(
                    $opcoes['responder_para']['email'],
                    $opcoes['responder_para']['nome'] ?? ''
                );
            }

            // Faz o envio
            if ($this->email->send()) {
                log_message('info', 'Email enviado com sucesso: ' . (is_array($opcoes['email_para']) ? implode(', ', $opcoes['email_para']) : $opcoes['email_para']));
                return true;
            } else {
                log_message('error', 'Falha ao enviar o Email: ' . $this->email->printDebugger(['headers']));
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'Erro de envio de Email: ' . $e->getMessage());
            return false;
        }
    }

    // Esse método é o que nós vamos usar para enviar emails usando os templates.
    public function sendTemplate(string $template, string $para, array $data = [], array $opcoes = []): bool
    {
        $mensagem = $this->renderTemplate($template, $data);
        
        $opcoesPadrao = [
            'email_para' => $para,
            'assunto' => $data['assunto'] ?? 'Notificação',
            'mensagem' => $mensagem,
        ];
        
        $opcoesFinal = array_merge($opcoesPadrao, $opcoes);
        
        return $this->sendEmail($opcoesFinal);
    }

    // Esse método renderiza o template.
    protected function renderTemplate(string $template, array $data): string
    {
        $viewPath = "emails/{$template}";
        return view($viewPath, $data);
    }

    // Para enviar mensagens simples
    public function sendQuick(string $para, string $assunto, string $mensagem): bool
    {
        return $this->sendEmail([
            'email_para' => $para,
            'assunto' => $assunto,
            'mensagem' => $mensagem
        ]);
    }
}