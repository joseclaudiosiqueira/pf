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
<div id="form_modal_user_detail" class="modal fade" role="dialog">
    <form id="form_user_detail">    
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="u_btn_fechar"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-user-secret"></i>&nbsp;&nbsp;Informa&ccedil;&otilde;es complementares<br />
                    <span class="sub-header">Preenchimento volunt&aacute;rio e n&atilde;o obrigat&oacute;rio. Utilizado apenas em estat&iacute;sticas</span>
                </div>            
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="u_cpf"><i class="fa fa-calculator"></i>&nbsp;C.P.F</label>
                                        <input type="text" class="form-control input_style" placeholder="CPF - somente n&uacute;meros" id="u_cpf" data-mask="00000000000">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="u_data_nascimento"><i class="fa fa-calendar"></i>&nbsp;Data de nascimento</label>
                                        <input type="text" class="form-control input_style input_calendar" placeholder="00/00/0000" id="u_data_nascimento" data-mask="00/00/0000">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="u_email_alternativo"><i class="fa fa-envelope"></i>&nbsp;Email alternativo</label>
                                        <input type="email" class="form-control input_style" placeholder="fulano@companhia.com/br" id="u_email_alternativo">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="u_apelido"><i class="fa fa-user-plus"></i>&nbsp;Como gosta de ser chamado?</label>
                                        <input type="text" class="form-control input_style" placeholder="Apelido" id="u_apelido">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="u_certificacao">
                                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;CFPS"
                                                  data-content="Certificação CFPS - Exame CFPS - Administrado pela <a href='http://www.prometric.com' target='_new'>Prometric</a>.<br />
                                                  CFPS - <i>Certified Function Point Specialist</i> - é a certificação conferida pelo International Function Point Users Group às pessoas aprovadas no exame de certificação CFPS. Existem outras
                                                  certificações oferecidas pelo IFPUG, selecione a sua, ou a que considere mais importante, se tiver mais de uma.
                                                  <hr>Caso selecione uma certificação, esta aparecerá nas assinaturas dos relatórios em que você é o responsável pela contagem.">
                                            </span><i class="fa fa-info-circle"></i>&nbsp;Certifica&ccedil;&atilde;o</label>
                                        <select id="u_certificacao" class="form-control input_style">
                                            <option value="">...</option>
                                            <option value="CFPS">CFPS - Certified Function Point Specialist</option>
                                            <option value="CFPS Fellow">CFPS Fellow - Certified Function Point Specialist with 20 or more years of continuous certification</option>
                                            <option value="CFPP">CFPP - Certified Function Point Practitioner</option>
                                            <option value="CSP">CSP - Certified SNAP Practitioner</option>
                                            <option value="CSMS">CSMS - Certified Software Measurement Specialist</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="u_uf"><i class="fa fa-map-marker"></i>&nbsp;UF</label>
                                        <select class="form-control input_style" id="u_uf"> 
                                            <option value="--">Selecione o Estado</option> 
                                            <option value="ac">Acre</option> 
                                            <option value="al">Alagoas</option> 
                                            <option value="am">Amazonas</option> 
                                            <option value="ap">Amapá</option> 
                                            <option value="ba">Bahia</option> 
                                            <option value="ce">Ceará</option> 
                                            <option value="df">Distrito Federal</option> 
                                            <option value="es">Espírito Santo</option> 
                                            <option value="go">Goiás</option> 
                                            <option value="ma">Maranhão</option> 
                                            <option value="mt">Mato Grosso</option> 
                                            <option value="ms">Mato Grosso do Sul</option> 
                                            <option value="mg">Minas Gerais</option> 
                                            <option value="pa">Pará</option> 
                                            <option value="pb">Paraíba</option> 
                                            <option value="pr">Paraná</option> 
                                            <option value="pe">Pernambuco</option> 
                                            <option value="pi">Piauí</option> 
                                            <option value="rj">Rio de Janeiro</option> 
                                            <option value="rn">Rio Grande do Norte</option> 
                                            <option value="ro">Rondônia</option> 
                                            <option value="rs">Rio Grande do Sul</option> 
                                            <option value="rr">Roraima</option> 
                                            <option value="sc">Santa Catarina</option> 
                                            <option value="se">Sergipe</option> 
                                            <option value="sp">São Paulo</option> 
                                            <option value="to">Tocantins</option> 
                                        </select> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="u_telefone_fixo"><i class="fa fa-phone"></i>&nbsp;Telefone fixo</label>
                                        <input type="text" class="form-control input_style sp_celphones" placeholder="(00) 0000-0000" id="u_telefone_fixo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="u_telefone_celular"><i class="fa fa-mobile"></i>&nbsp;Celular</label>
                                        <input type="text" class="form-control input_style sp_celphones" placeholder="(00) 0000-0000" id="u_telefone_celular">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="u_especialidades"><i class="fa fa-cogs"></i>&nbsp;Especialidades e habilidades t&eacute;cnicas<br>
                                            [ separe por v&iacute;rgula ou digite uma a uma teclando &lt;ENTER&gt; ]</label>
                                        <div class="scroll" style="border: 1px dotted #d0d0d0; border-radius: 5px; height: 149px; max-height: 149px; overflow-x: hidden; overflow-y: scroll; background-color:#fff; padding: 5px; width: 100%;">
                                            <input type="text" class="tm-input tm-input-success form-control input-medium input_style_mini" placeholder="Inserir" id="u_especialidades" style="width: 12em; display: inline-block; margin-top: 3px;" autocomplete="off" />
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="fa-ul">
                                        <li><i class="fa fa-arrow-circle-o-right"></i>&nbsp;Voc&ecirc; n&atilde;o precisa complementar nenhuma informa&ccedil;&atilde;o caso n&atilde;o ache necess&aacute;rio;</li>
                                        <li><i class="fa fa-arrow-circle-o-right"></i>&nbsp;As informa&ccedil;&otilde;es inseridas aqui ser&atilde;o de uso exclusivo da Dimension&reg; que n&atilde;o as repassar&aacute; para terceiros, sob nenhuma forma;</li>
                                        <li><i class="fa fa-arrow-circle-o-right"></i>&nbsp;Caso preencha as informa&ccedil;&atilde;o, esperamos que seja v&aacute;lida, a exemplo do C.P.F e das suas Qualifica&ccedil;&otilde;es e Habilidades T&eacute;cnicas;</li>
                                    </ul>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><i class="fa fa-camera"></i>&nbsp;Foto do seu perfil</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <iframe style="border: 1px dotted #999; width:100%; height: 565px; overflow: hidden; border-radius: 5px;" src="/pf/vendor/cropper/producao/crop/index.php?t=user" id="avatar-frame-user"></iframe>
                                </div>
                            </div>
                        </div>                      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i>&nbsp;Atualizar as informa&ccedil;&otilde;es</button>
                </div>
            </div>
        </div>
    </form>
</div>