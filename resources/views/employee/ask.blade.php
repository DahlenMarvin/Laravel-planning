@extends('layouts/app')

@section('content')

    <div class="container">

        <form action="{{ route('employee.storeAsk', $employee) }}" method="POST">
            @csrf
            <fieldset class="border p-2 mt-3">
                <legend class="w-auto">Type de la demande</legend>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="typeDemande" id="conges" value="conges" checked>
                    <label class="form-check-label" for="conges">
                        Congés
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="typeDemande" id="recup" value="recup">
                    <label class="form-check-label" for="recup">
                        Récupération
                    </label>
                </div>
            </fieldset>

            <fieldset class="border p-2 mt-3">
                <legend class="w-auto">Votre poste</legend>
                <div class="form-group row">
                    <label for="poste" class="col-sm-2 col-form-label">Votre poste</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="poste" name="poste" placeholder="Votre poste dans le magasin" required>
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 mt-3">
                <legend class="w-auto">La semaine</legend>
                <div class="form-group row">
                    <label for="nSemaine" class="col-sm-2 col-form-label">Numéro de la semaine</label>
                    <div class="col-sm-10">
                        <input type="number" step="1" min="1" max="53" maxlength="2" class="form-control" id="nSemaine" name="nSemaine" placeholder="Exemple : 48" required>
                        <small id="alert" class="form-text text-muted">

                        </small>
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 mt-3">
                <legend class="w-auto">Votre demande</legend>
                <div class="form-group row">
                    <label for="comment" class="col-sm-2 col-form-label">La demande</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="comment" id="comment" cols="30" rows="5" value="3mois" required></textarea>
                    </div>
                </div>
            </fieldset>

            <div class="form-group col text-center">
                <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
            </div>

        </form>

    </div>


@endsection

@section('js')
    <script>

        $(document).ready(function(){
            $('#nSemaine').on('input', function(event) {
                if($(this).val() > 53) {
                    $('#alert').html('Le champ numéro de semaine ne peut pas être supérieur à 53 semaines')
                    $(this).val(53)
                } else if($(this).val() < 1) {
                    $('#alert').html('Le champ numéro de semaine ne peut pas être inférieur à 1 semaine')
                    $(this).val('')
                }
            })
        })

    </script>
@endsection
