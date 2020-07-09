<?php ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--facebook tags-->
        <meta property="og:locale" content="en_US">
        <meta property="og:title" content="Dimension - Métricas - Análise de Pontos de Função, Pontos de Teste, Requisitos Não Funcionais - APF/IFPUG, APT, SNAP">
        <meta property="og:site_name" content="Dimension">
        <meta property="og:description" content="Integre CONTRATANTES, FORNECEDORES e &Oacute;RG&Atilde;OS DE CONTROLE e facilite os trabalhos de valida&ccedil;&atilde;o externa (Cliente) e auditoria externa (&Oacute;rg&atilde;os de controle). Bom porque elimina pap&eacute;is e fluxos desnecess&aacute;rios na sua empresa e melhor ainda porque facilita o trabalho dos seus Clientes e Auditores. Trabalhe em um ambiente colaborativo, onde o lema é agilizar seus processos.">
        <meta property="og:image" content="http://pfdimension.com.br/pf/img/Dimension.jpg">
        <meta property="og:image:type" content="image/jpeg">
        <meta property="og:image:width" content="640">
        <meta property="og:image:height" content="480">
        <meta property="og:type" content="website">
        <!--end-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Dimension - Análise de Pontos de Função, Análise de Pontos de Testes, Requisitos Não-Funcionais e Planejamento">
        <meta name="author" content="Dimension">
        <link rel="icon" href="/pf/img/favicon.ico">
        <title>Dimension&reg; - M&eacute;tricas</title>
        <link href="/pf/css/vendor/bootstrap/bootstrap.css" rel="stylesheet">
        <link href="/pf/css/vendor/font-awesome/font-awesome.css" rel="stylesheet">
        <style type="text/css">
            body{ 
                padding-top:54px;
                font-size: 16px;
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                font-family: 'Georgia', sans-serif;
                overflow-x: hidden;
                padding-top: 40px;
            }
            p {
                font-size: 16px;
            }
            .headerDoc {
                color: #005580;
            }
            @media (max-width: 767px) {
                #toc {
                    position: relative;
                    width: 100%;
                    margin: 0px 0px 20px 0px;
                }
            }
            .ok{
                color:#008000;
            }
            .pend{
                color:#B61E2D;
            }            
        </style>
    </head>
    <body>
        <div class="container" style="padding:30px; background: rgba(255,255,255,.5);">
            <table width="100%" class="table">
                <thead>
                    <tr><th colspan="3"><center><h2>Status do projeto Dimension&reg;</h2></center></th></tr>
                </thead>
                <tbody>
                    <tr><td colspan="3"><h3>Módulo inicial</h3></td></tr>
                    <tr><td width="30%"><h4>Descrição</h4></td><td width="10%"><h4>Status</h4></td><td width="60%"><h4>Observações</h4></td></tr>
                    <tr><td>Criar conta</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Ativar usuário</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Relembrar senha</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Alterar senha</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Completar perfil do usuário</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Atualizar a foto (Avatar)</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td colspan="3"><h3>Módulo principal (contagens)</h3></td></tr>
                    <tr><td>Inserir contagem avulsa</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Inserir contagem baseline</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Inserir contagem EF (d/t)</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td>[01/06/2016]<br />Trata-se de uma nova proposição de método para contagens de pontos de função derivada da APF. Este método foi proposto pelo TCU.</td></tr>
                    <tr><td>Inserir contagem projeto</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Inserir contagem licitação</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Inserir contagem APT</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[01/06/2016]<br />Previsão para o início de 2017</td></tr>
                    <tr><td>Inserir contagem SNAP</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[30/03/2016]<br />O proceso SNAP ainda não está maduro no mercado. A Dimension pretende lançar uma versão <i>beta</i> em março/2017.</td></tr>
                    <tr><td colspan="3"><h3>Módulo adicional (contagens)</h3></td></tr>
                    <tr><td>Sugerir e utilizar Linguagem (na contagem)</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td>[01/01/2016]<br />É um avanço implementado pela Dimension&reg; e significa que quando o analista está inserindo uma contagem e o tipo de linguagem utilizada no projeto não consta na listagem, ele pode neste momento inserir uma nova linguagem e utilizá-la no projeto.</td></tr>
                    <tr><td>Sugerir e utilizar Banco de dados (na contagem)</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td>[01/01/2016]<br />Trata-se do mesmo avanço implementao para a linguagem.</td></tr>
                    <tr><td colspan="3"><h3>Módulo especial de treinamento</h3></td></tr>
                    <tr><td>Gerenciamento de Turmas e Alunos</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td>O Dimension&reg; oferece um m&oacute;dulo especial de treinamento. Neste
                            m&oacute;dulo as contagens inseridas n&atilde;o s&atilde;o cobradas, ou seja, contagens inseridas por <kbd>alunos em treinamento</kbd> s&atilde;o gratuitas.</td></tr>                
                    <tr><td colspan="3"><h3>Módulos de permissões (contagens)</h3></td></tr>
                    <tr><td>Alterar contagem</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Excluir contagem</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Visualizar contagem</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Atualizar baseline</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Alterar validador interno</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[30/08/2016]<br />Funcionalidade prevista para o final de novembro/2016</td></tr>
                    <tr><td>Alterar validador externo</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[30/08/2016]<br />Funcionalidade prevista para o final de novembro/2016</td></tr>
                    <tr><td>Alterar o gerente do projeto</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[30/08/2016]<br />As funcionalidades de gestão de projetos estão previstas para o segundo semestre de 2017.</td></tr>
                    <tr><td>Finalizar auditoria interna (compulsória)</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[30/08/2016]<br />Funcionalidade prevista para o final de novembro/2016</td></tr>
                    <tr><td>Finalizar auditoria externa (compulsoria)</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[30/08/2016]<br />Funcionalidade prevista para o final de novembro/2016</td></tr>
                    <tr><td>Alterar a privacidade da contagem</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td>[01/12/2015]<br />O sistema de controle de acesso às contagens permite que apenas os envolvidos na contagem possam visualizar, entretanto você pode tornar sua contagem pública. Esta funcionalidade pública/privada aplica-se apenas a sua Empresa. Tornar uma contagem pública não quer dizer que outras empresas irão ter acesso a ela.</td></tr>
                    <tr><td colspan="3"><h3>Módulos de alterações, validações e colaboração</h3></td></tr>
                    <tr><td>Validação interna</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Validação externa</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Auditoria interna</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Auditoria externa</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Fluxo de revisão de validação e auditoria</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Sistema de mensagens e observações</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Enviar e editar contagem de forma colaborativa</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[30/08/2016]<br />Funcionalidade prevista para o início de 2017</td></tr>
                    <tr><td colspan="3"><h3>Módulo de relatórios</h3></td></tr>
                    <tr><td>Relatório em .PDF</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Relatório em .XLS</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Relatório em .XLSX</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Relatório em .HTML</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Relatórios personalizados</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td>[30/08/2016]<br />Estes relatórios são feitos sob demanda. A hora/Homem Dimension&reg; custa R$ 350,00. Geralmente cada relatório leva em média de seis a oito horas para ser elaborado, caso todas as informações já estejam no sistema. Caso alguma informação no relatório não esteja no nosso domínio vamos informar sobre a possibilidade de implantação liberação do relatório.</td></tr>
                    <tr><td colspan="3"><h3>Controle de tarefas</h3></td></tr>
                    <tr><td>Gerenciar tarefas pendentes</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Gerenciar tarefas solicitadas</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td colspan="3"><h3>Módulo de Business Intelligence</h3></td></tr>
                    <tr><td>BI das contagens</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[30/08/2016]<br />O modelo de B.I. do Dimension&reg; está em elaboração. A previsão de entrega dos <i>dashboards</i> está prevista para o final de 2016. Estas funcionalidades liberadas não acarretam nenhum custo ao usuário.</td></tr>
                    <tr><td colspan="3"><h3>Módulo administrativo</h3></td></tr>
                    <tr><td colspan="3"><h4>Gerenciar usuários</h4></td></tr>
                    <tr><td>Inserir usuário</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Alterar perfil usuário (pendências)</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[01/05/2016]<br />O modelo proposto para alteração de perfis de usuário pode gerar inconsistências. Este modelo está sendo revisto e será entregue em meados de novembro/2016, apesar de estar disponível e em funcionamento.</td></tr>
                    <tr><td>Listar perfis</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td colspan="3"><h4>Gerenciar fornecedores</h4></td></tr>
                    <tr><td>Inserir fornecedor</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Alterar/consultar fornecedores</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Atualizar logomarca</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td colspan="3"><h4>Gerenciar roteiros</h4></td></tr>
                    <tr><td>Inserir/Alterar roteiros</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Inserir/Alterar itens de roteiros</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Importar roteiros públicos</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[01/06/2016]<br />Previsão de entrega em janeiro/2017.</td></tr>
                    <tr><td colspan="3"><h4>Gerenciar clientes</h4></td></tr>
                    <tr><td>Inserir cliente</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Alterar/consultar clientes</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Atualizar logomarca</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td colspan="3"><h4>Gerenciar contratos</h4></td></tr>
                    <tr><td>Inserir/Alterar contratos e aditivos</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td colspan="3"><h4>Gerenciar projetos</h4></td></tr>
                    <tr><td>Inserir/Alterar projetos contratados</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td colspan="3"><h4>Gerenciar empresa/fornecedor</h4></td></tr>
                    <tr><td>Alterar/atualizar o cadastro da empresa</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Alterar/atualizar o cadastro do fornecedor</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Atualizar logomarca</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Autenticação via LDAP</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[30/08/2016]<br />Esta funcionalidade está disponível apenas em instalações locais.</td></tr>
                    <tr><td>Estatísticas de armazenamento</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Estatísticas de quantidade de contagens</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[30/08/2016]<br />Esta estatística estará disponível em dezembro/2016.</td></tr>
                    <tr><td colspan="3"><h4>Gerenciar contagens e tarefas</h4></td></tr>
                    <tr><td>Configurações das contagens</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Configurações das tarefas</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Compartilhamento de contagens</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Diretório público de contagens (Licitações)</td><td class="pend"><i class="fa fa-stop-circle fa-2x"></i></td><td>[30/08/2016]<br />Esta funcionalidade estará disponível em fevereiro/2017.</td></tr>
                    <tr><td colspan="3"><h4>Relatórios</h4></td></tr>
                    <tr><td>Configurar relatórios</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Cabeçalho e rodapé</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Inserir logomarcas (Cliente e Empresa)</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                    <tr><td>Gerenciar assinaturas por projeto</td><td class="ok"><i class="fa fa-check-circle fa-2x"></i></td><td></td></tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
