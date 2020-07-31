var i = (typeof getVar('id') !== 'undefined' ? true : false);//se vier um id de contagem
var b = (typeof getVar('b') !== 'undefined' ? true : false);//se for para exibir as baselines
var l = (typeof getVar('l') !== 'undefined' ? true : false);//se for para exibir as licitacoes
var m = (typeof getVar('m') !== 'undefined' ? true : false);//se for para exibir as minhas contagens
var a = (typeof getVar('a') !== 'undefined' ? true : false);//se for para exibir as minhas contagens
var ana = (typeof getVar('ana') !== 'undefined' ? true : false);//se for para exibir as analises
var arq = ana ? 91 : 32;
//colunas padrao
tblColumns = [
    {data: "col1"},
    {data: "col2"},
    {data: "col3"},
    {data: "col4"},
    {data: "col5"},
    {data: "col6"},
    {data: "col7"},
    {data: "col8"}
];
//monta tudo
$(document).ready(function () {
    !isFornecedor && contagemConfig['is_visualizar_contagem_fornecedor'] == 0 ? comboFornecedores('pesquisa', 0, 0, 0, true) : null;
    !isFornecedor && contagemConfig['is_visualizar_contagem_fornecedor'] == 1 ? comboFornecedores('pesquisa', 0, 0, 1, true) : null;
    comboBaseline(0, 0, $('#combo-baseline-lista-contagens'), 0);
    comboProjetoBaseline(0, $('#combo-projeto-lista-contagens'));
    montaThead(ana ? 'analises' : 'lista');//monte a thead da tabela e a tabela em si
    //tenta inicializar novamente
    tableLista = $('#dataTable').DataTable({
        paging: false,
        serverSide: false,
        deferRender: true,
        processing: true,
        bInfo: false,
        order: [[1, "desc"]],
        columns: tblColumns,
        searching: true,
        columnDefs: [
            {"orderable": false, "targets": 7}
        ],
        ajax: {
            url: '/pf/DIM.Gateway.php',
            type: 'POST',
            data: function (d) {
                d.arq = arq;
                d.tch = tch;
                d.sub = sub;
                d.dlg = dlg;
                d.p = i ? 'id' : p;//pesquisa pelo id da contagem
                d.v = i ? getVar('id') : r;
                if (l) {//licitacao
                    d.l = '';
                } else if (b) {//baseline
                    d.b = '';
                } else if (fau) {//faturamento autorizado
                    d.fau = '';
                } else if (fat) {//faturadas
                    d.fat = '';
                } else if (ana) {//minhas analises (fiscal contrato)
                    d.ana = '';
                } else if (m) {//minhas contagens
                    d.m = '';
                } else if (a) {//???
                    d.a = '';
                }
            }
        }
    });
    //float thead
    //$('#dataTable').floatThead({scrollingTop: 50, useAbsolutePositioning: true});
});

$('#forn-ativo-inativo').on('change', function () {
    comboFornecedores('pesquisa', 0, ($(this).prop('checked') ? '01' : 1), 0, true);
});

$('#turma-ativo-inativo').on('change', function () {
    comboFornecedores('pesquisa', 0, ($(this).prop('checked') ? '01' : 1), 1, true);
});

$('#collapseOne').on('hidden.bs.collapse', function () {
    $('#cabecalho').html('&nbsp;&nbsp;Exibir filtros');
    $('#eye')
            .removeClass('fa fa-eye-slash')
            .addClass('fa fa-eye');
});

$('#collapseOne').on('show.bs.collapse', function () {
    $('#cabecalho')
            .html('&nbsp;&nbsp;Ocultar filtros');
    $('#eye')
            .removeClass('fa fa-eye')
            .addClass('fa fa-eye-slash');
});
/*
 * finalizar o faturamento do ponto de vista do fiscal do contrato
 */
function finalizarFaturamentoFiscal(idc) {
    var exibirAlertas = $('#exibir-alertas').prop('checked');
    if (exibirAlertas) {
        swal({title: 'Confirma&ccedil;&atilde;o',
            text: 'Confirma a autoriza&ccedil;&atilde;o para faturamento da contagem?',
            html: true,
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar'}, function () {
            $.post('/pf/DIM.Gateway.php', {'arq': 79, 'tch': 0, 'sub': -1, 'dlg': 0, 'idc': idc}, function (data) {
                swal({
                    title: (data.id_tarefa > 0 ? 'Informa&ccedil;&atilde;o' : 'Alerta'),
                    text: data.msg,
                    type: (data.id_tarefa > 0 ? 'success' : 'warning'),
                    html: true,
                    confirmButtonText: "Obrigado!"}, function () {
                    montaThead('lista');
                    tableLista.ajax.reload();
                    pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1',
                            'Dimension - M&eacute;tricas',
                            '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1');

                });
            }, 'json');
        });
    }
    else {
        $.post('/pf/DIM.Gateway.php', {'arq': 79, 'tch': 0, 'sub': -1, 'dlg': 0, 'idc': idc}, function (data) {
            swal({
                title: (data.id_tarefa > 0 ? 'Informa&ccedil;&atilde;o' : 'Alerta'),
                text: data.msg,
                type: (data.id_tarefa > 0 ? 'success' : 'warning'),
                html: true,
                confirmButtonText: "Obrigado!"}, function () {
                montaThead('lista');
                tableLista.ajax.reload();
                pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1',
                        'Dimension - M&eacute;tricas',
                        '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1');

            });
        }, 'json');
    }
}
/*
 * apenas para alertar os bloqueios de contagem
 */
