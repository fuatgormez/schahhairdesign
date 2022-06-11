<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Pdf
{
    private $_CI;

    function __construct()
    {
        $this->_CI = &get_instance();
        // $this->_CI->load->model('Dynamic_Model','dm');

        $this->_CI->load->model('Model_common');
        $this->_CI->load->model('api/Model_shop');

        // $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

    public function index()
    {
        redirect(base_url());
    }

    public function positive($url)
    {

        try {
            $mpdf = new \Mpdf\Mpdf(
                [
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'default_font_size' => 9,
                    'default_font' => 'helvetica'
                ]
            );

            $mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

            $mpdf->WriteHTML(file_get_contents(base_url()));
                    

            $mpdf->Output("mynewfile.pdf",'D');exit;

            // $mpdf->Output('public/pdf/covid_test/' . time() . '.pdf', 'F');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }
    public function order_confirmation($order_number = 0)
    {
        $data['order'] = $this->_CI->Model_shop->get_order($order_number);


        try {
            $mpdf = new \Mpdf\Mpdf(
                [
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'default_font_size' => 9,
                    'default_font' => 'helvetica'
                ]
            );

            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("Irispicture Co. - Invoice");
            $mpdf->SetAuthor("Irispicture Co.");

            // $mpdf->SetDisplayMode('fullpage');

            $pagecount = $mpdf->setSourceFile('public/pdf/invoice.pdf');

            $import_page = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($import_page);

            $mpdf->WriteFixedPosHTML("fuat", 24, 60, 100,  'auto');
            $mpdf->WriteFixedPosHTML("Address", 24, 64, 100,  'auto');
            $mpdf->WriteFixedPosHTML("Address2", 24, 68, 100,  'auto');

            $mpdf->WriteFixedPosHTML('Datum: ' . date('d-m-Y'), 140, 76, 50,  'auto');
            $mpdf->WriteFixedPosHTML('Order Nummer: ' . $order_number, 140, 80, 70,  'auto');

            $mpdf->WriteFixedPosHTML('AUFTRAGSBESTÄTIGUNG ', 15, 90, 200,  'auto');
            $mpdf->WriteFixedPosHTML('______________________________________________________________________________________________________________________________', 15, 93, 200,  'auto');
            $mpdf->WriteFixedPosHTML('ONLINE ORDER', 15, 100, 200,  'auto');


            $mpdf->WriteFixedPosHTML("deneme", 15, 105, 200, 'auto');
            // $mpdf->simpleTables = true;
            // $mpdf->WriteHTML($table);

            // $mpdf->WriteHTML($table);

            $confirmation_name = $order_number . ".pdf";

            // $mpdf->Output('public/pdf/' . $invoice_name, 'F');
            $mpdf->Output('public/pdf/invoice/' . $confirmation_name, 'F');
            $mpdf->debug = true;
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }

    public function shooting_coupon($order_number)
    {
        $data['order'] = $this->_CI->Model_shop->get_order($order_number);

        try {

            $mpdf = new \Mpdf\Mpdf(
                [
                    'mode' => 'utf-8',
                    'format' => [210, 290],
                    'default_font_size' => 9,
                    'default_font' => 'helvetica',

                    'margin_left' => 0,
                    'margin_right' => 0,
                    'margin_header' => 0,
                    'margin_footer' => 0,

                    // 'orientation' => 'P'  
                ]
            );

            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("Irispicture Co. - Invoice");
            $mpdf->SetAuthor("Irispicture Co.");
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->SetDisplayMode('fullpage');

            $pagecount = $mpdf->setSourceFile('public/pdf/shooting_gutschein.pdf');

            $mpdf->AddPage();
            $mpdf->Text(66, 56, 'Shooting-Gutschein Code: ');
            $mpdf->Text(66, 63, 'Order Number: ' . $order_number);
            $mpdf->Text(66, 70, 'Ablaufdatum: ' . date('d-m-Y', strtotime('+1 year')));
            $import_page = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($import_page);


            $coupon_name = $order_number . ".pdf";

            $mpdf->Output('public/pdf/coupon/' . $coupon_name, 'F');
            $mpdf->debug = true;
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }
}
