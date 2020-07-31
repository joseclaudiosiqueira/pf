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
<div style="position:fixed;left:10px;bottom:10px">
    <!--- DO NOT EDIT - GlobalSign SSL Site Seal Code - DO NOT EDIT
    <table width=125 border=0 cellspacing=0 cellpadding=0 title="CLICK TO VERIFY: This site uses a GlobalSign SSL Certificate to secure your personal information." >
        <tr>
            <td>
                <span id="ss_img_wrapper_gmogs_image_90-35_en_blue">
                    <a href="https://www.globalsign.com/" target=_blank title="GlobalSign Site Seal" rel="nofollow">
                        <img alt="SSL" border=0 id="ss_img" src="//seal.globalsign.com/SiteSeal/images/gs_noscript_90-35_en.gif">
                    </a>
                </span>
                <script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_90-35_en_blue.js"></script>
            </td>
        </tr>
    </table>
    <!--- DO NOT EDIT - GlobalSign SSL Site Seal Code - DO NOT EDIT --->
</div>


