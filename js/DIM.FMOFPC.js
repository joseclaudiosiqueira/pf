var tableAddPerfis = '<table class="box-table-a" width="100%">' +
        '<thead>' +
        '<tr>' +
        '<th width="15%">Avatar</th>' +
        '<th width="30%">Nome</th>' +
        '<th width="55%">Email</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody id="addPerfis"></tbody>' +
        '</table>';
/*
 * janelas para comparacao entre as contagens
 */
var wCompara1, wCompara2;
/*
 * captura dos clicks dos botes do formulario de funcionalidades disponiveis
 */
$("#btn_alterar").on("click", function () {
    /*
     * verifica se ja foi validada
     */
    if ((lstIdProcesso == 2 || lstIdProcesso == 3 || lstIdProcesso == 10) && !lstDataFim) {
        swal({
            title: "Tem certeza que deseja alterar?",
            text: "Esta contagem j&aacute; foi validada interna e/ou externamente, caso altere, a contagem iniciar&aacute; a partir do processo de <strong>Elabora&ccedil;&atilde;o</strong> e a a&ccedil;&atilde;o n&atilde;o pode ser desfeita.",
            type: "warning",
            html: true,
            showCancelButton: true,
            cancelButtonText: "Não, obrigado",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim, por favor",
            closeOnConfirm: true
        },
        function (isConfirm) {
            if (isConfirm) {
                atualizarHistoricoTpoAlteracao();
            } else {
                return false;
            }
        });
    } else {
        exibeContagemAlteracao();
    }
});

$('.btn-opc').on('click', function () {
    var a = $(this).val();
    $.post('/pf/DIM.Gateway.php', {'i': lstIdContagem, 'arq': 20, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        var iForm;
        switch (Number(data.id)) {
            case 1:
            case 2:
            case 3:
            case 4:
            case 9:
                iForm = 0;//inserir alterar contagem
                break;
            case 5:
                iForm = 1;//inserir alterar contagem snap?
                break;
            case 6:
                iForm = 2;//inserir alterar contagem apt
                break;
            case 7:
                //visualizar comentarios da contagem
                return false;
                break;
        }
        self.location.href = '/pf/DIM.Gateway.php?arq=' + iForm + '&tch=2&sub=-1&dlg=1&ac=' + a + '&ab=' + data.id + '&id=' + lstIdContagem + '&rot=' + data.id_roteiro;
    }, 'json');
});

$('.btn-fa').on('click', function () {
    var a = $(this).html();
    var b = $(this).val();
    var t = a.search('interna') > 0 ? 'ai' : 'ae';
    var r = validaEmail(emailLogado) ? emailLogado : false;
    b === t && r && (btnFAI || btnFAE) ?
            validarContagem($(this).get(0).id, lstIdContagem, b, null, t, r, false) :
            gravaLogAuditoria(emailLogado, userRole, (t === 'ai' ? 'finalizar-a-interna;' : 'finalizar-a-externa') + ("000000000" + lstIdContagem).slice(-9));
    if (!(btnFAI || btnFAE)) {
        $(this).prop('disabled', true);
    }
});

//basealine de estimativa
$('#btn_baseline_estimativa').on('click', function () {
    $.post('/pf/DIM.Gateway.php', {
        'arq': 89,
        'tch': 0,
        'sub': -1,
        'dlg': 0,
        'idc': lstIdContagem
    }, function (data) {
        if (data.sucesso) {
            swal({
                title: "Informação",
                text: "A baseline de estimativa foi salva com sucesso!",
                type: "success",
                html: true,
                closeOnConfirm: true
            });
        }
    }, 'json');
});

$('#btn_privacidade').on('change', function () {//para o formulario de funcoes perfil contagem
    if (isAtualizarPrivacidade) {
        var privacidade = $(this).prop('checked');
        $.post('/pf/DIM.Gateway.php', {
            'i': lstIdContagem, 'p': privacidade ? 1 : 0,
            'arq': 13, 'tch': 0, 'sub': -1, 'dlg': 1},
        function (data) {
            if (data.msg) {
                $("#span-privacidade").animate({opacity: 0}, function () {
                    $(this).html("Privacidade definida com sucesso!")
                            .animate({opacity: 1}).animate({opacity: 0}, 3000);
                });
                //altera o span da privacidade
                $('#priv-' + lstIdContagem).html(privacidade ? '<i class="fa fa-ban fa-lg"></i>&nbsp;&nbsp;' : '<i class="fa fa-circle-thin fa-lg"></i>&nbsp;&nbsp;');
            }
        }, 'json');
    }
});

