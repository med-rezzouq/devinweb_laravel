@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 my4" id="form-errors" style="display: none"></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __("inscription.S'inscrire") }}
                </div>

                <div class="card-body">
                    <form
                        method="POST"
                        id="form-data"
                        data-route="{{ route('creation') }}"
                        action="#"
                    >
                        @csrf

                        <div class="form-group row">
                            <label
                                for="nom"
                                class="col-md-4 col-form-label text-md-right"
                                >{{ __("inscription.Nom") }}</label
                            >

                            <div class="col-md-6">
                                <input
                                    id="nom"
                                    type="text"
                                    class="
                                        form-control
                                        @error('nom')
                                        is-invalid
                                        @enderror
                                    "
                                    name="nom"
                                    value="{{ old('nom') }}"
                                    required
                                    autocomplete="nom"
                                    autofocus
                                />

                                @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                for="prenom"
                                class="col-md-4 col-form-label text-md-right"
                                >{{ __("inscription.Prénom") }}</label
                            >

                            <div class="col-md-6">
                                <input
                                    id="prenom"
                                    type="text"
                                    class="
                                        form-control
                                        @error('prenom')
                                        is-invalid
                                        @enderror
                                    "
                                    name="prenom"
                                    value="{{ old('prenom') }}"
                                    required
                                    autocomplete="prenom"
                                    autofocus
                                />

                                @error('prenom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                for="email"
                                class="col-md-4 col-form-label text-md-right"
                                >{{ __("inscription.E-MAIL") }}</label
                            >

                            <div class="col-md-6">
                                <input
                                    id="email"
                                    type="email"
                                    class="
                                        form-control
                                        @error('email')
                                        is-invalid
                                        @enderror
                                    "
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                />

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                for="password"
                                class="col-md-4 col-form-label text-md-right"
                                >{{ __("inscription.MOT DE PASSE") }}</label
                            >

                            <div class="col-md-6">
                                <input
                                    id="password"
                                    type="password"
                                    class="
                                        form-control
                                        @error('password')
                                        is-invalid
                                        @enderror
                                    "
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                />

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                for="password-confirm"
                                class="col-md-4 col-form-label text-md-right"
                                >{{ __("inscription.Confirm Password") }}</label
                            >

                            <div class="col-md-6">
                                <input
                                    id="password-confirm"
                                    type="password"
                                    class="form-control"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                />
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __("inscription.Inscription") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("document").ready(function () {
        $("#form-data").on("submit", function (event) {
            event.preventDefault();
            var route = $("#form-data").data("route");

            var formData = $("#form-data").serialize();
            $("#form-errors").hide();

            $("html,body").animate(
                {
                    scrollTop: $("#form-errors").offset().top - 100,
                },
                "slow"
            );

            $.ajax({
                type: "POST",
                url: route,
                data: formData,
                success: function (response) {
                    var data = response.responseJSON;

                    msgHtml =
                        '<div class="alert alert-green py4 px3">Votre inscription a été faite avec succès <a href="login">cliquer ici pour ce connecter</a></div>';
                    console.log("response", response.responseJSON);
                    $("#form-data").hide();
                    $("#form-errors").html(msgHtml);
                    $("#form-errors").show(1000);

                    // window.setTimeout(function () {
                    //     window.location.href = "http://127.0.0.1:8000/login";
                    // }, 2000);
                },
                error: function (jqXhr) {
                    var data = jqXhr.responseJSON;
                    errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each(data.errors, function (key, value) {
                        errorsHtml += "<li>" + value[0] + "</li>";
                    });
                    errorsHtml += "</ul></div>";

                    $("#form-errors").html(errorsHtml);
                    $("#form-errors").show(1000);
                    console.log("response", jqXhr.responseJSON);
                },
            });
        });
    });
</script>
@endsection
