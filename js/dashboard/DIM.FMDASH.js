var anoContagem = $('#dashboard-ano-contagem').val();
var dt = new Date();
var tNow = new Date();
// array de funcionalidades
var arFuncoes = ['ali', 'aie', 'ee', 'se', 'ce', 'ou'];
var arComplexidade = ['baixa', 'media', 'alta', 'ef'];
var arSituacao = [0, 1, 2, 3, 4, 5, 6, 7];
var key = 'AIzaSyDwpX8-GnIlRUsbMqJtvC9EagaEHr7-kQs';

$(document).ready(function () {
    //primeiro para os fornecedores
    if (isFornecedor) {
        comboProjetoBaseline($('#dashboard-projeto-todos').prop('checked') ? '1' : '01', $('#baseline_id_projeto'));
        // pega todos os jsons de dashboard
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.' + dt.getFullYear() + '.contagens.mes.json?v=' + tNow.getTime(), contagensMes);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.' + dt.getFullYear() + '.contagens.pf.mes.json?v=' + tNow.getTime(), contagensPFMes);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.complexidade.funcoes.json?v=' + tNow.getTime(), complexidadeFuncoes);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.contagem.situacao.json?v=' + tNow.getTime(), contagemSituacao);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.contagem.tipo.json?v=' + tNow.getTime(), contagemTipo);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.contagem.etapa.json?v=' + tNow.getTime(), contagemEtapa);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.contagem.abrangencia.json?v=' + tNow.getTime(), contagemAbrangencia);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.metodo.funcoes.json?v=' + tNow.getTime(), contagemMetodoFuncoes);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.banco.dados.json?v=' + tNow.getTime(), bancoDados);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.situacao.funcoes.consolidado.json?v=' + tNow.getTime(), contagemSituacaoFuncoesConsolidado);
        // totais de funcionalidades da empresa
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.situacao.funcoes.json?v=' + tNow.getTime(), function (data) {
            for (x = 0; x < arFuncoes.length; x++) {
                $('#dashboard-' + arFuncoes[x] + '-nao-validados').html(data[x].naovalidado);
                $('#dashboard-' + arFuncoes[x] + '-validados').html(data[x].validado);
                $('#dashboard-' + arFuncoes[x] + '-em-revisao').html(data[x].emrevisao);
                $('#dashboard-' + arFuncoes[x] + '-revisados').html(data[x].revisado);
            }
        }, 'json');
        // totais de funcionalidades da empresa
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.complexidade.funcoes.json?v=' + tNow.getTime(),
                function (data) {
                    for (x = 0; x < arComplexidade.length; x++) {
                        $('#contagem-complexidade-' + arComplexidade[x]).html(data.data[x]);
                    }
                }, 'json');
        // totais por processo nas contagens
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.contagem.situacao.json?v=' + tNow.getTime(),
                function (data) {
                    for (x = 0; x < arSituacao.length; x++) {
                        $('#contagem-situacao-' + arSituacao[x]).html(data.data[x]);
                    }
                }, 'json');
    }
    //depois para as empresas
    else {
        // preenche a combo baseline
        comboBaseline(0, '1', $("#contagem_id_baseline"), 1);
        // preenche a combo projeto
        comboProjetoBaseline($('#dashboard-projeto-todos').prop('checked') ? '1' : '01', $('#baseline_id_projeto'));
        // pega todos os jsons de dashboard
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.' + dt.getFullYear() + '.contagens.mes.json?v=' + tNow.getTime(), contagensMes);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.' + dt.getFullYear() + '.contagens.pf.mes.json?v=' + tNow.getTime(), contagensPFMes);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.complexidade.funcoes.json?v=' + tNow.getTime(), complexidadeFuncoes);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.contagem.situacao.json?v=' + tNow.getTime(), contagemSituacao);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.contagem.tipo.json?v=' + tNow.getTime(), contagemTipo);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.contagem.etapa.json?v=' + tNow.getTime(), contagemEtapa);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.contagem.abrangencia.json?v=' + tNow.getTime(), contagemAbrangencia);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.metodo.funcoes.json?v=' + tNow.getTime(), contagemMetodoFuncoes);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.banco.dados.json?v=' + tNow.getTime(), bancoDados);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.situacao.funcoes.consolidado.json?v=' + tNow.getTime(), contagemSituacaoFuncoesConsolidado);
        // totais de funcionalidades da empresa
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.situacao.funcoes.json?v=' + tNow.getTime(), function (data) {
            for (x = 0; x < arFuncoes.length; x++) {
                $('#dashboard-' + arFuncoes[x] + '-nao-validados').html(data[x].naovalidado);
                $('#dashboard-' + arFuncoes[x] + '-validados').html(data[x].validado);
                $('#dashboard-' + arFuncoes[x] + '-em-revisao').html(data[x].emrevisao);
                $('#dashboard-' + arFuncoes[x] + '-revisados').html(data[x].revisado);
            }
        }, 'json');
        // totais de funcionalidades da empresa
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.complexidade.funcoes.json?v=' + tNow.getTime(),
                function (data) {
                    for (x = 0; x < arComplexidade.length; x++) {
                        $('#contagem-complexidade-' + arComplexidade[x]).html(data.data[x]);
                    }
                }, 'json');
        // totais por processo nas contagens
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.contagem.situacao.json?v=' + tNow.getTime(),
                function (data) {
                    for (x = 0; x < arSituacao.length; x++) {
                        $('#contagem-situacao-' + arSituacao[x]).html(data.data[x]);
                    }
                }, 'json');
    }
});
/*
 * captura os clicks em determinadas tabs
 */
$('a[data-toggle="tab"]').on(
        'shown.bs.tab',
        function (e) {
            var link = String(e.target);
            link = link.split('#');
            if (link[1] === 'dashboard-financeiro') {
                if (isFornecedor) {
                    RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(idFornecedor) + '/' + sha1(idFornecedor) + '.contrato.pf.json?v=' + tNow.getTime(), contratoPF);
                }
                else {
                    RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(("00000000000" + idEmpresa).slice(-11)) + '.contrato.pf.json?v=' + tNow.getTime(), contratoPF);
                }
            }
        });
// na baseline de projeto
$('#dashboard-projeto-todos').on('change', function () {
    comboProjetoBaseline($(this).prop('checked') ? '1' : '01', $('#baseline_id_projeto'));
});

$("#contagem_id_cliente").on("change", function () {
    sel = $("#contagem_id_contrato");
    sel.empty().append('<option value="0">...</option>');
    sel = $("#contagem_id_projeto");
    sel.empty().append('<option value="0">...</option>');
    if ($(this).val() > 0) {
        comboContrato($(this).val(), '01', 0, 0, 'contagem');
    }
});

$("#contagem_id_contrato").on("change", function () {
    sel = $("#contagem_id_projeto");
    sel.empty().append('<option value="0">...</option>');
    if ($(this).val() > 0) {
        comboProjeto($(this).val(), '01', 0, 'contagem');
    }
});

