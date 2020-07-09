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
require_once DIR_CLASS . 'CRUD.php';

class Faturamento extends CRUD {

    private $idEmpresa;
    private $dataGeracao;
    private $quantidadeContagens;
    private $valorFaturamento;
    private $mesAno;
    private $status;
    private $isFaturavel;
    private $tipoFaturamento;
    private $indicadoPor;

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setDataGeracao($dataGeracao) {
        $this->dataGeracao = $dataGeracao;
    }

    function setQuantidadeContagens($quantidadeContagens) {
        $this->quantidadeContagens = $quantidadeContagens;
    }

    function setValorFaturamento($valorFaturamento) {
        $this->valorFaturamento = $valorFaturamento;
    }

    function setMesAno($mesAno) {
        $this->mesAno = $mesAno;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setIsFaturavel($isFaturavel) {
        $this->isFaturavel = $isFaturavel;
    }

    function setTipoFaturamento($tipoFaturamento) {
        $this->tipoFaturamento = $tipoFaturamento;
    }

    function setIndicadoPor($indicadoPor) {
        $this->indicadoPor = $indicadoPor;
    }

    public function insere() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_empresa,"
                        . "data_geracao,"
                        . "quantidade_contagens,"
                        . "valor_faturamento,"
                        . "mes_ano,"
                        . "status,"
                        . "is_faturavel,"
                        . "tipo_faturamento,"
                        . "indicado_por"
                        . ") VALUES ("
                        . ":idEmpresa,"
                        . ":dataGeracao,"
                        . ":quantidadeContagens,"
                        . ":valorFaturamento,"
                        . ":mesAno,"
                        . ":status,"
                        . ":isFaturavel,"
                        . ":tipoFaturamento,"
                        . ":indicadoPor"
                        . ")");
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':dataGeracao', $this->dataGeracao, PDO::PARAM_STR);
        $stm->bindParam(':quantidadeContagens', $this->quantidadeContagens, PDO::PARAM_INT);
        $stm->bindParam(':valorFaturamento', $this->valorFaturamento);
        $stm->bindParam(':mesAno', $this->mesAno, PDO::PARAM_STR);
        $stm->bindParam(':status', $this->status, PDO::PARAM_INT);
        $stm->bindParam(':isFaturavel', $this->isFaturavel, PDO::PARAM_INT);
        $stm->bindParam(':tipoFaturamento', $this->tipoFaturamento, PDO::PARAM_INT);
        $stm->bindParam(':indicadoPor', $this->indicadoPor, PDO::PARAM_INT);
        $stm->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        
    }

    public function getValorFaturamento($idEmpresa, $dataInicio = NULL, $dataFim = NULL) {
        //datas de 01 do mes atual a 01 do mes seguinte
        $dtFim = NULL !== $dataFim ? $dataFim : date('Y-m-01');
        $dtIni = NULL !== $dataInicio ? $dataInicio : date('Y-m-01', strtotime("-1 month", strtotime($dtFim)));
        //este select retorna apenas o valor a ser pago no mes
        $sql = "
            SELECT 
                COUNT(c.id) AS qtd_contagem, IF(COUNT(c.id) = 0, ecp.mensalidade, COUNT(c.id) * ecp.valor_contagem) AS valor_faturamento
            FROM 
                contagem c, empresa_config_plano ecp 
            WHERE
                c.data_cadastro BETWEEN '$dtIni' AND '$dtFim' AND 
                c.id_empresa = :idEmpresa AND
                c.id_empresa = ecp.id_empresa";
        $stm = DB::prepare($sql);
        $stm->bindParam(":idEmpresa", $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContagens($idEmpresa, $dataInicio = NULL, $dataFim = NULL) {
        //datas de 01 do mes atual a 01 do mes seguinte
        $dtFim = NULL !== $dataFim ? $dataFim : date('Y-m-01');
        $dtIni = NULL !== $dataInicio ? $dataInicio : date('Y-m-01', strtotime("-1 month", strtotime($dtFim)));
        //este select retorna apenas o valor a ser pago no mes
        $sql = "
            SELECT 
                c.id, 
                c.data_cadastro, 
                c.responsavel, 
                cli.sigla, 
                cli.descricao AS CLI_descricao,
                con.numero,
                con.ano,
                prj.descricao AS PRJ_descricao,
                ab.descricao AS AB_descricao,
                ab.tipo
            FROM 
                contagem c,
                cliente cli,
                contrato con,
                projeto prj,
                contagem_abrangencia ab
            WHERE
                c.id_cliente = cli.id AND 
                c.id_projeto = prj.id AND 
                c.id_contrato = con.id AND
                c.id_abrangencia = ab.id AND
                c.data_cadastro BETWEEN '$dtIni' AND '$dtFim' AND 
                c.id_empresa = :idEmpresa";
        $stm = DB::prepare($sql);
        $stm->bindParam(":idEmpresa", $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReferencia($idFaturamento) {
        $stm = DB::prepare("SELECT mes_ano FROM $this->table WHERE id = :idFaturamento");
        $stm->bindParam(':idFaturamento', $idFaturamento, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['mes_ano'];
    }

    public function getListaFaturamento($idEmpresa) {
        $stm = DB::prepare("SELECT f.*, e.cep, e.logradouro, e.bairro, e.cidade, e.uf, e.email FROM $this->table f, empresa e WHERE f.id_empresa = e.id AND f.id_empresa = :idEmpresa ORDER BY f.id DESC");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
