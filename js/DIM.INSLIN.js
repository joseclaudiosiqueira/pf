function insereLinha(
        id,
        tabela,
        row,
        operacao,
        funcao,
        td,
        tr,
        complexidade,
        pfb,
        siglaFator,
        pfa,
        obsFuncao,
        situacao,
        entrega,
        lido,
        nLido,
        isGrafico,
        isMudanca,
        faseMudanca,
        percentualFase,
        fd,
        isCrud,
        isCrudAtualizarDependentes,
        fe) {
    /*
     * set o class name para o fade de insercao das linhas
     */
    row.className = 'fadeIn';

    var cell1 = row.insertCell(0);//sequencia
    var cell2 = row.insertCell(1);//operacao
    var cell3 = row.insertCell(2);//funcao
    var cell4 = row.insertCell(3);//td
    var cell5 = row.insertCell(4);//tr,ar
    var cell6 = row.insertCell(5);//complexidade
    var cell7 = row.insertCell(6);//pfb
    var cell8 = row.insertCell(7);//sigla,fator
    var cell9 = row.insertCell(8);//pfa
    var cell10 = row.insertCell(9);//entrega
    var cell11 = row.insertCell(10);//observacoes-->agora eh botoes
    //var cell12 = row.insertCell(11);//botoes-->por enquando nao existe

    //insere o id na celula (1) para atualizar o background quando validar
    cell1.id = 'cell1_' + tabela + '_' + id;

    var qtdAtual = getQtdAtual(tabela);
    var oper = divOperacao(operacao);

    var vPfa = Number(pfa);
    var vPfb = Number(pfb);

    cell2.id = "oper_" + tabela + "_" + qtdAtual;
    cell3.id = "funcao_" + tabela + "_" + qtdAtual;
    cell4.id = "td_" + tabela + "_" + qtdAtual;
    cell5.id = (tabela === 'ALI' || tabela === 'AIE' ? "tr_" : "ar_") + tabela + "_" + qtdAtual;
    cell6.id = "complexidade_" + tabela + "_" + qtdAtual;
    cell7.id = "pfb_" + tabela + "_" + qtdAtual;
    cell8.id = "siglaFator_" + tabela + "_" + qtdAtual;
    cell9.id = "pfa_" + tabela + "_" + qtdAtual;
    cell10.id = "ent_" + tabela + "_" + qtdAtual + '_' + id;
    isAutorizadoAlterar ? cell10.setAttribute('onclick', 'exibeCampoEntrega($(this),\'' + tabela + '\', ' + id + ', ' + idContagem + ');') : null;
    /*
     * insere o background da situacao
     */
    setSituacao(situacao, 'cell1_' + tabela + '_' + id);
    /*
     * verifica se eh uma alteracao ou exclusao e define o processo de mudanca
     */
    var c = (operacao === 'A' || operacao === 'E') ? (isMudanca == 1 ? '<br />Retrabalho: ' + faseMudanca + ' - ' + percentualFase + '%' : '') : '';
    var t = '';
    var y = '';
    /*
     * verifica se tem fator de documentacao
     */
    if (Number(fd) > 0) {
        t = (isMudanca == 1 ? '&nbsp;&nbsp;' : '<br />') + 'Fator Documentação: ' + parseFloat(fd).toFixed(2);
    }
    if(Number(fe) > 0){
        y = '<br />Formulario Estendido: ' + parseFloat(fe).toFixed(2);
    }
    /*
     * insere os quadrados com as mensagens de Validacao, Validacao Externa e/ou Auditoria
     * TODO: refazer
     * setMensagens(obsValidador, obsValidadorExterno, obsAuditor, cell2, id);
     */
    cell2.innerHTML = oper;
    cell3.innerHTML = funcao;
    cell4.innerHTML = td;
    cell5.innerHTML = tr;
    cell6.innerHTML = complexidade;
    cell7.innerHTML = parseFloat(pfb).toFixed(4);
    cell8.innerHTML = siglaFator + (isMudanca == 1 ? c : '') + t + y;
    cell9.innerHTML = parseFloat(pfa).toFixed(4);
    cell10.innerHTML = entrega;

    var divBtnGroup = document.createElement('div');
    divBtnGroup.className = 'btn-group btn-group-justified';

    //excluir
    var divBtnGroup1 = document.createElement('div');
    divBtnGroup1.className = 'btn-group';
    //editar
    var divBtnGroup2 = document.createElement('div');
    divBtnGroup2.className = 'btn-group';
    //mensagens
    var divBtnGroup3 = document.createElement('div');
    divBtnGroup3.className = 'btn-group';

    var btnExcluir = document.createElement('button');
    btnExcluir.type = 'button';
    btnExcluir.className = 'btn btn-default';
    btnExcluir.innerHTML = '<i class="fa fa-trash"></i><span class="not-view">&nbsp;Excluir</span>';
    btnExcluir.setAttribute("onclick", "javascript: excluirLinha(" + id + ",'" + tabela + "', parentNode.parentNode.parentNode.parentNode.rowIndex, " + vPfa + ", " + vPfb + ", " + isCrud + ");");
    btnExcluir.id = 'excluir_' + tabela + "_" + qtdAtual;

    var btnEditar = document.createElement('button');
    btnEditar.type = 'button';
    btnEditar.className = 'btn btn-default';
    btnEditar.innerHTML = '<i class="fa fa-edit"></i><span class="not-view">&nbsp;Editar</span>';
    btnEditar.setAttribute("onclick", "retornaFuncao" + (tabela === 'ALI' || tabela === 'AIE' ? "Dados" : "Transacao") + "('" + id + "','" + tabela + "','" + qtdAtual + "','" + pfa + "', $(this)[0].id); return false;");
    btnEditar.id = "editar_" + tabela + "_" + qtdAtual;

    var btnComentar = document.createElement('button');
    btnComentar.type = 'button';
    btnComentar.className = 'btn btn-default';
    btnComentar.innerHTML = '<i class="fa fa-comments fa-lg"></i>&nbsp;<span class="not-view">' +
            '<span class="label label-success" id="lido-' + tabela + '-' + qtdAtual + '">' + lido + '</span>' +
            '<span class="label label-warning" id="nlido-' + tabela + '-' + qtdAtual + '">' + nLido + '</span></span>';
    btnComentar.setAttribute('data-toggle', 'modal');
    btnComentar.setAttribute('data-target', '#form_modal_comentarios');
    btnComentar.setAttribute('onclick', 'retornaComentarios("' + id + '", "' + tabela.toLowerCase() + '", ' + qtdAtual + ', false)');
    btnComentar.id = 'comentar_' + tabela + '_' + qtdAtual;

    divBtnGroup1.appendChild(btnExcluir);
    divBtnGroup2.appendChild(btnEditar);
    divBtnGroup3.appendChild(btnComentar);

    divBtnGroup.appendChild(divBtnGroup1);
    divBtnGroup.appendChild(divBtnGroup2);
    divBtnGroup.appendChild(divBtnGroup3);

    cell11.appendChild(divBtnGroup);//cell12
    /*
     * cria a celula que sequencia as linhas e o input hidden que conterah o id do elemento
     */
    var iSEQHidden = document.createElement('input');
    iSEQHidden.type = 'hidden';
    iSEQHidden.name = 'id_' + tabela;
    iSEQHidden.value = id;

    var iSEQ = document.createElement("div");
    iSEQ.id = "seq_" + tabela + '_' + qtdAtual;
    iSEQ.className = "div-seq-" + tabela + " div-linha";
    iSEQ.innerHTML = qtdAtual;
    iSEQ.setAttribute("onclick", "javascript: " +
            "if(ac === 'vi' && isAutorizadoValidarInternamente){ " +
            "   selecionaLinhaValidacao(this, parentNode.parentNode, '" + tabela + "', " + id + ");}" +
            "else if(ac === 're' && isAutorizadoRevisar){" +
            "   if(4 == " + situacao + " || 3 == " + situacao + "){" +
            "       concluirRevisaoLinha('" + tabela + "', " + id + ");}" +
            "   else {" +
            "       swal({title: 'Alerta',text: 'Voc&ecirc; n&atilde;o est&aacute; autorizado a validar/revisar estas funcionalidades.',type: 'info', html: true,confirmButtonText: 'Entendi, obrigado!'});}}" +
            "else {" +
            "   swal({title: 'Alerta',text: 'Voc&ecirc; n&atilde;o est&aacute; autorizado a validar/revisar estas funcionalidades.',type: 'info', html: true,confirmButtonText: 'Entendi, obrigado!'});}");
    iSEQ.appendChild(iSEQHidden);
    cell1.appendChild(iSEQ);
    /*
     * funcao que incrementa a numeracao das funcoes ALI, AIE, EE, ...
     */
    incrementaLinha(tabela);
    /*
     * atualiza as estisticas. O ultimo parametro servira para redesenhar o grafico das entregas
     * passando o novo fator Formulario Estendido junto com o FI para calcular corretamente
     */
    recalculaEstatisticas(vPfa.toFixed(4), vPfb.toFixed(4), tabela, 'incluir', 0, 0, isGrafico);
    /*
     * atualiza os itens de pesquisa nos arquivos referenciados apenas para as funcoes de dados
     */
    (tabela === 'ALI' || tabela === 'AIE') ? atualizaItensArquivosReferenciados($("#chk_pesq_contagem_atual"), 'A') : null;
    /*
     * verifica sempre a qtd atual e desabilita a opcao de mudanca de baseline
     */
    qtdAtual > 0 ? $('#contagem_id_baseline').prop('disabled', true) : $('#contagem_id_baseline').prop('disabled', false);
    /*
     * agora ao final estabelece os tooltips
     */
    $('[data-toggle="popover"]').popover({html: true});//, container: 'body'
}

