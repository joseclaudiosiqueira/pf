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
<input type="hidden" name="id" id="id" value="-">
<input type="hidden" name="cabecalho_funcao" id="cabecalho_funcao" value="-">
<input type="hidden" name="id_abrangencia" id="id_abrangencia" value="<?= $abrangencia; ?>">
<input type="hidden" name="acao" id="acao" value="<?= $ac; ?>">
<input type="hidden" name="contagem-id-processo" id="contagem-id-processo" value="">
<div class="panel panel-default">
    <div class="panel-title">
        <i class="fa fa-caret-right fa-lg"></i>&nbsp;&nbsp;Informa&ccedil;&otilde;es iniciais<br />
        <span class="sub-header">Inser&ccedil;&atilde;o e/ou altera&ccedil;&atilde;o de contagens</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="contagem_id_cliente">
                        <span class="pop"
                              data-placement="bottom" data-toggle="popover" title="<i
                              class='fa fa-arrow-circle-right'></i>&nbsp;Preenchimento
                              autom&aacute;tico e altera&ccedil;&otilde;es" data-content="Caso
                              haja cadastro, selecione um Cliente e para facilitar o trabalho,
                              clique no link <kbd>
                              <i class='fa fa-copy'></i>&nbsp;Preencher
                              </kbd> para inserir as informa&ccedil;&otilde;es b&aacute;sicas da
                              contagem:
                              <ul>
                              <li>Linguagem e produtividade</li>
                              <li>Tipo de contagem</li>
                              <li>Banco de dados</li>
                              <li>&Aacute;rea de atua&ccedil;&atilde;o</li>
                              <li>Processo de desenvolvimento</li>
                              <li>Processo de Gest&atilde;o</li>
                              </ul>
                              <hr> Ap&oacute;s o cadastro da contagem o Cliente n&atilde;o pode
                              ser mais alterado. Caso deseje, se ainda estiver no processo <kbd>Em
                              elabora&ccedil;&atilde;o</kbd>, exclua a contagem e insira uma
                              nova."> <i class="fa fa-info-circle"></i>&nbsp;Cliente</span>&nbsp;|&nbsp;
                        <a href="#" class="fmocti-link"><i class="fa fa-copy"></i>&nbsp;Preencher</a>&nbsp;|&nbsp;
                        <a href="#" class="fmoimp-link" data-toggle="tooltip" title="Em breve..."><i class="fa fa-download"></i>&nbsp;Importar</a>
                    </label><br />
                    <select class="input100" id="contagem_id_cliente" data-placeholder="Selecione o cliente" title="Cliente" style="border: 0; border-bottom: 2px solid #d9d9d9;"></select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="id_contrato">
                        <span class="pop" data-placement="bottom"
                              data-toggle="popover" title="<i  class='fa fa-arrow-circle-right'></i>&nbsp;Tipos
                              de contratos" data-content="Os contratos podem ser de dois tipos
                              no Dimension&reg;
                              <ul>
                              <li>[ I ]nicial (&eacute; o primeiro contrato celebrado);</li>
                              <li>[ A ]ditivo (contratos adicionais)</li>
                              </ul> IMPORTANTE: durante o cadastro do contrato o Administador
                              define o tipo, sendo que o primeiro &eacute; sempre Inicial"> <i
                                id="w_id_contrato" class="fa fa-dot-circle-o"></i>&nbsp;<i
                                class="fa fa-info-circle"></i>&nbsp;Contrato</span>
                    </label><br />
                    <select class="input100" id="contagem_id_contrato" title="Contrato" style="border: 0; border-bottom: 2px solid #d9d9d9;">
                        <option value="0">...</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="contagem_id_projeto">
                        <i id="w_id_projeto" class="fa fa-dot-circle-o"></i>&nbsp;Projeto</label><br />
                    <select class="input100" id="contagem_id_projeto" title="Projeto" style="border: 0; border-bottom: 2px solid #d9d9d9;">
                        <option value="0">...</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="contagem_id_baseline">
                        <span class="pop" data-toggle="popover" data-placement="bottom" id="span-resumo-baseline" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Resumo descritivo da Baseline" data-content="Selecione uma baseline">
                            <i id="w_id_baseline" class="fa fa-dot-circle-o"></i>&nbsp;<i class="fa fa-info-circle"></i>&nbsp;Baseline
                        </span>
                    </label><br />
                    <select class="input100" id="contagem_id_baseline" title="Baseline" style="border: 0; border-bottom: 2px solid #d9d9d9;">
                        <option value="0">...</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="for-group">
                    <label for="id-orgao">
                        <span class="pop" data-toggle="popover" data-placement="bottom" title="<i  class='fa fa-arrow-circle-right'></i>&nbsp;Outras
                              denomina&ccedil;&otilde;es" data-content="Este campo pode ter
                              outras denomina&ccedil;&otilde;es:
                              <ul class='fa-ul'>
                              <li><i class='fa fa-angle-double-right'></i>&nbsp;Setor /
                              Lota&ccedil;&atilde;o;</li>
                              <li><i class='fa fa-angle-double-right'></i>&nbsp;Departamento;</li>
                              <li><i class='fa fa-angle-double-right'></i>&nbsp;&Oacute;rg&atilde;o,
                              etc.</li>
                              </ul> <strong>LEMBRE-SE</strong>: a refer&ecirc;ncia &eacute; de
                              quem est&aacute; demandando">
                            <i id="w_id_orgao" class="fa fa-dot-circle-o"></i>&nbsp;<i class="fa fa-info-circle"></i>&nbsp;&Oacute;rg&atilde;o</span>
                    </label><br />
                    <select id="id-orgao" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;">
                        <option value="0">...</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="os">
                        <span class="pop" data-placement="bottom" data-toggle="popover" title="<i  class='fa fa-arrow-circle-right'></i>
                              Outras denomina&ccedil;&otilde;es" data-content="Este campo tem
                              v&aacute;rias denomina&ccedil;&otilde;es:
                              <ul>
                              <li>Demanda</li>
                              <li>Solicita&ccedil;&atilde;o</li>
                              </ul> <i class='fa fa-lightbulb-o'></i>&nbsp;<strong>DICA</strong>:
                              quando for inserir uma contagem de Baseline, digite OS-BASELINE,
                              isto facilita buscas.">
                            <i class="fa fa-info-circle"></i>&nbsp;Ordem de Servi&ccedil;o</span>
                    </label><br />
                    <div class="wrap-input100 m-b-0">
                        <input class="input100" type="text" id="ordem_servico" maxlength="45">
                        <span class="focus-input100" data-placeholder=""></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="responsavel">Respons&aacute;vel pela cria&ccedil;&atilde;o</label><br />
                    <div class="wrap-input100 m-b-0">
                        <input type="text" id="responsavel" value="<?= $_SESSION['user_email']; ?>" class="input100" disabled>
                        <span class="focus-input100" data-placeholder=""></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <label for="data-cadastro">Data de cadastro</label><br />
                <div class="wrap-input100 m-b-0">
                    <input class="input100" id="data_cadastro" value="<?= date('d/m/Y H:i:s'); ?>" disabled>
                    <span class="focus-input100" data-placeholder=""></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="entregas">
                        <span class="pop" data-toggle="popover"
                              data-placement="bottom" data-title="<i
                              class='fa fa-arrow-circle-right'></i>&nbsp;Entregas / Sprints"
                              data-content="Tanto para o processo tradicional de desenvolvimento
                              quanto para o processo &aacute;gil, utilize as entregas / sprints*
                              para dividir o esfor&ccedil;o do seu projeto.
                              <hr>*O Sprint Backlog é uma lista de tarefas que o Scrum Team se
                              compromete a fazer em um Sprint. Os itens do Sprint Backlog são
                              extraídos do Product Backlog, pela equipe, com base nas
                              prioridades definidas pelo Product Owner e a percepção da equipe
                              sobre o tempo que será necessário para completar as várias
                              funcionalidades. FONTE: <a
                              href='http://www.desenvolvimentoagil.com.br/scrum/sprint_backlog'
                              target='_new'>Desenvolvimento &Aacute;gil</a>"><i class="fa fa-info-circle"></i>&nbsp;Qtd. entregas/sprints
                        </span>
                    </label><br />
                    <div class="wrap-input100 m-b-0 m-t-16">
                        <input type="text" class="input100 spinnumber" id="entregas" name="entregas" maxlength="2" value="1" data-mask="00" readonly>
                        <span class="focus-input100" data-placeholder=""></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for=nome_gerente_projeto">
                        <span class="pop"
                              data-placement="bottom" data-toggle="popover" title="<i
                              class='fa fa-arrow-circle-right'></i> Gerente do projeto"
                              data-content="
                              <p align='justify'>O gerente do projeto ter&aacute; acesso a
                              funcionalidades de planejamento e execu&ccedil;&atilde;o. Esta
                              funcionalidade estar&aacute; dispon&iacute;vel apenas se sua
                              empresa utilizar o gerenciamento de projetos em conjunto com as
                              contagens.</p>"><i class="fa fa-info-circle"></i>&nbsp;Gerente do projeto</span>
                    </label><br />
                    <input type="hidden" id="gerente_projeto">
                    <!--email-->
                    <div class="wrap-input100 m-b-0">
                        <input type="text" id="nome_gerente_projeto" class="input100" maxlength="255" disabled>
                        <span class="focus-input100" data-placeholder=""></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="id_linguagem">
                        <span id="lbl_linguagem" class="pop"
                              data-placement="bottom" data-toggle="popover" title="<i
                              class='fa fa-arrow-circle-right'></i> Linguagem de
                              programa&ccedil;&atilde;o" data-content="Caso não encontre a
                              linguagem de programação utilizada por sua aplicação/contagem,
                              entre em contato com o Administrador do sistema para que ele
                              atualize o cadastro."><i class="fa fa-info-circle"></i>&nbsp;Linguagem</span>
                    </label><br />
                    <select id="id_linguagem" name="id_linguagem" title="Linguagem" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;"></select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="div_produtividade">
                        <span class="pop"
                              data-placement="bottom" data-toggle="popover" title="<i
                              class='fa fa-arrow-circle-right'></i> Produtividade" data-content="
                              <p align='justify'>
                              <i class='fa fa-lightbulb-o'></i>&nbsp;Refer&ecirc;ncias

                              <hr> Algumas linguagens tiveram sua produtividade definida por
                              analogia e/ou pesquisa de mercado e outras tiveram sua
                              produtividade m&eacute;dia calculada a partir de
                              estat&iacute;sticas retiradas do site <a
                              href=http://www.winbid.com.br/Informacoes/Noticias/0140_Produtividade-das-linguagens-em-pontos-por-funcao-APF
                              target=_new> Winbid - Neg&oacute;cios governamentais</a> e da
                              colabora&ccedil;&atilde;o dos nossos usu&aacute;rios. Geralmente os
                              projetos s&atilde;o estimados com a produtividade m&eacute;dia.
                              <hr> <strong>FONTE</strong>:&nbsp;<a
                              href='http://www.pgfn.gov.br/acesso-a-informacao/tecnologia-da-informacao/Roteiro_Contagem_PF_SERPRO_%207.pdf'
                              target='_new'>Roteiro de M&eacute;tricas do SERPRO</a>. P&aacute;g.
                              19 a 21.
                              </p>"><i id="w_produtividade" class="fa fa-dot-circle-o"></i>&nbsp;<i class="fa fa-info-circle"></i>&nbsp;Produtividade (h/PF)</span></label><br />
                    <div class="wrap-input100 m-b-0">
                        <input type="text" class="input100" id="div_produtividade" disabled>
                        <span class="focus-input100" data-placeholder=""></span>
                    </div>
                    <input type="hidden" id="produtividade-media" value="0">
                    <input type="hidden" id="produtividade-baixa" value="0">
                    <input type="hidden" id="produtividade-alta" value="0">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="id_tipo_contagem">Tipo</label><br />
                    <select id="id_tipo_contagem" name="id_tipo_contagem" title="Tipo da contagem" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;"></select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="id_etapa"><span id="idEtapa">Etapa</span></label><br />
                    <select id="id_etapa" name="id_etapa" title="Etapa" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;"></select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="id_banco_dados">
                        <span id="lbl_banco_dados" class="pop"
                              data-placement="bottom" data-toggle="popover" title="<i
                              class='fa fa-arrow-circle-right'></i> Banco de dados (SGBD)"
                              data-content="Caso não encontre o Banco de Dados utilizado por
                              sua aplicação/contagem, entre em contato com o Administrador do
                              sistema para que ele atualize o cadastro."><i
                                class="fa fa-info-circle"></i>&nbsp;Banco de dados (SGBD)</span>
                    </label><br />
                    <select id="id_banco_dados" name="id_banco_dados" title="Banco de dados (SGBD)" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;"></select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="id_industria">&Aacute;rea de atua&ccedil;&atilde;o</label><br />
                    <select id="id_industria" name="id_industria" title="&Aacute;rea de atua&ccedil;&atilde;o" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;"></select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="id_processo">Processo de desenvolvimento</label><br />
                    <select id="id_processo" name="id_processo" title="Processo de Desenvolvimento" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;"></select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="id_processo_gestao">Processo de Gest&atilde;o</label><br />
                    <select id="id_processo_gestao" name="id_processo_gestao" title="Processo de Gest&atilde;o do Desenvolvimento" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;"></select>
                </div>
            </div>
            <!--
            <div class="col-md-3">
                <div class="form-group">
                    <label for="id_sistema">
                        <span class="pop"
                              data-placement="bottom" data-toggle="popover" title="<i
                              class='fa fa-arrow-circle-right'></i> Sistema"
                              data-content="Este campo pode ter v&aacute;rias denomina&ccedil;&otilde;es: Sistema, Software, Aplica&ccedil;&atilde;o, etc."
                              ><i class="fa fa-info-circle"></i>&nbsp;Sistema</span>
                    </label><br />
                    <select id="id_sistema" name="id_sistema" title="Sistema" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;"></select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="id_modulo">
                        <span class="pop"
                              data-placement="bottom" data-toggle="popover" title="<i
                              class='fa fa-arrow-circle-right'></i> M&oacute;dulo do Sistema"
                              data-content="Este campo n&atilde;o &eacute; obrigat&oacute;rio."
                              ><i class="fa fa-info-circle"></i>&nbsp;M&oacute;dulo do Sistema</span>
                    </label><br />
                    <select id="id_modulo" name="id_modulo" title="M&oacute;dulo do Sistema" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;"></select>
                </div>
            </div>-->
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="proposito">Prop&oacute;sito da contagem</label>
                    <textarea id="proposito" name="proposito" class="form-control input100 scroll textarea"
                              maxlength="3000" title="Proposito" style="height: 150px; max-height: 150px; border: 1px dotted #e0e0e0; border-bottom: 2px solid #d9d9d9;"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="escopo">Escopo da contagem</label>
                    <textarea id="escopo" name="escopo" class="form-control input100 scroll textarea"
                              maxlength="3000" title="Escopo" style="height: 150px; max-height: 150px; border: 1px dotted #e0e0e0; border-bottom: 2px solid #d9d9d9;"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>