<footer id="footer" class="border-0 bg-dark mt-0">
				<div class="container-fluid px-0">
					<div class="row">
						<div class="col-lg-4 px-0">
							<div id="googlemaps" class="google-map h-100 m-0" style="min-height: 450px;"></div>
						</div>
						<div class="col-m-6 col-lg-4 px-0">
							<div class="card bg-secondary border-0 h-100">
								<div class="card-body text-center p-5 my-3">
									<img src="<?php echo base_url('public/layout/' . $theme . '/img/demos/barber/bar-sm.png'); ?>" class="img-fluid position-relative bottom-2 d-none d-xl-inline-block" alt="" />
									<span class="text-color-light font-weight-semibold text-4 mx-2">SCHAHHAIRDESIGN</span>
									<img src="<?php echo base_url('public/layout/' . $theme . '/img/demos/barber/bar-sm.png'); ?>" class="img-fluid position-relative bottom-2 d-none d-xl-inline-block" alt="" />

									<h2 class="font-weight-semibold text-color-light line-height-1 custom-fs1 ls-0 mb-3">SCHAHHAIRDESIGN</h2>
									<div class="bg-primary d-inline-flex custom-side-dots custom-side-dots-outside py-2 px-4">
										<span class="text-color-light">BERLIN</span>
										<span class="vertical-divider mx-3 border-color-light opacity-3 my-1"></span>
										<span class="text-color-light">2022</span>
									</div>
									<hr class="bg-primary mt-5 mb-4">
									<ul class="list list-unstyled text-color-light font-weight-semibold custom-fs-1 py-2 m-0">
										<li><?php echo $setting['footer_address']; ?></li>
										<li class="mb-0"><a href="mailto:<?php echo $setting['footer_email']; ?>?subject=Kontakt&body=your messsage" class="text-color-light"><?php echo $setting['footer_email']; ?></a></li>
									</ul>
									<hr class="bg-primary mt-4 mb-4">
									<h3 class="text-color-dark font-weight-bold custom-tertiary-font text-5 mb-5">So erreichen Sie uns</h3>
									<span class="text-color-light custom-primary-font font-weight-bold text-10"><?php echo $setting['footer_phone']; ?></span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-4 px-0 d-flex align-items-center">
							<div class="w-100 p-5 mx-3 my-5">
								<h3 class="text-color-primary font-weight-bold negative-ls-05 custom-side-dots custom-side-dots-rm-right text-8 mb-3">Kontaktiere uns</h3>
								<p class="font-weight-semibold text-3 pb-3 mb-4">Haben Sie Fragen oder einen Terminwunsch? Nehmen Sie Kontakt mit uns auf:</p>
								<form class="contact-form form-style-4 form-errors-light custom-form-style-1" method="POST">
									<input type="hidden" value="Contact Form" name="subject" id="subject">
									<div class="form-group col-lg-12 ms-auto my-0">
										<div class="contact-form-success alert alert-success d-none">
											Message has been sent to us.
										</div>

										<div class="contact-form-error alert alert-danger d-none">
											Error sending your message.
											<span class="mail-error-message text-1 d-block"></span>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-lg-6">
											<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control py-2" placeholder="Name" name="name" id="name" required>
										</div>
										<div class="form-group col-lg-6">
											<input type="text" value="" data-msg-required="Please enter your phone number." maxlength="100" class="form-control py-2" placeholder="Phone" name="phone" id="phone" required>
										</div>
									</div>
									<div class="row">
										<div class="form-group col">
											<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control py-2" placeholder="E-mail" name="email" id="email" required>
										</div>
									</div>
									<div class="row">
										<div class="form-group col">
											<textarea maxlength="5000" data-msg-required="Please enter your message." rows="4" class="form-control" placeholder="Message" name="message" id="message" required></textarea>
										</div>
									</div>
									<input type="submit" value="Senden" class="custom-btn-style-1 btn btn-dark font-weight-bold text-uppercase btn-px-5 py-3" data-loading-text="Loading...">
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="footer-copyright bg-dark py-5">
					<div class="container py-2">
						<div class="row py-4">
							<div class="col-12 text-center">
								<ul class="social-icons social-icons-clean social-icons-icon-light mb-2">
                                    <?php foreach ($social as $row_social): ?>
                                        <?php if ($row_social['social_url'] != ''): ?>
									        <li class="social-icons-<?php echo $row_social['social_name']; ?>"><a href="<?php echo $row_social['social_url']; ?>" target="_blank" title="<?php echo $row_social['social_name']; ?>"><i class="fab fa-<?php echo strtolower($row_social['social_name']); ?>"></i></a></li>
                                        <?php endif;?>
                                    <?php endforeach;?>
								</ul>
							</div>
							<div class="col-9">
								<p class="text-color-light font-weight-light opacity-4 mb-0">© 2022 SCHAHHAIRDESIGN Alle Rechte vorbehalten.</p>
							</div>
							<div class="col-3">
								<p class="text-color-white font-weight-bold text-3 mb-0 ">
                                    <a href="#" class="getPage" data-page="impressum">Impressum</a>
                                    |
                                    <a href="#" class="getPage" data-page="datenschutz">Datenschutz</a>
                                </p>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="largeModalLabel">Large Modal Title</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque neque eget diam posuere porta. Quisque ut nulla at nunc <a href="#">vehicula</a> lacinia. Proin adipiscing porta tellus, ut feugiat nibh adipiscing sit amet. In eu justo a felis faucibus ornare vel id metus. Vestibulum ante ipsum primis in faucibus.</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque neque eget diam posuere porta. Quisque ut nulla at nunc <a href="#">vehicula</a> lacinia. Proin adipiscing porta tellus, ut feugiat nibh adipiscing sit amet. In eu justo a felis faucibus ornare vel id metus. Vestibulum ante ipsum primis in faucibus.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Vendor -->
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/jquery.appear/jquery.appear.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/jquery.cookie/jquery.cookie.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/jquery.validation/jquery.validate.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/jquery.gmap/jquery.gmap.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/lazysizes/lazysizes.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/isotope/jquery.isotope.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/vide/jquery.vide.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/vivus/vivus.min.js"></script>
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/vendor/instafeed/instafeed.min.js"></script>

		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/js/theme.js"></script>

		<!-- Current Page Vendor and Views -->
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/js/views/view.contact.js"></script>

		<!-- Demo -->
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/js/demos/demo-barber.js"></script>

		<!-- Theme Custom -->
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/js/custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="<?php echo base_url(); ?>public/layout/<?php echo $theme; ?>/js/theme.init.js"></script>


    <script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>

		<script>

			/*
			Map Settings

				Find the Latitude and Longitude of your address:
					- https://www.latlong.net/
					- http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/

			*/

			function initializeGoogleMaps() {
				// Map Markers
				var mapMarkers = [{
					address: "Krumme Str. 50 10627 Berlin",
					html: "<strong>Krumme Str. 50</strong><br>10627, Berlin",
					icon: {
						image: "<?php echo base_url('public/layout/' . $theme . '/img/pin-light.png'); ?>",
						iconsize: [26, 46],
						iconanchor: [12, 46]
					},
					popup: false
				}];

				// Map Initial Location
				var initLatitude = 52.5068713;
				var initLongitude = 13.3120979;

				// Map Extended Settings
				var mapSettings = {
					controls: {
						draggable: (($.browser.mobile) ? false : true),
						panControl: false,
						zoomControl: false,
						mapTypeControl: false,
						scaleControl: false,
						streetViewControl: false,
						overviewMapControl: false
					},
					scrollwheel: false,
					markers: mapMarkers,
					latitude: initLatitude,
					longitude: initLongitude,
					zoom: 12
				};

				var map = $('#googlemaps').gMap(mapSettings),
					mapRef = $('#googlemaps').data('gMap.reference');

				// Styles from https://snazzymaps.com/
				var styles = [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}];

				var styledMap = new google.maps.StyledMapType(styles, {
					name: 'Styled Map'
				});

				mapRef.mapTypes.set('map_style', styledMap);
				mapRef.setMapTypeId('map_style');
			}

			// Initialize Google Maps when element enter on browser view
			theme.fn.intObs( '.google-map', 'initializeGoogleMaps()', {} );

			// Map text-center At
			var mapCenterAt = function(options, e) {
				e.preventDefault();
				$('#googlemaps').gMap("centerAt", options);
			}

		</script>

	</body>
</html>
