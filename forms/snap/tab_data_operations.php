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
<div class="row">
    <div class="col-md-12">
        <div class="row-legenda">
            <i id="w_do" class="fa fa-dot-circle-o fa-lg"></i>  
            <?php include('legenda.php'); ?>
            &nbsp;&nbsp;<i class="fa fa-ellipsis-v"></i>&nbsp;&nbsp;
            Selecionado(s):&nbsp;&nbsp;
            <strong><div id="span-selecionados-DO" style="display:inline-block;min-width:60px;text-align:right;">0</div></strong>&nbsp;&nbsp;<i class="fa fa-ellipsis-v"></i>
        </div>
    </div>
</div>
<div class="container-tabs">
    <div class="table-responsive scroll">
        <table class="box-table-a" id="fixDO" style="font-size:72.5%">
            <thead>
                <tr>
                    <th rowspan="3"><input type="checkbox" id="select-DO" /><label for="select-ALI">&nbsp;#SEQ</label></th>
                    <th rowspan="3">OP</th>
                    <th rowspan="3">
                        <span class="pop" data-toggle="tooltip" title="SCU = The Functional Elementary Proccess" data-placement="top"><i class="fa fa-info-circle"></i>&nbsp;
                            SCU</span></th>
                    <th align="center" colspan="21" style="background-color: #3BBF67;"><strong>Category (1): Data Operations</strong></th>
                    <th align="center" colspan="16" style="background-color: #7D9100;"><strong>Category (2): Interface Design</strong></th>
                    <th align="center" colspan="14" style="background-color: #57a957"><strong>Category (3): Technical Environment</strong></th>
                    <th align="center" colspan="9"  style="background-color: #8eb92a"><strong>Category (4): Architecture</strong></th>
                </tr>
                <tr>
                    <th colspan="3">1.1 Data Entry Validation</th>
                    <th rowspan="2" style="background-color: #3BBF67;" nowrap>SNAP Count</th>
                    <th colspan="4">1.2 Logical and Mathematical Operations</th>
                    <th rowspan="2" style="background-color: #3BBF67;" nowrap>SNAP Count</th>
                    <th colspan="2">1.3 Data Formating</th>
                    <th rowspan="2" style="background-color: #3BBF67;" nowrap>SNAP Count</th>
                    <th colspan="3">1.4 Internal Data Movements</th>
                    <th rowspan="2" style="background-color: #3BBF67;" nowrap>SNAP Count</th>
                    <th colspan="3">1.5 Delivering Added Value to Users by Data Configuration</th>
                    <th rowspan="2" style="background-color: #3BBF67;" nowrap>SNAP Count</th>
                    <th rowspan="2" style="background-color:lightgrey;" nowrap>DO - Effort (HH)</th>
                    <th colspan="3">2.1 UI Changes</th>
                    <th rowspan="2" style="background-color: #7D9100;" nowrap>SNAP Count</th>
                    <th colspan="2">2.2 Help Methods</th>
                    <th rowspan="2" style="background-color: #7D9100;" nowrap>SNAP Count</th>
                    <th colspan="3">2.3 Multiple Input Methods</th>
                    <th rowspan="2" style="background-color: #7D9100;" nowrap>SNAP Count</th>
                    <th colspan="3">2.4 Multiple Output Methods</th>
                    <th rowspan="2" style="background-color: #7D9100;" nowrap>SNAP Count</th>
                    <th rowspan="2" style="background-color:lightgrey;" nowrap>ID - Effort (HH)</th>
                    <th colspan="3">3.1 Multiple Platforms</th>
                    <th rowspan="2" style="background-color: #57a957;" nowrap>SNAP Count</th>
                    <th colspan="4">3.2 Database Technology</th>
                    <th rowspan="2" style="background-color: #57a957;" nowrap>SNAP Count</th>
                    <th colspan="3">3.3 Batch Processes</th>
                    <th rowspan="2" style="background-color: #57a957;" nowrap>SNAP Count</th>
                    <th rowspan="2" style="background-color:lightgrey;" nowrap>TE - Effort (HH)</th>
                    <th colspan="2">4.1 Component Based Software</th>
                    <th rowspan="2" style="background-color: #8eb92a;" nowrap>SNAP Count</th>
                    <th colspan="4">4.2 Multiple Input / Output Interfaces</th>
                    <th rowspan="2" style="background-color: #8eb92a;" style="background-color: #3BBF67;" style="background-color: #3BBF67;" nowrap>SNAP Count</th>
                    <th rowspan="2" style="background-color:lightgrey;" nowrap>AC - Effort (HH)</th>
                </tr>
                <tr>
                    <th>Nesting Levels</th>
                    <th>Complexity</th>
                    <th>DETs</th>
                    <th>Elementary Proccess Type</th>
                    <th>DETs</th>
                    <th>FTRs</th>
                    <th>Complexity</th>
                    <th><span class="pop" data-toggle="tooltip" data-placement="top" title="
                              a. <strong>Low</strong>: Data type conversions or simple formatting<br />
                              b. <strong>Average</strong>: Those between Simple and Complex<br />
                              c. <strong>High</strong>: Involves Encryption/Decryption of any kind and more"><i class="fa fa-info-circle"></i>&nbsp;
                            Transformation Complexity Level</span></th>
                    <th>DETs</th>
                    <th>FTRs</th>
                    <th>Complexity</th>
                    <th>DETs</th>
                    <th><span class="pop" data-toggle="tooltip" data-placement="top" title="
                              <strong>A record</strong><br/>One row in a logical file"><i class="fa fa-info-circle"></i>&nbsp;
                            Number of Records</span></th>
                    <th>Complexity</th>
                    <th><span class="pop" data-toggle="tooltip" data-placement="top" title="
                              <strong>Attribute</strong><br/>An independent parameter that has a unique business meaning and contains a set of different values"><i class="fa fa-info-circle"></i>&nbsp;
                            Number of attributes</span></th>
                    <th>Number of properties</th>
                    <th>Complexity</th>
                    <th>Number of Unique UI Elements</th>
                    <th>Help Type</th>
                    <th>Number of items impacted</th>
                    <th>DETs</th>
                    <th>Complexity</th>
                    <th>Number of input methods</th>
                    <th>DETs</th>
                    <th>Complexity</th>
                    <th>Number of output methods</th>
                    <th>Nature of platforms</th>
                    <th>Number of platforms to operate</th>
                    <th>Plataform type</th>
                    <th>DETs</th>
                    <th>RETs</th>
                    <th>Complexity</th>
                    <th>Number of changes</th>
                    <th>FTRs</th>
                    <th>Complexity</th>
                    <th>DETs</th>
                    <th>Number of unique in-house components</th>
                    <th>Number of unique third party components</th>
                    <th>DETs</th>
                    <th>Complexity</th>
                    <th>Total of input interfaces</th>
                    <th>Total of output interfaces</th>
                </tr>
                <tr>
                    <th>
                        <div style="min-width: 60px;">
                            <div class="form-group">
                                <div class="form-control btn btn-success"><i class="fa fa-plus-circle fa-lg"></i></div>
                            </div>
                        </div>
                    </th>
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="snap-op" style="min-width: 60px;">
                                <option value="A">Add</option>
                                <option value="C">Change</option>
                                <option value="D">Delete</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 200px;"></th>
                    <!-- 1.1 Data Entry Validation -->    
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="dev-nnl" style="min-width: 60px;">
                                <option value="1">1 to 2</option>
                                <option value="2">3 to 5</option>
                                <option value="3">6+</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><div class="div-label"></div></th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 1.2 Logical and Mathematical Operations -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="lmo-ept" style="min-width: 60px;">
                                <option value="1">Mathematical</option>
                                <option value="2">Logical</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="lmo-nftr" style="min-width: 60px;">
                                <option value="1">0 to 3</option>
                                <option value="2">4 to 9</option>
                                <option value="3">10+</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 1.3 Data Formating -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="df-tcl" style="min-width: 60px;">
                                <option value="1">Low</option>
                                <option value="2">Average</option>
                                <option value="2">High</option>
                            </select>
                        </div>
                    </th>         
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 1.4 Interna Data Movements -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="davudc-nr" style="min-width: 60px;">
                                <option value="1">1 to 3</option>
                                <option value="2">4 to 9</option>
                                <option value="3">10+</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 1.5 Delivering Added Value to Users -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="uc-np" style="min-width: 60px;">
                                <option value="1">1 to 10</option>
                                <option value="2">11 to 29</option>
                                <option value="3">30+</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 2.1 UI Changes -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="uc-np" style="min-width: 60px;">
                                <option value="1">1 to 9</option>
                                <option value="2">10 to 15</option>
                                <option value="3">16+</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>                    
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 2.2 Help Methods -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="hm-ht" style="min-width: 60px;">
                                <option value="1">User Manual</option>
                                <option value="2">On-line text</option>
                                <option value="3">context help</option>
                                <option value="4">Context + On-line</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 2.3 Multiple Imput Methods -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="mim-ndet" style="min-width: 60px;">
                                <option value="1">1 to 4</option>
                                <option value="2">5 to 15</option>
                                <option value="3">16+</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 2.4 Multiple Output Methods -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="mom-ndet" style="min-width: 60px;">
                                <option value="1">1 to 4</option>
                                <option value="2">5 to 15</option>
                                <option value="3">16+</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>                    
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 3.1 Multiple Platforms -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="mp-np" style="min-width: 60px;">
                                <option value="1">Software Platform</option>
                                <option value="2">Hardware Platform</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="mp-pt" style="min-width: 60px;">
                                <option value="1">Same Family</option>
                                <option value="2">Different Family</option>
                                <option value="3">Different Browser</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 3.2 Database Technology -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="dt-ndet" style="min-width: 60px;">
                                <option value="1">1 to 19</option>
                                <option value="2">20 to 50</option>
                                <option value="3">51+</option>
                            </select>
                        </div>
                    </th>
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="dt-nret" style="min-width: 60px;">
                                <option value="1">1</option>
                                <option value="2">2 to 5</option>
                                <option value="3">6+</option>
                            </select>
                        </div>
                    </th> 
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 3.3 Batch Process -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="bp-nftr" style="min-width: 60px;">
                                <option value="1">1 to 3</option>
                                <option value="2">4 to 9</option>
                                <option value="3">10+</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 4.1 Architecture -->
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <!-- 4.2 Multiple Input/Output Interfaces -->
                    <th>
                        <div class="form-group">
                            <select class="form-control input_style" id="bp-nftr" style="min-width: 60px;">
                                <option value="1">1 to 5</option>
                                <option value="2">6 to 19</option>
                                <option value="3">10+</option>
                            </select>
                        </div>
                    </th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><input type="text" class="form-control input_style" style="min-width: 60px;"></th>
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>                    
                    <th><div class="form-group"><div class="div-label" style="min-width: 60px;"></div></th>
                </tr>
            </thead>
            <tbody id="addDO">
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                <tr><td colspan="60"></td></tr>
                
            </tbody>
        </table>
    </div>
</div>