@extends('layouts.main')

@section('style-page')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-0">Select 1</h4>

                    <form id="form1">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kota:</label>
                            <div class="col-md-10">
                                <input type="text" id="inputKota1" class="form-control" required>
                            </div>
                        </div>
                    </form>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="button" id="submitButton1" class="btn btn-success">
                                Tambahkan
                            </button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Select Kota:</label>
                        <div class="col-md-10">
                            <select class="form-control" id="selectKota1">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kota Terpilih:</label>
                        <div class="col-md-10 pt-2">
                            <span id="kotaTerpilih1"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-0">Select 2</h4>

                    <form id="form2">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kota:</label>
                            <div class="col-md-10">
                                <input type="text" id="inputKota2" class="form-control" required>
                            </div>
                        </div>
                    </form>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="button" id="submitButton2" class="btn btn-success">
                                Tambahkan
                            </button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Select Kota:</label>
                        <div class="col-md-10">
                            <select class="form-control" id="selectKota2">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kota Terpilih:</label>
                        <div class="col-md-10 pt-2">
                            <span id="kotaTerpilih2"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-page')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#selectKota2').select2();

            $('#submitButton1').click(function () {
                let form = document.getElementById('form1');

                if (!form.checkValidity()){
                    form.reportValidity();
                    return;
                }

                $('#submitButton1').html(
                    '<span class="spinner-border spinner-border-sm"></span> Loading'
                )
                $('#submitButton1').prop('disabled', true);

                setTimeout(function(){
                    tambahKota1();
                },1000);
            });

            $('#submitButton2').click(function () {
                let form = document.getElementById('form2');

                if (!form.checkValidity()){
                    form.reportValidity();
                    return;
                }

                $('#submitButton2').html(
                    '<span class="spinner-border spinner-border-sm"></span> Loading'
                )

                $('#submitButton2').prop('disabled', true);

                setTimeout(function(){
                    tambahKota2();
                },1000);

            });

            $('#selectKota1').change(function() {
                let kota = $(this).val();
                $('#kotaTerpilih1').text(kota);
            });

            $('#selectKota2').change(function() {
                let kota = $(this).val();
                $('#kotaTerpilih2').text(kota);
            });
        });

        function tambahKota1() {
            let kota = $('#inputKota1').val();

            $('#selectKota1').append(
                `<option value='${kota}'>${kota}</option>`
            );

            $('#submitButton1').html("Tambahkan");
            $('#submitButton1').prop("disabled", false);
            $('#inputKota1').val('');
        }

        function tambahKota2() {
            let kota = $('#inputKota2').val();

            $('#selectKota2').append(
                `<option value="${kota}">${kota}</option>`
            ).trigger('change');

            $('#submitButton2').html("Tambahkan");
            $('#submitButton2').prop("disabled", false);
            $('#inputKota2').val('');
        }
    </script>
@endsection