$('#baseline_id_projeto').on('change', function () {
    var v = $(this).val();
    var exibeLista = false;
    if (v > 0) {
        // consolida as informacoes do projeto
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/projeto/' + (isFornecedor ? sha1(idFornecedor) + '/' : '') + sha1(v) + '.situacao.funcoes.json?v=' + tNow.getTime(), function (data) {
            for (x = 0; x < arFuncoes.length; x++) {
                $('#dashboard-' + arFuncoes[x] + '-nao-validados-projeto').html(data[x].naovalidado);
                $('#dashboard-' + arFuncoes[x] + '-validados-projeto').html(data[x].validado);
                $('#dashboard-' + arFuncoes[x] + '-em-revisao-projeto').html(data[x].emrevisao);
                $('#dashboard-' + arFuncoes[x] + '-revisados-projeto').html(data[x].revisado);
            }
        }, 'json');
        // complexidade das funcionalidades do projeto
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/projeto/' + (isFornecedor ? sha1(idFornecedor) + '/' : '') + sha1(v) + '.complexidade.funcoes.json?v=' + tNow.getTime(), function (data) {
            for (x = 0; x < arComplexidade.length; x++) {
                $('#contagem-complexidade-' + arComplexidade[x] + '-projeto').html(data.data[x]);
            }
        }, 'json');
        // desenha os graficos
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/projeto/' + (isFornecedor ? sha1(idFornecedor) + '/' : '') + sha1(v) + '.complexidade.funcoes.json?v=' + tNow.getTime(), complexidadeFuncoesProjeto);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/projeto/' + (isFornecedor ? sha1(idFornecedor) + '/' : '') + sha1(v) + '.situacao.funcoes.consolidado.json?v=' + tNow.getTime(), contagemSituacaoFuncoesConsolidadoProjeto);
        // monta a tabela com as contagens
        var tbl = document.getElementById('contagensAssociadas');
        $('#contagensAssociadas').empty();
        // pega o arquivo do dashboard
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/projeto/' + (isFornecedor ? sha1(idFornecedor) + '/' : '') + sha1(v) + '.lista.contagens.projeto.json?v=' + tNow.getTime(), function (data) {
            for (x = 0; x < data.length; x++) {
                if (sha1(data[x].user_id) !== UserIdSha1) {
                    if (data[x].privacidade == 0) {
                        exibeLista = true;
                    } else {
                        exibeLista = false;
                    }
                } else {
                    exibeLista = true;
                }
                // verifica se pode ver
                var row = tbl.insertRow(-1);
                var cell0 = row.insertCell(0);
                var cell1 = row.insertCell(1);
                var cell2 = row.insertCell(2);

                cell0.setAttribute('width', '05%');
                cell1.setAttribute('width', '75%');
                cell1.setAttribute('style', 'line-height: 38px;');
                cell2.setAttribute('width', '20%');
                cell2.setAttribute('style', 'line-height: 38px;');

                cell0.innerHTML = '<a href="mailto:' + data[x].user_email + '"><img src="/pf/vendor/cropper/producao/crop/img/img-user/' + sha1(data[x].user_id) + '.png" class="img-circle" width="38" height="38" /></a>';
                cell1.innerHTML = (data[x].privacidade == 0 ? '<i class="fa fa-circle-o"></i>&nbsp;' : '<i class="fa fa-ban"></i>&nbsp;')
                        + '#ID: ' + ("0000000" + data[x].id).slice(-7) + ' . '
                        + formattedDate(data[x].data_cadastro, false, false) + ' . '
                        + data[x].ordem_servico + ' . <strong>' + data[x].processo + '</strong>'
                        + (data[x].id_fornecedor != 0 ? ' . <i class="fa fa-angle-double-left"></i>&nbsp;' + data[x].sigla + '&nbsp;<i class="fa fa-angle-double-right"></i>' : '');
                cell2.innerHTML = '<div class="btn-group btn-group-sm btn-group-justified">'
                        + '<div class="btn-group btn-group-sm">'
                        + '<button type="button" class="btn btn-default" onclick="window.open(\'/pf/DIM.Gateway.php?arq=62&tch=0&sub=3&dlg=1&i='
                        + data[x].id
                        + '\');" '
                        + (exibeLista ? ''
                                : 'disabled')
                        + '><i class="fa fa-file-pdf-o"></i><span class="not-view">&nbsp;&nbsp;PDF</span></button>'
                        + '</div>'
                        + '<div class="btn-group btn-group-sm">'
                        + '<button type="button" class="btn btn-default" onclick="window.open(\'/pf/DIM.Gateway.php?arq=61&tch=0&sub=3&dlg=1&i='
                        + data[x].id
                        + '&p=html\');" '
                        + (exibeLista ? ''
                                : 'disabled')
                        + '><i class="fa fa-external-link"></i><span class="not-view">&nbsp;&nbsp;HTML<span></button>'
                        + '</div>'
                        + '<!--<div class="btn-group btn-group-sm">'
                        + '<button type="button" class="btn btn-default" onclick="window.open(\'/pf/DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=vw&ab='
                        + data[x].id_abrangencia
                        + '&id='
                        + data[x].id
                        + '\');" '
                        + (exibeLista ? ''
                                : 'disabled')
                        + '><i class="fa fa-search"></i><span class="not-view">&nbsp;&nbsp;Ver</span></button>'
                        + '</div>-->'
                        + '</div>';
                exibeLista = false;
            }
        }, 'json');
    }
});

