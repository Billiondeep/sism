<?php
class SuratKelahiranKematianPdf extends BasePdf {
    function generate($data) {
        $is_kelahiran = (strtolower($data['jenis_keterangan']) == 'kelahiran');
        $this->title = $is_kelahiran ? 'Surat Keterangan Kelahiran' : 'Surat Keterangan Kematian';
        $this->nomor_surat = '006/SKK/RT06-RW03/' . date('m/Y');
        
        $this->AliasNbPages(); $this->AddPage(); $this->SuratTitle();
        $this->SetFont('Times', '', 12);
        $this->MultiCell(0, 6, 'Yang bertanda tangan di bawah ini, Pengurus RT.06/RW.03, menerangkan bahwa pada:', 0, 'J');
        $this->Ln(5);
        
        $this->DataRow('Hari', $data['hari_wafat_lahir']);
        $this->DataRow('Tanggal', date('d F Y', strtotime($data['tanggal_wafat_lahir'])));
        $this->DataRow('Tempat', $data['tempat_wafat_lahir']);
        $this->Ln(5);

        $this->MultiCell(0, 6, $is_kelahiran ? 'Telah lahir seorang anak dengan data sebagai berikut:' : 'Telah meninggal dunia seorang warga kami, dengan data sebagai berikut:', 0, 'J');
        $this->Ln(5);
        $this->DataRow('Nama Lengkap', $data['nama_lengkap']);
        $this->DataRow('Jenis Kelamin', $data['jenis_kelamin']);
        if(!$is_kelahiran){
            $this->DataRow('Sebab Kematian', $data['sebab_kematian']);
        }
        $this->Ln(5);

        $this->MultiCell(0, 6, 'Dari keluarga Bapak/Ibu:', 0, 'J');
        $this->Ln(2);
        $this->DataRow('Nama Ayah', $data['nama_ayah']);
        $this->DataRow('Nama Ibu', $data['nama_ibu']);
        $this->DataRow('Alamat Keluarga', $data['alamat_keluarga']);
        $this->Ln(5);
        
        $this->MultiCell(0, 6, 'Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagai pengantar dalam mengurus Akta di Instansi terkait.', 0, 'J');
        
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
$file_prefix = $is_kelahiran ? 'SK_Kelahiran_' : 'SK_Kematian_';
        // Menggunakan kunci array 'nama_lengkap' yang benar
        $file_name = $file_prefix . str_replace(' ', '_', $data['nama_lengkap']) . '.pdf';

        $this->Output('D', $file_name);
    }
}
?>