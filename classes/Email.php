<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
require_once $_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php';

class Email extends PHPMailer {

    /**
     * singleton
     */
    private static $instance;
    private $mensagem;
    private $verificationLink;

    public function __construct() {
        
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $c = __CLASS__; //get class name
            self::$instance = new $c; //create new instance
        }
        return self::$instance;
    }

    public function config() {
        $this->IsSMTP();
        $this->Host = "smtp.pfdimension.com.br";
        $this->SMTPAuth = true;
        $this->Username = 'no-reply@pfdimension.com.br';
        $this->Password = '@#Dim.2015';
        $this->FromName = 'Dimension - Métricas';
        $this->IsHTML(true);
        $this->From = 'no-reply@pfdimension.com.br';
        $this->Sender = 'no-reply@pfdimension.com.br';
        $this->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    }

    public function enviar() {
        $this->setBody();
        $envio = $this->Send();
        $this->ClearAllRecipients();
        $this->ClearAttachments();
        return $envio;
    }

    public function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    public function setVerificationLink($verificationLink) {
        $this->verificationLink = $verificationLink;
    }

    public function setBody() {
        $this->Body = ''
                . '<h4 style="display:inline;">Dimension - Análise, Medição e Planejamento</h4><br />'
                . '<font style="font-size:10px;">Comunicação e encaminhamento de emails</font>'
                . '<hr>'
                . '<div style="padding:30px;">'
                . $this->mensagem
                . '</div>'
                . '<hr>'
                . '<center>Copyright &copy; 2014-' . date('Y') . ' Dimension Software LTDA. Todos os direitos reservados. Verifique a autenticidade deste email clicando <a href="http://pfdimension.com.br/pf/api/json_verifica_link_email.php?l=' . $this->verificationLink . '">aqui</a>.';
        $this->AltBody = $this->Body;
    }

    /**
     * 
     * @param string $param
     */
    public function setEmail($param) {
        //adiciona a lista de emails
        for ($x = 0; $x < count($param['emails']); $x++) {
            $this->AddAddress($param['emails'][$x]);
        }
        //seta o subject da mensagem
        $this->Subject = $param['subject'];
        //seta a mensagem do email
        $this->setMensagem($param['mensagem']);
        //seta o texto da mensagem (Body)
        $this->setBody($param['mensagem']);
        //seta o verification code e adiciona no banco
        $this->setVerificationLink($param['verificationLink']);
        //seta o charset
        $this->CharSet = 'utf-8';
    }

}