$('#contagem_id_baseline').on('change', function () {
    var v = $(this).val();
    var exibeLista = false;
    if (v > 0) {
        // consolida as informacoes da baseline
        // totais de funcionalidades da empresa
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(v) + '/situacao.funcoes.json?v=' + tNow.getTime(), function (data) {
            for (x = 0; x < arFuncoes.length; x++) {
                $('#dashboard-' + arFuncoes[x] + '-nao-validados-baseline').html(data[x].naovalidado);
                $('#dashboard-' + arFuncoes[x] + '-validados-baseline').html(data[x].validado);
                $('#dashboard-' + arFuncoes[x] + '-em-revisao-baseline').html(data[x].emrevisao);
                $('#dashboard-' + arFuncoes[x] + '-revisados-baseline').html(data[x].revisado);
            }
        }, 'json');
        // totais de funcionalidades da empresa
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(v) + '/complexidade.funcoes.json?v=' + tNow.getTime(), function (data) {
            for (x = 0; x < arComplexidade.length; x++) {
                $('#contagem-complexidade-' + arComplexidade[x] + '-baseline').html(data.data[x]);
            }
        }, 'json');
        // desenha os graficos
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(v) + '/complexidade.funcoes.json?v=' + tNow.getTime(), complexidadeFuncoesBaseline);
        RGraph.AJAX.getJSON('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(v) + '/situacao.funcoes.consolidado.json?v=' + tNow.getTime(), contagemSituacaoFuncoesConsolidadoBaseline);
        // lista os clientes
        isFornecedor ? comboCliente('contagem', idCliente, '0', idFornecedor) : comboCliente('contagem', 0, '0', 0);
        $('#contagem_id_cliente').prop('disabled', isFornecedor ? true : false);
        $('#contagem_id_contrato').prop('disabled', false);
        $('#contagem_id_projeto').prop('disabled', false);
        $.get('/pf/dashboard/' + sha1(idEmpresa) + '/' + sha1(v) + '/' + 'lista.funcoes.baseline.json?v=' + tNow.getTime(), function (data) {
            // limpa tudo
            $('#menu-funcionalidades').empty();
            // pega a div menu
            var menu = document.getElementById('menu-funcionalidades');
            // cria o list-group
            var listGroup, divTDTR, arrTD, descTD, arrTR, descTR, chkBox, lblBox;
            var listaAli, nomeFuncaoAli, listGroupAli, aliTD, aliDivTD, aliTR, aliDivTR;
            var listaAie, nomeFuncaoAie, listGroupAie, aieTD, aieDivTD, aieTR, aieDivTR;
            var listaEe, nomeFuncaoEe, listGroupEe, eeTD, eeDivTD, eeTR, eeDivTR;
            var listaSe, nomeFuncaoSe, listGroupSe, seTD, seDivTD, seTR, seDivTR;
            var listaCe, nomeFuncaoCe, listGroupCe, ceTD, ceDivTD, ceTR, ceDivTR;
            listGroup = document.createElement('div');
            listGroup.className = 'list-group';
            // adiciona o list-group ao menu
            menu.appendChild(listGroup);
            // cria as funcionalidades ALI, AIE, etc
            listGroupAli = document.createElement('a');
            listGroupAli.className = 'list-group-item';
            listGroupAli.setAttribute('href', '#');
            listGroupAli.setAttribute('data-toggle', 'collapse');
            listGroupAli.setAttribute('data-target', '#lista-ali');
            listGroupAli.setAttribute('data-parent', '#menu');
            listGroupAli.innerHTML = '<i class="fa fa-database"></i>&nbsp;&nbsp;Arquivos L&oacute;gicos Internos - ALI';
            listGroup.appendChild(listGroupAli);
            // cria o item de lista de alis
            listaAli = document.createElement('div');
            listaAli.id = 'lista-ali';
            listaAli.className = 'sublinks collapse';
            listGroup.appendChild(listaAli);
            // arquivos aie cria as funcionalidades ALI, AIE, etc
            listGroupAie = document.createElement('a');
            listGroupAie.className = 'list-group-item';
            listGroupAie.setAttribute('href', '#');
            listGroupAie.setAttribute('data-toggle', 'collapse');
            listGroupAie.setAttribute('data-target', '#lista-aie');
            listGroupAie.setAttribute('data-parent', '#menu');
            listGroupAie.innerHTML = '<i class="fa fa-sign-in"></i>&nbsp;&nbsp;Arquivos de Interface Externa  - AIE';
            listGroup.appendChild(listGroupAie);
            // cria o item de lista de alis
            listaAie = document.createElement('div');
            listaAie.id = 'lista-aie';
            listaAie.className = 'sublinks collapse';
            listGroup.appendChild(listaAie);
            // arquivos ee cria as funcionalidades ALI, AIE, etc
            listGroupEe = document.createElement('a');
            listGroupEe.className = 'list-group-item';
            listGroupEe.setAttribute('href', '#');
            listGroupEe.setAttribute('data-toggle', 'collapse');
            listGroupEe.setAttribute('data-target', '#lista-ee');
            listGroupEe.setAttribute('data-parent', '#menu');
            listGroupEe.innerHTML = '<i class="fa fa-keyboard-o"></i>&nbsp;&nbsp;Entradas Externas  - EE';
            listGroup.appendChild(listGroupEe);
            // cria o item de lista de alis
            listaEe = document.createElement('div');
            listaEe.id = 'lista-ee';
            listaEe.className = 'sublinks collapse';
            listGroup.appendChild(listaEe);
            // arquivos se cria as funcionalidades ALI, AIE, etc
            listGroupSe = document.createElement('a');
            listGroupSe.className = 'list-group-item';
            listGroupSe.setAttribute('href', '#');
            listGroupSe.setAttribute('data-toggle', 'collapse');
            listGroupSe.setAttribute('data-target', '#lista-se');
            listGroupSe.setAttribute('data-parent', '#menu');
            listGroupSe.innerHTML = '<i class="fa fa-external-link"></i>&nbsp;&nbsp;Sa&iacute;das Externas  - SE';
            listGroup.appendChild(listGroupSe);
            // cria o item de lista de alis
            listaSe = document.createElement('div');
            listaSe.id = 'lista-ee';
            listaSe.className = 'sublinks collapse';
            listGroup.appendChild(listaSe);
            // arquivos se cria as funcionalidades ALI, AIE, etc
            listGroupCe = document.createElement('a');
            listGroupCe.className = 'list-group-item';
            listGroupCe.setAttribute('href', '#');
            listGroupCe.setAttribute('data-toggle', 'collapse');
            listGroupCe.setAttribute('data-target', '#lista-ce');
            listGroupCe.setAttribute('data-parent', '#menu');
            listGroupCe.innerHTML = '<i class="fa fa-desktop"></i>&nbsp;&nbsp;Consultas Externas  - CE';
            listGroup.appendChild(listGroupCe);
            // cria o item de lista de alis
            listaCe = document.createElement('div');
            listaCe.id = 'lista-ce';
            listaCe.className = 'sublinks collapse';
            listGroup.appendChild(listaCe);
            for (x = 0; x < data.length; x++) {
                if (data[x].tipo === 'ali') {
                    nomeFuncaoAli = document.createElement('a');
                    nomeFuncaoAli.className = 'list-group-item draggable funcao';
                    nomeFuncaoAli.setAttribute('href', '#');
                    nomeFuncaoAli.setAttribute('data-toggle', 'collapse');
                    nomeFuncaoAli.setAttribute('data-target', '#div-tdtr-ali-' + data[x].id);
                    nomeFuncaoAli.setAttribute('data-parent', '#menu');
                    nomeFuncaoAli.id = 'ali-' + data[x].id;
                    nomeFuncaoAli.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;' + (data[x].situacao == 1 ? '<i class="fa fa-circle naoValidada"></i>&nbsp;&nbsp;'
                            : (data[x].situacao == 2 ? '<i class="fa fa-circle validada"></i>&nbsp;&nbsp;'
                                    : (data[x].situacao == 3 ? '<i class="fa fa-circle emRevisao"></i>&nbsp;&nbsp;'
                                            : '<i class="fa fa-circle revisada"></i>&nbsp;&nbsp;')))
                            + '<strong>' + data[x].funcao + '</strong> [ ' + data[x].pfb + 'PF - ' + data[x].complexidade + ' ]';
                    // checkbox para selecao da funcao
                    chkBox = document.createElement('input');
                    chkBox.setAttribute('type', 'checkbox');
                    chkBox.id = 'chk-ali-' + data[x].id;
                    chkBox.className = 'css-checkbox chkBox';
                    // label para a selecao da funcao
                    lblBox = document.createElement('label');
                    lblBox.className = 'css-label-check pull-right chkBox';
                    lblBox.innerHTML = '&nbsp;';
                    lblBox.setAttribute('for', 'chk-ali-' + data[x].id);
                    // insere checkbox e label
                    nomeFuncaoAli.appendChild(chkBox);
                    nomeFuncaoAli.appendChild(lblBox);
                    // <input onclick="javascript: return false;" type="checkbox" class="pull-right">
                    // cria o link para adicionar a funcao na contagem
                    // '<span class="pull-right"><a href="#" onclick="alert($(this).val()" value="' + data[x].id + '"><i class="fa fa-plus-circle"></i></a></span>';
                    // adiciona
                    listaAli.appendChild(nomeFuncaoAli);
                    // div que conterah duas linhas - TD e TR
                    divTDTR = document.createElement('div');
                    divTDTR.className = 'sublinks collapse';
                    divTDTR.id = 'div-tdtr-ali-' + data[x].id;
                    // adiciona a div tdtr
                    listaAli.appendChild(divTDTR);
                    // cria os links com os td
                    aliTD = document.createElement('a');
                    aliTD.className = 'list-group-item';
                    aliTD.setAttribute('href', '#');
                    aliTD.setAttribute('data-toggle', 'collapse');
                    aliTD.setAttribute('data-target', '#lista-ali-funcao-td-' + data[x].id);
                    aliTD.setAttribute('data-parent', '#menu');
                    aliTD.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Tipos de dados (TD)';
                    divTDTR.appendChild(aliTD);
                    // TD
                    aliDivTD = document.createElement('div');
                    aliDivTD.className = 'sublinks collapse';
                    aliDivTD.id = 'lista-ali-funcao-td-' + data[x].id;
                    divTDTR.appendChild(aliDivTD);
                    // passa tds e trs
                    if (data[x].descricao_td != undefined && (data[x].descricao_td).length > 0) {
                        // cria todos os tds
                        arrTD = (data[x].descricao_td).split(',');
                        // cria a div para recepcionar as descricoes dos tds
                        for (y = 0; y < arrTD.length; y++) {
                            descTD = document.createElement('a');
                            descTD.className = 'list-group-item small';
                            descTD.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + '<i class="fa fa-angle-right"></i>&nbsp;&nbsp;' + arrTD[y];
                            aliDivTD.appendChild(descTD);
                        }
                    }
                    // cria os links com os td
                    aliTR = document.createElement('a');
                    aliTR.className = 'list-group-item';
                    aliTR.setAttribute('href', '#');
                    aliTR.setAttribute('data-toggle', 'collapse');
                    aliTR.setAttribute('data-target', '#lista-ali-funcao-tr-' + data[x].id);
                    aliTR.setAttribute('data-parent', '#menu');
                    aliTR.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Tipos de Registros (TR)';
                    divTDTR.appendChild(aliTR);
                    // TR
                    aliDivTR = document.createElement('div');
                    aliDivTR.className = 'sublinks collapse';
                    aliDivTR.id = 'lista-ali-funcao-tr-' + data[x].id;
                    divTDTR.appendChild(aliDivTR);
                    // passa um a um
                    if (data[x].descricao_tr != undefined && (data[x].descricao_tr).length > 0) {
                        // cria todos os tds
                        arrTR = (data[x].descricao_tr)
                                .split(',');
                        // cria a div para
                        // recepcionar as
                        // descricoes dos tds
                        for (z = 0; z < arrTR.length; z++) {
                            descTR = document
                                    .createElement('a');
                            descTR.className = 'list-group-item small';
                            descTR.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                    + '<i class="fa fa-angle-right"></i>&nbsp;&nbsp;'
                                    + arrTR[z];
                            aliDivTR
                                    .appendChild(descTR);
                        }
                    }
                }
                // arquivos de interface externa
                if (data[x].tipo === 'aie') {
                    nomeFuncaoAie = document
                            .createElement('a');
                    nomeFuncaoAie.className = 'list-group-item';
                    nomeFuncaoAie.setAttribute(
                            'href', '#');
                    nomeFuncaoAie.setAttribute(
                            'data-toggle',
                            'collapse');
                    nomeFuncaoAie
                            .setAttribute(
                                    'data-target',
                                    '#div-tdtr-aie-'
                                    + data[x].id);
                    nomeFuncaoAie.setAttribute(
                            'data-parent',
                            '#menu');
                    nomeFuncaoAie.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;'
                            + (data[x].situacao == 1 ? '<i class="fa fa-circle naoValidada"></i>&nbsp;&nbsp;'
                                    : (data[x].situacao == 2 ? '<i class="fa fa-circle validada"></i>&nbsp;&nbsp;'
                                            : (data[x].situacao == 3 ? '<i class="fa fa-circle emRevisao"></i>&nbsp;&nbsp;'
                                                    : '<i class="fa fa-circle revisada"></i>&nbsp;&nbsp;')))
                            + '<strong>'
                            + data[x].funcao
                            + '</strong> [ '
                            + data[x].pfb
                            + 'PF - '
                            + data[x].complexidade
                            + ' ]';
                    // checkbox para selecao da
                    // funcao
                    // chkBox =
                    // document.createElement('input');
                    // chkBox.setAttribute('type',
                    // 'checkbox');
                    // chkBox.id = 'chk-aie-' +
                    // data[x].id;
                    // chkBox.className =
                    // 'css-checkbox chkBox';
                    // label para a selecao da
                    // funcao
                    // lblBox =
                    // document.createElement('label');
                    // lblBox.className =
                    // 'css-label-check
                    // pull-right chkBox';
                    // lblBox.innerHTML =
                    // '&nbsp;';
                    // lblBox.setAttribute('for',
                    // 'chk-aie-' + data[x].id);
                    // insere checkbox e label
                    // nomeFuncaoAie.appendChild(chkBox);
                    // nomeFuncaoAie.appendChild(lblBox);
                    // adiciona
                    listaAie
                            .appendChild(nomeFuncaoAie);
                    // div que conterah duas
                    // linhas - TD e TR
                    divTDTR = document
                            .createElement('div');
                    divTDTR.className = 'sublinks collapse';
                    divTDTR.id = 'div-tdtr-aie-'
                            + data[x].id;
                    // adiciona a div tdtr
                    listaAie
                            .appendChild(divTDTR);
                    // cria os links com os td
                    aieTD = document
                            .createElement('a');
                    aieTD.className = 'list-group-item';
                    aieTD.setAttribute('href',
                            '#');
                    aieTD.setAttribute(
                            'data-toggle',
                            'collapse');
                    aieTD
                            .setAttribute(
                                    'data-target',
                                    '#lista-aie-funcao-td-'
                                    + data[x].id);
                    aieTD.setAttribute(
                            'data-parent',
                            '#menu');
                    aieTD.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Tipos de dados (TD)';
                    divTDTR.appendChild(aieTD);
                    // TD
                    aieDivTD = document
                            .createElement('div');
                    aieDivTD.className = 'sublinks collapse';
                    aieDivTD.id = 'lista-aie-funcao-td-'
                            + data[x].id;
                    divTDTR
                            .appendChild(aieDivTD);
                    // passa tds e trs
                    if (data[x].descricao_td != undefined
                            && (data[x].descricao_td).length > 0) {
                        // cria todos os tds
                        arrTD = (data[x].descricao_td)
                                .split(',');
                        // cria a div para
                        // recepcionar as
                        // descricoes dos tds
                        for (y = 0; y < arrTD.length; y++) {
                            descTD = document
                                    .createElement('a');
                            descTD.className = 'list-group-item small';
                            descTD.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                    + '<i class="fa fa-angle-right"></i>&nbsp;&nbsp;'
                                    + arrTD[y];
                            aieDivTD
                                    .appendChild(descTD);
                        }
                    }
                    // cria os links com os td
                    aieTR = document
                            .createElement('a');
                    aieTR.className = 'list-group-item';
                    aieTR.setAttribute('href',
                            '#');
                    aieTR.setAttribute(
                            'data-toggle',
                            'collapse');
                    aieTR
                            .setAttribute(
                                    'data-target',
                                    '#lista-aie-funcao-tr-'
                                    + data[x].id);
                    aieTR.setAttribute(
                            'data-parent',
                            '#menu');
                    aieTR.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Tipos de Registros (TR)';
                    divTDTR.appendChild(aieTR);
                    // TR
                    aieDivTR = document
                            .createElement('div');
                    aieDivTR.className = 'sublinks collapse';
                    aieDivTR.id = 'lista-ali-funcao-tr-'
                            + data[x].id;
                    divTDTR
                            .appendChild(aieDivTR);
                    // passa um a um
                    if (data[x].descricao_tr != undefined
                            && (data[x].descricao_tr).length > 0) {
                        // cria todos os tds
                        arrTR = (data[x].descricao_tr)
                                .split(',');
                        // cria a div para
                        // recepcionar as
                        // descricoes dos tds
                        for (z = 0; z < arrTR.length; z++) {
                            descTR = document
                                    .createElement('a');
                            descTR.className = 'list-group-item small';
                            descTR.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                    + '<i class="fa fa-angle-right"></i>&nbsp;&nbsp;'
                                    + arrTR[z];
                            aieDivTR
                                    .appendChild(descTR);
                        }
                    }
                }
                // entradas externas
                if (data[x].tipo === 'ee') {
                    nomeFuncaoEe = document
                            .createElement('a');
                    nomeFuncaoEe.className = 'list-group-item';
                    nomeFuncaoEe.setAttribute(
                            'href', '#');
                    nomeFuncaoEe.setAttribute(
                            'data-toggle',
                            'collapse');
                    nomeFuncaoEe
                            .setAttribute(
                                    'data-target',
                                    '#div-tdtr-ee-'
                                    + data[x].id);
                    nomeFuncaoEe.setAttribute(
                            'data-parent',
                            '#menu');
                    nomeFuncaoEe.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;'
                            + (data[x].situacao == 1 ? '<i class="fa fa-circle naoValidada"></i>&nbsp;&nbsp;'
                                    : (data[x].situacao == 2 ? '<i class="fa fa-circle validada"></i>&nbsp;&nbsp;'
                                            : (data[x].situacao == 3 ? '<i class="fa fa-circle emRevisao"></i>&nbsp;&nbsp;'
                                                    : '<i class="fa fa-circle revisada"></i>&nbsp;&nbsp;')))
                            + '<strong>'
                            + data[x].funcao
                            + '</strong> [ '
                            + data[x].pfb
                            + 'PF - '
                            + data[x].complexidade
                            + ' ]';
                    // checkbox para selecao da
                    // funcao
                    chkBox = document
                            .createElement('input');
                    chkBox.setAttribute('type',
                            'checkbox');
                    chkBox.id = 'chk-ee-'
                            + data[x].id;
                    chkBox.className = 'css-checkbox chkBox';
                    // label para a selecao da
                    // funcao
                    lblBox = document
                            .createElement('label');
                    lblBox.className = 'css-label-check pull-right chkBox';
                    lblBox.innerHTML = '&nbsp;';
                    lblBox
                            .setAttribute(
                                    'for',
                                    'chk-ee-'
                                    + data[x].id);
                    // insere checkbox e label
                    nomeFuncaoEe
                            .appendChild(chkBox);
                    nomeFuncaoEe
                            .appendChild(lblBox);
                    // adiciona
                    listaEe
                            .appendChild(nomeFuncaoEe);
                    // div que conterah duas
                    // linhas - TD e TR
                    divTDTR = document
                            .createElement('div');
                    divTDTR.className = 'sublinks collapse';
                    divTDTR.id = 'div-tdtr-ee-'
                            + data[x].id;
                    // adiciona a div tdtr
                    listaEe
                            .appendChild(divTDTR);
                    // cria os links com os td
                    eeTD = document
                            .createElement('a');
                    eeTD.className = 'list-group-item';
                    eeTD.setAttribute('href',
                            '#');
                    eeTD.setAttribute(
                            'data-toggle',
                            'collapse');
                    eeTD
                            .setAttribute(
                                    'data-target',
                                    '#lista-ee-funcao-td-'
                                    + data[x].id);
                    eeTD.setAttribute(
                            'data-parent',
                            '#menu');
                    eeTD.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Tipos de dados (TD)';
                    divTDTR.appendChild(eeTD);
                    // TD
                    eeDivTD = document
                            .createElement('div');
                    eeDivTD.className = 'sublinks collapse';
                    eeDivTD.id = 'lista-ee-funcao-td-'
                            + data[x].id;
                    divTDTR
                            .appendChild(eeDivTD);
                    // passa tds e trs
                    if (data[x].descricao_td != undefined
                            && (data[x].descricao_td).length > 0) {
                        // cria todos os tds
                        arrTD = (data[x].descricao_td)
                                .split(',');
                        // cria a div para
                        // recepcionar as
                        // descricoes dos tds
                        for (y = 0; y < arrTD.length; y++) {
                            descTD = document
                                    .createElement('a');
                            descTD.className = 'list-group-item small';
                            descTD.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                    + '<i class="fa fa-angle-right"></i>&nbsp;&nbsp;'
                                    + arrTD[y];
                            eeDivTD
                                    .appendChild(descTD);
                        }
                    }
                    // cria os links com os td
                    eeTR = document
                            .createElement('a');
                    eeTR.className = 'list-group-item';
                    eeTR.setAttribute('href',
                            '#');
                    eeTR.setAttribute(
                            'data-toggle',
                            'collapse');
                    eeTR
                            .setAttribute(
                                    'data-target',
                                    '#lista-ee-funcao-tr-'
                                    + data[x].id);
                    eeTR.setAttribute(
                            'data-parent',
                            '#menu');
                    eeTR.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Arquivos Referenciados (AR)';
                    divTDTR.appendChild(eeTR);
                    // TR
                    eeDivTR = document
                            .createElement('div');
                    eeDivTR.className = 'sublinks collapse';
                    eeDivTR.id = 'lista-ee-funcao-tr-'
                            + data[x].id;
                    divTDTR
                            .appendChild(eeDivTR);
                    // passa um a um
                    if (data[x].descricao_tr != undefined
                            && (data[x].descricao_tr).length > 0) {
                        // cria todos os tds
                        arrTR = (data[x].descricao_tr)
                                .split(',');
                        // cria a div para
                        // recepcionar as
                        // descricoes dos tds
                        for (z = 0; z < arrTR.length; z++) {
                            descTR = document
                                    .createElement('a');
                            descTR.className = 'list-group-item small';
                            descTR.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                    + '<i class="fa fa-angle-right"></i>&nbsp;&nbsp;'
                                    + arrTR[z];
                            eeDivTR
                                    .appendChild(descTR);
                        }
                    }
                }
                // SAIDAS externas
                if (data[x].tipo === 'se') {
                    nomeFuncaoSe = document
                            .createElement('a');
                    nomeFuncaoSe.className = 'list-group-item';
                    nomeFuncaoSe.setAttribute(
                            'href', '#');
                    nomeFuncaoSe.setAttribute(
                            'data-toggle',
                            'collapse');
                    nomeFuncaoSe
                            .setAttribute(
                                    'data-target',
                                    '#div-tdtr-se-'
                                    + data[x].id);
                    nomeFuncaoSe.setAttribute(
                            'data-parent',
                            '#menu');
                    nomeFuncaoSe.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;'
                            + (data[x].situacao == 1 ? '<i class="fa fa-circle naoValidada"></i>&nbsp;&nbsp;'
                                    : (data[x].situacao == 2 ? '<i class="fa fa-circle validada"></i>&nbsp;&nbsp;'
                                            : (data[x].situacao == 3 ? '<i class="fa fa-circle emRevisao"></i>&nbsp;&nbsp;'
                                                    : '<i class="fa fa-circle revisada"></i>&nbsp;&nbsp;')))
                            + '<strong>'
                            + data[x].funcao
                            + '</strong> [ '
                            + data[x].pfb
                            + 'PF - '
                            + data[x].complexidade
                            + ' ]';
                    // checkbox para selecao da
                    // funcao
                    chkBox = document
                            .createElement('input');
                    chkBox.setAttribute('type',
                            'checkbox');
                    chkBox.id = 'chk-se-'
                            + data[x].id;
                    chkBox.className = 'css-checkbox chkBox';
                    // label para a selecao da
                    // funcao
                    lblBox = document
                            .createElement('label');
                    lblBox.className = 'css-label-check pull-right chkBox';
                    lblBox.innerHTML = '&nbsp;';
                    lblBox
                            .setAttribute(
                                    'for',
                                    'chk-se-'
                                    + data[x].id);
                    // insere checkbox e label
                    nomeFuncaoSe
                            .appendChild(chkBox);
                    nomeFuncaoSe
                            .appendChild(lblBox);
                    // adiciona
                    listaSe
                            .appendChild(nomeFuncaoSe);
                    // div que conterah duas
                    // linhas - TD e TR
                    divTDTR = document
                            .createElement('div');
                    divTDTR.className = 'sublinks collapse';
                    divTDTR.id = 'div-tdtr-se-'
                            + data[x].id;
                    // adiciona a div tdtr
                    listaSe
                            .appendChild(divTDTR);
                    // cria os links com os td
                    seTD = document
                            .createElement('a');
                    seTD.className = 'list-group-item';
                    seTD.setAttribute('href',
                            '#');
                    seTD.setAttribute(
                            'data-toggle',
                            'collapse');
                    seTD
                            .setAttribute(
                                    'data-target',
                                    '#lista-se-funcao-td-'
                                    + data[x].id);
                    seTD.setAttribute(
                            'data-parent',
                            '#menu');
                    seTD.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Tipos de dados (TD)';
                    divTDTR.appendChild(seTD);
                    // TD
                    seDivTD = document
                            .createElement('div');
                    seDivTD.className = 'sublinks collapse';
                    seDivTD.id = 'lista-se-funcao-td-'
                            + data[x].id;
                    divTDTR
                            .appendChild(seDivTD);
                    // passa tds e trs
                    if (data[x].descricao_td != undefined
                            && (data[x].descricao_td).length > 0) {
                        // cria todos os tds
                        arrTD = (data[x].descricao_td)
                                .split(',');
                        // cria a div para
                        // recepcionar as
                        // descricoes dos tds
                        for (y = 0; y < arrTD.length; y++) {
                            descTD = document
                                    .createElement('a');
                            descTD.className = 'list-group-item small';
                            descTD.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                    + '<i class="fa fa-angle-right"></i>&nbsp;&nbsp;'
                                    + arrTD[y];
                            seDivTD
                                    .appendChild(descTD);
                        }
                    }
                    // cria os links com os td
                    seTR = document
                            .createElement('a');
                    seTR.className = 'list-group-item';
                    seTR.setAttribute('href',
                            '#');
                    seTR.setAttribute(
                            'data-toggle',
                            'collapse');
                    seTR
                            .setAttribute(
                                    'data-target',
                                    '#lista-se-funcao-tr-'
                                    + data[x].id);
                    seTR.setAttribute(
                            'data-parent',
                            '#menu');
                    seTR.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Arquivos Referenciados (AR)';
                    divTDTR.appendChild(seTR);
                    // TR
                    seDivTR = document
                            .createElement('div');
                    seDivTR.className = 'sublinks collapse';
                    seDivTR.id = 'lista-se-funcao-tr-'
                            + data[x].id;
                    divTDTR
                            .appendChild(seDivTR);
                    // passa um a um
                    if (data[x].descricao_tr != undefined
                            && (data[x].descricao_tr).length > 0) {
                        // cria todos os tds
                        arrTR = (data[x].descricao_tr)
                                .split(',');
                        // cria a div para
                        // recepcionar as
                        // descricoes dos tds
                        for (z = 0; z < arrTR.length; z++) {
                            descTR = document
                                    .createElement('a');
                            descTR.className = 'list-group-item small';
                            descTR.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                    + '<i class="fa fa-angle-right"></i>&nbsp;&nbsp;'
                                    + arrTR[z];
                            seDivTR
                                    .appendChild(descTR);
                        }
                    }
                }
                // consultas externas
                if (data[x].tipo === 'ce') {
                    nomeFuncaoCe = document
                            .createElement('a');
                    nomeFuncaoCe.className = 'list-group-item';
                    nomeFuncaoCe.setAttribute(
                            'href', '#');
                    nomeFuncaoCe.setAttribute(
                            'data-toggle',
                            'collapse');
                    nomeFuncaoCe
                            .setAttribute(
                                    'data-target',
                                    '#div-tdtr-ce-'
                                    + data[x].id);
                    nomeFuncaoCe.setAttribute(
                            'data-parent',
                            '#menu');
                    nomeFuncaoCe.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;'
                            + (data[x].situacao == 1 ? '<i class="fa fa-circle naoValidada"></i>&nbsp;&nbsp;'
                                    : (data[x].situacao == 2 ? '<i class="fa fa-circle validada"></i>&nbsp;&nbsp;'
                                            : (data[x].situacao == 3 ? '<i class="fa fa-circle emRevisao"></i>&nbsp;&nbsp;'
                                                    : '<i class="fa fa-circle revisada"></i>&nbsp;&nbsp;')))
                            + '<strong>'
                            + data[x].funcao
                            + '</strong> [ '
                            + data[x].pfb
                            + 'PF - '
                            + data[x].complexidade
                            + ' ]';
                    // checkbox para selecao da
                    // funcao
                    chkBox = document
                            .createElement('input');
                    chkBox.setAttribute('type',
                            'checkbox');
                    chkBox.id = 'chk-ce-'
                            + data[x].id;
                    chkBox.className = 'css-checkbox chkBox';
                    // label para a selecao da
                    // funcao
                    lblBox = document
                            .createElement('label');
                    lblBox.className = 'css-label-check pull-right chkBox';
                    lblBox.innerHTML = '&nbsp;';
                    lblBox
                            .setAttribute(
                                    'for',
                                    'chk-ce-'
                                    + data[x].id);
                    // insere checkbox e label
                    nomeFuncaoCe
                            .appendChild(chkBox);
                    nomeFuncaoCe
                            .appendChild(lblBox);
                    // adiciona
                    listaCe
                            .appendChild(nomeFuncaoCe);
                    // div que conterah duas
                    // linhas - TD e TR
                    divTDTR = document
                            .createElement('div');
                    divTDTR.className = 'sublinks collapse';
                    divTDTR.id = 'div-tdtr-ce-'
                            + data[x].id;
                    // adiciona a div tdtr
                    listaCe
                            .appendChild(divTDTR);
                    // cria os links com os td
                    ceTD = document
                            .createElement('a');
                    ceTD.className = 'list-group-item';
                    ceTD.setAttribute('href',
                            '#');
                    ceTD.setAttribute(
                            'data-toggle',
                            'collapse');
                    ceTD
                            .setAttribute(
                                    'data-target',
                                    '#lista-ce-funcao-td-'
                                    + data[x].id);
                    ceTD.setAttribute(
                            'data-parent',
                            '#menu');
                    ceTD.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Tipos de dados (TD)';
                    divTDTR.appendChild(ceTD);
                    // TD
                    ceDivTD = document
                            .createElement('div');
                    ceDivTD.className = 'sublinks collapse';
                    ceDivTD.id = 'lista-ce-funcao-td-'
                            + data[x].id;
                    divTDTR
                            .appendChild(ceDivTD);
                    // passa tds e trs
                    if (data[x].descricao_td != undefined
                            && (data[x].descricao_td).length > 0) {
                        // cria todos os tds
                        arrTD = (data[x].descricao_td)
                                .split(',');
                        // cria a div para
                        // recepcionar as
                        // descricoes dos tds
                        for (y = 0; y < arrTD.length; y++) {
                            descTD = document
                                    .createElement('a');
                            descTD.className = 'list-group-item small';
                            descTD.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                    + '<i class="fa fa-angle-right"></i>&nbsp;&nbsp;'
                                    + arrTD[y];
                            ceDivTD
                                    .appendChild(descTD);
                        }
                    }
                    // cria os links com os td
                    ceTR = document
                            .createElement('a');
                    ceTR.className = 'list-group-item';
                    ceTR.setAttribute('href',
                            '#');
                    ceTR.setAttribute(
                            'data-toggle',
                            'collapse');
                    ceTR
                            .setAttribute(
                                    'data-target',
                                    '#lista-ce-funcao-tr-'
                                    + data[x].id);
                    ceTR.setAttribute(
                            'data-parent',
                            '#menu');
                    ceTR.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            + '<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Arquivos Referenciados (AR)';
                    divTDTR.appendChild(ceTR);
                    // TR
                    ceDivTR = document
                            .createElement('div');
                    ceDivTR.className = 'sublinks collapse';
                    ceDivTR.id = 'lista-ce-funcao-tr-'
                            + data[x].id;
                    divTDTR
                            .appendChild(ceDivTR);
                    // passa um a um
                    if (data[x].descricao_tr != undefined
                            && (data[x].descricao_tr).length > 0) {
                        // cria todos os tds
                        arrTR = (data[x].descricao_tr)
                                .split(',');
                        // cria a div para
                        // recepcionar as
                        // descricoes dos tds
                        for (z = 0; z < arrTR.length; z++) {
                            descTR = document
                                    .createElement('a');
                            descTR.className = 'list-group-item small';
                            descTR.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                    + '<i class="fa fa-angle-right"></i>&nbsp;&nbsp;'
                                    + arrTR[z];
                            ceDivTR
                                    .appendChild(descTR);
                        }
                    }
                }
            }
            // monta a tabela com as contagens
            var tbl = document
                    .getElementById('projetosAssociados');
            $('#projetosAssociados').empty();
            // pega o arquivo do dashboard
            $
                    .get(
                            '/pf/dashboard/'
                            + sha1(idEmpresa)
                            + '/'
                            + sha1(v)
                            + '/'
                            + 'lista.contagens.baseline.json?v='
                            + tNow
                            .getTime(),
                            function (data) {
                                for (x = 0; x < data.length; x++) {
                                    if (sha1(data[x].user_id) !== UserIdSha1) {
                                        if (data[x].privacidade == 0) {
                                            exibeLista = true;
                                        } else {
                                            exibeLista = false;
                                        }
                                    } else {
                                        exibeLista = true;
                                    }
                                    // verifica
                                    // se pode
                                    // ver
                                    var row = tbl
                                            .insertRow(-1);
                                    var cell0 = row
                                            .insertCell(0);
                                    var cell1 = row
                                            .insertCell(1);
                                    var cell2 = row
                                            .insertCell(2);

                                    cell0
                                            .setAttribute(
                                                    'width',
                                                    '05%');
                                    cell1
                                            .setAttribute(
                                                    'width',
                                                    '75%');
                                    cell1
                                            .setAttribute(
                                                    'style',
                                                    'line-height: 38px;');
                                    cell2
                                            .setAttribute(
                                                    'width',
                                                    '20%');
                                    cell2
                                            .setAttribute(
                                                    'style',
                                                    'line-height: 38px;');

                                    cell0.innerHTML = '<a href="mailto:'
                                            + data[x].user_email
                                            + '"><img src="/pf/vendor/cropper/producao/crop/img/img-user/'
                                            + sha1(data[x].user_id)
                                            + '.png" class="img-circle" width="38" height="38" /></a>';
                                    cell1.innerHTML = (data[x].privacidade == 0 ? '<i class="fa fa-circle-o"></i>&nbsp;'
                                            : '<i class="fa fa-ban"></i>&nbsp;')
                                            + '#ID: '
                                            + ("0000000" + data[x].id)
                                            .slice(-7)
                                            + ' . '
                                            + formattedDate(
                                                    data[x].data_cadastro,
                                                    false,
                                                    false)
                                            + ' . '
                                            + data[x].ordem_servico
                                            + ' . <strong>'
                                            + data[x].processo
                                            + '</strong>'
                                            + (data[x].id_fornecedor != 0 ? ' . <i class="fa fa-angle-double-left"></i>&nbsp;'
                                                    + data[x].sigla
                                                    + '&nbsp;<i class="fa fa-angle-double-right"></i>'
                                                    : '');
                                    cell2.innerHTML = '<div class="btn-group btn-group-sm btn-group-justified">'
                                            + '<div class="btn-group btn-group-sm">'
                                            + '<button type="button" class="btn btn-default" onclick="window.open(\'/pf/DIM.Gateway.php?arq=62&tch=0&sub=3&dlg=1&i='
                                            + data[x].id
                                            + '\');" '
                                            + (exibeLista ? ''
                                                    : 'disabled')
                                            + '><i class="fa fa-file-pdf-o"></i><span class="not-view">&nbsp;&nbsp;PDF</span></button>'
                                            + '</div>'
                                            + '<div class="btn-group btn-group-sm">'
                                            + '<button type="button" class="btn btn-default" onclick="window.open(\'/pf/DIM.Gateway.php?arq=61&tch=0&sub=3&dlg=1&i='
                                            + data[x].id
                                            + '&p=html\');" '
                                            + (exibeLista ? ''
                                                    : 'disabled')
                                            + '><i class="fa fa-external-link"></i><span class="not-view">&nbsp;&nbsp;HTML<span></button>'
                                            + '</div>'
                                            + '<!--<div class="btn-group btn-group-sm">'
                                            + '<button type="button" class="btn btn-default" onclick="window.open(\'/pf/DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=vw&ab='
                                            + data[x].id_abrangencia
                                            + '&id='
                                            + data[x].id
                                            + '\');" '
                                            + (exibeLista ? ''
                                                    : 'disabled')
                                            + '><i class="fa fa-search"></i><span class="not-view">&nbsp;&nbsp;Ver</span></button>'
                                            + '</div>-->'
                                            + '</div>';
                                    exibeLista = false;
                                }
                            }, 'json');
            // arrastar
            $(".draggable").on("dragstart",
                    function (ev, ui) {
                    });
            $('.chkBox').on('click',
                    function (e) {
                        e.stopPropagation();
                    });
        }, 'json');
    } else {
        // combos de criacao de contagem
        $('#contagem_id_cliente').prop('disabled', true)
                .empty().append(
                '<option value="0">...</option>');
        $('#contagem_id_contrato').prop('disabled', true)
                .empty().append(
                '<option value="0">...</option>');
        $('#contagem_id_projeto').prop('disabled', true)
                .empty().append(
                '<option value="0">...</option>');
        // desabilita os botoes de criacao de contagem
        $('.criar-contagem').prop('disabled', true);
        // limpar a tabela e a lista
        $('#projetosAssociados').empty();
        $('#menu-funcionalidades').empty();
        // resseta os graficos
        RGraph
                .Reset(document
                        .getElementById('dashboard-grafico-complexidade-funcoes-baseline'));
        RGraph
                .Reset(document
                        .getElementById('dashboard-grafico-contagens-situacao-funcoes-baseline'));
        // reseta as informacoes dos graficos
        $('#contagem-complexidade-baixa-baseline').empty();
        $('#contagem-complexidade-media-baseline').empty();
        $('#contagem-complexidade-alta-baseline').empty();
        $('#contagem-complexidade-ef-baseline').empty();
        // reseta o container
        $('#container4').empty();
    }
});

