/* global idContagem */
//TODO: http://ioncache.github.io/Tag-Handler/
/*request permission on page load
 document.addEventListener('DOMContentLoaded', function () {
 if (Notification.permission !== "granted")
 Notification.requestPermission();
 });
 */
//limpar a tabela de paste para poder colar novamente
$('#form_modal_colar').on('hide.bs.modal', function(){
    $("#addPaste").empty().get(0);
});
//verificar o paste no documento
$(document).on('paste', function (e) {
    if (!($('#form_modal_colar').is(':visible'))) {
        var arrTab = ['li-ali', 'li-aie', 'li-ee', 'li-se', 'li-ce'];
        var activeTab = $("ul#tabs-contagem li.active").get(0).id;
        var v = e.originalEvent.clipboardData.getData('text');
        var l = v.split(/\r\n|\r|\n/g);
        console.log(l);
        var arrCampos = ['funcao', 'opera&ccedil;&atilde;o', 'TD', 'AR/TR', 'm&eacute;todo'];
        //criacao das colunas na tabela
        var tblPaste = $("#addPaste").empty().get(0);
        var col_funcao, col_tipo, col_operacao, col_td, col_descricao_td, col_tr_ar, col_descricao_tr_ar, col_complexidade, col_pfb, col_metodo;
        var linhaPFCalculada;//var linhaPFCalculada = calculaLinhaPF_v2('ALI', ln[2], ln[3]);
        var rowPaste;
        var observacoes = '';
        var ln, ln_td, ln_tr, mt, qtd_td, qtd_tr;//tres linhas para cada funcionalidade
        if (arrTab.indexOf(activeTab) < 0) {
            return true;
        }
        else {
            if (l.length % 3 != 0) {
                swal({title: "Alerta",
                    text: "Aparentemente n&atilde;o h&aacute; nada na &aacute;rea de transfer&ecirc;ncia, ou as informa&ccedil;&otilde;es n&atilde;o s&atilde;o v&aacute;lidas<br />Quantidade de linhas: " + l.length,
                    type: "warning",
                    html: true,
                    confirmButtonText: "Entendi, vou verificar!"}, function () {
                    return false;
                });
            }
            else {
                switch (activeTab) {
                    case 'li-ali':
                        if (!($('#form_modal_funcao_dados').is(':visible'))) {
                            $('#form_modal_colar').modal('toggle');
                            var linha_atual = 0;
                            for (x = 0; x < l.length; x += 3) {
                                ln = l[x].split(';');
                                //verifica o tamanho do array da linha, no minimo cinco campos
                                if (ln.length < 5 && linha_atual == 0) {
                                    observacoes += '<i class="fa fa-times-circle-o"></i>&nbsp;A linha (Fun&ccedil;&atilde;o) n&atilde;o est&aacute; em um formato v&aacute;lido<br />';
                                    for (z = 1; z < ln.length; z++) {
                                        if (ln[z].length == 0) {
                                            observacoes += '<i class="fa fa-times-circle-o"></i>&nbsp;O campo <strong>' + arrCampos[z] + '</strong> n&atilde;o tem um formato v&aacute;lido<br />';
                                        }
                                    }
                                }
                                mt = ln[4].toUpperCase();
                                if (mt !== 'F' && mt !== 'N' && mt !== 'D') {
                                    observacoes += '<i class="fa fa-times-circle-o"></i>&nbsp;O campo <strong>m&eacute;todo</strong> &eacute; inv&aacute;lido<br />';
                                }
                                //incrementa para pegar o TD
                                linha_atual++;
                                //verifica o tamanho da segunda linha
                                ln_td = l[x + 1].split(':');
                                if (ln_td.length < 2 && linha_atual == 1) {
                                    observacoes += '<i class="fa fa-times-circle-o"></i>&nbsp;A linha (TD)n&atilde;o est&aacute; em um formato v&aacute;lido<br />';
                                }
                                //verifica o metodo e a quantidade de TD/TR
                                if (mt === 'D') {
                                    if (ln_td[1].length == 0) {
                                        observacoes += '<i class="fa fa-times-circle-o"></i>&nbsp;O m&eacute;todo (D) Detalhado exige a descri&ccedil;&atilde;o dos TDs<br />';
                                    }
                                }
                                //incrementa para pegar os AR/TR
                                linha_atual++;
                                ln_tr = l[x + 2].split(':');
                                if (ln_tr.length < 2 && linha_atual == 2) {
                                    observacoes += '<i class="fa fa-times-circle-o"></i>&nbsp;A linha (AR/TR) n&atilde;o est&aacute; em um formato v&aacute;lido<br />';
                                }
                                //verifica o metodo e a quantidade de TD/TR
                                if (mt === 'D') {
                                    if (ln_tr[1].length == 0) {
                                        observacoes += '<i class="fa fa-times-circle-o"></i>&nbsp;O m&eacute;todo (D) Detalhado exige a descri&ccedil;&atilde;o dos TRs<br />';
                                    }
                                }
                                //verifica se ja existe na contagem
                                if (isDuplicada('ALI', ln[0])) {
                                    observacoes += '<i class="fa fa-times-circle-o"></i>&nbsp;A funcionalidade j&aacute; est&aacute; cadastrada na contagem<br />';
                                }
                                //contagem de projeto
                                if (abAtual == 2) {
                                    //verifica se a funcao existe na baseline e carrega os dados originais
                                    //mesmo que tenham sido colados dados diferentes
                                    //TODO: verificar o async - deprecated
                                    $.ajaxSetup({async: false});
                                    $.post('/pf/DIM.gateway.php', {
                                        'arq': 83,
                                        'tch': 1,
                                        'sub': -1,
                                        'dlg': 1,
                                        'fun': ln[0],
                                        'tbl': 'ali',
                                        'icn': idContagem,
                                        'iba': $('#contagem_id_baseline').val()}, function (data) {
                                        //verifica se eh alteracao ou exclusao e consulta na baseline
                                        if (data.length == 0 && ln[1].toUpperCase() === 'A' || ln[1].toUpperCase() === 'E') {
                                            observacoes += '<i class="fa fa-times-circle-o"></i>&nbsp;A funcionalidade n&atilde;o existe na Baseline<br/ >';
                                        }
                                        //verifica se eh inclusao e se ja existe na baseline
                                        else if (Number(data.id) > 0 && ln[1].toUpperCase() === 'I') {
                                            observacoes += '<i class="fa fa-times-circle-o"></i>&nbsp;A funcionalidade j&aacute; existe na Baseline<br/ >';
                                        }
                                        //verifica o metodo e calcula a quantidade de TD
                                        qtd_td = (mt === 'D' ? ln_td[1].split(';').length : (mt === 'N' ? 19 : (mt === 'F' ? 51 : ln[2])));
                                        //verifica o metodo e calcula a quantidade de TR
                                        qtd_tr = (mt === 'D' ? ln_tr[1].split(';').length : (mt === 'N' ? '1' : (mt === 'F' ? '1' : ln[3])));
                                        //calcula pfb e complexidade
                                        linhaPFCalculada = calculaLinhaPF_v2('ALI', qtd_td, qtd_tr);
                                        //atribui os valores
                                        col_funcao = data.length > 0 ? data.funcao : ln[0];
                                        col_tipo = 'ALI';
                                        col_operacao = divOperacao(ln[1].toUpperCase());
                                        col_td = data.length > 0 ? data.td : qtd_td;
                                        col_tr_ar = data.length > 0 ? data.tr : qtd_tr;
                                        col_descricao_td = data.length > 0 ? data.descricao_td : ln_td[1];
                                        col_descricao_tr_ar = data.length > 0 ? data.descricao_tr : ln_tr[1];
                                        col_complexidade = data.length > 0 ? data.complexidade : linhaPFCalculada.c;
                                        col_pfb = data.length > 0 ? Number(data.pfb).toFixed(3) : Number(linhaPFCalculada.p).toFixed(3);
                                        col_metodo = ln[4].toUpperCase();
                                        //verifica se ja foi inserida na tabela de copia
                                        if (isDuplicada('Paste', ln[0])) {
                                            observacoes += '<i class="fa fa-times-circle-o"></i>&nbsp;A funcionalidade j&aacute; consta nesta tabela de c&oacute;pia<br/ >';
                                        }
                                        //agora sim insere a linha na tabela
                                        rowPaste = tblPaste.insertRow(-1);
                                        var cell0 = rowPaste.insertCell(0);//status
                                        var cell1 = rowPaste.insertCell(1);//funcao
                                        var cell2 = rowPaste.insertCell(2);//tipo
                                        var cell3 = rowPaste.insertCell(3);//operacao
                                        var cell4 = rowPaste.insertCell(4);//td
                                        var cell5 = rowPaste.insertCell(5);//ar/tr
                                        var cell6 = rowPaste.insertCell(6);//complexidade
                                        var cell7 = rowPaste.insertCell(7);//pfb
                                        var cell8 = rowPaste.insertCell(8);//metodo
                                        var cell9 = rowPaste.insertCell(9);//observacoes                                    
                                        //escreva na tabela
                                        cell0.innerHTML = observacoes === '' ? '<i class="fa fa-check-circle-o fa-lg"></i>' : '<i class="fa fa-times fa-lg"></i>';
                                        cell0.className = observacoes === '' ? 'yes' : 'no';
                                        //demais insercoes normalmente
                                        cell1.innerHTML = col_operacao;
                                        cell2.innerHTML = col_funcao;
                                        cell3.innerHTML = col_tipo;
                                        cell4.innerHTML = col_td + '<br />' + '<label class="label-round-3 label-default" style="margin: 2px;">' + (col_descricao_td).replace(/;/g, '</label><label class="label-round-3 label-default" style="margin: 2px;">') + '</label>';
                                        cell5.innerHTML = col_tr_ar + '<br />' + '<label class="label-round-3 label-default" style="margin: 2px;">' + (col_descricao_tr_ar).replace(/;/g, '</label><label class="label-round-3 label-default" style="margin: 2px;">') + '</label>';
                                        cell6.innerHTML = col_complexidade;
                                        cell7.innerHTML = col_pfb;
                                        cell8.innerHTML = col_metodo;
                                        observacoes += ((ln[5]).length > 0 ? (((observacoes).length > 0 ? '<br />---------------<br />' : '' ) + ln[5]) : '');
                                        cell9.innerHTML = observacoes;
                                        //limpa as observacoes
                                        observacoes = '';
                                        //zera a linha_atual
                                        //TODO: verificar
                                        linha_atual = 0;
                                    }, 'json');
                                    $.ajaxSetup({async: false});
                                    //adiciona as linhas
                                    //function insereLinha(
                                    //  id,tabela,row,operacao,funcao,td,tr,
                                    //  complexidade,pfb,siglaFator,pfa,obsFuncao,
                                    //  situacao,entrega,lido,nLido,isGrafico,isMudanca,
                                    //  faseMudanca,percentualFase,fd,isCrud,isCrudAtualizarDependentes,fe)
                                }
                            }
                        }
                        else{
                            
                        }
                        break;
                    case 'li-aie':
                        if (!($('#form_modal_funcao_dados').is(':visible'))) {
                        }
                        break;
                    case 'li-ee':
                        if (!($('#form_modal_funcao_transacao').is(':visible'))) {
                        }
                        break;
                    case 'li-se':
                        if (!($('#form_modal_funcao_transacao').is(':visible'))) {
                        }
                        break;
                    case 'li-ce':
                        if (!($('#form_modal_funcao_transacao').is(':visible'))) {
                        }
                        break;
                }
            }
        }
    }
});
/*
 * captura "paste" no campo dados_td e dados_tr
 */
$(".paste").on('paste', function (e) {
    //verifica se eh uma funcao de transaca e solicita a qual AR ela ira se referir
    if ($(this).hasClass('transacao') && Number($('#sel_funcao_transacao').val()) < 1 && $(this).get(0).id === 'transacao_descricao_td') {
        // escreve o html nos logs
        var tipo = 'alert-danger';
        var fa = 'fa-times';
        var n = 'Por favor selecione um Arquivo Referenciado';
        var f = $(this).hasClass('dados') ? 'dados' : 'transacao';
        var h = '<div class="alert ' + tipo + ' alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<i class="fa ' + fa + '"></i>&nbsp;&nbsp;' + n +
                '</div>';
        $('#' + f + '_log').html(h);
    }
    else if ($(this).hasClass('transacao')) {
        var s = $(this).get(0).id === 'transacao_descricao_ar' ? $('input[name=chk-tipo-arquivo]:checked').val() : $('#sel_funcao_transacao').find('option:selected').text();
        //pega o valor do campo de texto e limpa o campo
        var v = e.originalEvent.clipboardData.getData('text');
        //array com o texto colado
        var f = v.split(';');
        //remover duplicados no texto digitado
        var funcoes = removerDuplicados(f);
        //quantidade de descricoes inseridas
        var qtd = 0;
        if (funcoes.length > 0) {
            for (x = 0; x < funcoes.length; x++) {
                var funcao = funcoes[x];
                if (funcao.length > 0) {
                    funcao = s + '.' + funcao;
                    adicionarDescricaoPaste(funcao, $(this));
                    qtd++;
                }
            }
            // escreve o html nos logs
            var tipo = qtd > 0 ? 'alert-success' : 'alert-danger';
            var fa = qtd > 0 ? 'fa-check-circle' : 'fa-times';
            var n = qtd > 0 ?
                    'As descri&ccedil;&otilde;es foram adicionadas com sucesso e as duplicadas foram removidas automaticamente.' :
                    'Algo errado aconteceu e nenhuma descri&ccedil;&atilde;o foi inserida. Realize a opera&ccedil;&otilde;es de Copiar e Colar novamente.';
            var f = $(this).hasClass('dados') ? 'dados' : 'transacao';
            var h = '<div class="alert ' + tipo + ' alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<i class="fa ' + fa + '"></i>&nbsp;&nbsp;' + n +
                    '</div>';
            $('#' + f + '_log').html(h);
        }
    }
    //caso contrario segue normalmente
    else {
        //pega o valor do campo de texto e limpa o campo
        var v = e.originalEvent.clipboardData.getData('text');
        //verificacao de caracteres especiais
        var e = /[^a-z0-9_-|.]/gi;
        //array com o texto colado
        var f = v.split(';');
        //remover duplicados no texto digitado
        var funcoes = removerDuplicados(f);
        //variavel que armazena a quantidade gerada
        var qtd = 0;
        if (funcoes.length > 0) {
            for (x = 0; x < funcoes.length; x++) {
                var funcao = funcoes[x];
                if (funcao.length > 0) {
                    adicionarDescricaoPaste(funcao, $(this));
                    qtd++;
                }
            }
            // escreve o html nos logs
            var tipo = qtd > 0 ? 'alert-success' : 'alert-danger';
            var fa = qtd > 0 ? 'fa-check-circle' : 'fa-times';
            var n = qtd > 0 ?
                    'As descri&ccedil;&otilde;es foram adicionadas com sucesso e as duplicadas foram removidas automaticamente.' :
                    'Algo errado aconteceu e nenhuma descri&ccedil;&atilde;o foi inserida. Realize a opera&ccedil;&otilde;es de Copiar e Colar novamente.';
            var f = $(this).hasClass('dados') ? 'dados' : 'transacao';
            var h = '<div class="alert ' + tipo + ' alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<i class="fa ' + fa + '"></i>&nbsp;&nbsp;' + n +
                    '</div>';
            $('#' + f + '_log').html(h);
        }
    }
    //retorna false para nao deixar o texto colado
    return false;
});

