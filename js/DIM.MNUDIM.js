$("#contagem_livre").on("click", function () {
    $('#form_modal_selecionar_cliente').modal('show');
    var l = '/pf/DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=in&ab=1';
    listaCliente(l);
});

$("#contagem_auditoria").on("click", function () {
    $('#form_modal_selecionar_cliente').modal('show');
    var l = '/pf/DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=in&ab=1&aud=1';
    listaCliente(l);
});

$("#contagem_projeto").on("click", function () {
    $('#form_modal_selecionar_cliente').modal('show');
    var l = '/pf/DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=in&ab=2';
    listaCliente(l);
});

$("#contagem_baseline").on("click", function () {
    $('#form_modal_selecionar_cliente').modal('show');
    var l = '/pf/DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=in&ab=3';
    listaCliente(l);
});

$("#contagem_licitacao").on("click", function () {
    self.location.href = '/pf/DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=in&ab=4';
});

$("#contagem_snap").on("click", function () {
    $('#form_modal_selecionar_cliente').modal('show');
    var l = '/pf/DIM.Gateway.php?arq=1&tch=2&sub=-1&dlg=1&ac=in&ab=5';
    listaCliente(l);
});

$("#contagem_apt").on("click", function () {
    $('#form_modal_selecionar_cliente').modal('show');
    self.location.href = '/pf/DIM.Gateway.php?arq=2&tch=2&sub=-1&dlg=1&ac=in&ab=6';
    listaCliente(l);
});

$("#contagem_ef").on("click", function () {
    $('#form_modal_selecionar_cliente').modal('show');
    var l = '/pf/DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=in&ab=9';
    listaCliente(l);
});

$("#listar-contagens").on("click", function () {
    b = false;//se for para exibir as baselines
    l = false;//se for para exibir as licitacoes
    fau = false; //para exibir os faturamentos autorizados
    fat = false; //oculta as faturadas
    ana = false; //listar minhas analises
    arq = 32;
    tch = 1;
    sub = -1;
    dlg = 1;
    p = '';
    v = '';
    r = '';
    i = false;
    m = false;
    a = false;
    //verifica se ja esta na pagina de lista contagens e nao redireciona
    var hRef = self.location.href;
    //le apenas o ajax
    if (hRef.indexOf('DIM.Gateway.php?arq=3') > -1) {
        montaThead('lista');
        tableLista.ajax.reload();
        //pushstate para mudar a url
        pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1',
                'Dimension - M&eacute;tricas',
                '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1');
    }
    else {
        self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&p=&v=';
    }
});

$("#listar-minhas-contagens").on("click", function () {
    b = false;//se for para exibir as baselines
    l = false;//se for para exibir as licitacoes
    fau = false; //para exibir os faturamentos autorizados
    fat = false; //oculta as faturadas
    ana = false; //listar minhas analises
    arq = 32;
    tch = 1;
    sub = -1;
    dlg = 1;
    p = '';
    v = '';
    r = '';
    i = false;
    m = true;
    a = false;
    //verifica se ja esta na pagina de lista contagens e nao redireciona
    var hRef = self.location.href;
    //le apenas o ajax
    if (hRef.indexOf('DIM.Gateway.php?arq=3') > -1) {
        montaThead('lista');
        tableLista.ajax.reload();
        //pushstate para mudar a url
        pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1',
                'Dimension - M&eacute;tricas',
                '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1');
    }
    else {
        self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&p=&v=';
    }
});

$("#listar-contagens-acesso").on("click", function () {
    b = false;//se for para exibir as baselines
    l = false;//se for para exibir as licitacoes
    fau = false; //para exibir os faturamentos autorizados
    fat = false; //oculta as faturadas
    ana = false; //listar minhas analises
    arq = 32;
    tch = 1;
    sub = -1;
    dlg = 1;
    p = '';
    v = '';
    r = '';
    i = false;
    m = true;
    a = true;
    //verifica se ja esta na pagina de lista contagens e nao redireciona
    var hRef = self.location.href;
    //le apenas o ajax
    if (hRef.indexOf('DIM.Gateway.php?arq=3') > -1) {
        montaThead('lista');
        tableLista.ajax.reload();
        //pushstate para mudar a url
        pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1',
                'Dimension - M&eacute;tricas',
                '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1');
    }
    else {
        self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&p=&v=';
    }
});