$('#contagem_id_projeto').on('change', function () {
    if ($(this).val() > 0) {
        // desabilita os botoes de criacao de contagem
        $('.criar-contagem').prop('disabled', false);
    } else {
        $('.criar-contagem').prop('disabled', true);
    }
});

// dropabble
$("#droppable").on('dragover', false).on('drop', function (event, ui) {
    alert(ui.draggable.attr("productid"));
});

// grafico contagens/mes
function contagensMes(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-contagens-mes');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)', //1
                        'rgba(255, 206, 86, 0.2)', //2
                        'rgba(75, 192, 192, 0.2)', //3
                        'rgba(153, 102, 255, 0.2)', //4
                        'rgba(255, 159, 64, 0.2)', //5
                        'rgba(115, 162, 226, 0.2)', //6
                        'rgba(75, 231, 192, 0.2)', //7
                        'rgba(16, 117, 91, 0.2)', //8
                        'rgba(16, 23, 117, 0.2)', //9
                        'rgba(1, 4, 45, 0.2)', //10
                        'rgba(130, 166, 134, 0.2)', //11
                        'rgba(28, 46, 84, 0.2)'//12
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)', //1
                        'rgba(255, 206, 86, 1)', //2
                        'rgba(75, 192, 192, 1)', //3
                        'rgba(153, 102, 255, 1)', //4
                        'rgba(255, 159, 64, 1)', //5
                        'rgba(115, 162, 226, 1)', //6
                        'rgba(75, 231, 192, 1)', //7
                        'rgba(16, 117, 91, 1)', //8
                        'rgba(16, 23, 117, 1)', //9
                        'rgba(1, 4, 45, 1)', //10
                        'rgba(130, 166, 134, 1)', //11
                        'rgba(28, 46, 84, 1)'//12
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            },
            legend: {
                display: false
            }
        }
    });
}
// grafico de pizza
function contagemSituacao(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-situacao-contagens');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['#F9E79F', '#2ECC71', '#239B56', '#82E0AA', '#5DADE2', '#A0B041', '#F5B041', '#E5A041']
                }]
        },
        options: {
            legend: {
                display: false
            }
        }
    });
}

