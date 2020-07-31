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
<div class="row" style="background-color: rgb(200, 200, 200); padding: 50px;">
    <div class="container">
        <div class="col-md-4" style="background-color: #139ff7; min-height: 350px; padding:20px;">
            <table width="100%" cellpading="5" class="precos">
                <thead style="min-height:44px; line-height: 44px; background-color: #016DC5;">
                    <tr>
                        <th colspan="2"><h1 style="color: #fff;">DEMO</h1></th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="2">Armazenamento e Arquivos</td></tr>
                    <tr><td>Armazenamento</td><td>10MB (total)</td></tr>
                    <tr><td>Upload de arquivos</td><td>500KB</td></tr>
                    <tr><td>Arquivos por contagem</td><td>4</td></tr>
                    <tr><td colspan="2">Contagens</td></tr>
                    <tr><td>Contagens</td><td>5 (somente)</td></tr>
                    <tr><td>Edi&ccedil;&atilde;o Compartilhada</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Compartilhar Contagens</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Diret&oacute;rio P&uacute;blico</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Dashboad Gerencial</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td colspan="2">Tipos de Contagem</td></tr>
                    <tr><td>Avulsa</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Projeto</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Baseline</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Licita&ccedil;&atilde;o</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>SNAP</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>APT (Pontos de Teste)</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>EF (Elementos Funcionais)</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td colspan="2">Valida&ccedil;&otilde;es e Auditorias</td></tr>
                    <tr><td>Valida&ccedil;&atilde;o Interna</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Valida&ccedil;&atilde;o Externa</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Auditoria Interna</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Auditoria Externa</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td colspan="2">Exporta&ccedil;&atilde;o</td></tr>
                    <tr><td>.PDF <sup>1</sup></td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>.HTML <sup>2</sup></td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>.XML</td><td><i class="fa fa-circle"></i></td></tr>
                    <!--<tr><td>.ODS</td><td><i class="fa fa-circle"></i></td></tr>-->
                    <tr><td>.XLS</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>.XLSX</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>.IFPUG</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td colspan="2">Importa&ccedil;&atilde;o</td></tr>
                    <tr><td>.SQL</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>.CSV</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Planilhas</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td colspan="2"><h1 style="display:inline;">R$ 0</h1>,00</td>
                </tbody>
            </table>
        </div>
        <div class="col-md-4" style="background-color: #81cef9; min-height: 350px; padding:20px;">
            <table width="100%" cellpading="5" class="precos">
                <thead style="min-height:44px; line-height: 44px; background-color: #016DC5;">
                <th colspan="2">
                <h1 style="color: #fff;">ESTUDANTE</h1>
                </th>
                </thead>
                <tbody>
                    <tr><td colspan="2">Armazenamento e Arquivos</td></tr>
                    <tr><td>Armazenamento</td><td>250MB (total)</td></tr>
                    <tr><td>Upload de arquivos</td><td>1MB</td></tr>
                    <tr><td>Arquivos por contagem</td><td>8</td></tr>
                    <tr><td colspan="2">Contagens</td></tr>
                    <tr><td>Contagens</td><td>5 / Ano</td></tr>
                    <tr><td>Edi&ccedil;&atilde;o Compartilhada</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Compartilhar Contagens</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Diret&oacute;rio P&uacute;blico</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Dashboad Gerencial</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td colspan="2">Tipos de Contagem</td></tr>
                    <tr><td>Avulsa</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Projeto</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Baseline</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Licita&ccedil;&atilde;o</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>SNAP</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>APT (Pontos de Teste)</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>EF (Elementos Funcionais)</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td colspan="2">Valida&ccedil;&otilde;es e Auditorias</td></tr>
                    <tr><td>Valida&ccedil;&atilde;o Interna</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Valida&ccedil;&atilde;o Externa</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Auditoria Interna</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Auditoria Externa</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td colspan="2">Exporta&ccedil;&atilde;o</td></tr>
                    <tr><td>.PDF <sup>1</sup></td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>.HTML <sup>2</sup></td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>.XML</td><td><i class="fa fa-circle"></i></td></tr>
                    <!--<tr><td>.ODS</td><td><i class="fa fa-circle"></i></td></tr>-->
                    <tr><td>.XLS</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>.XLSX</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>.IFPUG</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td colspan="2">Importa&ccedil;&atilde;o</td></tr>
                    <tr><td>.SQL</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>.CSV</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td>Planilhas</td><td><i class="fa fa-circle"></i></td></tr>
                    <tr><td colspan="2"><h1 style="display:inline;">R$ 39</h1>,90 (por contagem)</td>
                </tbody>
            </table>
        </div>
        <div class="col-md-4" style="background-color: #cfc; min-height: 350px; padding:20px;">
            <table width="100%" cellpading="5" class="precos">
                <thead style="min-height:44px; line-height: 44px; background-color: #016DC5;">
                <th colspan="2">
                <h1 style="color: #fff;">EMPRESA</h1>
                </th>
                </thead>
                <tbody>
                    <tr><td colspan="2">Armazenamento e Arquivos</td></tr>
                    <tr><td>Armazenamento</td><td>10GB (expans&iacute;vel)</td></tr>
                    <tr><td>Upload de arquivos</td><td>4MB</td></tr>
                    <tr><td>Arquivos por contagem</td><td>Ilimitado</td></tr>
                    <tr><td colspan="2">Contagens</td></tr>
                    <tr><td>Contagens</td><td>Ilimitado</td></tr>
                    <tr><td>Edi&ccedil;&atilde;o Compartilhada</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Compartilhar Contagens</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Diret&oacute;rio P&uacute;blico</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Dashboad Gerencial</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td colspan="2">Tipos de Contagem</td></tr>
                    <tr><td>Avulsa</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Projeto</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Baseline</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Licita&ccedil;&atilde;o</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>SNAP</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>APT (Pontos de Teste)</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>EF (Elementos Funcionais)</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td colspan="2">Valida&ccedil;&otilde;es e Auditorias</td></tr>
                    <tr><td>Valida&ccedil;&atilde;o Interna</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Valida&ccedil;&atilde;o Externa</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Auditoria Interna</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>Auditoria Externa</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td colspan="2">Exporta&ccedil;&atilde;o</td></tr>
                    <tr><td>.PDF <sup>1</sup></td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>.HTML <sup>2</sup></td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>.XML</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <!--<tr><td>.ODS</td><td><i class="fa fa-check-circle"></i></td></tr>-->
                    <tr><td>.XLS</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>.XLSX</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td>.IFPUG</td><td><i class="fa fa-check-circle"></i></td></tr>
                    <tr><td colspan="2">Importa&ccedil;&atilde;o</td></tr>
                    <tr><td>.SQL</td><td>Sob consulta <sup>3</sup></td></tr>
                    <tr><td>.CSV</td><td>Sob consulta <sup>3</sup></td></tr>
                    <tr><td>Planilhas</td><td>Sob consulta <sup>3</sup></td></tr>
                    <tr><td colspan="2"><span id="valor-plano-empresarial"></span></td>
                </tbody>
            </table>            
        </div>
    </div>
</div>

