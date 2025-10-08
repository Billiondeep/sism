<form action="process_request.php" method="POST" class="space-y-8">
    <input type="hidden" name="jenis_surat" value="superce">
    <input type="hidden" name="telp" value="<?php echo htmlspecialchars($_SESSION['telp']); ?>">
    
    <div>
        <h3 class="text-lg font-medium leading-6 text-gray-900">Data Pihak Pertama (Anda sebagai Pemohon)</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="nik" required pattern="\d{16}" title="NIK harus 16 digit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="tempat_lahir1" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                <input type="text" name="tempat_lahir1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="tgl_lahir1" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="agama1" class="block text-sm font-medium text-gray-700">Agama</label>
                <select name="agama1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                     <option>Islam</option><option>Kristen</option><option>Katolik</option><option>Hindu</option><option>Buddha</option><option>Konghucu</option>
                </select>
            </div>
            <div>
                <label for="pekerjaan1" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                <input type="text" name="pekerjaan1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="md:col-span-2">
                <label for="alamat1" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                <textarea name="alamat1" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>
        </div>
    </div>
    
    <div class="border-t border-gray-200 pt-8">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Data Pihak Kedua (Mantan Pasangan)</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nama_2" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama_2" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="tempat_lahir2" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                <input type="text" name="tempat_lahir2" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="tgl_lahir2" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir2" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="agama2" class="block text-sm font-medium text-gray-700">Agama</label>
                <select name="agama2" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                     <option>Islam</option><option>Kristen</option><option>Katolik</option><option>Hindu</option><option>Buddha</option><option>Konghucu</option>
                </select>
            </div>
             <div>
                <label for="pekerjaan2" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                <input type="text" name="pekerjaan2" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
             <div>
                <label for="status_cerai" class="block text-sm font-medium text-gray-700">Status Perceraian</label>
                <select name="status_cerai" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="Cerai Hidup">Cerai Hidup</option>
                    <option value="Cerai Mati">Cerai Mati</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label for="alamat2" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                <textarea name="alamat2" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end pt-4 space-x-2">
        <a href="dashboard.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Ajukan Surat</button>
    </div>
    <div class="border-t border-gray-200 pt-6">
        <label for="dokumen_pendukung" class="block text-sm font-medium text-gray-900">Upload Dokumen Pendukung</label>
        <p class="text-sm text-gray-500 mb-2">Contoh: Scan KTP/KK. Format file: .jpg, .png, .pdf (Maks. 2MB)</p>
        <input type="file" name="dokumen_pendukung" id="dokumen_pendukung" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
    </div>

    <div class="flex justify-end pt-4 space-x-2">
        <a href="/sism-rt-rw/dashboard.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Ajukan Surat</button>
    </div>
</form>
