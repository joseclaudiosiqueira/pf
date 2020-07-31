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
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/jsgantt/jsgantt.css" />
<script language="javascript" src="/pf/js/vendor/jsgantt/jsgantt.js"></script>
<div style="position:relative" class="gantt" id="GanttChartDIV"></div>
<script>

    var g = new JSGantt.GanttChart(document.getElementById('GanttChartDIV'), 'week');

    if (g.getDivId() != null) {
        g.setCaptionType('Complete');
        g.setQuarterColWidth(36);
        g.setDateTaskDisplayFormat('day dd month yyyy');
        g.setDayMajorDateDisplayFormat('mon yyyy - Week ww');
        g.setWeekMinorDateDisplayFormat('dd mon');
        g.setShowTaskInfoLink(1);
        g.setShowEndWeekDate(0);
        g.setUseSingleCell(10000);
        g.setFormatArr('Day', 'Week', 'Month', 'Quarter');

        g.AddTaskItem(new JSGantt.TaskItem(1, window.opener.document.getElementById('pct-eng').innerHTML, '', '', 'ggroupblack', '', 0, 'Brian', 0, 1, 0, 1, '', '', 'Some Notes text', g));
        g.AddTaskItem(new JSGantt.TaskItem(2, 'Engenharia de Requisitos', '2014-02-01', '2014-02-19', 'gtaskblue', '', 1, 'Shlomy', 100, 0, 1, 1, '', '', '', g));
        g.AddTaskItem(new JSGantt.TaskItem(3, 'Design / Arquitetura', '2014-02-20', '2014-02-20', 'gtaskblue', '', 1, 'Shlomy', 100, 0, 1, 1, '', '', '', g));
        g.AddTaskItem(new JSGantt.TaskItem(4, 'Implementacao', '2014-02-20', '2014-02-20', 'gtaskblue', '', 0, 'Shlomy', 40, 1, 0, 1, '', '', '', g));
        g.AddTaskItem(new JSGantt.TaskItem(5, 'Testes', '2014-02-21', '2014-03-09', 'gtaskblue', '', 0, 'Brian T.', 60, 0, 0, 1, '', '', '', g));
        g.AddTaskItem(new JSGantt.TaskItem(6, 'Homologacao', '2014-03-06', '2014-03-11', 'gtaskred', '', 0, 'Brian', 60, 0, 0, 1, 121, '', '', g));
        g.AddTaskItem(new JSGantt.TaskItem(7, 'Implantacao', '2014-03-09', '2014-03-14 12:00', 'gtaskyellow', '', 0, 'Ilan', 60, 0, 0, 1, '', '', '', g));

        g.Draw();
    }
    else
    {
        alert("Error, unable to create Gantt Chart");
    }
</script>
