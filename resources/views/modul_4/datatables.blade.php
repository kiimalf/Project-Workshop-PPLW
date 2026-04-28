@extends('layouts.main')

@section('style-page')
    <link rel="stylesheet"
href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        #tableBarang tbody tr:hover {
            cursor: pointer;
        }
    </style>

@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Index Barang dengan Table Datatables </h3>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form id="inputForm">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" id="namaBarang" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Barang</label>
                            <input type="number" class="form-control" id="hargaBarang" required>
                        </div>
                    </form>

                    <button id="submitButton" class="btn btn-primary">
                        Submit
                    </button>

                    <hr>

                    <table id="tableBarang" class="table">
                        <thead>
                            <tr>
                                <td>ID Barang</td>
                                <td>Nama</td>
                                <td>Harga</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class="modal fade" id="modalBarang">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Edit Barang</h5>
                                </div>

                                <div class="modal-body">
                                    <form id="editForm">

                                        <div class="form-group">
                                            <label>ID Barang</label>
                                            <input type="text" id="editId" class="form-control" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Nama Barang</label>
                                            <input type="text" id="editNama" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Harga Barang</label>
                                            <input type="number" id="editHarga" class="form-control" required>
                                        </div>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button id="updateButton" class="btn btn-warning">Ubah</button>
                                    <button id="deleteButton" class="btn btn-danger">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-page')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let table;
        let selectedRow = null;

        $(document).ready(function() {
            table = $('#tableBarang').DataTable();

            $('#submitButton').click(function() {
                let form = document.getElementById('inputForm');

                if(!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                $('#submitButton').html(
                    '<span class="spinner-border spinner-border-sm"></span> Loading'
                )
                $('#submitButton').prop('disabled', true);

                setTimeout(function(){
                    tambahData();
                },1000);
            });

            $('#updateButton').click(function() {
                let form = document.getElementById('editForm');

                if(!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                $('#updateButton').html(
                    '<span class="spinner-border spinner-border-sm"></span> Loading'
                )
                $('#updateButton').prop('disabled', true);

                setTimeout(function(){
                    updateData();
                },1000);
            });

            $('#deleteButton').click(function() {

                $('#deleteButton').html(
                    '<span class="spinner-border spinner-border-sm"></span> Loading'
                )
                $('#deleteButton').prop('disabled', true);

                setTimeout(function(){
                    deleteData();
                },1000);
            });

            $('#tableBarang tbody').on('click', 'tr', function () {
                selectedRow = table.row(this);
                let data = selectedRow.data();

                $('#editId').val(data[0]);
                $('#editNama').val(data[1]);
                $('#editHarga').val(data[2]);

                $('#modalBarang').modal('show');
            });
        });

        function tambahData() {
            let nama = $('#namaBarang').val();
            let harga = $('#hargaBarang').val();
            let id = Math.floor(Math.random() * 100);
            
            table.row.add([
                id,
                nama,
                harga
            ]).draw();
            
            $('#namaBarang').val("");
            $('#hargaBarang').val("");

            $('#submitButton').html("Submit");
            $('#submitButton').prop("disabled", false);
        }

        function updateData() {
            let id = $('#editId').val();
            let nama = $('#editNama').val();
            let harga = $('#editHarga').val();
            
            selectedRow.data([
                id,
                nama,
                harga
            ]).draw();

            $('#editId').val("");
            $('#editNama').val("");
            $('#editHarga').val("");

            $('#updateButton').html("Update");
            $('#updateButton').prop("disabled", false);
            $('#modalBarang').modal('hide');
        }

        function deleteData() {
            selectedRow.remove().draw();

            $('#editId').val("");
            $('#editNama').val("");
            $('#editHarga').val("");

            $('#deleteButton').html("Delete");
            $('#deleteButton').prop("disabled", false);
            $('#modalBarang').modal('hide');
        }

    </script>
@endsection