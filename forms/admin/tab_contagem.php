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
<div class="panel panel-default">
    <div class="panel-title">
        <i class="fa fa-info-circle fa-lg"></i>&nbsp;&nbsp;Contagem<br />
        <span class="sub-header">Parametrize seu processo de contagem, aplic&aacute;vel tamb&eacute;m aos seus fornecedores</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <div style="border: 1px dotted #f68; padding: 5px; min-height: 36px; vertical-align: middle; margin-bottom: 4px; border-radius: 5px;">
                            Para efetuar quaisquer alterações nas configurações do sistema <strong>exceto - Informações Iniciais</strong>, por favor, selecione primeiro um Cliente.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select id="config_id_cliente" class="input_style"></select>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-4">
                        <strong><a href="#" id="fmccon-link"><i class="fa fa-pencil-square-o"></i>&nbsp;Contagens</a></strong><br />
                        Configura&ccedil;&otilde;es gerais das contagens, formas de acesso e visualiza&ccedil;&otilde;es<br /><br />
                        <div id="div-alerta-is-fornecedor" style="border:1px dotted #f68; padding:5px; margin-bottom: 15px; border-radius: 5px;"></div>
                        <strong><a href="#" class="fmocti-link"><i class="fa fa-list-alt"></i>&nbsp;Informações iniciais</a></strong><br />
                        Definição do padrão de informações iniciais das Contagens
                    </div>
                    <div class="col-md-4">
                        <strong><a href="#" id="fmctar-link"><i class="fa fa-tasks"></i>&nbsp;<span id="configuracoes-tarefas">Prazos (tarefas)</span></a></strong><br />
                        Configura&ccedil;&otilde;es gerais os prazos de tarefas geradas pelo sistema<br /><br />
                        <div style="border: 1px dotted #f68; padding: 5px; border-radius: 5px;" id="div-configuracoes"></div>                
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fa fa-cogs"></i>&nbsp;COCOMO II.2000</strong><br />
                        Parametrização e calibragem do Modelo COCOMO II.2000<br /><br />
                        <strong><a href="#" id="cocomo-link-escala">
                                <i class="fa fa-dashboard"></i>&nbsp;Escala - <i>Software Scale Drivers</i> & A, B, C e D</a></strong><br />
                        <strong><a href="#" id="cocomo-link-projeto-inicial">
                                <i class="fa fa-object-group"></i>&nbsp;Custo - Projeto Inicial (<i>Early Design</i>)</a></strong><br />                        
                        <strong><a href="#" id="cocomo-link-pos-arquitetura">
                                <i class="fa fa-object-ungroup"></i>&nbsp;Custo - P&oacute;s Arquitetura (<i>Post-Architechture</i>)</a></strong><br />
                        <strong><a href="#" id="cocomo-link-fases">
                                <i class="fa fa-list"></i>&nbsp;Configura&ccedil;&atilde;o de distribui&ccedil;&atilde;o percentual nas fases</a></strong><br /><br />
                        <strong><i class="fa fa-code"></i>&nbsp;Linguagens de Programa&ccedil;&atilde;o</strong><br />
                        Linguagens, convers&atilde;o UFP/SLOC, produtividade e Fator Tecnologia - FT<br /><br />
                        <strong><a href="#" id="cocomo-link-linguagem">
                                <i class="fa fa-list-alt"></i>&nbsp;Configurar</a></strong><br /><br /><br />                   
                        <strong><i class="fa fa-database"></i>&nbsp;Banco de Dados</strong><br />
                        Configura&ccedil;&atilde;o dos Bancos de Dados utilizados nas contagens<br /><br />
                        <?php
                        echo (!(isFornecedor() || getConfigPlano('id') < 3)) ?
                                '<strong><a href="#" id="link-inserir-banco-dados">
                        <i class="fa fa-plus-circle"></i>&nbsp;Inserir ou alterar</a></strong>' :
                                '<strong><i class="fa fa-plus-circle"></i>&nbsp;Inserir ou alterar</strong>';
                        ?>
                        <br /><br />
                        <div id="div-alerta-is-fornecedor-cocomo" style="border: 1px dotted #f68; padding: 5px; border-radius: 5px;"></div>
                    </div>     
                </div>
            </div>
        </div>
    </div>
</div>