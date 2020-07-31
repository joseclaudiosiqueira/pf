String.prototype.capitalizeFirstLetter = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
};
String.prototype.dScr = function () {
    return this.replace(/[a-zA-Z]/g, function (c) {
        return String.fromCharCode((c <= "Z" ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26);
    });
};
String.prototype.extenso = function (c) {
    // + Carlos R. L. Rodrigues
    // @ http://jsfromhell.com/string/extenso [rev. #3]
    var ex = [
        ["zero", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove"],
        ["dez", "vinte", "trinta", "quarenta", "cinqüenta", "sessenta", "setenta", "oitenta", "noventa"],
        ["cem", "cento", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"],
        ["mil", "milhão", "bilhão", "trilhão", "quadrilhão", "quintilhão", "sextilhão", "setilhão", "octilhão", "nonilhão", "decilhão", "undecilhão", "dodecilhão", "tredecilhão", "quatrodecilhão", "quindecilhão", "sedecilhão", "septendecilhão", "octencilhão", "nonencilhão"]
    ];
    var a, n, v, i, n = this.replace(c ? /[^,\d]/g : /\D/g, "").split(","), e = " e ", $ = "real", d = "centavo", sl;
    for (var f = n.length - 1, l, j = -1, r = [], s = [], t = ""; ++j <= f; s = []) {
        j && (n[j] = (("." + n[j]) * 1).toFixed(2).slice(2));
        if (!(a = (v = n[j]).slice((l = v.length) % 3).match(/\d{3}/g), v = l % 3 ? [v.slice(0, l % 3)] : [], v = a ? v.concat(a) : v).length)
            continue;
        for (a = -1, l = v.length; ++a < l; t = "") {
            if (!(i = v[a] * 1))
                continue;
            i % 100 < 20 && (t += ex[0][i % 100]) ||
                    i % 100 + 1 && (t += ex[1][(i % 100 / 10 >> 0) - 1] + (i % 10 ? e + ex[0][i % 10] : ""));
            s.push((i < 100 ? t : !(i % 100) ? ex[2][i == 100 ? 0 : i / 100 >> 0] : (ex[2][i / 100 >> 0] + e + t)) +
                    ((t = l - a - 2) > -1 ? " " + (i > 1 && t > 0 ? ex[3][t].replace("ão", "ões") : ex[3][t]) : ""));
        }
        a = ((sl = s.length) > 1 ? (a = s.pop(), s.join(" ") + e + a) : s.join("") || ((!j && (n[j + 1] * 1 > 0) || r.length) ? "" : ex[0][0]));
        a && r.push(a + (c ? (" " + (v.join("") * 1 > 1 ? j ? d + "s" : (/0{6,}$/.test(n[0]) ? "de " : "") + $.replace("l", "is") : j ? d : $)) : ""));
    }
    return r.join(e);
};
// remover caracteres html
String.prototype.stripHTMLSpace = function () {
    return this.replace(/<.*?>/g, ' ');
};
String.prototype.stripHTMLNoSpace = function () {
    return this.replace(/<.*?>/g, ' ');
};
String.prototype.isset = function () {
    var a = this,
            l = a.length,
            i = 0,
            undef;
    if (l === 0) {
        throw new Error('Empty isset');
    }
    while (i !== l) {
        if (a[i] === undef || a[i] === null) {
            return false;
        }
        i++;
    }
    return true;
};
/*
 * document.onkeypress = function (event) { event = (event || window.event); if
 * (event.keyCode == 123) { return false; } }; document.onmousedown = function
 * (event) { event = (event || window.event); if (event.keyCode == 123) { return
 * false; } }; document.onkeydown = function (event) { event = (event ||
 * window.event); if (event.keyCode == 123) { return false; } };
 */
function removerDuplicados(vetor) {
    var dicionario = {};
    for (var i = 0; i < vetor.length; i++) {
        dicionario[vetor[i] + ""] = true;
    }
    var novoVetor = [];
    for (var chave in dicionario) {
        novoVetor.push(chave);
    }
    return novoVetor;
}
function isDuplicada(t, s) {
    /*
     * 
     * @param {type} s - string com o nome da funcao @param {type} t - tipo ALI,
     * AIE, etc @returns {undefined}
     */
    // TODO: verificar possibilidade de alterar este numero
    var r = false;
    var funcao;
    $("#add" + t + " tr:lt(2000)").each(function () {
        this_row = $(this);
        funcao = $.trim(this_row.find('td:eq(2)').text());
        if (funcao.toLowerCase() === s.toLowerCase()) {
            r = true;
        }
    });
    return r;
}
/*
 * $(function () { $(this).bind('pbagrkgzrah'.dScr(), function (e) {
 * e.preventDefault(); }); });
 */
$(function () {
    $('[data-toggle="popover"]').popover({html: true});// , container: 'body'
});
$(function () {
    $('[data-toggle="tooltip"]').tooltip({html: true});
});
$(function () {
    var q = $('#zrah-nedhvib yv'.dScr()).size();
    if (q === 0) {
        $('#zrah-nedhvib'.dScr()).append('<li class="disabled"><a href="#">' + 'A&ngvyqr;b u&nnphgr; vgraf n rkvove...'.dScr() + '</a></li>');
    }
});
jQuery(function ($) {
    function tog(v) {
        return v ? 'addClass' : 'removeClass';
    }
    $(document).on('input', '.clearable', function () {
        $(this)[tog(this.value)]('x');
    }).on('mousemove', '.x', function (e) {
        $(this)[tog(this.offsetWidth - 24 < e.clientX - this.getBoundingClientRect().left)]('onX');
    }).on('touchstart click', '.onX', function (ev) {
        ev.preventDefault();
        $(this).removeClass('x onX').val('').change();
    });
});
function dump(arr, level) {
    /**
     * Function : dump() Arguments: The data - array,hash(associative
     * array),object The level - OPTIONAL Returns : The textual representation
     * of the array. This function was inspired by the print_r function of PHP.
     * This will accept some data as the argument and return a text that will be
     * a more readable version of the array/hash/object that is given. Docs:
     * http://www.openjs.com/scripts/others/dump_function_php_print_r.php
     */
    var dumped_text = "";
    if (!level)
        level = 0;
    // The padding given at the beginning of the line.
    var level_padding = "";
    for (var j = 0; j < level + 1; j++)
        level_padding += "    ";
    if (typeof (arr) === 'object') { // Array/Hashes/Objects
        for (var item in arr) {
            var value = arr[item];
            if (typeof (value) === 'object') { // If it is an array,
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += dump(value, level + 1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
            }
        }
    } else { // Stings/Chars/Numbers etc.
        dumped_text = "===>" + arr + "<===(" + typeof (arr) + ")";
    }
    return dumped_text;
}
function getConfigCocomo(v) {
    /*
     * 
     * @param {type} v - variavel @returns {float}
     */
    return Number(configCocomo[v]).toFixed(2);
}
/*
 * 
 * @param {type} date data Y-m-d @param {type} m true/false H:i:s @param {type}
 * isISO @returns {String}
 */
function formattedDate(date, m, isISO) {
    var dateISO;
    if (date.length > 0 && isISO) {
        dateISO = date.replace(' ', 'T');
    } else {
        dateISO = date;
    }
    var d = new Date(dateISO || Date.now()),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear(),
            hours = '' + d.getHours(),
            minutes = '' + d.getMinutes(),
            seconds = '' + d.getSeconds();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    if (hours.length < 2)
        hours = '0' + hours;
    if (minutes.length < 2)
        minutes = '0' + minutes;
    if (seconds.length < 2)
        seconds = '0' + seconds;
    return [day, month, year].join('/') + (m ? ' ' + [hours, minutes, seconds].join(':') : '');
}
/**
 * 
 * @param {type}
 *            t - tabela em upppercase
 * @returns {Number|qtdSE|qtdALI|qtdEE|qtdAR|qtdID|qtdAtual|qtdTE|qtdAIE|qtdDO}
 */
function getQtdAtual(t) {
    switch (t) {
        case arFn[0].dScr():
            qtdAtual = qtdALI;
            break;
        case arFn[1].dScr():
            qtdAtual = qtdAIE;
            break;
        case arFn[2].dScr():
            qtdAtual = qtdEE;
            break;
        case arFn[3].dScr():
            qtdAtual = qtdSE;
            break;
        case arFn[4].dScr():
            qtdAtual = qtdCE;
            break;
        case arFn[5].dScr():
            qtdAtual = qtdOU;
            break;
        case arFn[6].dScr():
            qtdAtual = qtdDO;
            break;
        case arFn[7].dScr():
            qtdAtual = qtdID;
            break;
        case arFn[8].dScr():
            qtdAtual = qtdTE;
            break;
        case arFn[9].dScr():
            qtdAtual = qtdAR;
            break;
    }
    return qtdAtual;
}
function incrementaLinha(t) {
    switch (t) {
        case arFn[0].dScr():
            qtdALI++;
            break;
        case arFn[1].dScr():
            qtdAIE++;
            break;
        case arFn[2].dScr():
            qtdEE++;
            break;
        case arFn[3].dScr():
            qtdSE++;
            break;
        case arFn[4].dScr():
            qtdCE++;
            break;
        case arFn[5].dScr():
            qtdOU++;
            break;
        case arFn[6].dScr():
            qtdDO++;
            break;
        case arFn[7].dScr():
            qtdID++;
            break;
        case arFn[8].dScr():
            qtdTE++;
            break;
        case arFn[9].dScr():
            qtdAR++;
            break;
    }
}
function decrementaLinha(tabela) {
    switch (tabela) {
        case arFn[0].dScr():
            qtdALI--;
            break;
        case arFn[1].dScr():
            qtdAIE--;
            break;
        case arFn[2].dScr():
            qtdEE--;
            break;
        case arFn[3].dScr():
            qtdSE--;
            break;
        case arFn[4].dScr():
            qtdCE--;
            break;
        case arFn[5].dScr():
            qtdOU--;
            break;
        case arFn[6].dScr():
            qtdDO--;
            break;
        case arFn[7].dScr():
            qtdID--;
            break;
        case arFn[8].dScr():
            qtdTE--;
            break;
        case arFn[9].dScr():
            qtdAR--;
            break;
    }
}
function getVar(q) {
    var url = window.location.href;
    var hash = {};
    if (url.indexOf('?') > -1) {
        var parametrosDaUrl = url.split("?")[1];
        var listaDeParametros = parametrosDaUrl.split("&");
        for (var i = 0; i < listaDeParametros.length; i++) {
            var parametro = listaDeParametros[i].split("=");
            var chave = parametro[0];
            var valor = parametro[1].replace('#', '');
            hash[chave] = valor;
        }
    }
    return hash[q];
}
function getVarRewrite() {
    var params = window.location.pathname.split('/').slice(1); // ["1",
    // "my-event"]
    var id = params[0];
    var name = params[1];
}
/*
 * @function divOperacao param: operacao (I - Inserir, A - Alterar e E-Excluir)
 */
function divOperacao(o) {
    var oper;
    switch (o) {
        case 'I':
            oper = '<div class="div-incluir">I</div>';
            break;
        case 'A':
            oper = '<div class="div-alterar">A</div>';
            break;
        case 'E':
            oper = '<div class="div-excluir">E</div>';
            break;
        case 'T':
            oper = '<div class="div-teste">T</div>';
            break;
        case 'N':
            oper = '<div class="div-nesma">N</div>';
            break;
    }
    return oper;
}
/**
 * 
 * @param {type}
 *            t - TD
 * @param {type}
 *            a - TR/AR
 * @param {type}
 *            c - Complexidade
 * @param {type}
 *            p - PFb
 * @param {type}
 *            d - Funcao (Dados/Transacao/Outros)
 * @param {type}
 *            m - Metodo
 * @returns {undefined}
 */
function camposMetodo(t, a, c, p, d, m) {
    $('#' + d + '_td').prop('readOnly', true);
    if (d === 'dados') {
        $('#' + d + '_tr').prop('readOnly', true);
        $('#' + d + '_tr').val(a);
    } else {
        $('#' + d + '_ar').prop('readOnly', true);
        $('#' + d + '_ar').val(a);
    }
    $('#' + d + '_pfb').prop('readOnly', true);
    $('#' + d + '_td').val(t);
    $('#' + d + '_pfb').val(p);
    /*
     * vai ate aqui, o resto eh pelo calculaLinhaPF
     */
    calculaLinhaPF(fAtual.toUpperCase(), d, $('#' + d + '_td'), d === 'dados' ? $('#' + d + '_tr') : $('#' + d + '_ar'));
    /*
     * $('#' + d + '_complexidade').val(c); verifica se ja existe um impacto
     * selecionado e calcula os pfa
     */
    if ($('#' + d + '_impacto').val() !== '0') {
        calculaPfa($('#' + d + '_impacto'), $('#' + d + '_pfb'), $('#' + d + '_pfa'), d);
    } else {
        var sel = $('#' + d + '_impacto');
        sel.val(0);
        $('#' + d + '_pfa').val('');
    }
}
/**
 * 
 * @param {type}
 *            a - Fator de impacto (Ajuste)
 * @param {type}
 *            b - PFb
 * @param {type}
 *            c - PFa
 * @param {type}
 *            t - funcao (transacao/dados/outros)
 * @param {type}
 *            f - formulario estendido
 * @returns {Boolean}
 */
function calculaPfa(a, b, c, t, f) {
    if (t === 'transacao') {
        if ($('#' + t + '_td').val() === '' || $('#' + t + '_ar').val() === '') {
            $('#' + t + '_impacto').val(0);
            $('#' + t + '_fd').val('0.00').prop('disabled', true);
            swal({
                title: "Alerta",
                text: "Cbe snibe, cerrapun cevzrveb bf pnzcbf Gvcb qr Qnqbf (GQ) r Nedhvibf Ersrerapvnqbf (NE)".dScr(),
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"});
            return false;
        }
    } else if (t === 'dados') {
        if ($('#' + t + '_td').val() === '' || $('#' + t + '_tr').val() === '') {
            $('#' + t + '_impacto').val(0);
            $('#' + t + '_fd').val('0.00').prop('disabled', true);
            swal({
                title: "Alerta",
                text: "Cbe snibe, cerrapun cevzrveb bf pnzcbf Gvcb qr Qnqbf (GQ) r Gvcbf qr Ertvfgebf (GE)!".dScr(),
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"});
            return false;
        }
    } else if (t === 'outros') {
        if ($("#" + t + "_qtd").val() === '') {
            swal({
                title: "Alerta",
                text: "Cbe snibe, cerrapun cevzrveb n dhnagvqnqr!".dScr(),
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"});
            $("#" + t + "_impacto").val(0);
            return false;
        }
    }
    if (a.val() !== null) {
        // define todas as variaveis necessarias para o calculo dos PFA
        var ft = 1;// parseFloat($('#valor_fator_tecnologia').html()).toFixed(3);
        // nao eh utilizado aqui
        var fd = parseFloat(Number($('#' + t + '_fd').val())).toFixed(2); // fator
        // documentacao
        var va = $(a).val().split(";"); // valor bruto de *_impacto
        var fi = va[1]; // fator de impacto
        var operador = va[4];// divisao ou multiplicacao
        var pfb = $(b).val();
        var totalPFATemp; // variavel temporaria
        var pfaFE;// formulario estendido
        var esforco = 0; // esforco das fases
        var tamanho = 0; //
        var fase = $('#' + t + '-fase').val(); // valor da fase ENG, DES, IMP,
        // etc
        var objPercentuais = new getPercentuais(fase);
        var isMudanca = $('#' + t + '-is-mudanca').prop('checked'); // verifica
        // se esta
        // on
        var pctTotal = objPercentuais.pctTotal / 100; // percentual total da
        // fase selecionada
        var pctFase = objPercentuais.pctFase / 100; // percentual da fase
        // selecionada
        var pctMudanca = $('#' + t + '-percentual-fase').val() === '' ? 0 : Number($('#' + t + '-percentual-fase').val()); // percentual
        // de
        // progresso
        // da
        // fase
        var totalPfa = 0;
        var qtd = $("#" + t + "_qtd").val(); // para OUTROS
        // calcula os pfa
        if (t !== 'outros') {
            // tem mudanca e o usuario ja selecionou uma fase mas ainda nao
            // digitou nada na fase vai para SISP
            // caso contrario vai para os calculos tipo RFB e SERPRO
            if (isMudanca) {
                if (fase === '0') {// o usuario acabou de mudar o check
                    totalPfa = calculaPFARoteiro(va[3], pfb, fi, fd);
                } else {
                    if (pctMudanca == 0) {// vai pelo fator original do
                        // roteiro
                        totalPfa = calculaPFARoteiro(va[3], pfb, fi, fd);
                    } else {
                        // calcula antes e deixa disponivel
                        esforco = (pctMudanca / 100) * pctFase;
                        tamanho = pctTotal + esforco;
                        if (va[3] === 'A') {// ajusta
                            totalPFATemp = pfb * tamanho * fi; // fi - o fator
                            // definido aqui
                            // e fixo em
                            // 0.75
                            totalPfa = parseFloat(totalPFATemp + totalPFATemp * fd).toFixed(4);
                        } else {// fator fixo
                            totalPFATemp = tamanho * fi; // fi - o fator
                            // definido aqui e
                            // fixo em 0.75
                            totalPfa = parseFloat(totalPFATemp + totalPFATemp * fd).toFixed(4);
                        }
                    }
                }
            } else {
                totalPfa = calculaPFARoteiro(va[3], pfb, fi, fd);
            }
            // verifica se tem valor em formulario estendido
            if (Number(f) > 0) {
                fe = fi * f;
                $(c).val(parseFloat(Number(totalPfa) + Number(fe)).toFixed(4));
            }
            else {
                if (t === 'transacao') {
                    $(c).val(parseFloat(totalPfa * ft).toFixed(4));
                }
                else {
                    $(c).val(totalPfa);
                }
            }
        } else {
            totalPFATemp = Number(operador) === 0 ? qtd * fi : qtd / fi;
            $(c).val(parseFloat(totalPFATemp).toFixed(4));
        }
    }
}
/**
 * 
 * @param {type}
 *            tipoFator - A Ajuste, F Fixo
 * @param {type}
 *            pfb - Pontos de funcao brutos
 * @param {type}
 *            fi - Fator de Impacto
 * @param {type}
 *            fd - Fator Documentacao
 * @returns {unresolved}
 */
function calculaPFARoteiro(tipoFator, pfb, fi, fd) {
    // fi - o fator nestes casos eh fixo em 0.75
    if (tipoFator === 'A') {// A - Ajusta pelo Fator de Impacto
        totalPFATemp = parseFloat(pfb).toFixed(4) * fi;
        totalPFA = parseFloat(totalPFATemp + totalPFATemp * fd).toFixed(4);
    } else if (tipoFator === 'F') {// F - Valor fixo dos PFA
        totalPFATemp = parseFloat(fi).toFixed(3);
        totalPFA = parseFloat(totalPFATemp + totalPFATemp * fd).toFixed(4);
    }
    return totalPFA;
}
/**
 * Excluir uma linha das tabelas
 * 
 * @example excluirLinha(id, tb, node)
 * 
 * @id {Number} id da funcao a ser excluida
 * @tb {Number} tabela ALI, AIE, etc.
 * @node {Number} Index (row) da tabela
 * @pfa {Number} Pontos de Funcao Ajustados
 * @pfb {Number} Pontos de Funcao Brutos
 */
function excluirLinha(id, tb, node, pfa, pfb, isCrud) {
    /*
     * verifica se pode excluir
     */
    if (isAutorizadoAlterar) {
        // nao pode excluir independente a funcao que foi inserida por um crud,
        // o default eh poder excluir uma a uma
        if (Number(isCrud) == 1 && (tb === 'EE' || tb === 'CE') && Number(contagemConfig.is_excluir_crud_independente) == 0) {
            swal({
                title: "Alerta",
                text: "A fun&ccedil;&atilde;o foi inserida automaticamente pela op&ccedil;&atilde;o de gerar CRUD. N&atilde;o &eacute; poss&iacute;vel " +
                        "excluir por aqui devido &agrave;s configura&ccedil;&otilde;es do sistema. " +
                        "Exclua a fun&ccedil;&atilde;o ALI principal que gerou a inclus&atilde;o, lembre-se que a a&ccedil;&atilde;o tamb&eacute;m " +
                        "excluir&aacute; as tr&ecirc;s EEs e a CE geradas automaticamente.",
                type: "error",
                html: true,
                confirmButtonText: "Entendi, obrigado!"}, function () {
                return false;
            });
        } else {
            // variaveis para conferencia de baseline
            operacao = $('#oper_' + tb + '_' + node).children('div').html();
            validada = $('#cell1_' + tb + '_' + id).hasClass('validada');
            // regras para exclusao
            // projeto, inclusao e validada na baseline
            if (abAtual == 2 && operacao === 'I' && validada) {
                swal({
                    title: "Alerta",
                    text: "A fun&ccedil;&atilde;o foi inserida por esta contagem de projeto, entretanto j&aacute; " +
                            "foi validada na Baseline, desta forma n&atilde;o &eacute; poss&iacute;vel excluir por aqui. " +
                            "Caso deseje crie uma nova contagem para executar a opera&ccedil;&atilde;o.",
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi, obrigado!"}, function () {
                    return false;
                });
            }
            // abAtual == 3 - Baseline, abAtual == 4 - Licitacao
            else if (abAtual == 3 || abAtual == 4) {
                $.post('/pf/DIM.Gateway.php', {
                    'i': id,
                    't': tb,
                    'isCrud': isCrud,
                    'arq': 45,
                    'tch': 1,
                    'sub': -1,
                    'dlg': 1}, function (data) {
                    if (Number(data.id_gerador) > 0) {
                        swal({
                            title: "Alerta",
                            text: "Esta fun&ccedil;&atilde;o foi inserida por uma contagem de projeto, desta forma n&atilde;o &eacute; poss&iacute;vel excluir por aqui.",
                            type: "error",
                            html: true,
                            confirmButtonText: "Entendi, obrigado!"}, function () {
                            return false;
                        });
                    }
                    /*
                     * verificar se existe alguma funcao que referencia o
                     * arquivo
                     */
                    else {
                        swal({
                            title: "Tem certeza?",
                            text: "Ap&oacute;s a exclus&atilde;o da linha as informa&ccedil;&otilde;es n&atilde;o poder&atilde;o ser recuperadas. " +
                                    (tb === 'ALI' && Number(isCrud) == 1 ? "As fun&ccedil;&otilde;es de transa&ccedil;&atilde;o EE e CE inseridas " +
                                            "automaticamente por CRUD tamb&eacute;m ser&atilde;o exclu&iacute;das." : ""),
                            type: "warning",
                            html: true,
                            showCancelButton: true,
                            cancelButtonText: "Cancelar",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Sim",
                            closeOnConfirm: true
                        }, function () {
                            var t = document.getElementById('fix' + tb);
                            $.post('/pf/DIM.Gateway.php', {
                                'id': id,
                                'tabela': tb,
                                'isCrud': isCrud,
                                'abrangencia_atual': abAtual,
                                'operacao': operacao,
                                'arq': 16,
                                'tch': 0,
                                'sub': -1,
                                'dlg': 1},
                            function (data) {
                                if (Number(data[0].isExcluida == 1)) {
                                    t.deleteRow(node);
                                    recalculaIndicesSEQ(tb);
                                    recalculaEstatisticas(Number(pfa), Number(pfb), tb, 'excluir', 0, 0, true); // o
                                    // ultimo
                                    // parametro
                                    // desenha
                                    // o
                                    // grafico
                                    // de
                                    // entregas
                                    decrementaLinha(tb);
                                    if (tb === 'ALI' && Number(isCrud) == 1) {
                                        zeraTabelaEstatisticas();
                                        isSalvarEstatisticas = false;
                                        listaFuncao(idContagem, 'ee', $('#addEE').get(0), 'transacao', 'id', 'ASC', true);
                                        listaFuncao(idContagem, 'ce', $('#addCE').get(0), 'transacao', 'id', 'ASC', true);
                                        isSalvarEstatisticas = true;
                                    }
                                    // verifica se nao ha mais funcoes e
                                    // habilita novamente a combobox de
                                    // alteracao de baseline
                                    if (qtdAIE == 1 || qtdALI == 1 || qtdEE == 1 || qtdSE == 1 || qtdCE == 1 || qtdOU == 1) {
                                        $('#contagem_id_baseline').prop('disabled', false);
                                    }
                                } else {
                                    swal({
                                        title: "Alerta",
                                        text: _ERR_EXCLUSAO,
                                        type: "error",
                                        html: true,
                                        confirmButtonText: "Entendi!"});
                                }
                            }, "json");
                        });
                    }
                }, 'json');
            }
            // contagem normal abAtual == 1 ou contagem de projeto abAtual == 2
            else {
                // passou aqui exclui a linha sem maiores perguntas
                swal({
                    title: "Tem certeza?",
                    text: "Ap&oacute;s a exclus&atilde;o da linha as informa&ccedil;&otilde;es n&atilde;o poder&atilde;o ser recuperadas. " +
                            (abAtual == 2 && operacao === 'I' && !validada ? "<strong>ATEN&Ccedil;&Atilde;O</strong>: esta fun&ccedil;&atilde;o pertence a uma Baseline e ser&aacute; exclu&iacute;da, j&aacute; que n&atilde;o havia sido validada. " +
                                    (Number(isCrud) == 1 && tb === 'ALI' ? "Todas as fun&ccedil;&otilde;es de Transa&ccedil;&atilde;o EE e CE, inseridas automaticamente como CRUD, tamb&eacute;m ser&atilde;o exclu&iacute;das." : "") : ""),
                    type: "warning",
                    html: true,
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim",
                    closeOnConfirm: true
                }, function () {
                    var t = document.getElementById('fix' + tb);
                    $.post('/pf/DIM.Gateway.php', {
                        'id': id,
                        'tabela': tb,
                        'isCrud': isCrud,
                        'abrangencia_atual': abAtual,
                        'operacao': operacao,
                        'arq': 16,
                        'tch': 0,
                        'sub': -1,
                        'dlg': 1},
                    function (data) {
                        if (Number(data[0].isExcluida == 1)) {
                            t.deleteRow(node);
                            recalculaEstatisticas(Number(pfa), Number(pfb), tb, 'excluir', 0, 0, true); // o
                            // ultimo
                            // parametro
                            // desenha
                            // o
                            // grafico
                            // de
                            // entregas
                            decrementaLinha(tb);
                            if (tb === 'ALI' && Number(isCrud) == 1) {
                                zeraTabelaEstatisticas();
                                isSalvarEstatisticas = false;
                                listaFuncao(idContagem, 'ee', $('#addEE').get(0), 'transacao', 'id', 'ASC', true);
                                listaFuncao(idContagem, 'ce', $('#addCE').get(0), 'transacao', 'id', 'ASC', true);
                                isSalvarEstatisticas = true;
                            }
                            recalculaIndicesSEQ(tb);
                            // verifica se nao ha mais funcoes e habilita
                            // novamente a combobox de alteracao de baseline
                            if (qtdAIE == 1 || qtdALI == 1 || qtdEE == 1 || qtdSE == 1 || qtdCE == 1 || qtdOU == 1) {
                                $('#contagem_id_baseline').prop('disabled', false);
                            }
                        } else {
                            swal({
                                title: "Alerta",
                                text: _ERR_EXCLUSAO,
                                type: "error",
                                html: true,
                                confirmButtonText: "Entendi!"});
                        }
                    }, "json");
                });
            }
        }
    } else {
        naoAutorizado('excluir', null);
    }
}
/*
 * Funcao utilizada para concluir a revisao de uma linha @param {INT} i = id da
 * funcao @param {String} t = tabela ali, aie, ee, etc.
 */
function concluirRevisaoLinha(t, i) {
    $.post('/pf/DIM.Gateway.php', {'i': i, 't': t.toLowerCase(), 'arq': 57, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        if (data.situacao == 4) {
            // adiciona/remove no array
            arrayValida(i, t);
            swal({
                title: "Alerta",
                text: "Esta linha j&aacute; est&aacute; revisada.",
                type: "warning",
                closeOnConfirm: true,
                html: true
            });
        } else {
            swal({
                title: "Tem certeza que deseja finalizar a revis&atilde;o desta linha?",
                text: "Ap&oacute;s isso as informa&ccedil;&otilde;es ser&atilde;o gravadas e a a&ccedil;&atilde;o n&atilde;o poder&aacute; ser desfeita!",
                type: "warning",
                html: true,
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#5cb85c",
                confirmButtonText: "Sim",
                closeOnConfirm: true
            },
            function (isConfirm) {
                isConfirm ?
                        $.post('/pf/DIM.Gateway.php', {'i': i, 't': t, 'arq': 14, 'tch': 0, 'sub': -1, 'dlg': 1}, function (data) {
                            setSituacao(4, 'cell1_' + t + '_' + i); // cell1_ALI_212
                        }, 'json') : null;
            });
        }
    }, 'json');
}
function recalculaIndicesSEQ(b) {
    var index = 1;
    $(".div-seq-" + b).each(function () {
        $(this).html(index);
        index++;
    });
}
/**
 * 
 * @param {type}
 *            pfa - pontos de funcao ajustados
 * @param {type}
 *            pfb - pontos de funcao brutos
 * @param {type}
 *            tb - tabela
 * @param {type}
 *            ac - acao
 * @param {type}
 *            pfan - pfa anterior
 * @param {type}
 *            pfbn - pfb anterior
 * @param {type}
 *            fe - PFs do formulario estendido
 * @returns {undefined}
 */
function recalculaEstatisticas(pfa, pfb, tb, ac, pfan, pfbn, isGrafico, fe) {
    var vPfa = Number(pfa) + (fe > 0 ? fe : 0);
    var vPfb = Number(pfb);
    var vPfan = Number(pfan);
    var vPfbn = Number(pfbn);
    var qtdAtual = Number(getQtdAtual(tb)); // quantidade atual na tabela
    // estatisticas
    var pfaAtual = Number($('#pfa' + tb).html()); // pfa atual na tabela
    // estatisticas
    var pfbAtual;
    if (tb !== 'OU') {
        pfbAtual = Number($('#pfb' + tb).html()); // pfb atual na tabela
        // estatisticas
    }
    var pfaEstat = Number();
    var pfbEstat = Number();
    var desEstat = Number();
    var totPfa = Number();
    var totPfb = Number();
    // INCLUIR
    if (ac === 'incluir') {
        pfaEstat = pfaAtual + vPfa;
        if (tb !== 'OU') {
            pfbEstat = pfbAtual + vPfb;
        }
        $('#qtd' + tb).html(qtdAtual - 1);
        $('#pfa' + tb).html(pfaEstat.toFixed(4));
        totPfa = $('#pfa' + tb).html();
    }
    // ALTERAR
    else if (ac === 'alterar') {
        pfaEstat = pfaAtual - vPfan;
        pfaEstat += vPfa;
        if (tb !== 'OU') {
            pfbEstat = pfbAtual - vPfbn;
            pfbEstat += vPfb;
        }
        $('#pfa' + tb).html(pfaEstat.toFixed(4));
        totPfa = $('#pfa' + tb).html();
    }
    // EXCLUIR
    else if (ac === 'excluir') {
        pfaEstat = pfaAtual - vPfa;
        if (tb !== 'OU') {
            pfbEstat = pfbAtual - vPfb;
        }
        $('#qtd' + tb).html(qtdAtual - 2);
        $('#pfa' + tb).html(pfaEstat.toFixed(4));
        totPfa = $('#pfa' + tb).html();
    }
    /*
     * para todos exceto Outras funcionalidades
     */
    if (tb !== 'OU') {
        if (Number(getQtdAtual(tb)) > 0) {
            $('#pfb' + tb).html(pfbEstat.toFixed(4));
            totPfb = $('#pfb' + tb).html();
            desEstat = (100 - ((totPfa / totPfb) * 100));
            desEstat = +desEstat || 0; // para evitar o NaN
            $('#des' + tb).html(txtDesvio(desEstat));
        }
    }
    totalPfa = new getTotalFuncoes('pfa');
    totalPfb = new getTotalFuncoes('pfb');
    var desvioTotal = (100 - ((totalPfa.total / totalPfb.total) * 100));
    desvioTotal = +desvioTotal || 0;
    $("#desvioTotal").html(txtDesvio(desvioTotal));
    $("#totPfa").html(totalPfa.total.toFixed(4));
    $("#totPfb").html(totalPfb.total.toFixed(4));
    // calcula as fases e segue ate salvar as estatisticas
    isSalvarEstatisticas ? calculaFases(isGrafico) : null;
}

function zeraTabelaEstatisticas() {
    qtdEE = 1;
    qtdCE = 1;
    var pfbEE = $('#pfbEE').html();
    var pfaEE = $('#pfaEE').html();
    var pfbCE = $('#pfbCE').html();
    var pfaCE = $('#pfaCE').html();
    var totPfb = $('#totPfb').html();
    var totPfa = $('#totPfa').html();
    // atualiza os spans - quantidade
    $('#qtdEE').html('0');
    $('#qtdCE').html('0');
    // atualiza os spans - total pfb
    $('#pfbEE').html('0.0000');
    $('#pfbCE').html('0.0000');
    // atualiza os spans - total pfa
    $('#pfaEE').html('0.0000');
    $('#pfaCE').html('0.0000');
    // atualiza os spans - desvio
    $('#desEE').html(txtDesvio(0));
    $('#desCE').html(txtDesvio(0));
    // atualiza todos os spans e recalcula as estatistica
    $('#totPfb').html((parseInt(totPfb) - (parseInt(pfbEE) + parseInt(pfbCE))).toFixed(4));
    $('#totPfb').html((parseInt(totPfa) - (parseInt(pfaEE) + parseInt(pfaCE))).toFixed(4));
}

/*
 * apos a exclusao das linhas inseridas por um crud o sistema atualiza as
 * estatisticas de forma global
 */
function atualizaEstatisticas() {
    zeraTabelaEstatisticas();
    var tbl = ['ALI', 'AIE', 'EE', 'SE', 'CE', 'EE', 'OU'];
    var objPF = {
        "ALIPFa": Number(0),
        "ALIPFb": Number(0),
        "ALIDes": Number(0),
        "ALIQtd": Number(0),
        "AIEPFa": Number(0),
        "AIEPFb": Number(0),
        "AIEDes": Number(0),
        "AIEQtd": Number(0),
        "EEPFa": Number(0),
        "EEPFb": Number(0),
        "EEDes": Number(0),
        "EEQtd": Number(0),
        "SEPFa": Number(0),
        "SEPFb": Number(0),
        "SEDes": Number(0),
        "SEQtd": Number(0),
        "CEPFa": Number(0),
        "CEPFb": Number(0),
        "CEDes": Number(0),
        "CEQtd": Number(0),
        "OUPFa": Number(0),
        "OUPFb": Number(0),
        "OUDes": Number(0),
        "OUQtd": Number(0),
        "TotalPFa": Number(0),
        "TotalPFb": Number(0)
    };
    for (x = 0; x < tbl.length; x++) {
        $("#add" + tbl[x] + " tr:lt(2000)").each(function () {
            var this_row = $(this);
            var pfb = $.trim(this_row.find('td:eq(' + tbl[x] === 'OU' ? 4 : 6 + ')').text());
            var pfa = $.trim(this_row.find('td:eq(' + tbl[x] === 'OU' ? 4 : 8 + ')').text());
            objPF.TotalPFb = Number(objPF.TotalPFb) + Number(pfb);
            objPF.TotalPFa = Number(objPF.TotalPFa) + Number(pfb);
            switch (tbl) {
                case 'ALI':
                    objPF.ALIPFb = Number(objPF.ALIPFb) + Number(pfb);
                    objPF.ALIPFa = Number(objPF.ALIPFb) + Number(pfa);
                    objPF.ALIQtd = Number(objPF.ALIQtd) + Number(1);
                    break;
                case 'AIE':
                    objPF.AIEPFb = Number(objPF.AIEPFb) + Number(pfb);
                    objPF.AIEPFa = Number(objPF.AIEPFb) + Number(pfa);
                    objPF.AIEQtd = Number(objPF.AIEQtd) + Number(1);
                    break;
                case 'EE':
                    objPF.EEPFb = Number(objPF.EEPFb) + Number(pfb);
                    objPF.EEPFa = Number(objPF.EEPFb) + Number(pfa);
                    objPF.EEQtd = Number(objPF.EEQtd) + Number(1);
                    break;
                case 'SE':
                    objPF.SEPFb = Number(objPF.SEPFb) + Number(pfb);
                    objPF.SEPFa = Number(objPF.SEPFb) + Number(pfa);
                    objPF.SEQtd = Number(objPF.SEQtd) + Number(1);
                    break;
                case 'CE':
                    objPF.CEPFb = Number(objPF.CEPFb) + Number(pfb);
                    objPF.CEPFa = Number(objPF.CEPFb) + Number(pfa);
                    objPF.CEQtd = Number(objPF.CEQtd) + Number(1);
                    break;
                case 'OU':
                    objPF.OUPFb = Number(objPF.OUPFb) + Number(pfb);
                    objPF.OUPFa = Number(objPF.OUPFb) + Number(pfa);
                    objPF.OUQtd = Number(objPF.OUQtd) + Number(1);
                    break;
            }
        });
    }
    // calcula os desvios
    objPF.ALIDes = +(100 - ((objPF.ALIPFa / objPF.ALIPFb) * 100)) || 0;
    objPF.AIEDes = +(100 - ((objPF.AIEPFa / objPF.AIEPFb) * 100)) || 0;
    objPF.EEDes = +(100 - ((objPF.EEPFa / objPF.EEPFb) * 100)) || 0;
    objPF.SEDes = +(100 - ((objPF.SEPFa / objPF.SEPFb) * 100)) || 0;
    objPF.CEDes = +(100 - ((objPF.CEPFa / objPF.CEPFb) * 100)) || 0;
    // atualiza os spans - quantidade
    $('#qtdALI').html(objPF.ALIQtd);
    $('#qtdAIE').html(objPF.AIEQtd);
    $('#qtdEE').html(objPF.EEQtd);
    $('#qtdSE').html(objPF.SEQtd);
    $('#qtdCE').html(objPF.CEQtd);
    $('#qtdOU').html(objPF.OUQtd);
    // atualiza os spans - total pfb
    $('#pfbALI').html(objPF.ALIPFb.toFixed(4));
    $('#pfbAIE').html(objPF.AIEPFb.toFixed(4));
    $('#pfbEE').html(objPF.EEPFb.toFixed(4));
    $('#pfbSE').html(objPF.SEPFb.toFixed(4));
    $('#pfbCE').html(objPF.CEPFb.toFixed(4));
    // atualiza os spans - total pfa
    $('#pfaALI').html(objPF.ALIPFa.toFixed(4));
    $('#pfaAIE').html(objPF.AIEPFa.toFixed(4));
    $('#pfaEE').html(objPF.EEPFa.toFixed(4));
    $('#pfaSE').html(objPF.SEPFa.toFixed(4));
    $('#pfaCE').html(objPF.CEPFa.toFixed(4));
    $('#pfaOU').html(objPF.OUPFa.toFixed(4));
    // atualiza os spans - desvio
    $('#desALI').html(objPF.ALIDes.toFixed(4));
    $('#desAIE').html(objPF.AIEDes.toFixed(4));
    $('#desEE').html(objPF.EEDes.toFixed(4));
    $('#desSE').html(objPF.SEDes.toFixed(4));
    $('#desCE').html(objPF.CEDes.toFixed(4));
    // atualiza todos os spans e recalcula as estatisticas
    var desvioTotal = +(100 - ((objPF.TotalPFa / objPF.TotalPFb) * 100)) || 0;
    $("#desvioTotal").html(txtDesvio(desvioTotal));
    $("#totPfa").html(objPF.TotalPFa.toFixed(4));
    $("#totPfb").html(objPF.TotalPFb.toFixed(4));
    // calcula as fases e segue ate salvar as estatisticas
    isSalvarEstatisticas ? calculaFases(true) : null;
}

function txtDesvio(d) {
    // d = desvio
    var txt;
    if (d > 0) {
        txt = '<i class="fa fa-minus-circle"></i>&nbsp;&nbsp;&nbsp;' + d.toFixed(4);
    } else if (d < 0) {
        txt = '<i class="fa fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;' + d.toFixed(4);
    } else {
        txt = '<i class="fa fa-circle"></i>&nbsp;&nbsp;&nbsp;' + d.toFixed(4);
    }
    return txt;
}

/**
 * 
 * @param {type}
 *            d id do campo ex. w_id_cliente, w_id_linguagem, etc
 * @param {type}
 *            r resposta true ou false (true adicionar e false remover)
 * @returns {undefined}
 */
function iWait(d, r) {
    if (r) {
        $('#' + d).removeClass('fa fa-dot-circle-o');
        $('#' + d).addClass('fa fa-refresh fa-spin');
    } else {
        $('#' + d).removeClass('fa fa-refresh fa-spin');
        $('#' + d).addClass('fa fa-dot-circle-o');
    }
}

/**
 * 
 * @param {type}
 *            d class
 * @param {type}
 *            r true ou false
 * @param {type}
 *            c classe original
 * @returns {undefined}
 */
function iWaitMenuContagem(d, r, c) {
    if (r) {
        $('.' + d).removeClass(c);
        $('.' + d).addClass('fa fa-refresh fa-spin');
    } else {
        $('.' + d).removeClass('fa fa-refresh fa-spin');
        $('.' + d).addClass(c);
    }
}

/**
 * 
 * @param {type}
 *            d class
 * @param {type}
 *            r true ou false
 * @param {type}
 *            c classe original
 * @returns {undefined}
 */
function iWaitEstatisticas(d, r, c) {
    if (r) {
        $('.' + d).removeClass(c);
        $('.' + d).addClass('fa fa-refresh fa-spin fa-lg');
    } else {
        $('.' + d).removeClass('fa fa-refresh fa-spin fa-lg');
        $('.' + d).addClass(c);
    }
}
/*
 * 
 * @param {type} v - valor que a combo podera ter @param {type} c - id da combo
 * @param {type} w - id do icone de wait @returns {undefined}
 */
function comboRoles(v, c, w) {
    /*
     * leitura das roles no combo role_ids
     */
    iWait(w, true);
    $.post('/pf/DIM.Gateway.php', {'arq': 16, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        var sel = $('#' + c);
        sel.empty();
        sel.append('<option value="0">Selecione um perfil...</option>');
        for (var i = 0; i < data.length; i++) {
            sel.append('<option value="' +
                    data[i].id +
                    '" ' +
                    (Number(v) == Number(data[i].id) ? 'selected' : '') + ' ' +
                    (data[i].id == 15 &&
                            _41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265 !== '41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265' ? 'disabled' : '') +
                    '>' + data[i].short_name + '</option>');
        }
        iWait(w, false);
    }, 'json');
}
/**
 * 
 * @param {type} i id_roteiro
 * @param {type} d funcao (dados, transacao, outros)
 * @param {type} v valor para o selected (16;0.987;IN_FA_IN)
 * @param {type} t tabela // aplica (ALI;EIE;...etc
 * @param {type} o operacao I, A ou E
 * @param {type} a acao (inserir ou atualizar) a contagem
 * @returns {undefined}
 */
function comboFatorImpacto(i, d, v, t, o, a) {
    var optSelected = '';
    var optOption = '';
    var tp = '0';
    /*
     * verifica a acao e procura retornar apenas os itens ativos e inativos
     */
    switch (a) {
        case 'al':
            tp = '01';
            break;
        case 'ad':
            tp = '0';
            break;
    }
    if (i === 0 && v === 0) {
        var sel = $("#" + d + "_impacto");
        sel.empty();
        sel.append('<option value="0">...</option>');
    } else {
        iWait('w_' + d + '_impacto', true);
        $.post("/pf/DIM.Gateway.php", {
            'i': i, 't': t, 'o': o, 'tp': tp, 'arq': 8, 'tch': 1, 'sub': -1, 'dlg': 1},
        function (data) {
            if (data.length > 1) {
                var sel = $("#" + d + "_impacto");
                sel.empty();
                for (var i = 0; i < data.length; i++) {
                    if (v === data[i].id) {
                        optSelected = 'selected';
                    } else {
                        optSelected = '';
                    }
                    optOption = '<option value="' +
                            data[i].id + '" ' + optSelected +
                            '>[ ' + parseFloat(data[i].fator).toFixed(3) + ' ] ' +
                            data[i].sigla + ' - ' +
                            (data[i].descricao).substring(0, 60) + ((data[i].descricao).length > 60 ? '...' : '') + '</option>';
                    sel.append(optOption);
                }
                iWait('w_' + d + '_impacto', false);
            } else {
                swal({
                    title: "Alerta",
                    text: "N&atilde;o h&aacute; itens - Fator Impacto - cadastrados neste roteiro ou os itens est&atilde;o inativos.",
                    type: "warning",
                    closeOnConfirm: true,
                    html: true
                });
                $('#' + d + '_id_roteiro').val(0);
            }
        }, "json");
    }
}
/**
 * 
 * @param {type} f - funcao (Dados, Transacao ou Outros
 * @param {type} t - tipo '01' - Ativo/Inativo e '0' apenas Ativos
 * @param {type} v - valor - valor que a combo recebera caso seja alteracao
 * @param {type} e - exibir todos ou nao
 * @returns {undefined}
 */
function comboRoteiro(f, t, v, e) {
    $.post("/pf/DIM.Gateway.php", {
        't': t,
        'e': e,
        'arq': 17,
        'tch': 1,
        'sub': -1,
        'dlg': 1},
    function (data) {
        var sel = $("#" + f + "_id_roteiro");
        sel.empty();
        sel.append('<option value="0">Selecione um roteiro</option>');
        for (var i = 0; i < data.length; i++) {
            // v - colocar o valor quando for necessario
            if (v === data[i].id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
        }
    }, "json");
}

function comboSistema() {
}
/**
 * 
 * @param {type}
 *            v - valor - valor que a combo recebera caso seja alteracao
 * @param {Object}
 *            s - combo em que os dados serao inseridos
 * @param {int}
 *            i - id do cliente
 * @returns {undefined}
 */
function comboFatorTecnologia(v, s, i) {
    $.post("/pf/DIM.Gateway.php", {
        'arq': 103,
        'tch': 1,
        'sub': -1,
        'dlg': 1,
        'icl': i},
    function (data) {
        var sel = s;
        sel.empty();
        // alterar a tabela ee, se e ce
        // realizar consulta ao ft
        // retornar o ft para alteracao
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                // v - colocar o valor quando for necessario
                if (v === data[i].id) {
                    selected = 'selected';
                } else {
                    selected = '';
                }
                sel.append('<option value="' + data[i].id +
                        '" ' + selected + '>' + parseFloat(data[i].fator_tecnologia).toFixed(3) + '-' + data[i].descricao + '</option>');
            }
        }
        else {
            sel.append('<option value="0" selected>1.000-N&atilde;o aplic&aacute;vel</option>');
        }
    }, "json");
}
/**
 * 
 * @param {string}
 *            t - tipo (01 = ativo e inativo, o - only tipo 1 ou 0)
 * @param {int}
 *            v - valor a ser assumido pela combo
 * @param {element}
 *            e - caixa de selecao (componente)
 * @param {int}
 *            c - id do cliente
 * @returns {boolean}
 */
function comboLinguagem(t, v, e, c) {
    $.post("/pf/DIM.Gateway.php", {
        't': t,
        'icl': c,
        'arq': 12,
        'tch': 1,
        'sub': -1,
        'dlg': 1},
    function (data) {
        var sel = e;
        sel.empty();
        sel.append('<option value="0">...</option>');
        for (var i = 0; i < data.length; i++) {
            if (Number(v) === Number(data[i].id)) {
                selected = 'selected';
            } else {
                selected = '';
            }
            if (data[i].status == 0) {
                sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
                sel.children('option[value="' + data[i].id + '"]').attr('disabled', true);
            } else {
                if (data[i].tipo === 'N') {
                    sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
                } else {
                    if (Number(data[i].ie == Number(idEmpresa))) {
                        sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
                        sel.children('option[value="' + data[i].id + '"]').css('color', '#000099');
                    } else {
                        sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
                        sel.children('option[value="' + data[i].id + '"]').css('color', '#339933');
                    }
                }
            }
        }
    }, "json");
}

function comboTipoContagem(t, v, e) {
// tipo (01 = ativo e inativo, o - only tipo 1 ou 0)
    $.post("/pf/DIM.Gateway.php", {'t': t, 'arq': 18, 'tch': 1, 'sub': -1, 'dlg': 1},
    function (data) {
        var sel = e;
        sel.empty();
        for (var i = 0; i < data.length; i++) {
            if (v === data[i].id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
        }
    }, "json");
}

function comboEtapa(t, v, e) {
// tipo (01 = ativo e inativo, o - only tipo 1 ou 0)
    $.post("/pf/DIM.Gateway.php", {'t': t, 'arq': 7, 'tch': 1, 'sub': -1, 'dlg': 1},
    function (data) {
        var sel = e;
        sel.empty();
        for (var i = 0; i < data.length; i++) {
            if (v === data[i].id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
        }
    }, "json");
}

function comboProcesso(t, v, e) {
// tipo (01 = ativo e inativo, o - only tipo 1 ou 0)
    $.post("/pf/DIM.Gateway.php", {'t': t, 'arq': 13, 'tch': 1, 'sub': -1, 'dlg': 1},
    function (data) {
        var sel = e;
        sel.empty();
        for (var i = 0; i < data.length; i++) {
            if (v === data[i].id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
        }
    }, "json");
}

function comboProcessoGestao(t, v, e) {
// tipo (01 = ativo e inativo, 0 - only tipo 1 ou 0)
    $.post("/pf/DIM.Gateway.php", {'t': t, 'arq': 14, 'tch': 1, 'sub': -1, 'dlg': 1},
    function (data) {
        var sel = e;
        sel.empty();
        for (var i = 0; i < data.length; i++) {
            if (v === data[i].id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
        }
    }, "json");
}

/**
 * 
 * @param {string}
 *            t - tipo (01 = ativo e inativo, o - only tipo 1 ou 0)
 * @param {int}
 *            v - valor a ser assumido pela combo
 * @param {element}
 *            e - caixa de selecao (componente)
 * @param {int}
 *            c - id do cliente
 * @returns {boolean}
 */
function comboBancoDados(t, v, e, c) {
    $.post("/pf/DIM.Gateway.php", {
        't': t,
        'icl': c,
        'arq': 3,
        'tch': 1,
        'sub': -1,
        'dlg': 1},
    function (data) {
        var sel = e;
        sel.empty();
        sel.append('<option value="0">...</option>');
        for (var i = 0; i < data.length; i++) {
            if (v === data[i].id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            if (data[i].status == 0) {
                sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
                sel.children('option[value="' + data[i].id + '"]').attr('disabled', true);
            } else {
                if (data[i].tipo === 'N') {
                    sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
                } else {
                    if (Number(data[i].ie == Number(idEmpresa))) {
                        sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
                        sel.children('option[value="' + data[i].id + '"]').css('color', '#000099');
                    } else {
                        sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
                        sel.children('option[value="' + data[i].id + '"]').css('color', '#339933');
                    }
                }
            }
        }
    }, "json");
}

function comboIndustria(t, v, e) {
    // tipo (01 = ativo e inativo, 0 - only tipo 1 ou 0)
    $.post("/pf/DIM.Gateway.php", {'t': t, 'arq': 11, 'tch': 1, 'sub': -1, 'dlg': 1},
    function (data) {
        var sel = e;
        sel.empty();
        sel.append('<option value="0">...</option>');
        for (var i = 0; i < data.length; i++) {
            if (v === data[i].id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
        }
    }, "json");
}

/**
 * 
 * @param {type} v - valor caso receba o item fica selecionado
 * @param {type} t - tipo ... 1 - ativos, 01 - todos
 * @param {type} sel ??
 * @returns {undefined}
 */
function comboBaseline(v, t, sel, isDashboard) {
    iWait('w_id_baseline', true);
    $.post('/pf/DIM.Gateway.php', {
        't': t,
        'arq': 4,
        'tch': 1,
        'sub': -1,
        'dlg': 1,
        'icl': idClienteContagem,
        'isDashboard': isDashboard}, function (data) {
        sel.empty();
        sel.append('<option value="0">Baseline...</option>');
        for (var i = 0; i < data.length; i++) {
            if (v === data[i].id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].sigla + ' - ' + data[i].descricao + '</option>');
        }
        iWait('w_id_baseline', false);
    }, 'json');
}

function comboBaselineAIE(t, i, a) {
    $.post('/pf/DIM.Gateway.php', {'t': t, 'i': i, 'a': a, 'arq': 4, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        var sel = $("#id-baseline-pesquisa");
        sel.empty();
        sel.append('<option value="0">...</option>');
        for (var i = 0; i < data.length; i++) {
            sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].sigla + ' - ' + data[i].descricao + '</option>');
        }
        iWait('w_id_baseline', false);
    }, 'json');
}
/**
 * 
 * @param {type}
 *            t - tipo (01 = ativo e inativo, o - only tipo 1 ou 0)
 * @param {type}
 *            v - Valor para a opcao default
 * @param {type}
 *            c - id_cliente
 * @param {type}
 *            e - elemento (a combo em si)
 * @returns {undefined}
 */
function comboOrgao(t, v, c, e) {
    iWait('w_id_orgao', true);
    $.post("/pf/DIM.Gateway.php", {'t': t, 'icl': c, 'arq': 92, 'tch': 1, 'sub': -1, 'dlg': 1},
    function (data) {
        var sel = e;
        sel.empty();
        sel.append('<option value="0">...</option>');
        for (var i = 0; i < data.length; i++) {
            if (v === data[i].id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            sel.append('<option value="' + data[i].id + '" ' + selected + (data[i].is_ativo == 0 ? ' disabled' : '') + '>' + data[i].descricao + '</option>');
        }
        iWait('w_id_orgao', false);
    }, "json");
}

function f41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265() {
    $.post('/pf/DIM.Gateway.php', {'arq': 58, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
        var sel = $("#41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265").empty().append('<option value="0">...</option>');
        for (var i = 0; i < data.length; i++) {
            sel.append('<option value="' + data[i].id + '">' + data[i].sigla + '</option>');
        }
    }, 'json');
}

function verificaProdutividade(i) {
    iWait('w_produtividade', true);
    $.post("/pf/DIM.Gateway.php", {'id': i, 'arq': 56, 'tch': 1, 'sub': -1, 'dlg': 1},
    function (data) {
        // div no formulario inicial
        $('#div_produtividade').val(data[0].variacao);
        // inputs de produtividade
        $('#produtividade-media').val(data[0].produtividadeMedia);
        $('#produtividade-baixa').val(data[0].produtividadeBaixa);
        $('#produtividade-alta').val(data[0].produtividadeAlta);
        // span da produtividae
        $('#span-produtividade-linguagem').html('M&Eacute;DIA: <strong>' + parseFloat(data[0].produtividadeMedia).toFixed(2) + '</strong>');
        // atualiza o botao de escala
        alteraEscalaProdutividade('media');
        // insere os valores de produtividade por fase
        if (isSalvarEstatisticas) {
            if ($('#chk-produtividade-linguagem').prop('checked')) {
                config_isEng ? $("#prod-eng").val(parseFloat(data[0].produtividadeMedia).toFixed(2)).prop("readonly", true) : null;
                config_isDes ? $("#prod-des").val(parseFloat(data[0].produtividadeMedia).toFixed(2)).prop("readonly", true) : null;
                config_isImp ? $("#prod-imp").val(parseFloat(data[0].produtividadeMedia).toFixed(2)).prop("readonly", true) : null;
                config_isTes ? $("#prod-tes").val(parseFloat(data[0].produtividadeMedia).toFixed(2)).prop("readonly", true) : null;
                config_isHom ? $("#prod-hom").val(parseFloat(data[0].produtividadeMedia).toFixed(2)).prop("readonly", true) : null;
                config_isImpl ? $("#prod-impl").val(parseFloat(data[0].produtividadeMedia).toFixed(2)).prop("readonly", true) : null;
            } else {
                if ($('#chk_produtividade_global').prop('checked')) {
                    config_isEng ? $("#prod-eng").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
                    config_isDes ? $("#prod-des").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
                    config_isImp ? $("#prod-imp").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
                    config_isTes ? $("#prod-tes").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
                    config_isHom ? $("#prod-hom").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
                    config_isImpl ? $("#prod-impl").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
                } else {
                    config_isEng ? $("#prod-eng").val(parseFloat(contagemConfig.prod_f_eng).toFixed(2)).prop("readonly", false) : null;
                    config_isDes ? $("#prod-des").val(parseFloat(contagemConfig.prod_f_des).toFixed(2)).prop("readonly", false) : null;
                    config_isImp ? $("#prod-imp").val(parseFloat(contagemConfig.prod_f_imp).toFixed(2)).prop("readonly", false) : null;
                    config_isTes ? $("#prod-tes").val(parseFloat(contagemConfig.prod_f_tes).toFixed(2)).prop("readonly", false) : null;
                    config_isHom ? $("#prod-hom").val(parseFloat(contagemConfig.prod_f_hom).toFixed(2)).prop("readonly", false) : null;
                    config_isImpl ? $("#prod-impl").val(parseFloat(contagemConfig.prod_f_impl).toFixed(2)).prop("readonly", false) : null;
                }
            }
            // verifica o Fator Tecnologia
            $('#span-ft').html(parseFloat(data[0].ft).toFixed(2));
            // salva as estatisticas
            calculaFases(false);
        }
        $('#coc-sloc-conversao').html(data[0].sloc);
        iWait('w_produtividade', false);
    }, "json");
}
/*
 * funcao que altera a produtividade
 */
function alteraEscalaProdutividade(p) {
    switch (p) {
        case 'baixa':
            $('#escala-baixa').removeClass('btn-default').removeClass('btn-success').addClass('btn-success');
            $('#escala-media').removeClass('btn-default').removeClass('btn-success').addClass('btn-default');
            $('#escala-alta').removeClass('btn-default').removeClass('btn-success').addClass('btn-default');
            break;
        case 'media':
            $('#escala-baixa').removeClass('btn-default').removeClass('btn-success').addClass('btn-default');
            $('#escala-media').removeClass('btn-default').removeClass('btn-success').addClass('btn-success');
            $('#escala-alta').removeClass('btn-default').removeClass('btn-success').addClass('btn-default');
            break;
        case 'alta':
            $('#escala-baixa').removeClass('btn-default').removeClass('btn-success').addClass('btn-default');
            $('#escala-media').removeClass('btn-default').removeClass('btn-success').addClass('btn-default');
            $('#escala-alta').removeClass('btn-default').removeClass('btn-success').addClass('btn-success');
            break;
    }
    $('#span-produtividade-linguagem').html(p.toUpperCase() + ': <strong>' + parseFloat($('#produtividade-' + p).val()).toFixed(2) + '</strong>');
}
/**
 * 
 * @param {String} f - funcao/complemento da combo
 * @param {int} v - Valor atual caso queira selecionar algum item diretamente
 * @param {String} t - tipo ('01' - todos, 0 - apenas os ativos
 * @param {int} frn - id do fornecedor
 * @returns {undefined}
 */
function comboCliente(f, v, t, frn) {
    $.post("/pf/DIM.Gateway.php", {
        't': t,
        'f': frn,
        'e': f, //especie -> contagem, etc.
        'i': v,
        'arq': 5,
        'tch': 1,
        'sub': -1,
        'dlg': 1},
    function (data) {
        var sel = $("#" + f + "_id_cliente");
        sel.empty();
        for (var i = 0; i < data.length; i++) {
            if (v === data[i].id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            sel.append('<option value="' + data[i].id + '" ' + selected + '>' + (data[i].sigla !== '' ? data[i].sigla + ' - ' : '') + data[i].descricao + '</option>');
        }
    }, "json");
}
/**
 * 
 * @param {String}
 *            f - funcao/complemento da combo
 * @param {int}
 *            v - Valor atual caso queira selecionar algum item diretamente
 * @param {String}
 *            t - tipo ('01' - todos, 0 - apenas os ativos
 * @param {String}
 *            tp - tipo 0 - fornecedor, 1 - turma, 2 - auditoria
 * @param {Boolean}
 *            isMudar - muda ou nao o id da combo
 * @returns {undefined}
 */
function comboFornecedores(f, v, t, tp, isMudar) {
    $.post("/pf/DIM.Gateway.php", {'t': t, 'tp': tp, 'arq': 9, 'tch': 1, 'sub': -1, 'dlg': 1},
    function (data) {
        var sel = $("#" + f + "_id_" + (isMudar ? (tp == 0 ? "fornecedor" : "turma") : "fornecedor"));
        sel.empty();
        for (var i = 0; i < data.length; i++) {
            if (tpoFornecedor == 1) {
                sel.append('<option value="' + data[i].id + '" ' + (v === data[i].id ? 'selected' : '') + '>' +
                        (data[i].is_ativo != '' ? (data[i].is_ativo == 1 ? '[ A ] ' : '[ I ] ') : '') +
                        (i == 0 ? data[i].nome : data[i].sigla + ' - ' + data[i].nome) + '</option>');
            } else {
                sel.append('<option value="' + data[i].id + '" ' + (v === data[i].id ? 'selected' : '') + '>' +
                        (data[i].is_ativo != '' ? (data[i].is_ativo == 1 ? '[ A ] ' : '[ I ] ') : '') +
                        (i == 0 ? data[i].nome : data[i].sigla + ' - ' + data[i].nome) + '</option>');
            }
        }
    }, "json");
}

/**
 * 
 * @param {type} i
 * @param {type} t
 * @param {type} v
 * @param {type} e
 * @param {type} f
 * @param {type} a
 * @returns {undefined}
 */
function comboContrato(i, t, v, e, f, a) {
    var sel;
    if (i === 0 && v === 0) {
        // feito sob medida para o formulario de configuracao dos relatorios
        sel = $("#" + f + "_id_contrato");
        sel.empty().append('<option value="0">Aguardando um cliente...</option>');
        sel = $("#" + f + "_id_projeto");
        sel.empty().append('<option value="0">Aguardando um contrato...</option>');
    } else {
        iWait('w_id_contrato', true);
        sel = $("#" + f + "_id_contrato");
        var selected = '';
        $.post("/pf/DIM.Gateway.php", {
            'i': i, 't': t, 'a': a, 'arq': 6, 'tch': 1, 'sub': -1, 'dlg': 1},
        function (data) {
            sel.empty();
            if (data.length <= 1) {
                swal({
                    title: "Alerta",
                    text: "Este cliente n&atilde;o possui contrato(s) ou n&atilde;o est&atilde;o ativos. Pe&ccedil;a para o administrador verificar.",
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi, obrigado!"});
                sel.append('<option value="0" disabled>Nenhum contrato ativo!</option>')
            } else {
                for (var i = 0; i < data.length; i++) {
                    if (v === data[i].id) {
                        selected = 'selected';
                    } else {
                        selected = '';
                    }
                    if (e == 0) { // todos
                        sel.append('<option value="' + data[i].id + '" ' + selected + '>' + (data[i].sigla === '-' ? '' : data[i].sigla) + data[i].numeroAno + '</option>');
                    } else if (e == 1) { // iniciais
                        if (data[i].tipo === '[ I ]') {
                            sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].numeroAno + '</option>');
                        }
                    } else if (e == 2) { // aditivos
                        if (data[i].tipo === '[ A ]') {
                            sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].numeroAno + '</option>');
                        }
                    }
                }
            }
            iWait('w_id_contrato', false);
        }, "json");
        if (parseInt(v, 10) > 0) {
            sel.val(v);
        }
    }
}
/**
 * 
 * @param {type}
 *            i - id cliente
 * @param {type}
 *            t - tipo (1 - ativo, 01 - todos)
 * @param {type}
 *            v - valor, se for diferente de zero assume a opcao passada
 * @param {type}
 *            f - nome da combo (ex.: assinatura, cliente, etc)
 * @returns {boolean}
 */
function comboProjeto(i, t, v, f) {
    var sel = $("#" + f + "_id_projeto");
    var selected = '';
    if (i === 0 && v === 0) {
        sel.empty().append('<option value="0">Aguardando um contrato...</option>');
    } else {
        iWait('w_id_projeto', true);
        $.post("/pf/DIM.Gateway.php", {'i': i, 't': t, 'arq': 15, 'tch': 1, 'sub': -1, 'dlg': 1},
        function (data) {
            if (data.length < 2) {
                swal({
                    title: "Alerta",
                    text: "Este contrato n&atilde;o possui projeto(s) ou n&atilde;o est&atilde;o ativos. Pe&ccedil;a para o administrador verificar.",
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi, obrigado!"});
                sel.empty().append('<option value="0">Aguardando um contrato...</option>');
                iWait('w_id_projeto', false);
            } else {
                sel.empty();
                for (var i = 0; i < data.length; i++) {
                    if (v === data[i].id) {
                        selected = 'selected';
                    } else {
                        selected = '';
                    }
                    sel.append('<option value="' + data[i].id + '" ' + selected + '>' + data[i].descricao + '</option>');
                }
                iWait('w_id_projeto', false);
                if (parseInt(v, 10) > 0) {
                    sel.val(v);
                }
            }
        }, "json");
    }
}

/**
 * 
 * @param {type} t - tipo (1 - ativo, 01 - todos)
 * @returns {undefined}
 */
function comboProjetoBaseline(t, sel) {
    $.post("/pf/DIM.Gateway.php", {'t': t, 'arq': 87, 'tch': 1, 'sub': -1, 'dlg': 1},
    function (data) {
        sel.empty();
        console.log(data);
        for (var i = 0; i < data.length; i++) {
            sel.append('<option value="' + data[i].id + '">' + data[i].descricao + '</option>');
        }
    }, "json");
}

function comboGerenteProjeto(v) {
    var sel = $("#prj_id_gerente_projeto");
    $.post("/pf/DIM.Gateway.php", {'arq': 10, 'tch': 1, 'sub': -1, 'dlg': 1},
    function (data) {
        sel.empty();
        for (var i = 0; i < data.length; i++) {
            if (v === data[i].user_id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            sel.append('<option value="' + data[i].user_id + '" ' + selected + '>' + data[i].complete_name + '</option>');
        }
    }, "json");
}

function exibeModalForm(f, t, p, b, a) {
    /*
     * Autor: Jose Claudio Descricao: Esta funcao recebe os parametros do click
     * nos botoes "btn_adicionar_* (ali, aie, ee, se, ee e ou) Parametros: f =
     * funcao (transacao/dados/outros) t = titulo p = tipo (ALI/AIE/EE/SE/CE/OU)
     * b = button (DOM - "btn_adicionar_*" a = acao -> al - alterar, ad -
     * adicionar
     */
    if ($('#id').val() === '-') {
        swal({
            title: "Alerta",
            text: "Por favor, insira primeiro as informa&ccedil;&otilde;es sobre a contagem.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
    } else {
        /*
         * se for baseline(3) e licitacao(4) desabilita alterar e excluir e ja
         * habilita o botão incluir
         */
        if (abAtual == 3 || abAtual == 4) {
            $('#' + f + '_op2').prop('disabled', true);
            $('#' + f + '_op3').prop('disabled', true);
            $('#' + f + '_op4').prop('disabled', true);
            /*
             * se for baseline desabilita Nesma e FP-Lite e ja habilita o botao
             * detalhado
             */
            if (abAtual == 3) {
                $('#' + f + '_me1').prop('disabled', true);
                $('#' + f + '_me2').prop('disabled', true);
            }
        } else if (abAtual == 2 && p === 'AIE') {// projeto
            /*
             * projeto de baseline nao pode alterar aie
             */
            $('#' + f + '_op2').prop('disabled', true);
        }
        $('#descricao-funcao-td').val(f);
        $('#id-linha-descricao').val('0');
        variaveisModalForm(f, t, p, b, a);
    }
}
function variaveisModalForm(f, t, p, b, a) {
    /*
     * Autor: Jose Claudio Descricao: Funcao que recebe os parametros da
     * exibeModalForm e habilita/desabilita os botoes de acao nos
     * form_modal_funcao_* eh generica porque pode ser chamada por outros
     * formularios e funcoes em outros momentos Parametros: os mesmos da funcao
     * exibeModalForm
     */
    b.setAttribute('data-toggle', 'modal');
    b.setAttribute('data-target', '#form_modal_funcao_' + f);
    $('#cabecalho_funcao').val(t);
    $('#' + f + '_tabela').val(p);
    $('#' + f + '_id').val($('#id').val());
    $('#' + f + '_h4-modal').html($('#cabecalho_funcao').val());
    if (a === 'ad') {
        /*
         * habilita e desabilita os botoes
         */
        $('#' + f + '_btn_if').prop('disabled', false);
        $('#' + f + '_btn_in').prop('disabled', false);
        $('#' + f + '_btn_al').prop('disabled', true);
    } else {
        /*
         * habilita e desabilita os botoes
         */
        $('#' + f + '_btn_if').prop('disabled', true);
        $('#' + f + '_btn_in').prop('disabled', true);
        $('#' + f + '_btn_al').prop('disabled', false);
    }
    // muda a variavel acForms
    acForms = a;
    // muda a variavel fAtual
    fAtual = p.toLowerCase();
    // operacao especial para o botao de alterar o nome da funcao de dados
    if (f === 'dados' && a === 'al') {
        // desabilita o input com o nome da funcao e o botao alterar nome apenas
        // para a funcao de dados ALI e AIE
        $('#dados_funcao').prop('readonly', true).css({'background-color': '#ffffe5'});
        $('#alterar-funcao-dados').removeClass('cancelar').addClass('alterar').removeClass('btn-warning').addClass('btn-default').html('<i class="fa fa-edit"></i>&nbsp;Alterar').prop('disabled', false);
        // limpa tambem o nome anterior da funcao
    }
    else {
        $('#dados_funcao').prop('readonly', false);
        $('#alterar-funcao-dados').removeClass('cancelar').addClass('alterar').removeClass('btn-warning').addClass('btn-default').html('<i class="fa fa-edit"></i>&nbsp;Alterar').prop('disabled', true);
    }
    // altera o valor do fator tecnologia
    Number(contagemConfig['id_fator_tecnologia_padrao']) > 0 ? $('#id_fator_tecnologia').val(contagemConfig['id_fator_tecnologia_padrao']) : null;
    $('#valor_fator_tecnologia').html(parseFloat(($('#id_fator_tecnologia option:selected').text()).split('-')[0]).toFixed(3));
}
/**
 * 
 * @param {type} f - funcao T - Transacao, D - Dados
 * @param {type} v - N - Nesma, F - PF-LITE, D - Detalhada
 * @param {type} r - roteiro de metricas
 * @param {type} o - valor da operacao I, A, E
 * @returns {undefined}
 */
function verificaMetodo(f, v, r, o) {
    // verifica se o id do roteiro e a operacao ja foram preenchidos
    if (Number($(r).val()) == 0 || $(o).val() === '') {
        swal({
            title: "Alerta",
            text: "Por favor selecione um roteiro e/ou uma opera&ccedil;&atilde;o antes de selecionar o m&eacute;todo.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"},
        function () {
            $(v).removeClass('btn-success').addClass('btn-default');
            $(r).get(0).focus();
        });
    } else {
        // verifica os valores do metodo
        if (Number($(v).val()) == 1) {
            // marca o botao
            destacaBotao(f, '_me', ['btn-success', 'btn-default', 'btn-default']);
            if ($('#' + f + '_tabela').val() === 'ALI') {
                camposMetodo(19, 1, 'Baixa', '7.0000', f, $(v).val());
            } else if ($('#' + f + '_tabela').val() === 'AIE') {
                camposMetodo(19, 1, 'Baixa', '5.0000', f, $(v).val());
            } else if ($('#' + f + '_tabela').val() === 'EE') {
                camposMetodo(16, 1, 'Media', '4.0000', f, $(v).val());
            } else if ($('#' + f + '_tabela').val() === 'SE') {
                camposMetodo(20, 1, 'Media', '5.000', f, $(v).val());
            } else if ($('#' + f + '_tabela').val() === 'CE') {
                camposMetodo(20, 1, 'Media', '4.0000', f, $(v).val());
            }
        } else if (Number($(v).val()) == 2) {
            // marca o botao
            destacaBotao(f, '_me', ['btn-default', 'btn-success', 'btn-default']);
            if ($('#' + f + '_tabela').val() === 'ALI' || $('#' + f + '_tabela').val() === 'AIE') {
                camposMetodo(51, 1, 'Media', '10.0000', f, $(v).val());
            } else if ($('#' + f + '_tabela').val() === 'EE') {
                camposMetodo(16, 1, 'Media', '4.0000', f, $(v).val());
            } else if ($('#' + f + '_tabela').val() === 'SE') {
                camposMetodo(20, 1, 'Media', '5.0000', f, $(v).val());
            } else if ($('#' + f + '_tabela').val() === 'CE') {
                camposMetodo(20, 1, 'Media', '4.0000', f, $(v).val());
            }
        } else if (Number($(v).val()) == 3) {
            // destaca o botao
            destacaBotao(f, '_me', ['btn-default', 'btn-default', 'btn-success']);
            // pega a funcao que esta sendo tratada no momento
            var tbl = $('#' + f + '_tabela').val(); // ALI, AIE, etc
            // verifica se tem algo nas tags e ja calcula os pontos de funcao
            var qtdTd = $('#' + f + '_descricao_td').tagsManager('tags');
            var qtdTr = f === 'transacao' ? $('#' + f + '_descricao_ar').tagsManager('tags') : $('#' + f + '_descricao_tr').tagsManager('tags');
            // calcula o pfb
            if (qtdTd.length > 0 && qtdTr.length > 0) {
                $('#' + f + '_td').val(qtdTd.length);
                $('#' + f + (f === 'transacao' ? '_ar' : '_tr')).val(qtdTr.length);
                calculaLinhaPF($('#' + f + '_tabela').val(), f, $('#' + f + '_td'), $('#' + f + (f === 'transacao' ? '_ar' : '_tr')));
                if ($('#' + f + '_impacto').val() !== '0') {
                    calculaPfa($('#' + f + '_impacto'), $('#' + f + '_pfb'), $('#' + f + '_pfa'), f);
                }
            } else {
                // atribui o valor zero caso seja uma SE
                $('#' + f + '_td').prop('readOnly', true).val(tbl === 'SE' ? '0' : '');
                if (f === 'dados') {
                    $('#' + f + '_tr').prop('readOnly', true).val('');
                } else if (f === 'transacao') {
                    $('#' + f + '_ar').prop('readOnly', true).val('0');
                }
                // apenas no caso SE o valor da linha PF ja pode ser calculado,
                // o campo aceita zero de valor
                if (tbl === 'SE') {
                    calculaLinhaPF($('#' + f + '_tabela').val(), f, $('#' + f + '_td'), $('#' + f + '_ar'));
                } else {
                    $('#' + f + '_complexidade').val('');
                    $('#' + f + '_pfb').val('');
                }
            }
        }
        $('#' + f + '_metodo').val($(v).val());
    }

    return true;
}
function verificaOperacao(f, v, i, s, b, a) {
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
    var idBaseline = $('#contagem_id_baseline').val();
    /*
     * verifica o iscrud e ja desabilita se nao for I
     */
    if (v !== 'I') {
        isCrud = false;
        $('#is-crud').bootstrapToggle('off').bootstrapToggle('disable');
    }
    else {
        // por enquanto nao faz nada, a opcao eh do operador
        // if (b === 'ALI') {
        // isCrud = true;
        // $('#is-crud').bootstrapToggle('enable').bootstrapToggle('on');
        // }
    }
    /*
     * nao pode converter uma inclusao de funcao em baseline para uma alteracao /
     * exclusao / testes na contagem de projeto(2)
     */
    if (v === 'I' && abAtual == 2 && a === 'al') {
        $('#' + f + '_op2').prop('disabled', true);
        $('#' + f + '_op3').prop('disabled', true);
        $('#' + f + '_op4').prop('disabled', true);
    }
    /*
     * nao pode converter uma exclusao / alteracao de funcao de baseline em uma
     * inclusao / testes na contagem de projeto
     */
    else if ((v === 'A' || v === 'E') && abAtual == 2 && a === 'al') {
        $('#' + f + '_op1').prop('disabled', true);
        $('#' + f + '_op4').prop('disabled', true);
    }
    /*
     * baseline ou licitacao habilita apenas inclusao
     */
    else if (abAtual == 3 || abAtual == 4) {
        $('#' + f + '_op2').prop('disabled', true);
        $('#' + f + '_op3').prop('disabled', true);
        /*
         * baseline desabilita os metodos Nesma e FP-Lite
         */
        if (abAtual == 3) {
            $('#' + f + '_me1').prop('disabled', true);
            $('#' + f + '_me1').prop('disabled', true);
        }
    }
    /*
     * antes de estabelecer a operacao verifica o id do roteiro
     */
    if (i == 0) {
        swal({
            title: "Alerta",
            text: "Por favor, selecione primeiro o Roteiro de M&eacute;tricas.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
        destacaBotao(f, '_op', ['btn-default', 'btn-default', 'btn-default', 'btn-default']);
        /*
         * habilita novamente
         * 
         * isCrud = true;
         * $('#is-crud').bootstrapToggle('enable').bootstrapToggle('on'); /* nao marca o botao
         */
        return false;
    }
    /*
     * para baseline
     */
    else if (abAtual == 3) {
        /*
         * monta a combo do impacto
         */
        comboFatorImpacto(i, f, s, b, v, a);
        /*
         * estabelece o metodo como D - Detalhado, por se tratar de uma baseline
         */
        verificaMetodo(f, $('#' + f + '_me3'), $('#' + f + '_id_roteiro'), $('#' + f + '_op1'));
        /*
         * destaca o botao como I - Inclusao
         */
        destacaBotao(f, '_op', ['btn-success', 'btn-default', 'btn-default', 'btn-default']);
        /*
         * destaca o botao como D - Detalhado
         */
        destacaBotao(f, '_me', ['btn-default', 'btn-default', 'btn-success']);
        /*
         * estabelece o valor do metodo como 3 - Detalhado
         */
        $('#' + f + '_metodo').val(3);
        $('#' + f + '_operacao').val('I');
        /*
         * habilita o input
         */
        $('#' + f + '_funcao').prop('disabled', false);
    }
    /*
     * para todas as outras abrangencias
     */
    else {
        switch (v) {
            case 'I':
                limpaCampos(f, false, a);
                if (abAtual == 2) {
                    if (b === 'AIE') {
                        destacaBotao(f, '_op', ['btn-success', 'btn-default', 'btn-default', 'btn-default']);
                        /*
                         * estebelece o input com o valor da operacao I, A e E
                         */
                        $('#' + f + '_operacao').val(v);
                        /*
                         * pega a combo impacto
                         */
                        comboFatorImpacto(i, f, s, b, v, a);
                    } else {
                        $('#' + f + '_funcao')
                                .replaceWith('<input type="text" class="form-control input_style" id="' + f + '_funcao" name="' + f + '_funcao" autocomplete="off">');
                        /*
                         * poe as classes nos botoes de operacao
                         */
                        destacaBotao(f, '_op', ['btn-success', 'btn-default', 'btn-default', 'btn-default']);
                        /*
                         * estebelece o input com o valor da operacao I, A e E
                         */
                        $('#' + f + '_operacao').val(v);
                        /*
                         * monta a combo do impacto
                         */
                        comboFatorImpacto(i, f, s, b, v, a);
                    }
                } else {
                    $('#' + f + '_funcao')
                            .replaceWith('<input type="text" class="form-control input_style" id="' + f + '_funcao" name="' + f + '_funcao" autocomplete="off">');
                    /*
                     * poe as classes nos botoes de operacao
                     */
                    destacaBotao(f, '_op', ['btn-success', 'btn-default', 'btn-default', 'btn-default']);
                    /*
                     * estebelece o input com o valor da operacao I, A e E
                     */
                    $('#' + f + '_operacao').val(v);
                    /*
                     * monta a combo do impacto
                     */
                    comboFatorImpacto(i, f, s, b, v, a);
                }
                break;
            case 'A':
                limpaCampos(f, false, a);
                if (abAtual == 2) {
                    $.post('/pf/DIM.Gateway.php', {'idBaseline': idBaseline, 'tabela': b, 'idContagem': idContagem, 'arq': 41, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
                        if (data.length < 1 && acForms !== 'al') {
                            swal({
                                title: "Alerta",
                                text: "<strong>ATEN&Ccedil;&Atilde;O</strong>: n&atilde;o h&aacute; fun&ccedil;&otilde;es (" + b + ") " +
                                        "cadastradas na Baseline ou as fun&ccedil;&otilde;es inseridas ainda n&atilde;o est&atilde;o validadas. " +
                                        "Verifique se a funcionalidade que voc&ecirc; est&aacute; pesquisando j&aacute; est&aacute; inserida na contagem, evite duplicidades.",
                                type: "error",
                                html: true,
                                confirmButtonText: "Obrigado, vou verificar!"}, function () {
                                destacaBotao(f, '_op', ['btn-default', 'btn-default', 'btn-default', 'btn-default']);
                                /*
                                 * habilita novamente
                                 * 
                                 * isCrud = true;
                                 * $('#is-crud').bootstrapToggle('enable').bootstrapToggle('on');
                                 */
                            });
                        } else {
                            /*
                             * se a operacao for alteracao da funcao nao coloca
                             * mais combobox
                             */
                            if (a !== 'al') {
                                $('#' + f + '_funcao')
                                        .replaceWith('<select id="' + f + '_funcao" class="form-control input_style" onchange="consultaFuncao' + f.capitalizeFirstLetter() + 'Baseline(this.value, \'' + b + '\');"></select>');
                                var sel = $('#' + f + '_funcao');
                                sel.empty();
                                sel.append('<option value="0">...</option>');
                                for (x = 0; x < data.length; x++) {
                                    sel.append('<option value="' + data[x].id + '">' +
                                            (Number(data[x].id_gerador) > 0 ? 'P' : 'B') +
                                            ' > ' + ("0000000" + data[x].id_contagem).slice(-7) +
                                            ' > ' + data[x].operacao +
                                            ' > ' + formattedDate(data[x].data_cadastro, false, false) +
                                            ' > ' + data[x].sigla +
                                            ' > ' + data[x].funcao + '</option>');
                                }
                            }
                            destacaBotao(f, '_op', ['btn-default', 'btn-success', 'btn-default', 'btn-default']);
                            /*
                             * estebelece o input com o valor da operacao I, A e
                             * E
                             */
                            $('#' + f + '_operacao').val(v);
                            /*
                             * pega a combo impacto
                             */
                            comboFatorImpacto(i, f, s, b, v, a);
                            /*
                             * habilita a opcao de mudanca
                             */
                            $('#' + f + '-is-mudanca').bootstrapToggle('enable');
                        }
                    }, 'json');
                } else {
                    destacaBotao(f, '_op', ['btn-default', 'btn-success', 'btn-default', 'btn-default']);
                    /*
                     * estebelece o input com o valor da operacao I, A e E
                     */
                    $('#' + f + '_operacao').val(v);
                    /*
                     * pega a combo impacto
                     */
                    comboFatorImpacto(i, f, s, b, v, a);
                    /*
                     * habilita a opcao de mudanca
                     */
                    $('#' + f + '-is-mudanca').bootstrapToggle('enable');
                }
                /*
                 * habilita a selecao de fator documentacao
                 */
                $('#' + f + '_fd').prop('disabled', false);
                break;
            case 'E':
                limpaCampos(f, false, a);
                if (Number(abAtual) == 2) {
                    $.post('/pf/DIM.Gateway.php', {'idBaseline': idBaseline, 'tabela': b, 'idContagem': idContagem, 'abAtual': abAtual, 'arq': 41, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
                        if (data.length < 1 && acForms !== 'al') {
                            swal({
                                title: "Alerta",
                                text: "<strong>ATEN&Ccedil;&Atilde;O</strong>: n&atilde;o h&aacute; fun&ccedil;&otilde;es (" + b + ") " +
                                        "cadastradas na Baseline ou as fun&ccedil;&otilde;es inseridas ainda n&atilde;o est&atilde;o validadas. " +
                                        "Verifique se a funcionalidade que voc&ecirc; est&aacute; pesquisando j&aacute; est&aacute; inserida na contagem, evite duplicidades.",
                                type: "error",
                                html: true,
                                confirmButtonText: "Obrigado, vou verificar!"}, function () {
                                destacaBotao(f, '_op', ['btn-default', 'btn-default', 'btn-default', 'btn-default']);
                                /*
                                 * habilita novamente
                                 * 
                                 * isCrud = true;
                                 * $('#is-crud').bootstrapToggle('enable').bootstrapToggle('on');
                                 */
                            });
                        } else {
                            /*
                             * se a operacao for exclusao da funcao nao coloca
                             * mais combobox
                             */
                            if (a !== 'al') {
                                $('#' + f + '_funcao')
                                        .replaceWith('<select id="' + f + '_funcao" class="form-control input_style" onchange="consultaFuncao' + f.capitalizeFirstLetter() + 'Baseline(this.value, \'' + b + '\');"></select>');
                                var sel = $('#' + f + '_funcao');
                                sel.empty();
                                sel.append('<option value="0">...</option>');
                                for (x = 0; x < data.length; x++) {
                                    sel.append('<option value="' + data[x].id + '">' +
                                            (Number(data[x].id_gerador) > 0 ? 'P' : 'B') +
                                            ' > ' + ("0000000" + data[x].id_contagem).slice(-7) +
                                            ' > ' + data[x].operacao +
                                            ' > ' + formattedDate(data[x].data_cadastro, false, false) +
                                            ' > ' + data[x].sigla +
                                            ' > ' + data[x].funcao + '</option>');
                                }
                            }
                            destacaBotao(f, '_op', ['btn-default', 'btn-default', 'btn-success', 'btn-default']);
                            /*
                             * estebelece o input com o valor da operacao I, A e
                             * E
                             */
                            $('#' + f + '_operacao').val(v);
                            /*
                             * pega a combo impacto
                             */
                            comboFatorImpacto(i, f, s, b, v, a);
                            /*
                             * habilita a opcao de mudanca
                             */
                            $('#' + f + '-is-mudanca').bootstrapToggle('enable');
                        }
                    }, 'json');
                } else {
                    destacaBotao(f, '_op', ['btn-default', 'btn-default', 'btn-success', 'btn-default']);
                    /*
                     * estebelece o input com o valor da operacao I, A e E
                     */
                    $('#' + f + '_operacao').val(v);
                    comboFatorImpacto(i, f, s, b, v, a);
                    /*
                     * habilita a opcao de mudanca
                     */
                    $('#' + f + '-is-mudanca').bootstrapToggle('enable');
                }
                /*
                 * habilita a selecao de fator documentacao
                 */
                $('#' + f + '_fd').prop('disabled', false);
                break;
            case 'T':
                limpaCampos(f, false, a);
                /*
                 * abrangencia 2 = projeto
                 */
                if (abAtual == 2) {
                    $.post('/pf/DIM.Gateway.php', {'idBaseline': idBaseline, 'tabela': b, 'idContagem': idContagem, 'arq': 41, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
                        if (data.length < 1 && acForms !== 'al') {
                            swal({
                                title: "Alerta",
                                text: "<strong>ATEN&Ccedil;&Atilde;O</strong>: n&atilde;o h&aacute; fun&ccedil;&otilde;es (" + b + ") " +
                                        "cadastradas na Baseline ou as fun&ccedil;&otilde;es inseridas ainda n&atilde;o est&atilde;o validadas. " +
                                        "Verifique se a funcionalidade que voc&ecirc; est&aacute; pesquisando j&aacute; est&aacute; inserida na contagem, evite duplicidades.",
                                type: "error",
                                html: true,
                                confirmButtonText: "Obrigado, vou verificar!"}, function () {
                                destacaBotao(f, '_op', ['btn-default', 'btn-default', 'btn-default', 'btn-default']);
                            });
                        } else {
                            /*
                             * se a operacao for alteracao da funcao nao coloca
                             * mais combobox
                             */
                            if (a !== 'al') {
                                $('#' + f + '_funcao')
                                        .replaceWith('<select id="' + f + '_funcao" class="form-control input_style" onchange="consultaFuncao' + f.capitalizeFirstLetter() + 'Baseline(this.value, \'' + b + '\');"></select>');
                                var sel = $('#' + f + '_funcao');
                                sel.empty();
                                sel.append('<option value="0">...</option>');
                                for (x = 0; x < data.length; x++) {
                                    sel.append('<option value="' + data[x].id + '">' +
                                            (Number(data[x].id_gerador) > 0 ? 'P' : 'B') +
                                            ' > ' + ("0000000" + data[x].id_contagem).slice(-7) +
                                            ' > ' + data[x].operacao +
                                            ' > ' + formattedDate(data[x].data_cadastro, false, false) +
                                            ' > ' + data[x].sigla +
                                            ' > ' + data[x].funcao + '</option>');
                                }
                            }
                            destacaBotao(f, '_op', ['btn-default', 'btn-default', 'btn-default', 'btn-success']);
                            /*
                             * estebelece o input com o valor da operacao
                             */
                            $('#' + f + '_operacao').val(v);
                            /*
                             * pega a combo impacto
                             */
                            comboFatorImpacto(i, f, s, b, v, a);
                        }
                    }, 'json');
                } else {
                    destacaBotao(f, '_op', ['btn-default', 'btn-default', 'btn-default', 'btn-success']);
                    /*
                     * estebelece o input com o valor da operacao
                     */
                    $('#' + f + '_operacao').val(v);
                    /*
                     * pega a combo impacto
                     */
                    comboFatorImpacto(i, f, s, b, v, a);
                }
                /*
                 * desaabilita a selecao de fator documentacao
                 */
                $('#' + f + '_fd').prop('disabled', true);
        }
        /*
         * passou aqui desabilita a opcao de mudanca e testa se ja tem um Fator
         * de Impacto TODO: verificar pois passa nos testes e nao aqui $('#' + f +
         * '-is-mudanca').bootstrapToggle('off').bootstrapToggle('disable');
         * $('#' + f + '-fase').val(0).prop('disabled', true); $('#' + f +
         * '-percentual-fase').val('').prop('readonly', true);
         */
    }
}
/**
 * 
 * @param {String}
 *            f - funcao (dados/transacao/outros)
 * @param {String}
 *            t - texto _op ou _me
 * @param {Array}
 *            a - array com as classes (succcess/default)
 * @returns {undefined}
 */
function destacaBotao(f, t, a) {
    $('#' + f + t + '1').removeClass('btn-default').removeClass('btn-success').addClass(a[0]);
    $('#' + f + t + '2').removeClass('btn-default').removeClass('btn-success').addClass(a[1]);
    $('#' + f + t + '3').removeClass('btn-default').removeClass('btn-success').addClass(a[2]);
    (t === '_op' && f !== 'outros') ? $('#' + f + t + '4').removeClass('btn-default').removeClass('btn-success').addClass(a[3]) : null;
}

function inserirAlterarLinguagem(ac, id, icl) {
    if (ac === 'i' && $("#nova_linguagem").val() === '') {
        swal({
            title: "Alerta",
            text: "A <strong>DESCRI&Ccedil;&Atilde;O</strong> da Linguagem &eacute; &uacute;nico campo obrigat&oacute;rio",
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
        return false;
    } else if (ac === 'a' && $("#des-" + id).val() === '') {
        swal({
            title: "Alerta",
            text: "A <strong>DESCRI&Ccedil;&Atilde;O</strong> da Linguagem &eacute; &uacute;nico campo obrigat&oacute;rio",
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
        return false;
    }
    $.post('/pf/DIM.Gateway.php', {
        // d = descricao, p = produtivade
        'd': ac === 'i' ? ($("#nova_linguagem").val()) : $('#des-' + id).val(),
        'b': ac === 'i' ? ($("#baixa").val() === '' ? '16' : $("#baixa").val()) : $('#bai-' + id).val(),
        'm': ac === 'i' ? ($("#media").val() === '' ? '12' : $("#media").val()) : $('#med-' + id).val(),
        'a': ac === 'i' ? ($("#alta").val() === '' ? '8' : $("#alta").val()) : $('#alt-' + id).val(),
        's': ac === 'i' ? ($('#sloc').val() === '' ? '0' : $('#sloc').val()) : $('#slo-' + id).val(),
        'i': ac === 'i' ? ($('#is_ativo').prop('checked') ? 1 : 0) : ($('#atv-' + id).prop('checked') ? 1 : 0),
        'f': ac === 'i' ? $('#fator_tecnologia').val() : $('#ft-' + id).val(),
        't': ac === 'i' ? ($('#is_ft').prop('checked') ? 1 : 0) : ($('#is-ft-' + id).prop('checked') ? 1 : 0),
        'ac': ac,
        'id': id,
        'icl': icl,
        'arq': 29,
        'tch': 0,
        'sub': 0,
        'dlg': 1
    }, function (data) {
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "A linguagem foi <strong>" + (ac === 'i' ? "inserida" : "alterada") + "</strong> com sucesso. #ID " + ("0000000" + data[0].id).slice(-7),
            type: "success",
            html: true,
            confirmButtonText: "Obrigado!"},
        function () {
            if (ac === 'i') {
                addLinhaLinguagem(
                        data[0].id,
                        $("#nova_linguagem").val(),
                        $('#is_ativo').prop('checked') ? 1 : 0,
                        Number($("#baixa").val()).toFixed(2),
                        Number($("#media").val()).toFixed(2),
                        Number($("#alta").val()).toFixed(2),
                        $("#sloc").val(), 0, '#ccff99',
                        $("#fator_tecnologia").val());
                // limpa os campos
                $("#nova_linguagem").val('');
                $("#baixa").val('');
                $("#media").val('');
                $("#alta").val('');
                $("#sloc").val('');
                $("#fator_tecnologia").val('');
            }
        });
    }, "json");
}

function inserirAlterarBancoDados(ac, id, icl) {
    if (ac === 'i' && $("#novo_banco_dados").val() === '') {
        swal({
            title: "Alerta",
            text: "A <strong>DESCRI&Ccedil;&Atilde;O</strong> do Banco de Dados &eacute; um campo obrigat&oacute;rio",
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
        return false;
    } else if (ac === 'a' && $("#des-" + id).val() === '') {
        swal({
            title: "Alerta",
            text: "A <strong>DESCRI&Ccedil;&Atilde;O</strong> do Banco de Dados &eacute; um campo obrigat&oacute;rio",
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
        return false;
    }
    $.post('/pf/DIM.Gateway.php', {
        // d = descricao, p = produtivade
        'd': ac === 'i' ? ($("#novo_banco_dados").val()) : $('#des-' + id).val(),
        'i': ac === 'i' ? ($('#banco_dados_is_ativo').prop('checked') ? 1 : 0) : ($('#atv-' + id).prop('checked') ? 1 : 0),
        'ac': ac,
        'id': id,
        'icl': icl,
        'arq': 87,
        'tch': 0,
        'sub': 0,
        'dlg': 1
    }, function (data) {
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "O Banco de Dados foi <strong>" + (ac === 'i' ? "inserido" : "alterado") + "</strong> com sucesso. #ID " + ("0000000" + data[0].id).slice(-7),
            type: "success",
            html: true,
            confirmButtonText: "Obrigado!"},
        function () {
            if (ac === 'i') {
                addLinhaBancoDados(
                        data[0].id,
                        $("#novo_banco_dados").val(),
                        $('#banco_dados_is_ativo').prop('checked') ? 1 : 0,
                        0, '#ccff99');
                // limpa os campos
                $("#novo_banco_dados").val('');
                $("#banco_dados_is_ativo").bootstrapToggle('on');
            }
        });
    }, "json");
}

function inserirBancoDados() {
    if ($("#novo_banco_dados").val() === '') {
        swal({
            title: "Alerta",
            text: "A <strong>DESCRI&Ccedil;&Atilde;O</strong> do Banco de Dados (SGBD) &eacute; um campo obrigat&oacute;rio",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    $.post('/pf/DIM.Gateway.php', {
        // d = descricao
        'd': $("#novo_banco_dados").val(), 'arq': 23, 'tch': 0, 'sub': -1, 'dlg': 1
    }, function (data) {
        comboBancoDados('01', $('#id_banco_dados'));
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "A descri&ccedil;&atilde;o do Banco de Dados (SGBD) foi inserida com sucesso. #ID " + ("0000000" + data[0].id).slice(-7),
            type: "success",
            html: true,
            confirmButtonText: "Obrigado!"},
        function () {
            comboBancoDados('01', data[0].id);
            $("#novo_banco_dados").val('');
        });
    }, "json");
}
function validaFormFuncao(t) {
    var objRetorno = {'msg': '', 'sucesso': true, 'campo': ''};
    var fn;
    if (t === 'transacao') {
        fn = 'ar';
    } else if (t === 'dados') {
        fn = 'tr';
    }
    if (Number($('#' + t + '_id_roteiro').val()) == 0) {
        objRetorno.sucesso = false;
        objRetorno.msg = "O campo <strong>#ID ROTEIRO</strong> &eacute; de preenchimento obrigat&oacute;rio.";
        objRetorno.campo = $('#' + t + '_id_roteiro');
    } else if ($('#' + t + '_operacao').val() === '') {
        objRetorno.sucesso = false;
        objRetorno.msg = "O campo <strong>OPERA&Ccedil;&Atilde;O</strong> &eacute; de preenchimento obrigat&oacute;rio <i>(I - Inclus&atilde;o, A - Altera&ccedil;&atilde;o " + (t !== 'transacao' ? 'e/ou' : ', ') + " E - Exclus&atilde;o " + (t === 'transacao' ? 'e/ou T - Testes' : '') + ")</i>.";
        objRetorno.campo = $('#' + t + '_operacao');
    } else if ($('#' + t + '_metodo').val() === '') {
        objRetorno.sucesso = false;
        objRetorno.msg = "O campo <strong>M&Eacute;TODO</strong> &eacute; de preenchimento obrigat&oacute;rio <i>(N - Nesma, F - FP-LITE e D - Detalhado)</i>.";
        objRetorno.campo = $('#' + t + '_metodo');
    } else if (Number($('#' + t + '_entrega').val()) == 0 || $('#' + t + '_entrega').val() === '' || Number($('#' + t + '_entrega').val()) > Number($('#entregas').val())) {
        objRetorno.sucesso = false;
        if (Number($('#' + t + '_entrega').val()) == 0) {
            objRetorno.msg = "O campo <strong>ENTREGA</strong> &eacute; de preenchimento obrigat&oacute;rio e não pode ser 0 (zero).";
        } else if ($('#' + t + '_entrega').val() === '') {
            objRetorno.msg = "O campo <strong>ENTREGA</strong> &eacute; de preenchimento obrigat&oacute;rio.";
        } else if (Number($('#' + t + '_entrega').val()) > Number($('#entregas').val())) {
            objRetorno.msg = "O campo <strong>ENTREGA</strong> n&atilde;o pode ser maior que o definido na ABA - Informa&ccedil;&otilde;es da Contagem, que &eacute; " + $('#entregas').val() + " (" + $('#entregas').val().extenso() + ").";
        }
        objRetorno.campo = $('#' + t + '_entrega');
    } else if ($('#' + t + '_funcao').val() === '' || $('#' + t + '_funcao').val() == 0) {
        objRetorno.sucesso = false;
        objRetorno.msg = "O campo <strong>NOME DA FUN&Ccedil;&Atilde;O</strong> &eacute; de preenchimento obrigat&oacute;rio.";
        objRetorno.campo = $('#' + t + '_funcao');
    } else if ($('#' + t + '_td').val() === '') {
        objRetorno.sucesso = false;
        objRetorno.msg = "O campo <strong>TD</strong> &eacute; de preenchimento obrigat&oacute;rio.";
        objRetorno.campo = $('#' + t + '_td');
    } else if ($('#' + t + '_' + fn).val() === '') {
        objRetorno.sucesso = false;
        objRetorno.msg = "O campo <strong>TD</strong> &eacute; de preenchimento obrigat&oacute;rio.";
        objRetorno.campo = $('#' + t + '_' + fn);
    } else if (Number($('#' + t + '_impacto').val()) == 0) {
        objRetorno.sucesso = false;
        objRetorno.msg = "O campo <strong>AJUSTE</strong> &eacute; de preenchimento obrigat&oacute;rio.";
        objRetorno.campo = $('#' + t + '_impacto');
    } else if ($('#' + t + '-is-mudanca').prop('checked') && Number($('#' + t + '-fase').val()) == 0) {
        objRetorno.sucesso = false;
        objRetorno.msg = "Voc&ecirc; selecionou &quot;SIM&quot; para <strong>mudan&ccedil;as</strong> por&eacute;m n&atilde;o selecionou uma fase.";
    } else if ($('#' + t + '-is-mudanca').prop('checked') && $('#' + t + '-fase').val() != '' && $('#' + t + '-percentual-fase').val() === '') {
        objRetorno.sucesso = false;
        objRetorno.msg = "Voc&ecirc; selecionou &quot;SIM&quot; para <strong>mudan&ccedil;as</strong> e informou a fase, entretanto n&atilde;o informou qual &eacute; o percentual de andamento da fase.";
    }
    return objRetorno;
}
/**
 * 
 * @param {type}
 *            t - funcao (dados, transacao, outros)
 * @param {type}
 *            f - limpa todos menos o roteiro selecionado
 * @param {type}
 *            a - acao (alterar/inserir)
 * @returns {undefined}
 */
function limpaCampos(t, f, a) {
    /*
     * reseta a combo do roteiro
     */
    f ? comboRoteiro(t, '01', idRoteiro, 0) : null;
    /*
     * verifica se nao eh uma alteracao na funcao
     */
    if (a !== 'al') {
        /*
         * var idRoteiro = $('#' + t.toLowerCase() + '_id_roteiro').val();
         * comboFatorImpacto(idRoteiro, t, 0, 0, 0, 0); reseta os botoes
         * operacao (I, A e E)
         */
        $("#" + t + "_op1").attr("class", "btn btn-default").prop('disabled', false);
        $("#" + t + "_op2").attr("class", "btn btn-default").prop('disabled', (abAtual == 3 || abAtual == 4) ? true : (abAtual == 2 && $('#' + t + '_tabela').val() === 'AIE' ? true : false));
        $("#" + t + "_op3").attr("class", "btn btn-default").prop('disabled', (abAtual == 3 || abAtual == 4) ? true : false);
        (t === 'transacao') ? $("#" + t + "_op4").attr("class", "btn btn-default").prop('disabled', (abAtual == 3 || abAtual == 4) ? true : false) : null;
        /*
         * continua com a limpeza normal dos campos
         */
        $("#" + t + "_operacao").val("");
        $("#" + t + "_entrega").val(1);
        $("#" + t + "_pfa").val("");
        /*
         * zera os arrays dadosItems e transacaoItems
         */
        dadosItems = [];
        transacaoItems = [];
        /*
         * para funcoes de dados e transacao
         */
        if (t !== 'outros') {
            /*
             * verifica se eh baseline e deixa os botoes Nesma e FP-Lite
             * desabilitados
             */
            $("#" + t + "_me1").attr("class", "btn btn-default").prop('disabled', (abAtual != 3 ? false : true));
            $("#" + t + "_me2").attr("class", "btn btn-default").prop('disabled', (abAtual != 3 ? false : true));
            /*
             * continua com os outros campos
             */
            $("#" + t + "_me3").attr("class", "btn btn-default").prop('disabled', false);
            $("#" + t + "_metodo").val("");
            $("#" + t + "_complexidade").val("");
            $("#" + t + "-is-mudanca").bootstrapToggle('off').bootstrapToggle('disable');
            $("#" + t + "-fase").val(0).prop('disabled', true);
            $("#" + t + "-percentual-fase").val('').prop('readonly', true);
            $("#" + t + "_pfb").val('').prop('readonly', true);
            $("#" + t + "_fd").val("0.00").prop("disabled", true);
            $("#" + t + "_fe").val(0);
        } else {
            $("#" + t + "_qtd").val("").prop('disabled', false);
        }
        /*
         * reseta os outros campos de texto
         */
        $("#" + t + "_fonte").val("").prop('disabled', false);
        $("#" + t + "_impacto").empty().append('<option value="0">...</option>').val(0).prop('disabled', false);
        $("#" + t + "_observacoes").val("").prop('disabled', false);
        $("#" + t + "_observacoes_validacao").val("").prop('disabled', false);
        $('#' + t + '_funcao')
                .replaceWith('<input type="text" class="form-control input_style" id="' + t + '_funcao" name="' + t + '_funcao" autocomplete="off">').val("").prop('disabled', false);
        /*
         * limpa os campos especificos de cada funcionalidade
         */
        if (t === 'dados') {
            $("#" + t + "_td").val("").prop('readonly', true);
            $("#" + t + "_tr").val("").prop('readonly', true);
            $("#" + t + "_descricao_tr").val("").prop('disabled', false).tagsManager('empty');
        } else if (t === 'transacao') {
            $("#" + t + "_td").val("").prop('readonly', true);
            $("#" + t + "_ar").val("").prop('readonly', true);
            $("#" + t + "_descricao_ar").val("").prop('disabled', false).tagsManager('empty');
        }
        $("#" + t + "_descricao_td").val("").prop('disabled', false).tagsManager('empty');
    } else {
        $("#" + t + "-is-mudanca").bootstrapToggle('enable').bootstrapToggle('off').bootstrapToggle('disable');
        $("#" + t + "-fase").val(0).prop('disabled', true);
        $("#" + t + "-percentual-fase").val('').prop('readonly', true);
        $("#" + t + "_pfa").val('');
    }
    // o campo de log sera limpo de qualquer forma
    $('#' + t + '_log').empty();
    // a combobox de AR para copiar e colar tambem sera limpa
    $('#sel_funcao_transacao').empty().append('<option value="0">...</option>');
    // esconde os popovers
    pBaseline = false; // baseline AR pesquisa
    bAR = false; // baseline TD/AR pesquisa
    $('[data-toggle="popover"]').popover("hide");
    // operacao especial para alterar o nome da funcao de dados
    if (t === 'dados' && a === 'al') {
        // desabilita o input com o nome da funcao e o botao alterar nome apenas
        // para a funcao de dados ALI e AIE
        $('#dados_funcao').prop('readonly', true).css({'background-color': '#ffffe5'});
        $('#alterar-funcao-dados').removeClass('cancelar').addClass('alterar').removeClass('btn-warning').addClass('btn-default').html('<i class="fa fa-edit"></i>&nbsp;Alterar').prop('disabled', false);
        // limpa tambem o nome anterior da funcao
    }
    else {
        $('#dados_funcao').prop('readonly', false);
        $('#alterar-funcao-dados').removeClass('cancelar').addClass('alterar').removeClass('btn-warning').addClass('btn-default').html('<i class="fa fa-edit"></i>&nbsp;Alterar').prop('disabled', true);
    }
    $('#dados_funcao_nome_anterior').val('');
    $('#dados_funcao_is_alterar_nome').val('0');
}
/**
 * Exemplo: verificaTd($('#transacao_tabela').val(), 'transacao',
 * $('#transacao_td'), $(this));
 * 
 * @param {type}
 *            t - tabela ALI, AIE, etc.
 * @param {type}
 *            f - funcao (dados/transacao)
 * @param {type}
 *            d - campo TD
 * @param {type}
 *            r - campo TR/AR
 * @returns {undefined}
 */
function limpaCamposLinha(t, f, d, r) {
    if (Number($(d).val()) == 0) {
        if (t === 'ALI' || t === 'AIE' || t === 'EE' || t === 'CE') {
            swal({
                title: "Alerta",
                text: "A quantidade de Tipos de Dados (TD) &eacute; obrigat&oacute;ria e n&atilde;o pode ser 0 (zero)!",
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"}, function () {
                $(d).val('').get(0).focus();
                return false;
            });
        }
    }
    // se possuir um valor em AR e/ou TR calcula de volta
    r !== '' ? calculaLinhaPF(t, f, d, r) : null;
}
/**
 * Exemplo: verificaTd($('#transacao_tabela').val(), 'transacao',
 * $('#transacao_td'), $(this));
 * 
 * @param {type}
 *            t - tabela ALI, AIE, etc.
 * @param {type}
 *            f - funcao (dados/transacao)
 * @param {type}
 *            d - campo TD
 * @param {type}
 *            r - campo TR/AR
 * @returns {undefined}
 */
function verificaTd(t, f, d, r) {
    if (Number($(d).val()) === '') {
        swal({
            title: "Alerta",
            text: "Por favor, digite a quantidade de Tipo de Dados (TD) antes de digitar a quantidade de " + (t === 'ALI' || t === 'AIE') ? 'Tipos de Registros (TR)!' : 'Arquivos Referenciados (AR)',
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"}, function () {
            $(r).val('');
            $(d).get(0).focus();
            return false;
        });
    }
    // so pode ser zero em EE, SE e CE
    if (Number($(r).val()) == 0) {
        if (t === 'ALI' || t === 'AIE') {
            swal({
                title: "Alerta",
                text: "A quantidade de Tipos de Registros (TR) &eacute; obrigat&oacute;ria e n&atilde;o pode ser 0 (zero)!",
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"},
            function () {
                $(r).val('').get(0).focus();
                return false;
            });
        }
    }
    calculaLinhaPF(t, f, d, r);
}
/*
 * 
 * @param {type} t - tabela ALI, AIE, etc. @param {type} f - funcao
 * (dados/transacao) @param {type} d - campo TD @param {type} r - campo TR/AR
 * @returns {undefined}
 */
function calculaLinhaPF(t, f, d, r) {
    var td = $(d).val(); // td
    var tr = $(r).val(); // ar, tr
    var c;
    var p;
    if (tr === '') {
        $('#' + f + '_complexidade').val('');
        $('#' + f + '_pfb').val('');
    } else {
        switch (t) {
            case "ALI":
                if (abAtual == 9) {
                    c = "EFd";
                    p = Number(1.75) + Number(0.96 * tr) + Number(0.12 * td);
                } else {
                    if ((tr == 1 && td <= 50) || (tr <= 5 && td < 20)) {
                        c = "Baixa";
                        p = Number(7);
                    } else {
                        if ((tr == 1 && td > 50) || ((tr >= 2 && tr <= 5) && (td >= 20 && td <= 50)) || (tr > 5 && td < 20)) {
                            c = "Media";
                            p = Number(10);
                        } else {
                            c = "Alta";
                            p = Number(15);
                        }
                    }
                }
                break;
            case "AIE":
                if (abAtual == 9) {
                    c = "EFd";
                    p = Number(1.25) + Number(0.65 * tr) + Number(0.08 * td);
                } else {
                    if ((tr == 1 && td <= 50) || (tr <= 5 && td < 20)) {
                        c = "Baixa";
                        p = Number(5);
                    } else {
                        if ((tr == 1 && td > 50) || ((tr >= 2 && tr <= 5) && (td >= 20 && td <= 50)) || (tr > 5 && td < 20)) {
                            c = "Media";
                            p = Number(7);
                        } else {
                            c = "Alta";
                            p = Number(10);
                        }
                    }
                }
                break;
            case "EE":
                if (abAtual == 9) {
                    c = "EFt";
                    p = Number(0.75) + Number(0.91 * tr) + Number(0.13 * td);
                } else {
                    if ((tr < 2 && td <= 15) || (tr == 2 && td < 5)) {
                        c = "Baixa";
                        p = Number(3);
                    } else {
                        if ((tr < 2 && td > 15) || (tr == 2 && (td >= 5 && td <= 15)) || (tr > 2 && td < 5)) {
                            c = "Media";
                            p = Number(4);
                        } else {
                            c = "Alta";
                            p = Number(6);
                        }
                    }
                }
                break;
            case "SE":
                if (abAtual == 9) {
                    c = "EFt";
                    p = Number(1) + Number(0.81 * tr) + Number(0.13 * td);
                } else {
                    if ((tr < 2 && td < 20) || ((tr == 2 || tr == 3) && td < 6)) {
                        c = "Baixa";
                        p = Number(4);
                    } else {
                        if ((tr < 2 && td > 19) || ((tr == 2 || tr == 3) && td < 20) || (td > 3 && td < 6)) {
                            c = "Media";
                            p = Number(5);
                        } else {
                            c = "Alta";
                            p = Number(7);
                        }
                    }
                }
                break;
            case "CE":
                if (abAtual == 9) {
                    c = "EFt";
                    p = Number(0.75) + Number(0.76 * tr) + Number(0.10 * td);
                } else {
                    if ((tr < 2 && td < 20) || ((tr == 2 || tr == 3) && td < 6)) {
                        c = "Baixa";
                        p = Number(3);
                    } else {
                        if ((tr < 2 && td > 19) || ((tr == 2 || tr == 3) && td < 20) || (tr > 3 && td < 6)) {
                            c = "Media";
                            p = Number(4);
                        } else {
                            c = "Alta";
                            p = Number(6);
                        }
                    }
                }
                break;
        }

        $('#' + f + '_complexidade').val(c);
        $('#' + f + '_pfb').val(p.toFixed(4));
    }

    return true;
}

/*
 * 
 * @param {type} t - tabela ALI, AIE, etc. @param {type} d - campo TD @param
 * {type} r - campo TR/AR @returns {undefined}
 */
function calculaLinhaPF_v2(t, td, tr) {
    var linhaPF = {'c': '', 'p': 0};
    switch (t) {
        case "ALI":
            if (abAtual == 9) {
                linhaPF.c = "EFd";
                linhaPF.p = Number(1.75) + Number(0.96 * tr) + Number(0.12 * td);
            } else {
                if ((tr == 1 && td <= 50) || (tr <= 5 && td < 20)) {
                    linhaPF.c = "Baixa";
                    linhaPF.p = Number(7);
                } else {
                    if ((tr == 1 && td > 50) || ((tr >= 2 && tr <= 5) && (td >= 20 && td <= 50)) || (tr > 5 && td < 20)) {
                        linhaPF.c = "Media";
                        linhaPF.p = Number(10);
                    } else {
                        linhaPF.c = "Alta";
                        linhaPF.p = Number(15);
                    }
                }
            }
            break;
        case "AIE":
            if (abAtual == 9) {
                linhaPF.c = "EFd";
                linhaPF.p = Number(1.25) + Number(0.65 * tr) + Number(0.08 * td);
            } else {
                if ((tr == 1 && td <= 50) || (tr <= 5 && td < 20)) {
                    linhaPF.c = "Baixa";
                    linhaPF.p = Number(5);
                } else {
                    if ((tr == 1 && td > 50) || ((tr >= 2 && tr <= 5) && (td >= 20 && td <= 50)) || (tr > 5 && td < 20)) {
                        linhaPF.c = "Media";
                        linhaPF.p = Number(7);
                    } else {
                        linhaPF.c = "Alta";
                        linhaPF.p = Number(10);
                    }
                }
            }
            break;
        case "EE":
            if (abAtual == 9) {
                linhaPF.c = "EFt";
                linhaPF.p = Number(0.75) + Number(0.91 * tr) + Number(0.13 * td);
            } else {
                if ((tr < 2 && td <= 15) || (tr == 2 && td < 5)) {
                    linhaPF.c = "Baixa";
                    linhaPF.p = Number(3);
                } else {
                    if ((tr < 2 && td > 15) || (tr == 2 && (td >= 5 && td <= 15)) || (tr > 2 && td < 5)) {
                        linhaPF.c = "Media";
                        linhaPF.p = Number(4);
                    } else {
                        linhaPF.c = "Alta";
                        linhaPF.p = Number(6);
                    }
                }
            }
            break;
        case "SE":
            if (abAtual == 9) {
                linhaPF.c = "EFt";
                linhaPF.p = Number(1) + Number(0.81 * tr) + Number(0.13 * td);
            } else {
                if ((tr < 2 && td < 20) || ((tr == 2 || tr == 3) && td < 6)) {
                    linhaPF.c = "Baixa";
                    linhaPF.p = Number(4);
                } else {
                    if ((tr < 2 && td > 19) || ((tr == 2 || tr == 3) && td < 20) || (td > 3 && td < 6)) {
                        linhaPF.c = "Media";
                        linhaPF.p = Number(5);
                    } else {
                        linhaPF.c = "Alta";
                        linhaPF.p = Number(7);
                    }
                }
            }
            break;
        case "CE":
            if (abAtual == 9) {
                linhaPF.c = "EFt";
                linhaPF.p = Number(0.75) + Number(0.76 * tr) + Number(0.10 * td);
            } else {
                if ((tr < 2 && td < 20) || ((tr == 2 || tr == 3) && td < 6)) {
                    linhaPF.c = "Baixa";
                    linhaPF.p = Number(3);
                } else {
                    if ((tr < 2 && td > 19) || ((tr == 2 || tr == 3) && td < 20) || (tr > 3 && td < 6)) {
                        linhaPF.c = "Media";
                        linhaPF.p = Number(4);
                    } else {
                        linhaPF.c = "Alta";
                        linhaPF.p = Number(6);
                    }
                }
            }
            break;
    }
    return linhaPF;
}
/**
 * 
 * @param {int}
 *            qtd - quantidade de registros
 * @param {string}
 *            funcao - dados/transacao
 * @param {string}
 *            campo - td - tr - ar
 * @param {string}
 *            tabela - ALI, AIE, etc.
 * @returns {boolean}
 */
function calculaLinhaPFDetalhada(qtd, funcao, campo, tabela) {
    /*
     * primeiro teste para limpeza dos campos || $('#' + funcao + '_' +
     * campo).val() === ''
     */
    if (qtd.length < 1) {
        if (funcao === 'dados') {
            $('#' + funcao + '_' + campo).val('');
            $('#' + funcao + '_complexidade').val('');
            $('#' + funcao + '_pfb').val('');
            $('#' + funcao + '_pfa').val('');
        } else {
            if (tabela === 'SE') {
                $('#' + funcao + '_' + campo).val('0');
                // quando e SE calcula sempre
                calculaLinhaPF(tabela, funcao, $('#' + funcao + '_td'), $('#' + funcao + '_ar'));
                // verifica o impacto e ja calcula os pfa
                if ($('#' + funcao + '_impacto').val() !== '0') {
                    calculaPfa($('#' + funcao + '_impacto'), $('#' + funcao + '_pfb'), $('#' + funcao + '_pfa'), funcao);
                }
            } else {
                if (tabela === 'EE' || tabela === 'CE') {
                    if (campo === 'td') {
                        $('#' + funcao + '_' + campo).val('');
                    } else {
                        $('#' + funcao + '_' + campo).val('0');
                    }
                }
                $('#' + funcao + '_complexidade').val('');
                $('#' + funcao + '_pfb').val('');
                $('#' + funcao + '_pfa').val('');
            }
        }
    } else {
        // atribui o valor ao campo
        $('#' + funcao + '_' + campo).val(qtd.length);
        // realiza os testes de validacao
        if (tabela === 'ALI' || tabela === 'AIE') {
            if ($('#' + funcao + '_td').val() !== '' && $('#' + funcao + '_tr').val() !== '') {
                calculaLinhaPF($('#' + funcao + '_tabela').val(), funcao, $('#' + funcao + '_td'), funcao === 'dados' ? $('#' + funcao + '_tr') : $('#' + funcao + '_ar'));
                // verifica se o impacto ja esta selecionado
                if (Number($('#' + funcao + '_td').val()) > 0 && Number($('#' + funcao + '_tr').val()) > 0 && $('#' + funcao + '_impacto').val() !== '0') {
                    calculaPfa($('#' + funcao + '_impacto'), $('#' + funcao + '_pfb'), $('#' + funcao + '_pfa'), funcao);
                }
            }
        } else {
            if (tabela !== 'SE') {
                if ($('#' + funcao + '_td').val() !== '') {
                    calculaLinhaPF($('#' + funcao + '_tabela').val(), funcao, $('#' + funcao + '_td'), funcao === 'dados' ? $('#' + funcao + '_tr') : $('#' + funcao + '_ar'));
                    // verifica se o impacto ja esta selecionado
                    if (Number($('#' + funcao + '_td').val()) >= 0 && $('#' + funcao + '_impacto').val() !== '0') {
                        calculaPfa($('#' + funcao + '_impacto'), $('#' + funcao + '_pfb'), $('#' + funcao + '_pfa'), funcao);
                    }
                }
            } else {
                calculaLinhaPF($('#' + funcao + '_tabela').val(), funcao, $('#' + funcao + '_td'), funcao === 'dados' ? $('#' + funcao + '_tr') : $('#' + funcao + '_ar'));
                // verifica o impacto e ja calcula os pfa
                if ($('#' + funcao + '_impacto').val() !== '0') {
                    calculaPfa($('#' + funcao + '_impacto'), $('#' + funcao + '_pfb'), $('#' + funcao + '_pfa'), funcao);
                }
            }
        }
    }
    return true;
}
function verificaData(Data) {
    Data = Data.substring(0, 10);
    var dma = -1;
    var data = Array(3);
    var ch = Data.charAt(0);
    for (i = 0; i < Data.length && ((ch >= '0' && ch <= '9') || (ch === '/' && i !== 0)); ) {
        data[++dma] = '';
        if (ch !== '/' && i !== 0)
            return false;
        if (i !== 0)
            ch = Data.charAt(++i);
        if (ch === 0)
            ch = Data.charAt(++i);
        while (ch >= 0 && ch <= 9) {
            data[dma] += ch;
            ch = Data.charAt(++i);
        }
    }
    if (ch !== '')
        return false;
    if (data[0] === '' || isNaN(data[0]) || parseInt(data[0]) < 1)
        return false;
    if (data[1] === '' || isNaN(data[1]) || parseInt(data[1]) < 1 || parseInt(data[1]) > 12)
        return false;
    if (data[2] === '' || isNaN(data[2]) || ((parseInt(data[2]) < 0 || parseInt(data[2]) > 99) && (parseInt(data[2]) < 1900 || parseInt(data[2]) > 9999)))
        return false;
    if (data[2] < 50)
        data[2] = parseInt(data[2]) + 2000;
    else if (data[2] < 100)
        data[2] = parseInt(data[2]) + 1900;
    switch (parseInt(data[1])) {
        case 2:
        {
            if (((parseInt(data[2]) % 4 !== 0 || (parseInt(data[2]) % 100 === 0 && parseInt(data[2]) % 400 !== 0)) && parseInt(data[0]) > 28) || parseInt(data[0]) > 29)
                return false;
            break;
        }
        case 4:
        case 6:
        case 9:
        case 11:
        {
            if (parseInt(data[0]) > 30)
                return false;
            break;
        }
        default:
        {
            if (parseInt(data[0]) > 31)
                return false;
        }
    }
    return true;
}
function getSpanPfa(t, d) {
    // t = tabela - ALI, AIE, etc
    // d = decimais (true, false)
    var pfa = Number($("#pfa" + t).html());
    if (d)
        return pfa.toFixed(4);
    else
        return pfa.toFixed(0);
}
function getSpanPfb(t, d) {
    // t = tabela - ALI, AIE, etc
    // d = decimais (true, false)
    var pfb = Number($("#pfb" + t).html());
    if (d)
        return pfb.toFixed(4);
    else
        return pfb.toFixed(0);
}
function getObject() {
    return RGraph.ObjectRegistry.getFirstObjectByType('bar');
}
function getTotalFuncoes(tipo) {
    // retorna o total dos pfa/pfb das funcoes na tela
    var objTotalFuncoes = {"ali": Number(0), "aie": Number(0), "ee": Number(0), "se": Number(0), "ce": Number(0), "ou": Number(0), "total": Number(0)};
    objTotalFuncoes.ali = Number($("#" + tipo + "ALI").html());
    objTotalFuncoes.aie = Number($("#" + tipo + "AIE").html());
    objTotalFuncoes.ee = Number($("#" + tipo + "EE").html());
    objTotalFuncoes.se = Number($("#" + tipo + "SE").html());
    objTotalFuncoes.ce = Number($("#" + tipo + "CE").html());
    if (tipo === 'pfa') {
        objTotalFuncoes.ou = Number($("#" + tipo + "OU").html());
    } else {
        objTotalFuncoes.ou = Number(0);
    }
    objTotalFuncoes.total = Number(
            objTotalFuncoes.ali +
            objTotalFuncoes.aie +
            objTotalFuncoes.ee +
            objTotalFuncoes.se +
            objTotalFuncoes.ce +
            objTotalFuncoes.ou);
    return objTotalFuncoes;
}
function getComplexidade(f) {
    /*
     * variaveis associadas a complexidade na tab de estatisticas
     */
    var objComplexidade = {"alta": Number(0), "media": Number(0), "baixa": Number(0)};
    $("#add" + f + " tr:lt(2000)").each(function () {
        var this_row = $(this);
        var c = $.trim(this_row.find('td:eq(5)').text());
        switch (c) {
            case 'Alta':
                objComplexidade.alta++;
                break;
            case 'Media':
                objComplexidade.media++;
                break;
            case 'Baixa':
                objComplexidade.baixa++;
                break;
        }
    });
    return objComplexidade;
}
/*
 * funcao que retorna os percentuas e totais das fases para os calculos
 * relativos a mudancas em dados e transacao
 */
function getPercentuais(fase) {
    var percentuais = {"pctFase": Number(0), "pctTotal": Number(0)};
    switch (fase) {
        case 'ENG':
            percentuais.pctTotal = parseFloat(config_isEng ? parseFloat(config_pctEng) : 0);
            percentuais.pctFase = parseFloat(config_isEng ? parseFloat(config_pctEng) : 0);
            break;
        case 'DES':
            percentuais.pctTotal = parseFloat(config_isEng ? parseFloat(config_pctEng) : 0);
            percentuais.pctFase = parseFloat(config_isEng ? parseFloat(config_pctDes) : 0);
            break;
        case 'IMP':
            percentuais.pctTotal = parseFloat(config_isEng ? parseFloat(config_pctEng) : 0) +
                    parseFloat(config_isDes ? parseFloat(config_pctDes) : 0);
            percentuais.pctFase = parseFloat(config_isImp ? parseFloat(config_pctImp) : 0);
            break;
        case 'TES':
            percentuais.pctTotal = parseFloat(config_isEng ? parseFloat(config_pctEng) : 0) +
                    parseFloat(config_isDes ? parseFloat(config_pctDes) : 0) +
                    parseFloat(config_isImp ? parseFloat(config_pctImp) : 0);
            percentuais.pctFase = parseFloat(config_isTes ? parseFloat(config_pctTes) : 0);
            break;
        case 'HOM':
            percentuais.pctTotal = parseFloat(config_isEng ? parseFloat(config_pctEng) : 0) +
                    parseFloat(config_isDes ? parseFloat(config_pctDes) : 0) +
                    parseFloat(config_isImp ? parseFloat(config_pctImp) : 0) +
                    parseFloat(config_isTes ? parseFloat(config_pctTes) : 0);
            percentuais.pctFase = parseFloat(config_isHom ? parseFloat(config_pctHom) : 0);
            break;
        case 'IMPL':
            percentuais.pctTotal = parseFloat(config_isEng ? parseFloat(config_pctEng) : 0) +
                    parseFloat(config_isDes ? parseFloat(config_pctDes) : 0) +
                    parseFloat(config_isImp ? parseFloat(config_pctImp) : 0) +
                    parseFloat(config_isTes ? parseFloat(config_pctTes) : 0) +
                    parseFloat(config_isHom ? parseFloat(config_pctHom) : 0);
            percentuais.pctFase = parseFloat(config_isImpl ? parseFloat(config_pctImpl) : 0);
            break;
    }
    return percentuais;
}
function getOperacao(f) {
    /*
     * variaveis associadas a operacao na tab de estatisticas TODO: ver a
     * questao de numeros maiores que 2000 CRITICO
     */
    var objOperacao = {"inclusao": Number(0), "alteracao": Number(0), "exclusao": Number(0)};
    $("#add" + f + " tr:lt(2000)").each(function () {
        var this_row = $(this);
        var c = $.trim(this_row.find('td:eq(1)').text());
        switch (c) {
            case 'I':
                objOperacao.inclusao++;
                break;
            case 'A':
                objOperacao.alteracao++;
                break;
            case 'E':
                objOperacao.exclusao++;
                break;
        }
    });
    return objOperacao;
}
function zeraArrayValida(t) {
// t = tabela
// zera os arrays no caso de selecao de todos
    switch (t) {
        case 'ALI':
            arrValidaALI.length = 0;
            break
        case 'AIE':
            arrValidaAIE.length = 0;
            break
        case 'EE':
            arrValidaEE.length = 0;
            break
        case 'SE':
            arrValidaSE.length = 0;
            break
        case 'CE':
            arrValidaCE.length = 0;
            break
        case 'OU':
            arrValidaOU.length = 0;
            break
    }
}

function zeraLinhasSelecionadas(t) {
    var seq = 1;
    $("#fix" + t + " tr:gt(0)").each(function () {
        if ($(this).hasClass('tr-selecionada')) {
            $(this).find('td:lt(13)').css({backgroundColor: 'rgba(255,255,255,1)'});
            $(this).toggleClass('tr-selecionada');
            $('#seq_' + t + '_' + seq).toggleClass('div-linha').toggleClass('selecionada');
        }
        seq++;
    });
    /*
     * atualiza o cabecalho com os itens selecionados
     */
    atualizaSelecionados(t);
}

function atualizaSelecionados(t) {
    switch (t) {
        case 'ALI':
            $('#span-selecionados-ALI').html(arrValidaALI.length);
            break;
        case 'AIE':
            $('#span-selecionados-AIE').html(arrValidaAIE.length);
            break;
        case 'EE':
            $('#span-selecionados-EE').html(arrValidaEE.length);
            break;
        case 'SE':
            $('#span-selecionados-SE').html(arrValidaSE.length);
            break;
        case 'CE':
            $('#span-selecionados-CE').html(arrValidaCE.length);
            break;
        case 'OU':
            $('#span-selecionados-OU').html(arrValidaOU.length);
            break;
    }

}

function arrayValida(i, t) {
    // i = id da funcao, t = tabela (ALI, AIE, etc)
    switch (t) {
        case 'ALI':
            if (arrValidaALI.indexOf(i) === -1) {
                arrValidaALI.push(i);
            } else {
                arrValidaALI.splice(arrValidaALI.indexOf(i), 1);
            }
            atualizaSelecionados(t);
            break;
        case 'AIE':
            if (arrValidaAIE.indexOf(i) === -1) {
                arrValidaAIE.push(i);
            } else {
                arrValidaAIE.splice(arrValidaAIE.indexOf(i), 1);
            }
            atualizaSelecionados(t);
            break;
        case 'EE':
            if (arrValidaEE.indexOf(i) === -1) {
                arrValidaEE.push(i);
            } else {
                arrValidaEE.splice(arrValidaEE.indexOf(i), 1);
            }
            atualizaSelecionados(t);
            break;
        case 'SE':
            if (arrValidaSE.indexOf(i) === -1) {
                arrValidaSE.push(i);
            } else {
                arrValidaSE.splice(arrValidaSE.indexOf(i), 1);
            }
            atualizaSelecionados(t);
            break;
        case 'CE':
            if (arrValidaCE.indexOf(i) === -1) {
                arrValidaCE.push(i);
            } else {
                arrValidaCE.splice(arrValidaCE.indexOf(i), 1);
            }
            atualizaSelecionados(t);
            break;
        case 'OU':
            if (arrValidaOU.indexOf(i) === -1) {
                arrValidaOU.push(i);
            } else {
                arrValidaOU.splice(arrValidaOU.indexOf(i), 1);
            }
            atualizaSelecionados(t);
            break;
    }
}

function selecionadaFaturar(i) {
    if (arrFaturar.indexOf(i) === -1) {
        arrFaturar.push(i);
    } else {
        arrFaturar.splice(arrFaturar.indexOf(i), 1);
    }
}

function zeraSelecionadaFaturar(v) {
    $("#dataTable tr:gt(0)").each(function () {
        if ($(this).hasClass('tr-selecionada')) {
            $(this).find('td:lt(13)').css({backgroundColor: ''});
            $(this).removeClass('tr-selecionada');
            // retira o fau e coloca o fat para evitar o clique novamente
            // apenas na chamada ao final do faturamento
            v ? $(this).find('td:eq(3)').parent().find('div').removeClass('fau').addClass('fat') : null;
        }
    });
    arrFaturar = [];
}

/*
 * situacao 0 - inserida 1 - nao validada 2 - validada 3 - revisao 4 - revisada
 */
function setSituacao(situacao, cell1) {
    var cell = document.getElementById(cell1);
    switch (Number(situacao)) {
        case 0:
            cell.style.backgroundImage = "url('/pf/img/bg_nn.png')";
            break; // inserida recentemente
        case 1:
            cell.style.backgroundImage = "url('/pf/img/bg_nv.png')";
            break; // nao validada
        case 2:
            cell.className = 'validada';
            cell.style.backgroundImage = "url('/pf/img/bg_va.png')";
            break; // validada
        case 3:
            cell.className = 'revisao';
            cell.style.backgroundImage = "url('/pf/img/bg_mu.png')";
            break; // em revisao
        case 4:
            cell.className = 'revisada';
            cell.style.backgroundImage = "url('/pf/img/bg_re.png')";
            break; // revisada
    }
    /*cell.style.backgroundColor = "rgba(224,224,224,.5)";*/
    /*cell.style.backgroundColor = "rgba(255,255,255,1)";*/
    cell.style.backgroundRepeat = "repeat-y";
    situacaoLinha = situacao;
}
/*
 * imprime os quadrados indicando se existem mensagens de Validacao, Validacao
 * Externa e/ou Auditoria
 */
function setMensagens(obsValidador, obsValidadorExterno, obsAuditor, cell2, id) {
    var va = obsValidador;
    var ve = obsValidadorExterno;
    var au = obsAuditor;
    var htva = ''; // conteudo html
    var htve = '';
    var htau = '';
    if (va === '' || va === undefined) {
        htva = '<div class="msg-off"></div>';
    } else {
        htva = '<div class="msg-on">VA</div>';
    }
    if (ve === '' || ve === undefined) {
        htve = '<div class="msg-off"></div>';
    } else {
        htve = '<div class="msg-on">VE</div>';
    }
    if (au === '' || au === undefined) {
        htau = '<div class="msg-off"></div>';
    } else {
        htau = '<div class="msg-on">AU</div>';
    }
    cell2.innerHTML = htva + '' + htve + '' + htau;
}
/*
 * seleciona as linhas para validacao t = tabela b = boolean (true ou false) ...
 * selecionar/retirar selecao
 * quando o SEQ for clicado
 */
function selecionaLinhasValidacao(t, b) {
    // entrou aqui limpa tudo
    zeraArrayValida(t);
    zeraLinhasSelecionadas(t);
    var seq = 1;
    var linha = 1;
    if ($(b).prop('checked')) { // inserindo a selecao
        $("#fix" + t + " tr:gt(0)").each(function () {
            if (!($(this).hasClass('tr-selecionada')) && !($(this).find('td:eq(0)').hasClass('validada')) && !($(this).find('td:eq(0)').hasClass('revisao'))) {
                $(this).find('td:lt(13)').css({backgroundColor: 'rgba(168, 178, 213, 1)'});
                $(this).toggleClass('tr-selecionada');
                $('#seq_' + t + '_' + linha).toggleClass('selecionada').toggleClass('div-linha');
                seq++;
            }
            linha++;
        });
        if (seq > 1) {
            $("input[name=id_" + t + "]").each(function (i) {
                if (!($(this).parent().parent().hasClass('validada')) && !($(this).parent().parent().hasClass('revisao'))) {
                    i = Number($(this).val());
                    arrayValida(i, t);
                }
            });
        } else if (seq == 1) {
            var msg_alerta = "O sistema verificou que todas as linhas j&aacute; est&atilde;o validadas ou foram enviadas para revisao.";
            switch (t) {
                case 'ALI':
                    if (qtdALI == 1)
                        msg_alerta = "N&atilde;o h&aacute; Arquivos L&oacute;gicos Internos a serem validados.";
                    break;
                case 'AIE':
                    if (qtdAIE == 1)
                        msg_alerta = "N&atilde;o h&aacute; Arquivos de Interface Externa a serem validados.";
                    break;
                case 'EE':
                    if (qtdEE == 1)
                        msg_alerta = "N&atilde;o h&aacute; Entradas Externas a serem validadas.";
                    break;
                case 'SE':
                    if (qtdSE == 1)
                        msg_alerta = "N&atilde;o h&aacute; Sa&iacute;das Externas a serem validadas.";
                    break;
                case 'CE':
                    if (qtdCE == 1)
                        msg_alerta = "N&atilde;o h&aacute; Consultas Externas a serem validadas.";
                    break;
                case 'OU':
                    if (qtdOU == 1)
                        msg_alerta = "N&atilde;o h&aacute; Outras Funcionalidades a serem validadas.";
                    break;
            }
            swal({
                title: "Alerta",
                text: msg_alerta,
                type: "error",
                html: true,
                confirmButtonText: "Entendi, obrigado!"});
            $(b).prop('checked', false);
        }
    }
    // obrigatoria a verificacao do botao "Validar"
    habilitaBotaoValidar(t);
    habilitaBotaoRevisar(t);
}
/*
 * seleciona uma linha por vez para a validacao l = linha r = objeto row t =
 * tabela
 */
function selecionaLinhaValidacao(l, r, t, i) {
    iWait('w_' + t.toLowerCase(), true); // minuscula ali, aie, etc...
    $.post('/pf/DIM.Gateway.php', {'i': i, 't': t.toLowerCase(), 'arq': 57, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        if (data.situacao == 2 || data.situacao == 3) {
            // adiciona/remove no array
            arrayValida(i, t);
            swal({
                title: "Alerta",
                text: "Esta linha j&aacute; est&aacute; validada ou j&aacute; foi enviada para revis&atilde;o.<br /><br />Deseja desfazer a a&ccedil;&atilde;o?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#5cb85c",
                cancelButtonColor: "#f0ad4e",
                confirmButtonText: "Sim, por favor",
                cancelButtonText: "Não, obrigado",
                closeOnConfirm: true,
                html: true
            }, function (isConfirm) {
                if (isConfirm) {
                    switch (t) {
                        case 'ALI':
                            validarFuncao('ali', arrValidaALI, 'nvalidar');
                            break;
                        case 'AIE':
                            validarFuncao('aie', arrValidaAIE, 'nvalidar');
                            break;
                        case 'EE':
                            validarFuncao('ee', arrValidaEE, 'nvalidar');
                            break;
                        case 'SE':
                            validarFuncao('se', arrValidaSE, 'nvalidar');
                            break;
                        case 'CE':
                            validarFuncao('ce', arrValidaCE, 'nvalidar');
                            break;
                        case 'OU':
                            validarFuncao('ou', arrValidaOU, 'nvalidar');
                            break;
                    }
                } else {
                    // adiciona/remove no array
                    arrayValida(i, t);
                }
            });
            iWait('w_' + t.toLowerCase(), false);
        } else if (data.situacao == 4 && ac === 're') {
            arrayValida(i, t);
            swal({
                title: "Alerta",
                text: "Esta linha j&aacute; foi revisada.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#5cb85c",
                cancelButtonColor: "#f0ad4e",
                confirmButtonText: "Sim, por favor",
                cancelButtonText: "Não, obrigado",
                closeOnConfirm: true,
                html: true});
        } else {
            // retira o loop ajax
            iWait('w_' + t.toLowerCase(), false);
            // verifica se ha uma classe de selecao e retira
            if ($(l).hasClass('selecionada')) {
                $(r).each(function () { // retirando a selecao
                    $(this).find('td:lt(13)').css({backgroundColor: 'rgba(255, 255, 255, 1)'});
                    if ($('#select-' + t).prop('checked')) {
                        $('#select-' + t).prop('checked', false);
                    }
                    $(r).toggleClass('tr-selecionada');
                });
            } else {
                $(r).each(function () { // inserindo a selecao
                    $(this).find('td:lt(13)').css({backgroundColor: 'rgba(168, 178, 213, 1)'});
                });
                $(r).toggleClass('tr-selecionada');
            }
            $(l).toggleClass('selecionada').toggleClass('div-linha');
            // adiciona/remove no array
            arrayValida(i, t);
            // verifica se a quantidade eh maior que zero e habilita ou
            // desabilita o bota de selecionar todos
            verificaSelecionados(t);
            // habilita / desabilita o botao de validacao e/ou o de revisao
            habilitaBotaoValidar(t);
            habilitaBotaoRevisar(t);
        }
        iWait('w_' + t.toLowerCase(), false);
    }, 'json');
}

function habilitaBotaoValidar(t) {
    // habilita o botao validar caso o arrayValida* seja maior que zero
    switch (t) {
        case 'ALI':
            if (arrValidaALI.length > 0)
                $('#btn_validar_' + t).prop('disabled', false);
            else
                $('#btn_validar_' + t).prop('disabled', true);
            break;
        case 'AIE':
            if (arrValidaAIE.length > 0)
                $('#btn_validar_' + t).prop('disabled', false);
            else
                $('#btn_validar_' + t).prop('disabled', true);
            break;
        case 'EE':
            if (arrValidaEE.length > 0)
                $('#btn_validar_' + t).prop('disabled', false);
            else
                $('#btn_validar_' + t).prop('disabled', true);
            break;
        case 'SE':
            if (arrValidaSE.length > 0)
                $('#btn_validar_' + t).prop('disabled', false);
            else
                $('#btn_validar_' + t).prop('disabled', true);
            break;
        case 'CE':
            if (arrValidaCE.length > 0)
                $('#btn_validar_' + t).prop('disabled', false);
            else
                $('#btn_validar_' + t).prop('disabled', true);
            break;
        case 'OU':
            if (arrValidaOU.length > 0)
                $('#btn_validar_' + t).prop('disabled', false);
            else
                $('#btn_validar_' + t).prop('disabled', true);
            break;
    }
}
function habilitaBotaoRevisar(t) {
    // habilita o botao revisar caso o arrayValida* seja maior que zero
    switch (t) {
        case 'ALI':
            if (arrValidaALI.length > 0)
                $('#btn_revisar_' + t).prop('disabled', false);
            else
                $('#btn_revisar_' + t).prop('disabled', true);
            break;
        case 'AIE':
            if (arrValidaAIE.length > 0)
                $('#btn_revisar_' + t).prop('disabled', false);
            else
                $('#btn_revisar_' + t).prop('disabled', true);
            break;
        case 'EE':
            if (arrValidaEE.length > 0)
                $('#btn_revisar_' + t).prop('disabled', false);
            else
                $('#btn_revisar_' + t).prop('disabled', true);
            break;
        case 'SE':
            if (arrValidaSE.length > 0)
                $('#btn_revisar_' + t).prop('disabled', false);
            else
                $('#btn_revisar_' + t).prop('disabled', true);
            break;
        case 'CE':
            if (arrValidaCE.length > 0)
                $('#btn_revisar_' + t).prop('disabled', false);
            else
                $('#btn_revisar_' + t).prop('disabled', true);
            break;
        case 'OU':
            if (arrValidaOU.length > 0)
                $('#btn_revisar_' + t).prop('disabled', false);
            else
                $('#btn_revisar_' + t).prop('disabled', true);
            break;
    }
}
function validarFuncao(t, l, a) {
    // t = tabela
    // l = array de linha(s)
    // a = acao (validar / revisar / nvalidar)
    // r = responsavel pela contagem, para o caso de revisoes
    var tb = t.toUpperCase(); // para usar no jQuery
    var r = $('#responsavel').val();
    iWait('w_' + t, true); // minuscula ali, aie, etc...
    $.post('/pf/DIM.Gateway.php', {'t': t, 'l': l, 'a': a, 'r': r, 'arq': 33, 'tch': 0, 'sub': -1, 'dlg': 1, 'ic': idContagem}, function (data) {
        if (data[0].msg === 'erro') {
            swal({
                title: "Alerta",
                text: "O sistema n&atilde;o conseguiu validar/enviar para revis&atilde;o as linhas selecionadas. Por favor entre em contato com o administrador.",
                type: "error",
                html: true,
                confirmButtonText: "Obrigado!"});
        } else {
            for (x = 0; x < l.length; x++) {
                setSituacao(a === 'validar' ? 2 : (a === 'nvalidar' ? 1 : 3), 'cell1_' + tb + '_' + l[x]);
                $('#cell1_' + tb + '_' + l[x])
                        .removeClass('validada nvalidar revisao')
                        .addClass(a === 'validar' ? 'validada' : (a === 'nvalidar' ? 'nvalidar' : 'revisao'));
            }
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: (a === 'validar' ?
                        "As linhas selecionadas foram validadas." :
                        (a === 'nvalidar' ?
                                "A linha selecionada retornou ao status <strong>N&atilde;o Validada</strong>." :
                                "As linhas foram enviadas para revis&atilde;o.")),
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
        }
        iWait('w_' + t, false); // minuscula ali, aie, etc...
        zeraArrayValida(tb);
        zeraLinhasSelecionadas(tb);
        habilitaBotaoValidar(tb);
        habilitaBotaoRevisar(tb);
        $('#select-' + tb).prop('checked', false);
    }, 'json');
}

function verificaSelecionados(t) {
    switch (t) {
        case 'ALI':
            if (Number(arrValidaALI.length) === Number((getQtdAtual(t) - 1))) {
                $('#select-' + t).prop('checked', true);
            }
            break;
        case 'AIE':
            if (Number(arrValidaAIE.length) === Number((getQtdAtual(t) - 1))) {
                $('#select-' + t).prop('checked', true);
            }
            break;
        case 'EE':
            if (Number(arrValidaEE.length) === Number((getQtdAtual(t) - 1))) {
                $('#select-' + t).prop('checked', true);
            }
            break;
        case 'SE':
            if (Number(arrValidaSE.length) === Number((getQtdAtual(t) - 1))) {
                $('#select-' + t).prop('checked', true);
            }
            break;
        case 'CE':
            if (Number(arrValidaCE.length) === Number((getQtdAtual(t) - 1))) {
                $('#select-' + t).prop('checked', true);
            }
            break;
        case 'OU':
            if (Number(arrValidaOU.length) === Number((getQtdAtual(t) - 1))) {
                $('#select-' + t).prop('checked', true);
            }
            break;
    }
}
function gerarSenhaRandomica(c1, c2, f) {
    if (!($(c1).prop('disabled')) && !($(c2).prop('disabled'))) {
        var randomString = Math.random().toString(36).slice(-10);
        $(c1).val(randomString);
        $(c2).val(randomString);
        if (f !== '') {
            $(f).focus();
        }
    }
}
function sobre() {
    var sobre = '<div class="jumbotron"><img src="/pf/img/logo_200px.png" width="80" height="72"><h3>PF.&nbsp;Dimension</h3><p align="justify">' +
            'Nos orgulhamos de ser um software 100% brasileiro.<br />' +
            'Vers&atilde;o est&aacute;vel: 1.0.1<br />';
    swal({
        title: '',
        text: sobre,
        html: true,
        confirmButtonText: "Ok!"});
}
/**
 * 
 * @param String
 *            user - email ou user_name
 * @param Image
 *            JQuery image tag
 */
function consultaGravatar(user, img) {
    // captura a imagem (gravatar do usuario)
    $.post('/pf/DIM.Gateway.php', {'user_name': user, 'arq': 24, 'tch': 1, 'sub': -1, 'dlg': 0}, function (data) {
        if (data[0].existe) {
            $(img).attr('src', data[0].img);
        } else {
            $(img).attr('src', '/pf/img/user.jpg');
        }
    }, 'json');
}
/**
 * 
 * @param String
 *            user - email ou user_name Utilizar esta por conta da performance
 *            na rede
 */
function consultaGravatar2(user) {
    /*
     * captura a imagem (gravatar do usuario)
     */
    var url = 'http://www.gravatar.com/avatar/';
    var pUrl = '?d=http%3A%2F%2Fpfdimension.com.br/pf/img/user.jpg';
    var gravatar = url + CryptoJS.MD5(user) + pUrl;
    return gravatar;
}
/**
 * 
 * @param {type}
 *            e
 * @param {type}
 *            i
 * @param {type}
 *            o - operacao, ve - verificacao ou va - validacao no ve o length
 *            pode ser menor que quatro
 * @returns {undefined}
 */
function verificaCaptcha(e, i, o) {
    if ($(e).val().length === 4 || o) {
        $.post('/pf/DIM.Gateway.php', {'c': sha1($(e).val().toLowerCase()), 'arq': 53, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
            if (data[0].confere) {
                $(i).addClass('fa-check-circle');
                $(i).removeClass('fa-dot-circle-o');
            } else {
                swal({
                    title: "Alerta",
                    text: "A letras e/ou os n&uacute;meros exibidos na figura n&atilde;o conferem com o que foi digitado. Voc&ecirc; pode clicar na imagem para gerar outro c&oacute;digo.",
                    type: "error",
                    html: true,
                    confirmButtonText: "Obrigado, vou corrigir!"});
                $(e).val('');
            }
        }, 'json');
    } else {
        $(i).removeClass('fa-check-circle');
        $(i).addClass('fa-dot-circle-o');
    }
}
function verificaPostCaptcha(e) {

}
function validaEmail(email, cp) {
    var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if (!filter.test(email)) {
        swal({
            title: "Alerta",
            text: "Este email n&atilde;o possui um formato v&aacute;lido.",
            type: "error",
            html: true,
            confirmButtonText: "Obrigado, vou corrigir!"},
        function () {
            if (typeof cp !== 'undefined') {
                $(cp).get(0).focus();
            }
        });
        return false;
    }
    return true;
}
function getGerenteProjeto(id) {
    $.post('/pf/DIM.Gateway.php', {'i': id, 'arq': 23, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        $('#gerente_projeto').val(data.user_email);
        $('#nome_gerente_projeto').val(data.complete_name);
    }, 'json');
}
function verificaBaseline(id) {
    iWait('w_id_baseline', true);
    $.post('/pf/DIM.Gateway.php', {'i': id, 'arq': 52, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        // continua sem o id_baseline porque a contagem de baseline pode vir
        // depois
        // verifica se eh uma contagem de projeto (2)
        // verifica se eh uma contagem de baseline (3) ou uma contagem de
        // licitacao (4)
        if (data.id == 0 && abAtual == 2) {
            swal({
                title: "Alerta",
                text: "Esta baseline ainda n&atilde;o possui uma contagem associada, " +
                        "voc&ecirc; pode continuar, entretanto n&atilde;o poder&aacute; " +
                        "inserir Altera&ccedil;&otilde;es e/ou Exclus&otilde;es em suas " +
                        "Fun&ccedil;&otilde;es de Dados/Transa&ccedil;&atilde;o.<hr>" +
                        "<strong>ATEN&Ccedil;&Atilde;O</strong>: o sistema ir&aacute; criar automaticamente a contagem de Baseline.",
                type: "warning",
                html: true,
                confirmButtonText: "Obrigado pela informação"});
            getGerenteProjeto($('#contagem_id_projeto').val());
        } else if (data.id > 0 && (abAtual == 3 || abAtual == 4)) {
            swal({
                title: "Alerta",
                text: "Esta baseline j&aacute; possui uma contagem associada.",
                type: "error",
                html: true,
                confirmButtonText: "Obrigado."});
            $('#contagem_id_baseline').val(0);
        } else if (ac === 'in' && abAtual == 2) {
            // TODO: colocar as informacoes basicas da baseline
            $('#id_linguagem').val(data.id_linguagem).trigger('change');
            $('#id_tipo_contagem').val(data.id_tipo_contagem);
            $('#id_etapa').val(data.id_etapa);
            $('#id_industria').val(data.id_industria);
            $('#id_banco_dados').val(data.id_banco_dados);
            $('#id_processo').val(data.id_processo);
            $('#id_processo_gestao').val(data.id_processo_gestao);
            getGerenteProjeto($('#contagem_id_projeto').val());
        }
        // atualiza o span com o resumo da baseline
        if (id > 0) {
            $('#span-resumo-baseline').attr({
                'data-content': data.sigla + ' - ' + data.descricao + '<hr>' + data.resumo
            });
        } else {
            $('#span-resumo-baseline').attr({
                'data-content': 'Selecione uma baseline'
            });
        }
        // limpa o wait do ajax
        iWait('w_id_baseline', false);
    }, 'json');
}
function refreshCaptcha(id, cp) {
    var dt = new Date();
    var tm = dt.getTime();
    $(id).attr('src', '/pf/vendor/huge/tools/showCaptcha.php?' + tm);
    $(cp).val('').get(0).focus();
}
function getInternetExplorerVersion() {
// Returns the version of Internet Explorer or a -1
// (indicating the use of another browser).
    var rv = -1; // Return value assumes failure.
    if (navigator.appName == 'Microsoft Internet Explorer')
    {
        var ua = navigator.userAgent;
        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat(RegExp.$1);
    }
    return rv;
}
function naoAutorizado(d, b) {
    /*
     * funcao que alerta para acessos nao autorizados
     */
    b !== null ? b.setAttribute("data-toggle", "") : null;
    swal({
        title: "Alerta",
        text: "Voc&ecirc; n&atilde;o est&aacute; autorizado a realizar esta opera&ccedil;&atilde;o (" + d + ").",
        type: "error",
        html: true,
        confirmButtonText: "Ok, entendi!"});
}

/**
 * 
 * @param {int} i - idBaseline
 * @returns {Boolean}
 */
function pArquivosReferenciados(i) {
    lstId = i > 0 ? $('#lst-ar-baseline') : $('#lst-ar-projeto');
    var tags = $('#transacao_descricao_ar').tagsManager('tags');
    var tbl = $('#transacao_tabela').val();
    /*
     * i = id da contagem t = tipo Baseline, Projeto a = abrangencia
     */
    $.post('/pf/DIM.Gateway.php', {'i': i, 'arq': 0, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        for (x = 0; x < data.length; x++) {
            var tag = data[x].arquivo + "." + data[x].funcao;
            var situacao;
            if (tags.indexOf(tag) === -1) {
                switch (Number(data[x].situacao)) {
                    case 1 :
                        situacao = "btn-warning";
                        break;
                    case 2 :
                        situacao = "btn-success";
                        break;
                    case 3:
                        situacao = "btn-info";
                        break;
                    case 4:
                        situacao = "btn-primary";
                        break;
                }
                $(lstId).append("<li class='btn " + situacao + " btn-li' " +
                        "onclick=\"removeArList($(this), $('#transacao_descricao_ar'));\"" +
                        (null !== data[x].obs_funcao ? " data-toggle=\"tooltip\" data-placement=\"top\" title=\"<small>" + data[x].obs_funcao + (tbl === 'EE' ? "<br /><i class='fa fa-info-circle'></i>&nbsp;N&atilde;o &aacute; aconselh&aacute;vel que Entradas Externas insiram dados em AIEs" : "") + "</small>\"" : "") +
                        ">" + data[x].arquivo + "." + data[x].funcao + "</li>");
            }
        }
        $('[data-toggle="tooltip"]').tooltip({html: true});
    }, 'json');
    return true;
}
function pTipoDadoAR(tags, i, t) {
    /**
     * 
     * @param {type}
     *            tags - descricao_ar
     * @param {type}
     *            i - idBaseline ou idContagem
     * @param {type}
     *            t - tipo B->baseline, P->projeto
     * @returns {undefined}
     */
    var lstId = t === 'B' ? $('#lst-td-ar-baseline') : $('#lst-td-ar-projeto');
    var tagsTD = $('#transacao_descricao_td').tagsManager('tags');
    var arquivosReferenciados = tags.toString();
    var situacao;
    if (tags.length < 1) {
        $(lstId).append("<div style='text-align: center;'><li class='btn btn-warning btn-li'>N&atilde;o h&aacute; Arquivos Referenciados selecionados</li></div>");
    } else {
        $.post('/pf/DIM.Gateway.php', {'i': i, 't': t, 'tags': arquivosReferenciados, 'arq': 0, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
            for (x = 0; x < data.length; x++) {
                var funcao = data[x].funcao.split(',');
                for (y = 0; y < funcao.length; y++) {
                    var tag = data[x].arquivo + "." + funcao[y];
                    if (tagsTD.indexOf(tag) === -1) {
                        switch (Number(data[0].situacao)) {
                            case 1 :
                                situacao = "btn-warning";
                                break;
                            case 2 :
                                situacao = "btn-success";
                                break;
                            case 3:
                                situacao = "btn-info";
                                break;
                            case 4:
                                situacao = "btn-primary";
                                break;
                        }
                        $(lstId).append("<li class='btn " + situacao + " btn-li' onclick=\"removeArList($(this), $('#transacao_descricao_td'));\">" + data[x].arquivo + "." + funcao[y] + "</li>");
                    }
                }
            }
        }, 'json');
    }
}
/*
 * esta funcao remove o item clicado @param {type} b - item da lista @param
 * {type} c - campo de pesquisa @returns {undefined}
 */
function removeArList(b, c) {
    /*
     * retirando o split
     * 
     * var arClicado = $(b).html().split(' - '); $(c).tagsManager('pushTag',
     * arClicado[1]);
     */
    $(c).tagsManager('pushTag', $(b).html());
    $('[data-toggle="tooltip"]').tooltip('hide');
    $(b).remove();
}
/*
 * 
 * @param {type} chk @param {type} tipo @returns {undefined}
 * 
 * atualizar os arquivos referenciados projeto.php - retorna os arquivos
 * referenciados (unicos) em contagens para o projeto (#contagem_id_projeto)
 * baseline.php - retorna os arquivos referenciados (unicos) da contagem de
 * baseline do projeto, se houver (#contagem_id_projeto && ab = 3) TODO:
 * atualizar o id da baseline - nao da pra ser criptografado
 */
function atualizaItensArquivosReferenciados(chk, tipo) {
    if (tipo === 'PAT') {
        if ($(chk).prop("checked")) {
            for (x = 1; x < getQtdAtual('ALI'); x++) {
                srcItems.push('ALI-' + $("#funcao_ALI_" + x).html());
            }
            for (x = 1; x < getQtdAtual('AIE'); x++) {
                srcItems.push('AIE-' + $("#funcao_AIE_" + x).html());
            }
        } else {
            for (x = 1; x < getQtdAtual('ALI'); x++) {
                srcItems.splice(srcItems.indexOf('ALI-' + $("#funcao_ALI_" + x).html()), 1);
            }
            for (x = 1; x < getQtdAtual('AIE'); x++) {
                srcItems.splice(srcItems.indexOf('AIE-' + $("#funcao_AIE_" + x).html()), 1);
            }
        }
    } else if (tipo === 'PAB') {
        if ($(chk).prop("checked")) {
            $.post('/pf/DIM.Gateway.php', {'i': $('#contagem_id_projeto').val(), 'a': '3', 'arq': 0, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
                for (x = 0; x < data.length; x++) {
                    srcItems.push(data[x].arquivo + '-' + data[x].funcao);
                }
            }, "json");
        } else {
            $.post('/pf/DIM.Gateway.php', {'i': $('#contagem_id_projeto').val(), 'a': '3', 'arq': 0, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
                for (x = 0; x < data.length; x++) {
                    srcItems.splice(srcItems.indexOf(data[x].arquivo + '-' + data[x].funcao), 1);
                }
            }, "json");
        }
    } else if (tipo === 'PAP') {
        if ($(chk).prop("checked")) {
            $.post('/pf/DIM.Gateway.php', {'i': $('#contagem_id_projeto').val(), 'a': '2', 'arq': 0, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
                for (x = 0; x < data.length; x++) {
                    srcItems.push(data[x].arquivo + '-' + data[x].funcao);
                }
            }, "json");
        } else {
            $.post('/pf/DIM.Gateway.php', {'i': $('#contagem_id_projeto').val(), 'a': '2', 'arq': 0, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
                for (x = 0; x < data.length; x++) {
                    srcItems.splice(srcItems.indexOf(data[x].arquivo + '-' + data[x].funcao), 1);
                }
            }, "json");
        }
    } else if (tipo === 'PAV') {
        if ($(chk).prop("checked")) {
            $.post('/pf/DIM.Gateway.php', {'i': $('#contagem_id_projeto').val(), 'a': '1', 'arq': 0, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
                for (x = 0; x < data.length; x++) {
                    srcItems.push(data[x].arquivo + '-' + data[x].funcao);
                }
            }, "json");
        } else {
            $.post('/pf/DIM.Gateway.php', {'i': $('#contagem_id_projeto').val(), 'a': '1', 'arq': 0, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
                for (x = 0; x < data.length; x++) {
                    srcItems.splice(srcItems.indexOf(data[x].arquivo + ' - ' + data[x].funcao), 1);
                }
            }, "json");
        }
    }

    return true;
}
/*
 * 
 * @param {type} chk @param {type} tipo @returns {undefined}
 * 
 * atualizar os arquivos referenciados projeto.php - retorna os arquivos
 * referenciados (unicos) em contagens para o projeto (#contagem_id_projeto)
 * baseline.php - retorna os arquivos referenciados (unicos) da contagem de
 * baseline do projeto, se houver (#contagem_id_projeto && ab = 3) TODO:
 * atualizar o id da baseline - nao da pra ser criptografado
 */
function atualizaItensTiposRegistros(chk, tipo) {
    if ($(chk).prop("checked")) {
        $.post('/pf/DIM.Gateway.php', {'i': $('#contagem_id_projeto').val(), 'a': '1', 'arq': 50, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
            for (x = 0; x < data.length; x++) {
                var subTr = (data[x].descricao_tr).split(',');
                for (y = 0; y < subTr.length; y++) {
                    trItems.push(data[x].arquivo + '-' + subTr[y]);
                }
            }
        }, "json");
    } else {
        $.post('/pf/DIM.Gateway.php', {'i': $('#contagem_id_projeto').val(), 'a': '1', 'arq': 50, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
            for (x = 0; x < data.length; x++) {
                var subTr = (data[x].descricao_tr).split(',');
                for (y = 0; y < subTr.length; y++) {
                    trItems.splice(trItems.indexOf(data[x].arquivo + '-' + subTr[y]), 1);
                }
            }
        }, "json");
    }
}
/*
 * 
 * @param {type} t ALI, AIE, etc @param {type} f dados/transacao @returns
 * {undefined}
 */
function atualizaItensFuncoes(t, f) {
    $.post('/pf/DIM.Gateway.php', {'t': t.toLowerCase(), 'arq': 2, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        if (data.length > 0) {
            $('#' + f + '_funcao')
                    .replaceWith('<select id="' + f + '_funcao" class="form-control input_style" onchange="retornaInputFuncao($(this),\'' + f + '\',\'' + t.toLowerCase() + '\');"></select>');
            var sel = $('#' + f + '_funcao');
            sel.empty();
            sel.append('<option value="0">Selecione uma função...</option>');
            for (x = 0; x < data.length; x++) {
                sel.append('<option value="' + data[x].id + '">' +
                        (Number(data[x].id_gerador) > 0 ? 'P' : 'B') +
                        ' > ' + ("0000000" + data[x].id_contagem).slice(-7) +
                        ' > ' + data[x].operacao +
                        ' > ' + formattedDate(data[x].data_cadastro, false, false) +
                        ' > ' + data[x].sigla +
                        ' > ' + data[x].funcao + '</option>');
            }
        } else {
            swal({
                title: "Alerta",
                text: "N&atilde;o h&aacute; funcionalidades cadastradas nas baselines.",
                type: "error",
                html: true,
                confirmButtonText: "Obrigado, vou verificar!"});
        }
    }, "json");
}
/**
 * 
 * @param {type}
 *            c - campo
 * @param {type}
 *            f - dados/transacao
 * @param {type}
 *            b - ali, aie, ee, etc
 * @returns {undefined}
 */
function retornaInputFuncao(c, f, b) {
    /*
     * buscar em baselines
     */
    var funcao = $(c).find('option:selected').text().split(' > ')[5];
    var i = $(c).val();
    var a = f === 'dados' ? 42 : f === 'transacao' ? 44 : 43;
    /*
     * retorna alguns dados da funcao
     */
    $.post("/pf/DIM.Gateway.php", {'i': i, 'b': b, 'arq': a, 'tch': 1, 'sub': -1, 'dlg': 1},
    function (data) {
        var pfb = Number(data[0].pfb);
        /*
         * consulta a funcao na baseline
         */
        $('#' + f + '_td').val(data[0].td);
        f === 'dados' ? $('#' + f + '_tr').val(data[0].tr) : $('#' + f + '_ar').val(data[0].ar);
        $('#' + f + '_complexidade').val(data[0].complexidade);
        $('#' + f + '_fonte').val(data[0].fonte);
        $('#' + f + '_pfb').val(pfb.toFixed(4));
        $('#' + f + '_observacoes').val(data[0].obs_funcao);
        $('#' + f + '_observacoes_validacao').val(data[0].obs_validar);
        $('#' + f + '_metodo').val(data[0].id_metodo);
        // verifica antes para nao alterar o pfa
        verificaMetodo(f, $('#' + f + '_metodo'), $('#' + f + '_id_roteiro'), $('#' + f + '_operacao'));
        /*
         * descricao dos TR
         */
        if (f === 'dados') {
            arrTR = data[0].descricaoTR;
            /*
             * limpa as descricoes
             */
            jQuery('#' + f + '_descricao_tr').tagsManager('empty');
            for (x = 0; x < arrTR.length; x++) {
                jQuery('#' + f + '_descricao_tr').tagsManager('pushTag', arrTR[x]);
            }
        } else {
            arrAR = data[0].descricaoAR;
            /*
             * limpa as descricoes
             */
            jQuery('#' + f + '_descricao_ar').tagsManager('empty');
            for (x = 0; x < arrAR.length; x++) {
                jQuery('#' + f + '_descricao_ar').tagsManager('pushTag', arrAR[x]);
            }
        }
        /*
         * descricao dos TD
         */
        arrTD = data[0].descricaoTD;
        /*
         * limpa as descricoes
         */
        jQuery('#' + f + '_descricao_td').tagsManager('empty');
        for (x = 0; x < arrTD.length; x++) {
            jQuery('#' + f + '_descricao_td').tagsManager('pushTag', arrTD[x]);
        }
        /*
         * escreve apenas o texto no input
         */
        $('#' + f + '_funcao')
                .replaceWith('<input type="text" class="form-control input_style" id="' + f + '_funcao" name="' + f + '_funcao" autocomplete="off" value="' + funcao + '">');
    }, 'json');
}
function getTimeStamp(data) {
    timeMili = new Date(data.split("/").reverse().join("/")).getTime();
    sobraMili = (timeMili % aDay) + 1;
    timeStamp = timeMili + aDay - sobraMili;
    return timeStamp;
}
/*
 * implementacao do sha1 para o javascript
 */
function sha1(str) {
    // discuss at: http://phpjs.org/functions/sha1/
    // original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // improved by: Michael White (http://getsprink.com)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // input by: Brett Zamir (http://brett-zamir.me)
    // example 1: sha1('Kevin van Zonneveld');
    // returns 1: '54916d2e62f65b3afa6e192e6a601cdbe5cb5897'
    var rotate_left = function (n, s) {
        var t4 = (n << s) | (n >>> (32 - s));
        return t4;
    };
    var cvt_hex = function (val) {
        var str = '';
        var i;
        var v;
        for (i = 7; i >= 0; i--) {
            v = (val >>> (i * 4)) & 0x0f;
            str += v.toString(16);
        }
        return str;
    };
    var blockstart;
    var i, j;
    var W = new Array(80);
    var H0 = 0x67452301;
    var H1 = 0xEFCDAB89;
    var H2 = 0x98BADCFE;
    var H3 = 0x10325476;
    var H4 = 0xC3D2E1F0;
    var A, B, C, D, E;
    var temp;
    // utf8_encode
    str = unescape(encodeURIComponent(str));
    var str_len = str.length;
    var word_array = [];
    for (i = 0; i < str_len - 3; i += 4) {
        j = str.charCodeAt(i) << 24 | str.charCodeAt(i + 1) << 16 | str.charCodeAt(i + 2) << 8 | str.charCodeAt(i + 3);
        word_array.push(j);
    }

    switch (str_len % 4) {
        case 0:
            i = 0x080000000;
            break;
        case 1:
            i = str.charCodeAt(str_len - 1) << 24 | 0x0800000;
            break;
        case 2:
            i = str.charCodeAt(str_len - 2) << 24 | str.charCodeAt(str_len - 1) << 16 | 0x08000;
            break;
        case 3:
            i = str.charCodeAt(str_len - 3) << 24 | str.charCodeAt(str_len - 2) << 16 | str.charCodeAt(str_len - 1) <<
                    8 | 0x80;
            break;
    }

    word_array.push(i);
    while ((word_array.length % 16) != 14) {
        word_array.push(0);
    }

    word_array.push(str_len >>> 29);
    word_array.push((str_len << 3) & 0x0ffffffff);
    for (blockstart = 0; blockstart < word_array.length; blockstart += 16) {
        for (i = 0; i < 16; i++) {
            W[i] = word_array[blockstart + i];
        }
        for (i = 16; i <= 79; i++) {
            W[i] = rotate_left(W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16], 1);
        }

        A = H0;
        B = H1;
        C = H2;
        D = H3;
        E = H4;
        for (i = 0; i <= 19; i++) {
            temp = (rotate_left(A, 5) + ((B & C) | (~B & D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
            E = D;
            D = C;
            C = rotate_left(B, 30);
            B = A;
            A = temp;
        }

        for (i = 20; i <= 39; i++) {
            temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
            E = D;
            D = C;
            C = rotate_left(B, 30);
            B = A;
            A = temp;
        }

        for (i = 40; i <= 59; i++) {
            temp = (rotate_left(A, 5) + ((B & C) | (B & D) | (C & D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
            E = D;
            D = C;
            C = rotate_left(B, 30);
            B = A;
            A = temp;
        }

        for (i = 60; i <= 79; i++) {
            temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
            E = D;
            D = C;
            C = rotate_left(B, 30);
            B = A;
            A = temp;
        }

        H0 = (H0 + A) & 0x0ffffffff;
        H1 = (H1 + B) & 0x0ffffffff;
        H2 = (H2 + C) & 0x0ffffffff;
        H3 = (H3 + D) & 0x0ffffffff;
        H4 = (H4 + E) & 0x0ffffffff;
    }

    temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);
    return temp.toLowerCase();
}
function detalheItem(id, funcao) {
    var fatorContent;
    if (id[0] != 0) {
        var idFator = id.split(';');
        if (idFator[0] != 0) {
            $.post('/pf/DIM.Gateway.php', {'i': idFator[0], 'arq': 25, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
                fatorContent = '<strong>Sigla</strong>: ' + data.sigla + '<br />' +
                        '<strong>Descri&ccedil;&atilde;o</strong>:<p align="justify">' + data.descricao + '</p>' +
                        '<strong>Fator</strong>: ' + Number(data.fator).toFixed(4) + '<br />' +
                        '<strong>Fonte</strong>: ' + data.fonte + '<br />' +
                        '<strong>Operacao</strong>: ' + (data.operacao).replace(/;/g, ' ') + '<br />' +
                        '<strong>Aplica-se a</strong>: ' + (data.aplica).replace(/;/g, ' ') + '<br />' +
                        '<strong>Tipo</strong>: ' + (data.tipo === 'A' ? '(A) Ajusta' : '(F) Fixo') + '<br />' +
                        '<strong>Operador</strong>: ' + (data.operador == 0 ? '(M) Multiplica' : '(D) Divide');
                $('#btn-' + funcao + '-detalhe-fator').attr('data-content', fatorContent);
            }, 'json');
        } else {
            $('#btn-' + funcao + '-detalhe-fator').attr('data-content', 'Por favor, selecione um Fator de Impacto.');
        }
    } else {
        $('#btn-' + funcao + '-detalhe-fator').attr('data-content', 'Por favor, selecione um Fator de Impacto.');
    }
}
/*
 * funcao que verifica se eh um numero
 */
function isNumberMy(n) {
    return typeof n == 'number' || !isNaN(n);
}
/**
 * 
 * @param {type}
 *            i - id da contagem
 * @param {type}
 *            t - tabela em minuscula (ali, eie, etc)
 * @param {type}
 *            tb - tabela na pagina que ira receber a listagem
 * @param {type}
 *            f - funcao dados/transacao
 * @param {type}
 *            o - ordenacao
 * @param {type}
 *            tpo - ??
 * @returns {undefined}
 */
function listaFuncao(i, t, tbl, f, o, tpo) {
    iWait("w_" + t, true);
    $('#add' + t.toUpperCase()).empty();
    /*
     * zera a contagem e refaz a tabela
     */
    switch (t) {
        case 'ali':
            qtdALI = 1;
            break;
        case 'aie':
            qtdAIE = 1;
            break;
        case 'ee':
            qtdEE = 1;
            break;
        case 'se':
            qtdSE = 1;
            break;
        case 'ce':
            qtdCE = 1;
            break;
    }
    $.post('/pf/DIM.Gateway.php', {
        'i': i,
        't': t,
        'f': f,
        'o': o,
        'tpo': tpo,
        'arq': 34,
        'tch': 1,
        'sub': -1,
        'dlg': 1}, function (data) {
        for (i = 0; i < data.length; i++) {
            var row = tbl.insertRow(-1);
            var pfa = Number(data[i].pfa);
            var pfb = Number(data[i].pfb);
            insereLinha(
                    data[i].id,
                    t.toUpperCase(),
                    row,
                    data[i].operacao,
                    data[i].funcao,
                    data[i].td,
                    (f === 'dados' ? data[i].tr : data[i].ar),
                    data[i].complexidade,
                    pfb.toFixed(4),
                    data[i].siglaFator,
                    pfa.toFixed(4),
                    data[i].obsFuncao,
                    data[i].situacao,
                    data[i].entrega,
                    data[i].lido,
                    data[i].nLido,
                    false,
                    data[i].isMudanca,
                    data[i].faseMudanca,
                    data[i].percentualFase,
                    data[i].fd,
                    data[i].isCrud,
                    0,
                    t === 'ali' ? data[i].fe : 0);// formulario estendido
        }
        iWait("w_" + t, false);
    }, "json");
}

function estabeleceQuantidadeEntregas(f) {
    var newMax = Number($("#entregas").val());
    $("#" + f + "_entrega").trigger("touchspin.updatesettings", {max: newMax});
    /*
     * verificando com este novo metodo
     * 
     * $().TouchSpin({ min: 1, max: , step: 1, boostat: 5, maxboostedstep: 10,
     * postfix: '' });
     */
}
/*
 * function base de calculo funcao que retorna a quantidade de PFa da contagem
 * dependendo das fases selecionadas
 */
function getBaseCalculo() {
    var pfaEng = config_isEng && isEng ? Number($('#pct-pfa-eng').html()) : 0;
    var pfaDes = config_isDes && isDes ? Number($('#pct-pfa-des').html()) : 0;
    var pfaImp = config_isImp && isImp ? Number($('#pct-pfa-imp').html()) : 0;
    var pfaTes = config_isTes && isTes ? Number($('#pct-pfa-tes').html()) : 0;
    var pfaHom = config_isHom && isHom ? Number($('#pct-pfa-hom').html()) : 0;
    var pfaImpl = config_isImpl && isImpl ? Number($('#pct-pfa-impl').html()) : 0;
    var V = Number((pfaEng + pfaDes + pfaImp + pfaTes + pfaHom + pfaImpl) * config_aumentoEsforco).toFixed(4);
    return V;
}
/*
 * thanks to
 * http://www.profissionaisdaweb.com.br/funcao-number-format-para-javacript-igual-a-do-php-31.jsp
 * Edgard Serra
 */
function number_format(numero, decimal, decimal_separador, milhar_separador) {
    numero = (numero + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+numero) ? 0 : +numero,
            prec = !isFinite(+decimal) ? 0 : Math.abs(decimal),
            sep = (typeof milhar_separador === 'undefined') ? ',' : milhar_separador,
            dec = (typeof decimal_separador === 'undefined') ? '.' : decimal_separador,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
    // Fix para IE: parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }

    return s.join(dec);
}
/**
 * 
 * @param {Object}
 *            d - data
 * @param {String}
 *            t - title
 * @param {Url}
 *            h - href/url
 * @returns {undefined}
 */
function pushState(d, t, h) {
    window.history.pushState({url: "" + d + ""}, t, h);
    return true;
}

function inserirContagem(id) {
    // funcoes para insercao, validacao e revisao nas contagens
    // insere a contagem
    if (!(validaFormContagem())) {
        $('#' + id).removeClass('disabled');
        swal({
            title: "Alerta",
            text: msg,
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
        return false;
    }
    iWaitMenuContagem('id-contagem', true, 'fa fa-floppy-o');
    // apenas para outras contagens, exceto SNAP
    if (abAtual != 5) {
        var item = $("input[type=radio][name=expoente]:checked");
        var expoente = item.length > 0 ? item.val() : Number('0.35').toFixed(2);
    }
    var arrayAPF = {
        'id': idContagem,
        'cabecalho_funcao': $('#cabecalho_funcao').val(),
        'id_abrangencia': $('#id_abrangencia').val(),
        'acao': $('#acao').val(),
        'id_cliente': $('#contagem_id_cliente').val(),
        'id_contrato': $('#contagem_id_contrato').val(),
        'id_projeto': $('#contagem_id_projeto').val(),
        'responsavel': $('#responsavel').val(),
        'entregas': $('#entregas').val(),
        'id_linguagem': $('#id_linguagem').val(),
        'id_tipo_contagem': $('#id_tipo_contagem').val(),
        'id_etapa': $('#id_etapa').val(),
        'id_industria': $('#id_industria').val(),
        'id_processo': $('#id_processo').val(),
        'id_processo_gestao': $('#id_processo_gestao').val(),
        'proposito': $('#proposito').val(),
        'escopo': $('#escopo').val(),
        'ordem_servico': $('#ordem_servico').val(),
        'id_banco_dados': $('#id_banco_dados').val(),
        'gerente_projeto': $('#gerente_projeto').val(),
        'id_baseline': $('#contagem_id_baseline').val(),
        'id_orgao': $('#id-orgao').val(),
        'privacidade': $('#privacidade').prop('checked') ? 1 : 0, // privada
        // por
        // default e
        // publica
        // caso
        // altere
        // estatisticas
        'previsao_inicio': $('#previsao_inicio').val(),
        'produtividade_global': $('#produtividade_global').html(),
        'chk_produtividade_global': $('#chk_produtividade_global').prop('checked') ? 1 : 0,
        'hlt': $('#hlt').html(),
        'isFt': $('#chk-ft').prop('checked') ? 1 : 0,
        'ft': $('#span-ft').html(),
        // eng
        'pct-eng': $('#pct-eng').html(),
        'prod-eng': $('#prod-eng').val(),
        'prof-eng': 1,
        'perf-eng': '',
        'chk-eng': 1,
        'is-f-eng': 1,
        'desc-f-eng': $('#desc-f-eng').html(),
        // des
        'pct-des': config_isDes ? $('#pct-des').html() : 0,
        'prod-des': config_isDes ? $('#prod-des').val() : 0,
        'prof-des': 1,
        'perf-des': '',
        'chk-des': 1,
        'is-f-des': config_isDes ? 1 : 0,
        'desc-f-des': config_isDes ? $('#desc-f-des').html() : '',
        // imp
        'pct-imp': config_isImp ? $('#pct-imp').html() : 0,
        'prod-imp': config_isImp ? $('#prod-imp').val() : 0,
        'prof-imp': 1,
        'perf-imp': '',
        'chk-imp': config_isImp ? 1 : 0,
        'is-f-imp': config_isImp ? 1 : 0,
        'desc-f-imp': config_isImp ? $('#desc-f-imp').html() : '',
        // tes
        'pct-tes': config_isTes ? $('#pct-tes').html() : 0,
        'prod-tes': config_isTes ? $('#prod-tes').val() : 0,
        'prof-tes': 1,
        'perf-tes': '',
        'chk-tes': config_isTes ? 1 : 0,
        'is-f-tes': config_isTes ? 1 : 0,
        'desc-f-tes': config_isTes ? $('#desc-f-tes').html() : '',
        // hom
        'pct-hom': config_isHom ? $('#pct-hom').html() : 0,
        'prod-hom': config_isHom ? $('#prod-hom').val() : 0,
        'prof-hom': 1,
        'perf-hom': '',
        'chk-hom': config_isHom ? 1 : 0,
        'is-f-hom': config_isHom ? 1 : 0,
        'desc-f-hom': config_isHom ? $('#desc-f-hom').html() : '',
        // impl
        'pct-impl': config_isImpl ? $('#pct-impl').html() : 0,
        'prod-impl': config_isImpl ? $('#prod-impl').val() : 0,
        'prof-impl': 1,
        'perf-impl': '',
        'chk-impl': config_isImpl ? 1 : 0,
        'is-f-impl': config_isImpl ? 1 : 0,
        'desc-f-impl': config_isImpl ? $('#desc-f-impl').html() : '',
        // demais informacoes
        'expoente': expoente,
        'calculado': ($('#calculado').html()).length > 0 ? $('#calculado').html() : 0,
        'tempo-desenvolvimento': ($('#tempo-desenvolvimento').html()).length > 0 ? $('#tempo-desenvolvimento').html() : 0,
        'regiao-impossivel': ($('#regiao-impossivel').html()).length > 0 ? $('#regiao-impossivel').html() : 0,
        'menor-custo': ($('#menor-custo').html()).length > 0 ? $('#menor-custo').html() : 0,
        // calculos iniciais
        'hpc': $('#hpc').val(),
        'hpa': $('#hpa').val(),
        'valor-hpc': Number($('#valor-hpc').val()),
        'valor-hpa': Number($('#valor-hpa').val()),
        'custo-total': Number($('#custo-total').html()),
        'valor-pfa-contrato': Number($('#valor-pfa-contrato').val()),
        // cronograma
        'aumento-esforco': config_aumentoEsforco,
        'fator-reducao-cronograma': config_fatorReducaoCronograma,
        'tipo-projeto': $('#tipo-projeto').val(),
        'esforco-total': Number($('#esforco-total').val()),
        'tamanho-pfa': Number($('#tamanho-pfa').html()),
        'span-produtividade-media': Number($('#span-produtividade-media').html()),
        'is_contagem_auditoria': isContagemAuditoria == 1 ? 1 : 0,
        'id_roteiro': idRoteiro,
        'arq': 20, 'tch': 0, 'sub': -1, 'dlg': 1
    };
    var arraySNAP = {
        'id': idContagem,
        'cabecalho_funcao': $('#cabecalho_funcao').val(),
        'id_abrangencia': $('#id_abrangencia').val(),
        'acao': $('#acao').val(),
        'id_cliente': $('#contagem_id_cliente').val(),
        'id_contrato': $('#contagem_id_contrato').val(),
        'id_projeto': $('#contagem_id_projeto').val(),
        'responsavel': $('#responsavel').val(),
        'entregas': $('#entregas').val(),
        'id_linguagem': $('#id_linguagem').val(),
        'id_tipo_contagem': $('#id_tipo_contagem').val(),
        'id_etapa': $('#id_etapa').val(),
        'id_industria': $('#id_industria').val(),
        'id_processo': $('#id_processo').val(),
        'id_processo_gestao': $('#id_processo_gestao').val(),
        'proposito': $('#proposito').val(),
        'escopo': $('#escopo').val(),
        'ordem_servico': $('#ordem_servico').val(),
        'id_banco_dados': $('#id_banco_dados').val(),
        'gerente_projeto': $('#gerente_projeto').val(),
        'id_baseline': $('#contagem_id_baseline').val(),
        'id_orgao': $('#id-orgao').val(),
        'privacidade': $('#privacidade').prop('checked') ? 1 : 0, // privada
        // por
        // default e
        // publica
        // caso
        // altere
        'arq': 20, 'tch': 0, 'sub': -1, 'dlg': 1
    };
    $.post("/pf/DIM.Gateway.php", abAtual == 5 ? arraySNAP : arrayAPF,
            function (data) {
                $('#id').val(data[0].id);
                if (data[0].acao === 'in') {
                    $('#span_btn_contagem').html('Atualizar as informa&ccedil;&otilde;es');
                    $('#acao').val('al');
                    swal({
                        title: "Informa&ccedil;&atilde;o",
                        text: "A Contagem foi <strong>INSERIDA</strong> com sucesso #ID: " + data[0].idPad + ", você já pode adicionar " + (abAtual == 5 ? "as SCU na SNAP Counting Sheet." : "as funções de dados e transação.") +
                                (data[0].idContagemBaselineInserida > 0 ? '<hr>O sistema tamb&eacute;m criou automaticamente uma contagem para esta Baseline' : ''),
                        type: "success",
                        html: true,
                        confirmButtonText: "Obrigado!"});
                    $('#span_id_contagem').html(data[0].idPad);
                    $('#li-ane').removeClass('disabled');
                    $('#li-est').removeClass('disabled');
                    $('#li-fin').removeClass('disabled');
                    $('#li-coc').removeClass('disabled');
                    $('#privacidade').prop('disabled', false);
                } else if (data[0].acao === 'al' || data[0].acao === 're') {
                    swal({
                        title: "Informa&ccedil;&atilde;o",
                        text: "A Contagem #ID: " + data[0].idPad + " foi <strong>ATUALIZADA<\/strong> com sucesso!",
                        type: "success",
                        html: true,
                        confirmButtonText: "Obrigado!"});
                }
                $('#' + id).removeClass('disabled');
                iWaitMenuContagem('id-contagem', false, 'fa fa-floppy-o');
                idContagem = data[0].id;
            }, "json");
}
function validaFormContagem() {
    // valida o formulario antes de inserir a contagem
    var ret = true;
    if (Number($('#contagem_id_cliente').val()) == 0 && !(abAtual == 3 || abAtual == 4)) {
        // para contagem licitacao e baseline
        ret = false;
        msg = "O campo <strong>#ID CLIENTE</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    } else if (Number($('#contagem_id_contrato').val()) == 0 && !(abAtual == 3 || abAtual == 4)) {
        ret = false;
        msg = "O campo <strong>#ID CONTRATO</strong> &eacute; de preenchimento obrigat&oacute;rio";
    } else if (Number($('#contagem_id_projeto').val()) == 0 && !(abAtual == 3 || abAtual == 4)) {
        ret = false;
        msg = "O campo <strong>#ID PROJETO</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    }
    // contagem de licitacao (4) nao precisa de baseline
    else if (Number($('#contagem_id_baseline').val()) == 0 && (abAtual == 2 || abAtual == 3)) {
        ret = false;
        msg = "O campo <strong>ID BASELINE</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    } else if (Number($('#id-orgao').val()) == 0 && !(abAtual == 3 || abAtual == 4)) {
        ret = false;
        msg = "O campo <strong>ID &Oacute;RG&Atilde;O</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    } else if ($('#responsavel').val() === '') {
        ret = false;
        msg = "O campo <strong>RESPONS&AACUTE;VEL</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    } else if (Number($('#entregas').val()) == 0 || Number($('#entregas').val()) > 50 || $('#entregas').val() === '') {
        if (Number($('#entregas').val()) > 50) {
            $('#entregas').val('50');
        } else if (Number($('#entregas').val()) == 0) {
            $('#entregas').val('1');
        }
        ret = false;
        msg = "O campo <strong>ENTREGAS</strong> &eacute; de preenchimento obrigat&oacute;rio. P.Ex. um número entre 1 (um) e 50 (cinquenta).";
    } else if (Number($('#id_linguagem').val()) == 0) {
        ret = false;
        msg = "O campo <strong>#ID LINGUAGEM</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    } else if (Number($('#id_tipo_contagem').val()) == 0) {
        ret = false;
        msg = "O campo <strong>#ID TIPO CONTAGEM</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    } else if (Number($('#id_etapa').val()) == 0) {
        ret = false;
        msg = "O campo <strong>#ID ETAPA</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    } else if (Number($('#id_processo').val()) == 0) {
        ret = false;
        msg = "O campo <strong>#ID PROCESSO</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    } else if (Number($('#id_processo_gestao').val()) == 0) {
        ret = false;
        msg = "O campo <strong>#ID PROCESSO GEST&Atilde;O</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    } else if ($('#proposito').val() === '') {
        ret = false;
        msg = "O campo <strong>PROP&Oacute;SITO</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    } else if ($('#escopo').val() === '') {
        ret = false;
        msg = "O campo <strong>ESCOPO</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    } else if ($('#ordem_servico').val() === '') {
        ret = false;
        msg = "O campo <strong>ORDEM DE SERVI&Ccedil;O / DEMANDA / SOLICITA&Ccedil;&Atilde;O</strong> &eacute; de preenchimento obrigat&oacute;rio.";
    }
    return ret;
}
/**
 * 
 * @param {type}
 *            c id do botao clicado
 * @param {type}
 *            i id da contagem
 * @param {type}
 *            b button ex. 'v-interna'
 * @param {type}
 *            ic icone
 * @param {type}
 *            t tipo vi, ve, etc
 * @param {type}
 *            r responsavel
 * @param {type}
 *            a true ou false para determinadas acoes
 * @returns {undefined}
 */
function validarContagem(c, i, b, ic, t, r, a) {
    a ? iWaitMenuContagem(b, true, ic) : null;
    $.post('/pf/DIM.Gateway.php', {'i': i, 'r': r, 't': t, 'arq': 32, 'tch': 0, 'sub': -1, 'dlg': 1
    }, function (data) {
        var msg;
        if (data.sucesso) {
            switch (t) {
                case 'vi':
                    msg = 'validada internamente';
                    break
                case 've':
                    msg = 'validada externamente';
                    break;
                case'ai':
                    msg = 'auditada internamente';
                    break;
                case 'ae':
                    msg = 'auditada externamente';
                    break;
            }
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: "A Contagem #ID: " + ("0000000" + i).slice(-7) + " foi " + msg + " com sucesso!",
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"},
            function () {
                if (a) {
                    iWaitMenuContagem(b, false, ic);
                    self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' + i + (abAtual == 3 ? '&b=' : abAtual == 4 ? '&l=' : '');
                } else {
                    $('#form_modal_funcoes_perfil_contagem').modal('toggle');
                }
            });
        } else {
            if (t === 've' || t === 'vi') {
                swal({
                    title: "Alerta",
                    text: "Para finalizar a valida&ccedil;&atilde;o " + (t === 'vi' ? 'interna' : 'externa') + " veja o seguinte:<br /> " +
                            (t === 'vi' ?
                                    "(1) Todos os itens devem estar validados;<br />" +
                                    "(2) Verifique se h&aacute; itens que voc&ecirc; enviou para revis&atilde;o;<br />" :
                                    "(3)Verifique se h&aacute; apontes pendentes que voc&ecirc; inseriu.<br />") +
                            "Caso haja alguma das condi&ccedil;&otilde;es acima, envie a contagem para revis&atilde;o.",
                    type: "error",
                    html: true,
                    confirmButtonText: "Obrigado, vou verificar"},
                function () {
                    $('#' + c).removeClass('disabled');
                    iWaitMenuContagem(b, false, ic);
                });
            }
        }
    }, 'json');
}
/**
 * Esta funcao serve para enviar para a revisao
 * 
 * @param {type}
 *            c id do botao clicado
 * @param {type}
 *            i id da contagem
 * @param {type}
 *            a acao (validacao interna ou externa)
 * @returns {undefined}
 */
function solicitarRevisao(c, i, a) {
    var r = $('#responsavel').val();
    iWaitMenuContagem('c-revisao', true, 'fa fa-pencil-square-o');
    $.post('/pf/DIM.Gateway.php', {'i': i, 'r': r, 'a': a, 'arq': 31, 'tch': 0, 'sub': -1, 'dlg': 1
    }, function (data) {
        if (data.sucesso) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: "A Contagem #ID: " + ("0000000" + i).slice(-7) + " foi enviada para revis&atilde;o!",
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"},
            function () {
                iWaitMenuContagem('c-revisao', false, 'fa fa-pencil-square-o');
                self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' + i;
            });
        } else {
            swal({
                title: "Alerta",
                text: "Para enviar a contagem para revis&atilde;o, verifique se h&aacute; itens marcados como <strong>em revis&atilde;o</strong>, n&atilde;o validados e/ou se voc&ecirc; inseriu algum aponte.",
                type: "error",
                html: true,
                confirmButtonText: "Obrigado, vou verificar"},
            function () {
                $('#' + c).removeClass('disabled');
                iWaitMenuContagem('c-revisao', false, 'fa fa-pencil-square-o');
            });
        }
    }, 'json');
}
/**
 * Esta funcao serve para enviar para a revisao
 * 
 * @param {type}
 *            c id do botao clicado
 * @param {type}
 *            i id da contagem
 * @param {type}
 *            ab abrangencia da contagem
 * @returns {undefined}
 */
function finalizarRevisao(c, i, a) {
    var r = $('#responsavel').val();
    var v = $('#email-validador').val();
    var p = $('#contagem-id-processo').val();
    iWaitMenuContagem('f-revisao', true, 'fa fa-check-square-o');
    $.post('/pf/DIM.Gateway.php', {'i': i, 'r': r, 'v': v, 'a': a, 'p': p, 'arq': 18, 'tch': 0, 'sub': -1, 'dlg': 1
    }, function (data) {
        if (data.sucesso) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: "A Contagem #ID: " + ("0000000" + i).slice(-7) + " teve sua revis&atilde;o finalizada e foi enviada novamente para valida&ccedil;&atilde;o " + (p == 8 ? "interna" : "externa") + "!",
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"},
            function () {
                iWaitMenuContagem('f-revisao', false, 'fa fa-check-square-o');
                self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' + i;
            });
        } else {
            swal({
                title: "Alerta",
                text: "H&aacute; itens que n&atilde;o foram revisados ou apontes que ainda n&atilde;o foram respondidos.",
                type: "error",
                html: true,
                confirmButtonText: "Obrigado, vou verificar"},
            function () {
                $('#' + c).removeClass('disabled');
                iWaitMenuContagem('f-revisao', false, 'fa fa-check-square-o');
            });
        }
    }, 'json');
}

function finalizarContagem(i) {
    $.post('/pf/DIM.Gateway.php', {'i': i, 'arq': 78, 'tch': 0, 'sub': -1, 'dlg': 0
    }, function (data) {
        if (data.idTarefa > 0) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: "A Contagem #ID: " + ("0000000" + i).slice(-7) + " foi enviada para faturamento",
                type: "success",
                html: true,
                confirmButtonText: "Obrigado"}, function () {
                $('#form_modal_funcoes_perfil_contagem').modal('hide');
                tableLista.ajax.reload();
                pushState('/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1',
                        'Dimension - M&eacute;tricas',
                        '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1');
            });
        } else {
            swal({
                title: "Alerta",
                text: data.msg,
                type: "error",
                html: true,
                confirmButtonText: "Obrigado, vou verificar"}, function () {
                $('#form_modal_funcoes_perfil_contagem').modal('hide');
            });
        }
    }, 'json');
}

function autorizaAlteracaoCampos(idFornecedor, tamanhoPfa) {
    $('#proposito').prop('readonly', !isAutorizadoAlterar);
    $('#escopo').prop('readonly', !isAutorizadoAlterar);
    $('#entregas').prop('disabled', !isAutorizadoAlterar);
    $('#ordem_servico').prop('readonly', !isAutorizadoAlterar);
    // verificar se eh um fornecedor ... nao altera naturalmente
    if (isFornecedor) {
        $('#contagem_id_cliente').val(idCliente);
        // tambem continua desabilitando as outras duas combos
        $('#contagem_id_contrato').prop('disabled', !isAutorizadoAlterar);
        $('#contagem_id_projeto').prop('disabled', !isAutorizadoAlterar);
        $('#id-orgao').prop('disabled', !isAutorizadoAlterar);
    } else {
        // uma coisa para a baseline, mesmo que esteja autorizado alterar
        if (abAtual == 3 || abAtual == 4) {
            $('#contagem_id_contrato').prop('disabled', true);
            $('#contagem_id_projeto').prop('disabled', true);
            $('#id-orgao').prop('disabled', true);
        } else if (abAtual == 2 && Number(tamanhoPfa) > 0) {
            $('#contagem_id_contrato').prop('disabled', true);
            $('#contagem_id_projeto').prop('disabled', true);
            $('#contagem_id_baseline').prop('disabled', true);
            $('#id-orgao').prop('disabled', !isAutorizadoAlterar);
        } else if (abAtual == 2 && Number(tamanhoPfa) < 1) {
            if (ac === 'vw' || ac === 've' || ac === 'ai' || ac === 'ae') {
                $('#contagem_id_contrato').prop('disabled', true);
                $('#contagem_id_projeto').prop('disabled', true);
                $('#contagem_id_baseline').prop('disabled', true);
                $('#id-orgao').prop('disabled', true);
            } else {
                $('#contagem_id_contrato').prop('disabled', false);
                $('#contagem_id_projeto').prop('disabled', false);
                $('#contagem_id_baseline').prop('disabled', false);
                $('#id-orgao').prop('disabled', false);
            }
        } else {
            $('#contagem_id_contrato').prop('disabled', !isAutorizadoAlterar);
            $('#contagem_id_projeto').prop('disabled', !isAutorizadoAlterar);
            $('#id-orgao').prop('disabled', !isAutorizadoAlterar);
        }
    }
    $('#id_linguagem').prop('disabled', !isAutorizadoAlterar);
    $('#id_tipo_contagem').prop('disabled', !isAutorizadoAlterar);
    $('#id_etapa').prop('disabled', !isAutorizadoAlterar);
    $('#id_industria').prop('disabled', !isAutorizadoAlterar);
    $('#id_banco_dados').prop('disabled', !isAutorizadoAlterar);
    $('#id_processo').prop('disabled', !isAutorizadoAlterar);
    $('#id_processo_gestao').prop('disabled', !isAutorizadoAlterar);
    $('#btn_placard_linguagem').prop('disabled', !isAutorizadoAlterar);
    $('#btn_placard_banco_dados').prop('disabled', !isAutorizadoAlterar);
    $('#btn_adicionar_ali').prop('disabled', !isAutorizadoAlterar);
    $('#btn_adicionar_aie').prop('disabled', !isAutorizadoAlterar);
    $('#btn_adicionar_ee').prop('disabled', !isAutorizadoAlterar);
    $('#btn_adicionar_se').prop('disabled', !isAutorizadoAlterar);
    $('#btn_adicionar_ce').prop('disabled', !isAutorizadoAlterar);
    $('#btn_adicionar_ou').prop('disabled', !isAutorizadoAlterar);
    $('#btn-pesquisar-ali').prop('disabled', (!isAutorizadoAlterar) || abAtual == 3); // especialmente
    // a
    // abrangência
    // 3 -
    // baseline,
    // nao
    // habilita
    // estes
    // botoes
    $('#btn-pesquisar-aie').prop('disabled', !isAutorizadoAlterar);
    $('#btn-pesquisar-ee').prop('disabled', (!isAutorizadoAlterar) || abAtual == 3); // especialmente
    // a
    // abrangência
    // 3 -
    // baseline,
    // nao
    // habilita
    // estes
    // botoes
    $('#btn-pesquisar-se').prop('disabled', (!isAutorizadoAlterar) || abAtual == 3); // especialmente
    // a
    // abrangência
    // 3 -
    // baseline,
    // nao
    // habilita
    // estes
    // botoes
    $('#btn-pesquisar-ce').prop('disabled', (!isAutorizadoAlterar) || abAtual == 3); // especialmente
    // a
    // abrangência
    // 3 -
    // baseline,
    // nao
    // habilita
    // estes
    // botoes
    $('#select-ALI').prop('disabled', !isAutorizadoValidarInternamente);
    $('#select-AIE').prop('disabled', !isAutorizadoValidarInternamente);
    $('#select-EE').prop('disabled', !isAutorizadoValidarInternamente);
    $('#select-SE').prop('disabled', !isAutorizadoValidarInternamente);
    $('#select-CE').prop('disabled', !isAutorizadoValidarInternamente);
    $('#select-OU').prop('disabled', !isAutorizadoValidarInternamente);
    /*
     * TODO: verificar contagem validada e visualizacao
     */
    if (isValidadaInternamente && (ac !== 'in' || ac !== 'al')) {
        $('#btn-selecionar-validador').prop('disabled', true);
        $('#btn-validar-contagem').prop('disabled', true);
        $('#chk_is_processo_validacao_1').prop('disabled', true);
        $('#chk_is_processo_validacao_2').prop('disabled', true);
        $('#privacidade').bootstrapToggle(isFornecedor ? 'disable' : 'enable');
    } else if (!isValidadaInternamente && ac === 'vi') {// validando
        $('#btn-selecionar-validador').prop('disabled', true);
        $('#btn-validar-contagem').prop('disabled', true);
        $('#chk_is_processo_validacao_1').prop('disabled', true);
        $('#chk_is_processo_validacao_2').prop('disabled', true);
        $('#privacidade').bootstrapToggle('disable');
    } else if (ac === 'vw' || ac === 're' || ac === 'ai' || ac === 'ae') {
        $('#btn-selecionar-validador').prop('disabled', true);
        $('#btn-validar-contagem').prop('disabled', true);
        $('#chk_is_processo_validacao_1').prop('disabled', true);
        $('#chk_is_processo_validacao_2').prop('disabled', true);
        $('#privacidade').bootstrapToggle('disable');
    } else {
        if (tpoFornecedor == 1) {// turma = 1
            $('#btn-selecionar-validador').prop('disabled', true);
            $('#btn-validar-contagem').prop('disabled', false);
            $('#chk_is_processo_validacao_1').prop('disabled', true).prop('checked', false);
            $('#chk_is_processo_validacao_2').prop('disabled', true).prop('checked', true);
            $('#privacidade').bootstrapToggle(isFornecedor ? 'disable' : 'enable');
        } else {// para todos os outros verifica o processo de validacao
            $('#btn-selecionar-validador').prop('disabled', false);
            $('#btn-validar-contagem').prop('disabled', true);
            $('#chk_is_processo_validacao_1').prop('disabled', false);
            $('#chk_is_processo_validacao_2').prop('disabled', false);
            $('#privacidade').bootstrapToggle(isFornecedor ? 'disable' : 'enable');
        }
    }
    // desabilita os botes e checks na aba arquivos para os arquivos que ja
    // estao na contagem
    isAutorizadoAlterar ? $('#btn-adicionar-arquivo').removeClass('disabled') : $('#btn-adicionar-arquivo').addClass('disabled');
    $('#files-start').prop('disabled', !isAutorizadoAlterar);
    $('#files-cancel').prop('disabled', !isAutorizadoAlterar);
    $('#files-delete').prop('disabled', !isAutorizadoAlterar);
    $('#chk-sel-todos').prop('disabled', !isAutorizadoAlterar);
    $('.delete').prop('disabled', !isAutorizadoAlterar);
    $('.toggle').prop('disabled', !isAutorizadoAlterar);
    // desabilita algumas opcoes nas telas de alteracao das funcoes
    $('#dados_id_roteiro').prop('disabled', false).css('background-color', '#fff');// !isAutorizadoAlterar
    $('#transacao_id_roteiro').prop('disabled', false).css('background-color', '#fff');
    $('#outros_id_roteiro').prop('disabled', false).css('background-color', '#fff');
    // TODO: verificar as consequencias de deixar o Roteiro Habilitado
    $('#dados_op1').prop('disabled', !isAutorizadoAlterar);
    $('#dados_op2').prop('disabled', !isAutorizadoAlterar);
    $('#dados_op3').prop('disabled', !isAutorizadoAlterar);
    //
    $('#transacao_op1').prop('disabled', !isAutorizadoAlterar);
    $('#transacao_op2').prop('disabled', !isAutorizadoAlterar);
    $('#transacao_op3').prop('disabled', !isAutorizadoAlterar);
    $('#transacao_op4').prop('disabled', !isAutorizadoAlterar);
    //
    $('#outros_op1').prop('disabled', !isAutorizadoAlterar);
    $('#outros_op1').prop('disabled', !isAutorizadoAlterar);
    $('#outros_op1').prop('disabled', !isAutorizadoAlterar);
    //
    $('#dados_me1').prop('disabled', !isAutorizadoAlterar);
    $('#dados_me2').prop('disabled', !isAutorizadoAlterar);
    $('#dados_me3').prop('disabled', !isAutorizadoAlterar);
    //
    $('#transacao_me1').prop('disabled', !isAutorizadoAlterar);
    $('#transacao_me2').prop('disabled', !isAutorizadoAlterar);
    $('#transacao_me3').prop('disabled', !isAutorizadoAlterar);
    //
    $('#dados_impacto').prop('disabled', !isAutorizadoAlterar);
    $('#transacao_impaco').prop('disabled', !isAutorizadoAlterar);
    $('#outros_impacto').prop('disabled', !isAutorizadoAlterar);
    //
    $('#dados_funcao').prop('readonly', !isAutorizadoAlterar);
    $('#dados_fonte').prop('readonly', !isAutorizadoAlterar);
    $('#dados_observacoes').prop('readonly', !isAutorizadoAlterar);
    $('#dados_observacoes_validacao').prop('readonly', !isAutorizadoAlterar);
    //
    $('#transacao_funcao').prop('readonly', !isAutorizadoAlterar);
    $('#transacao_fonte').prop('readonly', !isAutorizadoAlterar);
    $('#transacao_observacoes').prop('readonly', !isAutorizadoAlterar);
    $('#transacao_observacoes_validacao').prop('readonly', !isAutorizadoAlterar);
    //
    $('#outros_funcao').prop('readonly', !isAutorizadoAlterar);
    $('#outros_fonte').prop('readonly', !isAutorizadoAlterar);
    $('#outros_observacoes').prop('readonly', !isAutorizadoAlterar);
    $('#outros_observacoes_validacao').prop('readonly', !isAutorizadoAlterar);
    // tags de descricao
    $('#dados_descricao_tr').prop('readonly', !isAutorizadoAlterar);
    $('#dados_descricao_td').prop('readonly', !isAutorizadoAlterar);
    $('#transacao_descricao_ar').prop('readonly', !isAutorizadoAlterar);
    $('#transcao_descricao_td').prop('readonly', !isAutorizadoAlterar);
    // fator documentacao
    $('#dados_fd').prop('disabled', !isAutorizadoAlterar);
    $('#dados_fe').prop('disabled', !isAutorizadoAlterar);
    $('#transacao_fd').prop('disabled', !isAutorizadoAlterar);
    //
    $('#dados_entrega').prop('disabled', !isAutorizadoAlterar);
    $('#transacao_entrega').prop('disabled', !isAutorizadoAlterar);
    $('#outros_entrega').prop('disabled', !isAutorizadoAlterar);
    /*
     * desabilita os checks de pesquisas de tr e baselines
     * 
     * $('#chk_pesq_baseline_tr').prop('disabled', !isAutorizadoAlterar);
     * $('#chk_pesq_atual').prop('disabled', !isAutorizadoAlterar);
     * $('#chk_pesq_baseline').prop('disabled', !isAutorizadoAlterar);
     * $('#chk_pesq_projeto').prop('disabled', !isAutorizadoAlterar);
     * $('#chk_pesq_avulsa').prop('disabled', !isAutorizadoAlterar); /*
     * desabilita o botao de adicionar linha lista (td)
     */
    $('#btn-adicionar-linha-lista').prop('disabled', !isAutorizadoAlterar);
    /*
     * tab estatisticas
     */
    $('#chk_produtividade_global').bootstrapToggle(!isAutorizadoAlterar ? 'disable' : 'enable');
    $('#previsao_inicio').prop('disabled', !isAutorizadoAlterar);
    $('#btn-xml').prop('disabled', !isAutorizadoAlterar);
    $('#btn-csv').prop('disabled', !isAutorizadoAlterar);
    $('#btn-json').prop('disabled', !isAutorizadoAlterar);
    // profissionais
    config_isEng ? $('#prof-eng').prop('readonly', !isAutorizadoAlterar) : null;
    config_isDes ? $('#prof-des').prop('readonly', !isAutorizadoAlterar) : null;
    config_isImp ? $('#prof-imp').prop('readonly', !isAutorizadoAlterar) : null;
    config_isTes ? $('#prof-tes').prop('readonly', !isAutorizadoAlterar) : null;
    config_isHom ? $('#prof-hom').prop('readonly', !isAutorizadoAlterar) : null;
    config_isImpl ? $('#prof-impl').prop('readonly', !isAutorizadoAlterar) : null;
    // perfis
    config_isEng ? (!isAutorizadoAlterar ? selectizeEng.disable() : null) : null;
    config_isDes ? (!isAutorizadoAlterar ? selectizeDes.disable() : null) : null;
    config_isImp ? (!isAutorizadoAlterar ? selectizeImp.disable() : null) : null;
    config_isTes ? (!isAutorizadoAlterar ? selectizeTes.disable() : null) : null;
    config_isHom ? (!isAutorizadoAlterar ? selectizeHom.disable() : null) : null;
    config_isImpl ? (!isAutorizadoAlterar ? selectizeImpl.disable() : null) : null;
    // expoente
    $("input[type=radio][name=expoente]").prop('disabled', !isAutorizadoAlterar);
    /*
     * verifica a abrangencia, se for baseline ou licitacao deixa habilitado nas
     * operacoes apenas a inclusao
     */
    if (Number(abAtual) == 3 || Number(abAtual) == 4) {
        $('#dados_op2').prop('disabled', true);
        $('#dados_op3').prop('disabled', true);
        $('#transacao_op2').prop('disabled', true);
        $('#transacao_op3').prop('disabled', true);
        $('#outros_op2').prop('disabled', true);
        $('#outros_op3').prop('disabled', true);
    }
    /*
     * desabilita os botoes de fases
     */
    config_isEng ? $('#chk-eng').bootstrapToggle(!isAutorizadoAlterar ? 'disable' : 'enable') : null;
    config_isDes ? $('#chk-des').bootstrapToggle(!isAutorizadoAlterar ? 'disable' : 'enable') : null;
    config_isImp ? $('#chk-imp').bootstrapToggle(!isAutorizadoAlterar ? 'disable' : 'enable') : null;
    config_isTes ? $('#chk-tes').bootstrapToggle(!isAutorizadoAlterar ? 'disable' : 'enable') : null;
    config_isHom ? $('#chk-hom').bootstrapToggle(!isAutorizadoAlterar ? 'disable' : 'enable') : null;
    config_isImpl ? $('#chk-impl').bootstrapToggle(!isAutorizadoAlterar ? 'disable' : 'enable') : null;
    /*
     * desabilita o restante dos botoes
     */
    $('#hpc').prop('readonly', !isAutorizadoAlterar);
    $('#hpa').prop('readonly', !isAutorizadoAlterar);
    $('#projeto-padrao').prop('disabled', !isAutorizadoAlterar);
    $('#projeto-urgente').prop('disabled', !isAutorizadoAlterar);
    $('#projeto-critico').prop('disabled', !isAutorizadoAlterar);
    $('#projeto-criticidade').prop('disabled', !isAutorizadoAlterar);
    $('#chk-solicitacao-servico-critica').bootstrapToggle(!isAutorizadoAlterar ? 'disable' : 'enable');
    /*
     * desabilitacao dos botoes is_crud e alterar nome funcao
     */
    $('#is-crud').bootstrapToggle(!isAutorizadoAlterar ? 'disable' : 'enable');
    $('#alterar-funcao-dados').prop('disabled', !isAutorizadoAlterar);
}

function autorizaAlteracaoCamposLinha(isAutorizadoAlterarLinha, b) {
    /*
     * desabilita algumas opcoes nas telas de alteracao das funcoes
     * TODO: verificar consequencias de deixar Roteiro habilitado
     */
    $('#' + b + '_id_roteiro').prop('disabled', false).css('background-color', '#fff');// !isAutorizadoAlterarLinha
    //
    $('#' + b + '_op1').prop('disabled', !isAutorizadoAlterarLinha);
    $('#' + b + '_op2').prop('disabled', abAtual == 3 || abAtual == 4 ? true : !isAutorizadoAlterarLinha);
    $('#' + b + '_op3').prop('disabled', abAtual == 3 || abAtual == 4 ? true : !isAutorizadoAlterarLinha);
    b === 'transacao' ? $('#' + b + '_op4').prop('disabled', !isAutorizadoAlterarLinha) : null;
    //
    $('#' + b + '_me1').prop('disabled', !isAutorizadoAlterarLinha);
    $('#' + b + '_me2').prop('disabled', !isAutorizadoAlterarLinha);
    $('#' + b + '_me3').prop('disabled', !isAutorizadoAlterarLinha);
    //
    $('#' + b + '_impacto').prop('disabled', !isAutorizadoAlterarLinha);
    //
    $('#' + b + '_funcao').prop('readonly', !isAutorizadoAlterarLinha);
    $('#' + b + '_fonte').prop('readonly', !isAutorizadoAlterarLinha);
    $('#' + b + '_observacoes').prop('readonly', !isAutorizadoAlterarLinha);
    $('#' + b + '_observacoes_validacao').prop('readonly', !isAutorizadoAlterarLinha);
    // tags de descricao
    if (b === 'dados') {
        $('#' + b + '_descricao_tr').prop('readonly', !isAutorizadoAlterarLinha);
    } else if (b === 'transacao') {
        $('#' + b + '_descricao_ar').prop('readonly', !isAutorizadoAlterarLinha);
    }
    // td eh generico
    b !== 'outros' ? $('#' + b + '_descricao_td').prop('readonly', !isAutorizadoAlterarLinha) : null;
    // controle de alteracoes
    if (b !== 'outros') {
        $('#' + b + '-is-mudanca').bootstrapToggle(!isAutorizadoAlterarLinha ? 'disable' : 'enable');
        $('#' + b + '-fase').prop('disabled', !isAutorizadoAlterarLinha);
        // fator documentacao
        $('#' + b + '_fd').prop('disabled', !isAutorizadoAlterarLinha);
        $('#' + b + '_fe').prop('disabled', !isAutorizadoAlterarLinha);
    }
    //
    $('#' + b + '_entrega').prop('disabled', !isAutorizadoAlterarLinha);
    // desabilita os botoes
    if (isAutorizadoAlterar && !isAutorizadoAlterarLinha && acForms === 'al') {
        $('#' + b + '_btn_al').prop('disabled', !isAutorizadoAlterarLinha);
        $('#' + b + '_btn_if').prop('disabled', true);
        $('#' + b + '_btn_in').prop('disabled', true);
    } else {
        if (ac === 'vw' || ac === 'vi' || ac === 've' || ac === 'ai' || ac === 'ae') {
            $('#' + b + '_btn_al').prop('disabled', true);
            $('#' + b + '_btn_if').prop('disabled', true);
            $('#' + b + '_btn_in').prop('disabled', true);
        } else {
            $('#' + b + '_btn_al').prop('disabled', true);
            $('#' + b + '_btn_if').prop('disabled', false);
            $('#' + b + '_btn_in').prop('disabled', false);
        }
    }
    // nao pode deletar os tags de tds e trs
    $('.tm-tag-remove').css({'visibility': (!isAutorizadoAlterarLinha ? 'hidden' : 'visible')});
}
/**
 * 
 * @param {type} p - processo (is_processo_validacao (false = 0)
 * @param {type} i - id da contagem
 * @param {type} e - email de quem vai validar
 * @param {type} v - valida a passagem ou não, valida apenas se estiver no formulario de alteracao
 * @param {type} a - acao ... incluindo ou alterando.
 * @returns {Boolean}
 */
function atualizaProcessoValidacao(p, i, e, v, a) {
    if ((i === '-' || (
            getQtdAtual('ALI') === 1 &&
            getQtdAtual('AIE') === 1 &&
            getQtdAtual('EE') === 1 &&
            getQtdAtual('SE') === 1 &&
            getQtdAtual('CE') === 1 &&
            getQtdAtual('OU') === 1)) && v) {
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "Antes de enviar ou n&atilde;o para o processo de valida&ccedil;&atilde;o voc&ecirc; deve inserir ao menos uma fun&ccedil;&atilde;o de DADOS e/ou TRANSA&Ccedil;&Atilde;O.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    switch (p) {
        case 2:
            /*
             * validacao interna
             */
            $.post('/pf/DIM.Gateway.php', {
                'p': p, 'i': i, 'e': e, 'a': a, 'arq': 3, 'tch': 0, 'sub': -1, 'dlg': 1
            }, function (data) {
                exibeMensagemProcesso(data.msg, i, v);
            }, "json");
            break;
        case 3:
            /*
             * validacao externa
             */
            $.post('/pf/DIM.Gateway.php', {
                'p': p, 'i': i, 'e': e, 'a': a, 'arq': 2, 'tch': 0, 'sub': -1, 'dlg': 1
            }, function (data) {
                exibeMensagemProcesso(data.msg, i, v);
            }, "json");
            break;
        case 4:
            /*
             * auditoria interna
             */
            $.post('/pf/DIM.Gateway.php', {
                'p': p, 'i': i, 'e': e, 'arq': 1, 'tch': 0, 'sub': -1, 'dlg': 1
            }, function (data) {
                exibeMensagemProcesso(data.msg, i, v);
            }, "json");
            break;
        case 5:
            /*
             * auditoria externa
             */
            $.post('/pf/DIM.Gateway.php', {
                'p': p, 'i': i, 'e': e, 'arq': 0, 'tch': 0, 'sub': -1, 'dlg': 1
            }, function (data) {
                exibeMensagemProcesso(data.msg, i, v);
            }, "json");
            break;
        case 10:
            /*
             * validacao interna automatica
             */
            $.post('/pf/DIM.Gateway.php', {
                'p': p, 'i': i, 'e': e, 'arq': 4, 'tch': 0, 'sub': -1, 'dlg': 1
            }, function (data) {
                exibeMensagemProcesso(data.msg, i, v);
            }, "json");
            break;
    }
}
function exibeMensagemProcesso(msg, i, v) {
    swal({
        title: "Informa&ccedil;&atilde;o",
        text: msg,
        type: "success",
        html: true,
        confirmButtonText: "Obrigado!"}, function () {
        // verifica se veio do formulario de alteracao ou do modal de perfis na
        // lista de contagens
        v ? self.location.href = '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' + i + (abAtual == 3 ? '&b=' : abAtual == 4 ? '&l=' : '') :
                tableLista.ajax.url('/pf/DIM.Gateway.php?arq=32&tch=1&sub=-1&dlg=1&p=id&v=' + i).load();
    });
}
function gravaLogAuditoria(emailLogado, userRole, acesso) {
    swal({title: "Alerta",
        text: "Opera&ccedil;&atilde;o n&atilde;o permitida! <br /><br /><kbd>" + emailLogado + "</kbd><br /><br />" + userRole,
        type: "error",
        html: true,
        confirmButtonText: "Entendi!"});
    $.post('/pf/DIM.Gateway.php', {'e': emailLogado, 'u': userRole, 'a': acesso, 'arq': 19, 'tch': 0, 'sub': -1, 'dlg': 1});
}

/**
 * 
 * @param {type}
 *            t - tag inserida
 * @returns {boolean} pega uma tag em AR e verifica se existem tags relacionadas
 *          nos TDs remove caso a TAG AR esteja sendo excluida
 */
function verificaTDSInseridos(t) {
    var q = $('#transacao_descricao_td').tagsManager('tags');
    var s = new Array();
    /*
     * encontra o que deve ser removido
     */
    for (x = 0; x < q.length; x++) {
        var f = q[x];
        if (f.indexOf(t + '.') > -1) {
            s.push(q[x]);
        }
    }
    /*
     * remove e monta o novo array
     */
    for (y = 0; y < s.length; y++) {
        p = q.indexOf(s[y]);
        p > -1 ? q.splice(p, 1) : null;
    }
    var qClone = q.slice(0);
    /*
     * limpa as tags
     */
    $('#transacao_descricao_td').tagsManager('empty');
    /*
     * adiciona apenas o restante
     */
    for (z = 0; z < qClone.length; z++) {
        $('#transacao_descricao_td').tagsManager('pushTag', qClone[z]);
    }
    return true;
}
// t = tag
function validaTag(c, t) {
    /*
     * pega o valor na option ALI e AIE
     */
    var tipo = $('input:radio[name=chk-tipo-arquivo]:checked').val();
    var selFuncao = $('#sel_funcao_transacao').find('option:selected').text();
    var tag, tagStr, ar;
    // TODO - colocar o separador em uma configuracao
    var v = t.split('.');
    var tag;
    /*
     * valida descricao dos tipos de dados
     */
    if (c === 'TD') {
        if ((v[0] !== 'ali' && v[0] !== 'aie') && v.length == 1) {
            if (t.substr(0, 1) !== '.') {
                tag = selFuncao + '.' + v[0];
                $('#transacao_descricao_td').tagsManager('popTag');
                $('#transacao_descricao_td').tagsManager('pushTag', tag);
            }
            else {
                $('#transacao_descricao_td').tagsManager('popTag');
                $('#transacao_descricao_td').tagsManager('pushTag', '.' + tag);
            }
        }
        else if ((v[0] === 'ali' || v[0] === 'aie') && v.length < 3) {
            swal({title: "Alerta",
                text: "A descri&ccedil;&atilde;o do Tipo de Dado n&atilde;o est&aacute; no padr&atilde;o<br />[tipo].[nome].[descricao]<br />Ex.: ali.comentario.id_comentario",
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"}, function () {
                $('#transacao_descricao_td').tagsManager('popTag');
            });
        }
        else if ((v[0] === 'ali' || v[0] === 'aie') && v.length > 2) {
            tagStr = v[0] + '.' + v[1];
            // verifica se tem um AR com a descricao que foi inserida senao
            // coloca
            ar = jQuery("#transacao_descricao_ar").tagsManager('tags');
            if (ar.indexOf(tagStr) < 0) {
                $('#transacao_descricao_ar').tagsManager('pushTag', tagStr);
            }
        } else if (v[1].length < 1 && v[2].length < 1) {
            swal({title: "Alerta",
                text: "A descri&ccedil;&atilde;o do Tipo de Dado n&atilde;o est&aacute; no padr&atilde;o<br />[tipo].[nome].[descricao]<br />Ex.: ali.comentario.id_comentario",
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"}, function () {
                $('#transacao_descricao_td').tagsManager('popTag');
            });
        }
    }
    /*
     * valida descricao dos arquivos referenciados
     */
    else if (c === 'AR') {
        if ((v[0] !== 'ali' && v[0] !== 'aie') || v.length <= 1 || v[1].length < 1) {
            tag = tipo + '.' + v[0];
            // verificar pois no eh pra excluir as que ja estao
            $('#transacao_descricao_ar').tagsManager('popTag');
            $('#transacao_descricao_ar').tagsManager('pushTag', tag);
            return false;
        }
    }
    return true;
}

function notifyMe(t) {
    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        var notification = new Notification('Alerta', {
            icon: 'https://pfdimension.com.br/pf/img/Dimension.png',
            body: t
        });
        notification.onclick = function () {
            return true;
        };
    }
}

/**
 * 
 * @param {type}
 *            f - descricao da funcionalidade
 * @param {type}
 *            c - campo que ira receber a descricao
 * @returns {undefined}
 */
function adicionarDescricaoPaste(f, c) {
    jQuery(c).tagsManager('pushTag', f);
    return '';
}

/*******************************************************************************
 * 
 * @param {type}
 *            t - tags separadas por virgula
 * @returns {undefined}
 */
function atualizaComboPaste(t) {
    $('#sel_funcao_transacao').empty();
    // .append('<option value="0">...</option>')
    for (x = 0; x < t.length; x++) {
        $('#sel_funcao_transacao').append('<option value="' + (x + 1) + '">' + t[x] + '</option>');
    }
    if (x == 0) {
        $('#sel_funcao_transacao').append('<option value="0">...</option>');
    }
}

/**
 * 
 * @param {type}
 *            fun - descricao da funcao de dados
 * @param {type}
 *            icn - id da contagem de projeto / baseline
 * @param {type}
 *            tbl - tabela ALI ou AIE
 * @param {type}
 *            iba - id da baseline
 * @param {type}
 *            tag - descricao do TD
 * @returns {undefined}
 */
function verificaIntegridadeTD(fun, icn, tbl, iba, tag) {
    $.post('/pf/DIM.Gateway.php', {
        'fun': fun,
        'icn': icn,
        'tbl': tbl,
        'iba': iba,
        'tag': tag,
        'arq': 84,
        'tch': 1,
        'sub': -1,
        'dlg': 0}, function (data) {
        if (data) {
            if (data.length > 0) {
                var tipo = 'alert-danger';
                var fa = 'warning';
                var f = 'dados';
                var h = $('#' + f + '_log').html();
                var n = 'Refer&ecirc;ncias ao TD (<strong>' + tag + '</strong>)<br />';
                for (x = 0; x < data.length; x++) {
                    n += '[ ' + (x + 1) + ' ] ' + ' ' + data[x].tipo + ' - ' + data[x].funcao + ' - ' + data[x].fonte + '; <br />';
                }
                h += '<div class="alert ' + tipo + ' alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&nbsp;<i class="fa fa-times-circle"></i>&nbsp;</span></button>' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close" data-toggle="tooltip" data-placement="left" title="Desfazer" onclick="javascript: $(\'#dados_descricao_td\').tagsManager(\'pushTag\', \'' + tag + '\'); return false;"><span aria-hidden="true">' +
                        '&nbsp;<i class="fa fa-undo"></i>&nbsp;</span></button>' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close" data-toggle="tooltip" data-placement="left" title="Inserir em observações" onclick="javascript: $(\'#dados_observacoes\').val($(\'#dados_observacoes\').val() + $(\'#log-atual\').html().stripHTMLSpace()); return false;"><span aria-hidden="true">' +
                        '&nbsp;<i class="fa fa-upload"></i>&nbsp;</span></button>' +
                        '<i class="fa ' + fa + '"></i><span id="log-atual">' + n + '</span></div>';
                $('#' + f + '_log').html(h);
                // reinicializa os tooltips
                $('[data-toggle="tooltip"]').tooltip();
            }
        }
    }, 'json');
}

function copiarTDs() {
    var TD = $('#dados_descricao_td').tagsManager('tags');
    for (x = 0; x < TD.length; x++) {
        jQuery("#dados_descricao_tr").tagsManager('pushTag', TD[x]);
    }
}

/*
 * funcao que monta a thead da lista de contagens de acordo com o que esta sendo
 * chamado analise ou lista
 */
function montaThead(t) {
    // verifica se eh lista ou analise
    if (t === 'lista') {
        $('#th1').css('width', '05%');
        $('#th2').css('width', '05%');
        $('#th3').css('width', '08%');
        $('#th4').css('width', '18%');
        $('#th5').css('width', '12%');
        $('#th6').css('width', '26%');
        $('#th7').css('width', '26%');
        $('#th8').css('width', '00%');
        // coloca os titulos
        $('#sp1').html('Resp.');
        $('#sp2').html('#ID');
        $('#sp3').html(isFornecedor == 1 && tpoFornecedor == 1 ? 'Turma' : 'Fornecedor');
        $('#sp4').html('Processo');
        $('#sp5').html('M&eacute;trica');
        $('#sp6').html('Cliente/Contrato - O.S.');
        $('#sp7').html('Projeto');
        $('#sp8').html('');
    }
    else if (t === 'analises') {
        $('#th1').css('width', '05%');
        $('#th2').css('width', '05%');
        $('#th3').css('width', '10%');
        $('#th4').css('width', '5%');
        $('#th5').css('width', '5%');
        $('#th6').css('width', '10%');
        $('#th7').css('width', '37%');
        $('#th8').css('width', '23%');
        // coloca os titulos
        $('#sp1').html('R1');
        $('#sp2').html('#ID');
        $('#sp3').html('M&eacute;trica');
        $('#sp4').html('R2');
        $('#sp5').html('#ID');
        $('#sp6').html('M&eacute;trica');
        $('#sp7').html('Projeto - O.S.');
        $('#sp8').html('Analise');
    }
}

function searchInTable(idInput, idTable, index) {
    // Declare variables
    var input, filter, table, tr, td, i;
    input = document.getElementById(idInput);
    filter = input.value.toUpperCase();
    table = document.getElementById(idTable);
    tr = table.getElementsByTagName("tr");
    // Loop through all table rows, and hide those who don't match the search
    // query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[index];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// seta uma opcao no select pelo valor
function setSelectedFromValue(e, v) {
    var options = document.getElementById(e).options;
    for (var i = 0; i < options.length; i++) {
        if (options[i].value === v) {
            options[i].selected = true;
            break;
        }
    }
}

function setNoneSelected(e) {
    var options = document.getElementById(e).options;
    for (var i = 0; i < options.length; i++) {
        options[i].selected = false;
    }
}

function exibeCampoEntrega(cmp, tabela, id, idContagem) {
    $(cmp).on('click', function () {
        if (!$(this).hasClass('ed')) {
            $(this).html(
                    '<input type="text" class="form-control input_style_mini" value="' + $(this).html() + '" ' +
                    'data-mask="00" ' +
                    'maxlength="2" ' +
                    'id="' + id + '_' + tabela + '">')
                    .addClass('ed');
            $('#' + id + '_' + tabela)
                    .on('blur', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var valor = Number($(this).val());
                        var entregas = Number($('#entregas').val());
                        if ($(this).val() === '' || valor == 0 || valor > entregas) {
                            $(this).val(1).get(0).focus();
                            return false;
                        }
                        else {
                            $(cmp).html($(this).val()).removeClass('ed');
                            calculaDistribuicaoEntregas();
                            atualizaQuantidadeEntregas(id, tabela.toLowerCase(), 'entrega', $(this).val(), idContagem);
                        }
                    })
                    .select()
                    .attr("data-selected-all", true)
                    .mask('00')
                    .get(0)
                    .focus();
            document.execCommand('selectall');
        }
    });

}

// campo, id, valor, tabela
function atualizaQuantidadeEntregas(id, tb, cp, vl, ic) {
    $.post('/pf/DIM.Gateway.php', {
        'arq': 1,
        'tch': 1,
        'sub': -1,
        'dlg': 0,
        'id': id,
        'tb': tb,
        'cp': cp,
        'vl': vl,
        'ic': ic
    }, function (data) {
    }, 'json');
}

/*
 * apenas para exibir e ocultar o loading
 */
function exibeDivLoading() {
    $('#div-fade-loading').css('visibility', 'visible');
}

function ocultaDivLoading() {
    $('#div-fade-loading').css('visibility', 'hidden');
}

function getSomaPFAFatorTecnologia() {
    var pfaEE = Number($('#pfaEE').html());
    var pfaSE = Number($('#pfaSE').html());
    var pfaCE = Number($('#pfaCE').html());
    return parseFloat(pfaEE + pfaSE + pfaCE).toFixed(4);
}