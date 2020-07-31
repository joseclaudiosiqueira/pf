/*
 * formulario de cadastro de usuarios
 * funcao que verifica o keydown no nome do usuario
 */
jQuery(function ($) {
    $(document).on('keypress', 'input.verifica-id-usuario', function (e) {
        var sonumero = document.getElementById("user_name");
        var key = (window.event) ? event.keyCode : e.which;
        var opcao = $('#frmiausu-opcao-identificador').val();
        var usuario = $('#user_name').val();
        if (usuario.length == 11 && opcao == 0) {
            return false;
        } else if (opcao == 0) {
            if (opcao == 0) {// pelo cpf
                if ((key > 47 && key < 58)) {
                    return true;
                } else {
                    return (key == 8 || key == 0) ? true : false;
                }
            }
        } else if (opcao == 1) {
            if (usuario.length == 64) {
                return false;
            }
        }

    });
});
/*
 * captcha
 */
$('#fmiausu-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#fmiausu-i-captcha'), false);
});
/*
 * para todos dos forms a leitura da imagem do captcha eh feita no click para
 * evitar desatualizacoes
 */
$('#fmiausu-link').on(
        'click',
        function () {
            formulario = '';
            tpoFornecedor = 0;
            if (empresaConfigPlano.id < 3) {
                return false;
            }
            // se nao eh demo nem estudante segue o processo
            $('#fmiausu-img-captcha').attr('src',
                    '/pf/vendor/huge/tools/showCaptcha.php');
            $('#span-titulo-usuario')
                    .html(
                            '&nbsp;&nbsp;<i class="fa fa-users fa-lg"></i>&nbsp;&nbsp;Usu&aacute;rios e Grupos');
            $('#tip-usuario-fornecedor')
                    .html(
                            '<i class="fa fa-info-circle"></i>&nbsp;Usu&aacute;rio de um fornecedor?');
            $('#chk_id_fornecedor').prop('disabled', true).prop(
                    'checked', false);
            /*
             * remonta as empresas
             */
            _41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265 === '41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265' ? f41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265()
                    : null;
        });
/*
 * clique no link para inserir um Aluno em uma turma como um usuario
 */
$('#fmiaaluno-link').on(
        'click',
        function () {
            formulario = 'turma';
            tpoFornecedor = 1;
            if (empresaConfigPlano.id < 3) {
                return false;
            }
            // se nao eh demo nem estudante segue o processo
            $('#fmiausu-img-captcha').attr('src',
                    '/pf/vendor/huge/tools/showCaptcha.php');
            $('#span-titulo-usuario')
                    .html(
                            '&nbsp;&nbsp;<i class="fa fa-users fa-lg"></i>&nbsp;&nbsp;Usu&aacute;rios e Grupos (Treinamento)');
            $('#tip-usuario-fornecedor')
                    .html(
                            '<i class="fa fa-info-circle"></i>&nbsp;Aluno/Instrutor em uma turma?');
            // padrao e nao altera por ser um usuario de
            // turma/treinamento
            $('#chk_id_fornecedor').prop('checked', true).prop(
                    'disabled', true);
            comboFornecedores('user', 0, '01',
                    formulario === 'turma' ? 1 : 0, false);
            /*
             * remonta as empresas
             */
            _41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265 === '41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265' ? f41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265()
                    : null;
        });

$('#user_email').on(
        'keyup',
        function () {
            $('#btn-check-email').html(
                    '<i class="fa fa-check"></i>&nbsp;Validar').removeClass(
                    'btn-success').addClass('btn-default');

        });

$('#chk-opcao-cpf').on(
        'click',
        function () {
            $('#frmiausu-opcao-identificador').val('0');
            $(this).hasClass('btn-default') ? $(this)
                    .removeClass('btn-default').addClass('btn-success') : null;
            $('#chk-opcao-outro').removeClass('btn-success').addClass(
                    'btn-default');
            $('#user_name').val('').get(0).focus();
            /*
             * um palavrao aqui ... !$!#$!@#$!$!@!#!$!@$!@%!$*%*%*%
             * 
             * $('#user_name').attr('data-mask', '00000000000');
             * $('#user_name').val('').removeAttr('pattern').attr('maxlength',
             * '11').get(0).focus();
             */
        });

