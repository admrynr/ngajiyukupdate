<form method="POST" id="dataForm" action="#">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_client" class="control-label">Nama Depan :</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_client" class="control-label">Nama Belakang :</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_client" class="control-label">NIK :</label>
                    <input type="text" name="nik" id="nik" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_client" class="control-label">Email :</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_client" class="control-label">Jabatan :</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control">
                </div>
            </div>
        </div>
        <div class="row password_form">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_client" class="control-label">Passsword :</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_client" class="control-label">Konfirmasi Password :</label>
                    <input type="password" name="confirmation" id="confirmation" class="form-control" required>
                </div>
            </div>
        </div>
            <input type="hidden" id="method">
            <input type="hidden" id="id">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
        <button type="submit"  class="btn btn-success waves-effect waves-light">Simpan</button>
    </div>
</form>
    
