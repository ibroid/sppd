<?php

if (!function_exists('download_hasil')) {
    function download_hasil($exportName, $filename)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header("Content-Disposition: attachment; filename=$exportName.docx");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize('./hasil/' . $filename));

        ob_clean();
        flush();

        readfile('./hasil/' . $filename);
        unlink('./hasil/' . $filename);
        exit();
    }
}

if (!function_exists('fetchKopSurat')) {
    function fetchKopSurat($template)
    {
        $pengaturan = pengaturan();

        $template->setImageValue('logo', [
            'path' => './logo/' . $pengaturan->logo_satker,
            'width' => 50, 'height' => 50, 'ratio' => false
        ]);

        $template->setValues([
            'nama_satker' => $pengaturan->nama_satker,
            'alamat_satker' => $pengaturan->alamat_satker,
            'telp_satker' => $pengaturan->telp_satker,
            'fax_satker' => $pengaturan->fax_satker,
            'web_satker' => $pengaturan->web_satker,
            'email_satker' => $pengaturan->email_satker,
        ]);
    }
}
