<?php
/*
 * insere o conf
 */
require_once $_SERVER ['DOCUMENT_ROOT'] . (substr ( $_SERVER ['DOCUMENT_ROOT'], - 1 ) === '/' ? '' : '/') . 'pf/conf/conf.php';
/*
 * call da funcao
 */
atualizarBaseline(5);
/**
 *
 * @param int $idContagem
 * @return boolean
 */
function atualizarBaseline($idContagem) {
	/*
	 * atualizando funcao a funcao - ALI, AIE, EE, etc
	 */
	$sql = "SELECT 'ALI' AS 'COL', id_gerador FROM ali WHERE id_gerador IN (SELECT id FROM ali WHERE id_contagem = :idContagem) UNION
				SELECT 'AIE', id_gerador FROM aie WHERE id_gerador IN (SELECT id FROM aie WHERE id_contagem = :idContagem) UNION
				SELECT 'EE', id_gerador FROM ee WHERE id_gerador IN (SELECT id FROM ee WHERE id_contagem = :idContagem) UNION
				SELECT 'SE', id_gerador FROM se WHERE id_gerador IN (SELECT id FROM se WHERE id_contagem = :idContagem) UNION
				SELECT 'CE', id_gerador FROM ce WHERE id_gerador IN (SELECT id FROM ce WHERE id_contagem = :idContagem) UNION
				SELECT 'OU', id_gerador FROM ou WHERE id_gerador IN (SELECT id FROM ou WHERE id_contagem = :idContagem)";
	$stm = DB::prepare ( $sql );
	$stm->bindParam ( ':idContagem', $idContagem, PDO::PARAM_INT );
	$stm->execute ();
	$ids = $stm->fetchAll ( PDO::FETCH_ASSOC );
	/*
	 * percorre todas as tabelas
	 */
	foreach ( $ids as $row ) {
		$sqlUpdateBaseline = "UPDATE " . strtolower ( $row ['COL'] ) . " SET situacao = 2 WHERE id_gerador = " . $row ['id_gerador'];
		$stmUpdateBaseline = DB::prepare ( $sqlUpdateBaseline );
		echo $stmUpdateBaseline->execute () . "<br />";
	}
	return true;
}