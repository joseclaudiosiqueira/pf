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
        <!--facebook tags-->
        <meta property="og:locale" content="en_US">
        <meta property="og:title" content="Dimension - An&aacute;lise, medi&ccedil;&atilde;o e planejamento, pontos de teste, requisitos n&atilde;o-funcionais">
        <meta property="og:site_name" content="Dimension">
        <meta property="og:description" content="Integre CONTRATANTES, FORNECEDORES e &Oacute;RG&Atilde;OS DE CONTROLE e facilite os trabalhos de valida&ccedil;&atilde;o externa (Cliente) e auditoria externa (&Oacute;rg&atilde;os de controle). Bom porque elimina pap&eacute;is e fluxos desnecess&aacute;rios na sua empresa e melhor ainda porque facilita o trabalho dos seus Clientes e Auditores. Trabalhe em um ambiente colaborativo, onde o lema é agilizar seus processos.">
        <meta property="og:image" content="https://pfdimension.com.br/pf/img/logo_200px.png">
        <meta property="og:image:type" content="image/jpeg">
        <meta property="og:image:width" content="640">
        <meta property="og:image:height" content="480">
        <meta property="og:type" content="website">
        <!--end-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Dimension - An&aacute;lise, medi&ccedil;&atilde;o e planejamento, pontos de teste, requisitos não-funcionais">
        <meta name="author" content="Dimension">
        <link rel="icon" href="/pf/img/favicon.ico">
        <title>Dimension&reg;</title>
        <link href="/pf/css/vendor/bootstrap/bootstrap.css" rel="stylesheet">
        <link href="/pf/css/vendor/font-awesome/font-awesome.min.css" rel="stylesheet">
        <link href="/pf/css/checkbox-style.css" rel="stylesheet">
        <link href="/pf/css/dimension.css" rel="stylesheet">
        <link href="/pf/css//vendor/sweetalert/sweetalert.css" rel="stylesheet">
        <link href="/pf/css/vendor/labelholder/labelholder.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Marvel|Open+Sans+Condensed:300|Roboto+Condensed|Wire+One" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/pf/js/vendor/semantic-ui/semantic.css">
        <link rel="stylesheet" type="text/css" href="/pf/js/vendor/semantic-ui/components/label.css">        
        <!--http://tableless.com.br/utilizando-meta-tags-facebook/   IMPLEMENTAR -->
        <style type="text/css">
            body {
                padding-top: 54px;
                font-size: 15px;
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                font-family: 'Abel', sans-serif;
                font-size: 17px;
                overflow-x: hidden;
            }

            .form {
                -webkit-box-shadow: 0px 0px 39px 9px rgba(0, 0, 0, 0.27);
                -moz-box-shadow: 0px 0px 39px 9px rgba(0, 0, 0, 0.27);
                box-shadow: 0px 0px 39px 9px rgba(0, 0, 0, 0.27);
                padding: 30px;
            }

            .oswald-extra-light {
                font-family: 'Oswald', sans-serif;
                font-weight: 200;
                font-size: 44px;
                color: #006600;
            }

            .form-area {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 400px;
                height: 500px;
                box-sizing: border-box;
                background: rgba(0, 0, 0, 0.5);
                padding: 40px;
            }        
        </style>
    </head>
    <body style="margin-top: -40px;">
        <?php include DIR_BASE . 'forms/selo_site_seguro.php'; ?>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed"
                            data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                            aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span> <span
                            class="icon-bar"></span> <span class="icon-bar"></span> <span
                            class="icon-bar"></span>
                    </button>
                    <div
                        style="margin-top: 14px; margin-right: 20px; line-height: 34px; min-width: 128px; color: black; font-weight: bold; font-size: 150%;">
                        <img src="/pf/img/logo_200px.png" class="img-responsive" width="42"
                             height="34" align="left">&nbsp;&nbsp;&nbsp;Dimension
                    </div>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="#" data-toggle="modal" data-target="#modal-contato"
                               id="link-modal-contato"> <img src="/pf/img/index-contato.png"
                                                          width="32" height="32">&nbsp;Contato
                            </a></li>
                        <li><a href="#" data-toggle="modal" data-target="#modal-nova-conta">
                                <img src="/pf/img/criar-conta.png" width="32" height="32">&nbsp;Nova
                                conta
                            </a></li>
                        <li><a class="dropdown-toggle" data-toggle="dropdown" href="#"> <img
                                    src="/pf/img/servico.png" width="32" height="32">&nbsp;Mais... <span
                                    class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/pf/DIM.Gateway.php?arq=7&tch=2&sub=4&dlg=0"><img
                                            src="/pf/img/index-esqueci-senha.png" width="24" height="24">&nbsp;&nbsp;<?= WORDING_FORGOT_MY_PASSWORD; ?></a></li>
                                <li><a href="/pf/DIM.Gateway.php?arq=6&tch=2&sub=4&dlg=0"><img
                                            src="/pf/img/index-alterar-senha.png" width="24" height="24">&nbsp;&nbsp;<?= WORDING_CHANGE_PASSWORD; ?></a></li>
                                <li><a href="#" data-toggle="modal"
                                       data-target="#form_modal_politica_privacidade"><img
                                            src="/pf/img/index-privacidade.png" width="24" height="24">&nbsp;&nbsp;Privacidade</a></li>
                            </ul></li>
                    </ul>
                    <form class="navbar-form navbar-right" method="post" role="form"
                          class="form" id="form-login">
                        <div class="form-group">
                            <img src="/pf/img/user.jpg" width="54" height="54"
                                 style="border: 1px solid #d0d0d0;" class="img-circle"
                                 id="gravatar"> <input type="hidden" id="tipo-login"
                                 name="tipo-login" value="nuvem"> <input type="hidden"
                                 id="opcao-identificador" name="opcao-identificador" value="0">
                                 <?= NULL !== $url ? '<input type="hidden" id="url" value="' . $url . '">' : ''; ?>
                        </div>
                        &nbsp;&nbsp; <input type="text" style="display: none;"
                                            name="user_name">
                        <div class="form-group  labelholder"
                             data-label="Login e tecle [TAB] | CPF (n&uacute;meros)">
                            <input type="text"
                                   style="min-width: 190px; max-width: 190px; height: 36px; line-height: 36px; font-size: 130%;"
                                   name="user_name" id="user_name" class="form-control input_style"
                                   placeholder="Usu&aacute;rio" autocomplete="off" required
                                   autofocus>
                        </div>
                        <input type="password" style="display: none;" name="user_password">
                        <div class="form-group">
                            <input
                                style="min-width: 190px; max-width: 190px; height: 36px; line-height: 36px; font-size: 130%;"
                                type="password" name="user_password" id="user_password"
                                class="form-control input_style" placeholder="Senha"
                                autocomplete="off" value="" required>
                        </div>
                        <div class="form-group">
                            <select
                                style="min-width: 190px; max-width: 190px; height: 36px; line-height: 36px; font-size: 100%;"
                                class="form-control input_style" id="id_empresa"
                                name="id_empresa">
                                <option value="0">Selecione uma empresa</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-top: -3px;">
                            <div class="btn-group">
                                <div class="btn-group">
                                    <button style="height: 36px;" class="btn btn-info" type="submit"
                                            name="login" id="login" value="login" disabled>
                                        &nbsp;&nbsp;&nbsp;<i class="fa fa-check fa-lg"></i>&nbsp;&nbsp;Acessar&nbsp;&nbsp;&nbsp;
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button style="height: 36px;"
                                            class="btn btn-default button-refresh-login" type="button"
                                            name="refresh-login" id="button-refresh-login" value="">
                                        &nbsp;&nbsp;&nbsp;<i class="fa fa-refresh fa-lg"></i>&nbsp;&nbsp;&nbsp;
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
        <br />
        <br />
        <br />
        <br />
        <div class="container"
             style="border: 1px dotted #d0d0d0; padding: 10px; border-radius: 5px;">
            <div class="col-md-4">
                <p>
                    O Dimension&reg; &eacute; um sistema de <i><strong>FREEWARE</strong></i>,
                    ou seja, <strong>sua utiliza&ccedil;&atilde;o &eacute; gratuita</strong>.
                    Nosso lema &eacute; oferecer &agrave; comunidade de APF uma
                    solu&ccedil;&atilde;o robusta e simples para melhorar o trabalho dos
                    CONTRATANTES, CONTRATADOS e AUDITORIAS, sejam internas ou externas.
                <hr>
                Leia nossos <a href="#" data-toggle="modal"
                               data-target="#modal-condicoes">Termos & Condi&ccedil;&otilde;es</a>
                <hr>
                [<strong>ATEN&Ccedil;&Atilde;O]</strong> n&atilde;o h&aacute;
                diferen&ccedil;as entre a vers&atilde;o <i>FREEWARE</i> ou uma
                contratada, h&aacute; apenas o suporte (telefone, email e/ou chat) e
                os treinamentos.
                </p>
            </div>
            <div class="col-md-4">
                <p>Para mantermos as pesquisas e as evolu&ccedil;&otilde;es
                    constantes, necessitamos de recursos. Como n&atilde;o cobraremos
                    pelos servi&ccedil;os, pois acreditamos que isto fortalecer&aacute;
                    a comunidade de m&eacute;tricas, esperamos que voc&ecirc; se
                    sensibilize, utilize o Dimension e o torne &uacute;til na sua
                    organiza&ccedil;&atilde;o, e com isso se sinta a vontade para
                    realizar uma doa&ccedil;&atilde;o.</p>
                <hr>
                Para qualquer outra modalidade de utiliza&ccedil;&atilde;o ou se
                deseja outra forma de contrata&ccedil;&atilde;o, clique <a href="#"
                                                                           data-toggle="modal" data-target="#modal-contato"
                                                                           class="button-contato"><i class="fa fa-phone-square"></i>&nbsp;AQUI</a>
                e entre em contato conosco.
            </div>
            <div class="col-md-4" style="text-align: center;">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post"
                      target="_new">
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
                <br /> A doa&ccedil;&atilde;o &eacute; feita de forma segura
                atrav&eacute;s do PayPal&reg; e voc&ecirc; pode doar o valor que
                quiser.
                <hr>
                <i class="fa fa-video-camera" style="color: #d0d0d0"></i>&nbsp;&nbsp;Assista <a href="/pf/apresentacao/PF.ppsx" target="_new">AQUI</a> a uma breve apresenta&ccedil;&atilde;o do Dimension.
            </div>
        </div>
        <div class="row" style="padding: 30px;">
            <div class="container">
                <div class="col-md-3" style="text-align: center;">
                    <div class="panel">
                        <div class="panel-heading">
                            <img src="/pf/img/dimension/of_icon_padro_1.png">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Padroniza&ccedil;&atilde;o</font>
                        </div>
                    </div>
                    <font style="font-family: arial, sans-serif;"> Diversos
                    padr&otilde;es de m&eacute;tricas compor&atilde;o a base do
                    Dimension&reg; - APF/IFPUG, SNAP<sup>*</sup>, APT<sup>*</sup>,
                    NESMA, FP-Lite&trade; COCOMO II...
                    </font>
                    <hr>
                    <small> Obs.: SNAP e APT est&atilde;o em fase final de
                        desenvolvimento para libera&ccedil;&atilde;o. Nosso time de
                        volunt&aacute;rios acredita que at&eacute; Dez/2019 esteja tudo
                        pronto.</small>
                </div>
                <div class="col-md-3" style="text-align: center;">
                    <div class="panel">
                        <div class="panel-heading">
                            <img src="/pf/img/dimension/of_icon_ambiente_1.png">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Ambiente</font>
                        </div>
                    </div>
                    <font style="font-family: arial, sans-serif;"> Compartilhe suas
                    contagens com outros colaboradores e otimize o tempo de
                    elabora&ccedil;&atilde;o, entrega e faturamento. E mais, oferecemos
                    um m&oacute;dulo especial de treinamento e as contagens inseridas
                    pelos <kbd>alunos</kbd> s&atilde;o tratadas &agrave; parte.
                    </font>
                </div>
                <div class="col-md-3" style="text-align: center;">
                    <div class="panel">
                        <div class="panel-heading">
                            <img src="/pf/img/dimension/of_icon_valida_1.png">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Valida&ccedil;&otilde;es</font>
                        </div>
                    </div>
                    <font style="font-family: arial, sans-serif;"> Sua contagem
                    estar&aacute; sempre dispon&iacute;vel para auditorias e
                    valida&ccedil;&otilde;es, sejam internas e/ou externas. Explore um
                    novo mundo compartilhando seu conhecimento. </font>
                </div>
                <div class="col-md-3" style="text-align: center;">
                    <div class="panel">
                        <div class="panel-heading">
                            <img src="/pf/img/dimension/of_icon_planej_1.png">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Planejamento</font>
                        </div>
                    </div>
                    <font style="font-family: arial, sans-serif;"> Fa&ccedil;a a
                    contagem e integre &agrave; sua rotina de trabalho, voc&ecirc;
                    dimensiona e j&aacute; tem um pr&eacute;-planejamento, configurando
                    as fases adequadas ao seu processo de desenvolvimento.</font>
                </div>
            </div>
        </div>
        <br />
        <br />
        <div class="row" style="padding-bottom: 30px;">
            <div class="container">
                <div class="col-md-3" style="text-align: center;">
                    <div class="panel">
                        <div class="panel-heading">
                            <img src="/pf/img/dimension/of_icon_conheci_1.png">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Conhecimento</font>
                        </div>
                    </div>
                    <font style="font-family: arial, sans-serif;"> Temos o objetivo de
                    auxiliar os gestores na tomada de decis&atilde;o, e para isto
                    pretendemos nos tornar refer&ecirc;ncia, montando a maior base de
                    conhecimento de m&eacute;tricas dispon&iacute;vel no mercado.</font>
                </div>
                <div class="col-md-3" style="text-align: center;">
                    <div class="panel">
                        <div class="panel-heading">
                            <img src="/pf/img/dimension/of_icon_ajuda_1.png">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Ajuda on-line</font>
                        </div>
                    </div>
                    <font style="font-family: arial, sans-serif;"> Nosso sistema possui
                    um mecanismo de ajuda inteligente, que orienta o usu&aacute;rio
                    durante a elabora&ccedil;&atilde;o das contagens, para isto foram
                    feitas in&uacute;meras pesquisas, garantindo a confiabilidade das
                    fontes.</font>
                    <hr>
                    <small>As fontes s&atilde;o citadas no pr&oacute;prio sistema e logo
                        abaixo as principais pesquisadas.</small>
                </div>
                <div class="col-md-3" style="text-align: center;">
                    <div class="panel">
                        <div class="panel-heading">
                            <img src="/pf/img/dimension/of_icon_faq_1.png">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">F&oacute;rum e Chat</font>
                        </div>
                    </div>
                    <font style="font-family: arial, sans-serif;"> Utilize o nosso
                    F&oacute;rum e o chat (on-line) para retirar d&uacute;vidas
                    t&eacute;cnicas sobre o produto e/ou sobre m&eacute;todos e forma
                    de contagem. Temos o objetivo de reunir a maior comunidade de
                    m&eacute;tricas do Brasil, com profissionais, empresas,
                    consultores, &oacute;rg&atilde;os p&uacute;blicos, etc.</font>
                    <hr>
                    <small><i>Thanks to <a href="https://codoforum.com/" target="_new">Codoforum</a>
                            - For now we are using the free module.
                        </i></small>
                </div>
                <div class="col-md-3" style="text-align: center;">
                    <div class="panel">
                        <div class="panel-heading">
                            <img src="/pf/img/dimension/of_icon_config_1.png">
                        </div>
                        <div class="panel-body">
                            <font class="oswald-extra-light">Configura&ccedil;&atilde;o</font>
                        </div>
                    </div>
                    <font style="font-family: arial, sans-serif;"> O sistema de
                    m&eacute;tricas j&eacute; vem pr&eacute; configurado com os
                    roteiros SISP 2.0, 2.1, 2.2 e o Guia para projetos de datawarehouse
                    1.0, todos do Minist&eacute;rio da Economia (ex MPOG). Mas
                    n&atilde;o se limite, elabore o seu roteiro e insira no sistema, <strong>isso
                        &eacute; flexibilidade</strong>.
                    </font>
                </div>
            </div>
        </div>
        <hr>
        <div class="row" style="padding: 50px;">
            <div class="container">
                <div class="col-md-5">
                    <img src="/pf/img/dimension/vetor_ecossistema.png"
                         class="img-responsive">
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
                        clicando <a href="http://www.sisp.gov.br/" target="_new">AQUI</a>.
                        Mas n&atilde;o se limite a isso, configure o seu roteiro de acordo
                        com o Contrato celebrado.
                    </p>
                </div>
            </div>
        </div>
        <hr>
        <div class="row"
             style="min-height: 350px; background-color: rgb(255, 255, 255); padding: 50px;">
            <div class="container">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="/pf/img/dimension/logo_cinza.png" class="img-responsive">
                        </div>
                        <div class="col-md-8">
                            <p align="justify"
                               style="padding: 8px; font-family: arial, sans-serif; font-size: 13px; color: #000;">
                                O software est&aacute; disponibilizado em nuvem como SaaS - <i>Software-as-a-Service</i>,
                                e n&atilde;o h&aacute; TCO, nosso sistema &eacute; <i><strong>freeware</strong></i>.
                                Toda a infraestrutura necess&aacute;ria (servidores,
                                conectividade, equipe de manuten&ccedil;&atilde;o e
                                seguran&ccedil;a) fica sob nossa responsabilidade. Nossos
                                clientes apenas utilizam o servi&ccedil;o oferecido, n&atilde;o
                                h&aacute; forma de licenciamento. Veja condi&ccedil;&otilde;es na
                                nossa Pol&iacute;tica de Privacidade e no Termo de Servi&ccedil;o
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row" style="font-size: 85%;">
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
                                    (SISP/Capers Jones, COCOMO II)</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;Trabalho em Equipe</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i
                                        class="fa fa-arrow-circle-right"></i>&nbsp;Edi&ccedil;&otilde;es
                                    Colaborativas</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"
                             style="font-size: 82.5%; padding-left: 42px;">
                            * Trata-se de uma nova m&eacute;trica de software de tamanho
                            funcional derivada da An&aacute;lise de Pontos de
                            Fun&ccedil;&atilde;o (APF). Para maiores detalhes leia o artigo <a
                                href="http://revista.tcu.gov.br/ojsp/index.php/RTCU/article/view/1325"
                                target="_new">Uma m&eacute;trica de tamanho de software como
                                ferramenta para a governan&ccedil;a de TI</a>.<br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row"
             style="min-height: 350px; background-color: rgb(255, 255, 255); padding: 50px;">
            <div class="container">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            Nosso sistema foi constitu&iacute;do tendo como <strong>refer&ecirc;ncia</strong>
                            uma base de conhecimento gigantesca encontrada nas mais diversas
                            fontes, independente de serem marcas comerciais, sem fins
                            lucrativos e/ou &oacute;rg&atilde;os p&uacute;blicos, por isto <strong>achamos
                                justo</strong> citar essa valorosa contribui&ccedil;&atilde;o
                            para a comunidade de m&eacute;tricas. S&atilde;o
                            cita&ccedil;&otilde;es comuns no software Dimension&reg;:
                        </div>
                    </div>
                    <div class="row">
                        <br />
                        <div class="col-md-2">
                            <img src="/pf/img/logo_tcu.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/sisp.jpg" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/nesma.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/ifpug.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/fplite.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-bnb.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                    </div>
                    <div class="row">
                        <br />
                        <div class="col-md-2">
                            <img src="/pf/img/logo-serpro.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/bfpug.jpg" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/timetricas.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/wb-logo.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo_fatto.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-dataprev.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                    </div>
                    <div class="row">
                        <br />
                        <div class="col-md-2">
                            <img src="/pf/img/logo-anvisa.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-abrantes.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-rfb.jpg" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-aneel.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-caixa.jpg" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                        <div class="col-md-2">
                            <img src="/pf/img/logo-cocomo.png" class="img-thumbnail"
                                 style="width: 144px; height: 48px;">
                        </div>
                    </div>
                    <br /> .............................
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="fa-ul">
                                <li><sup>1</sup> As marcas registradas, logomarcas e
                                    siglas/legendas pertencem aos seus detentores;</li>
                                <li><sup>2</sup> As marcas exibidas acima s&atilde;o <strong>referenciadas</strong>
                                    apenas pela coleta de informa&ccedil;&otilde;es sobre
                                    m&eacute;tricas e conhecimento sobre o assunto. Desta forma, <strong>n&atilde;o
                                        representam nem tampouco s&atilde;o Parceiras/Clientes da
                                        Dimension&reg; e desde j&aacute; est&atilde;o automaticamente
                                        eximidas de qualquer obriga&ccedil;&atilde;o e/ou
                                        informa&ccedil;&atilde;o inserida dentro do sistema de
                                        m&eacute;tricas;</strong></li>
                                <li><sup>3</sup> Nossa pol&iacute;tica de privacidade define
                                    explicitamente que <strong>n&atilde;o divulgaremos a terceiros</strong>
                                    quem s&atilde;o os nossos clientes, suas logomarcas, ou
                                    quaisquer outras informa&ccedil;&otilde;es que possam
                                    minimamente identific&aacute;-los. Nossa pol&iacute;tica de
                                    parcerias est&aacute; no site;</li>
                                <li><sup>4</sup> Caso estejamos ferindo alguma pol&iacute;tica e
                                    queira retirar a logomarca do site, basta solicitar <a href="#"
                                                                                           data-toggle="modal" data-target="#modal-contato"
                                                                                           class="button-contato"><i class="fa fa-phone-square"></i>&nbsp;AQUI</a>
                                    que imediatamente ser&aacute; feita a exclus&atilde;o.</li>
                                <li><sup>5</sup> O sistema Dimension foi desenvolvido por
                                    volunt&aacute;rios e &eacute; <i>FREEWARE</i>.

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row"
             style="background-color: #fff; color: #333; font-size: 14px; text-shadow: #999; padding: 30px;">
            <div class="row">
                <div class="container">
                    <div class="col-md-8"
                         style="border-right: 1px solid #999; text-align: center;">
                        Copyright &copy; 2014-<?= date('Y'); ?> Dimension&reg;. O conte&uacute;do deste site &eacute; de propriedade exclusiva da Dimension.<br />
                        <br /> <br />
                    </div>
                    <div class="col-md-4">
                        Siga-nos<br /> <a href="//facebook.com/pfdimension" target="_new"><i
                                class="fa fa-facebook-square fa-2x"></i></a>&nbsp;&nbsp; <a
                            href="//twitter.com/pf_dimension" target="_new"><i
                                class="fa fa-twitter-square fa-2x"></i></a>&nbsp;&nbsp; <i
                            class="fa fa-instagram fa-2x"></i>&nbsp;&nbsp; <i
                            class="fa fa-google-plus-square fa-2x"></i>&nbsp;&nbsp; <i
                            class="fa fa-reddit-square fa-2x"></i>&nbsp;&nbsp; <i
                            class="fa fa-pinterest-square fa-2x"></i>&nbsp;&nbsp;
                    </div>
                </div>
            </div>
        </div>
        <br />
        <br />
        <?php include DIR_BASE . 'forms/index/form_modal_politica_privacidade.php'; ?>
        <?php include DIR_BASE . 'forms/index/form_modal_nova_conta.php'; ?>
        <?php include DIR_BASE . 'forms/index/form_modal_contato.php'; ?>
        <?php include DIR_BASE . 'forms/index/form_modal_condicoes.php'; ?>
        <script type="text/javascript" src="/pf/js/vendor/jquery-1.11.3.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/vendor/bootstrap.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/vendor/sweetalert.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/vendor/jquery.mask.min.js?v=201705111850"></script>
        <!--labelholder-->
        <script type="text/javascript" src="/pf/js/vendor/labelholder/labelholder.min.js?v=201705111850"></script>
        <!-- Dimension(c) scripts -->
        <script type="text/javascript" src="/pf/js/DIM.APIDIM.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/DIM.FRMLOG.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/index/DIM.FMOCONTA.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/index/DIM.FMONCONT.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/min/index/DIM.CPF.CNPJ.min.js?v=201705111850"></script>
        <!-- scripts da consultoria -->
        <script type="text/javascript" src="/pf/js/vendor/dimension/respond.min.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/vendor/dimension/responsiveslides.min.js?v=201705111850"></script>
        <script type="text/javascript">
            //labelholder
            $('.labelholder').labelholder();
        </script>
        <!-- BEGIN JIVOSITE CODE {literal} -->
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
        <!-- {/literal} END JIVOSITE CODE -->
    </body>
</html>