$('#chk-opcao-outro').on(
        'click',
        function () {
            $('#frmiausu-opcao-identificador').val('1');
            $(this).hasClass('btn-default') ? $(this)
                    .removeClass('btn-default').addClass('btn-success') : null;
            $('#chk-opcao-cpf').removeClass('btn-success').addClass(
                    'btn-default');
            $('#user_name').val('').get(0).focus();
            /*
             * mais um palavrao aqui ... op87q242190rw82418142497812479812341234
             * 124!@#$!@#412
             * 
             * $('#user_name').val('').attr('pattern', '[a-zA-Z0-9._]{2,64}')
             * .attr('maxlength', '64').get(0).focus();
             * $('#user_name').removeAttr('data-mask');
             */
        });

$('#btn-check-name').on(
        'click',
        function () {
            if ($('#user_name').val() !== ''
                    && !($('#btn_adicionar_usuario').prop('disabled'))) {
                var o = $('#frmiausu-opcao-identificador').val();
                iWait('w_user_name', true);
                $.post(
                        '/pf/DIM.Gateway.php',
                        {
                            'a': 'n',
                            'u': $('#user_name').val(),
                            'o': o,
                            'arq': 81,
                            'tch': 1,
                            'sub': 4,
                            'dlg': 1
                        },
                function (data) {
                    if (data[0].existeDimension) {
                        $('#user_email').val('').prop(
                                'disabled', false).get(
                                0).focus();
                        $('#user_complete_name')
                                .val(
                                        data[0].user_complete_name)
                                .prop('disabled', false);
                        $('#btn-check-name')
                                .html(
                                        '<i class="fa fa-check-circle"></i>&nbsp;Validado')
                                .removeClass(
                                        'btn-default')
                                .addClass('btn-success');
                        $('#frmiausu_user_id').val(
                                data[0].user_id);
                        isIDExistente = 1;
                        isActive = data[0].user_active;
                        activationHash = data[0].user_activation_hash;
                    } else if (data[0].erro !== '') {
                        swal(
                                {
                                    title: "Alerta",
                                    text: data[0].erro,
                                    type: "error",
                                    html: true,
                                    confirmButtonText: "Obrigado, vou corrigir!"
                                },
                        function () {
                            $('#user_name')
                                    .val('')
                                    .get(0)
                                    .focus();
                            $('#btn-check-name')
                                    .html(
                                            '<i class="fa fa-check"></i>&nbsp;Validar')
                                    .removeClass(
                                            'btn-success')
                                    .addClass(
                                            'btn-default');
                            isIDExistente = 0;
                            isActive = 0;
                            activationHash = '';
                        });
                    } else {
                        $('#user_email').val('').prop(
                                'disabled', false).get(
                                0).focus();
                        $('#btn-check-name')
                                .html(
                                        '<i class="fa fa-check-circle"></i>&nbsp;Validado')
                                .removeClass(
                                        'btn-default')
                                .addClass('btn-success');
                        isIDExistente = 0;
                        isActive = 0;
                        activationHash = '';
                    }
                    iWait('w_user_name', false);
                }, 'json');
            } else if ($('#user_name').val() === '') {
                swal(
                        {
                            title: "Alerta",
                            text: "Por favor, preencha o ID &uacute;nico do usu&aacute;rio ou o CPF.",
                            type: "error",
                            html: true,
                            confirmButtonText: "Obrigado, vou verificar!"
                        }, function () {
                    $('#user_name').get(0).focus();
                });
                isIDExistente = 0;
                isActive = 0;
                activationHash = '';
            }
        });