function alertaBloqueio(m) {
    swal({
        title: "Informa&ccedil;&atilde;o",
        text: m,
        type: "info",
        html: true,
        confirmButtonText: "Obrigado!"});
}

/*
 * captura dos cliques nos botoes de dada inicial e data final
 */
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var checkin = $('#data-inicial').datepicker({format: 'dd/mm/yyyy', onRender: function (date) {
    }}).on('changeDate', function (ev) {
    checkin.hide();
    $('#data-final').val('')[0].focus();
}).data('datepicker');

var checkout = $('#data-final').datepicker({format: 'dd/mm/yyyy', onRender: function (date) {
        return '';
        //sem desabilitar datas
        //date.valueOf() < checkin.date.valueOf() ? 'disabled' : 
    }}).on('changeDate', function (ev) {
    checkout.hide();
}).data('datepicker');

//pesquisa ordem de servico
$('#input-os').on('change', function () {
    r = $('#input-os').val();
    b = (typeof getVar('b') !== 'undefined' ? true : false);//se for para exibir as baselines
    l = (typeof getVar('l') !== 'undefined' ? true : false);//se for para exibir as licitacoes    
    if (r === '') {
        /*
         * 
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "Por favor, digite algo no campo para pesquisar",
            type: "info",
            html: true,
            confirmButtonText: "Obrigado!"});
        */
    } else {
        arq = 32;
        tch = 1;
        sub = -1;
        dlg = 1;
        p = 'os';
        v = r;
        fau = false;
        fat = false;
        ana = false;
        m = false;
        a = false;
        montaThead('lista');
        tableLista.ajax.reload();
    }
    $('#input-os').val('');
});

//pesquisa pelo responsavel
$('#input-responsavel').on('click', function () {
    r = $('#input-responsavel').val();
    b = (typeof getVar('b') !== 'undefined' ? true : false);//se for para exibir as baselines
    l = (typeof getVar('l') !== 'undefined' ? true : false);//se for para exibir as licitacoes    
    if (r === '') {
        /*
         * 
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "Por favor, digite algo no campo para pesquisar",
            type: "info",
            html: true,
            confirmButtonText: "Obrigado!"});
        */
    } else {
        arq = 32;
        tch = 1;
        sub = -1;
        dlg = 1;
        p = 'responsavel';
        v = r;
        fau = false;
        fat = false;
        ana = false;
        m = false;
        a = false;
        montaThead('lista');
        tableLista.ajax.reload();
    }
    $('#input-responsavel').val('');
});

//pesquisa projeto
$('#input-projeto').on('click', function () {
    r = $('#input-projeto').val();
    b = (typeof getVar('b') !== 'undefined' ? true : false);//se for para exibir as baselines
    l = (typeof getVar('l') !== 'undefined' ? true : false);//se for para exibir as licitacoes    
    if (r === '') {
        /*
         * 
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "Por favor, digite algo no campo para pesquisar",
            type: "info",
            html: true,
            confirmButtonText: "Obrigado!"});
        */
    } else {
        arq = 32;
        tch = 1;
        sub = -1;
        dlg = 1;
        p = 'projeto';
        v = r;
        fau = false;
        fat = false;
        ana = false;
        m = false;
        a = false;
        montaThead('lista');
        tableLista.ajax.reload();
    }
    $('#input-projeto').val('');
});

//pesquisa cliente
$('#input-cliente').on('click', function () {
    r = $('#input-cliente').val();
    b = (typeof getVar('b') !== 'undefined' ? true : false);//se for para exibir as baselines
    l = (typeof getVar('l') !== 'undefined' ? true : false);//se for para exibir as licitacoes    
    if (r === '') {
        /*
         * 
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "Por favor, digite algo no campo para pesquisar",
            type: "info",
            html: true,
            confirmButtonText: "Obrigado!"});
        */
    } else {
        arq = 32;
        tch = 1;
        sub = -1;
        dlg = 1;
        p = 'cliente';
        v = r;
        fau = false;
        fat = false;
        ana = false;
        m = false;
        a = false;
        montaThead('lista');
        tableLista.ajax.reload();
    }
    $('#input-cliente').val('');
});

//pesquisa pelo id do projeto
$('#combo-projeto-lista-contagens').on('change', function () {
    if ($(this).val() != 0) {
        r = $(this).val();
        b = (typeof getVar('b') !== 'undefined' ? true : false);//se for para exibir as baselines
        l = (typeof getVar('l') !== 'undefined' ? true : false);//se for para exibir as licitacoes
        arq = 32;
        tch = 1;
        sub = -1;
        dlg = 1;
        p = 'id_projeto';
        v = r;
        fau = false;
        fat = false;
        ana = false;
        m = false;
        a = false;
        montaThead('lista');
        tableLista.ajax.reload();
    }
});

