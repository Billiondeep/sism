<form action="/sism-rt-rw/process_request.php" method="POST" class="space-y-8" enctype="multipart/form-data">
    <input type="hidden" name="jenis_surat" value="surat_usaha">
    <input type="hidden" name="telp" value="<?php echo htmlspecialchars($_SESSION['telp']); ?>">
    
    <div>
        <h3 class="text-lg font-medium leading-6 text-gray-900">Data Pemilik Usaha</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label><input type="text" name="nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="nik" class="block text-sm font-medium text-gray-700">NIK</label><input type="text" name="nik" required pattern="\d{16}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div class="md:col-span-2"><label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Tinggal (Sesuai KTP)</label><textarea name="alamat" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea></div>
        </div>
    </div>
    
    <div class="border-t border-gray-200 pt-8">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Detail Usaha</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><label for="nama_usaha" class="block text-sm font-medium text-gray-700">Nama Usaha / Toko</label><input type="text" name="nama_usaha" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="jenis_usaha" class="block text-sm font-medium text-gray-700">Bidang / Jenis Usaha</label><input type="text" name="jenis_usaha" required placeholder="Contoh: Kuliner, Jasa Desain, Perdagangan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div class="md:col-span-2"><label for="alamat_usaha" class="block text-sm font-medium text-gray-700">Alamat Tempat Usaha</label><textarea name="alamat_usaha" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea></div>
            <div><label for="mulai_usaha" class="block text-sm font-medium text-gray-700">Usaha Berdiri Sejak Tanggal</label><input type="date" name="mulai_usaha" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div class="md:col-span-2"><label for="keperluan" class="block text-sm font-medium text-gray-700">Keperluan Surat</label><textarea name="keperluan" rows="2" required placeholder="Contoh: Untuk pengajuan pinjaman KUR ke Bank" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea></div>
        </div>
    </div>
    
    <div class="border-t border-gray-200 pt-6">
        <label for="dokumen_pendukung" class="block text-sm font-medium text-gray-900">Upload Dokumen Pendukung</label>
        <p class="text-sm text-gray-500 mb-2">Contoh: Scan KTP & Foto tempat usaha. Format: .jpg, .png, .pdf (Maks. 2MB)</p>
        <input type="file" name="dokumen_pendukung" id="dokumen_pendukung" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
    </div>

    <div class="flex justify-end pt-4 space-x-2">
        <a href="/sism-rt-rw/dashboard.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Ajukan Surat</button>
    </div>
</form>