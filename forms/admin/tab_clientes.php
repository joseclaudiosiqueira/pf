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
<div class="panel panel-default">
    <div class="panel-title">
        <i class="fa fa-info-circle fa-lg"></i>&nbsp;&nbsp;Clientes<br />
        <span class="sub-header">Gerenciamento dos clientes</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <?php echo (!(isFornecedor() || getConfigPlano('id') < 3)) ? '<strong><a href="#" id="fmiacli-link"><i class="fa fa-user-plus"></i>&nbsp;<span id="cli-inserir">Inserir</span></a></strong>' : '<strong><i class="fa fa-user-plus"></i>&nbsp;Clientes</strong>'; ?><br />
                Inclus&atilde;o de informa&ccedil;&otilde;es: nome, contatos e logomarca<br />
            </div>
            <div class="col-md-3">
                <?php if (!(isFornecedor() || getConfigPlano('id') < 3)) { ?>
                    <span id="href_modal_alterar_cliente"><i class="fa fa-user"></i>&nbsp;<span id="fmiacli-label-acao">Alterar/Consultar</span></span>
                    <?php
                }
                ?>
                <br />
                <div id="fmiacli-label-informacao">Para alterar as informa&ccedil;&otilde;es selecione um Cliente nas op&ccedil;&otilde;es abaixo</div><br />
                <div class="form-group">
                    <?php if (!(isFornecedor() || getConfigPlano('id') < 3)) { ?>
                        <select class="form-control input_style" id="combo_alterar_id_cliente"></select>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <div style="width: 100%; visibility: hidden;" id="fmiacli_info">
                    <div class="jumbotron" style="padding: 20px;">
                        <div class="row">
                            <div class="col-md-4">
                                <center>
                                    <span id="fmiacli_span_logomarca"></span>
                                </center>
                            </div>
                            <div class="col-md-8">
                                <div class="sub_text"><i class="fa fa-building"></i>&nbsp;Nome</div><strong><span id="fmiacli_span_descricao"></span></strong><br /><br />
                                <div class="sub_text"><i class="fa fa-user"></i>&nbsp;Contato</div><strong><span id="fmiacli_span_nome"></span></strong><br /><br />
                                <div class="sub_text"><i class="fa fa-envelope"></i>&nbsp;Email</div><span id="fmiacli_span_email"></span><br /><br />
                                <div class="sub_text"><i class="fa fa-phone"></i>&nbsp;Telefone principal</div><span id="fmiacli_span_telefone"></span><br /><br />
                                <span id="div-txt-cliente"></span><br /><br />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php if (!(isFornecedor() || getConfigPlano('id') < 3)) { ?>
                                    <button type="button" class="btn btn-success" id="fmiacli_btn_alterar" data-toggle="modal" data-target="#form_modal_inserir_cliente" disabled><i class="fa fa-edit"></i>&nbsp;Alterar</button>
                                    <?php
                                }
                                ?>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
