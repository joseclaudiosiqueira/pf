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
<div id="modal-estudante" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content" style="background-color: #f0f0f0;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <h3 style="display:inline;">&nbsp;&nbsp;<i class="fa fa-graduation-cap"></i>&nbsp;&nbsp;Plano especial para estudantes</h3>
            </div>
            <div class="modal-body" style="background-color: #fff;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="/pf/img/software.jpg" class="img-responsive">
                            </div>
                        </div>
                        <!--
                        <div class="row">
                            <div class="col-md-12">
                                <br /><br /><br />
                                <a href="#" data-toggle="modal" data-target="#modal-nova-conta">
                                    <img src="/pf/img/quero-comprar-agora.png" class="img-responsive">
                                </a><br />
                                <p align="justify">
                                    <small>
                                        Ao realizar a assinatura no Plano ESTUDANTE voc&ecirc; tem acesso imediato ao aplicativo, mas lembre-se, o boleto tem vencimento em 10 (dez) dias e
                                        caso n&atilde;o seja efetuado o pagamento iremos suspender o acesso, que ser&aacute; restabelecido t&atilde;o logo a situa&ccedil;&atilde;o seja normalizada.
                                    </small>
                                </p>
                            </div>
                        </div>                        
                        -->
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>INICIANTE, INTERMEDI&Aacute;RIO, AVAN&Ccedil;ADO?</h4>
                                <i class="fa fa-angle-double-right"></i>&nbsp;N&atilde;o importa em que n&iacute;vel voc&ecirc; esteja, uma hora ou outra ir&aacute; se deparar com alguns dilemas: qual &eacute; o tamanho do software que eu 
                                produzo? Quanto custa? Qual equipe? Quanto tempo levar&aacute; para produzi-lo? E os testes, como planejo e dimensiono? Ah! Tem tamb&eacute;m os requisitos n&atilde;o funcionais, quanto de esfor&ccedil;o, tempo e custo eles requerem?
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-angle-double-right"></i>&nbsp;Voc&ecirc; que est&aacute; iniciando ou concluindo algum curso na &aacute;rea de computa&ccedil;&atilde;o e o seu projeto final (TCC) ser&aacute; um projeto de software e quer medi-lo - voc&ecirc; pode
                                apresentar os tamanhos funcionais, n&atilde;o-funcionais e de testes aos seus examinadores <i class="fa fa-smile-o"></i>, conte com o
                                Dimension&reg;, nosso sistema foi feito sob medida, pr&aacute;tico, seguro, simples e confi&aacute;vel. Oferecemos aos <strong>ESTUDANTES</strong> a oportunidade de
                                aprender um pouco mais sobre este mundo incr&iacute;vel de m&eacute;tricas, por um pre&ccedil;o muito acess&iacute;vel, APENAS:
                            </div>                         
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <center>
                                    <h1>R$ 39<sup>,90</sup></h1>
                                </center>
                                <strong>POR CONTAGEM</strong>. Isso mesmo, por contagem, sem mensalidades!!! Pagamento apenas quando utilizar, clique <a href="#" data-toggle="modal" data-target="#modal-nova-conta">AQUI</a> e fa&ccedil;a seu cadastro. Ao efetu&aacute;-lo n&atilde;o esque&ccedil;a de nos informar seu estado de origem 
                                e a sua faculdade - apenas para informa&ccedil;&otilde;es demogr&aacute;ficas e estat&iacute;sticas.<br /><br />Se al&eacute;m disso voc&ecirc; quer tamb&eacute;m contribuir para o desenvolvimento
                                do Dimension&reg; ou tem alguma D&Uacute;VIDA, entre em <a href="#" data-toggle="modal" data-target="#modal-contato" class="button-contato"><i class="fa fa-phone-square"></i>&nbsp;CONTATO</a> conosco. Suas ideias ser&atilde;o sempre muito bem vindas!<br /><br /><br />
                                <!--<small><center>PHP + MySQL<sup>*</sup> + JQuery + Bootstrap && FontAwesome = <i class="fa fa-heart"></i> - Copyright &copy; 2015 - <?= date('Y'); ?></center></small><br />-->
                            </div>
                        </div>
                        <!--
                        <div class="row">
                            <div class="col-md-12"">
                                <small>* O Dimension&reg; foi originalmente projetado utilizando o MySQL. Entretanto, nossa plataforma &eacute; independente do SGBD</small>
                            </div>
                        </div>
                        -->
                    </div>
                </div>                         
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
