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
<div id="form_modal_relatorios" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form-config-relatorios">
                <div class="modal-header">
                    <button type="button" id="fechar_relatorios" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-text-width"></i>&nbsp;&nbsp;Formata&ccedil;&atilde;o dos relat&oacute;rios<br />
                    <span class="sub-header">Adeque os relat&oacute;rios ao visual da sua empresa e/ou fornecedores</span>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs relatorio" style="margin-top: -20px;">
                        <li class="active">
                            <a data-toggle="tab" href="#tab-apf-relatorio">
                                <div class="top-title">
                                    <i class="fa fa-file-pdf-o fa-lg"></i>
                                </div>
                                <strong>Relat&oacute;rio</strong></a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#tab-apf-assinatura">
                                <div class="top-title">
                                    <i class="fa fa-edit fa-lg"></i>
                                </div>
                                <strong>Assinaturas</strong></a>
                        </li>
                    </ul>
                    <div class="tab-content tab-transp">
                        <div id="tab-apf-relatorio" class="tab-pane fade in active" style="min-height: 535px;">
                            <div class="panel panel-default">                            
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select id="relatorio_id_cliente" class="form-control input_style"></select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="checkbox" id="is-logomarca-empresa" class="css-checkbox" disabled/><label for="is-logomarca-empresa" class="css-label-check">Logomarca da <strong>empresa?</strong></label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="checkbox" id="is-logomarca-cliente" class="css-checkbox" disabled/><label for="is-logomarca-cliente" class="css-label-check">Logomarca do <strong>cliente?</strong></label>
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">
                                            <label for="btn-alinhamento">Alinhamento:&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" id="txt-cab-linha-1" class="form-control input_style" maxlength="60" placeholder="Cabe&ccedil;alho - linha (1)" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" id="txt-cab-linha-2" class="form-control input_style" maxlength="60" placeholder="Cabe&ccedil;alho - linha (2)" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" id="txt-cab-linha-3" class="form-control input_style" maxlength="60" placeholder="Cabe&ccedil;alho - linha (3)" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="btn-group" id="btn-alinhamento">
                                                    <button type="button" class="btn btn-default" id="btn-left" disabled><i class="fa fa-align-left"></i></button>
                                                    <button type="button" class="btn btn-default" id="btn-center" disabled><i class="fa fa-align-center"></i></button>
                                                    <button type="button" class="btn btn-default" id="btn-right" disabled><i class="fa fa-align-right"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="padding-top: 14px; padding-bottom: 4px; border-left: 1px solid #d0d0d0; border-top: 1px solid #d0d0d0; border-right: 1px solid #d0d0d0; background: #fff url('/pf/img/recorte.png') repeat-x 0% 100%; width: 100%; height: 124px;">
                                                <div class="col-md-1" style="height: 100px;">
                                                    <img id="img-is-logomarca-empresa" src="/pf/img/empty_logo_empresa.pt_BR.jpg" valign="middle" width="85" height="85">
                                                </div>
                                                <div class="col-md-10" id="cab-alinhamento" style="line-height: 33px; text-align: center;">
                                                    <input type="hidden" id="txt-cab-alinhamento" value="center">
                                                    <h3 id="cab-linha-1" style="display:inline;"></h3><br />
                                                    <h4 id="cab-linha-2" style="display:inline;"></h4><br />
                                                    <h5 id="cab-linha-3" style="display:inline;"></h5><br />
                                                </div>
                                                <div class="col-md-1" style="height:120px;">
                                                    <img id="img-is-logomarca-cliente" src="/pf/img/empty_logo_cliente.pt_BR.jpg" valign="middle" width="85" height="85">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-md-12" style="padding:14px; line-height: 75px; text-align: center;">
                                            <div style="padding-top: 4px; padding-bottom: 3px; border-left: 1px solid #d0d0d0; border-bottom: 1px solid #d0d0d0; border-right: 1px solid #d0d0d0; background: #fff url('/pf/img/recorte_bottom.png') repeat-x 100% 0%; width: 100%; height: 75px;">
                                                <h5 id="rod-linha-1" style="display:inline;">página x de y - Emitido em xx/xx/xxx às xx:xx:xx por fulano@companhia.com</h5>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" id="txt-rod-linha-1" class="form-control input_style"  placeholder="Rodap&eacute;" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div style="height: 35px;"></div>
                                        <div class="col-md-12" style="text-align:right;">
                                            <div class="btn-group" id="acoes">
                                                <button type="submit" class="btn btn-success" id="btn-atualizar-relatorios" disabled><i class="fa fa-check"></i> Atualizar</button>
                                                <button type="button" class="btn btn-warning" id="btn-fechar-relatorios" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                                            </div>
                                        </div>
                                    </div>                      
                                </div>
                            </div>
                        </div>
                        <div id="tab-apf-assinatura" class="tab-pane fade in" style="min-height: 535px;">
                            <div class="panel panel-default">                            
                                <div class="panel-body">                            
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="assinatura_id_contrato">
                                                    <i id="w_id_contrato" class="fa fa-dot-circle-o"></i>&nbsp;Contrato(s)
                                                </label>
                                                <select id="assinatura_id_contrato" class="form-control input_style" disabled>
                                                    <option value="0">...</option>
                                                </select>
                                            </div>
                                        </div>                                
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="assinatura_id_projeto">
                                                    <i id="w_id_projeto" class="fa fa-dot-circle-o"></i>&nbsp;Projeto(s)
                                                </label>
                                                <select id="assinatura_id_projeto" class="form-control input_style" disabled>
                                                    <option value="0">...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"><br />
                                                <input type="checkbox" id="is-assinatura-relatorio" class="css-checkbox" disabled/><label for="is-assinatura-relatorio" class="css-label-check">Imprimir as assinaturas nos relat&oacute;rios?</strong></label>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="jumbotron" style="width: 100%;padding: 15px;">
                                                Assinatura [1]<br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_nome_1" placeholder="Nome (1)" disabled><br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_cargo_1" placeholder="Cargo e/ou Fun&ccedil;&atilde;o" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="jumbotron" style="width: 100%;padding: 15px;">
                                                Assinatura [2]<br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_nome_2" placeholder="Nome (2)" disabled><br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_cargo_2" placeholder="Cargo e/ou Fun&ccedil;&atilde;o" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="jumbotron" style="width: 100%;padding: 15px;">
                                                Assinatura [3]<br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_nome_3" placeholder="Nome (3)" disabled><br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_cargo_3" placeholder="Cargo e/ou Fun&ccedil;&atilde;o" disabled>
                                            </div>
                                        </div>                                
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="jumbotron" style="width: 100%;padding: 15px;">
                                                Assinatura [4]<br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_nome_4" placeholder="Nome (4)" disabled><br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_cargo_4" placeholder="Cargo e/ou Fun&ccedil;&atilde;o" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="jumbotron" style="width: 100%;padding: 15px;">
                                                Assinatura [5]<br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_nome_5" placeholder="Nome (5)" disabled><br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_cargo_5" placeholder="Cargo e/ou Fun&ccedil;&atilde;o" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="jumbotron" style="width: 100%;padding: 15px;">
                                                Assinatura [6]<br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_nome_6" placeholder="Nome (6)" disabled><br />
                                                <input type="text" class="form-control input_style" maxlength="60" id="assinatura_cargo_6" placeholder="Cargo e/ou Fun&ccedil;&atilde;o" disabled>
                                            </div>
                                        </div>                                
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align:right;">
                                            <div class="btn-group" id="acoes">
                                                <button type="button" class="btn btn-success" id="btn-atualizar-assinatura" disabled><i class="fa fa-check"></i> Atualizar</button>
                                                <button type="button" class="btn btn-warning" id="btn-fechar-assinatura" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                                            </div>
                                        </div>
                                    </div>                       
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>
