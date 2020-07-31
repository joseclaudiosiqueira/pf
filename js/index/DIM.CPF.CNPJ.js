// JavaScript Document
/*	********************************************************************	
 ####################################################################
 Assunto = Validação de CPF e CNPJ
 Autor = Marcos Regis
 Data = 24/01/2006
 Versão = 1.0
 Compatibilidade = Todos os navegadores.
 Pode ser usado e distribuído desde que esta linhas sejam mantidas
 ====------------------------------------------------------------====
 
 Funcionamento = O script recebe como parâmetro um objeto por isso 
 deve ser chamado da seguinte forma:
 E.: no evento onBlur de um campo texto
 <input name="cpf_cnpj" type="text" size="40" maxlength="18" 
 onBlur="validar(this);">
 Ao deixar o campo o evento é disparado e chama validar() com o 
 argumento "this" que representa o próprio objeto com todas as 
 propriedades.
 A partir daí a função validar() trata a entrada removendo tudo que
 não for caracter numérico e deixando apenas números, portanto
 valores escritos só com números ou com separadores como '.' ou mesmo
 espaços são aceitos
 ex.: 111222333/44, 111.222.333-44, 111 222 333 44 serão tratadoc como
 11122233344 (para CPFs)
 De certa forma até mesmo valores como 111A222B333C44 será aceito mas
 aconselho a usar a função soNums() que encotra-se aqui mesmo para
 que o campo só aceite caracteres numéricos.
 Para usar a função soNums() chame-a no evento onKeyPress desta forma
 onKeyPress="return soNums(event);"
 Após limpar o valor verificamos seu tamanho que deve ser ou 11 ou 14
 Se o tamanho não for aceito a função retorna false e [opcional] 
 mostra uma mensagem de erro.
 Sugestões e comentários marcos_regis@hotmail.com
 ####################################################################
 ********************************************************************	*/
// a função principal de validação
function validar(obj) {
    var s = (obj.value).replace(/\D/g, '');
    var tam = (s).length;
    if (tam == 0) {
        return false;
    }
    else if (!(tam == 11 || tam == 14)) {
        swal({
            title: "Alerta",
            text: "'" + s + "' Não é um CPF ou um CNPJ válido!",
            type: "error",
            html: true,
            confirmButtonText: "Obrigado, vou verificar!"}, function () {
            obj.value = '';
            obj.focus();
        });
        return false;
    }
    // se for CPF
    if (tam == 11) {
        if (!validaCPF(s)) {
            swal({
                title: "Alerta",
                text: "'" + s + "' Não é um CPF ou um CNPJ válido!",
                type: "error",
                html: true,
                confirmButtonText: "Obrigado, vou verificar!"}, function () {
                obj.value = '';
                obj.focus();
            });
            return false;
        }
        return true;
    }
    // se for CNPJ			
    if (tam == 14) {
        if (!validaCNPJ(s)) {
            swal({
                title: "Alerta",
                text: "'" + s + "' Não é um CNPJ válido!",
                type: "error",
                html: true,
                confirmButtonText: "Obrigado, vou verificar!"}, function () {
                obj.value = '';
                obj.focus();
            });
            return false;
        }
        return true;
    }
}
// fim da funcao validar()
// função que valida CPF
// O algorítimo de validação de CPF é baseado em cálculos
// para o dígito verificador (os dois últimos)
// Não entrarei em detalhes de como funciona
function validaCPF(s) {
    var c = s.substr(0, 9);
    var dv = s.substr(9, 2);
    var d1 = 0;
    for (var i = 0; i < 9; i++) {
        d1 += c.charAt(i) * (10 - i);
    }
    if (d1 == 0)
        return false;
    d1 = 11 - (d1 % 11);
    if (d1 > 9)
        d1 = 0;
    if (dv.charAt(0) != d1) {
        return false;
    }
    d1 *= 2;
    for (var i = 0; i < 9; i++) {
        d1 += c.charAt(i) * (11 - i);
    }
    d1 = 11 - (d1 % 11);
    if (d1 > 9)
        d1 = 0;
    if (dv.charAt(1) != d1) {
        return false;
    }
    return true;
}

// Função que valida CNPJ
// O algorítimo de validação de CNPJ é baseado em cálculos
// para o dígito verificador (os dois últimos)
// Não entrarei em detalhes de como funciona
function validaCNPJ(CNPJ) {
    var a = new Array();
    var b = new Number;
    var c = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    for (i = 0; i < 12; i++) {
        a[i] = CNPJ.charAt(i);
        b += a[i] * c[i + 1];
    }
    if ((x = b % 11) < 2) {
        a[12] = 0
    } else {
        a[12] = 11 - x
    }
    b = 0;
    for (y = 0; y < 13; y++) {
        b += (a[y] * c[y]);
    }
    if ((x = b % 11) < 2) {
        a[13] = 0;
    } else {
        a[13] = 11 - x;
    }
    if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])) {
        return false;
    }
    return true;
}