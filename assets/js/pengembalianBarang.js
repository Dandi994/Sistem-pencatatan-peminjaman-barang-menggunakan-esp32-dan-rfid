 let alertShown = false;

        function loadDataByUid() {
            $.ajax({
                url: 'proses/get_data_peminjam.php',
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'not_found') {
                        if (!alertShown) {
                            alert('Kartu belum terdaftar!');
                            alertShown = true; // ⬅️ Jangan tampilkan alert lagi
                        }
                        $('#uidInput').val(res.uid);
                        $('#dataBody').html('');
                        return;
                    }

                    if (res.status === 'no_uid') {
                        $('#uidInput').val('');
                        $('#dataBody').html('');
                        alertShown = false; // ⬅️ Reset saat tidak ada UID
                        return;
                    }

                    if (res.status === 'found') {
                        alertShown = false; // ⬅️ Reset saat UID valid
                        $('#uidInput').val(res.uid);
                        let rows = '';
                        res.peminjaman.forEach((item, index) => {
                            rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${res.uid}</td>
                            <td>${res.kelas}</td>
                            <td>${item.nama_barang}</td>
                            <td>${item.jumlah}</td>
                            <td>${item.tgl_peminjaman}</td>
                            <td>${item.tgl_pengembalian ?? '-'}</td>
                            <td>${item.status}</td>
                            <td>
                                ${item.status === 'Dipinjam' ? 
                                    `<button class="btn btn-success btn-sm" onclick="updateStatus(${item.id})">Kembalikan</button>` : 
                                    '<span class="text-muted">Sudah</span>'
                                }
                            </td>
                        </tr>
                    `;
                        });
                        $('#dataBody').html(rows);
                    }
                }
            });
        }

        // Jalankan fungsi setiap 2 detik
        setInterval(loadDataByUid, 2000);

        function updateStatus(id) {
            $.ajax({
                url: 'proses/update_status_peminjaman.php',
                method: 'POST',
                data: {
                    id: id
                },
                dataType: 'json', // PENTING agar jQuery parse otomatis
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Barang berhasil dikembalikan!');
                        loadDataByUid(); // refresh data
                    } else {
                        alert('Gagal mengubah status: ' + (response.message || ''));
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alert('Terjadi kesalahan saat menghubungi server.');
                }
            });
        }