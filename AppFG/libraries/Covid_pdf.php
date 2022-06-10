<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Spipu\Html2Pdf\Html2Pdf;


class Covid_pdf
{
    private $_CI;

    function __construct()
    {
        $this->_CI = &get_instance();

        $this->_CI->load->model('Model_common');
        $this->_CI->load->model('schnelltestzentrum/Model_covid_test_form');
    }

    public function index()
    {
        redirect(base_url());
    }

    public function generate_pdf_Dompdf($html)
    {
        $dompdf = new \Dompdf\Dompdf();
        // $url = file_get_contents($path . $name . $ext, true);

        $dompdf->loadHtml($html, 'UTF-8');

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4');

        $dompdf->render();
        file_put_contents("public/pdf/covid_test/fuat.pdf", $dompdf->output());
    }

    public function generate_pdf_Mpdf($pdf_name, $check, $val)
    {

        $this->_CI->load->library('encryption');
        try {
            $mpdf = new \Mpdf\Mpdf(
                [
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'default_font_size' => 10,
                    'default_font' => 'helvetica'
                ]
            );

            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("Irispicture Co. - Invoice");
            $mpdf->SetAuthor("Irispicture Co.");

            // $mpdf->SetDisplayMode('fullpage');

            // $stylesheet = file_get_contents('https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css');
            // $mpdf->WriteHTML($stylesheet, 1);

            $mpdf->SetHTMLHeader('
            <div style="text-align: right; font-weight: bold;">
                 Schnelltestzentrum - {DATE j-m-Y}
            </div>');
            $mpdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">Schnelltestzentrum</td>
                </tr>
            </table>');

            $html = '&nbsp;';
            $html .= '<p style="margin-top:50px;font-weight:bold">Bescheinigung über das Vorliegen eines positiven oder negativen Antigentests zum Nachweis des SARS-CoV-2 Virus</p>';
            $html .= '<p style="margin-top:50px;font-weight:bold">Testzentrum:</p>';
            $html .= '<p>Name: AIG Schnelltest Zentrum</p>';
            $html .= '<p>Straße: Tempelhofer Damm</p>';
            $html .= '<p>Hausnummer: 123</p>';
            $html .= '<p>Postleitzahl: 12099 Berlin</p>';

            $html .= '<hr />';
            $html .= '<p style="margin-top:50px; font-weight:bold">Getestete Person:</p>';

            $html .= '<table width="100%">
                        <tr>
                            <td width="33%">Name: '.$this->_CI->encryption->decrypt($check['lastname']).'</td>
                            <td width="33%" align="center">Vorname: '.$this->_CI->encryption->decrypt($check['firstname']).'</td>
                            <td width="33%" style="text-align: right;">'.$this->_CI->encryption->decrypt($check['gender']).'</td>
                        </tr>
                    </table>';

            $html .= '<p>Anschrift: '.$this->_CI->encryption->decrypt($check['street']).' '.$this->_CI->encryption->decrypt($check['postcode']).', '.$this->_CI->encryption->decrypt($check['ort_city']).'</p>';
            $html .= '<p>Geburtsdatum: '.$this->_CI->encryption->decrypt($check['birthday']).'</p>';
            $html .= '<p>Telefonnummer: '.$this->_CI->encryption->decrypt($check['telefon']).'</p>';


            $html .= '<p style="margin-top:100px; font-weight:bold">Antigen-Schnelltest:</p>';
            $html .= '<p>Name des Tests: Sars Cov-2 Antigen Rapid Test Kit (Collodial Gold)</p>';
            $html .= '<p>Hersteller: Joysbio</p>';
            $html .= '<p>Testdatum/Testuhrzeit: ' . date('d-m-Y', strtotime($check['created_at'])) . ' - ' . date('H:i:s', strtotime($check['created_at'])) . '</p>';
            $html .= '<p>Test durchgeführt durch (Namen): Reis Cakal</p>';

            $html .= '<hr />';

            if($val === "positive"){
                $positive_checked = 'checked="checked"';
            } 
            if($val === "negative"){
                $negative_checked = 'checked="checked"';
            }

            $html .= '<table width="100%">
                        <tr>
                            <td width="33%"><span style="font-weight:bold">Testergebnis:</span></td>
                            <td width="33%">Positive <input type="checkbox" '.@$positive_checked.'></td>
                            <td width="33%">Negative <input type="checkbox" '.@$negative_checked.'></td>
                        </tr>
                    </table>';

            $html .= '<hr style="margin-top:100px">';
            $html .= 'Datum / Stempel testende Stelle / Unterschrift';

            $html .= '<p>Wer dieses Dokument fälscht oder einen nicht erfolgten Test unrichtig bescheinigt, macht sich nach § 267 StGB der Urkundenfälschung strafbar. Jeder festgestellte Verstoß wird zur Anzeige gebracht.</p>';

            $html .= '<p>*Bei einem positiven Ergebnis muss sich die Person unmittelbar in Quarantäne begeben. Dies gilt auch für Haushaltsangehörige von Personen mit einem positiven Schnelltest. Die Quarantäne darf erst beendet werden, wenn ein nachfolgender PCR-Test ein negatives Ergebnis hat. Die positiv getestete Person hat zur Bestätigung oder auch Widerlegung Anspruch auf einen PCR-Test.</p>';

            $html .= '<p style="margin-top:100px;">Einverständniserklärung</p>';
            $html .= '<p>Speichelentnahme für Tests zum Nachweis von SARS-CoV-2/COVID-19</p>';

            $html .= '<p style="margin-top:30px; margin-bottom: 20px; font-weight:bold">Angaben zur Person:</p>';


            $html .= '<span>Name:</span>';
            $html .= '<hr style="margin-top:-1px; margin-bottom:30px;">';

            $html .= '<span>Vorname:</span>';
            $html .= '<hr style="margin-top:-1px; margin-bottom:30px;">';

            $html .= '<span>Geburtsdatum:</span>';
            $html .= '<hr style="margin-top:-1px; margin-bottom:30px;">';

            $html .= '<span>Anschrift:</span>';
            $html .= '<hr style="margin-top:-1px; margin-bottom:30px;">';

            $html .= '<span>E-Mail-Adresse / Telefonnummer:</span>';
            $html .= '<hr style="margin-top:-1px; margin-bottom:30px;">';


            $html .= '<p style="margin-top:50px; font-weight:bold">Informationen zu diesem Dokument:</p>';

            $html .= 'Hiermit erteilen Sie uns Ihre ausdrü ckliche Einwilligung zur Durchfü hrung einer Speichelentnahme mit anschließendem Antigen-Schnelltest und/ oder PCR-Test zwecks Nachweis einer akuten COVID-19-Erkrankung/ Infektion mit SARS-CoV-2 sowie zu der hiermit einhergehenden Verarbeitung Ihrer personenbezogenen Daten im Sinne von Art. 4 Abs.1 Datenschutz-Grundverordnung (DSGVO). Dazu zählen insb. auch solche personenbezogenen Daten, die gemäß Art. 9 Abs.1 DSGVO einem besonderen Schutz unterliegen (Gesundheitsdaten). So benö tigen wir zur Durchfü hrung der Untersuchung gemä ß Art. 9 Abs.2 lit. a) DSGVO Ihre ausdrü ckliche, schriftliche Einwilligung zur Datenverarbeitung.';

            $html .= '<p style="margin-top:50px; font-weight:bold">Entnahme des Untersuchungsmaterials:</p>';

            $html .= '<p>Zur Durchfü hrung des geplanten Tests zwecks Nachweises einer akuten SARS-CoV-2- Infektion/ COVID-19-Erkrankung ist zunächst die Entnahme von Untersuchungsmaterial erforderlich. Dies erfolgt mittels eines Abstrichs im Nasen-Rachen-Raum (Nasopharynx). Der Abstrich erfolgt regelhaft durch entsprechend medizinisch geschultes Personal und ggf. mit telemedizinischem Hintergrunddienst des Leitenden Arztes der 21Dx GmbH/Johaniter.</p>';

            $html .= 'Diese Entnahme ist in den meisten Fällen medizinisch unbedenklich. Folgende Unannehmlichkeit/ Risiken kö nnen dabei jedoch auftreten:';

            $html .= '<ul>
                        <li>ReizungderNasenschleimhäute</li>
                        <li>Würgereiz</li>
                        <li>Blutungen im Entnahme-Raum</li>
                        <li>Atemnot/ Atembeklemmungen</li>
                        <li>Niesen/ Husten/ Verschlucken</li>
                    </ul>';

            $html .= '<p style="margin-top:50px; font-weight:bold">Durchführung des Tests:</p>';

            $html .= '<p>Im Anschluss an die Entnahme des Untersuchungsmaterials
            wird entweder noch vor Ort ein Antigen-Schnelltest
            durchgeführt oder die Probe zur Durchführung eines
            PCR-Tests an ein mit uns kooperierendes, akkreditiertes
            Labor übersandt. Die Auswertung des Schnelltests sowie die
            Befundmitteilung erfolgen vor Ort. U]ber die Modalitäten
            der Auswertung und Befundmitteilug im Falle des PCR-Tests
            informieren wir Sie gerne vor Ort. Bitte beachten Sie,
            dass die Tests keine 100-prozentige Exaktheit erlauben.
            Ein Testergebnis kann sowohl falsch- positiv als auch
            falschnegativ ausfallen. Gerne informieren wir Sie über
            die jeweiligen, von dem Testhersteller angegebenen,
            statistischen Wahrscheinlichkeiten eines falschen
            Ergebnisses.</p>';

            $html .= '<p style="margin-top:50px; font-weight:bold">Folgen eines positiven Befundes:</p>';

            $html .= '<p>Sofern eine akute Infektion mit SARS-CoV-2 bzw. eine
            Erkrankung an COVID-19 nachgewiesen werden sollte(n),
            handelt es sich hierbei um eine meldepflichtige Infektion/
            Krankheit nach dem Infektionsschutzgesetz. In diesem Fall
            müssen Ihre personenbezogenen Daten zusammen mit dem
            positiven Testergebnis von uns bzw. im Falle des PCR-Test
            von dem Labor verpflichtend den zuständigen
            Gesundheitsbehörden gemeldet/ übermittelt werden. Zudem
            sind wir zu einer Meldung an die jeweilige dem Probanden
            zugeordnete Institution verpflichtet. Bitte beachten Sie
            außerdem, dass Sie nach derzeitigen wissenschaftlichen
            Erkenntnissen trotz eines negativen Tests ansteckend/
            infektiös sein könnten. Unser Personal klärt Sie gerne
            weiter auf.</p>';

            $html .= '<p style="margin-top:50px; font-weight:bold">Ihre Rechte:</p>';

            $html .= '<p>Sie haben das Recht sowohl Ihre Einwilligung in die
            Durchführung der Untersuchung als auch Ihre Einwilligung
            in die hierfür erforderliche Verarbeitung Ihrer
            personenbezogenen Daten jederzeit und ohne Angabe von
            Gründen mit Wirkung für die Zukunft gegenüber uns zu
            widerrufen. Im U]brigen stehen uneingeschränkt die
            Betroffenenrechte zu, die im Zusammenhang mit der DSGVO
            garantiert sind. Nähere Informationen zu Ihren
            Betroffenenrechten können Sie den nachfolgenden Hinweisen
            zur Datenverarbeitung (Anlage 1 zur
            Einwilligungserklärung) entnehmen.</p>';

            $html .= '<p style="margin-top:50px; font-weight:bold">Ihre Erklärung:</p>';

            $html .= '<p>Ich habe den vorstehenden Text sowie die in Anlage
            befindlichen Hinweise zur Datenverarbeitung (Anlage 1 zur
            Einwilligungserklärung) gelesen, verstanden und
            akzeptiert. <br /><br />
            Durch die Unterzeichnung dieses Dokumentes erkläre ich
            mich mit den geplanten Untersuchung/en, der hierfür
            erforderlichen Proben-Entnahme, der anschließenden
            Auswertung sowie mit der Verarbeitung meiner
            personenbezogenen Daten zu diesem Zweck einverstanden und
            erteile hiermit den entsprechenden Auftrag. Ferner
            bestätige ich mit meiner Unterschrift, dass ich die
            Gelegenheit hatte, Antworten auf alle meine
            (medizinischen) Fragen zu erhalten und mir vor der
            Einwilligung ausreichend Bedenkzeit eingeräumt worden ist.
            </p>';

            $html .= 'Berlin, ______________________________ ______________________________ Ort, Datum Unterschrift';



            $html .= '<p>Anlage 1 – Hinweise zur Daten- verarbeitung</p>';

            $html .= '<p>Mit diesen Hinweisen zur Datenverarbeitung kommen wir
            unseren Informationspflichten aus Art. 12 ff. der
            Datenschutzgrundverordnung (nachfolgend „DSGVO“ genannt)
            im Zusammenhang mit der geplanten Untersuchung nach.</p>';


            $html .= '<p>§ 1 Verantwortlicher für die Datenverarbeitung</p>';
            $html .= '<p>Für die Datenverarbeitung verantwortlich ist die EG
            Consulting Hessenring 2 12101 Berlin</p>
          <p>Für Fragen zu unserem Umgang mit Ihren personenbezogenen
    Daten stehen wir Ihnen jederzeit gerne per E-Mail an
    termine@schnelltestzentrum.berlin</p>
    
    
    <p>zur Verfügung.</p>
    <p>§ 2 Datenschutzbeauftragter</p>

    <p>
      § 2 Datenschutzbeauftragter Sie haben aber auch das
      Recht, sich mit Fragen im Zusammenhang mit der
      Verarbeitung Ihrer personenbezogenen Daten sowie
      bezüglich der Wahrnehmung Ihrer Betroffenenrechte gemäß
      der DSGVO an unseren Datenschutzbeauftragten zu wenden.
      Diesen erreichen Sie unter den folgenden Kontaktdaten:
    </p>
    <p>termine@schnelltestzentrum.berlin</p>
    <p>§ 3 Verarbeitung deiner Daten</p>

    <p>
      Wenn bei Ihnen eine Speichelentnahme mit anschließendem
      Test zwecks Nachweises einer akuten SARS-
      CoV-2-Infektion/ COVID-19-Erkrankung von uns
      durchgeführt werden soll, müssen wir Ihre
      personenbezogenen Daten verarbeiten. Hiervon betroffen
      sind Ihr/e
    </p>
    <ul>
      <li>Name</li>
      <li>Geburtsdatum</li>
      <li>Anschrift und Telefonnr</li>
    </ul>
    <p>
      Die Rechtmäßigkeit dieser Datenverarbei- tung stützen
      wir auf Art. 6 Abs.1 lit.a DSGVO. Ihre ausdrückliche
      Einwilligung hierzu erklären Sie uns gegenüber durch die
      Unterzeichnung der Einverständniserklärung.
    </p>

    <p>§ 4 Datenweitergabe</p>

    <p>
      Wir werden Ihre Daten nur dann an Dritte weitergeben,
      wenn
    </p>
    <ul>
      <li>
        Sie gemäß Art. 6 Abs.1 lit.a DSGVO hierzu Ihre
        ausdrückliche Einwilligung gegeben haben;
      </li>
      <li>
        die Weitergabe gemäß Art. 6 Abs.1 lit.f DSGVO zur
        Geltendmachung, Ausübung oder Verteidigung von
        Rechtsansprüchen erforderlich ist und kein Grund zur
        Annahme besteht, dass Sie ein überwiegendes und
        schutzwürdiges Interesse an der Nichtweitergabe Ihrer
        Daten haben;
      </li>
      <li>
        wir zur Weitergabe gemäß Art. 6 Abs.1 lit.c DSGVO
        gesetzlich verpflichtet sind;
      </li>
      <li>
        die Weitergabe gemäß Art. 6 Abs.1 lit.b DSGVO für die
        Abwicklung eines
      </li>
    </ul>
    <p>Vertragsverhältnisses erforderlich ist.</p>
    <p>
      § 5 Datenspeicherung involvierten A]rztinnen und A]rzte
    </p>
    <p>
      Personenbezogene Daten, die Gesundheitsdaten sind,
      werden von den involvierten A]rztinnen und A]rzten
      grundsätzlich gemäß den gesetzlichen Vorschriften für
      die Dauer von zehn Jahren nach Abschluss der
      Untersuchung aufbewahrt.
    </p>
    <p>
      In besonderen Fällen erfolgt eine längere Aufbewahrung
      als gesetzlich angeordnet, beispielsweise bei der
      Durchsetzung von Schadensersatz-, Versicherungs- und
      Rentenansprüchen, soweit Kenntnis von diesen besteht.
      Ebenso kann auch Ihr gesundheitlicher Zustand eine über
      die gesetzlichen Fristen hinausgehende Aufbewahrung
      erforderlich machen. Da auch Ihre zivilrechtlichen
      Schadensersatzansprüche gegen die involvierten
      A]rztinnen und A]rzte gemäß § 199 Absatz 2 BGB erst nach
      30 Jahren verjähren, behalten sich die involvierten
      A]rztinnen und A]rzte gegebenenfalls vor, die Daten,
      soweit erforderlich, für die Dauer von 30 Jahren
      aufzubewahren.
    </p>
    <p>§ 6 Betroffenenrechte</p>
    <p>
      Als betroffene Person im Sinne von § 4 Nr.1 DSGVO stehen
      Ihnen in der DSGVO geregelte, unabdingbare Rechte zu
      (sog. Betroffenenrechte). Sie haben daher das Recht
    </p>
    <p>mit Ihnen</p>
    <p>durch die</p>

    <ul>
      <li>
        gemäß Art. 15 DSGVO Auskunft darüber zu verlangen,
        welche Daten wir von Ihnen gespeichert haben;
      </li>
      <li>
        gemäß Art. 16 DSGVO unverzüglich die Berichtigung oder
        Vervollständigung der Daten zu verlangen, die wir von
        Ihnen gespeichert haben;
      </li>
      <li>
        gemäß Art. 17 DSGVO die Löschung der Daten zu
        verlangen, die wir von Ihnen gespeichert haben, außer
        dem steht ein Fall von Art. 17 Abs.3 DSGVO entgegen;
      </li>
      <li>
        gemäß Art. 18 DSGVO die Einschränkung der Verarbeitung
        der Daten zu verlangen, die wir von Ihnen gespeichert
        haben, wenn die Voraussetzungen von Art. 18 Abs.1
        lit.a- d DSGVO hierfür vorliegen;
      </li>
      <li>
        gemäß Art. 20 DSGVO die hürdenfreie U]bermittlung der
        Daten zu verlangen, die wir von Ihnen gespeichert
        haben, und zwar in einem strukturierten, gängigen und
        maschinenlesbaren Format (z.B. als PDF);
      </li>
      <li>
        gemäß Art. 21 DSGVO Widerspruch gegen die Verarbeitung
        Ihrer Daten einzulegen, wenn diese von uns auf der
        Rechtsgrundlage des Art. 6 Abs.1 lit.f DSGVO
        verarbeitet werden und sich Ihr Widerspruch aus einer
        besonderen Situation ergibt oder sich gegen
        Direktwerbung richtet. Im letzteren Fall können Sie
        auch ohne jeglichen Grund Widerspruch gegen die
        Verarbeitung einlegen;
      </li>
      <li>
        gemäß Art. 7 Abs.3 DSGVO Ihre einmal erteilte
        Einwilligung in eine Datenverarbeitung zu widerrufen;
      </li>
      <li>
        gemäß Art. 77 DSGVO Beschwerde bei der zuständigen
        Aufsichtsbehörde einzureichen.
      </li>
    </ul>
    <p>
      Ihre Anfragen, Widersprüche oder Widerrufe können Sie
      jederzeit per E-Mail an
    </p>
    <p>termine@schnelltestzentrum.berlin</p>

    <p>
      oder per Post an EG Consulting Hessenring 2 12101 Berlin
      schicken. Bitte haben Sie Verständnis dafür, dass wir
      vor der Löschung oder Anpassung Ihrer Daten zunächst
      Ihre Identität durch ein hierfür geeignetes Verfahren
      sicherstellen müssen.
    </p>

    <p>§ 7 Speicherort und Einbindung von Dienstleistern</p>

    <p>
      Ihre Daten werden ausschließlich in Rechenzentren
      innerhalb der Europäischen Union gespeichert und
      verarbeitet. Wir behalten uns dabei das Recht vor, uns
      zur Speicherung und Verarbeitung Ihrer Daten
      verschiedener Dienstleister zu bedienen, die jedoch
      ausschließlich in unserem Auftrag und gemäß unseren
      Weisungen tätig werden. Wir werden die von uns
      eingesetzten Dienstleister dazu verpflichten, technische
      und organisatorische Maßnahmen zu ergreifen, die nach
      dem aktuellen Stand der Technik dazu geeignet sind, eine
      datenschutzkonforme Verarbeitung Ihrer Daten
      sicherzustellen. Ihre Daten werden keinesfalls von
      unseren Dienstleistern an Dritte weitergegeben oder
      veräußert. Für die Verarbeitung ihrer Daten arbeiten wir
      insbesondere mit folgenden Dienstleistern zusammen:
    </p>
    <p>
      Anbieter von Dienstleistungen für IT- Service, Hosting
      und Infrastruktur:
    </p>
    <p>
      Telekom Deutschland GmbH Landgrabenweg 151 53227 Bonn
    </p>
    <p>Dienstleister für Labordienst- leistungen:</p>
    <p>§ 8 A]nderungen dieser Hinweise</p>
    <p>
      Wir behalten uns das Recht vor, diese Hinweise zur
      Datenverarbeitung jederzeit mit Wirkung für die Zukunft
      anzupassen, um auf Gesetzesänderungen, A]nderungen der
      Rechtsprechung oder A]nderungen der wirtschaftlichen
      Lage zu reagieren. Ihre Betroffenenrechte werden durch
      eine A]nderung dieser Hinweise zur Datenverarbeitung
      keinesfalls eingeschränkt.
    </p>';

            $mpdf->WriteHTML($html);

            // $mpdf->WriteFixedPosHTML($html, 5, 8, 200,  'auto');

            $mpdf->Output('public/pdf/covid_test/' . $pdf_name, 'F');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }
}
