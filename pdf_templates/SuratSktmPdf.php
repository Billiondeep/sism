<?php
// FILE: pdf_templates/SuratSktmPdf.php
class SuratSktmPdf extends BasePdf {
    function generate($data) {
        $this->title = 'Surat Keterangan Tidak Mampu';
        $this->nomor_surat = '002/SKTM/RT06-RW03/' . date('m/Y');
        
        $this->AliasNbPages();
        $this->AddPage();
        $this->SuratTitle();
        
        $this->SetFont('Times', '', 12);
        $this->MultiCell(0, 6, 'Yang bertanda tangan di bawah ini, Pengurus RT.06/RW.03, menerangkan bahwa:', 0, 'J');
        $this->Ln(5);
        
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, 'Data Orang Tua/Wali:', 0, 1);
        $this->SetFont('Times', '', 12);
        $this->DataRow('Nama Ayah', $data['nama_ayah']);
        $this->DataRow('Pekerjaan Ayah', $data['pekerjaan_ayah']);
        $this->DataRow('Nama Ibu', $data['nama_ibu']);
        $this->DataRow('Pekerjaan Ibu', $data['pekerjaan_ibu']);
        $this->Ln(5);

        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, 'Adalah benar orang tua dari:', 0, 1);
        $this->SetFont('Times', '', 12);
        $this->DataRow('Nama Lengkap', $data['nama']);
        $this->DataRow('Tempat/Tgl. Lahir', $data['tempat_lahir'] . ', ' . date('d F Y', strtotime($data['tgl_lahir'])));
        $this->DataRow('Jenis Kelamin', $data['jenis_kelamin']);
        $this->DataRow('Alamat', $data['alamat']);
        $this->Ln(5);
        
        $this->MultiCell(0, 6, 'Berdasarkan data dan sepengetahuan kami, keluarga tersebut di atas adalah benar warga kami yang tergolong dalam kategori keluarga tidak mampu/pra-sejahtera.', 0, 'J');
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
        $this->Output('D', 'SKTM_' . str_replace(' ', '_', $data['nama']) . '.pdf');
    }
}
?>