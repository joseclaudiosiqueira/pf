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
include_once $_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php';
include_once DIR_BASE . 'vendor/tcpdf/tcpdf.php';

class Pdf extends TCPDF {

    private $isLogomarcaEmpresa;
    private $isLogomarcaCliente;
    private $logomarca;
    private $logomarcaCliente;
    private $dirLogomarca;
    private $dirLogomarcaCliente;
    //cabecalho e rodape
    private $cabLinha1;
    private $cabLinha2;
    private $cabLinha3;
    private $rodLinha1;
    private $cabAlinhamento;
    //background caso a contagem esteja em validacao
    private $isValidadaInternamente;
    //background para os planos
    private $backgroundPlano;
    //imagem do background
    private $imgFile;
    //com ou sem background
    private $isBackground = true;

    function setIsBackground($isBackground) {
        $this->isBackground = $isBackground;
    }

    function setIsLogomarcaEmpresa($isLogomarcaEmpresa) {
        $this->isLogomarcaEmpresa = $isLogomarcaEmpresa;
    }

    function setIsLogomarcaCliente($isLogomarcaCliente) {
        $this->isLogomarcaCliente = $isLogomarcaCliente;
    }

    /**
     * 
     * @param string $logomarca logomarca Empresa ou Fornecedor
     */
    function setLogomarca($logomarca) {
        $this->logomarca = $logomarca;
    }

    function setLogomarcaCliente($logomarcaCliente) {
        $this->logomarcaCliente = $logomarcaCliente;
    }

    /**
     * 
     * @param string $dirLogomarca logomarca Empresa ou Fornecedor
     */
    function setDirLogomarca($dirLogomarca) {
        $this->dirLogomarca = $dirLogomarca;
    }

    function setDirLogomarcaCliente($dirLogomarcaCliente) {
        $this->dirLogomarcaCliente = $dirLogomarcaCliente;
    }

    function setCabLinha1($cabLinha1) {
        $this->cabLinha1 = $cabLinha1;
    }

    function setCabLinha2($cabLinha2) {
        $this->cabLinha2 = $cabLinha2;
    }

    function setCabLinha3($cabLinha3) {
        $this->cabLinha3 = $cabLinha3;
    }

    function setRodLinha1($rodLinha1) {
        $this->rodLinha1 = $rodLinha1;
    }

    function setCabAlinhamento($cabAlinhamento) {
        $this->cabAlinhamento = $cabAlinhamento;
    }

    function setIsValidadaInternamente($isValidadaInternamente) {
        $this->isValidadaInternamente = $isValidadaInternamente;
    }

    function getIsValidadaInternamente() {
        return $this->isValidadaInternamente;
    }

    function getBackgroundPlano() {
        return $this->backgroundPlano;
    }

    function setBackgroundPlano($backgroundPlano) {
        $this->backgroundPlano = $backgroundPlano;
    }

    function getImgFile() {
        return $this->imgFile;
    }

    function setImgFile($imgFile) {
        $this->imgFile = $imgFile;
    }

    public function setBackground() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $this->setImgfile(DIR_BASE . $this->backgroundPlano);
        //aqui?
        $this->Image($this->imgFile, 0, 0, 0, 0, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
        return true;
    }

    //overriding two methods
    //Page header
    public function Header() {
        //para nao validadas
        $this->isBackground ? $this->setBackground($this->imgFile) : NULL;
        //escreve o restante do header        
        $this->SetFont('courier', 'B', 10, '', true);
        $html = '<table width="100%">';
        $html .= '<tr><td align="' . $this->cabAlinhamento . '">' . $this->cabLinha1 . '</td></tr>';
        $html .= '<tr><td align="' . $this->cabAlinhamento . '">' . $this->cabLinha2 . '</td></tr>';
        $html .= '<tr><td align="' . $this->cabAlinhamento . '">' . $this->cabLinha3 . '</td></tr>';
        $html .= '</table>';

        //escreve a tabela com o cabecalho
        //writeHTMLCell(
        //$w, 
        //$h, 
        //$x, 
        //$y, 
        //$html='', 
        //$border=0, 
        //$ln=0, 
        //$fill=false, 
        //$reseth=true, 
        //$align='', 
        //$autopadding=true)
        $this->writeHTMLCell(($this->getPageWidth() - 56), 0, 35, 10, $html, 0, 1, 0, true, '', true);
        // Logomarca empresa e cliente
        //Image(
        //  $file, 
        //  $x='', 
        //  $y='', 
        //  $w=0, 
        //  $h=0, 
        //  $type='', 
        //  $link='', 
        //  $align='', 
        //  $resize=false, 
        //  $dpi=300, 
        //  $palign='', 
        //  $ismask=false, 
        //  $imgmask=false, 
        //  $border=0, 
        //  $fitbox=false, 
        //  $hidden=false, 
        //  $fitonpage=false, 
        //  $alt=false, 
        //  $altimgs=array())
        $this->isLogomarcaCliente ?
                        $this->Image($this->dirLogomarcaCliente . $this->logomarcaCliente, 9, 5, 21, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false) :
                        null;
        $this->isLogomarcaEmpresa ?
                        $this->Image($this->dirLogomarca . $this->logomarca, ($this->getPageWidth() - 31), 5, 21, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false) :
                        null;
    }

    // Page footer
    public function Footer() {
        $email = getEmailUsuarioLogado();
        $linha = $this->rodLinha1 ? $this->rodLinha1 . ' - ' : '';
        $linha .= 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages();
        $linha .= ' - Emitido em ' . date('d/m/Y H:i:s');
        $linha .= ' - Por: ' . $email;
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('courier', '', 7);
        //na pagina um nao tem
        $this->Cell($this->getPageWidth(), 0, $linha, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}
