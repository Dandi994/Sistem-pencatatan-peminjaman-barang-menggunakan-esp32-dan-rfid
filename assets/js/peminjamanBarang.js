  let lastUID = null;
        let uidPolling = null;

        function startPollingUID() {
            uidPolling = setInterval(() => {
                $.ajax({
                    url: 'proses/get_uid_card.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);

                        if (data.status === 'found') {
                            if (data.uid !== lastUID) {
                                lastUID = data.uid;
                                $('#uid').val(data.uid);
                                $('#kelas').val(data.kelas);
                                $('#prodi').val(data.prodi);
                                $('#semester').val(data.semester);

                                // Stop polling if UID is valid
                                clearInterval(uidPolling);
                                console.log("Polling dihentikan karena UID valid ditemukan.");
                            }
                        } else if (data.status === 'not_found') {
                            if (data.uid !== lastUID) {
                                lastUID = data.uid;
                                alert("Kartu tidak terdaftar.");
                                $('#uid').val('');
                                $('#kelas').val('');
                                $('#prodi').val('');
                                $('#semster').val('');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Gagal mengambil UID:", error);
                    }
                });
            }, 1000);
        }

        function resetPolling() {
            // Reset nilai
            lastUID = null;
            $('#uid').val('');
            $('#kelas').val('');
            $('#prodi').val('');
            $('#semster').val('');

            // Hentikan polling jika sedang berjalan
            if (uidPolling) clearInterval(uidPolling);

            // Mulai ulang polling
            startPollingUID();
        }

        // Mulai polling saat halaman dimuat
        $(document).ready(function() {
            startPollingUID();

            // Reset polling setelah form disubmit (optional)
            $('#myForm').on('submit', function(e) {
                // Tunggu submit selesai, baru reset polling (opsional, tergantung kebutuhan)
                setTimeout(() => {
                    resetPolling();
                }, 2000); // misal delay 2 detik setelah submit
            });
        });

let dataBarang = [];

$(document).ready(function () {
  // Ambil data barang dari server
  $.ajax({
    url: "proses/get_barang.php",
    method: "GET",
    dataType: "json",
    success: function (response) {
      dataBarang = response;

      // Isi hanya dropdown yang sudah ada saat halaman dimuat
      $('.barang-select').each(function () {
        populateSelect($(this));
      });
    },
    error: function () {
      alert("Gagal mengambil data barang.");
    }
  });

  // Tambah baris baru
  $('#tambah-baris').click(function () {
    const $newRow = $(`
      <tr>
        <td>
          <select name="barang[]" class="form-control barang-select" required>
            <option disabled selected>Pilih Barang</option>
          </select>
        </td>
        <td><input type="number" name="jumlah[]" class="form-control" min="1" required></td>
        <td><button type="button" class="btn btn-danger hapus-baris">Hapus</button></td>
      </tr>
    `);

    $('#tabel-barang tbody').append($newRow);

    // Isi hanya dropdown pada baris baru
    const $selectBaru = $newRow.find('.barang-select');
    populateSelect($selectBaru);
  });

  // Hapus baris
  $(document).on('click', '.hapus-baris', function () {
    $(this).closest('tr').remove();
  });
});

// Fungsi isi satu dropdown <select>
function populateSelect($select) {
  $select.empty().append('<option disabled selected>Pilih Barang</option>');
  dataBarang.forEach(barang => {
    $select.append(
      $('<option>', {
        value: barang.id_barang,
        text: `${barang.id_barang} - ${barang.nama_barang}`
      })
    );
  });
}
