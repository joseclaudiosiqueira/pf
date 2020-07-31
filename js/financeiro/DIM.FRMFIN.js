$.post('/pf/DIM.Gateway.php', {'arq': 74, 'tch': 1, 'sub': 1, 'dlg': 1}, function (data) {
    for (x = 0; x < data.length; x++) {
        addLinhasFaturamento(data[x], x + 1);
    }
}, 'json');

function addLinhasFaturamento(data, seq) {
    var t = $('#addFaturamento').get(0);
    var r = t.insertRow(-1);
    var cell0 = r.insertCell(0);//seq
    var cell1 = r.insertCell(1);//ref
    var cell2 = r.insertCell(2);//data
    var cell3 = r.insertCell(3);//contagens
    var cell4 = r.insertCell(4);//detalhes
    var cell5 = r.insertCell(5);//faturamento
    var cell6 = r.insertCell(6);//status
    var cell7 = r.insertCell(7);//detalhes
    //monta a tabela e os forms de pagamento
    cell0.innerHTML = "#" + ("00000" + seq).slice(-5);
    cell1.innerHTML = data['mes_ano'];
    cell2.innerHTML = formattedDate(data['data_geracao'], true, false);
    cell3.innerHTML = data['quantidade_contagens'];
    cell4.innerHTML = '<a href="/pf/DIM.Gateway.php?arq=64&tch=0&sub=7&dlg=1&i=' + data['id'] + '&p=" target="_new"><i class="fa fa-file-pdf-o fa-lg"></i></a>&nbsp;&nbsp;' +
            '<a href="/pf/DIM.Gateway.php?arq=64&tch=0&sub=7&dlg=1&i=' + data['id'] + '" target="_new"><i class="fa fa-internet-explorer fa-lg"></i></a>';
    cell5.innerHTML = "R$ " + parseFloat(data['valor_faturamento']).toFixed(2);
    /*
     * para faturamentos via PAG Seguro
     */
    if (data['status'] == 0 && data['is_faturavel'] == 1 && data['tipo_faturamento'] == 0) {
        cell6.innerHTML = '' +
                '<form method="post" target="pagseguro" action="https://pagseguro.uol.com.br/v2/checkout/payment.html">' +
                '<input name="receiverEmail" type="hidden" value="joseclaudio.siqueira@pfdimension.com.br">' +
                '<input name="currency" type="hidden" value="BRL">' +
                '<input name="itemId1" type="hidden" value="0001">' +
                '<input name="itemDescription1" type="hidden" value="Faturamento - contagens - Dimension">' +
                '<input name="itemAmount1" type="hidden" value="' + parseFloat(data['valor_faturamento']).toFixed(2) + '">' +
                '<input name="itemQuantity1" type="hidden" value="1">' +
                '<input name="itemWeight1" type="hidden" value="0">' +
                '<input name="reference" type="hidden" value="' + data['mes_ano'].replace('/', '') + ("0000000" + data['id_empresa']).slice(-7) + '">' +
                '<input name="shippingType" type="hidden" value="1">' +
                '<input name="shippingAddressPostalCode" type="hidden" value="' + data['cep'] + '">' +
                '<input name="shippingAddressStreet" type="hidden" value="' + data['logradouro'] + '">' +
                '<input name="shippingAddressNumber" type="hidden" value="0">' +
                '<input name="shippingAddressComplement" type="hidden" value="N/A">' +
                '<input name="shippingAddressDistrict" type="hidden" value="' + data['bairro'] + '">' +
                '<input name="shippingAddressCity" type="hidden" value="' + data['cidade'] + '">' +
                '<input name="shippingAddressState" type="hidden" value="' + data['uf'] + '">' +
                '<input name="shippingAddressCountry" type="hidden" value="BRA">' +
                '<input name="senderName" type="hidden" value="Dimension - Metricas">' +
                '<input name="senderAreaCode" type="hidden" value="61">' +
                '<input name="senderPhone" type="hidden" value="986289027">' +
                '<input name="senderEmail" type="hidden" value="' + data['email'] + '">' +
                '<input alt="Pague aqui" name="submit" type="image" width="140" height="21" src="https://stc.pagseguro.uol.com.br/public/img/botoes/pagamentos/205x30-pagar.gif"/>' +
                '</form>';
    }
    /*
     * para pagamentos via outra forma Boleto/Contrato/NF
     */
    else if (data['status'] == 0 && data['is_faturavel'] == 1 && data['tipo_faturamento'] == 1) {
        cell6.innerHTML = '<i class="fa fa-check-circle fa-lg"></i>&nbsp;PENDENTE<sup>1</sup>';
    }
    else {
        if (data['status'] == 1) {
            cell6.innerHTML = '<i class="fa fa-check-circle fa-lg"></i>&nbsp;PAGO';
        }
        else if (data['is_faturavel'] == 0) {
            cell6.innerHTML = '<i class="fa fa-check-circle fa-lg"></i>&nbsp;ISENTO';
        }
    }
    /*
     * caso ja tenha pago insere data de pagamento, NF, OB, etc.
     */
    cell7.innerHTML = null != data['detalhes_pagamento'] ? data['detalhes_pagamento'] : 'N/A';
}