// grafico complexidade funcoes
function complexidadeFuncoes(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-complexidade-funcoes');
    var myAreaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)']
                }],
            fill: 'origin'
        },
        options: {
            legend: {
                display: false
            }
        }
    });
}

// para as baselines
// grafico complexidade funcoes
function complexidadeFuncoesBaseline(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-complexidade-funcoes-baseline');
    var myAreaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)']
                }],
            fill: 'origin'
        },
        options: {
            legend: {
                display: false
            }
        }
    });
}

// para os projetos
// grafico complexidade funcoes
function complexidadeFuncoesProjeto(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-complexidade-funcoes-projeto');
    var myAreaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)']
                }],
            fill: 'origin'
        },
        options: {
            legend: {
                display: false
            }
        }
    });
}

// grafico contagens/PF/mes
function contagensPFMes(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-contagens-pf-mes');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data_pfa,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)', //1
                        'rgba(255, 206, 86, 0.2)', //2
                        'rgba(75, 192, 192, 0.2)', //3
                        'rgba(153, 102, 255, 0.2)', //4
                        'rgba(255, 159, 64, 0.2)', //5
                        'rgba(115, 162, 226, 0.2)', //6
                        'rgba(75, 231, 192, 0.2)', //7
                        'rgba(16, 117, 91, 0.2)', //8
                        'rgba(16, 23, 117, 0.2)', //9
                        'rgba(1, 4, 45, 0.2)', //10
                        'rgba(130, 166, 134, 0.2)', //11
                        'rgba(28, 46, 84, 0.2)'//12
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)', //1
                        'rgba(255, 206, 86, 1)', //2
                        'rgba(75, 192, 192, 1)', //3
                        'rgba(153, 102, 255, 1)', //4
                        'rgba(255, 159, 64, 1)', //5
                        'rgba(115, 162, 226, 1)', //6
                        'rgba(75, 231, 192, 1)', //7
                        'rgba(16, 117, 91, 1)', //8
                        'rgba(16, 23, 117, 1)', //9
                        'rgba(1, 4, 45, 1)', //10
                        'rgba(130, 166, 134, 1)', //11
                        'rgba(28, 46, 84, 1)'//12
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            },
            legend: {
                display: false
            }
        }
    });
}

