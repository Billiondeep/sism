<?php
// FILE: pdf_templates/SuratUsahaPdf.php
class SuratUsahaPdf extends BasePdf {
    function generate($data) {
        $this->title = 'Surat Keterangan Usaha';
        $this->nomor_surat = '004/SKU/RT06-RW03/' . date('m/Y');
        
        $this->AliasNbPages(); $this->AddPage(); $this->SuratTitle();
        $this->SetFont('Times', '', 12);
        $this->MultiCell(0, 6, 'Yang bertanda tangan di bawah ini, Pengurus RT.06/RW.03, menerangkan bahwa:', 0, 'J'); $this->Ln(5);
        
        $this->DataRow('Nama Lengkap', $data['nama']);
        $this->DataRow('NIK', $data['nik']);
        $this->DataRow('Alamat Tinggal', $data['alamat']);
        $this->Ln(5);

        $this->MultiCell(0, 6, 'Adalah benar warga kami yang memiliki/menjalankan kegiatan usaha di wilayah kami, dengan keterangan sebagai berikut:', 0, 'J');
        $this->Ln(5);
        $this->DataRow('Nama Usaha', $data['nama_usaha']);
        $this->DataRow('Jenis Usaha', $data['jenis_usaha']);
        $this->DataRow('Alamat Usaha', $data['alamat_usaha']);
        $this->DataRow('Berdiri Sejak', date('d F Y', strtotime($data['mulai_usaha'])));
        $this->Ln(5);
        
        $this->MultiCell(0, 6, 'Surat Keterangan ini dibuat untuk keperluan ' . $data['keperluan'] . '.', 0, 'J');
        
        $data_rw = [
            'nama' => 'DIMAS EKA FADILAH',
            'token' => 'RW_TOKEN_' . $data['id'] // Buat token unik untuk RW berdasarkan ID surat
        ];
    
        $data_rt = [
            'nama' => 'DJUNI NURA',
            'token' => $data['verification_token'] // Ambil token RT dari data surat
        ];

        // 2. Panggil fungsi Signature dari BasePdf dengan DUA array.
        $this->Signature($data_rw, $data_rt);

        // 3. Hasilkan Output PDF untuk diunduh.
        $this->Output('D', 'Surat_Usaha_' . str_replace(' ', '_', $data['nama']) . '.pdf');
    }
}
?>