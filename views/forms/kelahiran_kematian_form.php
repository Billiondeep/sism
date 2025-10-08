<form action="/sism-rt-rw/process_request.php" method="POST" class="space-y-6" enctype="multipart/form-data">
    <input type="hidden" name="jenis_surat" value="surat_kelahiran_kematian">
    <input type="hidden" name="telp" value="<?php echo htmlspecialchars($_SESSION['telp']); ?>">
    
    <div>
        <label for="jenis_keterangan" class="block text-sm font-medium text-gray-700">Jenis Keterangan yang Diajukan</label>
        <select name="jenis_keterangan" id="jenis_keterangan" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="Kelahiran">Kelahiran</option>
            <option value="Kematian">Kematian</option>
        </select>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <h3 class="text-lg font-medium text-gray-800">Data yang Dilaporkan (Bayi / Almarhum)</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label><input type="text" name="nama_lengkap" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"><option value="Laki-Laki">Laki-Laki</option><option value="Perempuan">Perempuan</option></select>
            </div>
            <div><label for="tempat_wafat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir/Wafat</label><input type="text" name="tempat_wafat_lahir" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="hari_wafat_lahir" class="block text-sm font-medium text-gray-700">Hari Lahir/Wafat</label><input type="text" name="hari_wafat_lahir" required placeholder="Contoh: Senin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div class="md:col-span-2"><label for="tanggal_wafat_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir/Wafat</label><input type="date" name="tanggal_wafat_lahir" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div id="sebab_kematian_field" class="md:col-span-2" style="display:none;"><label for="sebab_kematian" class="block text-sm font-medium text-gray-700">Sebab Kematian</label><input type="text" name="sebab_kematian" placeholder="Contoh: Sakit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
        </div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <h3 class="text-lg font-medium text-gray-800">Data Keluarga</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><label for="nama_ayah" class="block text-sm font-medium text-gray-700">Nama Ayah</label><input type="text" name="nama_ayah" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div><label for="nama_ibu" class="block text-sm font-medium text-gray-700">Nama Ibu</label><input type="text" name="nama_ibu" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            <div class="md:col-span-2"><label for="alamat_keluarga" class="block text-sm font-medium text-gray-700">Alamat Keluarga</label><textarea name="alamat_keluarga" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea></div>
        </div>
    </div>
    
    <div class="border-t border-gray-200 pt-6">
        <label for="dokumen_pendukung" class="block text-sm font-medium text-gray-900">Upload Dokumen Pendukung</label>
        <p class="text-sm text-gray-500 mb-2">Contoh: Surat dari Bidan/RS, KTP/KK Orang Tua. Format: .jpg, .png, .pdf (Maks. 2MB)</p>
        <input type="file" name="dokumen_pendukung" id="dokumen_pendukung" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
    </div>

    <div class="flex justify-end pt-4 space-x-2">
        <a href="/sism-rt-rw/dashboard.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Ajukan Surat</button>
    </div>
</form>
<script>
document.getElementById('jenis_keterangan').addEventListener('change', function() {
    var sebabKematianField = document.getElementById('sebab_kematian_field');
    if (this.value === 'Kematian') {
        sebabKematianField.style.display = 'block';
    } else {
        sebabKematianField.style.display = 'none';
    }
});
</script>