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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--facebook tags-->
        <meta property="og:locale" content="en_US">
        <meta property="og:title" content="Dimension - An&aacute;lise, medi&ccedil;&atilde;o e planejamento, pontos de teste, requisitos não-funcionais">
        <meta property="og:site_name" content="Dimension">
        <meta property="og:description" content="Integre CONTRATANTES, FORNECEDORES e &Oacute;RG&Atilde;OS DE CONTROLE e facilite os trabalhos de valida&ccedil;&atilde;o externa (Cliente) e auditoria externa (&Oacute;rg&atilde;os de controle). Bom porque elimina pap&eacute;is e fluxos desnecess&aacute;rios na sua empresa e melhor ainda porque facilita o trabalho dos seus Clientes e Auditores. Trabalhe em um ambiente colaborativo, onde o lema é agilizar seus processos.">
        <meta property="og:image" content="http://pfdimension.com.br/pf/img/logo_200px.png">
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
        <link href="/pf/css/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="/pf/css/vendor/font-awesome/font-awesome.min.css" rel="stylesheet">
        <link href="/pf/css/checkbox-style.css" rel="stylesheet">
        <link href="/pf/css/dimension.min.css" rel="stylesheet">
        <link href="/pf/css//vendor/sweetalert/sweetalert.css" rel="stylesheet">
        <link href="/pf/css/vendor/labelholder/labelholder.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Marvel|Open+Sans+Condensed:300|Roboto+Condensed|Wire+One" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400" rel="stylesheet">
        <!--http://tableless.com.br/utilizando-meta-tags-facebook/   IMPLEMENTAR -->
        <style type="text/css">
            .precos tbody{
                font-family: 'Marvel', sans-serif;
                font-size: 18px;
            }
            .precos tbody tr:nth-child(odd) {
                background-color: #f0f0f0;
                height: 28px;
                line-height: 28px;
            }
            .precos tbody tr:nth-child(even) {
                background-color: #fff;
                height: 28px;
                line-height: 28px;
            }
            .precos tbody tr td {
                padding:5px;
            }
            .precos tbody tr td:nth-child(2){
                font-weight: bold;
                text-align: center;
                text-shadow: 0px 2px #fff;
                font-size: medium;
            }
            .precos tbody tr td[colspan="2"]{
                font-weight: bold;
                font-size: small;
                font-style: italic;
                background-color: #d0d0d0;
            }
            .precos thead th{
                text-align: center;
            }
            /*<?= date('d'); ?>*/
            body{
                /*background: url('/pf/img/background/48.jpg') fixed; background-size: cover;*/
                padding-top:54px;
                font-size: 15px;
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                font-family: 'Roboto Condensed', sans-serif;
                overflow-x: hidden;
            }
            .form{
                -webkit-box-shadow: 0px 0px 39px 9px rgba(0,0,0,0.27);
                -moz-box-shadow: 0px 0px 39px 9px rgba(0,0,0,0.27);
                box-shadow: 0px 0px 39px 9px rgba(0,0,0,0.27);
                padding:30px; 
            }
            .oswald-extra-light{
                font-family: 'Oswald', sans-serif;
                font-weight: 200;
                font-size: 44px;
                color: #006600;
            }
        </style>
    </head>
    <body style="margin-top:-40px;">
        <?php include DIR_BASE . 'forms/selo_site_seguro.php'; ?>
        <div id="img-box"></div>
        <br />
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form method="post" role="form" class="form" id="form-login">
                    <input type="hidden" id="tipo-login" name="tipo-login" value="nuvem">
                    <input type="hidden" id="opcao-identificador" name="opcao-identificador" value="0">
                    <?= NULL !== $url ? '<input type="hidden" id="url" value="' . $url . '">' : ''; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <center>
                                <h1 style="display: inline;"><i class="fa fa-cube"></i>&nbsp;Dimension</h1><br />
                                An&aacute;lise, medi&ccedil;&atilde;o e planejamento
                            </center>
                            <br />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="text-align: center; min-height: 128px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <img src="/pf/img/user.jpg" width="128" height="128" class="img-circle img-responsive" id="gravatar"><br />
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" style="height: 44px; line-height: 44px; font-size: 18px; font-family: 'Georgia', sans-serif; display: none;" name="user_name">
                                    <div class="form-group labelholder" data-label="Login e tecle [TAB] | CPF (n&uacute;meros)">
                                        <input type="text" style="height: 44px; line-height: 44px; font-size: 18px; font-family: 'Georgia', sans-serif;" name="user_name" id="user_name" class="form-control input_style" placeholder="Usu&aacute;rio" autocomplete="off" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" style="height: 44px; line-height: 44px; font-size: 18px; font-family: 'Georgia', sans-serif; display: none;" name="user_password">
                                        <input style="height: 44px; line-height: 44px; font-size: 18px; font-family: 'Georgia', sans-serif;" type="password" name="user_password" id="user_password" class="form-control input_style" placeholder="Senha" autocomplete="off" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select style="height: 44px; line-height: 44px; font-size: 16px; font-family: 'Georgia', sans-serif;" class="form-control input_style" id="id_empresa" name="id_empresa">
                                            <option value="0">Selecione uma empresa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="btn-group btn-group-justified">
                                    <div class="btn-group">
                                        <button class="btn btn-default" style="line-height: 32px; font-size: 16px; font-family: 'Georgia', sans-serif;" type="submit" name="login" id="login" value="login" disabled>&nbsp;&nbsp;&nbsp;<i class="fa fa-check fa-lg"></i>&nbsp;&nbsp;Acessar&nbsp;&nbsp;&nbsp;</button>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" style="line-height: 32px; font-size: 16px; font-family: 'Georgia', sans-serif;" data-toggle="modal" data-target="#modal-nova-conta" class="button-contato"><i class="fa fa-plus-circle fa-lg"></i>&nbsp;&nbsp;Nova conta</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row" style="background-color: #f0f0f0; font-size:92.5%">
                        <div class="col-md-3" style="border-top: 1px dotted #999;padding:15px; text-align:center;">
                            <a href="/pf/DIM.Gateway.php?arq=7&tch=2&sub=4&dlg=0"><img src="/pf/img/index-esqueci-senha.png" width="32" height="32"><br /><?= WORDING_FORGOT_MY_PASSWORD; ?></a><br />
                        </div>
                        <div class="col-md-3" style="border-top: 1px dotted #999;padding:15px; text-align:center;">
                            <a href="/pf/DIM.Gateway.php?arq=6&tch=2&sub=4&dlg=0"><img src="/pf/img/index-alterar-senha.png" width="32" height="32"><br /><?= WORDING_CHANGE_PASSWORD; ?></a><br />
                        </div>
                        <div class="col-md-3" style="border-top: 1px dotted #999;padding:15px; text-align:center;">
                            <a href="#" data-toggle="modal" data-target="#form_modal_politica_privacidade"><img src="/pf/img/index-privacidade.png" width="32" height="32"><br />Privacidade</a><br />
                        </div>
                        <div class="col-md-3" style="border-top: 1px dotted #999;padding:15px; text-align:center;">
                            <a href="#" data-toggle="modal" data-target="#modal-contato" class="button-contato"><img src="/pf/img/index-contato.png" width="32" height="32"><br />Contato</a><br />
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
        <br /><br /><br /><br />
        <div class="row" style="padding:30px;">
            <div class="container">
                <div class="col-md-3">
                    <center>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <font style="font-family: arial, sans-serif; font-size: medium; color: #999; text-shadow: 0px 1px #666;">
                                <i class="fa fa-globe fa-4x"></i></font>
                            </div>
                            <div class="panel-body">
                                <font class="oswald-extra-light">Padroniza&ccedil;&atilde;o</font>
                            </div>
                        </div>
                        <font style="font-family: arial, sans-serif; font-size: small;">
                        Diversos padrões de métricas compõem a base do Dimension&reg; - APF/IFPUG, SNAP<sup>*</sup>, APT<sup>*</sup>, NESMA, FP-Lite&trade; COCOMO II...
                        </font>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <font style="font-family: arial, sans-serif; font-size: medium; color: #999; text-shadow: 0px 1px #666;">
                                <i class="fa fa-users fa-4x"></i></font>
                            </div>
                            <div class="panel-body">
                                <font class="oswald-extra-light">Ambiente</font>
                            </div>
                        </div>
                        <font style="font-family: arial, sans-serif; font-size: small;">
                        Compartilhe suas contagens com outros colaboradores e otimize o tempo de elaboração, entrega e faturamento. E mais,
                        oferecemos um m&oacute;dulo especial de treinamento e as contagens inseridas pelos <kbd>alunos</kbd> s&atilde;o gratuitas.
                        </font>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <font style="font-family: arial, sans-serif; font-size: medium; color: #999; text-shadow: 0px 1px #666;">
                                <i class="fa fa-user-secret fa-4x"></i></font>
                            </div>
                            <div class="panel-body">
                                <font class="oswald-extra-light">Valida&ccedil;&otilde;es</font>
                            </div>
                        </div>
                        <font style="font-family: arial, sans-serif; font-size: small;">
                        Sua contagem está disponível para auditorias e validações (internas e externas). Explore um novo mundo compartilhando seu conhecimento.
                        </font>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <font style="font-family: arial, sans-serif; font-size: medium; color: #999; text-shadow: 0px 1px #666;">
                                <i class="fa fa-calendar fa-4x"></i></font>
                            </div>
                            <div class="panel-body">
                                <font class="oswald-extra-light">Planejamento</font>
                            </div>
                        </div>
                        <font style="font-family: arial, sans-serif; font-size: small;">
                        Faça a contagem e integre &agrave; sua rotina de trabalho, você dimensiona e já tem um pré-planejamento, configurando as fases adequadas ao seu processo de desenvolvimento.
                        </font>
                    </center>
                </div>
            </div>
        </div>
        <br /><br />
        <div class="row" style="padding-bottom:30px;">
            <div class="container">
                <div class="col-md-3">
                    <center>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <font style="font-family: arial, sans-serif; font-size: medium; color: #999; text-shadow: 0px 1px #666;">
                                <i class="fa fa-database fa-4x"></i></font>
                            </div>
                            <div class="panel-body">
                                <font class="oswald-extra-light">Conhecimento</font>
                            </div>
                        </div>
                        <font style="font-family: arial, sans-serif; font-size: small;">
                        Temos o objetivo de auxiliar os gestores na tomada de decisão, e para isto pretendemos nos tornar referência, montando
                        a maior base de conhecimento de m&eacute;tricas disponível no mercado.
                        </font>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <font style="font-family: arial, sans-serif; font-size: medium; color: #999; text-shadow: 0px 1px #666;">
                                <i class="fa fa-info-circle fa-4x"></i></font>
                            </div>
                            <div class="panel-body">
                                <font class="oswald-extra-light">Ajuda on-line</font>
                            </div>
                        </div>
                        <font style="font-family: arial, sans-serif; font-size: small;">
                        Nosso sistema possui um mecanismo de ajuda inteligente, que orienta o usuário
                        durante a elaboração das contagens, para isto foram feitas inúmeras pesquisas, garantindo a confiabilidade das fontes.
                        </font>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <font style="font-family: arial, sans-serif; font-size: medium; color: #999; text-shadow: 0px 1px #666;">
                                <i class="fa fa-comments-o fa-4x"></i></font>
                            </div>
                            <div class="panel-body">
                                <font class="oswald-extra-light">F.A.Q. e Chat</font>
                            </div>
                        </div>
                        <font style="font-family: arial, sans-serif; font-size: small;">
                        Utilize o nosso F.A.Q. e o chat (on-line) para retirar dúvidas técnicas sobre o produto e/ou sobre métodos e forma de contagem.
                        Temos o objetivo de reunir a maior comunidade de métricas do Brasil, com profissionais, empresas, consultores, órgãos públicos, etc.
                        </font>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <font style="font-family: arial, sans-serif; font-size: medium; color: #999; text-shadow: 0px 1px #666;">
                                <i class="fa fa-map-o fa-4x"></i></font>
                            </div>
                            <div class="panel-body">
                                <font class="oswald-extra-light">Configuração</font>
                            </div>
                        </div>
                        <font style="font-family: arial, sans-serif; font-size: small;">
                        O sistema de métricas já vem pré configurado com os roteiros SISP 2.1 e o Guia para projetos de datawarehouse 1.0, todos do Ministério do Planejamento.
                        Mas não se limite, elabore o seu roteiro e insira no sistema, isso é flexibilidade.
                        </font>
                    </center>
                </div>
            </div>
        </div>
        <hr>
        <div class="row"style="padding:50px;">
            <div class="container">
                <div class="col-md-6">
                    <img src="/pf/img/integracao_1.png" class="img-responsive">
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <h3 class="oswald-extra-light">J&Aacute; IMAGINOU O P&Uacute;BLICO E O PRIVADO TRABALHANDO JUNTOS NO MESMO ECOSSISTEMA?</h3>
                    <p align="justify" style="text-shadow: 0px 1px 1px #fff;">
                        No Dimension&reg; isto &eacute; poss&iacute;vel.<br /><br />
                        Nosso software integra CONTRATANTES, FORNECEDORES e &Oacute;RG&Atilde;OS DE CONTROLE facilitando os trabalhos de 
                        valida&ccedil;&atilde;o externa (Cliente) e auditoria externa (&Oacute;rg&atilde;os de controle), 
                        bom porque elimina pap&eacute;is e fluxos desnecess&aacute;rios na sua empresa e melhor ainda porque facilita
                        o trabalho dos seus Clientes e Auditores. Tudo na nuvem! Livre-se de ter que arcar com infraestrutura e equipe 
                        dedicada a manter o sistema no ar.<br /><br />
                        E ainda tem mais, nosso sistema j&aacute; vem com os Roteiros de M&eacute;tricas do SISP (2.1, 2.2* e o Guia para 
                        contagem de projetos Data Warehouse 1.0) por padr&atilde;o. Veja mais detalhes clicando
                        <a href="http://www.sisp.gov.br/" target="_new">AQUI</a>. Mas n&atilde;o se limite a isso, configure o seu roteiro de acordo 
                        com o Contrato celebrado.
                    </p>
                </div>
            </div>
        </div>
        <hr>
        <div class="row" style="min-height: 350px; background-color: rgb(255, 255, 255); padding:50px;">
            <div class="container">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 style="color: #999;">SOBRE</h2>
                        </div>
                        <div class="col-md-4">
                            <img src="/pf/img/Dimension.png" class="img-responsive">
                        </div>
                        <div class="col-md-8">
                            <font style="font-family: arial, sans-serif; font-size: 12px; color: #000;">
                            <p align="justify">
                                O software &eacute; disponibilizado em nuvem  - SaaS - <i>Software-as-a-Service</i>,
                                com o objetivo de reduzir o seu TCO - <i>Total Cost of Ownership</i> ou Custo de Propriedade.
                                Toda a infraestrutura necess&aacute;ria (servidores, conectividade, equipe de manuten&ccedil;&atilde;o e seguran&ccedil;a)
                                fica sob nossa responsabilidade. Nossos clientes pagam apenas pelo servi&ccedil;o oferecido, e a forma de licenciamento 
                                voc&ecirc; escolhe: por Usu&aacute;rio, por volume de an&aacute;lises, etc. Nos adaptamos &agrave;s suas necessidades.
                            </p>
                            </font>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="/pf/img/green_it_logo.jpg" class="img-responsive" />
                        </div>
                        <div class="col-md-8">
                            <font style="font-family: arial, sans-serif; font-size: 12px; color: #000;">
                            <p align="justify">
                                <strong>Somos uma empresa </strong> Green IT, ou TI Verde, que &eacute; a aplicação inteligente de tecnologia e técnicas, com o uso eficiente de energia e ecologicamente corretas em toda a organização. Fonte: <a href="https://www.google.com.br/url?sa=t&rct=j&q=&esrc=s&source=web&cd=10&ved=0ahUKEwj46IrRn_LKAhVDvJAKHe11CbcQFghRMAk&url=http%3A%2F%2Fwww.ictsustain.com%2F_literature_119624%2FICT_Sustainabiity_Framework_and_Index&usg=AFQjCNGXNoTjzZ0Uk20Xf1TB9G0O-O4MCg&sig2=xLxulgnZfnLKgjc8sW5Bqg">Framework SMART/GREEN ICT</a>
                            </p>
                            </font>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 style="color: #999;">FUNCIONALIDADES</h2>
                        </div>
                    </div>
                    <div class="row" style="font-size:90%;">
                        <div class="col-md-6" style="color: #016DC5;">
                            <ul class="fa-ul">
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;Medi&ccedil;&otilde;es Estimativas/Indicativas, Projeto e Baseline</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;SNAP <i>Software Non-functional Assessment Process</i></li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;APT - An&aacute;lise de Pontos de Teste</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;EF - Elementos Funcionais*</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;Armazenamento de Arquivos</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;Diret&oacute;rio P&uacute;blico de contagens</li>
                            </ul>
                        </div>
                        <div class="col-md-6" style="color: #016DC5;">
                            <ul class="fa-ul">
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;Compartilhamento com Empresas</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;Dashboard Gerencial</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;Valida&ccedil;&otilde;es e Auditorias (internas e externas)</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;Planejamento (SISP/Capers Jones, COCOMO II)</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;Trabalho em Equipe</li>
                                <li style="border-bottom: 1px dotted #d0d0d0; padding: 8px;"><i class="fa fa-arrow-circle-right"></i>&nbsp;Edi&ccedil;&otilde;es Colaborativas</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small>
                                * Trata-se de uma nova métrica de software de tamanho funcional derivada da Análise de Pontos de Função (APF). Para maiores detalhes leia o artigo
                                <a href="https://www.google.com.br/url?sa=t&rct=j&q=&esrc=s&source=web&cd=2&cad=rja&uact=8&ved=0ahUKEwjfzqza1KXOAhVJQ5AKHR41C94QFggjMAE&url=http%3A%2F%2Fportal.tcu.gov.br%2Flumis%2Fportal%2Ffile%2FfileDownload.jsp%3FfileId%3D8A8182A2513578DE015144C3E0F55104&usg=AFQjCNHz8es1etrOQWkJunkgh8yH5k04Pw&sig2=wz85NETdrfO10TOMExvCtQ" target="_new">Uma métrica de tamanho de software como ferramenta para a governança de TI</a>.<br />
                                <strong>ATEN&Ccedil;&Atilde;O:</strong> o Dimension&reg; ainda est&aacute; verificando a viabilidade de implanta&ccedil;&atilde;o desta m&eacute;trica.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="row" style="background-color: rgb(224, 224, 224); padding:50px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="/pf/img/planos_customizaveis.png" class="img-responsive">
                            </div>
                            <div class="col-md-9">
                                <h3>PLANO FLEX&Iacute;VEL</h3>
                                <font style="color: slategray">
                                Nosso sistema de faturamento &eacute; bem simples, por <strong>Contagem</strong> e <strong>Espa&ccedil;o de Armazenamento<sup>**</sup></strong>.
                                Isto facilita o planejamento e o dimensionamento dos custos. Em m&eacute;dia as empresas realizam entre 20 (vinte) e 150 (cento e cinquenta) contagens/m&ecirc;s.
                                Voc&ecirc; pode iniciar agora mesmo pagando apenas o que utilizar, no m&ecirc;s que n&atilde;o utilizar, haver&aacute;
                                o pagamento da manuten&ccedil;&atilde;o dos servi&ccedil;os b&aacute;sicos, que custam apenas <span id="valor-plano-flexivel"></span>/m&ecirc;s e o sistema continua 100% dispon&iacute;vel.
                                </font>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="/pf/img/versao_demo.png" class="img-responsive">
                            </div>
                            <div class="col-md-9">
                                <h3>VERS&Atilde;O DEMO</h3>
                                <font style="color: slategray">
                                Nesta vers&atilde;o o cliente tem acesso &agrave; maioria das funcionalidades oferecidas pelo sistema,
                                podendo verificar as possibilidades do aplicativo. Ao final o cliente pode gerar um PDF,
                                com as principais informa&ccedil;&otilde;es da contagem.
                                Tomando a decis&atilde;o de utilizar, o cliente simplesmente migra de tipo de plano. Basta entrar em contato conosco.
                                </font>
                            </div>
                        </div>
                    </div>
                </div>
                <br /><br />
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="/pf/img/planos_estudante.png" class="img-responsive">
                            </div>
                            <div class="col-md-9">
                                <h3>VERS&Atilde;O ESTUDANTE</h3>
                                <font style="color: slategray">
                                Disponibilizamos para os estudantes que querem conhecer mais sobre de Pontos por Fun&ccedil;&atilde;o - APF, SNAP e APT,
                                uma conta a um pre&ccedil;o bem acess&iacute;vel. Para obt&ecirc;-lo, fa&ccedil;a seu cadastro, informando a sua faculdade e sua UF de resid&ecirc;ncia.
                                <i class="fa fa-graduation-cap"></i>&nbsp;<a href="#" data-toggle="modal" data-target="#modal-estudante"><strong>Veja todas as condi&ccedil;&otilde;es e limita&ccedil;&otilde;es desta vers&atilde;o</strong></a>
                                </font>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="/pf/img/planejamento.png" class="img-responsive">
                            </div>
                            <div class="col-md-9">
                                <h3>RETORNO FINANCEIRO</h3>
                                <font style="color: slategray">
                                O Dimension&REG; foi elaborado com foco na integra&ccedil;&atilde;o Empresa/Cliente.
                                Ao final da contagem apresentamos v&aacute;rias estat&iacute;sticas, gr&aacute;ficos e estimativas baseadas
                                em m&eacute;tricas de mercado. No sistema voc&ecirc; integra o seu Cliente ao seu neg&oacute;cio, tornando suas
                                contagens mais transparentes e agilizando o faturamento.
                                </font>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--tabela de precos
        <?php //include DIR_BASE . 'forms/index/tabela_precos.php'; ?>
        <div class="row" style="background-color: #f0f0f0; padding: 50px;">
            <div class="container">
                <div class="col-md-2">
                    <img src="/pf/img/light.png">
                </div>
                <div class="col-md-10" style="vertical-align: middle; line-height: 22px; text-shadow: 0px 1px 1px #c0c0c0;">
                    <span class="label label-info"><i class="fa fa-circle"></i></span><small>&nbsp;Nos planos Demo e Estudante n&atilde;o &eacute; poss&iacute;vel o Cadastro de Fornecedores, Usu&aacute;rios, Clientes, Contratos e Projetos. As configura&ccedil;&otilde;es ser&atilde;o realizadas pela Dimension&reg;</small><br />
                    <span class="label label-info"><i class="fa fa-circle"></i></span><small>&nbsp;Na contrata&ccedil;&atilde;o dos Planos Demo e Estudante a Dimension&reg; far&aacute; os cadastros necess&aacute;rios para a utiliza&ccedil;&atilde;o do sistema;</small><br />
                    <span class="label label-info"><i class="fa fa-circle"></i></span><small>&nbsp;Os arquivos no formato .PDF para os planos DEMO e ESTUDANTE s&atilde;o emitidos com um carimbo (Dimension&reg;) e com restri&ccedil;&otilde;es de c&oacute;pia de texto e impress&atilde;o;</small><br />
                    <span class="label label-info"><i class="fa fa-circle"></i></span><small>&nbsp;Os arquivos no formato .HTML para os planos DEMO e ESTUDANTE s&atilde;o emitidos com um carimbo (Dimension&reg;) e exibem somente a Capa mais as Fun&ccedil;&otilde;es de Dados e Transa&ccedil;&atilde;o</small><br />
                    <span class="label label-info"><i class="fa fa-circle"></i></span><small>&nbsp;Alguns formatos de exportação são aplicáveis às Contagens e outros são aplicáveis ao Planejamento;</small><br />
                    <span class="label label-info"><i class="fa fa-circle"></i></span><small>&nbsp;As contagens SNAP e APT estar&atilde;o liberadas no Plano Empresarial em outubro/2016 sem custo adicional e o plano de pagamento continua o mesmo;</small><br />
                    <span class="label label-info"><i class="fa fa-circle"></i></span><small>&nbsp;O espa&ccedil;o de armazenamento padr&atilde;o &eacute; de 10GB, caso ultrapasse este valor entraremos em contato para verificar a melhor alternativa;</small><br />
                    <span class="label label-info"><i class="fa fa-circle"></i></span><small>&nbsp;A mensalidade para manuten&ccedil;&atilde;o dos servi&ccedil;os ser&aacute; cobrada apenas nos meses em que n&atilde;o houver inser&ccedil;&atilde;o de contagens; No plano ESTUDANTE não há mensalidades.</small><br />
                    <span class="label label-info"><i class="fa fa-circle"></i></span><small>&nbsp;A Dimension&reg; jamais excluir&aacute; suas contagens, a n&atilde;o ser que, durante o cancelamento da assinatura, haja um pedido expl&iacute;cito para tal, e nestes casos um novo registro dever&aacute; ser feito, caso queira voltar ao sistema. De qualquer forma, você receberá todas as contagens em formato .ZIP</small>
                </div>
            </div>
        </div>-->
        <div class="row" style="color:white; font-family: Arial; font-size:16px; min-height:300px; background: url('/pf/img/suporte_cliente.jpg'); background-size: cover; padding: 50px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="row" style="padding: 10px;">
                        <div class="col-md-3">
                            <h2>Precisa de ajuda?</h2>
                            Entre em contato conosco para tirar d&uacute;vidas sobre o nosso software. Sua mensagem ser&aacute; respondida em 24h.
                        </div>
                    </div>
                    <div class="row" style="padding: 15px;">
                        <div class="col-md-3">
                            <center>
                                <button type="button" data-toggle="modal" data-target="#modal-contato" class="btn btn-default btn-large button-contato" style="line-height: 44px; font-size: 18px; font-family: Arial;">&nbsp;&nbsp;&nbsp;ENTRE EM CONTATO&nbsp;&nbsp;&nbsp;</button>
                            </center>
                        </div>
                        <div class="col-md-4" style="border-left: 1px solid #fff;">
                            Se preferir ligue pra n&oacute;s<br />
                            (61) 98625-9027<br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="background-color: #fff; color: #333; font-size:12px; text-shadow: #999; padding: 30px;">
            <div class="row">
                <div class="col-md-8" style="border-right: 1px solid #999;">
                    <center>
                        Copyright &copy; 2014-<?= date('Y'); ?> Dimension&reg;. Todo o conte&uacute;do deste site &eacute; de uso exclusivo da Dimension.<br />
                        <!--Proibida reprodução ou utilização a qualquer título, sob as penas da lei.--><br /><br /><br /><br />
                    </center>
                </div>
                <div class="col-md-4">
                    Siga-nos<br />
                    <a href="//facebook.com/pfdimension" target="_new"><i class="fa fa-facebook-square fa-2x"></i></a>&nbsp;&nbsp;
                    <a href="//twitter.com/pf_dimension" target="_new"><i class="fa fa-twitter-square fa-2x"></i></a>&nbsp;&nbsp;
                    <i class="fa fa-instagram fa-2x"></i>&nbsp;&nbsp;
                    <i class="fa fa-google-plus-square fa-2x"></i>&nbsp;&nbsp;
                    <i class="fa fa-reddit-square fa-2x"></i>&nbsp;&nbsp;
                    <i class="fa fa-pinterest-square fa-2x"></i>&nbsp;&nbsp;
                </div>
            </div>
            <!--
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            Nosso sistema foi constitu&iacute;do tendo como <strong>refer&ecirc;ncia</strong> uma base de conhecimento gigantesca encontrada nas mais
                            diversas fontes, por isto <strong>achamos justo</strong> citar essa valorosa contribui&ccedil;&atilde;o para a comunidade de m&eacute;tricas. S&atilde;o cita&ccedil;&otilde;es comuns no software Dimension&reg;:
                        </div>
                    </div>
                    <div class="row">
                        <br />
                        <div class="col-md-2"><img src="/pf/img/sisp.jpg" class="img-thumbnail" style="width:144px;height:48px;"></div>
                        <div class="col-md-2"><img src="/pf/img/nesma.png" class="img-thumbnail" style="width:144px;height:48px;"></div>
                        <div class="col-md-2"><img src="/pf/img/ifpug.png" class="img-thumbnail" style="width:144px;height:48px;"></div>
                        <div class="col-md-2"><img src="/pf/img/fplite.png" class="img-thumbnail" style="width:144px;height:48px;"></div>
                        <div class="col-md-2"><img src="/pf/img/bfpug.jpg" class="img-thumbnail" style="width:144px;height:48px;"></div>
                        <div class="col-md-2"><img src="/pf/img/timetricas.png" class="img-thumbnail" style="width:144px;height:48px;"></div>
                    </div>
                    <div class="row">
                        <br />
                        <div class="col-md-2"><img src="/pf/img/wb-logo.png" class="img-thumbnail" style="width:144px;height:48px;"></div>
                        <div class="col-md-2"><img src="/pf/img/logo_fatto.png" class="img-thumbnail" style="width:144px;height:48px;"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br />
                            <ul class="fa-ul">
                                <li><sup>1</sup> As marcas registradas, logomarcas e siglas/legendas pertencem aos seus detentores;</li>
                                <li><sup>2</sup> As marcas exibidas acima s&atilde;o <strong>referenciadas</strong> apenas pela coleta de informa&ccedil;&otilde;es sobre m&eacute;tricas e conhecimento sobre o assunto.
                                    Desta forma, <strong>n&atilde;o representam nem tampouco s&atilde;o Parceiras/Clientes da Dimension&reg; e desde j&aacute; se eximem de qualquer obriga&ccedil;&atilde;o e/ou informa&ccedil;&atilde;o
                                        inserida dentro do sistema de m&eacute;tricas;</strong></li>
                                <li><sup>3</sup> Nossa pol&iacute;tica de privacidade define explicitamente que <strong>n&atilde;o divulgaremos a terceiros</strong> quem s&atilde;o os nossos clientes, suas logomarcas,
                                    ou quaisquer outras informa&ccedil;&otilde;es que possam minimamente identific&aacute;-los. Nossa pol&iacute;tica de parcerias est&aacute; no site;</li>
                                <li><sup>4</sup> Caso estejamos ferindo alguma pol&iacute;tica sua e queira retirar a logomarca do site, basta solicitar <a href="#" data-toggle="modal" data-target="#modal-contato" class="button-contato"><i class="fa fa-phone-square"></i>&nbsp;AQUI</a>
                                    que imediatamente ser&aacute; feita a exclus&atilde;o.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
        <?php include DIR_BASE . 'forms/index/form_modal_politica_privacidade.php'; ?>
        <?php //include DIR_BASE . 'forms/index/form_modal_plano_estudante.php'; ?>
        <?php include DIR_BASE . 'forms/index/form_modal_nova_conta.php'; ?>
        <?php //include DIR_BASE . 'forms/index/form_modal_descontos.php'; ?>
        <?php include DIR_BASE . 'forms/index/form_modal_contato.php'; ?>
        <script type="text/javascript" src="/pf/js/vendor/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="/pf/js/vendor/bootstrap.min.js"></script>
        <script type="text/javascript" src="/pf/js/vendor/sweetalert.min.js"></script>
        <script type="text/javascript" src="/pf/js/vendor/jquery.mask.min.js"></script>
        <!--labelholder-->
        <script type="text/javascript" src="/pf/js/vendor/labelholder/labelholder.min.js"></script>
        <!-- Dimension(c) scripts -->
        <script type="text/javascript" src="/pf/js/DIM.APIDIM.js"></script>
        <script type="text/javascript" src="/pf/js/DIM.FRMLOG.js"></script>
        <script type="text/javascript" src="/pf/js/min/index/DIM.FMOCONTA.min.js"></script>
        <script type="text/javascript" src="/pf/js/min/index/DIM.FMONCONT.min.js"></script>
        <script type="text/javascript" src="/pf/js/min/index/DIM.CPF.CNPJ.min.js"></script>
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