$('#btn-check-email').on('click', function () {
    if ($('#user_email').val() !== ''
            && !($('#btn_adicionar_usuario').prop('disabled'))) {
        if (validaEmail($('#user_email').val(), $(this))) {
            comboRoles(0, 'role_id', 'w_grupo');
            $('#chk_id_fornecedor').prop('disabled',
                    formulario === 'turma' ? true : false)
                    .prop(
                            'checked',
                            formulario === 'turma' ? true
                            : false);
            $('#user_id_fornecedor').prop('disabled',
                    formulario === 'turma' ? false : true);
            /*
             * combo clientes apenas para empresas
             */
            formulario !== 'turma' ? comboCliente('user', 0,
                    '01', 0) : null;
            /*
             * habilita os demais botoes
             */
            $('#fmiausu-txt-captcha').prop('disabled', false);
            $('#btn_inserir_usuario').prop('disabled', false);
            $('#role_id').prop('disabled', false);
            $('#user_complete_name').prop('disabled', false)
                    .get(0).focus();
            $('#btn-check-email')
                    .html(
                            '<i class="fa fa-check-circle"></i>&nbsp;Validado')
                    .removeClass('btn-default').addClass(
                    'btn-success');
        }
    } else {
        swal({
            title: "Alerta",
            text: "Por favor, preencha o email do usu&aacute;rio para que o sistema possa validar.",
            type: "error",
            html: true,
            confirmButtonText: "Obrigado!"
        });
    }
});

$('#user_name').on(
        'keyup',
        function () {
            $('#btn-check-name').html(
                    '<i class="fa fa-check"></i>&nbsp;Validar').removeClass(
                    'btn-success').addClass('btn-default');
        });

$('#form_inserir_usuario').on('submit', function () {
    /*
     * confere o captcha
     */
    if ($('#fmiausu-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentes do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"
        });
        return false;
    }
    var userName = $('#user_name').val();
    var userEmail = $('#user_email').val();
    var userId = $('#frmiausu_user_id').val();
    var idRole = $('#role_id').val();
    var userCompleteName = $('#user_complete_name').val();
    var userIdFornecedor = $('#user_id_fornecedor').val();
    var userIdCliente = formulario !== 'turma' ? $('#user_id_cliente').val() : 0;
    var isValidarAdmGestor = $('#chk_is_validar_adm_gestor').prop('checked') ? 1 : 0;
    var opcaoIdentificador = $('#frmiausu-opcao-identificador').val();
    var msg;
    var isInserirContagemAuditoria = $('#is-inserir-contagem-auditoria').prop('checked') ? 1 : 0;
    if (idRole == 0) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; precisa associar o <strong>"
                    + (formulario === 'turma' ? (idRole == 14 ? "instrutor"
                            : "aluno")
                            : "usu&aacute;rio")
                    + "</strong> a um perfil.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"
        });
        return false;
    }
    /*
     * esqueceu de selecionar um fornecedor
     */
    if ($('#chk_id_fornecedor').prop('checked') && userIdFornecedor == 0) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; precisa associar o <strong>"
                    + (formulario === 'turma' ? (idRole == 14 ? "instrutor"
                            : "aluno")
                            : "usu&aacute;rio")
                    + "</strong> a um"
                    + (formulario === 'turma' ? "a" : "")
                    + (formulario === 'turma' ? " turma."
                            : " perfil."),
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"
        });
        return false;
    }
    $.post('/pf/DIM.Gateway.php',
            {
                'user_name': userName,
                'user_email': userEmail,
                'role_id': idRole,
                'user_complete_name': userCompleteName,
                'user_id_fornecedor': userIdFornecedor,
                'user_id_cliente': userIdCliente,
                'user_id': userId,
                'is_id_existente': isIDExistente, // para o id na empresa
                'is_validar_adm_gestor': isValidarAdmGestor,
                'opcao_identificador': opcaoIdentificador,
                '41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265': $('#41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265').val(),
                'user_active': isActive,
                'user_activation_hash': activationHash,
                'user_is_inserir_contagem_auditoria': isInserirContagemAuditoria,
                'arq': 68,
                'tch': 0,
                'sub': 4,
                'dlg': 1
            },
    function (data) {
        if (data[0].msg === 'erro') {
            swal({
                title: "Alerta",
                text: "Houve um erro durante a inser&ccedil;&atilde;o do usu&aacute;rio, por favor entre em contato com o Administrador do sistema.",
                type: "error",
                html: true,
                confirmButtonText: "Entendi, obrigado!"
            });
        } else {
            if (data[0].is_id_existente != 0) {
                msg = 'O '
                        + (tpoFornecedor ? 'aluno'
                                : 'usu&aacute;rio')
                        + ' <strong>'
                        + data[0].user_name
                        + '</strong> foi inserido com um perfil na sua empresa'
                        + (data[0].is_fornecedor ? ', para '
                                + (formulario === 'turma' ? 'a turma selecionada'
                                        : 'o fornecedor selecionado')
                                : '.');
            } else {
                msg = 'O '
                        + (tpoFornecedor ? 'aluno'
                                : 'usu&aacute;rio')
                        + ' <strong>'
                        + data[0].user_name
                        + '</strong> foi inserido com sucesso. As instru&ccedil;&otilde;es de ativa&ccedil;&atilde;o foram enviadas para o email informado.'
            }
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: msg,
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"
            });
            limpaCamposUsuario();
        }
    }, 'json');
    return false;
});

