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
        <meta property="og:image" content="https://pfdimension.com.br/pf/img/logo_200px.png">
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
        <link rel="stylesheet" type="text/css" href="/pf/login/fonts/iconic/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" type="text/css" href="/pf/login/vendor/animate/animate.css">
        <link rel="stylesheet" type="text/css" href="/pf/login/vendor/css-hamburgers/hamburgers.min.css">
        <link rel="stylesheet" type="text/css" href="/pf/login/vendor/animsition/css/animsition.min.css">
        <link rel="stylesheet" type="text/css" href="/pf/login/vendor/select2/select2.min.css">
        <link rel="stylesheet" type="text/css" href="/pf/login/vendor/daterangepicker/daterangepicker.css">
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
        <!--google fonts-->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Marvel|Open+Sans+Condensed:300|Roboto+Condensed|Wire+One" />
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Oswald:200,300,400">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Abel">
        <!--end-->
        <style type="text/css">
            body {
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                font-family: 'Abel', sans-serif;
                overflow-x: hidden;
            }
            .oswald-extra-light {
                font-family: 'Oswald', sans-serif;
                font-weight: 400;
                font-size: 44px;
                color: #57b846;
            }            
        </style>
    </head>
    <body style="padding-left: 20px; padding-right: 20px; overflow-x: hidden;">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-t-40 p-b-20">
                    <form class="login100-form validate-form">
                        <input type="hidden" id="tipo-login" name="tipo-login" value="nuvem">
                        <input type="hidden" id="opcao-identificador" name="opcao-identificador" value="0"><?= NULL !== $url ? '<input type="hidden" id="url" value="' . $url . '">' : ''; ?>
                        <span class="login100-form-title p-b-40">
                            <img src="/pf/img/logo_200px.png" width="48" height="40" align="center">&nbsp;&nbsp;&nbsp;Dimension
                        </span>                     
                        <span class="login100-form-avatar">
                            <img src="/pf/img/user.jpg" alt="AVATAR">
                        </span>
                        <div class="wrap-input100 validate-input m-t-40 m-b-35" data-validate = "Requerido">
                            <input class="input100" type="text" name="user_name" autocomplete="off">
                            <span class="focus-input100" data-placeholder="Login (CPF apenas n&uacute;meros)"></span>
                        </div>
                        <div class="wrap-input100 validate-input m-b-50" data-validate="Requerido">
                            <input class="input100" type="user_password" name="pass">
                            <span class="focus-input100" data-placeholder="Senha"></span>
                        </div>
                        <div class="m-b-50">
                            <select id="id_empresa" name="id_empresa" class="input100">
                                <option value="0">Selecione uma empresa</option>
                            </select>                            
                        </div>                        
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn" type="submit" name="login" id="login" disabled>
                                Acessar
                            </button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="login100-form-btn" name="refresh-login" id="button-refresh-login" value="">
                                <i class="fa fa-refresh fa-lg"></i>
                            </button>                            
                        </div>
                        <ul class="login-more p-t-90">
                            <li class="m-b-8">
                                <span class="txt1"><img src="/pf/img/index-contato.png" width="24" height="24" align="center">&nbsp;&nbsp;Entre em</span>
                                <a href="#" data-toggle="modal" data-target="#modal-contato" class="txt2" id="link-modal-contato">Contato</a>
                            </li>
                            <li class="m-b-8">
                                <span class="txt1"><img src="/pf/img/criar-conta.png" width="24" height="24" align="center">&nbsp;&nbsp;N&atilde;o tem uma conta?</span>
                                <a href="#" data-toggle="modal" data-target="#modal-nova-conta" class="txt2">Crie uma</a>
                            </li>
                            <li class="m-b-8">
                                <span class="txt1"><img src="/pf/img/index-esqueci-senha.png" width="24" height="24" align="center" class="txt1">&nbsp;&nbsp;Esqueceu a senha?</span>
                                <a href="/pf/DIM.Gateway.php?arq=7&tch=2&sub=4&dlg=0" class="txt2">Clique aqui</a>
                            </li>
                            <li class="m-b-8">
                                <span class="txt1"><img src="/pf/img/index-alterar-senha.png" width="24" height="24" align="center">&nbsp;&nbsp;Quero alterar</span>
                                <a href="/pf/DIM.Gateway.php?arq=6&tch=2&sub=4&dlg=0" class="txt2">minha senha</a>
                            </li>
                            <li class="m-b-8">
                                <span class="txt1"><img src="/pf/img/index-privacidade.png" width="24" height="24" align="center">&nbsp;&nbsp;Veja nossa</span>
                                <a href="#" data-toggle="modal" data-target="#form_modal_politica_privacidade" class="txt2">política de privacidade</a>
                            </li>
                        </ul>                        
                    </form>
                </div>
            </div>
        </div>
        <div class="container" style="border: 1px dotted #d0d0d0; padding: 20px; border-radius: 10px;">
            <div class="row panel">
                <div class="col-md-1">
                    <img src="/pf/img/light.png" class="img-responsive">
                </div>
                <div class="col-md-10">
                    <div class="panel-title">
                        Informa&ccedil;&otilde;es importantes<br />
                        <span class="sub-header">Leia abaixo o que estamos oferencendo para a comunidade de m&eacute;tricas de software</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <p>O Dimension&reg; &eacute; <strong>FREEWARE</strong>, 
                    sua utiliza&ccedil;&atilde;o &eacute; gratuita.
                    Nosso lema &eacute; oferecer &agrave; comunidade de APF uma
                    solu&ccedil;&atilde;o robusta e simples para melhorar o trabalho dos
                    CONTRATANTES, CONTRATADOS e AUDITORIAS, sejam internas ou externas.
                    <br /><br />
                    Leia nossos <a href="#" data-toggle="modal" data-target="#modal-condicoes" class="txt2">Termos & Condi&ccedil;&otilde;es</a>
                </p>
            </div>
            <div class="col-md-4">
                <p>Para mantermos as pesquisas e as evolu&ccedil;&otilde;es
                    constantes, necessitamos de recursos. Esperamos que voc&ecirc; se
                    sensibilize, utilize o Dimension e o torne &uacute;til na sua
                    organiza&ccedil;&atilde;o, e com isso se sinta a vontade para
                    realizar uma doa&ccedil;&atilde;o.</p>
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
                <p>
                    <br /> A doa&ccedil;&atilde;o &eacute; feita de forma segura
                    atrav&eacute;s do PayPal&reg; e voc&ecirc; pode doar o valor que
                    quiser.<br /><br/>
                    <i class="fa fa-video-camera" style="color: #d0d0d0"></i>&nbsp;&nbsp;
                    Assista <a href="/pf/apresentacao/PF.ppsx" target="_new" class="txt2">AQUI</a> a uma breve apresenta&ccedil;&atilde;o sobre o Dimension.
                </p>
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
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="/pf/img/dimension/logo_cinza.png" class="img-responsive">
                        </div>
                        <div class="col-md-8">
                            <p align="justify" style="font-size: 80%;">
                                O software est&aacute; disponibilizado em nuvem como SaaS - <i>Software-as-a-Service</i>,
                                e n&atilde;o h&aacute; TCO, nosso sistema &eacute; <i><strong>freeware</strong></i>.
                                Tudo necess&aacute;rio - servidores,
                                conectividade, equipe de manuten&ccedil;&atilde;o e
                                seguran&ccedil;a - fica sob nossa responsabilidade. Nossos
                                clientes apenas utilizam o servi&ccedil;o oferecido, n&atilde;o
                                h&aacute; forma de licenciamento. Veja condi&ccedil;&otilde;es na
                                nossa Pol&iacute;tica de Privacidade e no Termo de Servi&ccedil;o
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row"">
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
                                ferramenta para a governan&ccedil;a de TI</a> ou veja <a href="/pf/docs/Marcus%20Vinicius%20Borela%20de%20Castro.ppt"
                                                                                     target="_new" class="txt2">esta apresenta&ccedil;&atilde;o</a>.<br />
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
                                                                                           class="button-contato txt2"><i class="fa fa-phone-square"></i>&nbsp;AQUI</a>
                                    que imediatamente ser&aacute; feita a exclus&atilde;o.</li>
                                <li><sup>5</sup> O sistema Dimension foi desenvolvido por
                                    volunt&aacute;rios e &eacute; <i>FREEWARE</i>.

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="background-color: peachpuff; color: #333; padding: 30px; padding-bottom: 20px;">
            <div class="col-md-8" style="border-right: 2px solid #fff; text-align: center;">
                <br /><br />Copyright &copy; 2014-<?= date('Y'); ?> Dimension&reg;. O conte&uacute;do deste site &eacute; de propriedade exclusiva da Dimension.<br /><br /><br />
            </div>
            <div class="col-md-4"><br />
                <span class="txt1">Siga-nos</span><br />
                <a href="//facebook.com/pfdimension" target="_new" class="txt2"><i class="fa fa-facebook-square fa-2x"></i></a>&nbsp;&nbsp;
                <a href="//twitter.com/pf_dimension" target="_new" class="txt2"><i class="fa fa-twitter-square fa-2x"></i></a>&nbsp;&nbsp;
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
        <script type="text/javascript" src="/pf/js/DIM.APIDIM.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/DIM.FRMLOG.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/index/DIM.FMOCONTA.js?v=201705111850"></script>
        <script type="text/javascript" src="/pf/js/index/DIM.FMONCONT.js?v=201705111850"></script>
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
        <script src="/pf/login/js/main.js"></script>
        <!--end-->
    </body>
</html>