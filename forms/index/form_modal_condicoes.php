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
<style>
    .plist {
        list-style-type: none;
        font-family: 'Courier New', sans-serif;
        font-size: 18px;
    }

    .psub0 {
        font-size: 130%;
        font-weight: bold;
        display: inline;
    }

    .psub1 {
        padding-left: 20px;
    }

    .psub2 {
        padding-left: 40px;
    }

    .psub3 {
        padding-left: 60px;
    }

    .psub1 > span {
        font-weight: bold;
    }    

    .psub2 > span {
        font-weight: bold;
    }    

    .psub3 > span {
        font-weight: bold;
    }    
</style>
<div id="modal-condicoes" class="modal fade" role="dialog">
    <div class="modal-dialog modal-">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Termos & Condi&ccedil;&otilde;es<br />
                <span class="sub-header">Fique por dentro das condi&ccedil;&otilde;es de utiliza&ccedil;&atilde;o do Dimension</span>
            </div>
            <div class="modal-body" style="padding: 30px; background-color: #fff;">
                <div style="max-height:500px;min-height:500px;width:100%;overflow-x:hidden;overflow-y:auto;" class="scroll">                
                    <div class="row">
                        <div class="col-md-12" style="padding-right: 32px;">
                            <ol class="plist">
                                <li class="psub0">1. Prerrogativas</li>

                                <li class="psub1"><span>1.1.</span> O Dimension&reg;, doravante Sistema, &eacute; um software
                                    propriet&aacute;rio, ou seja, &eacute; aquele cuja c&oacute;pia,
                                    redistribui&ccedil;&atilde;o ou modifica&ccedil;&atilde;o
                                    s&atilde;o proibidos.</li>

                                <li class="psub1"><span>1.2.</span> Para utiliza&ccedil;&atilde;o do
                                    Sistema &eacute; necess&aacute;rio solicitar
                                    permiss&atilde;o, entretanto o licenciamento &eacute; <i>Freeware</i>.</li>

                                <li class="psub1"><span>1.3.</span> AN&Uacute;NCIOS - O Sistema n&atilde;o
                                    embutir&aacute; nenhuma esp&eacute;cie de propaganda e/ou chamadas 
                                    para outros sites, comerciais ou n&atilde;o.</li>

                                <li class="psub2"><span>1.3.1.</span> Eventualmente os parceiros para
                                    treinamento, palestras, worksohps e desenvolvimento,
                                    poder&atilde;o ter suas logomarcas divulgadas na p&aacute;gina
                                    principal com link apontando para os respectivos s&iacute;tios.</li>

                                <li class="psub2"><span>1.3.2.</span> N&atilde;o haver&aacute;
                                    "monetiza&ccedil;&atilde;o" caso seja efetuado algum clique nas
                                    logomarcas dos parceiros.</li>

                                <li class="psub2"><span>1.3.3.</span> A licen&ccedil;a Freeware
                                    n&atilde;o restringe o tipo de uso, seja para fins comerciais, 
                                    pesquisa ou acad&ecirc;mico, sendo esta "gratuita" para quaisquer fins.</li>

                                <li class="psub2"><span>1.3.4.</span> N&atilde;o nos
                                    responsabilizamos por cobran&ccedil;as de terceiros na
                                    utiliza&ccedil;&atilde;o e/ou orienta&ccedil;&atilde;o de uso do
                                    "sistema", inclusive se for contratada a administra&ccedil;&atilde;o.</li>

                                <li class="psub1"><span>1.4.</span> A utiliza&ccedil;&atilde;o e/ou
                                    orienta&ccedil;&atilde;o acima referem-se a, mas n&atilde;o
                                    exclusivamente, treinamentos, palestras e workshops, e poder&atilde;o ser
                                    contratados com qualquer empresa especializada.</li>

                                <li class="psub0">2. Modelo de Software-as-a-Service</li>

                                <li class="psub1"><span>2.1.</span> O Sistema, neste primeiro
                                    est&aacute;gio de maturidade ser&aacute; disponibilizado apenas
                                    na modalidade SaaS, bastando a solicita&ccedil;&atilde;o 
                                    de inscri&ccedil;&atilde;o atrav&eacute;s de um usu&aacute;rio "administrador".</li>

                                <li class="psub1"><span>2.2.</span> O "administrador" ser&aacute;
                                    respons&aacute;vel por toda a opera&ccedil;&atilde;o no
                                    Sistema, inclusive a cria&ccedil;&atilde;o dos outros usu&aacute;rios.</li>

                                <li class="psub1"><span>2.3.</span> N&atilde;o haver&aacute; forma de acesso
                                        dos "desenvolvedores" do Sistema para auxiliar nas
                                        atividades independentes do "administrador".</li>

                                <li class="psub1"><span>2.4.</span> No caso das intera&ccedil;&otilde;es via
                                        "chat", poder&aacute; ser cobrado um valor &agrave; parte pelo
                                        suporte, desde que previamente contratado.</li>

                                <li class="psub1"><span>2.5.</span> O Sistema n&atilde;o limitar&aacute;
                                        a quantidade de cadastros, seja de Alunos, Fornecedores,
                                        Clientes, Usu&aacute;rios, Projetos, Contratos e
                                        An&aacute;lises.</li>

                                <li class="psub1"><span>2.7.</span> A Dimension n&atilde;o se responsabiliza
                                        pelos "c&aacute;lculos" realizados no sistema com base nas
                                        configura&ccedil;&otilde;es realizadas por Administradores e
                                        Gestores.</li>

                                <li class="psub2"><span>2.7.1.</span> Poder&aacute; haver
                                        limita&ccedil;&atilde;o de espa&ccedil;o em disco, que &eacute;
                                        regulado pelo plano contratado junto ao ISP.</li>

                                <li class="psub2"><span>2.7.2.</span> O "administrador" poder&aacute;
                                        acompanhar a utiliza&ccedil;&atilde;o do espa&ccedil;o em disco
                                        no pr&oacute;prio sistema.</li>

                                <li class="psub1"><span>2.8.</span> A disponibilidade mensal do sistema
                                        ser&aacute; garantida junto ao plano contrado com o ISP.</li>

                                <li class="psub1"><span>2.9.</span> Eventualmente para poder custear os
                                        investimentos em manuten&ccedil;&atilde;o e
                                        atualiza&ccedil;&atilde;o de vers&otilde;es poder&aacute; haver
                                        doa&ccedil;&atilde;o feita por pessoas
                                        f&iacute;sicas ou jur&iacute;dicas.</li>

                                <li class="psub0">3. Itens sujeitos a cobran&ccedil;a
                                    personalizada</li>

                                <li class="psub1"><span>3.1.</span> Palestras e Workshops sobre o Sistema</li>

                                <li class="psub2"><span>3.1.1.</span> O solicitante dever&aacute; arcar com as
                                        despesas de di&aacute;rias, passagens e/ou outros custos
                                        envolvidos.</li>

                                <li class="psub2"><span>3.1.2.</span> Os palestrantes atuam de forma
                                        independente, entretanto poder&atilde;o cobrar honor&aacute;rios.</li>

                                <li class="psub1"><span>3.2.</span> Treinamentos presenciais.</li>

                                <li class="psub1"><span>3.3.</span> Treinamentos online.</li>

                                <li class="psub1"><span>3.4.</span> Integra&ccedil;&atilde;o com outros
                                        sistemas:</li>

                                <li class="psub2"><span>3.4.1.</span> Customiza&ccedil;&atilde;o de
                                        m&oacute;dulos e APIs.</li>

                                <li class="psub2"><span>3.4.2.</span> Cria&ccedil;&atilde;o de novas APIs.</li>

                                <li class="psub1"><span>3.5.</span> Customiza&ccedil;&otilde;es em
                                        relat&oacute;rios.</li>

                                <li class="psub2"><span>3.5.1.</span> Todos os relat&oacute;rios podem ser
                                        customizados pelos usu&aacute;rios, e o servi&ccedil;o
                                        ser&aacute; cobrado &agrave; parte atrav&eacute;s de
                                        c&aacute;lculo b&aacute;sico de H/H a depender do valor que o
                                        "consultor/desenvolvedor" ir&aacute; cobrar por seus
                                        honor&aacute;rios.</li>

                                <li class="psub1"><span>3.6.</span> Customiza&ccedil;&atilde;o no Sistema.</li>

                                <li class="psub2"><span>3.6.1.</span> O Sistema poder&aacute; ser
                                        customizado para alguma necessidade particular, desde que a
                                        customiza&ccedil;&atilde;o ajude a "comunidade" de
                                        usu&aacute;rios e alcance o maior n&uacute;mero poss&iacute;vel.</li>

                                <li class="psub2"><span>3.6.2.</span> Todas as customiza&ccedil;&otilde;es
                                        passar&atilde;o por um processo de avalia&ccedil;&atilde;o,
                                        an&aacute;lise de abrang&ecirc;ncia e viabilidade,
                                        desenvolvimento, testes, implanta&ccedil;&atilde;o,
                                        comunica&ccedil;&atilde;o aos usu&aacute;rios e
                                        libera&ccedil;&atilde;o.</li>

                                <li class="psub2"><span>3.6.3.</span> O Sistema n&atilde;o garante a
                                        execu&ccedil;&atilde;o de solicita&ccedil;&otilde;es de
                                        mudan&ccedil;a.</li>
                                
                                <li class="psub1"><span>3.7.</span> Quaisquer dos servi&ccedil;os acima podem ser solicitados pelo formul&aacute;rio de Contato.</li>
                                
                                <li class="psub1"><span>3.8.</span> &Agrave; medida em que tivermos mais Parceiros, as solicita&ccedil;&otilde;s podem ser feitas diretamente.</li>
                                
                                <li class="psub1"><span>3.9.</span> Para as solicita&ccedil;&otilde;es de altera&ccedil;&atilde;o no Sistema o formul&aacute;rio deve ser o de Contato.</li>

                                <li class="psub0">4. Garantia de execu&ccedil;&atilde;o:</li>

                                <li class="psub1"><span>4.1.</span> O Sistema estar&aacute;
                                        dispon&iacute;vel 24x7.</li>

                                <li class="psub1"><span>4.2.</span> N&atilde;o h&aacute; garantia de SLA em
                                        termos de tempo de resposta.</li>

                                <li class="psub1"><span>4.3.</span> Ser&atilde;o emitidos avisos aos
                                        usu&aacute;rios sobre as indisponibilidades programadas.</li>

                                <li class="psub1"><span>4.4.</span> Haver&aacute; backup di&aacute;rio do
                                        banco de dados.</li>

                                <li class="psub1"><span>4.5.</span> Nenhum dado pessoal ser&aacute; coletado
                                        sem o consentimento do usu&aacute;rio.</li>

                                <li class="psub2"><span>4.5.1.</span> Os dados pessoais coletados ser&atilde;o
                                        inseridos pela vontade do usu&aacute;rio em formul&aacute;rio
                                        pr&oacute;prio.</li>

                                <li class="psub2"><span>4.5.2.</span> Nenhum dado dos usu&aacute;rios
                                        ser&aacute; repassado a parceiros, fornecedores,
                                        &oacute;rg&atilde;os e/ou empresas.</li>

                                <li class="psub2"><span>4.5.3.</span> O CPF, o email e/ou o login
                                        "personalizado" s&atilde;o os &uacute;nicos dados pessoais
                                        obrigat&oacute;rios.</li>

                                <li class="psub2"><span>4.5.4.</span> Todos os dados inseridos no Sistema
                                        podem ser "fict&iacute;cios", apenas os CPF e email devem ser
                                        v&aacute;lidos.</li>

                                <li class="psub3"><span>4.5.4.1.</span> O CPF pode ser fict&iacute;cio, mas
                                    deve ser v&aacute;lido. <strong>Thanks to <a href="https://www.4devs.com.br/gerador_de_cpf" target="_new" class="txt2">4devs</a></strong>.</li>

                                <li class="psub3"><span>4.5.4.2.</span> O email deve ser v&aacute;lido porque
                                        o sistema utiliza mecanismos de controle de processos baseado no
                                        envio de emails.</li>

                                <li class="psub0">5. Ao solicitar a utiliza&ccedil;&atilde;o do
                                    Sistema voc&ecirc; est&aacute; nos dando ci&ecirc;ncia de
                                    que concorda com estes <strong>Termos & Condi&ccedil;&otilde;es</strong></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
