@extends('layouts.main')

@section('title', 'Dashboard')

@section('style')
<link href="https://kendo.cdn.telerik.com/themes/8.0.1/default/default-main.css" rel="stylesheet" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.common.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.default.min.css" />
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    td, th {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
        vertical-align: middle; /* Centra verticalmente */
    }
</style>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2023.1.117/js/jszip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2021.3.1207/js/kendo.all.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2022.1.119/js/cultures/kendo.culture.it-IT.min.js"></script>

@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <table class="table table-sm" style="border-left: 1px solid">
                <thead class="table-danger border border-danger"><th>Categoria</th><th>Anno</th><th>Allenamento 1</th><th>Allenamento 2</th><th>Allenamento 3</th><th>Quota</th></thead>
                <tr>
                    <th rowspan="2" class="text-lg" style="vertical-align: middle;border-bottom: 1px solid black">Allievi</th>
                    <td rowspan="2" class="text-lg text-danger text-bold" style="vertical-align: middle;border-bottom: 1px solid black">2008</td>
                    <td>Lunedi 15:30-17:00</td><td>Mercoledi 15:30-17:00</td><td>Venerdi 15:30-17:00</td><th class="text-xl" rowspan="16"style="vertical-align: middle;border: 1px solid black; text-align: center">380 € +<br> 60 € kit</th>
                </tr>
                <tr>
                    <td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td>
                </tr>
                <tr><th rowspan="2" class="text-lg" style="vertical-align: middle;border-bottom: 1px solid black">Allievi</th><td rowspan="2" class="text-lg text-danger text-bold" style="vertical-align: middle;border-bottom: 1px solid black">2009</td><td>Lunedi 15:30-17:00</td><td>Mercoledi 15:30-17:00</td><td>Venerdi 15:30-17:00</td></tr>
                <tr><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td></tr>
                <tr><th rowspan="2" class="text-lg" style="vertical-align: middle;border-bottom: 1px solid black">Giovanissimi</th><td rowspan="2" class="text-lg text-danger text-bold" style="vertical-align: middle;border-bottom: 1px solid black">2010</td><td>Lunedi 18:30-20:00</td><td>Mercoledi 18:30-20:00</td><td>Venerdi 18:30-20:00</td></tr>
                <tr><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td></tr>
                <tr><th rowspan="2" class="text-lg" style="vertical-align: middle;border-bottom: 1px solid black">Giovanissimi</th><td rowspan="2" class="text-lg text-danger text-bold" style="vertical-align: middle;border-bottom: 1px solid black">2011</td><td>Lunedi 18:30-20:00</td><td>Martedi 18:30-20:00</td><td>Martedi 18:30-20:00</td></tr>
                <tr><td style="vertical-align: middle;border-bottom: 1px solid black">Collemarino</td><td style="vertical-align: middle;border-bottom: 1px solid black">Collemarino</td><td style="vertical-align: middle;border-bottom: 1px solid black">Collemarino</td></tr>
                <tr><th rowspan="2" class="text-lg" style="vertical-align: middle;border-bottom: 1px solid black">Esordienti</th><td rowspan="2" class="text-lg text-danger text-bold" style="vertical-align: middle;border-bottom: 1px solid black">2012</td><td>Lunedi 18:30-20:00</td><td>Martedi 18:30-20:00</td><td>Martedi 18:30-20:00</td></tr>
                <tr><td style="vertical-align: middle;border-bottom: 1px solid black">Collemarino</td><td style="vertical-align: middle;border-bottom: 1px solid black">Collemarino</td><td style="vertical-align: middle;border-bottom: 1px solid black">Collemarino</td></tr>
                <tr><th rowspan="2" class="text-lg" style="vertical-align: middle;border-bottom: 1px solid black">Esordienti</th><td rowspan="2" class="text-lg text-danger text-bold" style="vertical-align: middle;border-bottom: 1px solid black">2013</td><td>Lunedi 17:00-18:30</td><td>Mercoledi 17:00-18:30</td><td>Venerdi 17:00-18:30</td></tr>
                <tr><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td></tr>
                <tr><th rowspan="2" class="text-lg" style="vertical-align: middle;border-bottom: 1px solid black">Pulcini</th><td rowspan="2" class="text-lg text-danger text-bold" style="vertical-align: middle;border-bottom: 1px solid black">2014</td><td>Lunedi 17:00-18:30</td><td>Mercoledi 17:00-18:30</td><td>Venerdi 17:00-18:30</td></tr>
                <tr><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td></tr>
                <tr><th rowspan="2" class="text-lg" style="vertical-align: middle;border-bottom: 1px solid black">Pulcini</th><td rowspan="2" class="text-lg text-danger text-bold" style="vertical-align: middle;border-bottom: 1px solid black">2015</td><td>Lunedi 17:00-18:30</td><td>Mercoledi 17:00-18:30</td><td>Venerdi 17:00-18:30</td></tr>
                <tr><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td></tr>
                <tr><th rowspan="2" class="text-lg" style="vertical-align: middle;border-bottom: 1px solid black">Primi Calci</th><td rowspan="2" class="text-lg text-danger text-bold" style="vertical-align: middle;border-bottom: 1px solid black">2016<br>2017</td><td>Mercoledi 18:45-20:00</td><td>Venerdi 18:45-20:00</td><td></td><th class="text-xl" rowspan="4"style="vertical-align: middle;border: 1px solid black; text-align: center">350 € +<br> 60 € kit</th></tr>
                <tr><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black"></td></tr>
                <tr><th rowspan="2" class="text-lg" style="vertical-align: middle;border-bottom: 1px solid black">Piccoli Amici</th><td rowspan="2" class="text-lg text-danger text-bold" style="vertical-align: middle;border-bottom: 1px solid black">2018<br>2019</td><td>Mercoledi 18:00-19:00</td><td>Venerdi 18:00-19:00</td><td></td></tr>
                <tr><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle;border-bottom: 1px solid black">Vallemiano</td><td style="vertical-align: middle; text-align: center;align:center;border-bottom: 1px solid black"></td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