$("#listar-contagens-baseline").on("click", function () {
    b = true;//se for para exibir as baselines
    l = false;//se for para exibir as licitacoes
    fau = false; //para exibir os faturamentos autorizados
    fat = false; //oculta as faturadas
    ana = false; //listar minhas analises//
    arq = 32;
    tch = 1;
    sub = -1;
    dlg = 1;
    p = '';
    v = '';
    i = false;
    m = false;
    a = false;
    //verifica se ja esta na pagina de lista contagens e nao redireciona
    var hRef = self.location.href;
    //le apenas o ajax
    if (hRef.indexOf('DIM.Gateway.php?arq=3') > -1) {
        montaThead('lista');
        tableLista.ajax.reload();
        //pushstate para mudar a url
        pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&b=',
                'Dimension - M&eacute;tricas',
                '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&b=');
    }
    else {
        self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&b=';
    }
});

$("#listar-contagens-licitacao").on("click", function () {
    b = false;//se for para exibir as baselines
    l = true;//se for para exibir as licitacoes      
    fau = false; //para exibir os faturamentos autorizados
    fat = false; //oculta as faturadas
    ana = false; //listar minhas analises
    arq = 32;
    tch = 1;
    sub = -1;
    dlg = 1;
    p = '';
    v = '';
    i = false;
    m = false;
    a = false;
    //verifica se ja esta na pagina de lista contagens e nao redireciona
    var hRef = self.location.href;
    //le apenas o ajax
    if (hRef.indexOf('DIM.Gateway.php?arq=3') > -1) {
        montaThead('lista');
        tableLista.ajax.reload();
        //pushstate para mudar a url
        pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&l=',
                'Dimension - M&eacute;tricas',
                '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&l=');
    }
    else {
        self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&l=';
    }
});

$("#listar-contagens-faturamento-autorizado").on("click", function () {
    b = false;//se for para exibir as baselines
    l = false;//se for para exibir as licitacoes      
    fau = true; //para exibir os faturamentos autorizados
    fat = false; //oculta as faturadas
    ana = false; //listar minhas analises
    arq = 32;
    tch = 1;
    sub = -1;
    dlg = 1;
    p = '';
    v = '';
    i = false;
    m = false;
    a = false;
    //verifica se ja esta na pagina de lista contagens e nao redireciona
    var hRef = self.location.href;
    //le apenas o ajax
    if (hRef.indexOf('DIM.Gateway.php?arq=3') > -1) {
        montaThead('lista');
        tableLista.ajax.reload();
        //pushstate para mudar a url
        pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&fau=',
                'Dimension - M&eacute;tricas',
                '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&fau=');
    }
    else {
        self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&fau=';
    }
});

$("#listar-contagens-faturadas").on("click", function () {
    b = false;//se for para exibir as baselines
    l = false;//se for para exibir as licitacoes      
    fau = false; //para exibir os faturamentos autorizados
    fat = true; //oculta as faturadas
    ana = false; //listar minhas analises
    arq = 32;
    tch = 1;
    sub = -1;
    dlg = 1;
    p = '';
    v = '';
    i = false;
    m = false;
    a = false;
    //verifica se ja esta na pagina de lista contagens e nao redireciona
    var hRef = self.location.href;
    //le apenas o ajax
    if (hRef.indexOf('DIM.Gateway.php?arq=3') > -1) {
        montaThead('lista');
        tableLista.ajax.reload();
        //pushstate para mudar a url
        pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&fat=',
                'Dimension - M&eacute;tricas',
                '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&fat=');
    }
    else {
        self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&fat=';
    }
});

$("#listar-contagens-analise").on("click", function () {
    b = false;//se for para exibir as baselines
    l = false;//se for para exibir as licitacoes      
    fau = false; //para exibir os faturamentos autorizados
    fat = false; //oculta as faturadas
    ana = true; //listar minhas analises
    arq = 91;
    tch = 1;
    sub = -1;
    dlg = 1;
    p = '';
    v = '';
    i = false;
    m = false;
    a = false;
    //verifica se ja esta na pagina de lista contagens e nao redireciona
    var hRef = self.location.href;
    //le apenas o ajax
    if (hRef.indexOf('DIM.Gateway.php?arq=3') > -1) {
        montaThead('analises');
        tableLista.ajax.reload();
        //pushstate para mudar a url
        pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&ana=',
                'Dimension - M&eacute;tricas',
                '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&ana=');
    }
    else {
        self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&ana=';
    }
});

$('#listar-tarefas-pendentes').on('click', function () {
    listarTarefasPendentes();
});

$("#navbar-listar-tarefas-pendentes").on('click', function () {
    listarTarefasPendentes();
});

$('#listar-tarefas-solicitante').on('click', function () {
    listarTarefasSolicitante();
});

$('#link-form-dashboard').on('click', function () {
    self.location.href = '/pf/DIM.Gateway.php?arq=9&tch=2&sub=9&dlg=1';
});

$("#link-financeiro").on("click", function () {
    self.location.href = '/pf/DIM.Gateway.php?arq=5&tch=2&sub=1&dlg=1';
});

