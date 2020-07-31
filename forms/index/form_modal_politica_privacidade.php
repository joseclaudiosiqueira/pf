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
<div id="form_modal_politica_privacidade" class="modal fade" role="dialog">
    <div class="modal-dialog modal-">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-user-secret"></i>&nbsp;&nbsp;Pol&iacute;tica de Privacidade<br />
                <span class="sub-header">Saiba mais sobre o Dimension</span>
            </div>
            <div class="modal-body">
                <div style="
                     max-height: 450px; 
                     min-height: 450px; 
                     width: 100%; 
                     overflow-x: hidden; 
                     overflow-y: auto;
                     font-family: 'Courier New', sans-serif;
                     font-size: 18px;                     
                     " class="scroll">
                    <h2>Política de privacidade para <a href='//pfdimension.com.br' class="txt3">Dimension&reg;</a></h2>
                    <div style="padding-left: 32px; padding-right: 32px; text-align: justify;">
                        Todas as suas informações pessoais recolhidas, serão usadas para nos ajudar a tornar 
                        a sua visita ao nosso sistema a mais produtiva e agradável possível. A garantia da confidencialidade dos dados pessoais 
                        dos utilizadores do nosso sistema 
                        é ponto fundamental para o Dimension&reg;. Todas as informações pessoais relativas a membros, assinantes, clientes ou visitantes 
                        que usem o Dimension serão tratadas em concordância com a Lei da Proteção de Dados Pessoais 
                        de 26 de outubro de 1998 (Lei n.º 67/98).
                        Não divulgaremos, no site ou em qualquer outro meio, quem são nossos Clientes usuários do Sistema, a não ser que previamente autorizado.
                        A informação pessoal recolhida pode incluir o seu nome, e-mail, número de telefone e/ou telemóvel,
                        morada, data de nascimento e/ou outros. O uso do Dimension pressupõe a aceitação 
                        deste Acordo de privacidade. A equipe do Dimension reserva-se ao direito de alterar 
                        este acordo sem aviso prévio. Deste modo, recomendamos que consulte a nossa política 
                        de privacidade com regularidade de forma a estar sempre atualizado.</div>
                    <h2>Os anúncios</h2>
                    <div style="padding-left: 32px; padding-right: 32px; text-align: justify;">
                        Diferente de outros websites, não coletamos nem utilizamos informação 
                        contida em anúncios. A informação que coletamos inclui o seu endereço IP 
                        (Internet Protocol), o seu ISP (Internet Service Provider), o browser que utilizou ao visitar o nosso 
                        website (como o Internet Explorer ou o Firefox), 
                        o tempo da sua visita e que páginas visitou dentro do nosso sistema, para efeitos de logs e auditorias, apenas. 
                        Não exibimos anúncios de terceiros no nosso site.</div>
                    <h2>Os Cookies e Web Beacons</h2>
                    <div style="padding-left: 32px; padding-right: 32px; text-align: justify;">
                        Utilizamos cookies para armazenar informação, tais como as suas preferências 
                        pessoas quando visita o nosso website. Isto poderá incluir um simples popup, ou uma ligação em vários 
                        serviços que providenciamos, tais como fóruns. Você detém o poder de desligar os seus cookies 
                        (não recomendamos esta ação para utilização do Dimension&reg;), 
                        nas opções do seu browser, ou efetuando alterações nas ferramentas de programas Anti-Virus, 
                        como o Norton Internet Security. No entanto, isso poderá alterar a forma como interage com o nosso website, 
                        ou outros websites. Isso poderá afetar ou não permitir que faça logins em programas, sites ou fóruns da nossa e 
                        de outras redes.</div>
                    <h2>Ligações a Sites de terceiros</h2>
                    <div style="padding-left: 32px; padding-right: 32px; text-align: justify;">
                        O Dimension&reg; possui ligações para outros sites, 
                        os quais, ao nosso ver, podem conter informações / ferramentas úteis para os nossos visitantes. 
                        A nossa política de privacidade não é aplicada a sites de terceiros, pelo que, caso visite outro site a 
                        partir do nosso deverá ler a politica de privacidade do mesmo.
                        Não nos responsabilizamos pela política de privacidade ou conteúdo presente nesses mesmos sites.</div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
