$('#contato-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#contato-i-captcha'), false);
});

$('#link-modal-contato').on('click', function(){
	refreshCaptcha($('#contato-img-captcha'), $('#contato-txt-captcha'));	
})

$('#form-contato').on('submit', function () {
    var n = $('#ctn').val();
    var e = $('#cte').val();
    var t = $('#ctt').val();
    var m = $('#ctm').val();
    /*
     * evita duplo post
     */
    $('#btn-enviar').prop('disabled', true);
    $('#i-btn-enviar').removeClass('fa-send').addClass('fa-refresh').addClass('fa-spin');
    //
    $.post('/pf/DIM.Gateway.php', {'n': n, 'e': e, 't': t, 'm': m, 'arq': 52, 'tch': 0, 'sub': 2, 'dlg': 0}, function (data) {
        if (data) {
            $('#ctn').val('');
            $('#cte').val('');
            $('#ctt').val('');
            $('#ctm').val('');
            $('#btn-enviar').prop('disabled', false);
            $('#i-btn-enviar').removeClass('fa-refresh').removeClass('fa-spin').addClass('fa-send');
            $('#contato-txt-captcha').val('');
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: "Sua mensagem foi enviada com sucesso (uma c&oacute;pia desta mensagem foi enviada para o seu email).<br /><br />Em at&eacute; 24 horas entraremos em contato.",
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
            $('#contato-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
        }
    }, 'json');
    return false;
});
/*
 * formatacao dos telefones para um digito a mais
 */
var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
}, spOptions = {onKeyPress: function (val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    }};

$('.sp_celphones').mask(SPMaskBehavior, spOptions);

