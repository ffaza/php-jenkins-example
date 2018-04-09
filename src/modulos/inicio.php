<?php
/**
 * Created by PhpStorm.
 * User: Programador01
 * Date: 06/10/2014
 * Time: 11:13
 */

use mc\naturezajuridica\natureza;
$ws = new natureza();
$db::$conn->execute($ws->selectAll());
$natureza = $db::$conn->toArray();
$processoByNatureza  = array();
$processoByNatureza[]  = array("Natureza","Quantidade");
foreach ($natureza as $value){

    if($value->CO_NATUREZA) {
        $db::$conn->execute($processo->selectByNatureza($value->CO_NATUREZA));
        $total_byNatureza = $db::$conn->getNumRows();
        if($total_byNatureza) {
            $processoByNatureza [] = array(utf8_encode($value->NO_NATUREZA), $total_byNatureza);
        }
    }
}

$processoByUser  = array();
$processoByUser[]  = array("Funcionário","Quantidade");
$db::$conn->execute($processo->selectByUser());
$i=1;
while ($result = $db::$conn->getObject() ){
    $processoByUser[$i][0] = $result->funcionario;
    $processoByUser[$i][1] = $result->quantidade    ;
    $i++;

}



/*echo "<pre>";print_r($processoByNatureza);echo "<pre>";*/
//echo "<pre>";print_r($processoByUser);echo "<pre>";
?>

<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart2);
    function drawChart2() {
        var data   = <?php echo  json_encode($processoByNatureza) ?>;
        if(data.length>1) {
            var data2 = google.visualization.arrayToDataTable(data);
            var options = {
                title: 'Processos por natureza <?=utf8_decode("jurídica")?>',
                is3D: true,
                width: $('#piechart').width(),
                height: 300,
                backgroundColor: '#F9F9F9',
                legend: {position: 'left', textStyle: {fontName: 'Verdana', fontSize: 10, bold: false, italic: false}}
            };

            var chart2 = new google.visualization.PieChart(document.getElementById('piechart'));
            chart2.draw(data2, options);
        }
    }
</script>

<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data2   = <?php echo  json_encode($processoByUser) ?>;

        if(data2.length>1) {
            var data = google.visualization.arrayToDataTable(data2);

            var options = {
                width: $('#chart_div').width(),
                height: 300,
                pointSize: 6,
                curveType: 'function',
                title: 'Processos ativos por <?=utf8_decode("funcionário")?>',
                backgroundColor: '#F9F9F9',
                vAxes: [{minValue: 0}],
                hAxis: { textPosition: 'none' }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    }
</script>

<div class="widgets">

    <!-- Donut -->
    <div class="oneTwo">
        <div class="widget">
            <div class="title"><img src="images/icons/dark/stats.png" alt="" class="titleIcon"><h6>Processos x Natureza J&#250;ridica</h6></div>
            <div id="piechart" class="body">

            </div>
        </div>
    </div>

    <!-- Auto updating chart -->
    <div class="oneTwo">
        <div class="widget chartWrapper">
            <div class="title"><img src="images/icons/dark/stats.png" alt="" class="titleIcon"><h6>Processos x Funcion&#225;rio</h6></div>
            <div id="chart_div" class="body">

            </div>
        </div>
    </div>
    <div class="clear"></div>

</div>