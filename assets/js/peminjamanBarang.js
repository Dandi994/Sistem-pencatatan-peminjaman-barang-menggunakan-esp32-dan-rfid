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

        $(document).ready(function() {
            $.ajax({
                url: "proses/get_barang.php",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    const grouped = {};

                    // Kelompokkan berdasarkan jenis_barang
                    response.forEach(function(item) {
                        if (!grouped[item.jenis_barang]) {
                            grouped[item.jenis_barang] = [];
                        }
                        grouped[item.jenis_barang].push(item);
                    });

                    // Tambahkan hasil ke combo box
                    for (const jenis in grouped) {
                        const optgroup = $('<optgroup>', {
                            label: jenis
                        });
                        grouped[jenis].forEach(function(barang) {
                            optgroup.append(
                                $('<option>', {
                                    value: barang.id_barang,
                                    text: barang.id_barang + ' - ' + barang.nama_barang
                                })
                            );
                        });
                        $('#barang').append(optgroup);
                    }
                },
                error: function() {
                    alert("Gagal mengambil data barang.");
                }
            });
        });