<?php
/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
?>
<!-- Modal -->
<div id="form_modal_help_copiar_colar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="fechar_dados" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-copy fa-lg"></i>&nbsp;Opera&ccedil;&otilde;es de <kbd>&nbsp;CTRL&nbsp;+&nbsp;C&nbsp;</kbd>&nbsp;e&nbsp;<kbd>&nbsp;CTRL&nbsp;+&nbsp;V&nbsp;</kbd><br />
                <span class="sub-header">Como elaborar um arquivo de texto para copiar e colar e inserir automaticamente as funcionalidades</span>
            </div>
            <div class="modal-body">
                <div class="row scroll" style="max-height: 530px; overflow-x: hidden; overflow-y: scroll;">
                    <div class="col-md-12">
                        <strong>Para fun&ccedil;&otilde;es de dados (ALI e AIE)</strong><br />
                        <div style="font-family: monospace; font-size:13px;" class="well well-sm">
                            [funcao];[operacao];[td];[tr];[metodo];[observacoes sobre a fun&ccedil;&atilde;o]<br />
                            TD:[descricao-td-1];[descricao-td-2];[descricao-td-3]...;[descricao-td-n]<br />
                            TR:[descricao-tr-1];...;[descricao-tr-n]<br />
                            <span class="samp">
                                1 | comentario;I;10;9;D;<br />
                                2 | TD:id;descricao;destinatario;data_insercao<br />
                                3 | TR:comentario;destinatario;data_insercao
                            </span>
                        </div>
                        <strong>Para fun&ccedil;&otilde;es de transa&ccedil;&atilde;o (EE, SE e CE)</strong><br />
                        <div style="font-family: monospace; font-size:13px;" class="well well-sm">
                            [funcao];[operacao];[td];[ar];[metodo];[observacoes sobre a fun&ccedil;&atilde;o]<br />
                            TD:[(ali/aie).(ar).descricao-td-1];[(ali/aie).(ar).descricao-td-2]...;[(ali/aie).(ar).descricao-td-n]<br />
                            AR:[(ali/aie).descricao-ar-1],...,[(ali/aie).descricao-ar-n]<br />
                            <span class="samp">
                                1 | consulta_comentario;I;5;3;D;<br />
                                2 | TD:ali.comentario.id;ali.comentario.descricao;...;aie.pessoas.nome;aie.usuario.email<br />
                                3 | AR:ali.comentario;aie.pessoas;...;aie.usuario<br />
                            </span>
                        </div>
                        <strong>ATEN&Ccedil;&Atilde;O</strong>
                        <ul>
                            <li>N&atilde;o esque&ccedil;a de inserir o ponto-e-v&iacute;rgula ao final da primeira linha da funcionalidade;</li>
                            <li>Para colar, basta selecionar a ABA e digitar <kbd>CTRL + V</kbd> que o sistema ir&aacute; realizar as verifica&ccedil;&otilde;es e exibir a lista com as funcionalidades;</li>
                            <li>Insira uma linha para cada fun&ccedil;&atilde;o, mais uma linha para os AR/TR e uma linha para os TD, totalizando sempre tr&ecirc;s linhas;</li>
                            <li><span class="bg-danger">Insira as linhas de AR/TR e TD mesmo que n&atilde;o haja descri&ccedil;&atilde;o;</span></li>
                            <li><strong>Opera&ccedil;&atilde;o</strong><br />
                                <ul>
                                    <li>Caso seja um ALI em contagem de <u>Projeto/Avulsa</u> voc&ecirc; pode (I) inserir, (A) alterar ou (E) excluir;</li>
                                    <li>O sistema verificar&aacute; nas op&ccedil;&otilde;es (A) alterar e (E) excluir se o ALI existe na Baseline caso seja uma contagem de <u>Projeto</u>;</li>
                                    <li>Caso seja um ALI em contagem de <u>Baseline</u> voc&ecirc; pode apenas (I) inserir;</li>
                                    <li>Caso seja um AIE em contagem de <u>Projeto</u> voc&ecirc; pode (I) incluir e (E) excluir;</li>
                                    <li>Caso queira inserir um AIE na contagem voc&ecirc; pode clicar no bot&atilde;o [<u><i class="fa fa-search-plus"></i>&nbsp;Pesquisar nas baselines</u>]</li>
                                    <li>Caso seja uma EE, SE ou CE em contagem de <u>Projeto</u> voc&ecirc; pode (I) inserir, (A) alterar, (E) excluir ou (T) testes (pontos de teste)</li>
                                    <li>O sistema verificar&aacute; nas op&ccedil;&otilde;es (A) alterar, (E) excluir e (T) testes se a funcionalidade existe na baseline caso seja uma contagem de <u>Projeto</u>;</li>
                                    <li>Caso esteja inserindo funcionalidades que estejam em uma baseline em contagem de projeto o sistema buscar&aacute; automaticamente as informa&ccedil;&otilde;es, independente do que tenha sido colado.</li>
                                </ul>
                            </li>
                            <li>Cada funcionalidade deve ser copiada e colada separadamente, note que o sistema leva em conta a <kbd>ABA</kbd> atual que est&aacute; selecionada;</li>
                            <li>Prepare em qualquer editor de texto simples: <strong>Notepad</strong>, <strong>Textpad&reg;</strong>, etc.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>