$(document).ready(function () {
    /*
     * tags para insercao automatica da funcao
     *
     jQuery("#input-ali").tagsManager({
     blinkBGColor_1: '#FFFF9C',
     blinkBGColor_2: '#CDE69C',
     tagCloseIcon: '<i class="fa fa-times-circle"></i>'
     });*/
    /*
     * clique no botao de pesquisa
     */
    $('#btn-pesq-dados').on('click', function () {
        if (!$(this).hasClass('disabled')) {
            atualizaItensFuncoes($('#dados_tabela').val(), 'dados');
        }
    });
    /*
     * clique no botao de pesquisa para baselines
     */
    $('#btn-pesq-transacao').on('click', function () {
        if (!$(this).hasClass('disabled')) {
            atualizaItensFuncoes($('#transacao_tabela').val(), 'transacao');
        }
    });
    /*
     * clique nos botoes de verificar nome funcao
     */
    $('.check-nome-funcao').on('click', function () {
        var t = $(this).hasClass('dados') ? $('#dados_tabela').val() : $('#transacao_tabela').val();
        var f = $(this).hasClass('dados') ? 'dados' : 'transacao';
        var s = f === 'dados' ? $('#dados_funcao').val() : $('#transacao_funcao').val();
        var b = $('#contagem_id_baseline').val();
        var h = $('#' + f + '_log').html();//html que sera exibido
        var n;//notificacao
        var tipo;//tipo de notificacao
        var fa;//icone para o font awesome
        var e = false;//variavel que define se a mensagem ja foi escrita ou nao (ajax)
        //verifica o preenchimento
        if (s.length == 0) {
            n = 'A descrição está vazia';
            tipo = 'alert-danger';
            fa = 'fa-times-circle';
        }
        else {
            if (t === 'AIE') {
                n = 'Excepcionalmente AIEs podem ter nomes iguais';
                tipo = 'alert-success';
                fa = 'fa-check-circle';
            }
            //verifica nas tabelas
            else if (isDuplicada(t, s)) {
                if (acForms === 'al') {
                    n = 'A função verificada é a que está sendo editada';
                    tipo = 'alert-warning';
                    fa = 'fa-times-circle';
                }
                else {
                    n = 'A função está duplicada';
                    tipo = 'alert-danger';
                    fa = 'fa-times-circle';
                }
            }
            else {
                if (abAtual == 3) {
                    n = 'Função não duplicada nesta contagem';
                    tipo = 'alert-success';
                    fa = 'fa-check-circle';
                }
                else if (abAtual == 2) {
                    $.ajaxSetup({async: false});
                    $.post('/pf/DIM.gateway.php', {
                        'arq': 83,
                        'tch': 1,
                        'sub': -1,
                        'dlg': 1,
                        'fun': s,
                        'tbl': t.toLowerCase(),
                        'icn': idContagem,
                        'iba': b}, function (data) {
                        e = true;
                        if (Number(data.id) > 0) {
                            if (Number(data.situacao == 1)) {
                                n = 'Esta função está sendo trabalhada na contagem de projeto <strong><a href="#" onclick="window.open(\'/pf/DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=vw&ab=2&id=' + data.id_contagem + '\'); return false;">#ID: ' + ("000000" + data.id_contagem).slice(-6) + '</a></strong> mas ainda n&atilde;o foi validada.';
                                tipo = 'alert-danger';
                                fa = 'fa-times-circle';
                            }
                            else {
                                n = 'A função já existe na baseline, utilize uma consulta para inserir na contagem';
                                tipo = 'alert-danger';
                                fa = 'fa-times-circle';
                            }
                        }
                        else {
                            n = 'A função não está duplicada na contagem e n&atilde;o existe na baseline';
                            tipo = 'alert-success';
                            fa = 'fa-check-circle';
                        }
                        //escreve o html
                        h += '<div class="alert ' + tipo + ' alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<center><i class="fa ' + fa + '"></i>&nbsp;&nbsp;' + n + '</center>' +
                                '</div>';
                        $('#' + f + '_log').html(h).scrollTop($('#' + f + '_log')[0].scrollHeight);
                    }, 'json');
                    $.ajaxSetup({async: false});
                }
                else {
                    n = 'O sistema confere apenas contagens de Projeto e Baseline';
                    tipo = 'alert-warning';
                    fa = 'fa-times-circle';
                }
            }
        }
        //escreve o html
        if (!e) {
            h += '<div class="alert ' + tipo + ' alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<center><i class="fa ' + fa + '"></i>&nbsp;&nbsp;' + n + '</center>' +
                    '</div>';
            $('#' + f + '_log').html(h).scrollTop($('#' + f + '_log')[0].scrollHeight);
            //notifyMe(n);TODO:
        }
    });
    //verifica o relacionamento da funcionalidade
    //tem como objetivo alertar ao operador em que funcionalidades as alteracoes poderao ser afetadas
    $('.check-relacionamento').on('click', function () {
        //TODO: exibir o relacionamento deste ALI, ver onde ele eh um AIE
        var tbl = $('#dados_tabela').val();
        var s = $('#dados_funcao').val();
        var h;
        if (tbl === 'ALI') {
            $.post('/pf/DIM.gateway.php', {
                'arq': 89,
                'tch': 1,
                'sub': -1,
                'dlg': 1,
                'fun': s,
                'tbl': tbl.toLowerCase(),
                'idc': idContagem}, function (data) {
                e = true;
                if (Number(data.id) > 0) {
                    n = '';
                    tipo = 'alert-info';
                    fa = 'fa-times-circle';
                    //escreve o html
                    h += '<div class="alert ' + tipo + ' alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<center><i class="fa ' + fa + '"></i>&nbsp;&nbsp;' + n + '</center>' +
                            '</div>';
                    $('#dados_log').html(h).scrollTop($('#dados_log')[0].scrollHeight);
                }
            }, 'json');
        }
        return false;
    });
    /*
     * pesquisa os ar na baseline
     */
    $('#btn-ar-baseline').on('click', function () {
        pBaseline = pBaseline ? false : true;
        var idBaseline = Number($('#contagem_id_baseline').val());
        if (pBaseline && idBaseline > 0) {//consultar
            pArquivosReferenciados(idBaseline); //id, tipo, abrangencia
        }
        else {//fechar
            $('#lst-ar-baseline').empty();
        }
    });
    /*
     * pesquisa os ar no projeto atual
     * TODO: fazer a parte de pesquisa no projeto atual
     */
    $('#btn-ar-projeto').on('click', function () {
        pProjeto = pProjeto ? false : true;
        var idBaseline = $('#contagem_id_baseline').val(); //0 se for uma contagem livre
        if (pProjeto) {//consultar
            if (abAtual == 3) {
                $('#lst-ar-projeto').append('<li class="btn btn-warning">Voc&ecirc; est&aacute; inserindo uma contagem de <strong>Baseline</strong></li>');
            }
            else {
                pArquivosReferenciados(idBaseline); //id, tipo, abrangencia
            }
        }
        else {//fechar
            $('#lst-ar-projeto').empty();
        }
    });
    /*
     * pesquisa os td dos arquivos referenciados
     */
    $('#btn-td-ar-baseline').on('click', function () {
        bAR = bAR ? false : true;
        var idBaseline = $('#contagem_id_baseline').val();
        if (bAR) {//consultar
            pTipoDadoAR($('#transacao_descricao_ar').tagsManager('tags'), idBaseline, 'B'); //ar, idBaseline, tipo B->baseline, P->projeto
        }
        else {//fechar
            $('#lst-td-ar-baseline').empty();
        }
    });
    /*
     * pesquisa os td dos arquivos referenciados
     * TODO: fazer a pesquisa nas funcoes
     */
    $('#btn-td-ar-projeto').on('click', function () {
        pAR = pAR ? false : true;
        if (pAR) {//consultar
            if (abAtual == 3) {
                $('#lst-td-ar-projeto').append('<li class="btn btn-warning">Voc&ecirc; est&aacute; inserindo uma contagem de <strong>Baseline</strong></li>');
            }
            else {
                pTipoDadoAR($('#transacao_descricao_ar').tagsManager('tags'), $('#contagem_id_baseline').val()); //ar, idBaseline
            }
        }
        else {//fechar
            $('#lst-td-ar-projeto').empty();
        }
    });
});
/*
 * genericos, aplicaveis a todas as contagens
 */
$("#escopo").charCount({allowed: 3000, warning: 100});
$("#proposito").charCount({allowed: 3000, warning: 100});
$("#text-indicativa").charCount({allowed: 3000, warning: 100});
//touchspin buttons
$("#entregas")
        .mask('00')
        .on('change', function () {
            qtdEntregas = $(this).val();
        })
        .TouchSpin({
            verticalbuttons: true,
            min: 1,
            max: contagemConfig.quantidade_maxima_entregas,
            step: 1,
            decimals: 0,
            boostat: 5,
            forcestepdivisibility: 'none',
            verticalupclass: 'glyphicon glyphicon-plus',
            verticaldownclass: 'glyphicon glyphicon-minus',
            postfix: ''
        });

$("#dados_entrega")
        .mask('00')
        .TouchSpin({
            verticalbuttons: true,
            min: 1,
            max: 50,
            step: 1,
            decimals: 0,
            boostat: 5,
            forcestepdivisibility: 'none',
            verticalupclass: 'glyphicon glyphicon-plus',
            verticaldownclass: 'glyphicon glyphicon-minus',
            postfix: ''

        });

$("#transacao_entrega")
        .mask('00')
        .TouchSpin({
            verticalbuttons: true,
            min: 1,
            max: 50,
            step: 1,
            decimals: 0,
            boostat: 5,
            forcestepdivisibility: 'none',
            verticalupclass: 'glyphicon glyphicon-plus',
            verticaldownclass: 'glyphicon glyphicon-minus',
            postfix: ''

        });

$("#outros_entrega")
        .mask('00')
        .TouchSpin({
            verticalbuttons: true,
            min: 1,
            max: 50,
            step: 1,
            decimals: 0,
            boostat: 5,
            forcestepdivisibility: 'none',
            verticalupclass: 'glyphicon glyphicon-plus',
            verticaldownclass: 'glyphicon glyphicon-minus',
            postfix: ''

        });
/*
 * limpa a tabela com os nomes dos arquivos
 */
$('#addFiles').empty();
/*
 * popover tipo
 */
var ctt = "<table class='table table-condensed table-striped'>" +
        "<thead>" +
        "<tr><th>Fun&ccedil;&atilde;o</th><th>M&eacute;todo</th><th>Complex.</th><th>PFb</th>" +
        "</thead>" +
        "<tbody>" +
        "<tr><td>EE, CE</td><td>NESMA</td><td>M&eacute;dia</td><td>4,000</td></tr>" +
        "<tr><td>EE, CE</td><td>FP-LITE</td><td>M&eacute;dia</td><td>4,000</td></tr>" +
        "<tr><td>SE</td><td>NESMA</td><td>M&eacute;dia</td><td>5,000</td></tr>" +
        "<tr><td>SE</td><td>FP-LITE</td><td>M&eacute;dia</td><td>5,000</td></tr> " +
        "<tr><td colspan='4'><strong>Elementos Funcionas de Transa&ccedil;&atilde;o (EFt)</strong><br />" +
        "SE [ EFt = 1,00 + 0,81 * ALR + 0,13 * TD ]<br />" +
        "EE [ EFt = 0,75 + 0,91 * ALR + 0,13 * TD ]<br />" +
        "CE [ EFt = 0,75 + 0,76 * ALR + 0,10 * TD ]<br />" +
        "</td></tr>" +
        "</tbody>" +
        "</table>";
$("#tbl_tipos").attr("data-content", ctt);
/*
 * verifica a acao do CRUD caso o usuario desabilite e seja um AIE
 */
$('#is-crud').on('change', function () {
    if ($(this).prop('checked') && !isCRUD) {
        $(this).bootstrapToggle('off').bootstrapToggle('disable');
        gravaLogAuditoria(emailLogado, userRole, 'is-crud;' + ("000000000" + idContagem).slice(-9));
    }
});
/*
 * captura o o clique no botao para alterar o nome da funcao de dados
 */