// grafico de pizza
function contagemTipo(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-contagens-tipo');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['#F9E79F', '#2ECC71', '#239B56', '#82E0AA', '#5DADE2', '#154360', '#F5B041']
                }]
        },
        options: {
            legend: {
                display: true
            }
        }
    });
}

// grafico de pizza
function contagemEtapa(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-contagens-etapa');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['#F9E79F', '#2ECC71', '#239B56', '#82E0AA', '#5DADE2', '#154360', '#F5B041']
                }]
        },
        options: {
            legend: {
                display: true
            }
        }
    });
}

// grafico de pizza
function contagemAbrangencia(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-contagens-abrangencia');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['#F9E79F', '#2ECC71', '#239B56', '#82E0AA', '#5DADE2', '#154360', '#F5B041']
                }]
        },
        options: {
            legend: {
                display: true
            }
        }
    });
}

// grafico de pizza
function contagemMetodoFuncoes(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-contagens-metodo-funcoes');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['#F9E79F', '#2ECC71', '#239B56', '#82E0AA', '#5DADE2', '#154360', '#F5B041']
                }]
        },
        options: {
            legend: {
                display: true
            }
        }
    });
}

// grafico de pizza
function contagemSituacaoFuncoesConsolidado(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-contagens-situacao-funcoes');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['#F9E79F', '#2ECC71', '#239B56', '#82E0AA', '#5DADE2', '#154360', '#F5B041']
                }]
        },
        options: {
            legend: {
                display: true
            }
        }
    });
}

