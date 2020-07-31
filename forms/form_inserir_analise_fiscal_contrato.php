<?php ?>
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/bootstrap/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="/pf/css/dimension.css" />
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="analise-fiscal-contrato"><h4>Parecer do Fiscal do Contrato em relação a análise e/ou comparação entre as contagens</h4></label>
            <textarea class="form-control input_style scroll" style="width:100%;" id="analiseFiscalContrato" required></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <button type="button" class="btn btn-success" onclick="salvaAnaliseFiscalContrato();"><i class="fa fa-check-circle"></i>&nbsp;Salvar análise</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="/pf/js/vendor/jquery-1.11.3.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/pf/js/vendor/bootstrap.min.js" charset="utf-8"></script>
<!--CKEditor-->
<script type="text/javascript" src="/pf/vendor/ckeditor/ckeditor.js"></script>
<!--Trying to initialize tooltips-->
<script type="text/javascript">
                //reinicializa os tooltips
                $('[data-toggle="tooltip"]').tooltip({html: true});
                DIMCKEditor = CKEDITOR.replace('analiseFiscalContrato', {
                    height: 400
                });
<?php
if ($isAnaliseExistente) {
    ?>
                    DIMCKEditor.setData('<?= html_entity_decode($isAnaliseExistente->analise); ?>');
    <?php
}
?>
</script>


