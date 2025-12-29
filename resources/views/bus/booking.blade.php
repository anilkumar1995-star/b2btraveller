@extends('layouts.base')

@section('content')
<!-- **************** MAIN CONTENT START **************** -->
<main>

<!-- =======================
Bus booking form START -->
<section class="pt-4">
	<div class="container">
		<div class="row g-4">
			<!-- Left side content START -->
			<div class="col-lg-8">
				<div class="card shadow p-3">
					<!-- Card header -->
					<div class="card-header border-bottom p-3">
						<h4 class="card-title mb-0">Bus Details</h4>
					</div>

					<!-- Card body START -->
					<div class="card-body">
						<!-- Bus info START -->
						<div class="row g-4">
							<!-- Bus image -->
							<div class="col-md-3">
								<img src="{{ asset('images/category/bus/03.svg') }}" class="rounded-2" alt="">
							</div>

							<!-- Bus info -->
							<div class="col-md-9">
								<h5 class="card-title mb-1">Sharma Travels - AC Sleeper</h5>
								<ul class="nav nav-divider align-items-center small mb-2">
									<li class="nav-item">Mumbai to Pune</li>
									<li class="nav-item">4 hrs journey</li>
								</ul>

								<ul class="nav nav-divider align-items-center small">
									<li class="nav-item">
										<div class="d-flex align-items-center">
											<i class="bi bi-clock-fill"></i>
											<span class="ms-2">5:00 AM - 9:00 AM</span>
										</div>
									</li>
									<li class="nav-item">29 Nov 2023</li>
								</ul>
							</div>
						</div>
						<!-- Bus info END -->

						<hr> <!-- Divider -->

						<!-- Seat selection START -->
						<div class="row">
							<div class="col-12">
								<h5 class="mb-3">Select Seats</h5>
								
								<!-- Bus layout -->
								<div class="row g-4">
									<!-- Seat map -->
									<div class="col-md-8">
										<div class="card bg-light p-3">
											<!-- Driver section -->
											<div class="text-center mb-4">
												<i class="bi bi-truck fs-1"></i>
												<div class="small">Driver</div>
											</div>

											<!-- Seats grid -->
											<div class="row g-2">
												<!-- Left side -->
												<div class="col-6">
													<div class="row g-2">
														@for ($i = 1; $i <= 15; $i++)
														<div class="col-4">
															<input type="checkbox" class="btn-check" id="seat-{{ $i }}">
															<label class="btn btn-light btn-primary-soft-check" for="seat-{{ $i }}">
																<i class="bi bi-chair-fill"></i>
																<span class="small d-block">{{ $i }}</span>
															</label>
														</div>
														@endfor
													</div>
												</div>

												<!-- Right side -->
												<div class="col-6">
													<div class="row g-2">
														@for ($i = 16; $i <= 30; $i++)
														<div class="col-4">
															<input type="checkbox" class="btn-check" id="seat-{{ $i }}">
															<label class="btn btn-light btn-primary-soft-check" for="seat-{{ $i }}">
																<i class="bi bi-chair-fill"></i>
																<span class="small d-block">{{ $i }}</span>
															</label>
														</div>
														@endfor
													</div>
												</div>
											</div>
										</div>
									</div>

									<!-- Seat info -->
									<div class="col-md-4">
										<div class="card bg-light p-3">
											<h6 class="mb-3">Seat Info</h6>
											<ul class="list-unstyled mb-0">
												<li class="mb-3">
													<i class="bi bi-chair-fill text-success me-2"></i>Available
												</li>
												<li class="mb-3">
													<i class="bi bi-chair-fill text-danger me-2"></i>Booked
												</li>
												<li>
													<i class="bi bi-chair-fill text-primary me-2"></i>Selected
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Seat selection END -->

						<hr> <!-- Divider -->

						<!-- Passenger details START -->
						<div class="row">
							<div class="col-12">
								<h5 class="mb-3">Passenger Details</h5>
								
								<!-- Form START -->
								<form class="row g-4">
									<!-- Name -->
									<div class="col-md-6">
										<label class="form-label">First Name</label>
										<input type="text" class="form-control" placeholder="Enter first name">
									</div>
									
									<div class="col-md-6">
										<label class="form-label">Last Name</label>
										<input type="text" class="form-control" placeholder="Enter last name">
									</div>

									<!-- Email -->
									<div class="col-md-6">
										<label class="form-label">Email</label>
										<input type="email" class="form-control" placeholder="Enter email">
									</div>

									<!-- Phone -->
									<div class="col-md-6">
										<label class="form-label">Phone Number</label>
										<input type="text" class="form-control" placeholder="Enter phone number">
									</div>
								</form>
								<!-- Form END -->
							</div>
						</div>
						<!-- Passenger details END -->
					</div>
					<!-- Card body END -->
				</div>
			</div>
			<!-- Left side content END -->

			<!-- Right side content START -->
			<div class="col-lg-4">
				<div class="card shadow">
					<!-- Card header -->
					<div class="card-header border-bottom p-3">
						<h4 class="card-title mb-0">Fare Summary</h4>
					</div>

					<!-- Card body START -->
					<div class="card-body p-3">
						<ul class="list-group list-group-borderless">
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span>Selected Seats</span>
								<span class="h6 mb-0">2</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span>Base Fare (₹800 x 2)</span>
								<span class="h6 mb-0">₹1,600</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span>Tax & Service Fee</span>
								<span class="h6 mb-0">₹200</span>
							</li>
							<li class="list-group-item h5 d-flex justify-content-between align-items-center fw-bold mb-0">
								<span>Total Amount</span>
								<span>₹1,800</span>
							</li>
						</ul>
					</div>
					<!-- Card body END -->

					<!-- Card footer -->
					<div class="card-footer p-3">
						<div class="d-grid gap-2">
							<a href="#" class="btn btn-primary mb-0">Proceed to Payment</a>
						</div>
					</div>
				</div>
			</div>
			<!-- Right side content END -->
		</div>
	</div>
</section>
<!-- =======================
Bus booking form END -->

</main>
<!-- **************** MAIN CONTENT END **************** -->
@endsection