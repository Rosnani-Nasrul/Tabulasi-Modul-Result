<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/highcharts/highcharts.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/boostrapdatetimepicker/css/bootstrap-datetimepicker.min.css">

<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>  
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->

<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>


<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a></li>
        <li class="active">Dashboard</li>
    </ul>

    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>

</div>
<!-- /breadcrumbs line -->
<div class="row">
    <div class="col-md-12">
        <!-- Vertical bars -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title"><i class="icon-bars2"></i> Statistik Pemilihan Umum</h6>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <form class="form-horizontal" id="pie_result_pilkada" method="POST">
                        <div class="col-sm-4">
                            <div class="form-group" style="margin-top:0px;">
                                <div class="col-sm-12">
                                    <select class="form-control" id="pilkada" name="pilkada">
                                        <option value=''>--Pilih Pilkada--</option>                                  
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" style="margin-top:0px;">
                                <div class="col-sm-12">
                                    <select class="form-control" id="putaran" name="putaran">
                                        <option value=''>--Pilih Putaran-</option>                                  
                                    </select>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-4">
                            <div class="form-group" style="margin-top:0px;">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="provinsi" name="provinsi" placeholder="Nama Provinsi" readonly="true">
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-4">
                            <div class="form-group" style="margin-top:0px;">
                                <div class="col-sm-12">
                                    <select class="form-control" id="kabupaten" name="kabupaten">
                                        <option value=''>--Pilih Kabupaten--</option>                                  
                                    </select>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-4">
                            <div class="form-group" style="margin-top:0px;">
                                <div class="col-sm-12">
                                    <select class="form-control" id="kecamatan" name="kecamatan">
                                        <option value=''>--Pilih Kecamatan--</option>                                  
                                    </select>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-4">
                            <div class="form-group" style="margin-top:0px;">
                                <div class="col-sm-12">
                                    <select class="form-control" id="kelurahan" name="kelurahan">
                                        <option value=''>--Pilih Kelurahan--</option>                                  
                                    </select>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-4">
                            <div class="form-group" style="margin-top:0px;">
                                <div class="col-sm-12">
                                    <select class="form-control" id="tps" name="tps">
                                        <option value=''>--Pilih TPS--</option>                                  
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
               <div class="col-sm-6">
                            <div class="form-group col-sm-2">
                                <button type="button" class="btn btn-info" onclick="Search()">Cari</button>
                            </div>                        
                        </div>
                <div class="col-md-12">
                    <h4 class="text-center" style="font-style: Helvetica;">Tabel Statistik Result</h4>
                    <p class="text-center" style="font-style: Helvetica;" id="tabel_result">Tahun 2016</p>
                        <!-- Row styling -->
                        <div class="block">
                            <div class="">
                                <table class="table table-bordered" id="dataresult">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Kandidat</th>
                                            <th class="text-center">Total Suara</th>
                                        </tr>
                                    </thead>
                                </table>
                                
                            </div>
                        </div>
                        <!-- /row styling -->
                </div>

                 <div class="col-md-12">
                    <h4 class="text-center" style="font-style: Helvetica;">Grafik Statistik Result</h4>
                    <p class="text-center" style="font-style: Helvetica;" id="grafik_result">Tahun 2016</p>
                    <br>
                    <div id="vertical_bars1"></div>
                </div>

            </div>
        </div>
        <!-- /vertical bars -->
    </div>
</div>
<!-- /info blocks -->
<script type="text/javascript">
var $ = jQuery;

function Search(){
    var pilkada = $('#pilkada').val();
    var putaran = $('#putaran').val();
    var provinsi = $('#provinsi').val();
    var kabupaten = $('#kabupaten').val();
    var kecamatan = $('#kecamatan').val();
    var kelurahan = $('#kelurahan').val();
    var tps = $('#tps').val();
    
    showGrafikResult();

$(document).ready(function(){ 
    $('#dataresult').dataTable( {
            "processing": true,
            "serverSide": true,
            "bServerSide": true,
            "sAjaxSource": baseurl+"home/dashboard/listResult" + "/" + pilkada + "/" + putaran + "/" +  provinsi + "/" + kabupaten + "/" +  kecamatan + "/" +  kelurahan + "/" +  tps,
            "aaSorting": [[0, "ASC"]],
            "aoColumns": [
            { "bSortable": false, "sClass": "text-center" },
            { "sClass": "text-left" },
            { "bSortable": false, "sClass": "text-center" }
            ],
            "fnDrawCallback": function () {
                set_default_datatable();
            },
        });
});
}

