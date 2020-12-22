@extends('layout.site')

@section('title','JSON2CSV')

@section('content')

<div class="container">
    <div class="row">
        <div class="col l12 m12">
            <div class="card yellow">
                <div class="card-content black-text">
                    <span class="card-title" style="font-weight:700;">Bem Vindo ao JSON2CSV</span>
                    <p>Com esta aplicação simples é possivel converter seu texto JSON em CSV, basta colar o texto que
                    deseja converter na caixa de Entrada e seu CSV sairá pronto na caixa de Saida.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col l6 m12">
            <div class="card yellow">
                <div class="row">
                <form class="col s12" action="{{route('converte')}}" method="post">
                    {{ csrf_field() }}
                    <div class="card-content black-text">
                        <span class="card-title" style="font-weight:700;">Entrada</span>
                        <div class="row">
                            <div class="input-field col s12">
                                <textarea name="json" id="jsonText" class="materialize-textarea white" style="overflow-y: scroll; height: 300px; max-height: 300px;"></textarea>
                                <label class="black-text" for="jsonText">Cole aqui seu JSON</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="button" id="botaoLimpar" onclick="limpar()" class="waves-effect waves-light btn black">Limpar</button>
                        <button type="submit" id="botaoGerar" onclick="validarJson('json')" class="waves-effect waves-light btn black">Converter</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="col l6 m12">
            <div class="card yellow" style="height: 520px">
                <div class="row">
                <form class="col s12" id="csvForm">
                    <div class="card-content black-text">
                        <span class="card-title" style="font-weight:700;">Saida</span>
                        <div class="row">
                            <div class="input-field col s12">
                            <textarea placeholder="Aqui estará seu CSV" name="csv" id="csvOutput" class="materialize-textarea white" style="overflow-y: scroll; overflow-x: scroll; height: 300px; max-height: 300px;">{{isset($finalCSV) ? $finalCSV : null}}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function limpar(){
    document.getElementById("jsonText").value = '';
    document.getElementById("csvOutput").value = '';
}

function validarJson(name){
    var objArray = document.getElementsByName(name)[0].value;
    try{
        JSON.parse(objArray);
    } catch (e) {
        window.alert('Caixa vazia ou JSON inválido!');
    }
}

</script>

@endsection