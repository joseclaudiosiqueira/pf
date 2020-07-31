<?php

include $_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php';
// pega todas as empresas
$e = new Empresa();
$f = new Fornecedor();
$fa = new Contagem();
// varre as empresa
$empresas = $e->consultaGenerica("SELECT id FROM empresa");
$fornecedores = $f->consultaGenerica("SELECT id, id_empresa FROM fornecedor");
//inicia os jobs
echo 'Start Date: ' . date('Y/m/d H:i:s') . '<br />';
include 'job_contagem_baseline.php';
include 'job_contagem_projeto.php';
include 'job_complexidade_funcoes.php';
include 'job_contagem_abrangencia.php';
include 'job_contagem_etapa.php';
include 'job_contagem_mes.php';
include 'job_contagem_pf_mes.php';
include 'job_contagem_situacao.php';
include 'job_contagem_tipo.php';
include 'job_metodo_funcoes.php';
include 'job_situacao_funcoes.php';
include 'job_banco_dados.php';
include 'job_cliente_contrato_pf.php';
include 'job_estatisticas_index.php';
echo 'Finish Date: ' . date('Y/m/d H:i:s');