$('#btn_atualizar_baseline').on('click', function () {
    swal(
            {
                title: "Tem certeza que deseja atualizar a Baseline com esta contagem?",
                text: "Ao atualizar uma baseline atrav&eacute;s de uma contagem de projeto a a&ccedil;&atilde;o n&atilde;o poder&aacute; ser desfeita e a contagem n&atilde;o poder&aacute; mais ser alterada.",
                type: "warning",
                html: true,
                showCancelButton: true,
                cancelButtonText: "Não, obrigado",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, por favor",
                closeOnConfirm: true
            },
    function (isConfirm) {
        if (isConfirm) {
            atualizarBaselineContagem(lstIdContagem);
        } else {
            return false;
        }
    });
});

$('#btn_finalizar').on('click', function () {
    btnFIN ?
            finalizarContagem(lstIdContagem) :
            gravaLogAuditoria(emailLogado, userRole, 'finalizar-contagem-' + ("000000000" + lstIdContagem).slice(-9));
    if (!(btnFIN)) {
        $(this).prop('disabled', true);
    }
});
/*
 * botoes de relatorio
 */
$('#btn-pdf').on('click', function () {
    window.open('/pf/DIM.Gateway.php?arq=62&tch=0&sub=3&dlg=1&i=' + lstIdContagem);
});

$('#btn-html').on('click', function () {
    window.open('/pf/DIM.Gateway.php?arq=61&tch=0&sub=3&dlg=1&i=' + lstIdContagem + '&p=html');
});

$('#btn-xls').on('click', function () {
    window.open('/pf/DIM.Gateway.php?arq=63&tch=0&sub=3&dlg=1&t=xls&i=' + lstIdContagem);
});

$('#btn-ods').on('click', function () {
    window.open('/pf/DIM.Gateway.php?arq=63&tch=0&sub=3&dlg=1&t=ods&i=' + lstIdContagem);
});

$('#btn-xlsx').on('click', function () {
    window.open('/pf/DIM.Gateway.php?arq=63&tch=0&sub=3&dlg=1&t=xlsx&i=' + lstIdContagem);
});

$('#btn-fatto').on('click', function () {
    window.open('/pf/DIM.Gateway.php?arq=95&tch=0&sub=3&dlg=1&t=fatto&i=' + lstIdContagem);
});

//botao fechar janela
$('#fechar-funcoes-perfil').on('click', function () {
    isAtualizarPrivacidade = false;
    lstIdProcesso = '';
    lstDataFim = '';
    lstIdCliente = '';
    lstIdContagem = '';
    $('#btn_privacidade').bootstrapToggle('enable');
    $('#addPerfis').empty();
});

//botoes de acao ve, ai, ae e co
$('.btn-acoes').on('click', function () {
    //passar no value do botao a acao = in->incluir e al->alterar
    //passos para alteracao
    //1->concluir a atividade pendente e enviar email;
    //2->criar uma nova atividade e enviar email;
    //3->alterar o responsavel
    //feito passando um array no val() do botao
    var opcoes = ($(this).val()).split(';');
    var escopo = opcoes[0];
    var acao = opcoes[1];
    $('#log-tabela').empty().html(tableAddPerfis);
    $.post('/pf/DIM.Gateway.php', {'escopo': escopo, 'ic': lstIdCliente,
        'arq': 38, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        for (x = 0; x < data.length; x++) {
            adicionarLinhasPerfis(data[x], escopo, acao);
        }
    }, 'json');
});

/*
 * checks de comparacao e apenas validacao
 */
$('#comparar-contagens').on('change', function () {
    if ($('#realizar-analise-fiscal').prop('checked')) {
        $('#realizar-analise-fiscal').prop('checked', false);
    }
});

$('#realizar-analise-fiscal').on('change', function () {
    if ($('#comparar-contagens').prop('checked')) {
        $('#comparar-contagens').prop('checked', false);
    }
});

/*
 * check de faturamento
 */
$('#faturar').on('change', function () {
    $('#btn-faturar').prop('disabled', !($(this).prop('checked')));
    $('#mes-ano-faturamento').prop('disabled', !($(this).prop('checked'))).val('');
    zeraSelecionadaFaturar(false);
});