$('#chk_id_fornecedor').on('change', function () {
    if ($(this).prop('checked')) {
        $('#user_id_fornecedor').prop('disabled', false);
        comboFornecedores('user', 0, '01', formulario === 'turma' ? 1 : 0, false);
        /*
         * verifica o perfil e habilita o cliente tambem, apenas para
         * fiscal de contrato e/ou financeiro
         * tem que fazer isso tambem na selecao do perfil validador externo
         */
        if ($('#role_id').val() == 13 || $('#role_id').val() == 16) {
            $('#user_id_cliente').prop('disabled', false);
        }
    } else {
        $('#user_id_fornecedor').prop('disabled', true).empty().append('<option value="0">...</option>');
    }
});

$('#user_id_fornecedor').on('change', function () {
    $('#role_id').val(0);
    //chama a combo dos clientes apenas com o cliente do fornecedor
    $.post('/pf/DIM.Gateway.php', {
        'i': $('#user_id_fornecedor').val(),
        'arq': 105,
        'tch': 1,
        'sub': 0,
        'dlg': 1},
    function (data) {
        $('#user_id_cliente').empty().prop('disabled', true);
        for (x = 0; x < data.length; x++) {
            $('#user_id_cliente').append('<option value="' + data[x].id + '">' + data[x].sigla + ' - ' + data[x].descricao + '</option>');
        }
    }, 'json');
    //verificar, pois agora esta associado ao change das roles
    //if ($('#role_id').val() == 16) {
    //    comboCliente('user', 0, '01', $(this).val());
    //}
});

