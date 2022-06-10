<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Schnelltestzentrum Berlin</title>

    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <div class="py-5 text-center">
            <h2>CITY CORONA</h2>
            <p class="lead">...</p>

            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')) : ?>
                <div class="alert alert-error"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
        </div>

        <?php echo form_open(base_url() . 'covid_test_form/add', array('class' => 'needs-validation', 'novalidate' => 'novalidate')); ?>

        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Registrierdetails</h4>
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="gender">Geschlecht</label>
                        <select class="form-control" name="gender">
                            <option value="männlich">Männlich</option>
                            <option value="weiblich">Weiblich</option>
                        </select>
                        <div class="invalid-feedback">
                        Geschlecht ist ein Pflichtfeld.
                        </div>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="firstname">Vorname</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="" required>
                        <div class="invalid-feedback">
                            Vorname ist ein Pflichtfeld.
                        </div>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="lastname">Nachname</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="" required>
                        <div class="invalid-feedback">
                            Nachname ist ein Pflichtfeld.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <p>Land / Region <span class="text-danger">*</span> <br> Deutschland</p>
                    <label for="street">Straße + Hausnummer <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="street" id="street" placeholder="Straßenname und Hausnummer" required>
                    <div class="invalid-feedback">
                        Straße + Hausnummer ist ein Pflichtfeld.
                    </div>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="street_optional" id="street_optional" placeholder="Wohnung, Suite, Zimmer usw. (optional)">
                </div>
                <div class="mb-3">
                    <label for="ort_city">Ort / Stadt <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="ort_city" id="billing_ort_city" placeholder="Straßenname und Hausnummer" required>
                    <div class="invalid-feedback">
                        Ort / Stadt ist ein Pflichtfeld.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="postcode">Postleitzahl <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="postcode" id="postcode" placeholder="" required>
                    <div class="invalid-feedback">
                        Postleitzahl ist ein Pflichtfeld.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="telefon">Telefon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="telefon" id="telefon" placeholder="" required>
                    <div class="invalid-feedback">
                        Telefon ist ein Pflichtfeld.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="birthday">Geburtstag <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="birthday" id="birthday" placeholder="" required>
                    <div class="invalid-feedback">
                        Geburtstag ist ein Pflichtfeld.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email">E-mail <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" required>
                    <div class="invalid-feedback">
                        E-Mail-Adresse ist keine gültige E-Mail-Adresse.
                    </div>
                </div>
                <h2 class="text-warning">Bei Symptomen kontaktieren Sie bitte Ihren Hausarzt.</h2>
                <p>Pflichtfeld <span class="text-danger">*</span></p>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="required_data" required>
                    <label class="custom-control-label" for="required_data">Alle meine Daten entsprechen der Wahrheit</label>
                </div>
            </div>
        </div>

        <div class="h-100 mt-3 bg-light border rounded-3">
            <div class="container-fluid py-4">
                <h6 class="display-5 fw-bold">Die Bezahlung findet vor Ort statt.</h6>
                <hr class="my-4">
                <p class="col-md-12 fs-4">Wir verwenden deine personenbezogenen Daten, um deine Registrierung durchführen zu können, eine möglichst gute Benutzererfahrung auf dieser Website zu ermöglichen und für weitere Zwecke, die in unserer Datenschutzerklärung beschrieben sind.</p>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save-info" required>
                    <label class="custom-control-label" for="save-info"> Hiermit stimme ich dem Behandlungsvertrag zu. <span class="text-danger">*</span></label>
                </div>

                <button class="btn btn-primary btn-lg btn-block mt-5" type="submit" name="CovidTestForm">Jetzt registrieren</button>
            </div>
        </div>
        <?php echo form_close(); ?>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2021 Schnelltestzentrum Berlin</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Impressum</a></li>
                <li class="list-inline-item"><a href="#">Datenschutz</a></li>
            </ul>
        </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';

            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');

                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>