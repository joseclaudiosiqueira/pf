<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * nao exibe caso esteja comparando
 */
if (!(isset($_GET['cp']))) {
    //pagina de cabecalho do cocomo e resumo das variaveis
    !isset($_GET['p']) ? $pdf->addPage('P') : NULL;
    $html = '<table width="100%" border="0" cellpadding="5">
            <tr bgcolor="#d0d0d0"><td colspan="6" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Vari&aacute;veis utilizadas no Modelo COCOMO II.2000</strong></td></tr>
            <tr bgcolor="#f0f0f0">
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%">PFb</td>
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%">SLOCc</td>
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%">A</td>
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%">B</td>
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%">C</td>
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%">D</td>
            </tr>
            <tr>
                <td>' . number_format(array_sum($statsPFB), 2, ",", ".") . '</td>
                <td>' . number_format($estatisticas['sloc'], 2, ",", "") . '</td>
                <td>' . $estatisticas['COCOMO_A'] . '</td>
                <td>' . $estatisticas['COCOMO_B'] . '</td>
                <td>' . $estatisticas['COCOMO_C'] . '</td>
                <td>' . $estatisticas['COCOMO_D'] . '</td>
            </tr>    
            <tr bgcolor="#f0f0f0">
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%">Esfor&ccedil;o</td>
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%">Cronograma</td>
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%">Custo/Pessoa</td>
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%">M&eacute;todo</td>
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%"></td>
                <td style="border-bottom: 1px solid #d0d0d0;" width="16.6%"></td>                
            </tr>
            <tr>
                <td>' . number_format($estatisticas['esforco'], 2, ",", ".") . '</td>
                <td>' . number_format($estatisticas['cronograma'], 2, ",", "") . '</td>
                <td>' . number_format($estatisticas['custo_pessoa'], 2, ",", "") . '</td>
                <td>' . ($estatisticas['tipo_calculo'] ? 'P&oacute;s Arquitetura' : 'Projeto Inicial') . '</td>
                <td></td>
                <td></td>
            </tr>             
        </table>';
    $html .= '  <div width="100%" style="height:15px;">&nbsp;</div>';
    /*
     * verifica o tipo de calculo associado a contagem ... 'early design' ou 'pos arquitetura'
     */
    $html .= $estatisticas['tipo_calculo'] ? ''
            . '<table width="100%" border="0" cellpadding="5">
                <tr bgcolor="#d0d0d0"><td colspan="8" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>P&oacute;s Arquitetura (<i>Post Architecture</i>)</strong></td></tr>
                <tr bgcolor="#f0f0f0">
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['PREC'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['FLEX'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['RESL'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['TEAM'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['PMAT'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['RELY'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['DATA'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['CPLX'] . '</td>
                </tr>
                <tr>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['PREC'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['FLEX'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['RESL'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['TEAM'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['PMAT'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['RELY'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['DATA'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['CPLX'])], 2, ',', '.') . '</td>
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['RUSE'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['DOCU'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['TIME'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['STOR'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['PVOL'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['ACAP'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['PCAP'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['PCON'] . '</td>
                </tr>
                <tr>
                    
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['RUSE'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['DOCU'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['TIME'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['STOR'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['PVOL'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['ACAP'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['PCAP'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['PCON'])], 2, ',', '.') . '</td>
                </tr> 
                <tr bgcolor="#f0f0f0">
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['APEX'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['PLEX'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['LTEX'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['TOOL'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['SITE'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">' . $estatisticas['SCED'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">-</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="12.5%">-</td>
                </tr>
                <tr>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['APEX'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['PLEX'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['LTEX'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['TOOL'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['SITE'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['SCED'])], 2, ',', '.') . '</td>
                    <td>-</td>
                    <td>-</td>
                </tr>                  
           </table>' :
            //early design
            '<table width="100%" border="0" cellpadding="5">
                <tr bgcolor="#d0d0d0"><td colspan="7" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Projeto Inicial (<i>Early-Design</i>)</strong></td></tr>
                <tr bgcolor="#f0f0f0">
                    <td style="border-bottom: 1px solid #d0d0d0;" width="14.285%">' . $estatisticas['ED_PERS'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="14.285%">' . $estatisticas['ED_RCPX'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="14.285%">' . $estatisticas['ED_PDIF'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="14.285%">' . $estatisticas['ED_PREX'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="14.285%">' . $estatisticas['ED_FCIL'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="14.285%">' . $estatisticas['ED_RUSE'] . '</td>
                    <td style="border-bottom: 1px solid #d0d0d0;" width="14.285%">' . $estatisticas['ED_SCED'] . '</td>
                </tr>
                <tr>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['ED_PERS'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['ED_RCPX'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['ED_PDIF'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['ED_PREX'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['ED_FCIL'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['ED_RUSE'])], 2, ',', '.') . '</td>
                    <td>' . number_format($estatisticas[str_replace('-', '_', $estatisticas['ED_SCED'])], 2, ',', '.') . '</td>
                </tr>                
           </table>';
    //escreve a tabela
    !isset($_GET['p']) ? $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true) : print $html;
    //pagina de sumario do cocomo
    !isset($_GET['p']) ? $pdf->addPage('L') : NULL;
    $tc = calculaCocomo($estatisticas);
    //escreve as tabelas
    $html = '   <table width="100%" border="0" cellpadding="5">
                <tr>
                    <td width="50%">
                        <table width="100%" cellpadding="5">
                            <tr bgcolor="#d0d0d0"><td colspan="5" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong><i>Rational Unified Proccess - RUP</i></strong></td></tr>
                            <tr bgcolor="#f0f0f0">
                                <td style="border-bottom: 1px solid #d0d0d0;" width="28%">Fase</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Esfor&ccedil;o</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Cronograma</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">M&eacute;dia</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Custo (R$)</td>
                            </tr>                                
                            <tr>
                                <td>Concep&ccedil;&atilde;o</td>
                                <td><span id="rup-inc-ef">' . number_format($tc['rup_inc_ef'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-inc-sc">' . number_format($tc['rup_inc_sc'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-inc-av">' . number_format($tc['rup_inc_av'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-inc-co">' . number_format($tc['rup_inc_co'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Elabora&ccedil;&atilde;o</td>
                                <td><span id="rup-ela-ef">' . number_format($tc['rup_ela_ef'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-ela-sc">' . number_format($tc['rup_ela_sc'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-ela-av">' . number_format($tc['rup_ela_av'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-ela-co">' . number_format($tc['rup_ela_co'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Constru&ccedil;&atilde;o</td>
                                <td><span id="rup-con-ef">' . number_format($tc['rup_con_ef'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-con-sc">' . number_format($tc['rup_con_sc'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-con-av">' . number_format($tc['rup_con_av'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-con-co">' . number_format($tc['rup_con_co'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Transi&ccedil;&atilde;o</td>
                                <td><span id="rup-tra-ef">' . number_format($tc['rup_tra_ef'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-tra-sc">' . number_format($tc['rup_tra_sc'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-tra-av">' . number_format($tc['rup_tra_av'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-tra-co">' . number_format($tc['rup_tra_co'], 2, ',', '.') . '</span></td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%">
                        <table width="100%" border="0" cellpadding="5">
                        <tr bgcolor="#d0d0d0"><td colspan="5" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong><i>COCOMO II.2000</i></strong></td></tr>
                            <tr bgcolor="#f0f0f0">
                                <td style="border-bottom: 1px solid #d0d0d0;" width="28%">Fase</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Esfor&ccedil;o</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Cronograma</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">M&eacute;dia</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Custo (R$)</td>
                            </tr>                                
                            <tr>
                                <td>Concep&ccedil;&atilde;o</td>
                                <td><span id="coc-inc-ef">' . number_format($tc['coc_inc_ef'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-inc-sc">' . number_format($tc['coc_inc_sc'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-inc-av">' . number_format($tc['coc_inc_av'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-inc-co">' . number_format($tc['coc_inc_co'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Elabora&ccedil;&atilde;o</td>
                                <td><span id="coc-ela-ef">' . number_format($tc['coc_ela_ef'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-ela-sc">' . number_format($tc['coc_ela_sc'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-ela-av">' . number_format($tc['coc_ela_av'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-ela-co">' . number_format($tc['coc_ela_co'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Constru&ccedil;&atilde;o</td>
                                <td><span id="coc-con-ef">' . number_format($tc['coc_con_ef'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-con-sc">' . number_format($tc['coc_con_sc'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-con-av">' . number_format($tc['coc_con_av'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-con-co">' . number_format($tc['coc_con_co'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Transi&ccedil;&atilde;o</td>
                                <td><span id="coc-tra-ef">' . number_format($tc['coc_tra_ef'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-tra-sc">' . number_format($tc['coc_tra_sc'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-tra-av">' . number_format($tc['coc_tra_av'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-tra-co">' . number_format($tc['coc_tra_co'], 2, ',', '.') . '</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>';
    //encerra a tabela
    $html .= '  <div width="100%" style="height:15px;">&nbsp;</div>';
    //nova tabela com as fases/atividades
    $html .= '   <table width="100%" border="0" cellpadding="5">
                <tr>
                    <td width="50%">
                        <table width="100%" border="0" cellpadding="5">
                            <tr bgcolor="#d0d0d0"><td colspan="5" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Distribui&ccedil;&atilde;o nas atividades do processo</strong></td></tr>
                            <tr bgcolor="#f0f0f0">
                                <td style="border-bottom: 1px solid #d0d0d0;" width="28%">Fase/Atividade</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Concep&ccedil;&atilde;o</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Elabora&ccedil;&atilde;o</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Constru&ccedil;&atilde;o</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Transi&ccedil;&atilde;o</td>
                            </tr>
                            <tr>
                                <td>Gerenciamento</td>
                                <td><span id="rup-man-inc">' . number_format($tc['rup_man_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-man-ela">' . number_format($tc['rup_man_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-man-con">' . number_format($tc['rup_man_con'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-man-tra">' . number_format($tc['rup_man_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Ambiente/ Configura&ccedil;&atilde;o</td>
                                <td><span id="rup-env-inc">' . number_format($tc['rup_env_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-env-ela">' . number_format($tc['rup_env_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-env-con">' . number_format($tc['rup_env_con'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-env-tra">' . number_format($tc['rup_env_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Requisitos</td>
                                <td><span id="rup-req-inc">' . number_format($tc['rup_req_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-req-ela">' . number_format($tc['rup_req_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-req-con">' . number_format($tc['rup_req_con'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-req-tra">' . number_format($tc['rup_req_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Design (projeto)</td>
                                <td><span id="rup-des-inc">' . number_format($tc['rup_des_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-des-ela">' . number_format($tc['rup_des_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-des-con">' . number_format($tc['rup_des_con'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-des-tra">' . number_format($tc['rup_des_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Implementa&ccedil;&atilde;o</td>
                                <td><span id="rup-imp-inc">' . number_format($tc['rup_imp_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-imp-ela">' . number_format($tc['rup_imp_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-imp-con">' . number_format($tc['rup_imp_con'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-imp-tra">' . number_format($tc['rup_imp_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr><td>Avalia&ccedil;&atilde;o / Testes</td>
                                <td><span id="rup-ass-inc">' . number_format($tc['rup_ass_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-ass-ela">' . number_format($tc['rup_ass_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-ass-con">' . number_format($tc['rup_ass_con'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-ass-tra">' . number_format($tc['rup_ass_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr><td>Implanta&ccedil;&atilde;o</td>
                                <td><span id="rup-dep-inc">' . number_format($tc['rup_dep_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-dep-ela">' . number_format($tc['rup_dep_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-dep-con">' . number_format($tc['rup_dep_con'], 2, ',', '.') . '</span></td>
                                <td><span id="rup-dep-tra">' . number_format($tc['rup_dep_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                        </table> 
                    </td>
                    <td width="50%">
                        <table width="100%" border="0" cellpadding="5">
                            <tr bgcolor="#d0d0d0"><td colspan="5" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Distribui&ccedil;&atilde;o nas atividades do processo</strong></td></tr>
                            <tr bgcolor="#f0f0f0">
                                <td style="border-bottom: 1px solid #d0d0d0;" width="28%">Fase/Atividade</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Concep&ccedil;&atilde;o</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Elabora&ccedil;&atilde;o</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Constru&ccedil;&atilde;o</td>
                                <td style="border-bottom: 1px solid #d0d0d0;" width="18%">Transi&ccedil;&atilde;o</td>
                            </tr>
                            <tr>
                                <td>Gerenciamento</td>
                                <td><span id="coc-man-inc">' . number_format($tc['coc_man_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-man-ela">' . number_format($tc['coc_man_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-man-con">' . number_format($tc['coc_man_con'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-man-tra">' . number_format($tc['coc_man_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Ambiente/ Configura&ccedil;&atilde;o</td>
                                <td><span id="coc-env-inc">' . number_format($tc['coc_env_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-env-ela">' . number_format($tc['coc_env_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-env-con">' . number_format($tc['coc_env_con'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-env-tra">' . number_format($tc['coc_env_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Requisitos</td>
                                <td><span id="coc-req-inc">' . number_format($tc['coc_req_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-req-ela">' . number_format($tc['coc_req_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-req-con">' . number_format($tc['coc_req_con'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-req-tra">' . number_format($tc['coc_req_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Design (projeto)</td>
                                <td><span id="coc-des-inc">' . number_format($tc['coc_des_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-des-ela">' . number_format($tc['coc_des_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-des-con">' . number_format($tc['coc_des_con'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-des-tra">' . number_format($tc['coc_des_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr>
                                <td>Implementa&ccedil;&atilde;o</td>
                                <td><span id="coc-imp-inc">' . number_format($tc['coc_imp_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-imp-ela">' . number_format($tc['coc_imp_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-imp-con">' . number_format($tc['coc_imp_con'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-imp-tra">' . number_format($tc['coc_imp_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr><td>Avalia&ccedil;&atilde;o / Testes</td>
                                <td><span id="coc-ass-inc">' . number_format($tc['coc_ass_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-ass-ela">' . number_format($tc['coc_ass_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-ass-con">' . number_format($tc['coc_ass_con'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-ass-tra">' . number_format($tc['coc_ass_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                            <tr><td>Implanta&ccedil;&atilde;o</td>
                                <td><span id="coc-dep-inc">' . number_format($tc['coc_dep_inc'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-dep-ela">' . number_format($tc['coc_dep_ela'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-dep-con">' . number_format($tc['coc_dep_con'], 2, ',', '.') . '</span></td>
                                <td><span id="coc-dep-tra">' . number_format($tc['coc_dep_tra'], 2, ',', '.') . '</span></td>
                            </tr>
                        </table>      
                    </td>
                </tr>
            </table>';
    //encerra a tabela
    !isset($_GET['p']) ? $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true) : print $html;
}