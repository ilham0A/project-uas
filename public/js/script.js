console.log("Script.js berhasil dipanggil!");

$(function () {
  $(".tombolTambahData").on("click", function () {
    $("#judulModal").html("Tambah Data Mahasiswa");
    $(".modal-footer button[type=submit]").html("Tambah Data");
  });
  $(document).ready(function () {
    $(".tampilModalUbah").on("click", function () {
      $("#judulModal").text("Ubah Data Mahasiswa");
      $(".modal-footer button[type=submit]").text("Ubah Data");

      const id = $(this).data("id"); // Ambil data-id dari tombol
      console.log("ID yang dikirim:", id); // Debugging ID yang akan dikirim ke server

      // Ubah action form untuk ubah data
      $("form").attr(
        "action",
        "http://localhost/2311500021_pbf1/public/mahasiswa/ubah"
      );

      $.ajax({
        url: "http://localhost/2311500021_pbf1/public/mahasiswa/getUbah",
        method: "POST",
        data: { id: id }, // Kirim ID ke server
        dataType: "json",
        success: function (data) {
          console.log("Data dari server:", data); // Debug respons server
          if (data.error) {
            alert(data.error); // Tampilkan error jika ada
            return;
          }

          // Isi form dengan data dari server
          $("#id").val(data.id);
          $("#nama").val(data.nama);
          $("#nim").val(data.nim);
          $("#email").val(data.email);
          $("#jurusan").val(data.jurusan);
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", error); // Debugging jika ada error di AJAX
        },
      });
    });
  });
});