$('#alterar-funcao-dados').on('click', function () {
    if ($(this).hasClass('alterar')) {
        $('#dados_funcao').prop('readonly', false);
        $('#dados_funcao_nome_anterior').val($('#dados_funcao').val());
        $('#dados_funcao_is_alterar_nome').val('1');
        $(this).removeClass('alterar').addClass('cancelar').removeClass('btn-default').addClass('btn-warning').html('<i class="fa fa-refresh fa-spin"></i>&nbsp;Aguarde').prop('disabled', true);
        //variaveis
        var idBaseline = abAtual == 3 ? $('#contagem_id_baseline').val() : 0;
        var funcao = $('#dados_funcao_nome_anterior').val();
        //verifica os relacionamentos do nome da funcionalidade
        $.post('DIM.Gateway.php', {
            'arq': 94,
            'tch': 1,
            'sub': -1,
            'dlg': 0,
            'idc': idContagem,
            'idb': idBaseline,
            'fun': funcao
        }, function (data) {
            if (data) {
                if (data.length > 0) {
                    var tipo = 'alert-danger';
                    var fa = 'warning';
                    var f = 'dados';
                    var h = $('#' + f + '_log').html();
                    var n = 'Refer&ecirc;ncias ao Arquivo L&oacute;gico (<strong>' + funcao + '</strong>)<br />';
                    for (x = 0; x < data.length; x++) {
                        n += '[ ' + (x + 1) + ' ] ' + ' ' +
                                data[x].tipo + ' - ' +
                                data[x].funcao + ' - ' +
                                //data[x].abrangencia + ' - ' +
                                //'<a href="mailto:' + data[x].responsavel + '">' + data[x].responsavel + '</a> - ' +
                                data[x].fonte + '; <br />';
                    }
                    h += '<div class="alert ' + tipo + ' alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&nbsp;<i class="fa fa-times-circle"></i>&nbsp;</span></button>' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close" data-toggle="tooltip" data-placement="left" title="Inserir em observações" onclick="javascript: $(\'#dados_observacoes\').val($(\'#dados_observacoes\').val() + $(\'#log-atual\').html().stripHTMLSpace()); return false;"><span aria-hidden="true">' +
                            '&nbsp;<i class="fa fa-upload"></i>&nbsp;</span></button>' +
                            '<i class="fa ' + fa + '"></i><span id="log-atual">' + n + '</span></div>';
                    $('#' + f + '_log').html(h);
                    //reinicializa os tooltips
                    $('[data-toggle="tooltip"]').tooltip();
                }
            }
            $('#alterar-funcao-dados').html('<i class="fa fa-arrow-circle-left"></i>&nbsp;Cancelar').prop('disabled', false);
        }, 'json');
    }
    else {
        $('#dados_funcao').prop('readonly', true).val($('#dados_funcao_nome_anterior').val()).css({'background-color': '#ffffe5'});
        $(this).removeClass('cancelar').addClass('alterar').removeClass('btn-warning').addClass('btn-default').html('<i class="fa fa-edit"></i>&nbsp;Alterar');
        $('#dados_funcao_is_alterar_nome').val('0');
    }
});
/*
 * ATENCAO
 * ponto de corte para os tipos de contagem
 * a) nesta primeira condicao sao as contagens
 * 1. Avulsa
 * 2. Projeto
 * 3. Baseline
 * 4. Licitacao
 * 9. Elementos Funcionais
 */
if (abAtual < 5 || abAtual == 9) {
    $("#btn_adicionar_ali").on("click", function () {
        //exibe o formulario e seta os campos principais
        exibeModalForm('dados', title_ali_inc, 'ALI', $(this)[0], 'ad');
        //somente aqui habilita a combo dados_fe - formularios estendidos
        $('#dados_fe').prop('disabled', false);
        //habilita a funcionalidade de CRUD mas nao is_crud automatico
        $('#is-crud').bootstrapToggle('enable').bootstrapToggle('off');
        $('#is-crud-atualizar-dependentes').bootstrapToggle('enable').bootstrapToggle('off');
        isCRUD = true;
        //verifica a quantidade de entregas autorizadas
        estabeleceQuantidadeEntregas('dados');
        //habilita o input para o nome da funcao e desabilita o alterar
        $('#dados_funcao').prop('readonly', false);
    });
    $("#btn_adicionar_aie").on("click", function () {
        //exibe o formulario e seta os campos iniciais
        exibeModalForm('dados', title_aie_inc, 'AIE', $(this)[0], 'ad');
        //desabilita a combo dados_fe - formularios estendidos
        $('#dados_fe').val(0).prop('disabled', true);
        //desabilita o crud automaticamente
        $('#is-crud').bootstrapToggle('off').bootstrapToggle('disable');
        $('#is-crud-atualizar-dependentes').bootstrapToggle('off').bootstrapToggle('disable');
        isCRUD = false;
        //verifica a quantidade de entregas autorizadas
        estabeleceQuantidadeEntregas('dados');
        //habilita o input para o nome da funcao e desabilita o alterar
        $('#dados_funcao').prop('readonly', false);
    });
    $("#btn_adicionar_ee").on("click", function () {
        exibeModalForm('transacao', title_ee_inc, 'EE', $(this)[0], 'ad');
        estabeleceQuantidadeEntregas('transacao');
    });
    $("#btn_adicionar_se").on("click", function () {
        exibeModalForm('transacao', title_se_inc, 'SE', $(this)[0], 'ad');
        estabeleceQuantidadeEntregas('transacao');
    });
    $("#btn_adicionar_ce").on("click", function () {
        exibeModalForm('transacao', title_ce_inc, 'CE', $(this)[0], 'ad');
        estabeleceQuantidadeEntregas('transacao');
    });
    $("#btn_adicionar_ou").on("click", function () {
        exibeModalForm('outros', title_ou_inc, 'OU', $(this)[0], 'ad');
        estabeleceQuantidadeEntregas('outros');
    });
    /*
     * captura os cliques nos botoes de alteracao no form_modal_altera_*
     */
    $("#transacao_btn_al").on("click", function () {
        alteraFuncaoTransacao($(this));
    });
    $("#transacao_btn_if").on("click", function () {
        var sucesso = insereFuncaoTransacao($(this)[0]);
        if (sucesso) {
            $(this).attr("data-dismiss", "modal");
            swal("Dimension", "O registro foi inserido com sucesso!", "success");
        }
        else {
            $(this).attr("data-dismiss", "");
        }
    });
    $("#transacao_btn_in").on("click", function () {
        var sucesso = insereFuncaoTransacao($(this)[0]);
        if (sucesso) {
            swal("Dimension", "O registro foi inserido com sucesso!", "success");
        }
    });
    $("#dados_btn_al").on("click", function () {
        alteraFuncaoDados($(this));
    });
    $("#dados_btn_if").on("click", function () {
        var sucesso = insereFuncaoDados($(this)[0]);
        if (sucesso) {
            $(this).attr("data-dismiss", "modal");
            swal("Dimension", "O registro foi inserido com sucesso!", "success");
        }
        else {
            $(this).attr("data-dismiss", "");
        }
    });
    $("#dados_btn_in").on("click", function () {
        var sucesso = insereFuncaoDados($(this)[0]);
        if (sucesso) {
            swal("Dimension", "O registro foi inserido com sucesso!", "success");
        }
    });
    $("#outros_btn_al").on("click", function () {
        alteraFuncaoOutros($(this));
    });
    $("#outros_btn_if").on("click", function () {
        var sucesso = insereFuncaoOutros($(this)[0]);
        if (sucesso) {
            $(this).attr("data-dismiss", "modal");
            swal("Dimension", "O registro foi inserido com sucesso!", "success");
        }
    });
    $("#outros_btn_in").on("click", function () {
        var sucesso = insereFuncaoOutros($(this)[0]);
        if (sucesso) {
            swal("Dimension", "O registro foi inserido com sucesso!", "success");
        }
    });
    //combos roteiro
    //TODO: ver isso quando for uma funcao de baseline em uma contagem de projeto
    //precisa alterar
    $('#dados_id_roteiro').on('change', function () {
        //verificar se o roteiro eh o do Dimension em casos de baseline para nao limpar tudo.
        if (acForms !== 'al') {
            limpaCampos('dados', false, acForms);
            /*
             * se for baseline ja estabelece o valor da operacao em I - Inclusao
             */
            if (abAtual == 3) {
                $('#dados_operacao').val('I');
                destacaBotao('dados', '_op', ['btn-success', 'btn-default', 'btn-default', 'btn_default']);
            }
            /*
             * se for projeto desabilita a opcao de alteracao, ja que nao tem sentido alterar um aie
             */
            else if (abAtual == 2 && $('#dados_tabela').val() === 'AIE') {
                $('#dados_op2').prop('disabled', true);
            }
            /*
             * verifica a operacao
             */
            if ($('#dados_operacao').val() !== '')
                verificaOperacao('dados', $('#dados_operacao').val(), $(this).val(), 0, $('#dados_tabela').val(), acForms);
        }
        else if (acForms === 'al') {
            /**
             * 
             * @param {string} f funcao T - Transacao, D - Dados
             * @param {string} v valor I = Incluir, A = Alterar, E = Excluir e T = Testes
             * @param {int} i id_roteiro
             * @param {string} s id_fator_impacto - valor da selecao (16;0.985,IN_FA_A)
             * @param {string} b tabela ALI, AIE, etc
             * @param {string} a acao (inserir/alterar) ad = adicionar, al = alterar
             * @returns {Boolean}
             */
            /*
             * pega a combo impacto
             */
            var i = $(this).val();
            var f = 'dados';
            var s = 0;
            var b = $('#dados_tabela').val();
            var v = $('#dados_operacao').val();
            var a = 'al';
            comboFatorImpacto(i, f, s, b, v, a);
        }
    });
    $('#transacao_id_roteiro').on('change', function () {
        //verificar se o roteiro eh o do Dimension em casos de baseline para nao limpar tudo.
        if (acForms !== 'al') {
            limpaCampos('transacao', false, acForms);
            /*
             * se for baseline ja estabelece o valor da operacao em I - Inclusao
             */
            if (abAtual == 3) {
                $('#transacao_operacao').val('I');
                destacaBotao('transacao', '_op', ['btn-success', 'btn-default', 'btn-default', 'btn-default']);
            }
            /*
             * verifica a operacao
             */
            if ($('#transacao_operacao').val() !== '')
                verificaOperacao('transacao', $('#transacao_operacao').val(), $(this).val(), 0, $('#transacao_tabela').val(), acForms);
        }
        else if (acForms === 'al') {
            /**
             * 
             * @param {string} f funcao T - Transacao, D - Dados
             * @param {string} v valor I = Incluir, A = Alterar, E = Excluir e T = Testes
             * @param {int} i id_roteiro
             * @param {string} s id_fator_impacto - valor da selecao (16;0.985,IN_FA_A)
             * @param {string} b tabela ALI, AIE, etc
             * @param {string} a acao (inserir/alterar) ad = adicionar, al = alterar
             * @returns {Boolean}
             */
            /*
             * pega a combo impacto
             */
            var i = $(this).val();
            var f = 'transacao';
            var s = 0;
            var b = $('#transacao_tabela').val();
            var v = $('#transacao_operacao').val();
            var a = 'al';
            comboFatorImpacto(i, f, s, b, v, a);
        }
    });
    $('#outros_id_roteiro').on('change', function () {
        //passou aqui limpa tudo
        limpaCampos('outros', false, acForms);
        /*
         * se for baseline ja estabelece o valor da operacao em I - Inclusao
         */
        if (abAtual == 3) {
            $('#outros_operacao').val('I');
            destacaBotao('outros', '_op', ['btn-success', 'btn-default', 'btn-default', 'btn-default']);
        }
        /*
         * verifica a operacao
         */
        if ($('#outros_operacao').val() !== '')
            verificaOperacao('outros', $('#outros_operacao').val(), $(this).val(), 0, $('#outros_tabela').val(), acForms);
    });
    /**
     * PARAMETROS PARA A FUNCAO VERIFICA OPERACAO
     * @param {string} f funcao T - Transacao, D - Dados
     * @param {string} v valor I = Incluir, A = Alterar e E = Excluir
     * @param {int}    i id_roteiro
     * @param {string} s id_fator_impacto - valor da selecao (16;0.985,IN_FA_A;A)
     * @param {string} b tabela ALI, AIE, etc
     * @param {string} a acao (inserir/alterar)
     * @returns {Boolean}
     */
    $("#dados_op1").on("click", function () {
        $("#dados_tabela").val() === 'ALI' ? $('#is-criar-crud').bootstrapToggle('enable') : $('#is-criar-crud').bootstrapToggle('disable');
        verificaOperacao('dados', $(this).val(), $('#dados_id_roteiro').val(), 0, $('#dados_tabela').val(), acForms);
    });
    $("#dados_op2").on("click", function () {
        $('#is-criar-crud').bootstrapToggle('disable');
        verificaOperacao('dados', $(this).val(), $('#dados_id_roteiro').val(), 0, $('#dados_tabela').val(), acForms);
    });
    $("#dados_op3").on("click", function () {
        $('#is-criar-crud').bootstrapToggle('disable');
        verificaOperacao('dados', $(this).val(), $('#dados_id_roteiro').val(), 0, $('#dados_tabela').val(), acForms);
    });
    $("#dados_op4").on("click", function () {
        $('#is-criar-crud').bootstrapToggle('disable');
        verificaOperacao('dados', $(this).val(), $('#dados_id_roteiro').val(), 0, $('#dados_tabela').val(), acForms);
    });
    $("#transacao_op1").on("click", function () {
        verificaOperacao('transacao', $(this).val(), $('#transacao_id_roteiro').val(), 0, $('#transacao_tabela').val(), acForms);
    });
    $("#transacao_op2").on("click", function () {
        verificaOperacao('transacao', $(this).val(), $('#transacao_id_roteiro').val(), 0, $('#transacao_tabela').val(), acForms);
    });
    $("#transacao_op3").on("click", function () {
        verificaOperacao('transacao', $(this).val(), $('#transacao_id_roteiro').val(), 0, $('#transacao_tabela').val(), acForms);
    });
    $("#transacao_op4").on("click", function () {
        verificaOperacao('transacao', $(this).val(), $('#transacao_id_roteiro').val(), 0, $('#transacao_tabela').val(), acForms);
    });
    $("#outros_op1").on("click", function () {
        verificaOperacao('outros', $(this).val(), $('#outros_id_roteiro').val(), 0, $('#outros_tabela').val(), acForms);
    });
    $("#outros_op2").on("click", function () {
        verificaOperacao('outros', $(this).val(), $('#outros_id_roteiro').val(), 0, $('#outros_tabela').val(), acForms);
    });
    $("#outros_op3").on("click", function () {
        verificaOperacao('outros', $(this).val(), $('#outros_id_roteiro').val(), 0, $('#outros_tabela').val(), acForms);
    });
    //fator documentacao
    $('#dados_fd').on('change', function () {
        calculaPfa($('#dados_impacto'), $('#dados_pfb'), $('#dados_pfa'), 'dados', 0);
    });
    $('#transacao_fd').on('change', function () {
        calculaPfa($('#transacao_impacto'), $('#transacao_pfb'), $('#transacao_pfa'), 'transacao', 0);
    });
    $('#id_fator_tecnologia').on('change', function () {
        var valor_fator_tecnologia = ($('#id_fator_tecnologia option:selected').text()).split('-')[0];
        $('#valor_fator_tecnologia').html(parseFloat(valor_fator_tecnologia).toFixed(3));
        if ($('#transacao_impacto option:selected').val() !== '0') {
            calculaPfa($('#transacao_impacto'), $('#transacao_pfb'), $('#transacao_pfa'), 'transacao', 0);
        }
    });
    //formularios estendidos
    $('#dados_fe').on('change', function () {
        calculaPfa($('#dados_impacto'), $('#dados_pfb'), $('#dados_pfa'), 'dados', $(this).val());
    });
    //botoes de metodo
    $("#dados_me1").on("click", function () {//nesma
        verificaMetodo('dados', $(this), $('#dados_id_roteiro'), $('#dados_operacao'));
    });
    $("#dados_me2").on("click", function () {//fp-lite
        verificaMetodo('dados', $(this), $('#dados_id_roteiro'), $('#dados_operacao'));
    });
    $("#dados_me3").on("click", function () {//detalhado
        verificaMetodo('dados', $(this), $('#dados_id_roteiro'), $('#dados_operacao'));
    });
    $("#transacao_me1").on("click", function () {
        verificaMetodo('transacao', $(this), $('#transacao_id_roteiro'), $('#transacao_operacao'));
    });
    $("#transacao_me2").on("click", function () {
        verificaMetodo('transacao', $(this), $('#transacao_id_roteiro'), $('#transacao_operacao'));
    });
    $("#transacao_me3").on("click", function () {
        verificaMetodo('transacao', $(this), $('#transacao_id_roteiro'), $('#transacao_operacao'));
    });
    //captura do hidden do modal
    $('#form_modal_funcao_dados').on('hidden.bs.modal', function () {
        limpaCampos('dados', true, 'ad');
        autorizaAlteracaoCamposLinha(true, 'dados');
    });
    $('#form_modal_funcao_transacao').on('hidden.bs.modal', function () {
        limpaCampos('transacao', true, 'ad');
        autorizaAlteracaoCamposLinha(true, 'transacao');
    });
    $('#form_modal_funcao_outros').on('hidden.bs.modal', function () {
        limpaCampos('outros', true, 'ad');
        autorizaAlteracaoCamposLinha(true, 'outros');
    });
    //calculo do novo PFa de acordo com o *-is-mudanca
    $('#dados-percentual-fase').on('keyup', function (e) {
        if (Number($(this).val()) == 0) {
            $(this).val('');
        }
        else if (Number($(this).val()) > 100) {
            $(this).val(100);
        }
        /**
         * 
         * @param {type} a - Fator de impacto (Ajuste)
         * @param {type} b - PFb
         * @param {type} c - PFa
         * @param {type} t - funcao (transacao/dados/outros)
         * @returns {Boolean}
         */
        //antes verifica se tem fator_impacto
        if ($('#dados_impacto').val() == 0) {
            swal({
                title: "Alerta",
                text: "Por favor, selecione o Fator de Impacto antes de digitar o percentual de conclusão da fase.",
                type: "error",
                html: true,
                confirmButtonText: "Entendi, obrigado!"}, function () {
                return false;
            });
            $(this).val('');
        }
        else {
            calculaPfa($('#dados_impacto'), $('#dados_pfb'), $('#dados_pfa'), 'qnqbf'.dScr(), $('#dados_fe').val());
        }
    });
    //transacao
    $('#transacao-percentual-fase').on('keyup', function (e) {
        if (Number($(this).val()) == 0) {
            $(this).val('');
        }
        else if (Number($(this).val()) > 100) {
            $(this).val(100);
        }
        /**
         * 
         * @param {type} a - Fator de impacto (Ajuste)
         * @param {type} b - PFb
         * @param {type} c - PFa
         * @param {type} t - funcao (transacao/dados/outros)
         * @returns {Boolean}
         */
        //antes verifica se tem fator_impacto
        if ($('#transacao_impacto').val() == 0) {
            swal({
                title: "Alerta",
                text: "Por favor, selecione o Fator de Impacto antes de digitar o percentual de conclusão da fase.",
                type: "error",
                html: true,
                confirmButtonText: "Entendi, obrigado!"}, function () {
                return false;
            });
            $(this).val('');
        }
        else {
            calculaPfa($('#transacao_impacto'), $('#transacao_pfb'), $('#transacao_pfa'), 'genafnpnb'.dScr(), 0);
        }
    });
    /*
     * change do *-fase para habilitar o percentual
     */
    $('#dados-fase').on('change', function () {
        if (Number($(this).val()) == 0) {
            $('#dados-percentual-fase').val('').prop('readonly', true);
        }
        else {
            $('#dados-percentual-fase').prop('readonly', false).val('').get(0).focus();
        }
        //sempre recalcula
        Number($('#dados_impacto').val()) != 0 ? calculaPfa($('#dados_impacto'), $('#dados_pfb'), $('#dados_pfa'), 'qnqbf'.dScr(), $('#dados_fe').val()) : null;
    });
    $('#transacao-fase').on('change', function () {
        if (Number($(this).val()) == 0) {
            $('#transacao-percentual-fase').val('').prop('readonly', true);
        }
        else {
            $('#transacao-percentual-fase').prop('readonly', false).val('').get(0).focus();
        }
        //sempre recalcula
        Number($('#transacao_impacto').val()) != 0 ? calculaPfa($('#transacao_impacto'), $('#transacao_pfb'), $('#transacao_pfa'), 'genafnpnb'.dScr(), 0) : null;
    });
    //calculo para a variavel is-mudanca
    $('#dados-is-mudanca').on('change', function () {
        if ($(this).prop('checked')) {
            $('#dados-fase').prop('disabled', false).get(0).focus();
        }
        else {
            $('#dados-fase').prop('disabled', true).val(0);
            $('#dados-percentual-fase').prop('readonly', true).val('');
        }
        //recalcula se nao for zero
        Number($('#dados_impacto').val()) != 0 ? calculaPfa($('#dados_impacto'), $('#dados_pfb'), $('#dados_pfa'), 'qnqbf'.dScr(), $('#dados_fe').val()) : null;
    });
    $('#transacao-is-mudanca').on('change', function () {
        if ($(this).prop('checked')) {
            $('#transacao-fase').prop('disabled', false).get(0).focus();
        }
        else {
            $('#transacao-fase').prop('disabled', true).val(0);
            $('#transacao-percentual-fase').prop('readonly', true).val('');
        }
        Number($('#transacao_impacto').val()) != 0 ? calculaPfa($('#transacao_impacto'), $('#transacao_pfb'), $('#transacao_pfa'), 'genafnpnb'.dScr(), 0) : null;
    });
    //combos de fator de impacto
    $("#dados_impacto").on("change", function () {
        //insere no popover os valores do item
        detalheItem($(this).val(), 'qnqbf'.dScr());
        //verifica o valor da combo
        if (Number($(this).val()) == 0) {
            $('#dados_pfa').val('');
            $('#dados-is-mudanca').bootstrapToggle('off').bootstrapToggle('disable');
            $('#dados-fase').prop('disabled', true).val(0);
            $('#dados-percentual-fase').val('').prop('readonly', true);
            $('#dados_fd').val('0.00').prop('disabled', true);
            $('#dados_fe').val(0);
        }
        else {
            if ($('#dados_operacao').val() === 'A' || $('#dados_operacao').val() === 'E') {
                $('#dados-is-mudanca').bootstrapToggle('enable').bootstrapToggle('off');
                $('#dados_fd').val('0.00').prop('disabled', false);
            }
            calculaPfa($(this), $('#dados_pfb'), $('#dados_pfa'), 'qnqbf'.dScr(), $('#dados_fe').val());
        }
    });
    $("#transacao_impacto").on("change", function () {
        //insere no popover os valores do item
        detalheItem($(this).val(), 'genafnpnb'.dScr());
        //verifica o valor da combo
        if (Number($(this).val()) === 0) {
            $('#transacao_pfa').val('');
            $('#transacao-is-mudanca').bootstrapToggle('off').bootstrapToggle('disable');
            $('#transacao-fase').val(0).prop('disabled', true);
            $('#transacao-percentual-fase').val('').prop('readonly', true);
            $('#transacao_fd').val('0.00').prop('disabled', true);
        }
        else {
            if ($('#transacao_operacao').val() === 'A' || $('#transacao_operacao').val() === 'E') {
                $('#transacao-is-mudanca').bootstrapToggle('enable').bootstrapToggle('off');
                $('#transacao_fd').val('0.00').prop('disabled', false);
            }
            calculaPfa($(this), $('#transacao_pfb'), $('#transacao_pfa'), 'genafnpnb'.dScr(), 0);
        }
    });
    $("#outros_impacto").on("change", function () {
        detalheItem($(this).val(), 'outros');
        if (Number($(this).val()) === 0) {
            $("#outros_pfa").val('');
            return false;
        }
        else {
            calculaPfa($(this), $('#outros_pfa')[0], $('#outros_pfa')[0], 'outros', 0);
        }
    });
    //evento de change para a tela "OUTROS" na quantidade
    $("#outros_qtd").on("keyup", function () {
        if (Number($("#outros_impacto").val()) !== 0 && $(this).val() != '') {
            calculaPfa($("#outros_impacto")[0], $('#outros_pfa')[0], $('#outros_pfa')[0], 'outros', 0);
        } else if ($(this).val() === '') {
            $("#outros_pfa").val('');
        }
    });
    //aplicabilidade nos formularios de insercao de funcoes
    $("#dados_observacoes").charCount({allowed: 3000, warning: 100});
    $("#transacao_observacoes").charCount({allowed: 3000, warning: 100});
    $("#outros_observacoes").charCount({allowed: 3000, warning: 100});
    $("#outros_observacoes_validacao").charCount({allowed: 3000, warning: 100});
    //restricoes relacionadas as entregas e tds/ars/qtd, que aceitam somente numeros
    $("#dados_tr").mask('000');
    $("#dados_td").mask('000');
    $("#transacao_ar").mask('000');
    $("#transacao_td").mask('000');
    $("#outros_qtd").mask('0000');
    /*
     * coloca os marcadores de insercao das tags
     */
    jQuery("#dados_descricao_td").tagsManager({
        blinkBGColor_1: '#FFFF9C',
        blinkBGColor_2: '#CDE69C',
        tagCloseIcon: '<i class="fa fa-times-circle"></i>',
        deleteTagsOnBackspace: true,
        isInserirTR: true
    }).on('tm:pushed', function (e, tag, isTR) {
        var qtd = $(this).tagsManager('tags');
        if (Number($('#dados_metodo').val()) == 3) {
            calculaLinhaPFDetalhada(qtd, 'dados', 'td', $('#dados_tabela').val());
        }
    }).on('tm:popped', function (e, tag) {
        var qtd = $(this).tagsManager('tags');
        var funcao;
        //verifica se eh uma funcao em contagem de baseline e/ou projeto e verifica a descricao do TD
        //para pegar as referencias de utilizacao
        //como existem dois metodos de entrada (text e select), tem que verificar o nome antes
        if ($('#dados_funcao').is('input')) {
            funcao = $('#dados_funcao').val();
        }
        else {
            funcao = $('#dados_funcao').find('option:selected').text();
            funcao = funcao.split(' > ');
            funcao = funcao[5];
        }
        if (abAtual == 2 || abAtual == 3) {
            //fun, icn, tbl, iba, tag
            verificaIntegridadeTD(funcao, idContagem, $('#dados_tabela').val(), $('#contagem_id_baseline').val(), tag);
        }
        if (Number($('#dados_metodo').val()) == 3) {
            calculaLinhaPFDetalhada(qtd, 'dados', 'td', $('#dados_tabela').val());
        }
    }).on('tm:spliced', function (e, tag) {
        var qtd = $(this).tagsManager('tags');
        if ($('#dados_funcao').is('input')) {
            funcao = $('#dados_funcao').val();
        }
        else {
            funcao = $('#dados_funcao').find('option:selected').text();
            funcao = funcao.split(' > ');
            funcao = funcao[5];
        }
        if (abAtual == 2 || abAtual == 3) {
            //fun, icn, tbl, iba, tag
            verificaIntegridadeTD(funcao, idContagem, $('#dados_tabela').val(), $('#contagem_id_baseline').val(), tag);
        }
        if (Number($('#dados_metodo').val()) == 3) {
            calculaLinhaPFDetalhada(qtd, 'dados', 'td', $('#dados_tabela').val());
        }
    });

    jQuery("#dados_descricao_tr").tagsManager({
        blinkBGColor_1: '#FFFF9C',
        blinkBGColor_2: '#CDE69C',
        tagCloseIcon: '<i class="fa fa-times-circle"></i>'
    }).on('tm:pushed', function (e, tag) {
        var qtd = $(this).tagsManager('tags');
        if (Number($('#dados_metodo').val()) == 3) {
            calculaLinhaPFDetalhada(qtd, 'dados', 'tr', $('#dados_tabela').val());
        }
    }).on('tm:popped', function (e, tag) {
        var qtd = $(this).tagsManager('tags');
        if (Number($('#dados_metodo').val()) == 3) {
            calculaLinhaPFDetalhada(qtd, 'dados', 'tr', $('#dados_tabela').val());
        }
    }).on('tm:spliced', function (e, tag) {
        var qtd = $(this).tagsManager('tags');
        if (Number($('#dados_metodo').val()) == 3) {
            calculaLinhaPFDetalhada(qtd, 'dados', 'tr', $('#dados_tabela').val());
        }
    });

    jQuery("#transacao_descricao_ar").tagsManager({
        blinkBGColor_1: '#FFFF9C',
        blinkBGColor_2: '#CDE69C',
        tagCloseIcon: '<i class="fa fa-times-circle"></i>'
    }).on('tm:pushed', function (e, tag) {
        if (validaTag('AR', tag)) {
            var qtd = $(this).tagsManager('tags');
            if (Number($('#transacao_metodo').val()) == 3) {
                calculaLinhaPFDetalhada(qtd, 'transacao', 'ar', $('#transacao_tabela').val());
            }
            //atualiza a combo para copiar e colar
            atualizaComboPaste(qtd);
        }
    }).on('tm:popped', function (e, tag) {
        var qtd = $(this).tagsManager('tags');
        verificaTDSInseridos(tag);
        if (Number($('#transacao_metodo').val()) == 3) {
            calculaLinhaPFDetalhada(qtd, 'transacao', 'ar', $('#transacao_tabela').val());
        }
        //atualiza a combo para copiar e colar
        atualizaComboPaste(qtd);
    }).on('tm:spliced', function (e, tag) {
        var qtd = $(this).tagsManager('tags');
        verificaTDSInseridos(tag);
        if (Number($('#transacao_metodo').val()) == 3) {
            calculaLinhaPFDetalhada(qtd, 'transacao', 'ar', $('#transacao_tabela').val());
        }
        //atualiza a combo para copiar e colar
        atualizaComboPaste(qtd);
    });

    jQuery("#transacao_descricao_td").tagsManager({
        blinkBGColor_1: '#FFFF9C',
        blinkBGColor_2: '#CDE69C',
        tagCloseIcon: '<i class="fa fa-times-circle"></i>'
    }).on('tm:pushed', function (e, tag) {
        if (validaTag('TD', tag)) {
            var qtd = $(this).tagsManager('tags');
            if (Number($('#transacao_metodo').val()) == 3) {
                calculaLinhaPFDetalhada(qtd, 'transacao', 'td', $('#transacao_tabela').val());
            }
        }
    }).on('tm:popped', function (e, tag) {
        var qtd = $(this).tagsManager('tags');
        if (Number($('#transacao_metodo').val()) == 3) {
            calculaLinhaPFDetalhada(qtd, 'transacao', 'td', $('#transacao_tabela').val());
        }
    }).on('tm:spliced', function (e, tag) {
        var qtd = $(this).tagsManager('tags');
        if (Number($('#transacao_metodo').val()) == 3) {
            calculaLinhaPFDetalhada(qtd, 'transacao', 'td', $('#transacao_tabela').val());
        }
    }).on('tm:emptied', function (e, taglist) {
        var qtd = $(this).tagsManager('tags');
        if (Number($('#transacao_metodo').val()) == 3) {
            calculaLinhaPFDetalhada(qtd, 'transacao', 'td', $('#transacao_tabela').val());
        }
    });
    //fixa os headers das tabelas
    $('#fixALI').floatThead({scrollingTop: 54, useAbsolutePositioning: true});
    $('#fixAIE').floatThead({scrollingTop: 54, useAbsolutePositioning: true});
    $('#fixEE').floatThead({scrollingTop: 54, useAbsolutePositioning: true});
    $('#fixSE').floatThead({scrollingTop: 54, useAbsolutePositioning: true});
    $('#fixCE').floatThead({scrollingTop: 54, useAbsolutePositioning: true});
    $('#fixOU').floatThead({scrollingTop: 54, useAbsolutePositioning: true});
    $('#fixFiles').floatThead({scrollingTop: 54, useAbsolutePositioning: true});
    //selects para validacao
    $('#select-ALI').on('click', function () {
        selecionaLinhasValidacao('ALI', $(this));
    });
    $('#select-AIE').on('click', function () {
        selecionaLinhasValidacao('AIE', $(this));
    });
    $('#select-EE').on('click', function () {
        selecionaLinhasValidacao('EE', $(this));
    });
    $('#select-SE').on('click', function () {
        selecionaLinhasValidacao('SE', $(this));
    });
    $('#select-CE').on('click', function () {
        selecionaLinhasValidacao('CE', $(this));
    });
    $('#select-OU').on('click', function () {
        selecionaLinhasValidacao('OU', $(this));
    });
    //funcao de validacao das linhas. Passar a tabela em minuscula ali, aie, ee, etc porque ira acessar o banco
    $('#btn_validar_ALI').on('click', function () {
        validarFuncao('ali', arrValidaALI, 'validar');
    });
    $('#btn_validar_AIE').on('click', function () {
        validarFuncao('aie', arrValidaAIE, 'validar');
    });
    $('#btn_validar_EE').on('click', function () {
        validarFuncao('ee', arrValidaEE, 'validar');
    });
    $('#btn_validar_SE').on('click', function () {
        validarFuncao('se', arrValidaSE, 'validar');
    });
    $('#btn_validar_CE').on('click', function () {
        validarFuncao('ce', arrValidaCE, 'validar');
    });
    $('#btn_validar_OU').on('click', function () {
        validarFuncao('ou', arrValidaOU, 'validar');
    });
    //funcao de revisao das linhas. Passar a tabela em minuscula ali, aie, ee, etc porque ira acessar o banco
    $('#btn_revisar_ALI').on('click', function () {
        validarFuncao('ali', arrValidaALI, 'revisar');
    });
    $('#btn_revisar_AIE').on('click', function () {
        validarFuncao('aie', arrValidaAIE, 'revisar');
    });
    $('#btn_revisar_EE').on('click', function () {
        validarFuncao('ee', arrValidaEE, 'revisar');
    });
    $('#btn_revisar_SE').on('click', function () {
        validarFuncao('se', arrValidaSE, 'revisar');
    });
    $('#btn_revisar_CE').on('click', function () {
        validarFuncao('ce', arrValidaCE, 'revisar');
    });
    $('#btn_revisar_OU').on('click', function () {
        validarFuncao('ou', arrValidaOU, 'revisar');
    });
}
else if (abAtual == 5) {
    $('#fixDO').floatThead({scrollingTop: 54, useAbsolutePositioning: true});
}
//verifica se tem um hash para direcionar a tabs
$(function () {
    var locationHash = location.hash;
    var hashTab = locationHash.split(':');
    var activeTab = hashTab[0] ? $('[href=' + hashTab[0] + ']') : null;
    activeTab && activeTab.tab('show');
    idLinhaFuncao = hashTab[1];
});
/*
 * muda aqui o idRoteiro padrao
 */
idRoteiro = getVar('rot');
/*
 * acoes disparadas pela variavel no inicio do formulario exceto para inclusoes
 */
if (ac === 'al' || ac === 'vi' || ac === 've' || ac === 'ai' || ac === 'ae' || ac === 'vw' || ac === 're') {
    $.post('/pf/DIM.Gateway.php', {
        'id': idContagem,
        'ac': ac,
        'ab': abAtual,
        'arq': 40,
        'tch': 1,
        'sub': -1,
        'dlg': 1}, function (data) {
        if (data.alerta) {
            swal({
                title: "Alerta",
                text: data.msg,
                type: "error",
                html: true,
                confirmButtonText: "Ok, entendi!"},
            function () {
                self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1';
            });
        }
        else {
            //a combo cliente sera preenchida em todos os casos e desabilitada no final
            //caso um gestor esteja alterando a contagem de um fornecedor
            comboCliente('contagem', data[0].idCliente, '01', data[0].idFornecedor);
            //contagem de baseline
            if (abAtual == 3) {
                $('#contagem_id_contrato').empty().append('<option value="0">---</option>').prop('disabled', true);
                $('#contagem_id_projeto').empty().append('<option value="0">---</option>').prop('disabled', true);
                $('#id-orgao').empty().append('<option value="0">---</option>').prop('disabled', true);
                $('#contagem_id_baseline').prop('disabled', false);
                comboBaseline(data[0].idBaseline, '01', $("#contagem_id_baseline"), 0);//idClienteContagem em inc_meta
            }
            //contagem de licitacao
            else if (abAtual == 4) {
                $('#contagem_id_contrato').empty().append('<option value="0">---</option>').prop('disabled', true);
                $('#contagem_id_projeto').empty().append('<option value="0">---</option>').prop('disabled', true);
                $('#contagem_id_baseline').empty().append('<option value="0">---</option>').prop('disabled', true);
                $('#id-orgao').empty().append('<option value="0">---</option>').prop('disabled', true);
            }
            //demais contagens
            else {
                //verificacao se eh uma contagem de auditoria com a flag especial
                //precisa selecionar todos os contratos da organizacao pai
                if (Number(isContagemAuditoria) == 1) {
                    comboContrato(data[0].idCliente, '01', data[0].idContrato, 0, 'contagem', 1);
                    comboProjeto(data[0].idContrato, '01', data[0].idProjeto, 'contagem');
                }
                else {
                    comboCliente('contagem', data[0].idCliente, '01', data[0].idFornecedor);
                    comboContrato(data[0].idCliente, '01', data[0].idContrato, 0, 'contagem', 0);
                    comboProjeto(data[0].idContrato, '01', data[0].idProjeto, 'contagem');
                }
                //id baseline para todo mundo que entra por aqui
                $('#contagem_id_baseline').empty().append('<option value="0">---</option>').prop('disabled', true);
            }
            //monta a combo baseline apenas se for uma contagem de baseline ou de projeto
            (abAtual == 2 || abAtual == 3) ? comboBaseline(data[0].idBaseline, '01', $("#contagem_id_baseline")) : null;
            comboFatorTecnologia(0, $('#id_fator_tecnologia'), data[0].idCliente);
            comboOrgao('01', data[0].idOrgao, data[0].idCliente, $('#id-orgao'));
            comboLinguagem('01', data[0].idLinguagem, $('#id_linguagem'), data[0].idCliente);
            comboTipoContagem('01', data[0].idTipoContagem, $('#id_tipo_contagem'));
            comboProcesso('01', data[0].idProcesso, $('#id_processo'));
            comboEtapa('01', data[0].idEtapa, $('#id_etapa'));
            //atribui o idEtapa
            idEtapa = data[0].idEtapa;
            //verifica se a etapa eh tres - indicativa e desabilita outros botoes
            if (data[0].idEtapa == 3) {
                $('#li-ee').addClass('disabled');
                $('#li-se').addClass('disabled');
                $('#li-ce').addClass('disabled');
                $('#li-ou').addClass('disabled');
                $('#btn-pesquisar-ali').prop('disabled', true);
                $('#btn-pesquisar-aie').prop('disabled', true);
                $('#btn_adicionar_ali').prop('disabled', true);
                $('#btn_adicionar_aie').prop('disabled', true);
            }
            else {
                $('#li-ee').removeClass('disabled');
                $('#li-se').removeClass('disabled');
                $('#li-ce').removeClass('disabled');
                $('#li-ou').removeClass('disabled');
                if (abAtual == 3) {
                    $('#btn-pesquisar-ali').prop('disabled', true);
                    $('#btn-pesquisar-ee').prop('disabled', true);
                    $('#btn-pesquisar-se').prop('disabled', true);
                    $('#btn-pesquisar-ce').prop('disabled', true);
                }
                else {
                    $('#btn-pesquisar-ali').prop('disabled', false);
                    $('#btn-pesquisar-aie').prop('disabled', false);
                    $('#btn_adicionar_ali').prop('disabled', false);
                    $('#btn_adicionar_aie').prop('disabled', false);
                }
            }
            //verifica se a contagem eh de baseline e desabilita as pesquisas. EXCETO !! ALIs de outras Baselines que sao AIE nesta
            comboIndustria('01', data[0].idIndustria, $('#id_industria'));
            comboProcessoGestao('01', data[0].idProcessoGestao, $('#id_processo_gestao'));
            comboBancoDados('01', data[0].idBancoDados, $('#id_banco_dados'), data[0].idCliente);
            verificaProdutividade(data[0].idLinguagem);
            $('#id').val(data[0].id);
            $("#proposito").val(data[0].proposito);
            $("#escopo").val(data[0].escopo);
            $("#entregas").val(data[0].entregas);
            //atualiza a variavel entregas
            qtdEntregas = data[0].entregas
            $("#ordem_servico").val(data[0].ordemServico);
            $("#id_abrangencia").val(data[0].idAbrangencia);
            $("#nome_gerente_projeto").val(data[0].nomeGerenteProjeto);
            $("#gerente_projeto").val(data[0].gerenteProjeto);
            $("#data_cadastro").val(data[0].dataCadastro);
            $("#responsavel").val(data[0].responsavel);
            //muda o texto do botao
            $('#span_btn_contagem').html('Atualizar informa&ccedil&otilde;es');
            //atualiza o check para a privacidade
            $('#privacidade').bootstrapToggle(data[0].privacidade == 0 ? 'off' : 'on').bootstrapToggle(isFornecedor ? 'disable' : 'enable');
            //altera a acao para atualizar/alterar
            $('#acao').val(ac);
            //insere o email do validador no span da tab finalizar
            //ver email de validadores em outras acoes
            if (ac === 're') {
                $('#email-validador').val(data[0].contagemIdProcesso == 8 ? data[0].validadorInterno : data[0].validadorExterno);
                $('#contagem-id-processo').val(data[0].contagemIdProcesso);
            }
            //habilita a tab finalizar apenas para al e re
            //TODO: colocar uma variavel para logar caso o usuario tire o 'disabled'
            if (ac === 'vi' || ac === 've' || ac === 'ai' || ac === 'ae' || ac === 'vw') {
                $('#li-fin').addClass('disabled');
            }
            else {
                $('#li-fin').removeClass('disabled');
            }
            //verificar se a contagem esta em validacao
            if (data[0].validadorInterno !== '') {
                if (data[0].validadorInterno !== emailLogado) {
                    if (data[0].isProcessoValidacaoInterna) {
                        $('#btn-validador-selecionado').css({'visibility': 'hidden'});
                        $('#div-validador').css({'visibility': 'visible'});
                        consultaGravatar(data[0].validadorInterno, '#img-validador');
                        $('#validador-selecionado').html('Esta contagem est&aacute; sendo validada internamente por: <u>' + data[0].validadorInterno + '</u>');
                    }
                    else {
                        $('#btn-validador-selecionado').css({'visibility': 'hidden'});
                        $('#div-validador').css({'visibility': 'visible'});
                        consultaGravatar(data[0].validadorInterno, '#img-validador');
                        $('#validador-selecionado').html('Esta contagem foi validada internamente por: <u>' + data[0].validadorInterno + '</u>');
                    }
                }
            }
            else if (data[0].validadorExterno !== '') {
                if (data[0].validadorExterno !== emailLogado) {
                    if (data[0].isProcessoValidacaoExterna) {
                        $('#btn-validador-selecionado').css({'visibility': 'hidden'});
                        $('#div-validador').css({'visibility': 'visible'});
                        consultaGravatar(data[0].validadorExterno, '#img-validador');
                        $('#validador-selecionado').html('Esta contagem est&aacute; sendo validada externamente por: <u>' + data[0].validadorExterno + '</u>');
                    }
                    else {
                        $('#btn-validador-selecionado').css({'visibility': 'hidden'});
                        $('#div-validador').css({'visibility': 'visible'});
                        consultaGravatar(data[0].validadorExterno, '#img-validador');
                        $('#validador-selecionado').html('Esta contagem foi validada externamente por: <u>' + data[0].validadorExterno + '</u>');
                    }
                }
            }
            /*
             * habilita ou desabilita os campos para alteracao
             */
            isAutorizadoAlterar = data[0].isAutorizadoAlterar;
            isAutorizadoValidarInternamente = data[0].isAutorizadoValidarInternamente;
            isValidadaInternamente = data[0].isValidadaInternamente;
            isAutorizadoRevisar = data[0].isAutorizadoRevisar;
            /*
             * ATENCAO
             * ponto de corte para os tipos de contagem
             * a) nesta primeira condicao sao as contagens
             * 1. Avulsa
             * 2. Projeto
             * 3. Baseline
             * 4. Licitacao
             * 5. SNAP
             * 9. Elementos Funcionais
             */
            if (abAtual != 5) {
                comboRoteiro('dados', '01', idRoteiro, 0);
                comboRoteiro('transacao', '01', idRoteiro, 0);
                comboRoteiro('outros', '01', idRoteiro, 0);
                //produtividades das linguagens atualiza primeiro
                $('#escala-produtividade').val(data[0].escalaProdutividade);
                $('#produtividade-baixa').val(data[0].produtividadeBaixa);
                $('#produtividade-media').val(data[0].produtividadeMedia);
                $('#produtividade-alta').val(data[0].produtividadeAlta);
                //verifica o check da produtividade da linguagem
                if (Number(data[0].isProdutividadeLinguagem) === 1) {
                    $('#chk_produtividade_global').bootstrapToggle('off').bootstrapToggle('disable');
                    $('#chk-produtividade-linguagem').bootstrapToggle('enable').bootstrapToggle('on');
                    //altera os demais valores
                    $('.escala').prop('disabled', false);
                    alteraEscalaProdutividade($('#escala-produtividade').val());
                    //ainda nao sei o porque disso aqui
                    isLinguagem = true;
                    isGlobal = false; //altera os valores dos campos de produtividade
                    config_isEng ? $("#prod-eng").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)).prop("readonly", true) : null;
                    config_isDes ? $("#prod-des").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)).prop("readonly", true) : null;
                    config_isImp ? $("#prod-imp").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)).prop("readonly", true) : null;
                    config_isTes ? $("#prod-tes").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)).prop("readonly", true) : null;
                    config_isHom ? $("#prod-hom").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)).prop("readonly", true) : null;
                    config_isImpl ? $("#prod-impl").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)).prop("readonly", true) : null;
                }
                else {
                    $('#chk_produtividade_global').bootstrapToggle(Number(data[0].chkProdutividadeGlobal) === 1 ? 'on' : 'off').bootstrapToggle('enable');
                    $('#chk-produtividade-linguagem').bootstrapToggle('off').bootstrapToggle(Number(data[0].chkProdutividadeGlobal) === 1 ? 'disable' : 'enable');
                    $('.escala').prop('disabled', true);
                    $('#escala-produtividade').val('media');
                    alteraEscalaProdutividade('media');
                    isLinguagem = false;
                    isGlobal = Number(data[0].chkProdutividadeGlobal) === 1 ? true : false;
                    config_isEng ? $("#prod-eng").val(parseFloat(data[0].prodEng).toFixed(2)).prop("readonly", (data[0].chkEng && Number(data[0].chkProdutividadeGlobal) === 0) ? false : true) : null;
                    config_isDes ? $("#prod-des").val(parseFloat(data[0].prodDes).toFixed(2)).prop("readonly", (data[0].chkDes && Number(data[0].chkProdutividadeGlobal) === 0) ? false : true) : null;
                    config_isImp ? $("#prod-imp").val(parseFloat(data[0].prodImp).toFixed(2)).prop("readonly", (data[0].chkImp && Number(data[0].chkProdutividadeGlobal) === 0) ? false : true) : null;
                    config_isTes ? $("#prod-tes").val(parseFloat(data[0].prodTes).toFixed(2)).prop("readonly", (data[0].chkTes && Number(data[0].chkProdutividadeGlobal) === 0) ? false : true) : null;
                    config_isHom ? $("#prod-hom").val(parseFloat(data[0].prodHom).toFixed(2)).prop("readonly", (data[0].chkHom && Number(data[0].chkProdutividadeGlobal) === 0) ? false : true) : null;
                    config_isImpl ? $("#prod-impl").val(parseFloat(data[0].prodImpl).toFixed(2)).prop("readonly", (data[0].chkImpl && Number(data[0].chkProdutividadeGlobal) === 0) ? false : true) : null;
                }
                $('#produtividade_global').html(data[0].produtividadeGlobal);
                //atualiza as estatisticas da contagem
                $('#previsao_inicio').val(data[0].previsaoInicio);
                $('#div_previsao_termino').val(data[0].previsaoTermino);
                $('#hlt').html(data[0].hlt);
                //atualiza o fator tecnologia
                $('#span-ft').html(Number(data[0].ft).toFixed(2));
                $('#chk-ft').bootstrapToggle(Number(data[0].isFt) === 1 ? 'on' : 'off');
                //atualiza o span indicando calculo com ft
                Number(data[0].isFt) === 1 ? '<br /><strong>FT: ' + Number($('#span-ft').html()).toFixed(2) + '</strong>' : '';
                //eng
                config_isEng ? $('#chk-eng').bootstrapToggle(data[0].chkEng ? 'on' : 'off') : null;
                config_isEng ? $('#pct-eng').html(data[0].pctEng) : null;
                config_isEng ? (Number(data[0].isProdutividadeLinguagem) === 1 ? $("#prod-eng").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)) : $('#prod-eng').val(data[0].prodEng)) : null;
                config_isEng ? $('#prof-eng').val(data[0].profEng) : null;
                for (i = 0; i < data[0].perfEng.length; i++) {
                    config_isEng ? selectizeEng.createItem(data[0].perfEng[i]) : null;
                }
                config_isEng ? $('#desc-f-eng').html(data[0].descFEng) : null;
                //des
                config_isDes ? $('#chk-des').bootstrapToggle(data[0].chkDes ? 'on' : 'off') : null;
                config_isDes ? $('#pct-des').html(data[0].pctDes) : null;
                config_isDes ? (Number(data[0].isProdutividadeLinguagem) === 1 ? $("#prod-des").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)) : $('#prod-des').val(data[0].prodDes)) : null;
                config_isDes ? $('#prof-des').val(data[0].profDes) : null;
                for (i = 0; i < data[0].perfDes.length; i++) {
                    config_isDes ? selectizeDes.createItem(data[0].perfDes[i]) : null;
                }
                config_isDes ? $('#desc-f-des').html(data[0].descFDes) : null;
                //imp
                config_isImp ? $('#chk-imp').bootstrapToggle(data[0].chkImp ? 'on' : 'off') : null;
                config_isImp ? $('#pct-imp').html(data[0].pctImp) : null;
                config_isImp ? (Number(data[0].isProdutividadeLinguagem) === 1 ? $("#prod-imp").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)) : $('#prod-imp').val(data[0].prodImp)) : null;
                config_isImp ? $('#prof-imp').val(data[0].profImp) : null;
                for (i = 0; i < data[0].perfImp.length; i++) {
                    config_isImp ? selectizeImp.createItem(data[0].perfImp[i]) : null;
                }
                config_isImp ? $('#desc-f-imp').html(data[0].descFImp) : null;
                //tes
                config_isTes ? $('#chk-tes').bootstrapToggle(data[0].chkTes ? 'on' : 'off') : null;
                config_isTes ? $('#pct-tes').html(data[0].pctTes) : null;
                config_isTes ? (Number(data[0].isProdutividadeLinguagem) === 1 ? $("#prod-tes").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)) : $('#prod-tes').val(data[0].prodTes)) : null;
                config_isTes ? $('#prof-tes').val(data[0].profTes) : null;
                for (i = 0; i < data[0].perfTes.length; i++) {
                    config_isTes ? selectizeTes.createItem(data[0].perfTes[i]) : null;
                }
                config_isTes ? $('#desc-f-tes').html(data[0].descFTes) : null;
                //hom
                config_isHom ? $('#chk-hom').bootstrapToggle(data[0].chkHom ? 'on' : 'off') : null;
                config_isHom ? $('#pct-hom').html(data[0].pctHom) : null;
                config_isHom ? (Number(data[0].isProdutividadeLinguagem) === 1 ? $("#prod-hom").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)) : $('#prod-hom').val(data[0].prodHom)) : null;
                config_isHom ? $('#prof-hom').val(data[0].profHom) : null;
                for (i = 0; i < data[0].perfHom.length; i++) {
                    config_isHom ? selectizeHom.createItem(data[0].perfHom[i]) : null;
                }
                isHom ? $('#desc-f-hom').html(data[0].descFHom) : null;
                //impl
                config_isImpl ? $('#chk-impl').bootstrapToggle(data[0].chkImpl ? 'on' : 'off') : null;
                config_isImpl ? $('#pct-impl').html(data[0].pctImpl) : null;
                config_isImpl ? (Number(data[0].isProdutividadeLinguagem) === 1 ? $("#prod-impl").val(parseFloat($('#produtividade-' + data[0].escalaProdutividade).val()).toFixed(2)) : $('#prod-impl').val(data[0].prodImpl)) : null;
                config_isImpl ? $('#prof-impl').val(data[0].profImpl) : null;
                for (i = 0; i < data[0].perfImpl.length; i++) {
                    config_isImpl ? selectizeImpl.createItem(data[0].perfImpl[i]) : null;
                }
                config_isImpl ? $('#desc-f-impl').html(data[0].descFImpl) : null;
                //expoente
                $("input[name=expoente]").val([data[0].expoente]);
                //prazos
                $('#calculado').html(data[0].calculado);
                $('#tempo-desenvolvimento').html(data[0].tempoDesenvolvimento);
                $('#regiao-impossivel').html(data[0].regiaoImpossivel);
                $('#menor-custo').html(data[0].menorCusto);
                //calculos iniciais
                $('#hpc').val(data[0].hpc);
                $('#hpa').val(data[0].hpa);
                $('#valor-hpc').val(data[0].valorHpc);
                $('#valor-hpa').val(data[0].valorHpa);
                $('#custo-total').html(data[0].custoTotal);
                $('#valor-pfa-contrato').val(data[0].valorPfaContrato);
                //verifica se a solicitacao eh critica pelo tipo de projeto
                if (Number(data[0].tipoProjeto) === 5) {
                    $('#chk-solicitacao-servico-critica').bootstrapToggle('on');
                }
                else {
                    $('#chk-solicitacao-servico-critica').bootstrapToggle('off');
                }
                switch (Number(data[0].tipoProjeto)) {
                    case 1:
                        config_aumentoEsforco = parseFloat(1).toFixed(2);
                        config_fatorReducaoCronograma = parseFloat(1).toFixed(2);
                        $('#span-tipo-projeto').html('Projeto Padr&atilde;o => 1,00');
                        break;
                    case 2:
                        config_aumentoEsforco = parseFloat(1.2).toFixed(2);
                        config_fatorReducaoCronograma = parseFloat(0.9).toFixed(2);
                        $('#span-tipo-projeto').html('Projeto Urgente => 1,20');
                        break;
                    case 3:
                        config_aumentoEsforco = parseFloat(1.5).toFixed(2);
                        config_fatorReducaoCronograma = parseFloat(0.8).toFixed(2);
                        $('#span-tipo-projeto').html('Projeto Cr&iacute;tico => 1,50');
                        break;
                    case 4:
                        config_aumentoEsforco = parseFloat(1.7).toFixed(2);
                        config_fatorReducaoCronograma = parseFloat(0.75).toFixed(2);
                        $('#span-tipo-projeto').html('Projeto Alta Criticidade => 1,70');
                        break;
                    case 5:
                        config_aumentoEsforco = parseFloat(1.35).toFixed(2);
                        config_fatorReducaoCronograma = parseFloat(0.85).toFixed(2);
                        $('#span-tipo-projeto').html('Solicita&ccedil;&atilde;o de Servi&ccedil;o Cr&iacute;tica => 1,35');
                        break;
                }
                $('#tipo-projeto').val(data[0].tipoProjeto);
                $('#esforco-total').html(data[0].esforcoTotal);
                //escreve nos spans tamanho-pfa e produtividade-media
                $('#tamanho-pfa').html(parseFloat(data[0].tamanhoPfa).toFixed(2));
                //pega a produtividade media ou a linguagem/produtividade global
                $('#span-produtividade-media').html(data[0].spanProdutividadeMedia);
                //cocomo II.2000
                $('#COCOMO-A').val(Number(data[0].COCOMO_A).toFixed(2));
                $('#COCOMO-B').val(Number(data[0].COCOMO_B).toFixed(2));
                $('#COCOMO-C').val(Number(data[0].COCOMO_C).toFixed(2));
                $('#COCOMO-D').val(Number(data[0].COCOMO_D).toFixed(2));
                $('#' + data[0].ED_PERS).prop('checked', true); //'ED-PERS-NO',
                $('#' + data[0].ED_RCPX).prop('checked', true); //'ED-RCPX-NO',
                $('#' + data[0].ED_PDIF).prop('checked', true); //'ED-PDIF-NO',
                $('#' + data[0].ED_PREX).prop('checked', true); //'ED-PREX-NO',
                $('#' + data[0].ED_FCIL).prop('checked', true); //'ED-FCIL-NO',
                $('#' + data[0].ED_RUSE).prop('checked', true); //'ED-RUSE-NO',
                $('#' + data[0].ED_SCED).prop('checked', true); //'ED-SCED-NO',
                $('#' + data[0].PREC).prop('checked', true); //'PREC-NO',
                $('#' + data[0].FLEX).prop('checked', true); //'FLEX-NO',
                $('#' + data[0].RESL).prop('checked', true); //'RESL-NO',
                $('#' + data[0].TEAM).prop('checked', true); //'TEAM-NO',
                $('#' + data[0].PMAT).prop('checked', true); //'PMAT-NO',
                $('#' + data[0].RELY).prop('checked', true); //'RELY-NO',
                $('#' + data[0].DATA).prop('checked', true); //'DATA-NO',
                $('#' + data[0].CPLX_CN).prop('checked', true); //'CPLX-CN-NO',
                $('#' + data[0].CPLX_CO).prop('checked', true); //'CPLX-CO-NO',
                $('#' + data[0].CPLX_DO).prop('checked', true); //'CPLX-DO-NO',
                $('#' + data[0].CPLX_DM).prop('checked', true); //'CPLX-DM-NO',
                $('#' + data[0].CPLX_UI).prop('checked', true); //'CPLX-UI-NO',
                $('#' + data[0].RUSE).prop('checked', true); //'RUSE-NO',
                $('#' + data[0].DOCU).prop('checked', true); //'DOCU-NO',
                $('#' + data[0].TIME).prop('checked', true); //'TIME-NO',
                $('#' + data[0].STOR).prop('checked', true); //'STOR-NO',
                $('#' + data[0].PVOL).prop('checked', true); //'PVOL-NO',
                $('#' + data[0].ACAP).prop('checked', true); //'ACAP-NO',
                $('#' + data[0].PCAP).prop('checked', true); //'PCAP-NO',
                $('#' + data[0].PCON).prop('checked', true); //'PCON-NO',
                $('#' + data[0].APEX).prop('checked', true); //'APEX-NO',
                $('#' + data[0].PLEX).prop('checked', true); //'PLEX-NO',
                $('#' + data[0].LTEX).prop('checked', true); //'LTEX-NO',
                $('#' + data[0].TOOL).prop('checked', true); //'TOOL-NO',
                $('#' + data[0].SITE).prop('checked', true); //'SITE-NO',
                $('#' + data[0].SCED).prop('checked', true); //'SCED-NO',
                //fatores de escala
                $('#PREC-VL').val(Number(data[0].PREC_VL).toFixed(2)); //'6.2',
                $('#PREC-LO').val(Number(data[0].PREC_LO).toFixed(2)); //'4.96',
                $('#PREC-NO').val(Number(data[0].PREC_NO).toFixed(2)); //'3.72',
                $('#PREC-HI').val(Number(data[0].PREC_HI).toFixed(2)); //'2.48',
                $('#PREC-VH').val(Number(data[0].PREC_VH).toFixed(2)); //'1.24',
                $('#PREC-EH').val(Number(data[0].PREC_EH).toFixed(2)); //'0',
                $('#FLEX-VL').val(Number(data[0].FLEX_VL).toFixed(2)); //'5.07',
                $('#FLEX-LO').val(Number(data[0].FLEX_LO).toFixed(2)); //'4.05',
                $('#FLEX-NO').val(Number(data[0].FLEX_NO).toFixed(2)); //'3.04',
                $('#FLEX-HI').val(Number(data[0].FLEX_HI).toFixed(2)); //'2.03',
                $('#FLEX-VH').val(Number(data[0].FLEX_VH).toFixed(2)); //'1.01',
                $('#FLEX-EH').val(Number(data[0].FLEX_EH).toFixed(2)); //'0',
                $('#RESL-VL').val(Number(data[0].RESL_VL).toFixed(2)); //'7.07',
                $('#RESL-LO').val(Number(data[0].RESL_LO).toFixed(2)); //'5.65',
                $('#RESL-NO').val(Number(data[0].RESL_NO).toFixed(2)); //'4.24',
                $('#RESL-HI').val(Number(data[0].RESL_HI).toFixed(2)); //'2.83',
                $('#RESL-VH').val(Number(data[0].RESL_VH).toFixed(2)); //'1.41',
                $('#RESL-EH').val(Number(data[0].RESL_EH).toFixed(2)); //'0',
                $('#TEAM-VL').val(Number(data[0].TEAM_VL).toFixed(2)); //'5.48',
                $('#TEAM-LO').val(Number(data[0].TEAM_LO).toFixed(2)); //'4.38',
                $('#TEAM-NO').val(Number(data[0].TEAM_NO).toFixed(2)); //'3.29',
                $('#TEAM-HI').val(Number(data[0].TEAM_HI).toFixed(2)); //'2.19',
                $('#TEAM-VH').val(Number(data[0].TEAM_VH).toFixed(2)); //'1.1',
                $('#TEAM-EH').val(Number(data[0].TEAM_EH).toFixed(2)); //'0',
                $('#PMAT-VL').val(Number(data[0].PMAT_VL).toFixed(2)); //'7.8',
                $('#PMAT-LO').val(Number(data[0].PMAT_LO).toFixed(2)); //'6.24',
                $('#PMAT-NO').val(Number(data[0].PMAT_NO).toFixed(2)); //'4.68',
                $('#PMAT-HI').val(Number(data[0].PMAT_HI).toFixed(2)); //'3.12',
                $('#PMAT-VH').val(Number(data[0].PMAT_VH).toFixed(2)); //'1.56',
                $('#PMAT-EH').val(Number(data[0].PMAT_EH).toFixed(2)); //'0',
                //post-achitecture
                $('#CPLX-CN-VL').val(Number(data[0].CPLX_CN_VL).toFixed(2)); //'0.73',
                $('#CPLX-CN-LO').val(Number(data[0].CPLX_CN_LO).toFixed(2)); //'0.87',
                $('#CPLX-CN-NO').val(Number(data[0].CPLX_CN_NO).toFixed(2)); //'1',
                $('#CPLX-CN-HI').val(Number(data[0].CPLX_CN_HI).toFixed(2)); //'1.17',
                $('#CPLX-CN-VH').val(Number(data[0].CPLX_CN_VH).toFixed(2)); //'1.34',
                $('#CPLX-CN-EH').val(Number(data[0].CPLX_CN_EH).toFixed(2)); //'1.74',
                $('#CPLX-CO-VL').val(Number(data[0].CPLX_CO_VL).toFixed(2)); //'0.73',
                $('#CPLX-CO-LO').val(Number(data[0].CPLX_CO_LO).toFixed(2)); //'0.87',
                $('#CPLX-CO-NO').val(Number(data[0].CPLX_CO_NO).toFixed(2)); //'1',
                $('#CPLX-CO-HI').val(Number(data[0].CPLX_CO_HI).toFixed(2)); //'1.17',
                $('#CPLX-CO-VH').val(Number(data[0].CPLX_CO_VH).toFixed(2)); //'1.34',
                $('#CPLX-CO-EH').val(Number(data[0].CPLX_CO_EH).toFixed(2)); //'1.74',
                $('#CPLX-DO-VL').val(Number(data[0].CPLX_DO_VL).toFixed(2)); //'0.73',
                $('#CPLX-DO-LO').val(Number(data[0].CPLX_DO_LO).toFixed(2)); //'0.87',
                $('#CPLX-DO-NO').val(Number(data[0].CPLX_DO_NO).toFixed(2)); //'1',
                $('#CPLX-DO-HI').val(Number(data[0].CPLX_DO_HI).toFixed(2)); //'1.17',
                $('#CPLX-DO-VH').val(Number(data[0].CPLX_DO_VH).toFixed(2)); //'1.34',
                $('#CPLX-DO-EH').val(Number(data[0].CPLX_DO_EH).toFixed(2)); //'1.74',
                $('#CPLX-DM-VL').val(Number(data[0].CPLX_DM_VL).toFixed(2)); //'0.73',
                $('#CPLX-DM-LO').val(Number(data[0].CPLX_DM_LO).toFixed(2)); //'0.87',
                $('#CPLX-DM-NO').val(Number(data[0].CPLX_DM_NO).toFixed(2)); //'1',
                $('#CPLX-DM-HI').val(Number(data[0].CPLX_DM_HI).toFixed(2)); //'1.17',
                $('#CPLX-DM-VH').val(Number(data[0].CPLX_DM_VH).toFixed(2)); //'1.34',
                $('#CPLX-DM-EH').val(Number(data[0].CPLX_DM_EH).toFixed(2)); //'1.74',
                $('#CPLX-UI-VL').val(Number(data[0].CPLX_UI_VL).toFixed(2)); //'0.73',
                $('#CPLX-UI-LO').val(Number(data[0].CPLX_UI_LO).toFixed(2)); //'0.87',
                $('#CPLX-UI-NO').val(Number(data[0].CPLX_UI_NO).toFixed(2)); //'1',
                $('#CPLX-UI-HI').val(Number(data[0].CPLX_UI_HI).toFixed(2)); //'1.17',
                $('#CPLX-UI-VH').val(Number(data[0].CPLX_UI_VH).toFixed(2)); //'1.34',
                $('#CPLX-UI-EH').val(Number(data[0].CPLX_UI_EH).toFixed(2)); //'1.74',
                $('#RELY-VL').val(Number(data[0].RELY_VL).toFixed(2)); //'0.82',
                $('#RELY-LO').val(Number(data[0].RELY_LO).toFixed(2)); //'0.92',
                $('#RELY-NO').val(Number(data[0].RELY_NO).toFixed(2)); //'1',
                $('#RELY-HI').val(Number(data[0].RELY_HI).toFixed(2)); //'1.1',
                $('#RELY-VH').val(Number(data[0].RELY_VH).toFixed(2)); //'1.26',
                $('#DATA-LO').val(Number(data[0].DATA_LO).toFixed(2)); //'0.9',
                $('#DATA-NO').val(Number(data[0].DATA_NO).toFixed(2)); //'1',
                $('#DATA-HI').val(Number(data[0].DATA_HI).toFixed(2)); //'1.14',
                $('#DATA-VH').val(Number(data[0].DATA_VH).toFixed(2)); //'1.28',                
                $('#RUSE-LO').val(Number(data[0].RUSE_LO).toFixed(2)); //'0.95',
                $('#RUSE-NO').val(Number(data[0].RUSE_NO).toFixed(2)); //'1',
                $('#RUSE-HI').val(Number(data[0].RUSE_HI).toFixed(2)); //'1.07',
                $('#RUSE-VH').val(Number(data[0].RUSE_VH).toFixed(2)); //'1.15',
                $('#RUSE-EH').val(Number(data[0].RUSE_EH).toFixed(2)); //'1.24',
                $('#DOCU-VL').val(Number(data[0].DOCU_VL).toFixed(2)); //'0.81',
                $('#DOCU-LO').val(Number(data[0].DOCU_LO).toFixed(2)); //'0.91',
                $('#DOCU-NO').val(Number(data[0].DOCU_NO).toFixed(2)); //'1',
                $('#DOCU-HI').val(Number(data[0].DOCU_HI).toFixed(2)); //'1.11',
                $('#DOCU-VH').val(Number(data[0].DOCU_VH).toFixed(2)); //'1.23',
                $('#TIME-NO').val(Number(data[0].TIME_NO).toFixed(2)); //'1',
                $('#TIME-HI').val(Number(data[0].TIME_HI).toFixed(2)); //'1.11',
                $('#TIME-VH').val(Number(data[0].TIME_VH).toFixed(2)); //'1.29',
                $('#TIME-EH').val(Number(data[0].TIME_EH).toFixed(2)); //'1.63',
                $('#STOR-NO').val(Number(data[0].STOR_NO).toFixed(2)); //'1',
                $('#STOR-HI').val(Number(data[0].STOR_HI).toFixed(2)); //'1.05',
                $('#STOR-VH').val(Number(data[0].STOR_VH).toFixed(2)); //'1.17',
                $('#STOR-EH').val(Number(data[0].STOR_EH).toFixed(2)); //'1.46',
                $('#PVOL-LO').val(Number(data[0].PVOL_LO).toFixed(2)); //'0.87',
                $('#PVOL-NO').val(Number(data[0].PVOL_NO).toFixed(2)); //'1',
                $('#PVOL-HI').val(Number(data[0].PVOL_HI).toFixed(2)); //'1.15',
                $('#PVOL-VH').val(Number(data[0].PVOL_VH).toFixed(2)); //'1.3',
                $('#ACAP-VL').val(Number(data[0].ACAP_VL).toFixed(2)); //'1.42',
                $('#ACAP-LO').val(Number(data[0].ACAP_LO).toFixed(2)); //'1.19',
                $('#ACAP-NO').val(Number(data[0].ACAP_NO).toFixed(2)); //'1',
                $('#ACAP-HI').val(Number(data[0].ACAP_HI).toFixed(2)); //'0.85',
                $('#ACAP-VH').val(Number(data[0].ACAP_VH).toFixed(2)); //'0.71',
                $('#PCAP-VL').val(Number(data[0].PCAP_VL).toFixed(2)); //'1.34',
                $('#PCAP-LO').val(Number(data[0].PCAP_LO).toFixed(2)); //'1.15',
                $('#PCAP-NO').val(Number(data[0].PCAP_NO).toFixed(2)); //'1',
                $('#PCAP-HI').val(Number(data[0].PCAP_HI).toFixed(2)); //'0.88',
                $('#PCAP-VH').val(Number(data[0].PCAP_VH).toFixed(2)); //'0.76',
                $('#PCON-VL').val(Number(data[0].PCON_VL).toFixed(2)); //'1.29',
                $('#PCON-LO').val(Number(data[0].PCON_LO).toFixed(2)); //'1.12',
                $('#PCON-NO').val(Number(data[0].PCON_NO).toFixed(2)); //'1',
                $('#PCON-HI').val(Number(data[0].PCON_HI).toFixed(2)); //'0.9',
                $('#PCON-VH').val(Number(data[0].PCON_VH).toFixed(2)); //'0.81',
                $('#APEX-VL').val(Number(data[0].APEX_VL).toFixed(2)); //'1.22',
                $('#APEX-LO').val(Number(data[0].APEX_LO).toFixed(2)); //'1.1',
                $('#APEX-NO').val(Number(data[0].APEX_NO).toFixed(2)); //'1',
                $('#APEX-HI').val(Number(data[0].APEX_HI).toFixed(2)); //'0.88',
                $('#APEX-VH').val(Number(data[0].APEX_VH).toFixed(2)); //'0.81',
                $('#PLEX-VL').val(Number(data[0].PLEX_VL).toFixed(2)); //'1.19',
                $('#PLEX-LO').val(Number(data[0].PLEX_LO).toFixed(2)); //'1.09',
                $('#PLEX-NO').val(Number(data[0].PLEX_NO).toFixed(2)); //'1',
                $('#PLEX-HI').val(Number(data[0].PLEX_HI).toFixed(2)); //'0.91',
                $('#PLEX-VH').val(Number(data[0].PLEX_VH).toFixed(2)); //'0.85',
                $('#LTEX-VL').val(Number(data[0].LTEX_VL).toFixed(2)); //'1.2',
                $('#LTEX-LO').val(Number(data[0].LTEX_LO).toFixed(2)); //'1.09',
                $('#LTEX-NO').val(Number(data[0].LTEX_NO).toFixed(2)); //'1',
                $('#LTEX-HI').val(Number(data[0].LTEX_HI).toFixed(2)); //'0.91',
                $('#LTEX-VH').val(Number(data[0].LTEX_VH).toFixed(2)); //'0.84',
                $('#TOOL-VL').val(Number(data[0].TOOL_VL).toFixed(2)); //'1.17',
                $('#TOOL-LO').val(Number(data[0].TOOL_LO).toFixed(2)); //'1.09',
                $('#TOOL-NO').val(Number(data[0].TOOL_NO).toFixed(2)); //'1',
                $('#TOOL-HI').val(Number(data[0].TOOL_HI).toFixed(2)); //'0.9',
                $('#TOOL-VH').val(Number(data[0].TOOL_VH).toFixed(2)); //'0.78',
                $('#SITE-VL').val(Number(data[0].SITE_VL).toFixed(2)); //'1.22',
                $('#SITE-LO').val(Number(data[0].SITE_LO).toFixed(2)); //'1.09',
                $('#SITE-NO').val(Number(data[0].SITE_NO).toFixed(2)); //'1',
                $('#SITE-HI').val(Number(data[0].SITE_HI).toFixed(2)); //'0.93',
                $('#SITE-VH').val(Number(data[0].SITE_VH).toFixed(2)); //'0.86',
                $('#SITE-EH').val(Number(data[0].SITE_EH).toFixed(2)); //'0.8',
                $('#SCED-VL').val(Number(data[0].SCED_VL).toFixed(2)); //'1.43',
                $('#SCED-LO').val(Number(data[0].SCED_LO).toFixed(2)); //'1.14',
                $('#SCED-NO').val(Number(data[0].SCED_NO).toFixed(2)); //'1',
                $('#SCED-HI').val(Number(data[0].SCED_HI).toFixed(2)); //'1',
                $('#SCED-VH').val(Number(data[0].SCED_VH).toFixed(2)); //'1',
                //early-design
                $('#ED-PERS-XL').val(Number(data[0].ED_PERS_XL).toFixed(2)); //'2.12',
                $('#ED-PERS-VL').val(Number(data[0].ED_PERS_VL).toFixed(2)); //'1.62',
                $('#ED-PERS-LO').val(Number(data[0].ED_PERS_LO).toFixed(2)); //'1.26',
                $('#ED-PERS-NO').val(Number(data[0].ED_PERS_NO).toFixed(2)); //'1',
                $('#ED-PERS-HI').val(Number(data[0].ED_PERS_HI).toFixed(2)); //'0.83',
                $('#ED-PERS-VH').val(Number(data[0].ED_PERS_VH).toFixed(2)); //'0.63',
                $('#ED-PERS-EH').val(Number(data[0].ED_PERS_EH).toFixed(2)); //'0.5',
                $('#ED-RCPX-XL').val(Number(data[0].ED_RCPX_XL).toFixed(2)); //'0.49',
                $('#ED-RCPX-VL').val(Number(data[0].ED_RCPX_VL).toFixed(2)); //'0.6',
                $('#ED-RCPX-LO').val(Number(data[0].ED_RCPX_LO).toFixed(2)); //'0.83',
                $('#ED-RCPX-NO').val(Number(data[0].ED_RCPX_NO).toFixed(2)); //'1',
                $('#ED-RCPX-HI').val(Number(data[0].ED_RCPX_HI).toFixed(2)); //'1.33',
                $('#ED-RCPX-VH').val(Number(data[0].ED_RCPX_VH).toFixed(2)); //'1.91',
                $('#ED-RCPX-EH').val(Number(data[0].ED_RCPX_EH).toFixed(2)); //'2.72',
                $('#ED-PDIF-LO').val(Number(data[0].ED_PDIF_LO).toFixed(2)); //'0.87',
                $('#ED-PDIF-NO').val(Number(data[0].ED_PDIF_NO).toFixed(2)); //'1',
                $('#ED-PDIF-HI').val(Number(data[0].ED_PDIF_HI).toFixed(2)); //'1.29',
                $('#ED-PDIF-VH').val(Number(data[0].ED_PDIF_VH).toFixed(2)); //'1.81',
                $('#ED-PDIF-EH').val(Number(data[0].ED_PDIF_EH).toFixed(2)); //'2.61',
                $('#ED-PREX-XL').val(Number(data[0].ED_PREX_XL).toFixed(2)); //'1.59',
                $('#ED-PREX-VL').val(Number(data[0].ED_PREX_VL).toFixed(2)); //'1.33',
                $('#ED-PREX-LO').val(Number(data[0].ED_PREX_LO).toFixed(2)); //'1.12',
                $('#ED-PREX-NO').val(Number(data[0].ED_PREX_NO).toFixed(2)); //'1',
                $('#ED-PREX-HI').val(Number(data[0].ED_PREX_HI).toFixed(2)); //'0.87',
                $('#ED-PREX-VH').val(Number(data[0].ED_PREX_VH).toFixed(2)); //'0.74',
                $('#ED-PREX-EH').val(Number(data[0].ED_PREX_EH).toFixed(2)); //'0.62',
                $('#ED-FCIL-XL').val(Number(data[0].ED_FCIL_XL).toFixed(2)); //'1.43',
                $('#ED-FCIL-VL').val(Number(data[0].ED_FCIL_VL).toFixed(2)); //'1.3',
                $('#ED-FCIL-LO').val(Number(data[0].ED_FCIL_LO).toFixed(2)); //'1.1',
                $('#ED-FCIL-NO').val(Number(data[0].ED_FCIL_NO).toFixed(2)); //'1',
                $('#ED-FCIL-HI').val(Number(data[0].ED_FCIL_HI).toFixed(2)); //'0.87',
                $('#ED-FCIL-VH').val(Number(data[0].ED_FCIL_VH).toFixed(2)); //'0.73',
                $('#ED-FCIL-EH').val(Number(data[0].ED_FCIL_EH).toFixed(2)); //'0.62',
                $('#ED-RUSE-LO').val(Number(data[0].ED_RUSE_LO).toFixed(2)); //'0.95',
                $('#ED-RUSE-NO').val(Number(data[0].ED_RUSE_NO).toFixed(2)); //'1',
                $('#ED-RUSE-HI').val(Number(data[0].ED_RUSE_HI).toFixed(2)); //'1.07',
                $('#ED-RUSE-VH').val(Number(data[0].ED_RUSE_VH).toFixed(2)); //'1.15',
                $('#ED-RUSE-EH').val(Number(data[0].ED_RUSE_EH).toFixed(2)); //'1.24',
                $('#ED-SCED-VL').val(Number(data[0].ED_SCED_VL).toFixed(2)); //'1.43',
                $('#ED-SCED-LO').val(Number(data[0].ED_SCED_LO).toFixed(2)); //'1.14',
                $('#ED-SCED-NO').val(Number(data[0].ED_SCED_NO).toFixed(2)); //'1',
                $('#ED-SCED-HI').val(Number(data[0].ED_SCED_HI).toFixed(2)); //'1',
                $('#ED-SCED-VH').val(Number(data[0].ED_SCED_VH).toFixed(2)); //'1',
                $('#coc-esforco').html(Number(data[0].coc_esforco).toFixed(3)); //'0',
                $('#coc-cronograma').html(Number(data[0].coc_cronograma).toFixed(3)); //'0',
                $('#coc-custo').html(Number(data[0].coc_custo).toFixed(3)); //'0',
                $('#coc-custo-pessoa').html(Number(data[0].coc_custo_pessoa).toFixed(2));//'0'
                $('#coc-sloc').html(Number(data[0].coc_sloc).toFixed(3)); //'0',
                $('#tipo-calculo').bootstrapToggle(Number(data[0].coc_tipo_calculo) == 1 ? 'on' : 'off'); //'0',
                $('#inc-ef').html(Number(0).toFixed(3)); //'0',
                $('#inc-sc').html(Number(0).toFixed(3)); //'0',
                $('#inc-av').html(Number(0).toFixed(3)); //'0',
                $('#inc-co').html(Number(0).toFixed(3)); //'0',
                $('#ela-ef').html(Number(0).toFixed(3)); //'0',
                $('#ela-sc').html(Number(0).toFixed(3)); //'0',
                $('#ela-av').html(Number(0).toFixed(3)); //'0',
                $('#ela-co').html(Number(0).toFixed(3)); //'0',
                $('#con-ef').html(Number(0).toFixed(3)); //'0',
                $('#con-sc').html(Number(0).toFixed(3)); //'0',
                $('#con-av').html(Number(0).toFixed(3)); //'0',
                $('#con-co').html(Number(0).toFixed(3)); //'0',
                $('#tra-ef').html(Number(0).toFixed(3)); //'0',
                $('#tra-sc').html(Number(0).toFixed(3)); //'0',
                $('#tra-av').html(Number(0).toFixed(3)); //'0',
                $('#tra-co').html(Number(0).toFixed(3)); //'0',
                $('#man-inc').html(Number(0).toFixed(3)); //'0',
                $('#man-ela').html(Number(0).toFixed(3)); //'0',
                $('#man-con').html(Number(0).toFixed(3)); //'0',
                $('#man-tra').html(Number(0).toFixed(3)); //'0',
                $('#env-inc').html(Number(0).toFixed(3)); //'0',
                $('#env-ela').html(Number(0).toFixed(3)); //'0',
                $('#env-con').html(Number(0).toFixed(3)); //'0',
                $('#env-tra').html(Number(0).toFixed(3)); //'0',
                $('#req-inc').html(Number(0).toFixed(3)); //'0',
                $('#req-ela').html(Number(0).toFixed(3)); //'0',
                $('#req-con').html(Number(0).toFixed(3)); //'0',
                $('#req-tra').html(Number(0).toFixed(3)); //'0',
                $('#des-inc').html(Number(0).toFixed(3)); //'0',
                $('#des-ela').html(Number(0).toFixed(3)); //'0',
                $('#des-con').html(Number(0).toFixed(3)); //'0',
                $('#des-tra').html(Number(0).toFixed(3)); //'0',
                $('#imp-inc').html(Number(0).toFixed(3)); //'0',
                $('#imp-ela').html(Number(0).toFixed(3)); //'0',
                $('#imp-con').html(Number(0).toFixed(3)); //'0',
                $('#imp-tra').html(Number(0).toFixed(3)); //'0',
                $('#ass-inc').html(Number(0).toFixed(3)); //'0',
                $('#ass-ela').html(Number(0).toFixed(3)); //'0',
                $('#ass-con').html(Number(0).toFixed(3)); //'0',
                $('#ass-tra').html(Number(0).toFixed(3)); //'0',
                $('#dep-inc').html(Number(0).toFixed(3)); //'0',
                $('#dep-ela').html(Number(0).toFixed(3)); //'0',
                $('#dep-con').html(Number(0).toFixed(3)); //'0',
                $('#dep-tra').html(Number(0).toFixed(3)); //'0',  
                /*
                 * aproveita o json e faz as outras chamadas
                 */
                //ALI
                iWait("w_ali", true);
                $.post('/pf/DIM.Gateway.php', {'i': idContagem, 't': 'ali', 'f': 'qnqbf'.dScr(), 'o': 'id', 'tpo': 'ASC', 'arq': 34, 'tch': 1, 'sub': -1, 'dlg': 1}, function (dataALI) {
                    tblALI = $("#addALI")[0];
                    for (i = 0; i < dataALI.length; i++) {
                        var rowALI = tblALI.insertRow(-1);
                        var pfa = Number(dataALI[i].pfa);
                        var pfb = Number(dataALI[i].pfb);
                        insereLinha(
                                dataALI[i].id,
                                'ALI',
                                rowALI,
                                dataALI[i].operacao,
                                dataALI[i].funcao,
                                dataALI[i].td,
                                dataALI[i].tr,
                                dataALI[i].complexidade,
                                pfb.toFixed(4),
                                dataALI[i].siglaFator,
                                pfa.toFixed(4),
                                dataALI[i].obsFuncao,
                                dataALI[i].situacao,
                                dataALI[i].entrega,
                                dataALI[i].lido,
                                dataALI[i].nLido,
                                false, //nao redesenha os graficos
                                dataALI[i].isMudanca,
                                dataALI[i].faseMudanca,
                                dataALI[i].percentualFase,
                                dataALI[i].fd,
                                dataALI[i].isCrud,
                                0,
                                dataALI[i].fe);
                    }
                    iWait("w_ali", false);
                }, "json");
                // AIE
                iWait("w_aie", true);
                $.post('/pf/DIM.Gateway.php', {'i': idContagem, 't': 'aie', 'f': 'qnqbf'.dScr(), 'o': 'id', 'tpo': 'ASC', 'arq': 34, 'tch': 1, 'sub': -1, 'dlg': 1}, function (dataAIE) {
                    tblAIE = $("#addAIE")[0];
                    for (i = 0; i < dataAIE.length; i++) {
                        var rowAIE = tblAIE.insertRow(-1);
                        var pfa = Number(dataAIE[i].pfa);
                        var pfb = Number(dataAIE[i].pfb);
                        insereLinha(
                                dataAIE[i].id,
                                'AIE',
                                rowAIE,
                                dataAIE[i].operacao,
                                dataAIE[i].funcao,
                                dataAIE[i].td,
                                dataAIE[i].tr,
                                dataAIE[i].complexidade,
                                pfb.toFixed(4),
                                dataAIE[i].siglaFator,
                                pfa.toFixed(4),
                                dataAIE[i].obsFuncao,
                                dataAIE[i].situacao,
                                dataAIE[i].entrega,
                                dataAIE[i].lido,
                                dataAIE[i].nLido,
                                false, //nao redesenha os graficos
                                dataAIE[i].isMudanca,
                                dataAIE[i].faseMudanca,
                                dataAIE[i].percentualFase,
                                dataAIE[i].fd,
                                0,
                                0,
                                0);//formulario estendido
                    }
                    iWait("w_aie", false);
                }, "json");
                // EE
                iWait("w_ee", true);
                $.post('/pf/DIM.Gateway.php', {'i': idContagem, 't': 'ee', 'f': 'genafnpnb'.dScr(), 'o': 'id', 'tpo': 'ASC', 'arq': 34, 'tch': 1, 'sub': -1, 'dlg': 1}, function (dataEE) {
                    tblEE = $("#addEE")[0];
                    for (i = 0; i < dataEE.length; i++) {
                        var rowEE = tblEE.insertRow(-1);
                        var pfa = Number(dataEE[i].pfa);
                        var pfb = Number(dataEE[i].pfb);
                        insereLinha(
                                dataEE[i].id,
                                'EE',
                                rowEE,
                                dataEE[i].operacao,
                                dataEE[i].funcao,
                                dataEE[i].td,
                                dataEE[i].ar,
                                dataEE[i].complexidade,
                                pfb.toFixed(4),
                                dataEE[i].siglaFator,
                                pfa.toFixed(4),
                                dataEE[i].obsFuncao,
                                dataEE[i].situacao,
                                dataEE[i].entrega,
                                dataEE[i].lido,
                                dataEE[i].nLido,
                                false, //nao redesenha os graficos
                                dataEE[i].isMudanca,
                                dataEE[i].faseMudanca,
                                dataEE[i].percentualFase,
                                dataEE[i].fd,
                                dataEE[i].isCrud,
                                0,
                                0);
                    }
                    iWait("w_ee", false);
                }, "json");
                //SE
                iWait("w_se", true);
                $.post('/pf/DIM.Gateway.php', {'i': idContagem, 't': 'se', 'f': 'genafnpnb'.dScr(), 'o': 'id', 'tpo': 'ASC', 'arq': 34, 'tch': 1, 'sub': -1, 'dlg': 1}, function (dataSE) {
                    tblSE = $("#addSE")[0];
                    for (i = 0; i < dataSE.length; i++) {
                        var rowSE = tblSE.insertRow(-1);
                        var pfa = Number(dataSE[i].pfa);
                        var pfb = Number(dataSE[i].pfb);
                        insereLinha(
                                dataSE[i].id,
                                'SE',
                                rowSE,
                                dataSE[i].operacao,
                                dataSE[i].funcao,
                                dataSE[i].td,
                                dataSE[i].ar,
                                dataSE[i].complexidade,
                                pfb.toFixed(4),
                                dataSE[i].siglaFator,
                                pfa.toFixed(4),
                                dataSE[i].obsFuncao,
                                dataSE[i].situacao,
                                dataSE[i].entrega,
                                dataSE[i].lido,
                                dataSE[i].nLido,
                                false, //nao redesenha os graficos
                                dataSE[i].isMudanca,
                                dataSE[i].faseMudanca,
                                dataSE[i].percentualFase,
                                dataSE[i].fd,
                                0,
                                0,
                                0);
                    }
                    iWait("w_se", false);
                }, "json");
                //CE
                iWait("w_ce", true);
                $.post('/pf/DIM.Gateway.php', {'i': idContagem, 't': 'ce', 'f': 'genafnpnb'.dScr(), 'o': 'id', 'tpo': 'ASC', 'arq': 34, 'tch': 1, 'sub': -1, 'dlg': 1}, function (dataCE) {
                    tblCE = $("#addCE")[0];
                    for (i = 0; i < dataCE.length; i++) {
                        var rowCE = tblCE.insertRow(-1);
                        var pfa = Number(dataCE[i].pfa);
                        var pfb = Number(dataCE[i].pfb);
                        insereLinha(
                                dataCE[i].id,
                                'CE',
                                rowCE,
                                dataCE[i].operacao,
                                dataCE[i].funcao,
                                dataCE[i].td,
                                dataCE[i].ar,
                                dataCE[i].complexidade,
                                pfb.toFixed(4),
                                dataCE[i].siglaFator,
                                pfa.toFixed(4),
                                dataCE[i].obsFuncao,
                                dataCE[i].situacao,
                                dataCE[i].entrega,
                                dataCE[i].lido,
                                dataCE[i].nLido,
                                false, //nao redesenha os graficos
                                dataCE[i].isMudanca,
                                dataCE[i].faseMudanca,
                                dataCE[i].percentualFase,
                                dataCE[i].fd,
                                dataCE[i].isCrud,
                                0,
                                0);
                    }
                    iWait("w_ce", false);
                }, "json");
                //OU
                iWait("w_ou", true);
                $.post('/pf/DIM.Gateway.php', {'i': idContagem, 't': 'ou', 'f': 'outros', 'arq': 34, 'tch': 1, 'sub': -1, 'dlg': 1}, function (dataOU) {
                    tblOU = $("#addOU")[0];
                    for (i = 0; i < dataOU.length; i++) {
                        var rowOU = tblOU.insertRow(-1);
                        var pfaOU = Number(dataOU[i].pfa);
                        insereLinhaOutros(
                                dataOU[i].id,
                                'OU',
                                rowOU,
                                dataOU[i].operacao,
                                dataOU[i].funcao,
                                dataOU[i].qtd,
                                dataOU[i].siglaFator,
                                pfaOU.toFixed(4),
                                dataOU[i].obsFuncao,
                                dataOU[i].situacao,
                                dataOU[i].entrega,
                                dataOU[i].lido,
                                dataOU[i].nLido,
                                false); //nao redesenha os graficos
                    }
                    iWait("w_ou", false);
                }, "json");
            }
            /*
             * agora no final de tudo
             */
            autorizaAlteracaoCampos(data[0].idFornecedor, data[0].tamanhoPfa);
            /*
             * apesar da autorizacao, o Cliente agora fica sempre bloqueado
             */
            $('#contagem_id_cliente').prop('disabled', true);
        }
    }, "json");
    /*
     * escreve o span id contagem para todas
     */
    $('#span_id_contagem').html(("000000" + idContagem).slice(-6));
}
else {
    /*
     * A selecao do cliente ocorre a priori, entao a combo box fica desabilitada por default
     * TODO: verificar uma forma de colocar apenas um texto/tag e inserir o id em hidden
     */
    $('#contagem_id_cliente').prop('disabled', true);
    /*
     * a combo cliente sera sempre populada com um id, para que possa ser inserido tambem em Baseline
     */
    isFornecedor ? comboCliente('contagem', idClienteContagem, '0', idFornecedor) : comboCliente('contagem', idClienteContagem, '0', 0);
    /*
     * verifica as abrangencias
     */
    if (abAtual == 3) {//baseline
        $('#contagem_id_contrato').empty().append('<option value="0">---</option>').prop('disabled', true);
        $('#contagem_id_projeto').empty().append('<option value="0">---</option>').prop('disabled', true);
        $('#id-orgao').empty().append('<option value="0">---</option>').prop('disabled', true);
        $('#contagem_id_baseline').prop('disabled', false);
        comboBaseline(0, '01', $("#contagem_id_baseline"), 0);//idClienteContagem em inc_meta
        getGerenteProjeto(0);
        //preenche como sugestao a OS
        $('#ordem_servico').val('OS-BASELINE');
    }
    else if (abAtual == 4) {//licitacao
        $('#contagem_id_contrato').empty().append('<option value="0">---</option>').prop('disabled', true);
        $('#contagem_id_projeto').empty().append('<option value="0">---</option>').prop('disabled', true);
        $('#contagem_id_baseline').empty().append('<option value="0">---</option>').prop('disabled', true);
        $('#id-orgao').empty().append('<option value="0">---</option>').prop('disabled', true);
        comboBaseline(0, '01', $("#contagem_id_baseline"), 0);
        getGerenteProjeto(0);
        $('#ordem_servico').val('OS-LICITAÇÃO');
    }
    else {
        //verifica se eh uma contagem de auditoria
        if (Number(isContagemAuditoria) == 1) {
            //chama direto pois sera sempre de um fornecedor
            //TODO: verificar na insercao do usuario
            comboContrato(idClienteContagem, '01', 0, 0, 'contagem', 1);
            comboOrgao('01', 0, idClienteContagem, $('#id-orgao'));
        }
        else {
            comboContrato(idClienteContagem, '01', 0, 0, 'contagem', false);
            comboOrgao('01', 0, idClienteContagem, $('#id-orgao'));
        }
        //continua desabilitando a baseline normalmente
        if (abAtual != 2) {//nao eh uma contagem de projeto
            $('#contagem_id_baseline').empty().append('<option value="0">---</option>').prop('disabled', true);
        }
        else {//contagem de projeto
            comboBaseline(0, '01', $("#contagem_id_baseline"), 0);
        }
    }
    //o restante continua normal exceto para snap
    if (abAtual != 5) {
        comboRoteiro('dados', '1', idRoteiro, 0); //para inserir novos itens apenas os ativos
        comboRoteiro('transacao', '1', idRoteiro, 0); //para inserir novos itens apenas os ativos
        comboRoteiro('outros', '1', idRoteiro, 0); //para inserir novos itens apenas os ativos
    }
    comboFatorTecnologia(0, $('#id_fator_tecnologia'), $('#contagem_id_cliente option:selected').val());
    comboLinguagem('01', 0, $('#id_linguagem'), idClienteContagem);
    comboTipoContagem('01', 0, $('#id_tipo_contagem'));
    comboProcesso('01', 0, $('#id_processo'));
    comboEtapa('01', 0, $('#id_etapa'));
    comboIndustria('01', 0, $('#id_industria'));
    comboProcessoGestao('01', 0, $('#id_processo_gestao'));
    comboBancoDados('01', 0, $('#id_banco_dados'), idClienteContagem);
    $('#span_id_contagem').html("------");
    isFornecedor ? $('#privacidade').bootstrapToggle('off').bootstrapToggle('disable') : null;
    isAutorizadoAlterar = true;
}

