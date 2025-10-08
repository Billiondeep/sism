<?php
class SuratDomisiliPdf extends BasePdf {
    function generate($data) {
        $this->title = 'Surat Keterangan Domisili';
        $this->nomor_surat = '003/SKD/RT06-RW03/' . date('m/Y');
        
        $this->AliasNbPages(); $this->AddPage(); $this->SuratTitle();
        $this->SetFont('Times', '', 12);
        $this->MultiCell(0, 6, 'Yang bertanda tangan di bawah ini, Pengurus RT.06/RW.03, menerangkan bahwa:', 0, 'J'); $this->Ln(5);
        
        $this->DataRow('Nama Lengkap', $data['nama']);
        $this->DataRow('NIK', $data['nik']);
        $this->DataRow('Tempat/Tgl. Lahir', $data['tempat_lahir'] . ', ' . date('d F Y', strtotime($data['tgl_lahir'])));
        $this->DataRow('Jenis Kelamin', $data['jenis_kelamin']);
        $this->DataRow('Alamat Sesuai KTP', $data['alamat_ktp']);
        $this->Ln(5);

        $this->MultiCell(0, 6, 'Adalah benar warga kami yang saat ini berdomisili (menetap) di wilayah kami sejak tanggal ' . date('d F Y', strtotime($data['mulai_menetap'])) . ', dengan alamat:', 0, 'J');
        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15); $this->MultiCell(0, 6, $data['alamat_domisili'], 0, 'L');
        $this->Ln(5);
        $this->SetFont('Times', '', 12);

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
        $this->Output('D', 'Surat_Domisili_' . str_replace(' ', '_', $data['nama']) . '.pdf');
    }
}
?>