$('#role_id').on('change', function () {
    if ($(this).val() != 0) {
        iWait('w_grupo', true)
        $.post('/pf/DIM.Gateway.php', {
            'i': $(this).val(),
            'arq': 47,
            'tch': 1,
            'sub': -1,
            'dlg': 1},
        function (data) {
            $('#addPermission').empty();
            //ser nao houver um fornecedor selecionado habilita a combo dos clientes
            $('#user_id_cliente').prop('disabled', ($('#user_id_fornecedor').val() == 0 ? false : true));
            if (data.length == 0) {
                swal({
                    title: "Alerta",
                    text: "N&atilde;o h&aacute; permiss&otilde;es associadas a este grupo/perfil.",
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi, obrigado!"});
                $('#role_id').val(0);
                $('#chk_is_validar_adm_gestor').prop('disabled', true).prop('checked', false);
            } else {
                for (x = 0; x < data.length; x++) {
                    addLinhaPermission(
                            data[x].ID,
                            data[x].Description,
                            data[x]._Title);
                }
                /*
                 * 1  administrador 
                 * 2  validador_interno 
                 * 3  validador_externo 
                 * 4  auditor_interno 
                 * 5  auditor_externo 
                 * 6  gestor 
                 * 7  analista_metricas 
                 * 8  gerente_projetos 
                 * 9  gerente_conta 
                 * 10 diretor 
                 * 11 viewer 
                 * 13 financeiro 
                 * 14 instrutor 
                 * 15 comissionado 
                 * 16 fiscal_contrato
                 * 
                 * TODO: ver uma forma diferente
                 * de fazer
                 */
                if ($('#role_id').val() == 1 || $('#role_id').val() == 7) {
                    $('#chk_is_validar_adm_gestor').prop('disabled', (isValidarAdmGestor == 1 ? false : true));
                } else {
                    $('#chk_is_validar_adm_gestor').prop('disabled', true).prop('checked', false);
                }
                // verifica outas opcoes de perfil validador externo, auditor externo e financeiro o validador interno da empresa eh o validadorexterno do fornecedor
                if ($('#role_id').val() == 3 || $('#role_id').val() == 5 || $('#role_id').val() == 13 || $('#role_id').val() == 16) {
                    if (formulario === 'turma') {
                        swal({
                            title: "Aten&ccedil;&atilde;o",
                            html: true,
                            type: "warning",
                            text: "Estes perfis n&atilde;o podem ser associados a um aluno em turmas de treinamento.",
                            confirmButtonText: "Entendi, obrigado!"},
                        function () {
                            $('#role_id').val(0);
                            $('#addPermission').empty();
                        }
                        );
                    } else {
                        // situacao complexa aqui: quando tiver que ter um validador externo para um fornecedor
                        // selecionar o cliente do fornecedor e desabilitar combo cliente no caso de inserir validador externo de Fornecedor
                        // por conta da identificacao do cliente, os validadores internos da "empresa" terao que ter perfis de validadores externos nos fornecedores
                        // desabilitar a combo de selecao do cliente ou deixar apenas uma opcao
                        // $('#user_id_fornecedor').val(0).prop('disabled', true);
                        // $('#chk_id_fornecedor').prop('checked', false).prop('disabled', true);
                        // caso selecione um validador externo ou um fiscal de contrato este devera ser associado a um cliente
                        // 1) verifica se eh validador externos para um fornecedor
                        // 2) caso nao seja o procedimento segue normal
                        if ($('#role_id').val() == 3 || $('#role_id').val() == 16) {
                            //validador externo
                            if ($('#role_id').val() == 3) {
                                $.post('/pf/DIM.Gateway.php', {
                                    'i': $('#user_id_fornecedor').val(),
                                    'arq': 105,
                                    'tch': 1,
                                    'sub': 0,
                                    'dlg': 1},
                                function (data) {
                                    for (x = 0; x < data.length; x++) {
                                        $('#user_id_cliente').append('<option value="' + data[x].id + '">' + data[x].sigla + ' - ' + data[x].descricao + '</option>');
                                    }
                                }, 'json');
                            }
                            //fiscal de contrato
                            else if ($('#role_id').val() == 16) {
                                //um fiscal pode estar associado a um fornecedor e opcionalmente a um cliente
                                comboFornecedores('user', 0, '01', (formulario === 'turma' ? 1 : 0), false);
                                $('#chk_id_fornecedor').prop('disabled', false);
                            }
                        }
                    }
                }
                /*
                 * pelas caracteristicas o instrutor sera uma especie de gestor
                 * 
                 * else if ($('#role_id').val() == 14) { 
                 * 		if (formulario !== 'turma') { 
                 * 			swal({ 
                 * 				title:"Aten&ccedil;&atilde;o", 
                 * 				html: true, 
                 * 				type: "warning", 
                 * 				text: "Este perfil n&atilde;o pode ser associado a um usu&aacute;rio na empresa. Deve ser cadastrado apenas em suas turmas de treinamento.",
                 * 				confirmButtonText: "Entendi, obrigado!" }, function () {
                 * 					$('#role_id').val(0);
                 * 					$('#addPermission').empty();
                 * 			}); 
                 * 		} 
                 * 	}
                 */
                else {
                    $('#user_id_cliente').val(0).prop('disabled', true);
                    $('#chk_id_fornecedor').prop('disabled', false);
                }
            }
            iWait('w_grupo', false);
        }, 'json');
    } else {
        $('#addPermission').empty();
        $('#chk_is_validar_adm_gestor').prop('disabled', true).prop('checked', false);
    }
});
/**
 * 
 * @param Int i id da permission
 * @param String d descricao da permission
 * @param String ti titulo da permission
 * @returns null
 */
function addLinhaPermission(i, d, ti) {
    var t = $('#addPermission').get(0);
    var r = t.insertRow(-1);
    var c1 = r.insertCell(0);
    var c2 = r.insertCell(1);
    c1.setAttribute('align', 'center');
    c1.innerHTML = '<input type="checkbox" name="id_permission" id="id_permission_'
            + i
            + '" class="css-checkbox" value="'
            + i
            + '" checked disabled /><label for="id_permission_'
            + i
            + '" class="css-label-check">&nbsp;</label>';
    c2.innerHTML = '<strong>' + ti + '</strong>&nbsp;' + d;
}

$('#btn_fechar_usuario').on('click', function () {
    limpaCamposUsuario();
});

$('#link_fechar_usuario').on('click', function () {
    limpaCamposUsuario();
});

function limpaCamposUsuario() {
    $('#user_name').val('').prop('disabled', false).get(0).focus();
    $('#chk-opcao-cpf').removeClass('btn-default').removeClass('btn-success').addClass('btn-success');
    $('#chk-opcao-outro').removeClass('btn-default').removeClass('btn-success').addClass('btn-default');
    $('#frmiausu-opcao-identificador').val('0');
    $('#user_email').val('').prop('disabled', true);
    $('#frmiau_user_id').val(0);
    $('#fmiausu-txt-captcha').val('').prop('disabled', true);
    $('#role_id').empty().prop('disabled', true).append('<option value="0">...</option>');
    formulario !== 'turma' ? $('#user_id_fornecedor').empty().prop('disabled', true).append('<option value="0">...</option>') : $('#user_id_fornecedor').prop('disabled', true);
    formulario !== 'turma' ? $('#chk_id_fornecedor').prop('disabled', true).prop('checked', false) : null;
    $('#user_id_cliente').empty().prop('disabled', true).append('<option value="0">...</option>');
    $('#user_complete_name').val('').prop('disabled', true);
    $('#addPermission').empty();
    $('#fmiausu-i-captcha').removeClass('fa-check-circle').addClass('fa-dot-circle-o');
    $('#chk_is_validar_adm_gestor').prop('checked', false).prop('disabled', true);
    $('#btn-check-name').html('<i class="fa fa-check"></i>&nbsp;Validar').removeClass('btn-success').addClass('btn-default');
    $('#btn-check-email').html('<i class="fa fa-check"></i>&nbsp;Validar').removeClass('btn-success').addClass('btn-default');
    if (tpoFornecedor) {
        $('#span-titulo-usuario').html('&nbsp;&nbsp;<i class="fa fa-users fa-lg"></i>&nbsp;&nbsp;Usu&aacute;rios e Grupos (Treinamento)');
        $('#tip-usuario-fornecedor').html('<i class="fa fa-info-circle"></i>&nbsp;Aluno de uma turma de treinamento?');
    } else {
        $('#span-titulo-usuario').html('&nbsp;&nbsp;<i class="fa fa-users fa-lg"></i>&nbsp;&nbsp;Usu&aacute;rios e Grupos');
    }
    $('#is-inserir-contagem-auditoria').prop('checked', false);
    isEmailExistente = 0;
    isIDExistente = 0;
    isActive = 0;
    activationHash = '';
    formulario = formulario !== 'turma' ? '' : 'turma';
}