//verifica as condicoes da valor do id da contagem e habilita a aba estatisticas
$('#li-ane').on('click', function () {
    if ($(this).hasClass('disabled') || $('#span_id_contagem').html() === "------")
        return false;
});
$('#li-est').on('click', function () {
    if ($(this).hasClass('disabled'))
        return false;
});

$('#li-coc').on('click', function () {
    if ($(this).hasClass('disabled')) {
        return false;
    }
    else {
        calculaCocomo();
    }
});
$('#li-fin').on('click', function () {
    if ($(this).hasClass('disabled'))
        return false;
});
//verifica a etapa selecionada
$('#id_etapa').on('change', function () {
    if (qtdAtual > 1) {
        swal({title: "Alerta",
            text: 'Ap&oacute;s inserir funcionalidades n&atilde;o &eacute; poss&iacute;vel alternar para outro m&eacute;todo que n&atilde;o o Indicativo.',
            type: "warning",
            html: true
        });
        $(this).val(idEtapa);
    }
    else if (abAtual != 1 && $(this).val() == 3) {
        swal({title: "Alerta",
            text: 'Apenas contagens livres podem ser associadas ao m&eacute;todo/etapa de contagem Indicativa',
            type: "warning",
            html: true
        });
        $(this).val(idEtapa);
        //TODO: verificar se ja ha funcoes indicativas e desabilitar
        //TODO: nao pode inserir outras funcionalidades na contagem indicativa, exceto INM
    }
    else if ($(this).val() == 3) {
        $('#btn-pesquisar-ali').prop('disabled', true);
        $('#btn-pesquisar-aie').prop('disabled', true);
        $('#btn-pesquisar-ee').prop('disabled', true);
        $('#btn-pesquisar-se').prop('disabled', true);
        $('#btn-pesquisar-ce').prop('disabled', true);
        $('#btn_adicionar_ali').prop('disabled', true);
        $('#btn_adicionar_aie').prop('disabled', true);
        $('#li-ee').addClass('disabled');
        $('#li-se').addClass('disabled');
        $('#li-ce').addClass('disabled');
        $('#li-ou').addClass('disabled');
    }
    else {
        $('#btn-pesquisar-ali').prop('disabled', false);
        $('#btn-pesquisar-aie').prop('disabled', false);
        $('#btn-pesquisar-ee').prop('disabled', false);
        $('#btn-pesquisar-se').prop('disabled', false);
        $('#btn-pesquisar-ce').prop('disabled', false);
        $('#btn_adicionar_ali').prop('disabled', false);
        $('#btn_adicionar_aie').prop('disabled', false);
        $('#li-ee').removeClass('disabled');
        $('#li-se').removeClass('disabled');
        $('#li-ce').removeClass('disabled');
        $('#li-ou').removeClass('disabled');
    }
});
//verifica o id_etapa para habilitar a insercao automatica em contagens do tipo indicativa
$('#li-ali').on('click', function () {
    if ($('#id_etapa').val() == 3 && abAtual == 1 && idContagem > 0) {//apenas para contagens avulsas
        $('.btn-adicionar-indicativa').prop('disabled', false);
    }
});
$('#li-aie').on('click', function () {
    if ($('#id_etapa').val() == 3 && abAtual == 1 && idContagem > 0) {//apenas para contagens avulsas
        $('.btn-adicionar-indicativa').prop('disabled', false);
    }
});
$('.btn-adicionar-indicativa').on('click', function () {
    if ($('#id_etapa').val() == 3 && abAtual == 1 && idContagem > 0) {
        $('#titulo-indicativa').html($(this).val().toUpperCase());
        $('#indicativa-titulo-2').html($(this).val() === 'ali' ? 'Arquivos L&oacute;gicos Internos' : 'Arquivos de Interface Externa');
        $('#tabela-indicativa').val($(this).val());
        $('#form-modal-inserir-indicativa').modal('toggle');
    }
    else {
        if (idContagem == 0) {
            swal({title: "Alerta",
                text: "Voc&eacute; deve salvar as informa&ccedil;&otilde;es iniciais da contagem para poder inserir fun&ccedil;&otilde;es no m&eacute;todo Indicativo.",
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"}, function () {
            });
        }
        else {
            swal({title: "Alerta",
                text: "A abrang&ecirc;ncia da contagem (" + (abAtual == 2 ? 'Projeto' : (abAtual == 3 ? 'Baseline' : 'Licita&ccedil;&atilde;o')) + ") n&atilde;o permite inserir funcionalidades no m&eacute;todo Indicativo.",
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"}, function () {
            });
        }
    }
});
$('#form-modal-inserir-indicativa').on('hidden.bs.modal', function () {
    $('#titulo-indicativa').html('');
    $('#indicativa-titulo-2').html('');
    $('#text-indicativa').val('');
    $('#tabela-indicativa').val('');
});
$('#text-indicativa').on('keyup', function () {
    var regex = new RegExp("^[a-zA-Z0-9;_.-]+$");
    var texto = $(this).val();
    if (!regex.test(texto)) {
        $(this).val(texto.substring(0, (texto.length - 1)));
    }
});
$('#btn-adicionar-indicativa').on('click', function () {
    var regex = new RegExp("^[a-zA-Z0-9;_.-]+$");
    var texto = $('#text-indicativa').val();
    var b = $('#tabela-indicativa').val();
    if (texto.length < 1) {
        swal({title: "Alerta",
            text: "Voc&ecirc; precisa inserir ao menos uma funcionalidade.",
            type: "error",
            html: true,
            confirmButtonText: "Obrigado, vou corrigir!"}, function () {
            return false;
        });
    }
    else if (!regex.test(texto)) {
        swal({title: "Alerta",
            text: "H&aacute; caracteres especiais/inv&aacute;lidos nos nomes/descri&ccedil;&otilde;es das fun&ccedil;&otilde;es.",
            type: "error",
            html: true,
            confirmButtonText: "Obrigado, vou corrigir!"}, function () {
            return false;
        });
    }
    else {
        //array com os textos digitados
        var f = texto.split(';');
        //remover duplicados no texto digitado
        var funcoes = removerDuplicados(f);
        //variavel que armazena as duplicadas
        var duplicadas = '';
        for (x = 0; x < funcoes.length; x++) {
            var funcao = funcoes[x];
            if (funcao.length > 0) {
                //verifica se ha duplicacoes na tabela
                duplicadas += isDuplicada(b.toUpperCase(), funcao) ? funcao + ', ' : insereFuncaoDadosIndicativa(b.toUpperCase(), funcao);
            }
        }
        swal({title: "Informa&ccedil;&atilde;o",
            text: "As funcionalidades foram adicionadas &agrave; contagem." + (duplicadas.length > 0 ? "<br />As seguintes <strong>n&atilde;o</strong> foram inseridas por estarem duplicadas:<br />" + duplicadas.substr(0, duplicadas.length - 2) : ""),
            type: "success",
            html: true,
            confirmButtonText: "Obrigado!"}
        );
        $('#form-modal-inserir-indicativa').modal('toggle');
    }
});
//verifica se ha um id e habilita a tab estatisticas
if ($('#span_id_contagem').html() !== '------') {
    $('#li-ane').removeClass('disabled');
    $('#li-est').removeClass('disabled');
    $('#li-coc').removeClass('disabled');
    $('#li-fin').removeClass('disabled');
}
//cliques no menu rapido, salvar, comentarios, validar, auditar
$(".salvar-contagem").on('click', function () {
    if ($(this).hasClass('disabled')) {
        return false;
    }
    if (!isSalvarContagem) {
        gravaLogAuditoria(emailLogado, userRole, 'salvar-contagem;' + ("000000000" + idContagem).slice(-9));
        return false;
    }
    $(this).addClass('disabled');
    inserirContagem($(this)[0].id);
    //apos inserir a contagem jah salva as estatisticas
    isSalvarEstatisticas = true;
    calculaFases(false);
    //delega o isSalvarEstatisticas para o script _insere_linhas.js
});
$('.finalizar-v-interna').on('click', function () {
    if ($(this).hasClass('disabled')) {
        return false;
    }
    if (!isFinalizarVInterna) {
        gravaLogAuditoria(emailLogado, userRole, 'finalizar-v-interna;' + ("000000000" + idContagem).slice(-9));
        return false;
    }
    $(this).addClass('disabled');
    //faz as validacoes e retorna true ou false
    validarContagem($(this)[0].id, idContagem, 'v-interna', 'fa fa-sign-in', 'vi', $('#responsavel').val(), true);
});
$('.finalizar-v-externa').on('click', function () {
    if ($(this).hasClass('disabled')) {
        return false;
    }
    if (!isFinalizarVExterna) {
        gravaLogAuditoria(emailLogado, userRole, 'finalizar-v-externa;' + ("000000000" + idContagem).slice(-9));
        return false;
    }
    $(this).addClass('disabled');
    //faz as validacoes e retorna true ou false
    validarContagem($(this)[0].id, idContagem, 'v-externa', 'fa fa-sign-out', 've', $('#responsavel').val(), true);
});
$('.finalizar-a-interna').on('click', function () {
    if ($(this).hasClass('disabled')) {
        return false;
    }
    if (!isFinalizarAInterna) {
        gravaLogAuditoria(emailLogado, userRole, 'finalizar-a-interna;' + ("000000000" + idContagem).slice(-9));
        return false;
    }
    $(this).addClass('disabled');
    //faz as validacoes e retorna true ou false
    validarContagem($(this)[0].id, idContagem, 'a-interna', 'fa fa-flag-checkered', 'ai', $('#responsavel').val(), true);
});
$('.finalizar-a-externa').on('click', function () {
    if ($(this).hasClass('disabled')) {
        return false;
    }
    if (!isFinalizarAExterna) {
        gravaLogAuditoria(emailLogado, userRole, 'finalizar-a-externa;' + ("000000000" + idContagem).slice(-9));
        return false;
    }
    $(this).addClass('disabled');
    //faz as validacoes e retorna true ou false
    validarContagem($(this)[0].id, idContagem, 'a-externa', 'fa fa-flag-o', 'ae', $('#responsavel').val(), true);
});
$('.solicitar-revisao').on('click', function () {
    if ($(this).hasClass('disabled')) {
        return false;
    }
    if (!isSolicitarRevisao) {
        gravaLogAuditoria(emailLogado, userRole, 'solicitar-revisao;' + ("000000000" + idContagem).slice(-9));
        return false;
    }
    $(this).addClass('disabled');
    //faz as validacoes e retorna true ou false
    solicitarRevisao($(this)[0].id, idContagem, ac);
});
$('.finalizar-revisao').on('click', function () {
    if ($(this).hasClass('disabled')) {
        return false;
    }
    if (!isFinalizarRevisao) {
        gravaLogAuditoria(emailLogado, userRole, 'finalizar-revisao;' + ("000000000" + idContagem).slice(-9));
        return false;
    }
    $(this).addClass('disabled');
    //faz as validacoes e retorna true ou false
    finalizarRevisao($(this)[0].id, idContagem, abAtual);
});
$('.relatorio-apontes').on('click', function () {
    if ($(this).hasClass('disabled')) {
        return false;
    }
    if (!isRelatorioApontes) {
        gravaLogAuditoria(emailLogado, userRole, 'relatorio-apontes;' + ("000000000" + idContagem).slice(-9));
        return false;
    }
    $(this).attr('data-toggle', 'modal').attr('data-target', '#form_modal_apontes');
    //exibe o formulario e faz a lista de apontamentos
    retornaApontes(idContagem);
});
/*
 * captura as mudancas nos combos
 */
