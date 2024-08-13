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
        <div class="col-3">
            <table class="table-sm table-striped">
                <thead><th>ID</th><th>Name</th><th>Email</th><th>Stato</th><th>Ultimo Accesso</th></thead>
                <tbody>
                    @foreach ($data['user'] as $u)
                        <tr>
                            <td>{{ $u['id'] }}</td>
                            <td>{{ $u['name'] }}</td>
                            <td>{{ $u['email'] }}</td>
                            <td>
                                @if($u['isOnline'])
                                    <span class="text-bold text-success">Online</span>
                                @else
                                    <span class="text-bold text-danger">Offline</span>
                                @endif
                            </td>
                            <td>{{ $u['lastSeen'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
