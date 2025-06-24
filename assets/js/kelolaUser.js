  let uidPolling;

        function startPollingUID() {
            uidPolling = setInterval(() => {
                $.get('./proses/get_uid.php', function(data) {
                    $('#uid').val(data);
                });
            }, 1000);
        }

        function loadUserData() {
            $.ajax({
                url: 'kelolaUser.php?action=get_users',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let html = '';
                    data.forEach((user, index) => {
                        html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${user.uid}</td>
                            <td>${user.kelas}</td>
                            <td>${user.prodi}</td>
                            <td>${user.angkatan}</td>
                            <td>
                                <a href="editUser.php?id=${user.id}" class="btn btn-sm btn-success">Edit</a>
                                <a href="proses/hapus_user.php?id=${user.id}" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    `;
                    });
                    $('#user-table-body').html(html);
                }
            });
        }

        startPollingUID();
        loadUserData();

        $('#myForm').on('submit', function(e) {
            e.preventDefault();
            clearInterval(uidPolling);

            $.ajax({
                url: 'proses/update_user.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert('Data berhasil dikirim!');
                    $('#myForm')[0].reset();
                    $('#uid').val('');
                    loadUserData();
                    startPollingUID();
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            });
        });