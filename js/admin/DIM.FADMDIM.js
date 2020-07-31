$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    activeTab = e.target['hash'];
    if (activeTab === '#fornecedores') {
        formulario = 'forn';
        tCaptcha = 'fmiafor';
        if ($('#combo_alterar_id_fornecedor').val() < 1) {
            comboFornecedores('combo_alterar', 0, '01', 0, true);
            comboFornecedores('combo_alterar_auditoria', 0, '01', 2, true);
            $('#' + formulario + '-info').css({visibility: 'hidden'});
        }
    }
    else if (activeTab === '#contagem') {
        isFornecedor ? comboCliente('config', idCliente, '0', idFornecedor) : comboCliente('config', idCliente, '0', 0);
        isFornecedor ? $('#config_id_cliente').prop('disabled', true) : null;
    }
    else {
        formulario = 'turma';
        tCaptcha = 'fmiaturma';
        if ($('#combo_alterar_id_turma').val() < 1) {
            comboFornecedores('combo_alterar', 0, '01', 1, true);
            $('#' + formulario + '-info').css({visibility: 'hidden'});
        }
    }
});
//scripts associados as acoes e listas dos modais administrativos
$(document).ready(function () {
    /*
     * demais variaveis
     */
    var pop_content_adm_validar = "<p align='justify'>Por padr&atilde;o o sistema permite que apenas os Gestores e Validadores " +
            "executem as valida&ccedil;&otilde;es nas contagens (Grupo de Valida&ccedil;&atilde;o, Escrit&oacute;rio de M&eacute;tricas, etc). " +
            "Entretanto, no momento do cadastro do usu&aacute;rio, existe a possibilidade de " +
            "ALGUNS Administradores / Analistas de M&eacute;tricas poderem validar contagens.";
    $("#pop_content_adm_validar").attr("data-content", pop_content_adm_validar);

    var pop_content_linguagem = "<div class='row'>" +
            "<div class='col-md-12'>" +
            "Legenda na sele&ccedil;&atilde;o da Linguagem</div>" +
            "</div>" +
            "</div>" +
            "<div class='row'>" +
            "<div class='col-md-4'><i class='fa fa-stop' style='color: #000000;'></i>&nbsp;Itens padr&atilde;o</div>" +
            "<div class='col-md-4'><i class='fa fa-stop' style='color: #669933;'></i>&nbsp;Itens de sugest&atilde;o</div>" +
            "<div class='col-md-4'><i class='fa fa-stop' style='color: #999999;'></i>&nbsp;Itens banidos</div>" +
            "</div>" +
            "<hr>" +
            "<div class='row'>" +
            "<div class='col-md-6'>" +
            "<p align='justify'>O sistema Dimension permite que um usu&aacute;rio insira uma <strong>Linguagem</strong>, caso esta n&atilde;o seja encontrada nas op&ccedil;&otilde;es " +
            "padr&atilde;o do sistema, entretanto algumas dessas sugest&otilde;es n&atilde;o s&atilde;o aplic&aacute;veis aos seus projetos. Desta forma voc&ecirc; pode desabilitar a visualiza&ccedil;&atilde;o destes " +
            "itens na listagem. Entretanto, as sugest&otilde;es feitas pelos seus pr&oacute;prios colaboradores ser&atilde;o visualizadas.</p>" +
            "</div>" +
            "<div class='col-md-6'>" +
            "<center><img src='/pf/img/ajuda/img_ajuda_linguagem.png' class='img-thumbnail' alt='Sele&ccedil;&atilde;o da linguagem'></center>" +
            "</div>" +
            "</div>";
    $("#pop_content_linguagem").attr("data-content", pop_content_linguagem);

    var pop_content_horas_liquidas = "<p align='justify'>Horas L&iacute;quidas Trabalhadas - HLT &eacute; a quantidade de horas reais dispensadas pelos envolvidos em um projeto descontando-se sa&iacute;das/pausas do tipo:</p>" +
            "<ul>" +
            "<li>Caf&eacute;</li>" +
            "<li>Atrasos</li>" +
            "<li>Pausa para o fumo</li>" +
            "<li>Aprendizado espont&acirc;neo</li>" +
            "<li>Reuni&otilde;es fora do contexto do projeto (Diretoria, Gerenciais, Cliente, etc.)</li>" +
            "<li>Treinamentos</li>" +
            "</ul>" +
            "Defina a quantidade em fra&ccedil;&otilde;es de 0,25 da hora. Ex.: 7.25, 7.50...";
    $("#pop_content_horas_liquidas").attr("data-content", pop_content_horas_liquidas);

    var pop_content_gestao_projetos = "<p align='justify'>Utilize esta op&ccedil;&atilde;o caso sua empresa tenha um grupo de gerentes de projetos. Para acessar estas funcionalidades os colaboradores devem estar previamente cadastrados no grupo &quot;Gerentes de Projeto&quot; e cada projeto deve ter apenas um gerente.</p>";
    $("#pop_content_gestao_projetos").attr("data-content", pop_content_gestao_projetos);
    
    //para alteracao em um cliente
    comboCliente('combo_alterar', (isFornecedor ? idCliente : 0), '01', (isFornecedor ? idFornecedor : 0));
    //verifica se eh um fornecedor e desabilita as abas para adicionar fornecedor e cliente
    if (isFornecedor) {
        //mutacao para a tab configuracoes-empresa-fornecedores
        //minhas configuracoes, no caso de fornecedores
        $('#configuracoes-empresa-fornecedores').html('<a data-toggle="tab" href="#conf-fornecedor"><div class="top-title"><i class="fa fa-adjust fa-lg"></i><!--<span class="not-view"><br>Minhas configura&ccedil;&otilde;es<br /></span>--></div><span class="not-view"><strong>Ajustar</strong></span></a>');
        //altera as configuracoes de titulos do formulario de fornecedores e desabilita acoes que o fornecedor nao deve ter acesso
        $('#i-forn-titulo').removeClass('fa-building-o').addClass('fa-adjust');
        $('#span-forn-titulo').html('Ajustes e configura&ccedil;&otilde;es');
        $('#h4-forn-titulo').html('Minhas informa&ccedil;&otilde;es');
        $('#forn-btn-inserir').prop('disabled', isInst ? false : true);//isInst = eh um instrutor?
        $('#forn-btn-novo').prop('disabled', isInst ? false : true);
        $('#forn-btn-atualizar').prop('disabled', false);
        $('#forn-is-ativo').bootstrapToggle(isInst ? 'enable' : 'disable');
        //reforma a aba clientes, ja que eh apenas um fornecedor
        $.post('/pf/DIM.Gateway.php', {
            'arq': 59,
            'tch': 1,
            'sub': 0,
            'dlg': 1,
            'i': idCliente}, function (data) {
            $('#fmiacli_info').css({visibility: 'visible'});
            if (data.logomarca !== null)
                $('#fmiacli_span_logomarca').html('<img src="/pf/vendor/cropper/producao/crop/img/img-cli/' + data.logomarca + '.png?' + new Date().getTime() + '" class="img-thumbnail" width="150" height="150">');
            else
                $('#fmiacli_span_logomarca').html('<img src="/pf/img/blank_logo.pt_BR.jpg" class="img-thumbnail img-responsive" width="150" height="150">');
            $('#fmiacli_span_descricao').html(data.descricao);
            $('#fmiacli_span_nome').html(data.nome);
            $('#fmiacli_span_email').html('<a href="mailto:' + data.email + '">' + data.email + '</a>');
            $('#fmiacli_span_telefone').html(data.telefone);
        }, 'json');
        $('#fmiacli_btn_alterar').prop('disabled', true);
        $('#fmiacli-label-acao').html('Informa&ccedil;&otilde;es do cliente');
        $('#fmiacli-titulo').html('Informa&ccedil;&otilde;es do cliente');
        $('#cli-inserir').css('text-decoration', 'line-through');
        $('#fmiacli-label-informacao')
                .css({'border': '1px dotted #f68', 'padding': '5px', 'border-radius': '5px'})
                .html('Atualmente voc&ecirc; est&aacute; logado como um <strong>Fornecedor, ou est&aacute; associado a um Plano DEMO/ESTUDANTE</strong>, n&atilde;o sendo poss&iacute;vel o gerenciamento de clientes');
        $('#combo_alterar_id_cliente').prop('disabled', isFornecedor);
        //permite apenas algumas configuracoes nas contagens pois herda da empresa contratante
        //estas abaixo ficam desabilitadas
        $('#quantidade_maxima_entregas').prop('disabled', true);
        $('#is_processo_validacao').prop('disabled', true);
        $('#is_visualizar_roteiros_publicos').prop('disabled', true);
        $('#is_validar_adm_gestor').prop('disabled', true);
        $('#is_visualizar_sugestao_linguagem').prop('disabled', true);
        $('#is_visualizar_contagem_fornecedor').prop('disabled', true);
        var divAlertaIsFornecedor = 'Voc&ecirc; est&aacute; logado como um Fornecedor e as op&ccedil;&otilde;es de:' +
                '<ul class="fa-ul">' +
                '<li><i class="fa fa-arrow-circle-o-right"></i> Quantidade de entregas;</li>' +
                '<li><i class="fa fa-arrow-circle-o-right"></i> Processo de valida&ccedil;&atilde;o;</li>' +
                '<li><i class="fa fa-arrow-circle-o-right"></i> Visualizar roteiros p&uacute;blicos;</li>' +
                '<li><i class="fa fa-arrow-circle-o-right"></i> Valida&ccedil;&atilde;o por Administradores e Analistas;</li>' +
                '<li><i class="fa fa-arrow-circle-o-right"></i> Visualizar sugest&otilde;es de linguagem;</li>' +
                '<li><i class="fa fa-arrow-circle-o-right"></i> e, permitir Analistas de M&eacute;tricas visualizar contagens de Fornecedor, ' +
                'estar&atilde;o <strong>desabilitadas</strong> e portanto, n&atilde;o poder&atilde;o ser alteradas. Caso deseje uma configura&ccedil;&atilde;o diferenciada entre em contato com o Administrador da empresa Contratante.</li></ul>';
        var divAlertaIsFornecedorCocomo = 'Voc&ecirc; est&aacute; logado como um Fornecedor, sendo assim, n&atilde;o &eacute; poss&iacute;vel calibrar o Modelo COCOMO II.2000';
        $('#div-alerta-is-fornecedor')
                .html(divAlertaIsFornecedor)
                .css('visibility', 'visible');
        $('#div-alerta-is-fornecedor-cocomo')
                .html(divAlertaIsFornecedorCocomo)
                .css('visibility', 'visible');
        //exibe a primeira tab ativa
        exibeTabAtiva();
    }
    else {
        //mutacao para a tab configuracoes-empresa-fornecedores
        $('#configuracoes-empresa-fornecedores').html('<a data-toggle="tab" href="#empresa"><div class="top-title"><i class="fa fa-cogs fa-lg"></i><!--<span class="not-view"><br>Configurar empresa<br /></span>--></div><span class="not-view"><strong>Empresa</strong></span></a>');
        //exibe a primeira tab dos fornecedores
        //pega a primeira tab ativa e exibe
        exibeTabAtiva();
        //monta uma combo com os fornecedores
        //tipo = 0 - fornecedor, 1 - turma
        comboFornecedores('combo_alterar', 0, '01', activeTab === '#treinamentos' ? 1 : '0, 2', true);
        //oculta a div de alerta do fornecedor
        $('#div-alerta-is-fornecedor').css('visibility', 'hidden');
        $('#div-alerta-is-fornecedor-cocomo').css('visibility', 'hidden');
    }
});

function exibeTabAtiva() {
    $("#ul-adm li").each(function () {
        if (!($(this).hasClass('disabled'))) {
            var activeTab;
            var tTab = $(this).get(0).id;
            var aTab = tTab.split('-');
            activeTab = $('[href=#' + aTab[1] + ']');
            activeTab && activeTab.tab('show');
            return false;
        }
    });
}