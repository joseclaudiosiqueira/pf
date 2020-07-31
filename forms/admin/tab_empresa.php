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
        <i class="fa fa-info-circle fa-lg"></i>&nbsp;&nbsp;Empresa<br />
        <span class="sub-header">Configure as informa&ccedil;&otilde;s principais da sua empresa</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <strong><a href="#" data-toggle="modal" data-target="#form_modal_configuracoes_empresa" id="fmcemp-link"><i class="fa fa-cog"></i>&nbsp;Empresa</a></strong><br />
                Defini&ccedil;&otilde;es sobre os contatos administrativos do sistema e inser&ccedil;&atilde;o/altera&ccedil;&atilde;o da logomarca da empresa
                <br /><br />
                <?php
                if (getUserName() === '41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265') {
                    ?>
                    <strong><a href="#" data-toggle="modal" data-target="#form_modal_inserir_empresa" id="fmcempinc-link"><i class="fa fa-plus-circle"></i>&nbsp;Nova Empresa</a></strong><br />
                    Inser&ccedil;&atilde;o de uma nova empresa no sistema Dimension&reg;
                    <?php
                }
                ?>
                <br /><br />
                <strong>
                    <a href="#" data-toggle="modal" data-target="#form-modal-gerenciar-orgao" class="link-gerenciar-orgao">
                        <i class="fa fa-sitemap"></i>&nbsp;&Oacute;rg&atilde;os</a></strong><br />
                Defina a estrutura de &oacute;rg&atilde;os/departamentos/setores da sua Empresa ou dos seus Clientes.
            </div>
            <div class="col-md-4">
                <strong><a href="#" data-toggle="modal" data-target="#form_modal_configuracoes_autenticacao" id="ldap-link"><i class="fa fa-user-secret"></i>&nbsp;Autentica&ccedil;&atilde;o</a></strong><br />
                Configura&ccedil;&atilde;o do sistema de autentica&ccedil;&atilde;o de usu&aacute;rios<br /><br />
                <small>
                    Ao configurar sua empresa para logar via LDAP, lembre-se que os usu&aacute;rios dos Fornecedores cadastrados devem ser inseridos no seu LDAP para que possam logar no sistema Dimension&reg;.
                    <strong>Esta op&ccedil;&atilde;o est&aacute; dispon&iacute;vel apenas em instala&ccedil;&otilde;es locais.</strong>
                </small><br /><br />
                <div style="border: 1px dotted #f68; padding: 5px; border-radius: 5px;">
                    * <strong>ATEN&Ccedil;&Atilde;O</strong>: &eacute; estritamente recomend&aacute;vel que o administrador do ambiente da sua empresa seja consultado antes da realiza&ccedil;&atilde;o das configura&ccedil;&otilde;es
                    no sistema de autentica&ccedil;&atilde;o, sob pena de nenhum usu&aacute;rio conseguir logar. Caso voc&ecirc; configure o LDAP e tenha usu&aacute;rios de FORNECEDORES, estes dever&atilde;o ser cadastrados
                    no LDAP para poderem logar no Dimension&reg;. <strong>Lembre-se</strong> ainda que mesmo utilizando o LDAP voc&ecirc; deve cadastrar os usu&aacute;rios no sistema, para que eles sejam associados aos perfis.
                </div>                   
            </div>
            <div class="col-md-4">
                <?php
                /*
                 * verifica a utilizacao de espaco em disco do plano contratado
                 */
                $espacoUtilizado = getEspacoDisco(DIR_FILE . '/' . str_pad(getIdEmpresa(), 11, '0', STR_PAD_LEFT) . '/');
                $espacoLivre = getConfigPlano('armazenamento') - $espacoUtilizado;
                $espacoTotal = getConfigPlano('armazenamento');
                $percentualLivre = number_format(($espacoLivre / $espacoTotal) * 100, 2);
                $percentualLivre < 20 ? $progress = 'danger' : $progress = 'success';
                ?>
                <strong><i class="fa fa-database"></i>&nbsp;Armazenamento</strong><br />
                Informa&ccedil;&otilde;es sobre o espa&ccedil;o de armazenamento utilizado por sua empresa
                <div class="row" style="padding: 10px;">
                    <div class="col-md-12" style="text-align: center;">
                        Espa&ccedil;o em disco - Utilizado: <?= tamanhoArquivo($espacoUtilizado); ?> | Livre: <?= tamanhoArquivo($espacoLivre); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="progress">
                            <div class="progress-bar progress-bar-<?= $progress; ?>" role="progressbar" aria-valuenow="<?= $percentualLivre; ?>"
                                 aria-valuemin="0" aria-valuemax="100" style="width:<?= $percentualLivre . '%'; ?>">
                                Livre (<?= $percentualLivre . '%'; ?>)
                            </div>
                        </div>                            
                    </div>
                </div>
                <strong><i class="fa fa-info-circle"></i>&nbsp;Quantidade de contagens</strong><br />
                Informa&ccedil;&otilde;es sobre a quantidade de contagens inseridas no sistema
                <div class="row">
                    <div class="col-md-12">
                        <div class="well well-lg">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>