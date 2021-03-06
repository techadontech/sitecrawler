<?php

    $app->get("/", "HomeController:index");

    //$app->post("/checkfile", "HomeController:excelUpload");

    $app->post("/checkfile", function($request,$response){

        $files = $request->getUploadedFiles();
        
                    $file = $files['myfile'];
        
                    $inputFileType = PHPExcel_IOFactory::load($file->file);
                    $objReader = $inputFileType->getActiveSheet()->toArray(null);
                    // $objPHPExcel = $objReader->load($inputFileName);
                    
                    // $data = array(1,$objPHPExcel->getActiveSheet()->toArray(null,true,true,true));
                    return json_encode($objReader);
        
    });

    $app->post("/checkstatus", "HomeController:checkStatus");

    $app->post("/converttoexcel", function($request, $response){

        $htmltable = $request->getParsedBodyParam("htmltb");
        //return $htmltable;

        $excelobj = new PHPExcel();
        $excelobj->getActiveSheet($htmltable);
        $response->withHeader("Content-Type","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")->withHeader('Content-Disposition','attachment;filename="crawloutput.xlsx"')->withHeader("Cache-Control","max-age=0");
        //   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //   header('Content-Disposition: attachment;filename="crawloutput.xlsx"');
        //   header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($excelobj, 'Excel2007');
        return $objWriter->save('php://output');

        //return $objWriter;

    });

?>