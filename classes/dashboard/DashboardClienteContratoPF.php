<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

require_once DIR_CLASS . 'CRUD.php';

class DashboardClienteContratoPF extends CRUD {

    public function insere() {
        
    }

    public function getSituacao($idEmpresa) {
        $stm = DB::prepare("
            SELECT
                cli.sigla AS sigla, 
                cli.descricao AS descricao, 
                cnt.ano AS ano, 
                cnt.numero AS numero, 
                cnt.pf_contratado AS pf_contratado, 
                SUM(ces.tamanho_pfa) AS qtd
            FROM
                contagem_estatisticas ces,
                contrato cnt,
                contagem con,
                empresa emp,
                cliente cli
            WHERE
                ces.id_contagem = con.id AND
                con.id_contrato = cnt.id AND
                con.id_empresa = emp.id AND
                con.id_cliente = cli.id AND
                cli.id_empresa = emp.id AND
                con.id_fornecedor NOT IN (SELECT id FROM fornecedor WHERE tipo IN (1, 2)) AND 
                emp.id = $idEmpresa
            GROUP BY
                sigla, descricao, ano, numero");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSituacaoFornecedor($idEmpresa, $idFornecedor) {
        $stm = DB::prepare("
            SELECT
                cli.sigla AS sigla, 
                cli.descricao AS descricao, 
                cnt.ano AS ano, 
                cnt.numero AS numero, 
                cnt.pf_contratado AS pf_contratado, 
                SUM(ces.tamanho_pfa) AS qtd
            FROM
                contagem_estatisticas ces,
                contrato cnt,
                contagem con,
                empresa emp,
                cliente cli
            WHERE
                ces.id_contagem = con.id AND
                con.id_contrato = cnt.id AND
                con.id_empresa = emp.id AND
                con.id_cliente = cli.id AND
                cli.id_empresa = emp.id AND
                emp.id = $idEmpresa AND
                con.id_fornecedor = $idFornecedor
            GROUP BY
                sigla, descricao, ano, numero");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }    

}