$("#contagem_id_cliente").on("change", function () {
    sel = $("#contagem_id_contrato");
    sel.empty().append('<option value="0">...</option>');
    sel = $("#contagem_id_projeto");
    sel.empty().append('<option value="0">...</option>');
    if (abAtual == 2) {
        sel = $("#contagem_id_baseline");
        sel.empty().append('<option value="0">...</option>');
    }
    if ($(this).val() > 0) {
        comboContrato($(this).val(), '01', 0, 0, 'contagem');
        comboOrgao('01', 0, $(this).val(), $('#id-orgao'));
    }
});

$("#contagem_id_contrato").on("change", function () {
    sel = $("#contagem_id_projeto");
    sel.empty().append('<option value="0">...</option>');
    if (abAtual == 2) {
        sel = $("#contagem_id_baseline");
        sel.empty().append('<option value="0">...</option>');
    }
    if ($(this).val() > 0) {
        /*
         * Pegar os valores HPC e HPA sempre que alterar o contrato
         */
        if (ac === 'al' || ac === 'in') {
            getValorHora($(this).val()); //_tab_estatisticas.js
        }
        comboProjeto($(this).val(), '01', 0, 'contagem');
    }
});

$("#contagem_id_projeto").on("change", function () {
    if (abAtual == 2) {
        sel = $("#contagem_id_baseline");
        sel.empty().append('<option value="0">...</option>');
    }
    if ($(this).val() == 0) {
        $('#gerente_projeto').val('');
        $('#nome_gerente_projeto').val('');
    }
    else {
        if (abAtual == 2) {//projeto
            comboBaseline(0, '1', $("#contagem_id_baseline"), 0); //apenas ativos
        }
        //coloca o gerente de qualquer forma
        getGerenteProjeto($(this).val());
    }
});
$('#contagem_id_baseline').on('change', function () {
    var id = $(this).val();
    if ($(this).val() != 0) {
        //verifica duas coisas ao mesmo tempo
        //(1) se for contagem para a baseline
        //(2) se for uma contagem de projeto
        //verifica se esta baseline possui uma contagem associada
        if (ac !== 'in') {
            $('#id_linguagem').val(0).trigger('change');
            $('#id_tipo_contagem').val(0);
            $('#id_etapa').val(0);
            $('#id_industria').val(0);
            $('#id_banco_dados').val(0);
            $('#id_processo').val(0);
            $('#id_processo_gestao').val(0);
        }
        verificaBaseline(id);
    }
    else {
        $('#span-resumo-baseline').attr({
            'data-content': 'Selecione uma baseline'
        });
        $('#id_linguagem').val(0).trigger('change');
        $('#id_tipo_contagem').val(0);
        $('#id_etapa').val(0);
        $('#id_industria').val(0);
        $('#id_banco_dados').val(0);
        $('#id_processo').val(0);
        $('#id_processo_gestao').val(0);
    }
});
/*
 * verifica a produtividade da linguagem e a conversao de SLOC
 */
