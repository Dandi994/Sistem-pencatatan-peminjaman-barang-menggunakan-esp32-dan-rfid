function loadAllPeminjaman() {
            $.ajax({
                url: 'proses/get_riwayat.php',
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        let rows = '';
                        res.data.forEach((item, index) => {
                            rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.uid}</td>
                                <td>${item.kelas}</td>
                                <td>${item.semester}</td>
                                <td>${item.kode_barang}</td>
                                <td>${item.nama_barang}</td>
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
                    } else {
                        $('#dataBody').html('<tr><td colspan="9" class="text-center">Gagal memuat data.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error memuat data:", error);
                    $('#dataBody').html('<tr><td colspan="9" class="text-center">Terjadi kesalahan.</td></tr>');
                }
            });
        }

        function updateStatus(id) {
            $.ajax({
                url: 'proses/update_status_peminjaman.php',
                method: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Status berhasil diperbarui.');
                        loadAllPeminjaman(); // refresh data
                    } else {
                        alert('Gagal memperbarui status: ' + (response.message || ''));
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alert('Terjadi kesalahan saat menghubungi server.');
                }
            });
        }

        // Muat data saat halaman dimuat
        $(document).ready(function() {
            loadAllPeminjaman();
        });

        function filterData() {
            const tglAwal = $('#tanggalAwal').val();
            const tglAkhir = $('#tanggalAkhir').val();

            $.ajax({
                url: 'proses/get_riwayat.php',
                method: 'GET',
                data: {
                    tgl_awal: tglAwal,
                    tgl_akhir: tglAkhir
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        let rows = '';
                        res.data.forEach((item, index) => {
                            rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.uid}</td>
                            <td>${item.kelas}</td>
                            <td>${item.semester}</td>
                            <td>${item.kode_barang}</td>
                            <td>${item.nama_barang}</td>
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
                    } else {
                        $('#dataBody').html('<tr><td colspan="9" class="text-center">Data tidak ditemukan.</td></tr>');
                    }
                }
            });
        }

        function exportExcel() {
            const tglAwal = document.getElementById('tanggalAwal').value;
            const tglAkhir = document.getElementById('tanggalAkhir').value;

            // Jika tanggal tidak diisi, export semua data
            let url = 'proses/export_excel.php';
            if (tglAwal && tglAkhir) {
                url += `?tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}`;
            }

            window.location.href = url;
        }