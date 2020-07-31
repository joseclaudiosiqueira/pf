<?php ?>
<div class="panel-default">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="min-height: 350px;">
                <div class="panel-title">
                    Situa&ccedil;&atilde;o dos contratos em rela&ccedil;&atilde;o aos Pontos de Fun&ccedil;&atilde;o contados
                </div>
                <div class="panel-body">
                    <canvas id="dashboard-grafico-contrato-pf" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!--
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="min-height: 450px;">
                <div class="panel-title">
                    &Uacute;ltimas contagens finalizadas / faturadas
                </div>
                <div class="panel-body">

                </div>
            </div>        
        </div>
    </div>-->
    <!--
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="min-height: 290px;">
                <div class="panel-title">
                    Refer&ecirc;ncia de valor PF nos contratos registrados no Dimension&reg;
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="map" style="width: 100%; height: 700px; border-radius: 5px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->
</div>
<script>
    function initMap() {
        var myLatLng = {lat: -15, lng: -56};
        var map = new google.maps.Map(document.getElementById('map'), {
            center: myLatLng,
            scrollwheel: false,
            zoom: 4
        });
        // Create a marker and set its position.
        setMarkers(map);
    }

    function setMarkers(map) {
        /*
         * coordenadas dos estados brasileiros
         */
        var arrUF = ["AC", "AL", "AM", "AP", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RO", "RS", "RR", "SC", "SE", "SP", "TO"];
        var coordenadasUF = [{"lat": -8.77, "lng": -70.55}, {"lat": -9.71, "lng": -35.73}, {"lat": -3.07, "lng": -61.66}, {"lat": 1.41, "lng": -51.77}, {"lat": -12.96, "lng": -38.51},
            {"lat": -3.71, "lng": -38.54}, {"lat": -15.83, "lng": -47.86}, {"lat": -19.19, "lng": -40.34}, {"lat": -16.64, "lng": -49.31}, {"lat": -2.55, "lng": -44.30}, {"lat": -12.64, "lng": -55.42}, {"lat": -20.51, "lng": -54.54}, {"lat": -18.10, "lng": -44.38}, {"lat": -5.53, "lng": -52.29},
            {"lat": -7.06, "lng": -35.55}, {"lat": -24.89, "lng": -51.55}, {"lat": -8.28, "lng": -35.07}, {"lat": -8.28, "lng": -43.68}, {"lat": -22.84, "lng": -43.15}, {"lat": -5.22, "lng": -36.52}, {"lat": -11.22, "lng": -62.80},
            {"lat": -30.01, "lng": -51.22}, {"lat": 1.89, "lng": -61.22}, {"lat": -27.33, "lng": -49.44}, {"lat": -10.90, "lng": -37.07}, {"lat": -23.55, "lng": -46.64}, {"lat": -10.25, "lng": -48.25}
        ];
        var image = {
            url: '/pf/img/marker.png',
            size: new google.maps.Size(24, 24),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(0, 24)
        };
        var shape = {
            coords: [1, 1, 1, 24, 24, 24, 24, 1],
            type: 'poly'
        };
        for (x = 0; x < coordenadasUF.length; x++) {
            var marker = new google.maps.Marker({
                map: map,
                position: coordenadasUF[x],
                title: arrUF[x],
                icon: image,
                shape: shape,
            }).addListener('click', function () {
                infowindow.open(map, this);
            });
            var infowindow = new google.maps.InfoWindow({
                content: this.toString()
            });
        }
    }
</script>
<!--
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwpX8-GnIlRUsbMqJtvC9EagaEHr7-kQs&callback=initMap" async defer></script>-->
