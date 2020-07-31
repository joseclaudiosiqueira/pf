<?php
/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER ['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dimension&reg; - login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--facebook tags-->
        <meta property="og:locale" content="en_US">
        <meta property="og:title" content="Dimension - An&aacute;lise, medi&ccedil;&atilde;o e planejamento, pontos de teste, requisitos n&atilde;o-funcionais">
        <meta property="og:site_name" content="Dimension">
        <meta property="og:description" content="Integre CONTRATANTES, FORNECEDORES e &Oacute;RG&Atilde;OS DE CONTROLE e facilite os trabalhos de valida&ccedil;&atilde;o externa (Cliente) e auditoria externa (&Oacute;rg&atilde;os de controle). Bom porque elimina pap&eacute;is e fluxos desnecess&aacute;rios na sua empresa e melhor ainda porque facilita o trabalho dos seus Clientes e Auditores. Trabalhe em um ambiente colaborativo, onde o lema é agilizar seus processos.">
        <meta property="og:image" content="https://pfdimension.com.br/pf/img/logo_200px.png" alt="Logomarca Dimension">
        <meta property="og:image:type" content="image/jpeg">
        <meta property="og:image:width" content="640">
        <meta property="og:image:height" content="480">
        <meta property="og:type" content="website">
        <!--end-->
        <!--meta padrao-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Dimension - An&aacute;lise, medi&ccedil;&atilde;o e planejamento, pontos de teste, requisitos não-funcionais">
        <meta name="author" content="Dimension">
        <link rel="icon" href="/pf/img/favicon.ico">
        <!--end-->
        <!--icon-->
        <link rel="icon" type="image/png" href="/pf/img/favicon.ico">
        <!--end-->
        <!--stylesheets login clean-->
        <link rel="stylesheet" type="text/css" href="/pf/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/pf/login/css/util.css">
        <link rel="stylesheet" type="text/css" href="/pf/login/css/main.css">
        <!--end-->
        <!--stylesheets dimension-->
        <link rel="stylesheet" type="text/css" href="/pf/css/vendor/bootstrap/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/pf/css//vendor/sweetalert/sweetalert.css">
        <link rel="stylesheet" type="text/css" href="/pf/css/dimension.css">
        <link rel="stylesheet" type="text/css" href="/pf/js/vendor/semantic-ui/semantic.css">
        <link rel="stylesheet" type="text/css" href="/pf/js/vendor/semantic-ui/components/label.css">
        <!--end-->
        <!--google fonts
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Marvel|Open+Sans+Condensed:300|Roboto+Condensed|Wire+One" />
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Oswald:200,300,400">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Abel">
        <!--end-->
        <!--meta tags de adaptacao aos navegadores-->
        <!-- icon in the highest resolution we need it for -->
        <link rel="icon" sizes="192x192" href="/pf/img/favicon.ico">
        <!-- reuse same icon for Safari -->
        <link rel="apple-touch-icon" href="/pf/img/favicon.ico">
        <!-- multiple icons for IE -->
        <meta name="msapplication-square310x310logo" content="/pf/img/favicon.ico">
        <!--for safari-->
        <link rel="apple-touch-icon" href="/pf/img/favicon.ico">
        <link rel="apple-touch-icon" sizes="76x76" href="/pf/img/favicon.ico">
        <link rel="apple-touch-icon" sizes="120x120" href="/pf/img/favicon.ico">
        <link rel="apple-touch-icon" sizes="152x152" href="/pf/img/favicon.ico">
        <!--ie e windows phone-->
        <meta name="msapplication-square70x70logo" content="/pf/img/favicon.ico">
        <meta name="msapplication-square150x150logo" content="/pf/img/favicon.ico">
        <meta name="msapplication-wide310x150logo" content="/pf/img/favicon.ico">        
        <!--inicializacao safari-->
        <link rel="apple-touch-startup-image" href="icon.png">
        <!--fim-->
        <style type="text/css">
            body {
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                /*font-family: 'Abel', sans-serif;*/
                overflow-x: hidden;
            }
            .oswald-extra-light {
                /*font-family: 'Oswald', sans-serif;*/
                font-weight: 400;
                font-size: 48px;
                color: #57b846;
            }            
        </style>
    </head>
    <body style="overflow-x: hidden;">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-t-40 p-b-20">
                    <form class="login100-form" method="post" role="form" id="form-login">
                        <input type="hidden" id="tipo-login" name="tipo-login" value="nuvem">
                        <input type="hidden" id="opcao-identificador" name="opcao-identificador" value="0"><?= NULL !== $url ? '<input type="hidden" id="url" value="' . $url . '">' : ''; ?>
                        <span class="login100-form-title p-b-40">
                            <img src="/pf/img/logo_200px.png" width="48" height="40" align="center" alt="Logomarca Dimension">&nbsp;&nbsp;&nbsp;Dimension
                        </span>                     
                        <span class="login100-form-avatar">
                            <img src="/pf/img/user.jpg" id="gravatar" alt="Foto do usuário">
                        </span>
                        <div class="wrap-input100 m-t-40 m-b-35">
                            <input class="input100" type="text" id="user_name" name="user_name" autocomplete="off" required autofocus>
                            <span class="focus-input100" data-placeholder="Login (se for o CPF apenas n&uacute;meros)"></span>
                        </div>
                        <div class="wrap-input100 m-b-50">
                            <input class="input100" type="password" name="user_password" id="user_password" required>
                            <span class="focus-input100" data-placeholder="Senha"></span>
                        </div>
                        <div class="m-b-50">
                            <select id="id_empresa" name="id_empresa" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;">
                                <option value="0">Selecione uma empresa</option>
                            </select>                            
                        </div>                        
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn" type="submit" name="login" id="login" aria-label="Login no sistema" disabled>
                                Acessar
                            </button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="login100-form-btn" name="refresh-login" id="button-refresh-login" value="" aria-label="Atualizar lista de empresas">
                                <i class="fa fa-refresh fa-lg"></i>
                            </button>                            
                        </div>
                        <div class="p-t-50">
                            <div class="m-t-10">
                                <span class="txt1"><img src="/pf/img/index-contato.png" width="24" height="24" align="center" alt="Entre em contato">&nbsp;&nbsp;Entre em</span>
                                <a href="#" data-toggle="modal" data-target="#modal-contato" class="txt2" id="link-modal-contato">Contato</a>
                            </div>
                            <div class="m-t-10">
                                <span class="txt1"><img src="/pf/img/criar-conta.png" width="24" height="24" align="center" alt="Crie uma conta">&nbsp;&nbsp;N&atilde;o tem uma conta?</span>
                                <a href="#" data-toggle="modal" data-target="#modal-nova-conta" class="txt2">Crie uma</a>
                            </div>
                            <div class="m-t-10">
                                <span class="txt1"><img src="/pf/img/index-esqueci-senha.png" width="24" height="24" align="center" class="txt1" alt="Esqueci a senha">&nbsp;&nbsp;Esqueceu a senha?</span>
                                <a href="/pf/DIM.Gateway.php?arq=7&tch=2&sub=4&dlg=0" class="txt2">Clique aqui</a>
                            </div>
                            <div class="m-t-10">
                                <span class="txt1"><img src="/pf/img/index-alterar-senha.png" width="24" height="24" align="center" alt="Alterar a senha">&nbsp;&nbsp;Quero alterar</span>
                                <a href="/pf/DIM.Gateway.php?arq=6&tch=2&sub=4&dlg=0" class="txt2">minha senha</a>
                            </div>
                            <div class="m-t-10">
                                <span class="txt1"><img src="/pf/img/index-privacidade.png" width="24" height="24" align="center" alt="politica de privacidade">&nbsp;&nbsp;Veja nossa</span>
                                <a href="#" data-toggle="modal" data-target="#form_modal_politica_privacidade" class="txt2">pol&iacute;tica de privacidade</a>
                            </div>
                            <div class="m-t-10">
                                <span class="txt1"><img src="/pf/img/seo-audit.png" width="24" height="24" align="center" alt="Termos & Condi&ccedil;&otilde;es">&nbsp;&nbsp;Aceite nossos</span>
                                <a href="#" data-toggle="modal" data-target="#modal-condicoes" class="txt2">Termos & Condi&ccedil;&otilde;es</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container" style="border: 1px dotted #d0d0d0; padding: 20px; border-radius: 10px;">
            <div class="row panel-default">
                <div class="col-md-2">
                    <img src="/pf/img/clipart_idea.png" class="img-responsive" alt="Informa&ccedil;&otilde;es importantes" />
                </div>
                <div class="col-md-10">
                    <div class="panel-title">
                        <p style="font-family: 'Wire One', sans-serif; font-size: 50px; font-weight: 400; display: inline;">Informa&ccedil;&otilde;es importantes</p>
                        <span class="sub-header"><p style="font-family: 'Roboto', sans-serif; font-size: 16px; font-weight: 400;">Leia abaixo o que estamos oferencendo.
                                Queremos nos tornar a maior comunidade de m&eacute;tricas do Brasil, reunindo Empresas, Desenvolvedores, Profissionais de M&eacute;tricas, 
                                &Oacute;rg&atilde;os P&uacute;blicos e Privados, Empresas de Treinamento, Certificadoras e Universidades.</p></span>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-4">
                    <p>O Dimension&reg; &eacute; <strong>Freeware</strong>, 
                        sua utiliza&ccedil;&atilde;o &eacute; gratuita.
                        Nosso lema &eacute; oferecer &agrave; comunidade de APF uma
                        solu&ccedil;&atilde;o robusta e simples para melhorar o trabalho dos
                        CONTRATANTES, CONTRATADOS e AUDITORIAS, sejam internas ou externas.
                    </p>
                </div>
                <div class="col-md-4">
                    <p>Para mantermos as pesquisas e as evolu&ccedil;&otilde;es
                        constantes, necessitamos de recursos. Esperamos que voc&ecirc; se
                        sensibilize, utilize o Sistema e o torne &uacute;til na sua
                        organiza&ccedil;&atilde;o, e com isso se sinta a vontade para
                        realizar uma doa&ccedil;&atilde;o.</p>
                </div>
                <div class="col-md-4" style="text-align: center;">
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_new">
                        <input type="hidden" name="cmd" value="_s-xclick" /> <input
                            type="hidden" name="hosted_button_id" value="BERX4QM3NU4J6" /> <input
                            type="image"
                            src="https://www.paypalobjects.com/pt_BR/BR/i/btn/btn_donateCC_LG.gif"
                            border="0" name="submit"
                            title="PayPal - The safer, easier way to pay online!"
                            alt="Faça doações com o botão do PayPal" /> <img alt="" border="0"
                            src="https://www.paypal.com/pt_BR/i/scr/pixel.gif" width="1"
                            height="1" />
                    </form>
                    <p>
                        <br /> A doa&ccedil;&atilde;o &eacute; feita de forma segura
                        atrav&eacute;s do PayPal&reg; e voc&ecirc; pode doar o valor que
                        quiser.<br /><br/>
                        <i class="fa fa-video-camera" style="color: #d0d0d0"></i>&nbsp;&nbsp;
                        Assista <a href="/pf/apresentacao/PF.ppsx" target="_new" class="txt2" alt="Apresenta&ccedil;&atilde;o do Dimension">a uma breve apresenta&ccedil;&atilde;o sobre o Dimension</a>.
                    </p>
                </div>
            </div>
        </div>
        <div class="row" style="padding: 30px;">
            <div class="container">
                <div class="col-md-4" style="text-align: center;">
                    <div class="panel-default">
                        <div class="panel-title">
                            <img src="/pf/img/dimension/of_icon_padro_1.png" alt="Padroniza&ccedil;&atilde;o">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Padroniza&ccedil;&atilde;o</font>
                        </div>
                    </div>
                    <font style="font-family: Poppins-Regular, sans-serif;">Diversos
                    padr&otilde;es de m&eacute;tricas comp&otilde;em a base do
                    Dimension&reg; - APF/IFPUG, SNAP<sup>*</sup>, APT<sup>*</sup>,
                    NESMA, FP-Lite&trade; COCOMO II.2000
                    </font>
                    <hr>
                    <small>Obs.: SNAP e APT est&atilde;o em fase final de
                        desenvolvimento, acreditamos que at&eacute; Dez/2019 esteja tudo
                        pronto. <img src="/pf/img/check.png" alt="Check"></small>
                </div>
                <div class="col-md-4" style="text-align: center;">
                    <div class="panel-default">
                        <div class="panel-title">
                            <img src="/pf/img/dimension/of_icon_ambiente_1.png" alt="Ambiente">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Ambiente</font>
                        </div>
                    </div>
                    <font style="font-family: Poppins-Regular, sans-serif;">Compartilhe suas
                    contagens com outros colaboradores e otimize o tempo de
                    elabora&ccedil;&atilde;o, entrega e faturamento.</font>
                    <hr>
                    <small>O Sistema oferece um m&oacute;dulo especial para treinamento e as contagens inseridas
                        pelos <kbd>alunos</kbd> s&atilde;o tratadas &agrave; parte.
                    </small>
                </div>
                <div class="col-md-4" style="text-align: center;">
                    <div class="panel-default">
                        <div class="panel-title">
                            <img src="/pf/img/dimension/of_icon_valida_1.png" alt="Valida&ccedil;&otilde;es">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Valida&ccedil;&otilde;es</font>
                        </div>
                    </div>
                    <font style="font-family: Poppins-Regular, sans-serif;">Sua contagem
                    estar&aacute; sempre dispon&iacute;vel para auditorias e
                    valida&ccedil;&otilde;es, sejam internas e/ou externas.</font>
                </div>
            </div>
        </div>
        <div class="row" style="padding: 30px;">
            <div class="container">
                <div class="col-md-4" style="text-align: center;">
                    <div class="panel-default">
                        <div class="panel-title">
                            <img src="/pf/img/dimension/of_icon_planej_1.png" alt="Planejamento">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Planejamento</font>
                        </div>
                    </div>
                    <font style="font-family: Poppins-Regular, sans-serif;">Fa&ccedil;a a
                    contagem e integre &agrave; sua rotina de trabalho, voc&ecirc;
                    dimensiona e j&aacute; tem um pr&eacute;-planejamento, configurando
                    as fases adequadas ao seu processo de desenvolvimento.</font>
                </div>
                <div class="col-md-4" style="text-align: center;">
                    <div class="panel-default">
                        <div class="panel-title">
                            <img src="/pf/img/dimension/of_icon_conheci_1.png" alt="Conhecimento">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Conhecimento</font>
                        </div>
                    </div>
                    <font style="font-family: Poppins-Regular, sans-serif;">Temos o objetivo de
                    auxiliar os gestores na tomada de decis&atilde;o, e para isto
                    pretendemos nos tornar refer&ecirc;ncia, montando a maior base de
                    conhecimento de m&eacute;tricas dispon&iacute;vel no mercado.</font>
                </div>
                <div class="col-md-4" style="text-align: center;">
                    <div class="panel-default">
                        <div class="panel-title">
                            <img src="/pf/img/dimension/of_icon_ajuda_1.png" alt="Ajuda on-line">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Ajuda on-line</font>
                        </div>
                    </div>
                    <font style="font-family: Poppins-Regular, sans-serif;">O Sistema possui
                    um mecanismo de ajuda, que orienta o usu&aacute;rio
                    durante a elabora&ccedil;&atilde;o das contagens. Foram
                    feitas in&uacute;meras pesquisas, garantindo a confiabilidade das
                    informa&ccedil;&otilde;es.</font>
                    <hr>
                    <small>As fontes s&atilde;o citadas no pr&oacute;prio Sistema.</small>
                </div>
            </div>
        </div>
        <div class="row" style="padding: 30px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <div class="panel-default">
                                    <div class="panel-title">
                                        <img src="/pf/img/dimension/of_icon_faq_1.png" alt="F&oacute;rum e Chat">
                                    </div>
                                    <div class="panel-body">
                                        <font class="oswald-extra-light">F&oacute;rum e Chat</font>
                                    </div>
                                </div>
                                <font style="font-family: Poppins-Regular, sans-serif;">Utilize o 
                                F&oacute;rum e o chat (on-line) para retirar d&uacute;vidas
                                t&eacute;cnicas sobre o produto.</font>
                                <hr>
                                <small>Thanks to <a href="https://codoforum.com/" target="_new" class="txt2">Codoforum</a>
                                    - For now we are using the free module ;-)
                                </small>
                            </div>
                        </div>
                        <br /><br />
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <div class="panel-default">
                                    <div class="panel-title">
                                        <img src="/pf/img/dimension/of_icon_config_1.png" alt="Configura&ccedil;&atilde;o">
                                    </div>
                                    <div class="panel-body">
                                        <font class="oswald-extra-light">Configura&ccedil;&atilde;o</font>
                                    </div>
                                </div>
                                <font style="font-family: Poppins-Regular, sans-serif;">
                                Elabore o seu roteiro, configure seu processo e insira no sistema, <strong>isso
                                    &eacute; flexibilidade</strong>.
                                </font>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12" style="border: 0px solid #28aadc; padding-left: 50px; padding-right: 50px;">
                                <div class="panel-title">
                                    <p style="font-family: 'Wire One', sans-serif; font-size: 50px; font-weight: 700; display: inline;">Dimension</p>
                                    <span class="sub-header"><p style="font-family: 'Roboto', sans-serif; font-size: 16px; font-weight: 400;">Utilize o que h&aacute; de melhor em termos
                                            de processo, an&aacute;lise e gest&atilde;o, com um sistema humanizado, &aacute;gil e f&aacute;cil de usar</p></span>
                                </div>                    
                                <img src="/pf/img/telas_index.png" class="img-responsive img-rounded" alt="Telas do sistema" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <br />
        <div class="row">
            <div class="col-md-12">
                <div class="container">
                    <div class="panel-default">
                        <div class="panel-title">
                            <i class="fa fa-map-marker fa-lg"></i>&nbsp&nbsp;Refer&ecirc;ncia de valor dos Pontos de Fun&ccedil;&atilde;o nos contratos registrados no sistema.<br />
                            Mais informa&ccedil;&otilde;es em:&nbsp;
                            <a href="http://www.fattocs.com/pt/faq-14.html" target="_new" alt="Valor do ponto de fun&ccedil;&atilde;o - FATTO" class="txt2"><strong>FAQ - Fatto Consultoria</strong></a> ou 
                            <a href="https://docplayer.com.br/13499465-Quanto-pagar-por-um-ponto-de-funcao.html" target="_new" alt="Quanto pagar por um ponto de fun&ccedil;&atilde;o" class="txt2"><strong>Quanto pagar por um ponto de fun&ccedil;&atilde;o</strong></a>.
                            <br />
                            <span class="sub-header">Aqui voc&ecirc; encontrar&aacute; informa&ccedil;&otilde;es importantes para a tomada de decisão. Confira os valores m&eacute;dios dos contratos de pontos de fun&ccedil;&atilde;o registrados no Dimension por Estado.</span>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="map" style="width: 100%; height: 700px; border-radius: 10px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <br />
        <div class="row" style="padding: 50px;">
            <div class="container">
                <div class="col-md-5">
                    <img src="/pf/img/dimension/vetor_ecossistema.png"
                         class="img-responsive" alt="Ecosistema Dimension">
                </div>
                <div class="col-md-7">
                    <h3 class="oswald-extra-light">J&Aacute; IMAGINOU O P&Uacute;BLICO E
                        O PRIVADO TRABALHANDO JUNTOS NO MESMO ECOSSISTEMA?</h3>
                    <p align="justify" style="text-shadow: 0px 1px 1px #fff;">
                        No Dimension&reg; isto &eacute; poss&iacute;vel.<br /> <br />
                        Nosso software integra CONTRATANTES, FORNECEDORES e
                        &Oacute;RG&Atilde;OS DE CONTROLE facilitando os trabalhos de
                        valida&ccedil;&atilde;o externa (Cliente) e auditoria externa
                        (&Oacute;rg&atilde;os de controle), bom porque elimina
                        pap&eacute;is e fluxos desnecess&aacute;rios na sua empresa e
                        melhor ainda porque facilita o trabalho dos seus Clientes e
                        Auditores. Tudo na nuvem! Livre-se de ter que arcar com
                        infraestrutura e equipe dedicada a manter o sistema no ar.<br /> <br />
                        E ainda tem mais, nosso sistema j&aacute; vem com os Roteiros de
                        M&eacute;tricas do SISP (2.0, 2.1, 2.2* e o Guia para contagem de
                        projetos Data Warehouse 1.0) por padr&atilde;o. Veja mais detalhes
                        clicando <a href="http://www.sisp.gov.br/" target="_new" class="txt2" alt="P&aacute;gina do SISP">aqui para ir &agrave; p&aacute;gina do SISP</a>.
                        Mas n&atilde;o se limite a isso, configure o seu roteiro de acordo
                        com o Contrato celebrado.
                    </p>
                </div>
            </div>
        </div>
        <hr>
        <div class="row" style="min-height: 350px; background-color: rgb(255, 255, 255); padding: 50px;">
            <div class="container">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="/pf/img/dimension/logo_cinza.png" class="img-responsive" alt="Logomarca Dimension "/><br /><br />
                            <img src="/pf/img/dimension/freeware-free-software-computer-software-shareware.jpg" class="img-responsive" alt="Licen&ccedil;a freeware" />
                        </div>
                        <div class="col-md-8">
                            <p align="justify" style="font-size: 80%;">
                                O software est&aacute; disponibilizado em nuvem como SaaS - <i>Software-as-a-Service</i>.
                                Tudo necess&aacute;rio - servidores,
                                conectividade, equipe de manuten&ccedil;&atilde;o e
                                seguran&ccedil;a - fica sob nossa responsabilidade. Nossos
                                clientes apenas utilizam o servi&ccedil;o oferecido, e a forma 
                                de licenciamento &eacute; freeware. Veja condi&ccedil;&otilde;es na
                                nossa Pol&iacute;tica de Privacidade e no Termo de Servi&ccedil;o
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6" style="color: #016DC5;">
                            <ul class="fa-ul">
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;Medi&ccedil;&otilde;es
                                    Estimativas/Indicativas e Projetos</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;APT - An&aacute;lise
                                    de Pontos de Teste</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;EF - Elementos
                                    Funcionais*</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;Armazenamento de
                                    Arquivos</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;Diret&oacute;rio
                                    P&uacute;blico de contagens</li>
                            </ul>
                        </div>
                        <div class="col-md-6" style="color: #016DC5;">
                            <ul class="fa-ul">
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;Dashboard Gerencial</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;Valida&ccedil;&otilde;es
                                    e Auditorias (internas e externas)</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;Planejamento
                                    (SISP/Capers Jones, COCOMO)</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;Trabalho em Equipe</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;Edi&ccedil;&otilde;es
                                    Colaborativas</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 txt1"
                             style="padding-left: 42px; padding-top: 15px;">
                            * Trata-se de uma nova m&eacute;trica de software de tamanho
                            funcional derivada da An&aacute;lise de Pontos de
                            Fun&ccedil;&atilde;o (APF). Para maiores detalhes leia o artigo <a
                                href="/pf/docs/Uma%20metrica%20de%20tamanho%20de%20software%20como%20ferramenta%20para%20a%20governanca%20de%20TI.pdf"
                                target="_new" class="txt2">Uma m&eacute;trica de tamanho de software como
                                ferramenta para a governan&ccedil;a de TI</a> ou veja 
                            <a href="/pf/docs/Marcus%20Vinicius%20Borela%20de%20Castro.ppt"
                               target="_new" class="txt2">esta apresenta&ccedil;&atilde;o</a>.<br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row" style="min-height: 350px; background-color: rgb(255, 255, 255); padding: 50px;">
            <div class="container">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            O Sistema foi constitu&iacute;do tendo como <strong>refer&ecirc;ncia</strong>
                            uma base de conhecimento encontrada nas mais diversas
                            fontes, independente de serem marcas comerciais, sem fins
                            lucrativos e/ou &oacute;rg&atilde;os p&uacute;blicos, por isto <strong>achamos
                                justo</strong> citar essa valorosa contribui&ccedil;&atilde;o
                            para a comunidade de m&eacute;tricas, desta forma, s&atilde;o
                            cita&ccedil;&otilde;es comuns no software Dimension&reg;:
                        </div>
                    </div>
                    <div class="row">
                        <br />
                        <div class="col-md-2">
                            <img src="/pf/img/logo_tcu.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Tribunal de Contas da Uni&atilde;o">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/sisp.jpg" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Sisp">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/nesma.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Nesma">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/ifpug.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="IFPUG">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/fplite.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="FP-Lite">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-bnb.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Banco do Nordeste">
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <br />
                        <div class="col-md-2">
                            <img src="/pf/img/logo-serpro.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Serpro">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/bfpug.jpg" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="BFPUG">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/timetricas.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="TIMeticas">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/wb-logo.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Winbid">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo_fatto.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Fatto">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-dataprev.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Dataprev">
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-2">
                            <img src="/pf/img/logo-anvisa.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Anvisa">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-abrantes.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Abrantes">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-rfb.jpg" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Receita Federal do Brasil">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-aneel.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Aneel">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-caixa.jpg" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Caixa Econ&ocirc;mica Federal">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-cocomo.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="COCOMO II.2000">
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-2">
                            <img src="/pf/img/logo_4devs.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="4devs">                            
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/api.cep.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;" alt="Api.CEP">                            
                        </div>                    
                    </div>
                    <br /> .............................
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="fa-ul">
                                <li><sup>1</sup> As marcas registradas, logomarcas e
                                    siglas ou legendas pertencem aos seus detentores;</li>
                                <li><sup>2</sup> As marcas exibidas acima s&atilde;o <strong>referenciadas</strong>
                                    apenas pela coleta de informa&ccedil;&otilde;es sobre
                                    m&eacute;tricas e do conhecimento sobre o assunto. Sendo assim, <strong>n&atilde;o
                                        representam nem tampouco s&atilde;o Parceiras ou Clientes da
                                        Dimension&reg; e desde j&aacute; est&atilde;o eximidas de qualquer 
                                        obriga&ccedil;&atilde;o e/ou
                                        informa&ccedil;&atilde;o inserida dentro do sistema de
                                        m&eacute;tricas;</strong></li>
                                <li><sup>3</sup> Nossa pol&iacute;tica de privacidade define
                                    que <strong>n&atilde;o divulgaremos a terceiros</strong>
                                    quem s&atilde;o os nossos clientes, suas logomarcas, ou
                                    quaisquer outras informa&ccedil;&otilde;es que possam identific&aacute;-los;</li>
                                <li><sup>4</sup> Caso estejamos ferindo alguma pol&iacute;tica e
                                    queira retirar a logomarca do site, basta solicitar 
                                    <a href="#"
                                       data-toggle="modal" data-target="#modal-contato"
                                       class="button-contato txt2" alt="Excluir logomarca"><i class="fa fa-phone-square"></i>&nbsp;neste formul&aacute;rio</a>
                                    que imediatamente ser&aacute; feita a exclus&atilde;o.</li>
                                <li><sup>5</sup> O sistema Dimension foi desenvolvido por
                                    volunt&aacute;rios e &eacute; <i>Freeware</i>.

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="background-color: #016DC5; color: #fff; padding: 30px; padding-bottom: 20px;">
            <div class="col-md-8" style="border-right: 2px solid #fff; text-align: center;">
                <br /><br />Copyright &copy; 2014-<?= date('Y'); ?> Dimension&reg;. O conte&uacute;do deste site &eacute; de propriedade exclusiva da Dimension.<br /><br /><br />
            </div>
            <div class="col-md-4"><br />
                <span class="txt1">Siga-nos</span><br />
                <a href="//facebook.com/pfdimension" target="_new" class="txt2" alt="Facebook"><i class="fa fa-facebook-square fa-2x"></i></a>&nbsp;&nbsp;
                <a href="//twitter.com/pf_dimension" target="_new" class="txt2" alt="Twitter"><i class="fa fa-twitter-square fa-2x"></i></a>&nbsp;&nbsp;
                <i class="fa fa-instagram fa-2x"></i>&nbsp;&nbsp;
                <i class="fa fa-google-plus-square fa-2x"></i>&nbsp;&nbsp;
                <i class="fa fa-reddit-square fa-2x"></i>&nbsp;&nbsp;
                <i class="fa fa-pinterest-square fa-2x"></i>&nbsp;&nbsp;
            </div>
        </div>  
        <!--formularios dimension-->
        <?php include DIR_BASE . 'forms/index/form_modal_politica_privacidade.php'; ?>
        <?php include DIR_BASE . 'forms/index/form_modal_nova_conta.php'; ?>
        <?php include DIR_BASE . 'forms/index/form_modal_contato.php'; ?>
        <?php include DIR_BASE . 'forms/index/form_modal_condicoes.php'; ?>
        <!--end-->
        <!--scripts dimension-->
        <script type="text/javascript" src="/pf/js/vendor/jquery-1.11.3.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/vendor/bootstrap.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/vendor/sweetalert.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/vendor/jquery.mask.min.js?v=201705111850"></script>
        <!-- Dimension(c) scripts -->
        <script type="text/javascript" src="/pf/js/min/DIM.APIDIM.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/min/DIM.FRMLOG.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/min/index/DIM.FMOCONTA.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/min/index/DIM.FMONCONT.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/min/index/DIM.CPF.CNPJ.min.js?v=201705111850"></script>
        <!-- scripts da consultoria -->
        <script type="text/javascript" src="/pf/js/vendor/dimension/respond.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/vendor/dimension/responsiveslides.min.js?v=201705111850"></script>
        <!--jivo chat-->
        <script type='text/javascript'>
            (function () {
                var widget_id = 'aa8UDcAoxx';
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = '//code.jivosite.com/script/widget/' + widget_id;
                var ss = document.getElementsByTagName('script')[0];
                ss.parentNode.insertBefore(s, ss);
            })();
        </script>  
        <!--end-->
        <script src="/pf/login/js/main.min.js"></script>
        <!--end-->
        <script type="text/javascript">
            /*
             * apenas para ler os json
             */
            var tNow = new Date();
            var arrUF = ["AC", "AL", "AM", "AP", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RO", "RS", "RR", "SC", "SE", "SP", "TO"];
            var arrEstado = [
                'Acre',
                'Alagoas',
                'Amazonas',
                'Amapá',
                'Bahia',
                'Ceará',
                'Distrito Federal',
                'Espírito Santo',
                'Goiás',
                'Maranhão',
                'Mato Grosso',
                'Mato Grosso do Sul',
                'Minas Gerais',
                'Pará',
                'Paraíba',
                'Paraná',
                'Pernambuco',
                'Piauí',
                'Rio de Janeiro',
                'Rio Grande do Norte',
                'Rondônia',
                'Rio Grande do Sul',
                'Roraíma',
                'Santa Catarina',
                'Sergipe',
                'São Paulo',
                'Tocantins'
            ];
            /*
             * init map do google
             */
            function initMap() {
                var myLatLng = {lat: -15, lng: -56};
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: myLatLng,
                    scrollwheel: false,
                    zoom: 4
                });
                setMarkers(map);
            }

            function setMarkers(map) {
                /*
                 * get json index
                 */
                $.ajax({
                    url: '/pf/dashboard/index/valor.contrato.pf.json?v=' + tNow.getTime(),
                    dataType: 'json',
                    async: false,
                    success: function (json) {
                        for (x = 0; x < Object.keys(json).length; x++) {
                            tempEst = arrUF[x];
                            arrUF[x] =
                                    "<i class='fa fa-info-circle'></i>&nbsp;&nbsp;" + arrEstado[x] + "<div style='padding: 20px; line-height: 2em;'>" +
                                    "<strong>Valor em R$ dos PF contratados</strong><br />" +
                                    "<i class='fa fa-arrow-down'></i>&nbsp;Min.: R$ " + number_format(json[arrUF[x]]["MIN"], 2) + "<br />" +
                                    "<i class='fa fa-arrow-right'></i>&nbsp;M&eacute;d.: R$ " + number_format(json[arrUF[x]]["MED"], 2) + "<br />" +
                                    "<i class='fa fa-arrow-up'></i>&nbsp;M&aacute;x.: R$ " + number_format(json[arrUF[x]]["MAX"], 2) + "<hr>" +
                                    "<strong>Quantidade de contratos registrados no sistema:</strong> <label class='label-round label-success' style='display: inline;'>" + json[arrUF[x]]["QTD"] + "</label>";
                            /*
                             "<table class='table table-condensed table-striped'>" +
                             "<thead><tr><th colspan='2'>Top Five - Linguagens de Programa&ccedil;&atilde;o</th></tr></thead>" +
                             "<tbody>" +
                             "<tr><td>Java</td><td>R$ 456,77</td></tr>" +
                             "<tr><td>PHP</td><td>R$ 337,89</td></tr>" +
                             "<tr><td>Visual Basic</td><td>R$ 425,38</td></tr>" +
                             "<tr><td>ASP 3.x</td><td>R$ 658,49</td></tr>" +
                             "<tr><td>.NET</td><td>R$ 549,72</td></tr>" +
                             "<tr><td><strong>Contratos registrados</strong></td><td>31</td></tr>" +
                             "</tbody>" +
                             "</table>" +
                             "</div>";*/
                        }
                        /*
                         * coordenadas dos estados brasileiros
                         */
                        var coordenadasUF = [{"lat": -8.77, "lng": -70.55}, {"lat": -9.71, "lng": -35.73}, {"lat": -3.07, "lng": -61.66}, {"lat": 1.41, "lng": -51.77}, {"lat": -12.96, "lng": -38.51},
                            {"lat": -3.71, "lng": -38.54}, {"lat": -15.83, "lng": -47.86}, {"lat": -19.19, "lng": -40.34}, {"lat": -16.64, "lng": -49.31}, {"lat": -2.55, "lng": -44.30}, {"lat": -12.64, "lng": -55.42}, {"lat": -20.51, "lng": -54.54}, {"lat": -18.10, "lng": -44.38}, {"lat": -5.53, "lng": -52.29},
                            {"lat": -7.06, "lng": -35.55}, {"lat": -24.89, "lng": -51.55}, {"lat": -8.28, "lng": -35.07}, {"lat": -8.28, "lng": -43.68}, {"lat": -22.84, "lng": -43.15}, {"lat": -5.22, "lng": -36.52}, {"lat": -11.22, "lng": -62.80},
                            {"lat": -30.01, "lng": -51.22}, {"lat": 1.89, "lng": -61.22}, {"lat": -27.33, "lng": -49.44}, {"lat": -10.90, "lng": -37.07}, {"lat": -23.55, "lng": -46.64}, {"lat": -10.25, "lng": -48.25}
                        ];
                        var image = {
                            url: '/pf/img/marker.png',
                            size: new google.maps.Size(24, 24),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(0, 24)
                        };
                        var shape = {
                            coords: [1, 1, 1, 24, 24, 24, 24, 1],
                            type: 'poly'
                        };
                        for (x = 0; x < coordenadasUF.length; x++) {
                            var content = arrUF[x];
                            var infowindow = new google.maps.InfoWindow();
                            var marker = new google.maps.Marker({
                                map: map,
                                position: coordenadasUF[x],
                                title: arrEstado[x],
                                icon: image,
                                shape: shape,
                            });
                            google.maps.event.addListener(marker, 'click', (function (marker, content, infowindow) {
                                return function () {
                                    infowindow.setContent(content);
                                    infowindow.open(map, marker);
                                };
                            })(marker, content, infowindow));
                        }
                    }
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwpX8-GnIlRUsbMqJtvC9EagaEHr7-kQs&callback=initMap" async defer></script>        
    </body>
</html>