// para as baselines
// grafico de pizza
function contagemSituacaoFuncoesConsolidadoBaseline(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-contagens-situacao-funcoes-baseline');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['#F9E79F', '#2ECC71', '#239B56', '#82E0AA', '#5DADE2', '#154360', '#F5B041']
                }]
        },
        options: {
            legend: {
                display: true
            }
        }
    });
}

// para as baselines
// grafico de pizza
function contagemSituacaoFuncoesConsolidadoProjeto(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-contagens-situacao-funcoes-projeto');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['#F9E79F', '#2ECC71', '#239B56', '#82E0AA', '#5DADE2', '#154360', '#F5B041']
                }]
        },
        options: {
            legend: {
                display: true
            }
        }
    });
}
function bancoDados(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-contagens-banco-dados');
    var myPieChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: json.labels,
            datasets: [{
                    data: json.data,
                    backgroundColor: ['#F9E79F', '#2ECC71', '#239B56', '#82E0AA', '#5DADE2', '#154360', '#F5B041']
                }]
        },
        options: {
            legend: {
                display: false
            }
        }
    });
}

function contratoPF(json) {
    window.__json__ = json;
    var ctx = document.getElementById('dashboard-grafico-contrato-pf');
    var barType = isFornecedor ? 'bar' : 'line';
    var displayLegend = isFornecedor ? true : false;
    var mixedChart = new Chart(ctx, {
        type: 'bar',
        data: {
            datasets: [
                {
                    label: 'Contratado',
                    data: json.data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                },
                {
                    label: 'Executado',
                    data: json.data2,
                    type: barType
                }],
            labels: json.labels
        },
        options: {
            legend: {
                display: displayLegend
            }
        }
    });
}
