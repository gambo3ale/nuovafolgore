@extends('layouts.main')

@section('style')
<style>
.table th, .table td {
    text-align: center;
}

.table .btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.table .btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}
</style>
@endsection

@section('content')
<div class="container">
    <h1>Gestione Squadre per Allenatori</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('assegna.squadra') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="allenatore_id">Seleziona Utente:</label>
            <select name="allenatore_id" id="allenatore_id" class="form-control">
                @foreach($allenatori as $allenatore)
                    <option value="{{ $allenatore->id }}">{{ $allenatore->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="categoria_id">Seleziona Categoria:</label>
            <select name="categoria_id" id="categoria_id" class="form-control">
                @foreach($categorie as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->categoria_estesa }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="categoria_id">Seleziona Staff:</label>
            <select name="staff_id" id="staff_id" class="form-control">
                @foreach($staff as $st)
                    <option value="{{ $st->id }}">{{ $st->cognome }} {{$st->nome}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="categoria_id">Seleziona Stagione:</label>
            <select name="stagione_id" id="stagione_id" class="form-control">
                @foreach($stagioni as $stag)
                    <option value="{{ $stag->id }}">{{ $stag->descrizione }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Assegna Squadra</button>
    </form>

    <hr>

    <h2>Squadre Assegnate</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Allenatore</th>
                @foreach($categorie as $categoria)
                    <th>{{ $categoria->categoria_estesa }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($allenatori as $allenatore)
                <tr>
                    <td>{{ $allenatore->name }}</td>
                    @foreach($categorie as $categoria)
                            @php
                                $squadra = $allenatore->squadreAllenate->firstWhere('id_categoria', $categoria->id);
                            @endphp
                        <td @if($squadra) class="table-success" @endif>
                            @if($squadra)
                                <form action="{{ route('rimuovi.squadra', $squadra->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" aria-label="Rimuovi">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                            @else
                                <span>—</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