/*
 * acao do btn-faturar
 */
$('#btn-faturar').on('click', function () {
    //desabilita para evitar outro clique
    $(this).prop('disabled', true);
    $('#i-btn-faturar').removeClass('fa-check-square-o').addClass('fa-refresh fa-spin');
    $('#s-btn-faturar').html('&nbsp;Aguarde...');
    var faturamento = $('#mes-ano-faturamento').val().split('-');
    var mesFaturamento = Number(faturamento[0]);
    var anoFaturamento = Number(faturamento[1]);
    var maf = $('#mes-ano-faturamento').val();
    if (anoFaturamento.length < 4 || mesFaturamento < 1 || mesFaturamento > 12) {
        swal({
            title: 'Alerta',
            html: true,
            type: 'error',
            text: 'M&ecirc;s / Ano do faturamento est&aacute; incorreto.'
        }, function () {
            $('#i-btn-faturar').removeClass('fa-refresh fa-spin').addClass('fa-check-square-o');
            $('#s-btn-faturar').html('&nbsp;Gerar faturamento');
            $('#btn-faturar').prop('disabled', false);
        });
    }
    else if (arrFaturar.length < 1) {
        swal({
            title: 'Alerta',
            html: true,
            type: 'error',
            text: 'Por favor, selecione ao menos uma contagem para realizar o faturamento'
        }, function () {
            $('#i-btn-faturar').removeClass('fa-refresh fa-spin').addClass('fa-check-square-o');
            $('#s-btn-faturar').html('&nbsp;Gerar faturamento');
            $('#btn-faturar').prop('disabled', false);
        });
    }
    else {
        //envia sem aguardar o retorno do zip, mas atualiza as contagens e a lista
        $.post('/pf/DIM.Gateway.php', {
            'arq': 81,
            'tch': 0,
            'sub': -1,
            'dlg': 0,
            'fat': arrFaturar,
            'maf': maf}, function (data) {
            //libera o alerta e dispara o post sem aguardar o retorno
            if (data.sucesso) {
                swal({
                    title: 'Informa&ccedil;&atilde;o',
                    html: true,
                    type: 'success',
                    text: 'O faturamento foi enviado com sucesso. Aguarde um email informando o local onde voc&ecirc; far&aacute; o <i>download</i> do arquivo.'
                }, function () {
                    tableLista.ajax.reload();
                    //envia sem aguardar o retorno do zip, mas atualiza as contagens e a lista
                    $.post('/pf/DIM.Gateway.php', {
                        'arq': 82,
                        'tch': 0,
                        'sub': -1,
                        'dlg': 0,
                        'fat': arrFaturar,
                        'maf': maf});
                    //restaura os botoes e inputs
                    $('#i-btn-faturar').removeClass('fa-refresh fa-spin').addClass('fa-check-square-o');
                    $('#s-btn-faturar').html('&nbsp;Gerar faturamento');
                    $('#mes-ano-faturamento').val('');
                    $('#faturar').prop('checked', false);
                    //zera a selecao
                    zeraSelecionadaFaturar(true);
                });
            } else {
                //libera o alerta e dispara o post sem aguardar o retorno
                swal({
                    title: 'Alerta',
                    html: true,
                    type: 'error',
                    text: 'Houve erro ao processar o faturamento, por favor, verifique junto ao administrador.'
                });
            }
        }, 'json');
    }
});

/*
 * hide do modal
 */
$('#form-modal-comparar-contagens').on('hide.bs.modal', function () {
    $(TRCompara)
            .parent()
            .parent()
            .parent()
            .find('td:lt(13)')
            .css('background-color', '');
    comparaID1 = 0;
    comparaID2 = 0;
    $('#comparar-id-1').html('0000000');
    $('#comparar-id-2').html('0000000');
    CKEDITOR.instances.analiseFiscalContrato.setData('');
});

