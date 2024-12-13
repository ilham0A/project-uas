<div class="container mt-4">
    <div class="row">
        <div class="col-lg-6">
            <?php Flasher::flash(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <!-- Button trigger modal -->
            <h3>Daftar Mahasiswa</h3>
            <br>
            <button type="button" class="btn btn-primary ml-1 tombolTambahData" data-toggle="modal" data-target="#formModal">
                Tambah Data Mahasiswa
            </button>
            <button onclick="printData()" class="btn btn-secondary float-right ml-1">Print</button>
            <a href="<?php echo BASEURL; ?>/mahasiswa/exportPDF" class="btn btn-warning float-right ml-1">PDF</a>
            <a href="<?= BASEURL; ?>/mahasiswa/exportExcel" class="btn btn-success float-right ml-1">Excel</a><br><br>
            <!-- Menambahkan ID printArea di sini -->
            <div id="printArea">
                <ul class="list-group">
                    <?php foreach ($data['mhs'] as $mhs) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo htmlspecialchars($mhs['nama']); ?>
                            <div>
                                <a href="<?php echo BASEURL; ?>/mahasiswa/hapus/<?php echo $mhs['id']; ?>" class="badge badge-danger float-right ml-1" onclick="return confirm('Yakin?');">
                                    hapus
                                </a>
                                <a href="<?php echo BASEURL; ?>/mahasiswa/ubah/<?php echo $mhs['id']; ?>"
                                    class="badge badge-success float-right ml-1 tampilModalUbah"
                                    data-toggle="modal"
                                    data-target="#formModal"
                                    data-id="<?php echo $mhs['id']; ?>">
                                    ubah
                                </a>

                                <a href="<?php echo BASEURL; ?>/mahasiswa/detail/<?php echo $mhs['id']; ?>" class="badge badge-primary float-right ml-1">
                                    detail
                                </a>

                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <br>
            <a href="<?= BASEURL; ?>/Auth/logout" class="btn btn-primary float-left ml-1" onclick="return confirm('Apakah Anda Ingin Logout?');">
                Logout
            </a>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulModal">Tambah Data Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo BASEURL; ?>/mahasiswa/tambah" method="post">
                    <input type="hidden" id="id" name="id" value="">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="nim">Nim</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="23115000.." required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com" required>
                    </div>
                    <div class="form-group">
                        <label for="jurusan">Jurusan</label>
                        <select class="form-control" id="jurusan" name="jurusan">
                            <option value="teknik informatika">Teknik Informatika</option>
                            <option value="sistem informasi">Sistem Informasi</option>
                            <option value="managemen informatika">Managemen Informatika</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>