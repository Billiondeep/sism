<?php
// FILE: info_surat.php
define('SISM_EXEC', true);
include_once __DIR__ . '/includes/header.php';
require_login('warga');

// Daftar surat lengkap dengan deskripsi dan alur
$surat_list = [
    'pengantar' => [
        'title' => 'Surat Pengantar RT/RW',
        'desc' => 'Surat resmi sebagai tanda pengenal bahwa Anda adalah warga terdaftar di wilayah ini. Diperlukan untuk mengurus KTP, KK, SKCK, dan administrasi lainnya.',
        'alur' => '1. Isi form dengan data diri sesuai KTP/KK.
2. Upload scan/foto KTP dan Kartu Keluarga.
3. Tunggu verifikasi dari pengurus RT/RW.
4. Unduh surat setelah pengajuan disetujui.'
    ],
    'sktm' => [
        'title' => 'Surat Keterangan Tidak Mampu (SKTM)',
        'desc' => 'Diterbitkan untuk warga dengan kesulitan finansial. Umumnya digunakan untuk mengajukan bantuan sosial, keringanan biaya pendidikan (Beasiswa), atau layanan kesehatan.',
        'alur' => '1. Isi form data diri dan data orang tua/wali.
2. Upload scan/foto KTP dan Kartu Keluarga.
3. Tunggu verifikasi dari pengurus RT/RW.
4. Unduh surat setelah pengajuan disetujui.'
    ],
    'domisili' => [
        'title' => 'Surat Keterangan Domisili',
        'desc' => 'Sebagai bukti sah bahwa Anda tinggal atau menetap di alamat saat ini, yang mungkin berbeda dari alamat pada KTP. Berguna untuk melamar pekerjaan, membuka rekening bank, atau keperluan administrasi lain yang memerlukan alamat terkini.',
        'alur' => '1. Isi form data diri, alamat KTP, dan alamat domisili sekarang.
2. Upload scan/foto KTP.
3. Tunggu verifikasi dari pengurus RT/RW.
4. Unduh surat setelah pengajuan disetujui.'
    ],
    'usaha' => [
        'title' => 'Surat Keterangan Usaha',
        'desc' => 'Membuktikan bahwa Anda memiliki kegiatan usaha di wilayah RT/RW. Sering digunakan sebagai syarat untuk mengajukan pinjaman modal usaha (KUR), membuat SIUP, atau izin lainnya.',
        'alur' => '1. Isi form data diri dan detail lengkap mengenai usaha Anda.
2. Upload scan/foto KTP dan foto tempat usaha.
3. Tunggu verifikasi dari pengurus RT/RW.
4. Unduh surat setelah pengajuan disetujui.'
    ],
    'penghasilan' => [
        'title' => 'Surat Keterangan Penghasilan',
        'desc' => 'Menyatakan jumlah penghasilan rata-rata per bulan, biasanya berdasarkan pernyataan. Diperlukan untuk pengajuan beasiswa, keringanan biaya, atau pengajuan kredit yang tidak memerlukan slip gaji formal.',
        'alur' => '1. Isi form data diri dan jumlah penghasilan. Data orang tua diisi jika surat ini untuk keperluan anaknya.
2. Upload scan/foto KTP.
3. Tunggu verifikasi dari pengurus RT/RW.
4. Unduh surat setelah pengajuan disetujui.'
    ],
     'kelahiran_kematian' => [
        'title' => 'Surat Keterangan Kelahiran / Kematian',
        'desc' => 'Surat pengantar untuk mencatatkan peristiwa kelahiran atau kematian ke tingkat Kelurahan/Kecamatan sebagai dasar pembuatan Akta Kelahiran atau Akta Kematian.',
        'alur' => '1. Pilih jenis keterangan (kelahiran/kematian).
2. Isi form data yang dilaporkan dan data keluarga.
3. Upload dokumen pendukung (Surat dari Bidan/RS, KTP orang tua/yang meninggal).
4. Tunggu verifikasi.'
    ],
];
?>

<h1 class="text-2xl font-bold text-gray-800 font-poppins">Informasi dan Pengajuan Surat</h1>
<p class="mt-1 text-gray-600">Pelajari setiap jenis surat dan ajukan sesuai kebutuhan Anda.</p>

<div class="mt-8 space-y-6">
    <?php foreach ($surat_list as $type => $details): ?>
    <div class="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:-translate-y-1">
        <h2 class="text-xl font-bold text-gray-800 font-poppins"><?php echo $details['title']; ?></h2>
        <p class="mt-2 text-gray-600"><?php echo $details['desc']; ?></p>
        <div class="mt-4 p-4 bg-gray-50 rounded-md border border-gray-200">
            <h4 class="font-semibold text-gray-700">Alur Pengajuan:</h4>
            <p class="mt-1 text-sm text-gray-600 whitespace-pre-line"><?php echo $details['alur']; ?></p>
        </div>
        <div class="mt-5 text-right">
            <a href="/sism-rt-rw/form_surat.php?type=<?php echo $type; ?>" class="inline-block px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition-colors">
                Ajukan Surat Ini &rarr;
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>