function adicionarLinhasPerfis(data, escopo, acao) {
    var t = $('#addPerfis').get(0);
    var r = t.insertRow(-1);
    var cell0 = r.insertCell(0);
    var cell1 = r.insertCell(1);
    var cell2 = r.insertCell(2);
    //var cell3 = r.insertCell(3);
    cell0.innerHTML = '<img id="img-' + data.user_id + '" onclick="selecionaPerfil(\'' + data.user_email + '\', \'' + escopo + '\', \'' + acao + '\');" class="img-circle img-responsive" style="width:64px; height:64px; cursor:default; cursor:pointer;">';
    cell1.innerHTML = '<font style="font-family:arial; font-size:13px; font-weight:bold; text-shadow: 1px 0px #fff;">' + data.user_complete_name + '</font><br />' +
            '<font style="color: #999"><i class="fa fa-phone-square"></i>&nbsp;' +
            (data.telefone_celular !== null ? data.telefone_celular : '-') + '<br />' +
            '<i class="fa fa-phone"></i>&nbsp;' + (data.telefone_fixo !== null ? data.telefone_fixo : '-') + '</font>';
    cell2.innerHTML = '<font style="font-size:9px; color:#999; text-shadow: 1px 0px #fff;">Principal<br /></font><a href="mailto:' + data.user_email + '">' + data.user_email + '</a><br />' +
            '<font style="font-size:9px; color:#999; text-shadow: 1px 0px #fff;">Alternativo<br /></font>' + (data.email_alternativo !== null ? '<a href="mailto:' + data.email_alternativo + '">' + data.email_alternativo + '</a>' : '-');
    //cell3.innerHTML = 'Valida&ccedil;&otilde;es Pendentes: 3, Contagens validadas: 16<br />Tempo M&eacute;dio de Valida&ccedil;&atilde;o: <br />VALIDA&Ccedil;&Atilde;O - Maior 1.600PF (3d 4h 16m 45s), Menor: 40PF (0d 2h 23m 24s)';
    //atualiza o gravatar
    consultaGravatar(data.user_email, '#img-' + data.user_id);
}

//funcao simples que apenas alerta para a selecao do validador/auditor interno ou externo
function selecionaPerfil(email, escopo, acao) {
    var processo;
    var idProcesso;
    switch (escopo) {
        case 'vi':
            processo = 'a Valida&ccedil;&atilde;o Interna';
            idProcesso = 2;
            break;
        case 've':
            processo = 'a Valida&ccedil;&atilde;o Externa';
            idProcesso = 3;
            break;
        case 'ai':
            processo = 'a Auditoria Interna';
            idProcesso = 4;
            break;
        case 'ae':
            processo = 'a Auditoria Externa';
            idProcesso = 5;
            break;
    }
    swal(
            {
                title: "Tem certeza que deseja enviar a contagem para <strong>" + processo + "</strong>?",
                text: "Ao enviar para este processo a a&ccedil;&atilde;o n&atilde;o poder&aacute; ser desfeita.",
                type: "warning",
                html: true,
                showCancelButton: true,
                cancelButtonText: "Não, obrigado",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, por favor",
                closeOnConfirm: false //exibira uma nova mensagem apenas em AI e AE
            },
    function (isConfirm) {
        if (isConfirm) {
            atualizaProcessoValidacao(idProcesso, lstIdContagem, email, false, acao);
            $('#form_modal_funcoes_perfil_contagem').modal('toggle');
            $('#addPerfis').empty();
        } else {
            return false;
        }
    });
}

/*
 * funcao que exibe a contagem para alteracao
 */
function exibeContagemAlteracao() {
    $.post('/pf/DIM.Gateway.php', {
        'i': lstIdContagem,
        'arq': 20,
        'tch': 1,
        'sub': -1,
        'dlg': 1
    }, function (data) {
        var iForm;
        switch (Number(data.id)) {
            case 1:
            case 2:
            case 3:
            case 4:
            case 9:
                iForm = 0;
                break;
            case 5:
                iForm = 1;
                break;
            case 6:
                iForm = 2;
                break;
        }
        self.location.href = '/pf/DIM.Gateway.php?arq=' + iForm + '&tch=2&sub=-1&dlg=1&ac=al&ab=' + data.id + '&id=' + lstIdContagem + (data.isContagemAuditoria == 1 ? '&aud=1' : '') + '&rot=' + idRoteiro;
    }, 'json');
}

function atualizarHistoricoTpoAlteracao() {
    $.post('/pf/DIM.Gateway.php', {'i': lstIdContagem, 'arq': 12, 'tch': 0, 'sub': -1, 'dlg': 1}, function (data) {
        exibeContagemAlteracao();
    }, 'json');
}

