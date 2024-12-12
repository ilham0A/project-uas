<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mhs as $mahasiswa): ?>
            <tr>
                <td><?= $mahasiswa['id']; ?></td>
                <td><?= $mahasiswa['nama']; ?></td>
                <td><?= $mahasiswa['nim']; ?></td>
                <td><?= $mahasiswa['email']; ?></td>
                <td><?= $mahasiswa['jurusan']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>