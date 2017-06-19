<?php



  require('dompdf_config.inc.php');
  $html = "<meta http-equiv='Content-Type' content='text/html; charset=utf8'><p style='font-family:SimSun;'>我就是中文</p><img src='lo.png' style='position:absolute;top:0;opacity:0.7;' />";
  $pdf_obj = new DOMPDF();
  $pdf_obj->load_html($html);
  $pdf_obj->render();
  $pdf_obj->stream('test_pdf.pdf',array("Attachment" => false));//在线预览
  //$pdf_obj->stream('test_pdf.pdf');//下载


?>