$("#administracao").on("click", function () {
    self.location.href = '/pf/DIM.Gateway.php?arq=4&tch=2&sub=0&dlg=1';
});
//funcoes que integram o menu
function listarTarefasPendentes() {
    //sobe o modal
    $('#form_modal_listar_tarefas_pendentes').modal('toggle');
    //verifica se a tabela ja esta ativa e apenas escreve
    if (!($.fn.dataTable.isDataTable('#tableTarefas'))) {
        tblTarefas = $('#tableTarefas').DataTable({
            paging: false,
            serverSide: false,
            deferRender: true,
            processing: true,
            bInfo: false,
            searching: false,
            ordering: false,
            ajax: {
                url: '/pf/DIM.Gateway.php',
                type: 'POST',
                data: {'arq': 36,
                    'tch': 1,
                    'sub': -1,
                    'dlg': 1}
            },
            columns: [
                {data: "avatar"},
                {data: "descricao"},
                {data: "prazos"},
                {data: "acoes"}
            ]
        });
    }
    else {
        tblTarefas.ajax.reload();
    }
}

function listarTarefasSolicitante() {
    //sobe o modal
    $('#form_modal_listar_tarefas_solicitante').modal('toggle');
    //testa se a tabela ja esta ativa e apenas escreve
    if (!($.fn.dataTable.isDataTable('#tableTarefasSolicitante'))) {
        tblTarefasSolicitante = $('#tableTarefasSolicitante').DataTable({
            paging: false,
            serverSide: false,
            deferRender: true,
            processing: true,
            bInfo: false,
            searching: false,
            ordering: false,
            ajax: {
                url: '/pf/DIM.Gateway.php',
                type: 'POST',
                data: {
                    'arq': 37,
                    'tch': 1,
                    'sub': -1,
                    'dlg': 1
                }
            },
            columns: [
                {data: "avatar"},
                {data: "descricao"},
                {data: "prazos"},
                {data: "acoes"}
            ]
        });
    }
    else {
        tblTarefasSolicitante.ajax.reload();
    }
}

function listaCliente(l) {
    $.post('DIM.Gateway.php', {
        'arq': 98,
        'tch': 1,
        'sub': -1,
        'dlg': 0
    }, function (data) {
        /*
         * entrou aqui limpa tudo
         */
        $('#id_roteiro_cliente').empty();
        var lnHTML = '<table class="box-table-a" width="100%">';
        lnHTML += '<thead><th>Logo</th><th>Informa&ccedil;&otilde;es</th><th>Roteiro</th><th>A&ccedil;&atilde;o</th></thead>';
        for (x = 0; x < data.clientes.length; x++) {
            lnHTML +=
                    '<tr>' +
                    '   <td width="15%">' +
                    '       <img src="' + data.clientes[x].logo + '" class="img-thumbnail img-circle" width="100" height="100" />' +
                    '   </td>' +
                    '   <td width="40%">' +
                    '       <i class="fa fa-building-o"></i>&nbsp;' + data.clientes[x].sigla + ' - ' + data.clientes[x].descricao + '<br />' +
                    '       <i class="fa fa-user"></i>&nbsp;' + data.clientes[x].nome + '<br />' +
                    '       <i class="fa fa-envelope-o"></i>&nbsp;<a href="mailto:' + data.clientes[x].email + '">' + data.clientes[x].email + '</a><br />' +
                    '       <i class="fa fa-phone-square"></i>&nbsp;' + data.clientes[x].telefone +
                    '   </td>' +
                    '   <td width="30%"><div class="form-group">' +
                    '       <select id="cliente_' + data.clientes[x].id + '" class="form-control input_style">';
            for (k = 0; k < data.clientes[x].roteiros.length; k++) {
                lnHTML += '<option value="' + data.clientes[x].roteiros[k].id + '">' + data.clientes[x].roteiros[k].descricao + '</option>';
            }
            lnHTML += '     </select></div>' +
                    '   </td>' +
                    '   <td width="15%"><div class="form-group">' +
                    '       <button class="btn btn-success btn-block" onClick="goLink(\'' + l + '&icl=' + data.clientes[x].id + '\', ' + data.clientes[x].id + ');"><i class="fa fa-check-circle"></i>&nbsp;Iniciar</button></div>' +
                    '   </td>' +
                    '</tr>';
        }
        lnHTML += '</table>';
        /*
         * coloca as linhas com os clientes
         */
        $('#addListaCliente').html(lnHTML);
    }, 'json');
}

function goLink(l, i) {
    var id_roteiro = $('#cliente_' + i + ' option:selected').val();
    if (Number(id_roteiro) === 0) {
        swal({
            title: "Alerta",
            text: "Por favor selecione o Roteiro de Métricas a ser utilizado",
            type: "warning",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    else {
        self.location.href = l + '&rot=' + id_roteiro;
    }
}