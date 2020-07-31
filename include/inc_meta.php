<?php
/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica se eh um instrutor para atribuir o valor especial de variavel isInst
 */
$userId = getUserIdDecoded();
$usuario = new Usuario();
$isInstrutor = $usuario->isInstrutor($userId);
/*
 * instancia da classe
 */
$cn = new Contagem();
/*
 * verifica a variavel aud = auditoria (contagem)
 */
if (isset($_GET['aud']) && $_GET['aud'] != 1 && $ac === 'in') {
    header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
} else {
    if (isset($_GET['aud']) && $_GET['aud'] == 1 && $ac === 'in' && !getVariavelSessao('is_inserir_contagem_auditoria')) {
        header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
    } elseif (isset($_GET['aud']) && $_GET['aud'] == 1 && $ac === 'in' && getVariavelSessao('is_inserir_contagem_auditoria')) {
        $isContagemAuditoria = 1;
    } elseif ($ac !== 'in') {
        $isContagemAuditoria = $cn->isContagemAuditoria($idContagem);
    }
}
$isContagemAuditoria = $isContagemAuditoria ? 1 : 0;
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Dimension - Metricas">
    <meta name="author" content="Dimension">
    <meta name="theme-color" content="#317EFB"/>
    <meta http-equiv="Expires" CONTENT="0">
    <meta http-equiv="Cache-Control" CONTENT="no-cache">
    <meta http-equiv="Pragma" CONTENT="no-cache">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/pf/img/favicon.ico">
    <title>Dimension - M&eacute;tricas</title>
    <?php include(DIR_BASE . 'include/inc_css.php'); ?>
    <style type="text/css">
        body{
            /*background: url('/pf/img/background/88.jpg') fixed; background-size: cover;*/
            background-color: #fff;
            padding-top: 38px;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            overflow-x: hidden;
            /* fontes do google */
            /* font-family: 'Asap', sans-serif; */
            /* font-size: 13px; */
            /*font-family: 'Roboto Condensed';*/
            /*font-family: Poppins-Regular, sans-serif;*/
            font-weight: 400;
            /*font-size: 14px;*/
            margin-top: 15px;
        }
    </style>
    <script type="text/javascript">
        String.prototype.dScr = function () {
            return this.replace(/[a-zA-Z]/g, function (c) {
                return String.fromCharCode((c <= "Z" ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26);
            });
        };
        //desligar sempre em producao
        var debug = false;
        //agora o roteiro eh padrao no inicio da contagem
        var idRoteiro;
        var qtdALI = 1;
        var qtdAIE = 1;
        var qtdEE = 1;
        var qtdSE = 1;
        var qtdCE = 1;
        var qtdOU = 1;
        var qtdSNAP = 1;
        var qtdAtual;
        var passwordComplexity;
        var arrLinhasAtuaisTD = [];
        var aDay = 86400000; //24 * 60 * 60 * 1000
        var aHour = 3600000; //60 * 60 * 1000;
        var msg = '';
        var arFn = ['NYV', 'NVR', 'RR', 'FR', 'PR', 'BH', 'QB', 'VQ', 'GR', 'NE'];
        var pBaseline = false; //quando clica na pesquisa de ALI e AIE na baseline
        var pProjeto = false; //quando clica na pesquisa de ALI e AIE no projeto
        var pAR = false; //quando clica na pesquisa de AR/TD projeto
        var bAR = false; //quando clica na pesquisa de AR/TD baseline
        var DIR_APP = '<?= PRODUCAO ? 'https://pfdimension.com.br/' : 'http://localhost/'; ?>';
        var isCRUD = true;
        var comparaID1 = 0;
        var comparaID2 = 0;
        var TRCompara;
        var isContagemAuditoria = <?= $isContagemAuditoria; ?>;
        var compararContagens = false;
        var realizarAnaliseFiscal = false;
        var doisMonitores = false;
        var faturar = false;
        var arrFaturar = [];
        var tipoComparacao = 0;
        var DIMCKEditor;
        /*
         * para as bugigangas da tabela na lista de contagens
         */
        var tblColumns;
        var tableLista;
        var fau = false;//se for para exibir faturamento autorizado
        var fat = false;//se for para exibir as faturadas
        var ana = false;//se for para analises do fiscal
        var tch = 1;
        var sub = -1;
        var dlg = 1;
        var p = '';
        var v = '';
        var r = '';
        /*
         * variaveis que definem os titulos dos formularios ALI, AIE, EE, SE e CE
         */
        var title_ali_inc = '<i class="' + 'sn sn-qngnonfr'.dScr() + '"></i>' + '&aofc;&aofc;Vafre&pprqvy;&ngvyqr;b qr Nedhvib Y&bnphgr;tvpb Vagreab - NYV'.dScr() + '<br /><span class="sub-header">Fun&ccedil;&atilde;o de Dados</span>';
        var title_ali_alt = '<i class="' + 'sn sn-qngnonfr'.dScr() + '"></i>' + '&aofc;&aofc;Nygren&pprqvy;&ngvyqr;b qr Nedhvib Y&bnphgr;tvpb Vagreab - NYV'.dScr() + '<br /><span class="sub-header">Fun&ccedil;&atilde;o de Dados</span>';
        var title_aie_inc = '<i class="' + 'sn sn-fvta-va'.dScr() + '"></i>' + '&aofc;&aofc;Vafre&pprqvy;&ngvyqr;b qr Nedhvib qr Vagresnpr Rkgrean - NVR'.dScr() + '<br /><span class="sub-header">Fun&ccedil;&atilde;o de Dados</span>';
        var title_aie_alt = '<i class="' + 'sn sn-fvta-va'.dScr() + '"></i>' + '&aofc;&aofc;Nygren&pprqvy;&ngvyqr;b qr Nedhvib qr Vagresnpr Rkgrean - NVR'.dScr() + '<br /><span class="sub-header">Fun&ccedil;&atilde;o de Dados</span>';
        var title_ee_inc = '<i class="' + 'sn sn-xrlobneq-b'.dScr() + '"></i>' + '&aofc;&aofc;Vafre&pprqvy;&ngvyqr;b qr Ragenqnf Rkgreanf - RR'.dScr() + '<br /><span class="sub-header">Fun&ccedil;&atilde;o de Transa&ccedil;&atilde;o</span>';
        var title_ee_alt = '<i class="' + 'sn sn-xrlobneq-b'.dScr() + '"></i>' + '&aofc;&aofc;Nygren&pprqvy;&ngvyqr;b qr Ragenqnf Rkgreanf - RR'.dScr() + '<br /><span class="sub-header">Fun&ccedil;&atilde;o de Transa&ccedil;&atilde;o</span>';
        var title_se_inc = '<i class="' + 'sn sn-rkgreany-yvax'.dScr() + '"></i>' + '&aofc;&aofc;Vafre&pprqvy;&ngvyqr;b qr Fn&vnphgr;qnf Rkgreanf - FR'.dScr() + '<br /><span class="sub-header">Fun&ccedil;&atilde;o de Transa&ccedil;&atilde;o</span>';
        var title_se_alt = '<i class="' + 'sn sn-rkgreany-yvax'.dScr() + '"></i>' + '&aofc;&aofc;Nygren&pprqvy;&ngvyqr;b qr Fn&vnphgr;qnf Rkgreanf - FR'.dScr() + '<br /><span class="sub-header">Fun&ccedil;&atilde;o de Transa&ccedil;&atilde;o</span>';
        var title_ce_inc = '<i class="' + 'sn sn-qrfxgbc'.dScr() + '"></i>' + '&aofc;&aofc;Vafre&pprqvy;&ngvyqr;b qr Pbafhygnf Rkgreanf - PR'.dScr() + '<br /><span class="sub-header">Fun&ccedil;&atilde;o de Transa&ccedil;&atilde;o</span>';
        var title_ce_alt = '<i class="' + 'sn sn-qrfxgbc'.dScr() + '"></i>' + '&aofc;&aofc;Nygren&pprqvy;&ngvyqr;b qr Pbafhygnf Rkgreanf - PR'.dScr() + '<br /><span class="sub-header">Fun&ccedil;&atilde;o de Transa&ccedil;&atilde;o</span>';
        var title_ou_inc = '<i class="' + 'sn sn-fvgrznc'.dScr() + '"></i>' + '&aofc;&aofc;Vafre&pprqvy;&ngvyqr;b qr bhgenf shapvbanyvqnqrf'.dScr() + '<br /><span class="sub-header">Funcionalidades est&aacute;ticas, telas e outras</span>';
        var title_ou_alt = '<i class="' + 'sn sn-fvgrznc'.dScr() + '"></i>' + '&aofc;&aofc;Nygren&pprqvy;&ngvyqr;b qr bhgenf shapvbanyvqnqrf'.dScr() + '<br /><span class="sub-header">Funcionalidades est&aacute;ticas, telas e outras</span>';
        /*
         * variaveis que recebem valores do php devem ficar no documento e antes de qualquer script
         * not elegant but functional - :-( // jose claudio
         */
        var isFornecedor = <?= isFornecedor(); ?>; //DEFINE SE EH UM FORNECEDOR CONTANDO OU NAO
        var idFornecedor = '<?= getIdFornecedor(); ?>'; //ID DO FORNECEDOR DO USUARIO LOGADO        
        var tpoFornecedor = '<?= getTipoFornecedor(); ?>'; ///DEFINE O TIPO DE FORNECEDOR 0 - NORMAL, 1 - TURMAS DE TREINAMENTO
        var idEmpresa = '<?= getIdEmpresa(); ?>'; //ID DA EMPRESA DO USUARIO LOGADO
        var idCliente = '<?= getIdCliente(); ?>'; //ID DO CLIENTE CASO ESTEJA ATUANDO COMO FORNECEDOR
        var idClienteContagem = '<?= $idClienteContagem; ?>';//ID DO CLIENTE DA CONTAGEM SENDO EXECUTADA
        var padIdEmpresa = ("0000000000" + idEmpresa).slice(-10); //PADDING DO ID DA EMPRESA
        var idContagem = '<?= isset($_GET['id']) ? $_GET['id'] : 0; ?>'; //getIdContagem(); //DEIXA O ID DA CONTAGEM DISPONIVEL NA PAGINA
        var idContagemBaseline = '<?= isset($_GET['idb']) ? $_GET['idb'] : 0; ?>';
        var srcItems = []; //ITENS QUE SERAO UTILIZADOS NAS LISTAGENS DOS ARQUIVOS REFERENCIADOS
        var trItems = []; //ITENS QUE SERAO UTILIZADOS NAS LISTAGENS DOS TIPOS DE REGISTROS
        var srcItemsTR = []; //ITENS QUE SERAO UTILIZADOS NAS LISTAGENS DA DESCRICAO DOS TIPOS DE REGISTRO
        var dadosItems = []; //ITENS QUE SERAO UTILIZADOS NO AUTOCOMPLETE DAS FUNCOES DE DADOS
        var transacaoItems = []; //ITENS QUE SERAO UTILIZADOS NO AUTOCOMPLETE DAS FUNCOES DE TRANSACAO
        var funcoesItems = []; //ITENS QUE SERAO SELECIONADOS NA INSERCAO AUTOMATICA DE FUNCOES
        var contagemConfig = <?= json_encode($_SESSION['contagem_config']); ?>; //ARRAY COM AS CONFIGURACOES DAS CONTAGENS INDEPENDENTE SE EH CONTRATANTE OU FORNECEDOR
        /*
         * 
         * ira reatribuir as variaveis e juntar para a contagemConfig
         */
        var contagemConfigEmpresa = {};
        var contagemEstatisticas = <?= isset($_GET['id']) ? json_encode($_SESSION['contagem_estatisticas']) : json_encode(''); ?>;
        var empresaConfigPlano = <?= json_encode($_SESSION['empresa_config_plano']); ?>; //CONFIGURACAO DO PLANO DA EMPRESA
        var abrangencia = <?= json_encode($_SESSION['abrangencia']); ?>; //ARRAY CONTENDO AS ABRANGENCIAS DAS CONTAGENS
        var isAutorizadoAlterar = false;
        var isAutorizadoValidarInternamente = false;
        var isValidadaInternamente = false;
        var isAutorizadoRevisar = false;
        var abAtual = '<?= isset($_GET['ab']) ? $_GET['ab'] : 1; ?>';
        var ac = '<?= isset($_GET['ac']) ? $_GET['ac'] : 0; ?>';
        var id = '<?= isset($_GET['id']) ? $_GET['id'] : 0; ?>';
        var acForms; //variavel que armazena as operacoes nos formularios de dados/transacao/outros (al - ad)
        var emailLogado = '<?= getEmailUsuarioLogado(); ?>';
        var isValidarAdmGestor = '<?= isValidarAdmGestor(); ?>';
        var userId = '<?= getUserId(); ?>';
        var UserIdSha1 = '<?= getUserIdSha1(); ?>';
        var _41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265 = '<?= getUserName(); ?>';
        var userRole = '<?= getUserRole(); ?>';
        var avatarUser = '<?= getGravatarImageUser(getUserIdSha1()); ?>';
        var isProdutividadeGlobal = '<?= isProdutividadeGlobal(); ?>';
        var isAlterarProdutividadeGlobal = '<?= isAlterarProdutividadeGlobal(); ?>';
        var produtividadeGlobal = '<?= getProdutividade(); ?>';
        var produtividadeLinguagem;
        var maxLines = 2000; //variavel que conta as linhas nas tabelas api.js->calculaDistribuicaoEntregas();
        var isGlobal; //variavel que define se esta utilizado a produtividade global
        var isLinguagem; //variavel que define se esta utilizado a produtividade linguagem
        var lstIdProcesso; //id do processo
        var lstDataFim; //se true significa que ja foi finalizado
        var lstIdContagem; //na lista de contagens
        var lstIdCliente; //na lista de contagens
        var idAbrangencia; //na lista de contagens
        var isAtualizarPrivacidade = false; //so atualiza depois do click na tab finalizar
        var fAtual; //funcao atual ALI, AIE, EE, etc ... para os calculos de PFA no caso de Elementos Funcionais
        var activeTab; //na administracao para verificar se eh fornecedor ou turma
        var tCaptcha; //na administracao para verificar se eh fornecedor ou turma
        var arrFuncoes = {
            ali: 'Arquivos L&oacute;gicos Internos',
            aie: 'Arquivos de Interface Externa',
            ee: 'Entradas Externas',
            se: 'Sa&iacute;das Externas',
            ce: 'Consultas Externas',
            ou: 'Outras funcionalidades'
        };
        var isInst = <?= $isInstrutor ? 1 : 0; ?>;
        /*
         * @type Boolean variavel que armazena se o usuario ja existe ou nao email/usuario
         */
        var isEmailExistente = 0;
        var activationHash = '';
        var isActive = 0;
        var isIDExistente = 0;
        /*
         * array que insere e exclui os grupos para validacao das funcoes de dados/transacao/outros
         */
        var arrValidaALI = [];
        var arrValidaAIE = [];
        var arrValidaEE = [];
        var arrValidaSE = [];
        var arrValidaCE = [];
        var arrValidaOU = [];
        //snap
        var arrValidaSNAP = [];
        /*
         * tabelas com as tarefas pendentes/solicitante
         */
        var tblTarefas;
        var tblTarefasSolicitante;
        /*
         * variavel que guarda o id da linha da funcao
         */
        var idLinhaFuncao;
        /*
         * check security
         */
        var isSalvarContagem = <?= $bt[0][0] === '' ? 1 : 0; ?>; // inserir/atualizar informacoes
        var isSolicitarRevisao = <?= $bt[0][1] === '' ? 1 : 0; ?>; // solicitar revisao
        var isRelatorioApontes = <?= $bt[0][6] === '' ? 1 : 0; ?>; // observacoes (ver/inserir)
        var isFinalizarVInterna = <?= $bt[0][3][0] === '' ? 1 : 0; ?>; // validar interna
        var isFinalizarVExterna = <?= $bt[0][3][1] === '' ? 1 : 0; ?>; // validar externa
        var isFinalizarAInterna = <?= $bt[0][3][2] === '' ? 1 : 0; ?>; // auditar interna
        var isFinalizarAExterna = <?= $bt[0][3][3] === '' ? 1 : 0; ?>; // auditar externa
        var isFinalizarRevisao = <?= $bt[0][4] === '' ? 1 : 0; ?>; // finalizar revisao
        /*
         * btns no form perfil contagem
         */
        var btnFAI = true;
        var btnFAE = true;
        var btnAVI = true;
        var btnAVE = true;
        var btnAGP = true;
        var selFRN = true;
        var selTUR = true;
        var btnFIN = true;
        /*
         * formulario
         */
        var formulario = 'turma';
        /*
         * exibiu ou nao a descricao da baseline
         */
        var isB = false;
        /*
         * retorna o valor original do id_etapa
         */
        var idEtapa;
        /*
         * quantidade de entregas definida na contagem
         */
        var qtdEntregas = 1;
<?php
if (isset($_GET['id'])) {
    ?>
            var config_isEng = Number(contagemEstatisticas['is_f_eng']) == 1 ? true : false;
            var config_isDes = Number(contagemEstatisticas['is_f_des']) == 1 ? true : false;
            var config_isImp = Number(contagemEstatisticas['is_f_imp']) == 1 ? true : false;
            var config_isTes = Number(contagemEstatisticas['is_f_tes']) == 1 ? true : false;
            var config_isHom = Number(contagemEstatisticas['is_f_hom']) == 1 ? true : false;
            var config_isImpl = Number(contagemEstatisticas['is_f_impl']) == 1 ? true : false;
            //para os checks
            var isEng = Number(contagemEstatisticas['chk_eng']) == 1 ? true : false;
            var isDes = Number(contagemEstatisticas['chk_des']) == 1 ? true : false;
            var isImp = Number(contagemEstatisticas['chk_imp']) == 1 ? true : false;
            var isTes = Number(contagemEstatisticas['chk_tes']) == 1 ? true : false;
            var isHom = Number(contagemEstatisticas['chk_hom']) == 1 ? true : false;
            var isImpl = Number(contagemEstatisticas['chk_impl']) == 1 ? true : false;
            //percentuais
            var config_pctEng = parseFloat(contagemEstatisticas['pct_eng']).toFixed(3);
            var config_pctDes = parseFloat(contagemEstatisticas['pct_des']).toFixed(3);
            var config_pctImp = parseFloat(contagemEstatisticas['pct_imp']).toFixed(3);
            var config_pctTes = parseFloat(contagemEstatisticas['pct_tes']).toFixed(3);
            var config_pctHom = parseFloat(contagemEstatisticas['pct_hom']).toFixed(3);
            var config_pctImpl = parseFloat(contagemEstatisticas['pct_impl']).toFixed(3);
            var config_pctExclusao = 1.40; //TODO: colocar em contagem config para PF_RETRABALHO
            //calculos iniciais
            var config_hpc = parseFloat(contagemEstatisticas['hpc']).toFixed(3);
            var config_hpa = parseFloat(contagemEstatisticas['hpa']).toFixed(3);
            var config_aumentoEsforco = parseFloat(contagemEstatisticas['aumento_esforco']).toFixed(3);
            var config_fatorReducaoCronograma = parseFloat(contagemEstatisticas['fator_reducao_cronograma']).toFixed(3);
            var config_isSolicitacaoServicoCritica = contagemEstatisticas['is_solicitacao_servico_critica'] == 1 ? true : false;
            //produtividade global
            var config_produtividadeGlobal = parseFloat(contagemEstatisticas['produtividade_global']);
            var config_isProdutividadeGlobal = contagemEstatisticas['chk_produtividade_global'] == 1 ? true : false;
            //produtividade linguagem
            var config_isProdutividadeLinguagem = contagemEstatisticas['chk_produtividade_linguagem'] == 1 ? true : false;
            var lblProdutividadeLinguagem = contagemEstatisticas['escala_produtividade'];
            var config_produtividadeLinguagem = parseFloat(
                    config_isProdutividadeLinguagem ? contagemEstatisticas[lblProdutividadeLinguagem] : contagemEstatisticas['media']).toFixed(3);
            var contagemEstatisticasCocomo = <?= isset($_GET['id']) ? json_encode($_SESSION['contagem_estatisticas_cocomo']) : json_encode(''); ?>;
    <?php
} else {
    ?>
            var config_isEng = Number(contagemConfig['is_f_eng']) == 1 ? true : false;
            var config_isDes = Number(contagemConfig['is_f_des']) == 1 ? true : false;
            var config_isImp = Number(contagemConfig['is_f_imp']) == 1 ? true : false;
            var config_isTes = Number(contagemConfig['is_f_tes']) == 1 ? true : false;
            var config_isHom = Number(contagemConfig['is_f_hom']) == 1 ? true : false;
            var config_isImpl = Number(contagemConfig['is_f_impl']) == 1 ? true : false;
            //para os checks
            var isEng = Number(contagemConfig['is_f_eng']) == 1 ? true : false;
            var isDes = Number(contagemConfig['is_f_des']) == 1 ? true : false;
            var isImp = Number(contagemConfig['is_f_imp']) == 1 ? true : false;
            var isTes = Number(contagemConfig['is_f_tes']) == 1 ? true : false;
            var isHom = Number(contagemConfig['is_f_hom']) == 1 ? true : false;
            var isImpl = Number(contagemConfig['is_f_impl']) == 1 ? true : false;
            //percentuais
            var config_pctEng = parseFloat(contagemConfig['pct_f_eng']).toFixed(3);
            var config_pctDes = parseFloat(contagemConfig['pct_f_des']).toFixed(3);
            var config_pctImp = parseFloat(contagemConfig['pct_f_imp']).toFixed(3);
            var config_pctTes = parseFloat(contagemConfig['pct_f_tes']).toFixed(3);
            var config_pctHom = parseFloat(contagemConfig['pct_f_hom']).toFixed(3);
            var config_pctImpl = parseFloat(contagemConfig['pct_f_impl']).toFixed(3);
            var config_pctExclusao = 1.40; //TODO: colocar em contagem config para PF_RETRABALHO
            //calculos iniciais
            var config_hpc = parseFloat(0).toFixed(3);
            var config_hpa = parseFloat(0).toFixed(3);
            var config_aumentoEsforco = parseFloat(1).toFixed(3);
            var config_fatorReducaoCronograma = parseFloat(1).toFixed(3);
            var config_isSolicitacaoServicoCritica = false;
            //produtividade global
            var config_produtividadeGlobal = parseFloat(contagemConfig['produtividade_global']);
            var config_isProdutividadeGlobal = contagemConfig['chk_produtividade_global'] == 1 ? true : false;
            //produtividade linguagem
            var config_produtividadeLinguagem;
            var config_isProdutividadeLinguagem = false;
            var contagemEstatisticasCocomo = <?= json_encode($_SESSION['contagem_config_cocomo']); ?>; //CONFIGURACAO ORIGINAL DO COCOMO

    <?php
}
?>
        /*
         * variaveis dos graficos
         */
        var dataVariacao;
        var dataComplexidade;
        var lineChartVariacao;
        var ctxGraficoVariacao;
        var ctxGraficoComplexidade;
        var barChartComplexidade;
        var div;
        var hn;
        var h;
        /*
         * variaveis globais para os graficos na tab estatisticas
         */
        var chartOptions = [{
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                scaleShowHorizontalLines: true,
                scaleShowVerticalLines: true,
                bezierCurve: true,
                bezierCurveTension: 0.4,
                pointDot: true,
                pointDotRadius: 4,
                pointDotStrokeWidth: 1,
                pointHitDetectionRadius: 20,
                datasetStroke: true,
                datasetStrokeWidth: 1,
                datasetFill: true,
                responsive: true
            }];
        /*
         * tabela ALI, AIE, etc ... para contar as complexidades
         */
        var tblTemp;
        /*
         * salvamento automatico ou nao das estatisticas
         */
        var isSalvarEstatisticas = false;
        /*
         * try to prevent backspace
         */
        document.onkeydown = function (event) {
            if (!event) { /* This will happen in IE */
                event = window.event;
            }
            var keyCode = event.keyCode || event.which;
            if (keyCode == 8 &&
                    ((event.target || event.srcElement).tagName != "TEXTAREA") &&
                    ((event.target || event.srcElement).tagName != "INPUT")) {
                if (navigator.userAgent.toLowerCase().indexOf("msie") == -1) {
                    event.stopPropagation();
                } else {
                    //alert("prevented");
                    event.returnValue = false;
                }
                return false;
            }
        };
    </script>
    <!--
    <script type='text/javascript'>
        (function () {
            var widget_id = 'aa8UDcAoxx';
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = '//code.jivosite.com/script/widget/' + widget_id;
            var ss = document.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss);
        })();
    </script>-->
</head>