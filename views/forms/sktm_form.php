<form action="/sism-rt-rw/process_request.php" method="POST" class="space-y-8" enctype="multipart/form-data">
    <input type="hidden" name="jenis_surat" value="surat_sktm">
    <input type="hidden" name="telp" value="<?php echo htmlspecialchars($_SESSION['telp']); ?>">
    
    <div>
        <h3 class="text-lg font-medium leading-6 text-gray-900">Data Pemohon (Anak/Diri Sendiri)</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label><input type="text" name="nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="nik" class="block text-sm font-medium text-gray-700">NIK</label><input type="text" name="nik" required pattern="\d{16}" title="NIK harus 16 digit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label><input type="text" name="tempat_lahir" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label><input type="date" name="tgl_lahir" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label><select name="jenis_kelamin" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"><option value="Laki-Laki">Laki-Laki</option><option value="Perempuan">Perempuan</option></select></div>
            <div><label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label><input type="text" name="pekerjaan" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div class="md:col-span-2"><label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap (Sesuai KTP)</label><textarea name="alamat" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea></div>
        </div>
    </div>

    <div class="border-t border-gray-200 pt-8">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Data Orang Tua / Wali</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><label for="nama_ayah" class="block text-sm font-medium text-gray-700">Nama Ayah</label><input type="text" name="nama_ayah" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="pekerjaan_ayah" class="block text-sm font-medium text-gray-700">Pekerjaan Ayah</label><input type="text" name="pekerjaan_ayah" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="nama_ibu" class="block text-sm font-medium text-gray-700">Nama Ibu</label><input type="text" name="nama_ibu" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="pekerjaan_ibu" class="block text-sm font-medium text-gray-700">Pekerjaan Ibu</label><input type="text" name="pekerjaan_ibu" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
        </div>
    </div>
    
    <div class="border-t border-gray-200 pt-8">
        <div class="md:col-span-2"><label for="keperluan" class="block text-sm font-medium text-gray-700">Keperluan Surat SKTM</label><textarea name="keperluan" rows="2" required placeholder="Contoh: Untuk pengajuan Beasiswa KIP Kuliah" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea></div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <label for="dokumen_pendukung" class="block text-sm font-medium text-gray-900">Upload Dokumen Pendukung</label>
        <p class="text-sm text-gray-500 mb-2">Contoh: Scan KTP Pemohon & KK. Format: .jpg, .png, .pdf (Maks. 2MB)</p>
        <input type="file" name="dokumen_pendukung" id="dokumen_pendukung" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
    </div>

    <div class="flex justify-end pt-4 space-x-2">
        <a href="/sism-rt-rw/dashboard.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Ajukan Surat</button>
    </div>
</form>