function verificaAutorizacao(id, e) {
    lstIdContagem = id;
    compararContagens = $('#comparar-contagens').prop('checked');
    realizarAnaliseFiscal = $('#realizar-analise-fiscal').prop('checked');
    doisMonitores = $('#dois-monitores').prop('checked');
    faturar = $('#faturar').prop('checked');
    /*
     * neste primeiro passo verifica se o usuario esta comparando contagens
     */
    if (compararContagens) {
        if (comparaID1 == 0) {
            comparaID1 = id;
            TRCompara = $(e);
            $('#comparar-id-1').html(('0000000' + id).slice(-7));
            $('#comparar-id-2').html('0000000');
            $(e)
                    .parent()
                    .parent()
                    .parent()
                    .find('td:lt(13)')
                    .css('background-color', 'rgba(168, 178, 213, 1)')
        }
        else if (comparaID2 == 0) {
            comparaID2 = id;
            if (comparaID2 == comparaID1) {
                $(TRCompara)
                        .parent()
                        .parent()
                        .parent()
                        .find('td:lt(13)')
                        .css('background-color', '');
                comparaID1 = 0;
                comparaID2 = 0;
                $('#comparar-id-1').html('0000000');
            }
            else {
                $('#comparar-id-2').html(('0000000' + id).slice(-7));
                if (doisMonitores) {
                    wCompara1 = window.open("/pf/DIM.Gateway.php?arq=90&tch=0&sub=3&dlg=1&i=" + comparaID1 + "&i2=" + comparaID2 + "&p=html&cp=&dm", '_blank', 'toolbar=0,location=0,menubar=0');
                    wCompara2 = window.open("/pf/DIM.Gateway.php?arq=90&tch=0&sub=3&dlg=1&i=" + comparaID2 + "&p=html&cp=", '_blank', 'toolbar=0,location=0,menubar=0');
                }
                else {
                    $('#col-compara-1').remove();
                    $('#col-compara-2').remove();
                    $('#div-compara-contagem').append('<div class="col-md-6 scroll" id="col-compara-1" style="min-height: 630px; max-height: 630px; overflow-x: hidden; overflow-y: scroll;"></div>');
                    $('#div-compara-contagem').append('<div class="col-md-6 scroll" id="col-compara-2" style="min-height: 630px; max-height: 630px; overflow-x: hidden; overflow-y: scroll;"></div>');
                    $.get("/pf/DIM.Gateway.php?arq=90&tch=0&sub=3&dlg=1&i=" + comparaID1 + "&i2=" + comparaID2 + "&p=html&cp=", function (html) {
                        $('#col-compara-1').html(html);
                    });
                    $.get("/pf/DIM.Gateway.php?arq=90&tch=0&sub=3&dlg=1&i=" + comparaID2 + "&p=html&cp=", function (html) {
                        $('#col-compara-2').html(html);
                    });
                    /*
                     * altera as propriedades do modal
                     */
                    $('#modal-dialog-comparar-contagens').addClass('modal-lg');
                    $('#form-modal-comparar-contagens').modal('toggle');
                    //$("#iframe-compara-1").attr("src", "/pf/DIM.Gateway.php?arq=90&tch=0&sub=3&dlg=1&i=" + comparaID1 + "&i2=" + comparaID2 + "&p=html&cp=");
                    //$("#iframe-compara-2").attr("src", "/pf/DIM.Gateway.php?arq=90&tch=0&sub=3&dlg=1&i=" + comparaID2 + "&p=html&cp=");
                    $.post('/pf/DIM.Gateway.php', {
                        'idContagem1': comparaID1,
                        'idContagem2': comparaID2,
                        'tipo': 0,
                        'arq': 90,
                        'tch': 1,
                        'sub': -1,
                        'dlg': 0}, function (data) {
                        DIMCKEditor.setData(data.analise);
                    }, 'json');
                    $('#col-compara-1').on('scroll', function () {
                        $('#col-compara-2').scrollTop($(this).scrollTop());
                    });
                }
            }
        }
    }
    else if (realizarAnaliseFiscal) {
        comparaID1 = id;
        comparaID2 = 0;
        if (doisMonitores) {
            window.open("/pf/DIM.Gateway.php?arq=90&tch=0&sub=3&dlg=1&i=" + id + "&p=html&cp=&an=", '_blank', 'toolbar=0,location=0,menubar=0');
        }
        else {
            $('#col-compara-1').remove();
            $('#col-compara-2').remove();
            $('#div-compara-contagem').append('<div class="col-md-12 scroll" id="col-compara-1" style="min-height: 630px; max-height: 630px; overflow-x: hidden; overflow-y: scroll;"></div>');
            $.get("/pf/DIM.Gateway.php?arq=90&tch=0&sub=3&dlg=1&i=" + id + "&p=html&cp=&an=", function (html) {
                $('#col-compara-1').html(html);
            });
            /*
             * altera o tamanho do form-modal
             */
            $('#modal-dialog-comparar-contagens').removeClass('modal-lg');
            $('#form-modal-comparar-contagens').modal('toggle');
            //$("#iframe-compara-1").attr("src", "/pf/DIM.Gateway.php?arq=90&tch=0&sub=3&dlg=1&i=" + id + "&p=html&cp=&an");
            //TODO: $("#div-compara-contagem").scrollTop();
            $.post('/pf/DIM.Gateway.php', {
                'idContagem1': comparaID1,
                'idContagem2': comparaID2,
                'tipo': 1,
                'arq': 90,
                'tch': 1,
                'sub': -1,
                'dlg': 0}, function (data) {
                DIMCKEditor.setData(data.analise);
            }, 'json');
        }
    }
    /*
     * especifico para faturamento
     */
    else if (faturar) {
        //verifica se ja esta selecionada
        if ($(e)
                .parent()
                .parent()
                .parent()
                .hasClass('tr-selecionada')) {
            //retira a classe de selecao
            $(e)
                    .parent()
                    .parent()
                    .parent()
                    .removeClass('tr-selecionada')
                    .find('td:lt(13)')
                    .css('background-color', '');
            //envia ao ID para a funcao (adiciona ou retira IDs)
            selecionadaFaturar(id);
        }
        else {
            //procura pela div que armazena a autorizacao de faturamento class = 'af'
            var empresaFornecedorFaturamento = isFornecedor ? 'fauF' : 'fauE';
            var isAutorizadoFaturar = $(e).parent().parent().parent().find('td:eq(3)').parent().find('div').hasClass(empresaFornecedorFaturamento);
            if (isAutorizadoFaturar) {
                //adiciona a classe de selecao
                $(e)
                        .parent()
                        .parent()
                        .parent()
                        .addClass('tr-selecionada')
                        .find('td:lt(13)')
                        .css('background-color', 'rgba(168, 178, 213, 1)');
                //envia ao ID para a funcao (adiciona ou retira IDs)
                selecionadaFaturar(id);
            }
            else {
                swal({
                    title: 'Alerta',
                    html: true,
                    type: 'error',
                    text: 'Por favor, selecione apenas as contagens com FATURAMENTO AUTORIZADO e/ou ser voc&ecirc; &eacute; um GESTOR, selecione apenas as contagens de sua Empresa. As contagens de Fornecedores devem ser faturadas por seus respectivos gestores.'});
            }
        }
    }
    else {
        $('#id').val(lstIdContagem);
        $("#id_contagem").html(("0000000" + id).slice(-7));
        $.post('/pf/DIM.Gateway.php', {
            'i': id,
            'arq': 51, 'tch': 1, 'sub': -1, 'dlg': 1
        }, function (data) {
            $('#form_modal_funcoes_perfil_contagem').modal('toggle');
            /*
             * negativa do retorno porque o disabled tem que ser false ou true - ao contrario da resposta
             * p.ex: se tem acesso retorna true, entao o 'disabled' tem que ser false para acessar
             */
            $('#btn_alterar').prop('disabled', !data.btn_alterar).removeClass('btn-success').addClass(data.btn_alterar ? 'btn-success' : 'btn-default');
            $('#btn_revisar').prop('disabled', !data.btn_revisar).removeClass('btn-success').addClass(data.btn_revisar ? 'btn-success' : 'btn-default');
            $('#btn_copiar').prop('disabled', !data.btn_copiar).removeClass('btn-success').addClass(data.btn_copiar ? 'btn-success' : 'btn-default');
            $('#btn_editar').prop('disabled', !data.btn_editar).removeClass('btn-success').addClass(data.btn_editar ? 'btn-success' : 'btn-default');
            $('#btn_excluir').prop('disabled', !data.btn_excluir).removeClass('btn-warning').addClass(data.btn_excluir ? 'btn-warning' : 'btn-default');
            $('#btn_finalizar').prop('disabled', !data.btn_finalizar).removeClass('btn-sucesss').addClass(data.btn_finalizar ? 'btn-sucess' : 'btn-default');
            $('#btn_baseline_estimativa').prop('disabled', !data.btn_baseline_estimativa).removeClass('btn-success').addClass(data.btn_baseline_estimativa ? 'btn-success' : 'btn-default');
            $('#btn_atualizar_baseline').prop('disabled', !data.btn_atualizar_baseline).removeClass('btn-success').addClass(data.btn_atualizar_baseline ? 'btn-success' : 'btn-default');
            $('#btn_visualizar').prop('disabled', !data.btn_visualizar).removeClass('btn-success').addClass(data.btn_visualizar ? 'btn-success' : 'btn-default');
            $('#btn_alterar_validador_interno').prop('disabled', !data.btn_alterar_validador_interno).removeClass('btn-success').addClass(data.btn_alterar_validador_interno ? 'btn-success' : 'btn-default');
            $('#btn_alterar_validador_externo').prop('disabled', !data.btn_alterar_validador_externo).removeClass('btn-success').addClass(data.btn_alterar_validador_externo ? 'btn-success' : 'btn-default');
            $('#btn_alterar_gerente_projeto').prop('disabled', !data.btn_alterar_gerente_projeto).removeClass('btn-success').addClass(data.btn_alterar_gerente_projeto ? 'btn-success' : 'btn-default');
            $('#btn_finalizar_auditoria_interna').prop('disabled', !data.btn_finalizar_auditoria_interna).removeClass('btn-success').addClass(data.btn_finalizar_auditoria_interna ? 'btn-success' : 'btn-default');
            $('#btn_finalizar_auditoria_externa').prop('disabled', !data.btn_finalizar_auditoria_externa).removeClass('btn-success').addClass(data.btn_finalizar_auditoria_externa ? 'btn-success' : 'btn-default');
            $('#btn_privacidade').bootstrapToggle(data.privacidade == 0 ? 'off' : 'on');
            $('#btn_privacidade').bootstrapToggle(isFornecedor ? 'disable' : (data.btn_privacidade ? 'enable' : 'disable'));
            $('#btn_validar_interno').prop('disabled', !data.btn_validar_interno).removeClass('btn-success').addClass(data.btn_validar_interno ? 'btn-success' : 'btn-default');
            $('#btn_validar_externo').prop('disabled', !data.btn_validar_externo).removeClass('btn-success').addClass(data.btn_validar_externo ? 'btn-success' : 'btn-default');
            $('#btn_auditar_interno').prop('disabled', !data.btn_auditar_interno).removeClass('btn-success').addClass(data.btn_auditar_interno ? 'btn-success' : 'btn-default');
            $('#btn_auditar_externo').prop('disabled', !data.btn_auditar_externo).removeClass('btn-success').addClass(data.btn_auditar_externo ? 'btn-success' : 'btn-default');
            $('#btn_empresa').prop('disabled', !data.btn_empresa).removeClass('btn-success').addClass(data.btn_empresa ? 'btn-success' : 'btn-default');
            $('#btn_diretorio').prop('disabled', !data.btn_diretorio).removeClass('btn-success').addClass(data.btn_diretorio ? 'btn-success' : 'btn-default');
            $('#btn_orgao').prop('disabled', !data.btn_orgao).removeClass('btn-success').addClass(data.btn_orgao ? 'btn-success' : 'btn-default');
            //$('#btn_exportar_pdf_resumo').toggleClass(data.btn_exportar_pdf_resumo ? '' : 'disabled');
            //$('#btn_exportar_pdf_detalhado').toggleClass(data.btn_exportar_pdf_detalhado ? '' : 'disabled');
            //$('#btn_exportar_pdf_detalhado_estatisticas').toggleClass(data.btn_exportar_pdf_detalhado_estatisticas ? '' : 'disabled');
            $('#btn-pdf').prop('disabled', !data.btn_pdf).removeClass('btn-success').addClass(data.btn_pdf ? 'btn-success' : 'btn-default');
            $('#btn-html').prop('disabled', !data.btn_html).removeClass('btn-success').addClass(data.btn_html ? 'btn-success' : 'btn-default');
            //$('#btn-json').prop('disabled', !data.btn_json).removeClass('btn-success').addClass(data.btn_json ? 'btn-success' : 'btn-default');;
            //$('#btn-xml').prop('disabled', !data.btn_xml).removeClass('btn-success').addClass(data.btn_xml ? 'btn-success' : 'btn-default');;
            $('#btn-ods').prop('disabled', !data.btn_ods).removeClass('btn-success').addClass(data.btn_ods ? 'btn-success' : 'btn-default');
            $('#btn-xls').prop('disabled', !data.btn_xls).removeClass('btn-success').addClass(data.btn_xls ? 'btn-success' : 'btn-default');
            $('#btn-xlsx').prop('disabled', !data.btn_xlsx).removeClass('btn-success').addClass(data.btn_xlsx ? 'btn-success' : 'btn-default');
            //$('#btn-ifpug').prop('disabled', !data.btn_ifpug).removeClass('btn-success').addClass(data.btn_ifpug ? 'btn-success' : 'btn-default');;
            $('#btn-zip').prop('disabled', !data.btn_zip).removeClass('btn-success').addClass(data.btn_zip ? 'btn-success' : 'btn-default');
            //botao de colaboracao
            $('#btn_colaborar').prop('disabled', !data.btn_colaborar).removeClass('btn-success').addClass(data.btn_colaborar ? 'btn-success' : 'btn-default');
            //auditorias internas e externas
            $('#btn_validador_externo').prop('disabled', !data.btn_validador_externo).removeClass('btn-success').addClass(data.btn_validador_externo ? 'btn-success' : 'btn-default');
            $('#btn_auditor_interno').prop('disabled', !data.btn_auditor_interno).removeClass('btn-success').addClass(data.btn_auditor_interno ? 'btn-success' : 'btn-default');
            $('#btn_auditor_externo').prop('disabled', !data.btn_auditor_externo).removeClass('btn-success').addClass(data.btn_auditor_externo ? 'btn-success' : 'btn-default');
            $('#btn-fatto').prop('disabled', !data.btn_fatto).removeClass('btn-success').addClass(data.btn_fatto ? 'btn-success' : 'btn-default');
            /*
             * atribui o id do processo e a data_fim para o botao alterar
             */
            lstIdProcesso = data.id_processo;
            lstDataFim = data.data_fim;
            lstIdCliente = data.id_cliente;
            isAtualizarPrivacidade = true;
            idRoteiro = data.id_roteiro;
            //btn
            btnFAI = data.btn_finalizar_auditoria_interna;
            btnFAE = data.btn_finalizar_auditoria_externa;
            btnFIN = data.btn_finalizar;
        }, "json");
    }
}