$(document).ready(function(){
    $.ajax({
              url: "<?php echo site_url('home/dashboard/pilkada')?>",
              type: "GET",
              dataType: "JSON",
              success: function (data) {
                  var obj = new Object(data);
                  var select = document.querySelector('#pilkada');
                  for (var i = 0; i < Object.keys(data).length; i++) {
                      select.innerHTML += "<option value='" + data[i]['pilkada_id'] + "'>" + data[i]['pilkada_name'] + "</option>";
               }
            }
        });

       $("#pilkada").change(function(){
           var pilkada_id = $("#pilkada").val();
           $("#putaran").empty();
        $.ajax({
              url: "<?php echo site_url('home/dashboard/putaran') ?>/" + pilkada_id,
              type: "GET",
              dataType: "JSON",
              success: function (data) {
                  var obj = new Object(data);
                  var select = document.querySelector('#putaran');
                  for (var i = 0; i < Object.keys(data).length; i++) {
                      select.innerHTML += "<option value='" + data[i]['pilkada_session_id'] + "'>" + data[i]['pilkada_session_name'] + "</option>";
                    }
                }
            });
       });

         $("#pilkada").change(function(){
          var id = $("#pilkada").val();
         
            $.ajax({
                  url: "<?php echo site_url('home/dashboard/place') ?>/" + id,
                  type: "GET",
                  dataType: "JSON",
                  success: function (data) {
                      $('[name="provinsi"]').val(data.province_code).trigger('change');;
                    }
                });
            
            });

        $("#provinsi").change(function(){
              var regency_id = $("#provinsi").val();
            
              $("#kabupaten").empty();
                $.ajax({
                      url: "<?php echo site_url('home/dashboard/kabupaten') ?>/" + regency_id,
                      type: "GET",
                      dataType: "JSON",
                      success: function (data) {
                          var obj = new Object(data);
                          var select = document.querySelector('#kabupaten');
                          for (var i = 0; i < Object.keys(data).length; i++) {
                              select.innerHTML += "<option value='" + data[i]['regency_code'] + "'>" + data[i]['regency_name'] + "</option>";
                            }
                        }
                    });
                });

     $("#kabupaten").change(function(){
          var district_id = $("#kabupaten").val();
          $("#kecamatan").empty();
            $.ajax({
                  url: "<?php echo site_url('home/dashboard/kecamatan') ?>/" + district_id,
                  type: "GET",
                  dataType: "JSON",
                  success: function (data) {
                      var obj = new Object(data);
                      var select = document.querySelector('#kecamatan');
                      for (var i = 0; i < Object.keys(data).length; i++) {
                          select.innerHTML += "<option value='" + data[i]['district_code'] + "'>" + data[i]['district_name'] + "</option>";
                        }
                    }
                });
            });     
     $("#kecamatan").change(function(){
          var district_id = $("#kecamatan").val();
          $("#kelurahan").empty();
            $.ajax({
                  url: "<?php echo site_url('home/dashboard/kelurahan') ?>/" + district_id,
                  type: "GET",
                  dataType: "JSON",
                  success: function (data) {
                      var obj = new Object(data);
                      var select = document.querySelector('#kelurahan');
                      for (var i = 0; i < Object.keys(data).length; i++) {
                          select.innerHTML += "<option value='" + data[i]['village_id'] + "'>" + data[i]['village_name'] + "</option>";
                        }
                    }
                });
            }); 


     $("#kelurahan").change(function(){
          var pilkada_session_id = $("#kelurahan").val();
          $("#tps").empty();
            $.ajax({
                  url: "<?php echo site_url('home/dashboard/tps') ?>/" + pilkada_session_id,
                  type: "GET",
                  dataType: "JSON",
                  success: function (data) {
                      var obj = new Object(data);
                      var select = document.querySelector('#tps');
                      for (var i = 0; i < Object.keys(data).length; i++) {
                          select.innerHTML += "<option value='" + data[i]['pilkada_tps_id'] + "'>" + data[i]['pilkada_tps_name'] + "</option>";
                        }
                    }
                });
            });  
});

function showGrafikResult(){
    $("#grafik_result").html("");
    $("#tabel_result").html("");
    $("#dataresult").html("");
    var serialize = $("#pie_result_pilkada").serialize();
    $("#vertical_bars1").html("");
    $.ajax({
        url: baseurl+'home/dashboard/getGrafikResult',
        type: 'POST',
        data: serialize,
        success: function (datas) {
            var data = JSON.parse(datas);
            var datanya = '';
            if (data.result.length > 0) {
                for (var i = 0; i < data.result.length; i++) {
                    datanya += '<tr><td>'+(i+1)+'</td><td>'+data.result[i]["pilkada_candidate_name"]+'</td><td style="text-align:center">'+data.result[i]["pilkada_result_total_vote"]+'</td></tr>';                
                }
            }            
            else{
                datanya += '<tr><td colspan="3" style="text-align:center">Data tidak tersedia</td></tr>'
            }
            
            $("#dataresult").append(datanya);
            $("#grafik_result").html(data.grafik_result);
            $("#tabel_result").html(data.grafik_result);
            Highcharts.chart('vertical_bars1', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Perjalanan'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Total Perjalanan: <b>{point.y}</b>'
                },
                series: [{
                    name: 'Population',
                    data: data.result,
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        format: '{point.y}',
                        y: 10,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }]
            });
        }
    });
}

</script>