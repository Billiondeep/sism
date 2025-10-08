<form action="/sism-rt-rw/process_request.php" method="POST" class="space-y-8" enctype="multipart/form-data">
    <!-- Menggunakan nama tabel baru: surat_pengantar -->
    <input type="hidden" name="jenis_surat" value="surat_pengantar">
    <input type="hidden" name="telp" value="<?php echo htmlspecialchars($_SESSION['telp']); ?>">
    
    <!-- Bagian Data Diri Pemohon -->
    <fieldset class="border border-gray-300 p-6 rounded-lg">
        <legend class="px-2 text-lg font-semibold text-gray-800">Data Diri Pemohon</legend>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="nik" id="nik" required pattern="\d{16}" title="NIK harus 16 digit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" id="tgl_lahir" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div>
                <label for="agama" class="block text-sm font-medium text-gray-700">Agama</label>
                <select name="agama" id="agama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option>Islam</option><option>Kristen</option><option>Katolik</option><option>Hindu</option><option>Buddha</option><option>Konghucu</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="pekerjaan" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="md:col-span-2">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap (Sesuai KTP)</label>
                <textarea name="alamat" id="alamat" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            </div>
        </div>
    </fieldset>

    <!-- Bagian Keperluan & Dokumen -->
    <fieldset class="border border-gray-300 p-6 rounded-lg">
        <legend class="px-2 text-lg font-semibold text-gray-800">Keperluan & Dokumen</legend>
        <div class="mt-4 space-y-6">
            <div>
                <label for="keperluan" class="block text-sm font-medium text-gray-700">Keperluan Surat</label>
                <textarea name="keperluan" id="keperluan" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: Untuk mengurus SKCK di kepolisian"></textarea>
            </div>
            <div>
                <label for="dokumen_pendukung" class="block text-sm font-medium text-gray-900">Upload Dokumen Pendukung</label>
                <p class="text-sm text-gray-500 mb-2">Contoh: Scan KTP/KK. Format file: .jpg, .png, .pdf (Maks. 2MB)</p>
                <input type="file" name="dokumen_pendukung" id="dokumen_pendukung" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
            </div>
        </div>
    </fieldset>

    <!-- Tombol Aksi -->
    <div class="flex justify-end pt-4 space-x-2">
        <a href="/sism-rt-rw/dashboard.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Ajukan Surat</button>
    </div>
</form>