function fe(b) {
    if ($(b).val() === 'e') {
        $.post('/pf/DIM.Gateway.php', {'i': lstIdContagem,
            'arq': 27, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
            if (data.sucesso) {
                swal({
                    title: "Informa&ccedil;&atilde;o",
                    text: data.msg,
                    type: "success",
                    html: true,
                    confirmButtonText: "Ok, obrigado!"});
                $('[data-original-title]').popover('hide');
                $('#form_modal_funcoes_perfil_contagem').modal('hide');
                //verifica se ja esta na pagina de lista contagens e nao redireciona
                var hRef = self.location.href;
                //le apenas o ajax
                if (hRef.indexOf('DIM.Gateway.php?arq=3') > 0) {
                    arq = 32;
                    tch = 1;
                    sub = -1;
                    dlg = 1;
                    p = '';
                    v = '';
                    tableLista.ajax.reload();
                    //pushstate para mudar a url
                    pushState(DIR_APP + 'pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1',
                            'Dimension - M&eacute;tricas',
                            DIR_APP + 'pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1');
                } else {
                    self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&p=&v=';
                }
                //atualiza o balloon com o total de tarefas pendentes
                $('#navbar-listar-tarefas-pendentes').html(data.qtd);
            }
            else {
                swal({
                    title: "Informa&ccedil;&atilde;o",
                    text: data.msg,
                    type: "warning",
                    html: true,
                    confirmButtonText: "Ok, vou verificar!"});
            }
        }, 'json');
    } else {
        $('[data-original-title]').popover('hide');
    }
}