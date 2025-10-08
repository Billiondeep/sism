<?php

class BasePdf extends FPDF {
    protected $title = 'SURAT KETERANGAN';
    protected $nomor_surat = '.../.../.../...';
    function Header() {
        $logoPath = __DIR__ . '/../assets/images/logo-sism.png';
        if (file_exists($logoPath)) {
            $this->Image($logoPath, 15, 12, 25);
        }
        $this->SetFont('Times', 'B', 14);
        $this->Cell(0, 7, 'PEMERINTAH KOTA TANGERANG SELATAN', 0, 1, 'C');
        $this->Cell(0, 7, 'KECAMATAN SERPONG UTARA', 0, 1, 'C');
        $this->SetFont('Times', 'B', 16);
        $this->Cell(0, 7, 'RUKUN WARGA 03 / RUKUN TETANGGA 06', 0, 1, 'C');
        $this->SetFont('Times', '', 12);
        $this->Cell(0, 7, 'Sekretariat: Jl. Boulevard Pakulonan, Kel. Pakulonan, Kec. Serpong Utara, Kota Tangerang Selatan', 0, 1, 'C');
        $this->SetLineWidth(1);
        $this->Line(10, 42, 200, 42);
        $this->SetLineWidth(0.2);
        $this->Line(10, 43, 200, 43);
        $this->Ln(10);
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10, 'Halaman '.$this->PageNo(),0,0,'C');
    }

    function SuratTitle() {
        $this->SetFont('Times', 'BU', 14);
        $this->Cell(0, 7, strtoupper($this->title), 0, 1, 'C');
        $this->SetFont('Times', '', 12);
        $this->Cell(0, 7, 'Nomor: ' . $this->nomor_surat, 0, 1, 'C');
        $this->Ln(10);
    }
    
    function DataRow($label, $data) {
        $this->Cell(15);
        $this->Cell(50, 6, $label, 0, 0);
        $this->Cell(5, 6, ':', 0, 0);
        $this->MultiCell(0, 6, $data ?? '-', 0, 'L');
    }

    protected function drawESignatureBlock($x, $y, $signerName, $verificationToken) {
        require_once __DIR__ . '/../lib/qrlib.php';

        $qrTempDir = __DIR__ . '/../uploads';
        if (!is_dir($qrTempDir)) mkdir($qrTempDir, 0775, true);
        
        $qrCodeFile = $qrTempDir . '/qr_' . $verificationToken . '.png';
        $logoQrPath = __DIR__ . '/../assets/images/logo-sism-qr.png';

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $urlToVerify = $protocol . $_SERVER['HTTP_HOST'] . "/sism-rt-rw/verify.php?token=" . $verificationToken;
        // buat ngetes: $urlToVerify = "http://192.168.1.200/sism-rt-rw/verify.php?token=" . $verificationToken;

        QRcode::png($urlToVerify, $qrCodeFile, QR_ECLEVEL_H, 4, 2);

        $this->SetY($y);
        $this->SetX($x);

        $boxWidth = 85;
        $boxHeight = 28;

        $this->SetLineWidth(0.2);
        $this->Rect($x, $y, $boxWidth, $boxHeight);

        $qrSize = 20;
        $qrY = $y + (($boxHeight - $qrSize) / 2); 
        
        if (file_exists($qrCodeFile)) {
            $this->Image($qrCodeFile, $x + 4, $qrY, $qrSize, $qrSize);
            
            if (file_exists($logoQrPath)) {
                $logoSize = $qrSize * 0.25;
                $logoX = $x + 4 + ($qrSize / 2) - ($logoSize / 2);
                $logoY = $qrY + ($qrSize / 2) - ($logoSize / 2);
                $this->Image($logoQrPath, $logoX, $logoY, $logoSize, $logoSize);
            }
            unlink($qrCodeFile);
        }
        
        $textX = $x + $qrSize + 7;
        $textWidth = $boxWidth - $qrSize - 9;
        
        $lineHeight = 4; 
        $startYText = $y + 5; 

        // Baris 1
        $this->SetFont('Times', '', 8);
        $this->SetXY($textX, $startYText);
        $this->Cell($textWidth, $lineHeight, 'Telah ditandatangani secara elektronik oleh:', 0, 2, 'L');
        
        // Baris 2 (Nama)
        $this->SetFont('Times', 'B', 8);
        $this->SetTextColor(4, 88, 165);
        $this->SetX($textX);
        $this->Cell($textWidth, $lineHeight, strtoupper($signerName), 0, 2, 'L');
        $this->SetTextColor(0, 0, 0);

        // Baris 3 & 4
        $this->SetFont('Times', '', 8);
        $this->SetX($textX);
        $this->MultiCell($textWidth, 3.5, 'Menggunakan Sertifikat Elektronik SISM RT/RW.', 0, 'L');
    }

    function Signature($rwData, $rtData) {
        $this->Ln(10);
        $this->SetFont('Times', '', 12);

        $pageWidth = $this->GetPageWidth();
        $margin = 15; // Margin kiri dan kanan halaman
        $contentWidth = $pageWidth - (2 * $margin);
        $blockWidth = 85; // Lebar satu blok tanda tangan
        
        // Menghitung posisi agar kedua blok simetris di tengah halaman
        $totalBlockWidth = ($blockWidth * 2) + 5; // Lebar 2 blok + spasi 5mm
        $kolom_kiri_x = $margin + (($contentWidth - $totalBlockWidth) / 2);
        $kolom_kanan_x = $kolom_kiri_x + $blockWidth + 5; // Ditambah spasi 5mm

        setlocale(LC_TIME, 'id_ID.UTF-8', 'id_ID', 'Indonesian');
        $tanggal_surat = strftime('%d %B %Y');
        
        // --- Menulis Judul Jabatan dengan Perataan Tengah Presisi ---
        $this->SetXY($kolom_kiri_x, $this->GetY());
        $this->Cell($blockWidth, 6, 'Mengetahui,', 0, 0, 'C');
        $this->SetXY($kolom_kanan_x, $this->GetY());
        $this->Cell($blockWidth, 6, 'Tangerang Selatan, ' . $tanggal_surat, 0, 1, 'C');
        
        $this->SetXY($kolom_kiri_x, $this->GetY());
        $this->Cell($blockWidth, 6, 'Ketua RW. 03', 0, 0, 'C');
        $this->SetXY($kolom_kanan_x, $this->GetY());
        $this->Cell($blockWidth, 6, 'Ketua RT. 06', 0, 1, 'C');
        $this->Ln(1);

        $y_pos_start_block = $this->GetY();

        $this->drawESignatureBlock($kolom_kiri_x, $y_pos_start_block, $rwData['nama'], $rwData['token']);
        $this->drawESignatureBlock($kolom_kanan_x, $y_pos_start_block, $rtData['nama'], $rtData['token']);

        // --- Menulis Nama Bawah dengan Perataan Tengah Presisi ---
        $y_pos_nama = $y_pos_start_block + 28 + 2; // Y awal blok + tinggi blok + spasi
        $this->SetY($y_pos_nama);
        $this->SetFont('Times', 'BU', 12);
        
        $this->SetXY($kolom_kiri_x, $y_pos_nama);
        $this->Cell($blockWidth, 6, strtoupper($rwData['nama']), 0, 0, 'C');
        
        $this->SetXY($kolom_kanan_x, $y_pos_nama);
        $this->Cell($blockWidth, 6, strtoupper($rtData['nama']), 0, 1, 'C');
    }
}
?>