//pesquisa pelo id da baseline
$('#combo-baseline-lista-contagens').on('change', function () {
    if ($(this).val() != 0) {
        r = $(this).val();
        b = (typeof getVar('b') !== 'undefined' ? true : false);//se for para exibir as baselines
        l = (typeof getVar('l') !== 'undefined' ? true : false);//se for para exibir as licitacoes
        arq = 32;
        tch = 1;
        sub = -1;
        dlg = 1;
        p = 'id_baseline';
        v = r;
        fat = false;
        fau = false;
        ana = false;
        m = false;
        a = false;
        montaThead('lista');
        tableLista.ajax.reload();
    }
});
//pesquisa data
$('#pesq-data').on('click', function () {
    di = $('#data-inicial').val();
    df = $('#data-final').val();
    r = di + ' ' + df;
    b = (typeof getVar('b') !== 'undefined' ? true : false);//se for para exibir as baselines
    l = (typeof getVar('l') !== 'undefined' ? true : false);//se for para exibir as licitacoes    
    if (r === ' ') {
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "Por favor, digite algo nas datas para pesquisar",
            type: "info",
            html: true,
            confirmButtonText: "Obrigado!"});
        return false;
    } else {
        arq = 32;
        tch = 1;
        sub = -1;
        dlg = 1;
        p = 'data';
        v = r;
        fau = false;
        fat = false;
        ana = false;
        m = false;
        a = false;
        montaThead('lista');
        tableLista.ajax.reload();
    }
    $('#data-inicial').val('');
    $('#data-final').val('');
});

$('#pesquisa_id_fornecedor').on('change', function () {
    if ($(this).val() != 0) {
        r = $(this).val();
        b = (typeof getVar('b') !== 'undefined' ? true : false);//se for para exibir as baselines
        l = (typeof getVar('l') !== 'undefined' ? true : false);//se for para exibir as licitacoes
        arq = 32;
        tch = 1;
        sub = -1;
        dlg = 1;
        p = 'fornecedor';
        v = r;
        fau = false;
        fat = false;
        ana = false;
        m = false;
        a = false;
        montaThead('lista');
        tableLista.ajax.reload();
    }
});

$('#pesquisa_id_turma').on('change', function () {
    if ($(this).val() != 0) {
        r = $(this).val();
        b = (typeof getVar('b') !== 'undefined' ? true : false);//se for para exibir as baselines
        l = (typeof getVar('l') !== 'undefined' ? true : false);//se for para exibir as licitacoes    
        arq = 32;
        tch = 1;
        sub = -1;
        dlg = 1;
        p = 'fornecedor';
        v = r;
        fau = false;
        fat = false;
        ana = false;
        m = false;
        a = false;
        montaThead('lista');
        tableLista.ajax.reload();
    }
});

$('.limpar-filtros').on('click', function () {
    tableLista.destroy();
    $('#input-os').val('');
    $('#input-responsavel').val('');
    $('#input-projeto').val('');
    $('#input-cliente').val('');
    $('#data-inicial').val('');
    $('#data-final').val('');
    $('#turma-ativo-inativo').bootstrapToggle('on');
    $('#forn-ativo-inativo').bootstrapToggle('on');
    $('#combo-projeto-lista-contagens').val(0);
    $('#combo-baseline-lista-contagens').val(0);
    arq = 32;
    tch = 1;
    sub = -1;
    dlg = 1;
    p = '';
    v = '';
    r = '';
    i = false;
    b = false;
    l = false;
    fau = false;
    fat = false;
    ana = false;
    m = false;//verificar se volta para minhas contagens ou nao
    a = false;
    montaThead('lista');//monte a thead da tabela e a tabela em si
    //tenta inicializar novamente
    tableLista = $('#dataTable').DataTable({
        paging: false,
        serverSide: false,
        deferRender: true,
        processing: true,
        bInfo: false,
        order: [[1, "desc"]],
        searching: false,
        columns: tblColumns,
        columnDefs: [
            {"orderable": false, "targets": 7}
        ],
        ajax: {
            url: '/pf/DIM.Gateway.php',
            type: 'POST',
            data: function (d) {
                d.arq = arq;
                d.tch = tch;
                d.sub = sub;
                d.dlg = dlg;
                d.p = i ? 'id' : p;//pesquisa pelo id da contagem
                d.v = i ? getVar('id') : r;
                if (l) {//licitacao
                    d.l = '';
                } else if (b) {//baseline
                    d.b = '';
                } else if (fau) {//faturamento autorizado
                    d.fau = '';
                } else if (fat) {//faturadas
                    d.fat = '';
                } else if (ana) {//minhas analises (fiscal contrato)
                    d.ana = '';
                } else if (m) {//minhas contagens
                    d.m = '';
                } else if (a) {//???
                    d.a = '';
                }
            }
        }
    });
    pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1',
            'Dimension - M&eacute;tricas',
            '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1');
});