$("#id_linguagem").on("change", function () {
    verificaProdutividade($(this).val()); //verifica tambem o Fator Tecnologia
});
$('#files-add').on('click', function () {
    if (Number(idContagem) == 0) {
        swal({title: "Alerta",
            text: "Por favor, insira primeiro as informa&ccedil;&otilde;es sobre a contagem.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
        return false;
    }
    else {
        return true;
    }
});
/*  
 * captura os clicks em determinadas tabs
 */
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var link = String(e.target);
    link = link.split('#');
    if (link[1] === 'tab_variacao' || link[1] === 'est' || link[1] === 'coc') {
        graficoVariacao();
        if (link[1] === 'est' || link[1] === 'coc') {
            //salva as estatisticas apenas nas inclusoes, alteracoes e/ou revisoes
            if (ac === 'in' || ac === 'al' || ac === 're') {
                isSalvarEstatisticas = true;
            }
            calculaFases(true); //para calcular o grafico de entregas
        }
        return true;
    }
    else if (link[1] === 'tab_complexidade') {
        graficoComplexidade();
        return true;
    }
    else if (link[1] === 'tab_operacao') {
        graficoOperacao();
        return true;
    }
    else if (link[1] === 'fin') {
        isAtualizarPrivacidade = true;
    }
});
//captura os cliques nas tabs, todas
$('li[data-toggle="tabs"]').on('click', function () {
    if (($(this).hasClass('disabled'))) {
        return false;
    }
});