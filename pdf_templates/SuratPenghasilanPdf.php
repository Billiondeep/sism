<?php
class SuratPenghasilanPdf extends BasePdf {
    function generate($data) {
        $this->title = 'Surat Keterangan Penghasilan';
        $this->nomor_surat = '005/SKP/RT06-RW03/' . date('m/Y');
        
        $this->AliasNbPages(); $this->AddPage(); $this->SuratTitle();
        $this->SetFont('Times', '', 12);
        $this->MultiCell(0, 6, 'Yang bertanda tangan di bawah ini, Pengurus RT.06/RW.03, menerangkan bahwa:', 0, 'J'); $this->Ln(5);
        
        $this->DataRow('Nama Lengkap', $data['nama']);
        $this->DataRow('NIK', $data['nik']);
        $this->DataRow('Pekerjaan', $data['pekerjaan']);
        $this->DataRow('Alamat', $data['alamat']);
        $this->Ln(5);

        $this->MultiCell(0, 6, 'Berdasarkan data dan pernyataan yang bersangkutan, nama tersebut di atas benar memiliki penghasilan rata-rata per bulan sebesar:', 0, 'J');
        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 8, 'Rp ' . number_format($data['penghasilan_bulanan'], 0, ',', '.'), 1, 1, 'C');
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
        $this->Output('D', 'Surat_Penghasilan_' . str_replace(' ', '_', $data['nama']) . '.pdf');
    }
}
?>