function insereLinhaOutros(
        id,
        tabela,
        row,
        operacao,
        funcao,
        qtd,
        siglaFator,
        pfa,
        obsFuncao,
        situacao,
        entrega,
        lido,
        nLido,
        isGrafico) {
    /*
     * set o class name para o fade de insercao das linhas
     */
    row.className = 'fadeIn';

    var cell1 = row.insertCell(0);//seq
    var cell2 = row.insertCell(1);//operacao
    var cell3 = row.insertCell(2);//funcao,descricao
    var cell4 = row.insertCell(3);//qtd
    var cell5 = row.insertCell(4);//pf
    var cell6 = row.insertCell(5);//tipo
    var cell7 = row.insertCell(6);//entrega
    var cell8 = row.insertCell(7);//botoes
    //insere o id na celula (1) para atualizar o background quando validar
    cell1.id = 'cell1_' + tabela + '_' + id;

    qtdAtual = getQtdAtual(tabela);
    var oper = divOperacao(operacao);
    var vPfa = Number(pfa);

    cell2.id = "oper_" + tabela + "_" + qtdAtual;
    cell3.id = "funcao_" + tabela + "_" + qtdAtual;
    cell4.id = "qtd_" + tabela + "_" + qtdAtual;
    cell5.id = "pfa_" + tabela + "_" + qtdAtual;
    cell6.id = "siglaFator_" + tabela + "_" + qtdAtual;
    cell7.id = "ent_" + tabela + "_" + qtdAtual + "_" + id;
    isAutorizadoAlterar ? cell7.setAttribute('onclick', 'exibeCampoEntrega($(this),\'' + tabela + '\', ' + id + ', ' + idContagem + ');') : null;
    /*
     * insere o background da situacao
     */
    setSituacao(situacao, 'cell1_' + tabela + '_' + id);
    /*
     * insere os quadrados com as mensagens de Validacao, Validacao Externa e/ou Auditoria
     * TODO: atualizar
     * setMensagens(obsValidador, obsValidadorExterno, obsAuditor, cell2, id);
     */
    cell2.innerHTML = oper;
    cell3.innerHTML = funcao;
    cell4.innerHTML = qtd;
    cell5.innerHTML = parseFloat(pfa).toFixed(4);
    cell6.innerHTML = siglaFator;
    cell7.innerHTML = entrega;

    var divBtnGroup = document.createElement('div');
    divBtnGroup.className = 'btn-group btn-group-justified';

    //excluir
    var divBtnGroup1 = document.createElement('div');
    divBtnGroup1.className = 'btn-group';
    //editar
    var divBtnGroup2 = document.createElement('div');
    divBtnGroup2.className = 'btn-group';
    //mensagens
    var divBtnGroup3 = document.createElement('div');
    divBtnGroup3.className = 'btn-group';

    var btnExcluir = document.createElement('button');
    btnExcluir.type = 'button';
    btnExcluir.className = 'btn btn-default';
    btnExcluir.innerHTML = '<i class="fa fa-trash"></i><span class="not-view">&nbsp;Excluir</span>';
    btnExcluir.setAttribute("onclick", "javascript: excluirLinha(" + id + ",'" + tabela + "', parentNode.parentNode.parentNode.parentNode.rowIndex, $('#pfa_" + tabela + "_" + qtdAtual + "').html(), 0);");
    btnExcluir.id = 'excluir_' + tabela + "_" + qtdAtual;

    var btnEditar = document.createElement('button');
    btnEditar.type = 'button';
    btnEditar.className = 'btn btn-default';
    btnEditar.innerHTML = '<i class="fa fa-edit"></i><span class="not-view">&nbsp;Editar</span>';
    btnEditar.setAttribute("data-toggle", "modal");
    btnEditar.setAttribute("onclick", "retornaFuncaoOutros('" + id + "','" + tabela + "','" + qtdAtual + "','" + pfa + "', $(this)[0].id); return false;");
    btnEditar.id = "editar_" + tabela + "_" + qtdAtual;

    var btnComentar = document.createElement('button');
    btnComentar.type = 'button';
    btnComentar.className = 'btn btn-default';
    btnComentar.innerHTML = '<i class="fa fa-comments fa-lg"></i>&nbsp;<span class="not-view">' +
            '<span class="label label-success" id="lido-' + tabela + '-' + qtdAtual + '">' + lido + '</span>' +
            '<span class="label label-warning" id="nido-' + tabela + '-' + qtdAtual + '">' + nLido + '</span></span>';
    btnComentar.setAttribute('data-toggle', 'modal');
    btnComentar.setAttribute('data-target', '#form_modal_comentarios');
    btnComentar.setAttribute('onclick', 'retornaComentarios("' + id + '", "' + tabela.toLowerCase() + '", ' + qtdAtual + ', ' + (Number(lido) + Number(nLido)) + ', false)');
    btnComentar.id = 'comentar_' + tabela + '_' + qtdAtual;

    divBtnGroup1.appendChild(btnExcluir);
    divBtnGroup2.appendChild(btnEditar);
    divBtnGroup3.appendChild(btnComentar);

    divBtnGroup.appendChild(divBtnGroup1);
    divBtnGroup.appendChild(divBtnGroup2);
    divBtnGroup.appendChild(divBtnGroup3);

    cell8.appendChild(divBtnGroup);//cell9
    /*
     * cria a celula que sequencia as linhas e o input hidden que contera o id do elemento
     */
    var iSEQHidden = document.createElement('input');
    iSEQHidden.type = 'hidden';
    iSEQHidden.name = 'id_' + tabela;
    iSEQHidden.value = id;

    var iSEQ = document.createElement("div");
    iSEQ.id = "seq_" + tabela + '_' + qtdAtual;
    iSEQ.className = "div-seq-" + tabela + " div-linha";
    iSEQ.innerHTML = qtdAtual;
    iSEQ.setAttribute("onclick", "javascript: " +
            "if(ac === 'vi' && isAutorizadoValidarInternamente){ " +
            "   selecionaLinhaValidacao(this, parentNode.parentNode, '" + tabela + "', " + id + ");}" +
            "else if(ac === 're' && isAutorizadoRevisar){" +
            "   if(4 == " + situacao + " || 3 == " + situacao + "){" +
            "       concluirRevisaoLinha('" + tabela + "', " + id + ");}" +
            "   else {" +
            "       swal({title: 'Alerta',text: 'Voc&ecirc; n&atilde;o est&aacute; autorizado a validar/revisar estas funcionalidades.',type: 'info', html: true,confirmButtonText: 'Entendi, obrigado!'});}}" +
            "else {" +
            "   swal({title: 'Alerta',text: 'Voc&ecirc; n&atilde;o est&aacute; autorizado a validar/revisar estas funcionalidades.',type: 'info', html: true,confirmButtonText: 'Entendi, obrigado!'});}");
    iSEQ.appendChild(iSEQHidden);
    cell1.appendChild(iSEQ);
    /*
     * funcao que incrementa a numeracao das funcoes ALI, AIE, EE, ...
     */
    incrementaLinha(tabela);
    /*
     * atualiza as estisticas recalculaEstatisticas(pfa, pfb, tb, ac, pfn)
     */
    recalculaEstatisticas(vPfa.toFixed(4), 0, 'OU', 'incluir', 0, 0, isGrafico);
    /*
     * desabilita a mudanca de baseline
     */
    qtdAtual > 0 ? $('#contagem_id_baseline').prop('disabled', true) : $('#contagem_id_baseline').prop('disabled', false);
    /*
     * agora ao final estabelece os tooltips
     */
    $('[data-toggle="tooltip"]').tooltip();
}