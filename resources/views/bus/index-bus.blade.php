@extends('layouts.app')
@section('title', 'Bus Booking Search')
@section('pagetitle', 'Bus Booking Search')


@section('content')
<main>

<!-- =======================
Main Banner START -->
<section class="pt-0">
	<div class="container">
		<!-- Background image -->
		<div class="rounded-3 p-3 p-sm-5" style="background-image: url({{ asset('images/bg/05.jpg') }}); background-position: center center; background-repeat: no-repeat; background-size: cover;">
			<!-- Banner title -->
			<div class="row my-2 my-xl-5">
				<div class="col-md-12 mx-auto">
					<h1 class="text-center text-white">Find Your Bus Ticket</h1>
					<!-- Form START -->
					<form class="bg-mode shadow rounded-3 position-relative p-4 pe-md-5 pb-5 pb-md-4 mb-4">
						<div class="row g-4">
							<!-- From -->
							<div class="col-lg-6">
								<div class="form-control-border form-control-transparent form-fs-md d-flex">
									<!-- Icon -->
									<i class="bi bi-geo-alt fs-3 me-2 mt-2"></i>
									<!-- Select input -->
									<div class="flex-grow-1">
										<label class="form-label">From</label>
										<select class="form-select js-choice" data-search-enabled="true">
											<option value="">Select location</option>
											<option>Mumbai</option>
											<option>Delhi</option>
											<option>Bangalore</option>
											<option>Hyderabad</option>
											<option>Chennai</option>
											<option>Kolkata</option>
										</select>
									</div>
								</div>
							</div>

							<!-- To -->
							<div class="col-lg-6">
								<div class="form-control-border form-control-transparent form-fs-md d-flex">
									<!-- Icon -->
									<i class="bi bi-geo-alt fs-3 me-2 mt-2"></i>
									<!-- Select input -->
									<div class="flex-grow-1">
										<label class="form-label">To</label>
										<select class="form-select js-choice" data-search-enabled="true">
											<option value="">Select location</option>
											<option>Mumbai</option>
											<option>Delhi</option>
											<option>Bangalore</option>
											<option>Hyderabad</option>
											<option>Chennai</option>
											<option>Kolkata</option>
										</select>
									</div>
								</div>
							</div>

							<!-- Journey date -->
							<div class="col-lg-4">
								<div class="form-control-border form-control-transparent form-fs-md d-flex">
									<!-- Icon -->
									<i class="bi bi-calendar fs-3 me-2 mt-2"></i>
									<!-- Date input -->
									<div class="flex-grow-1">
										<label class="form-label">Journey Date</label>
										<input type="text" class="form-control flatpickr" data-date-format="d/m/Y" placeholder="Select date">
									</div>
								</div>
							</div>

							<!-- Return date -->
							<div class="col-lg-4">
								<div class="form-control-border form-control-transparent form-fs-md d-flex">
									<!-- Icon -->
									<i class="bi bi-calendar fs-3 me-2 mt-2"></i>
									<!-- Date input -->
									<div class="flex-grow-1">
										<label class="form-label">Return Date (Optional)</label>
										<input type="text" class="form-control flatpickr" data-date-format="d/m/Y" placeholder="Select date">
									</div>
								</div>
							</div>

							<!-- Passenger -->
							<div class="col-lg-4">
								<div class="form-control-border form-control-transparent form-fs-md d-flex">
									<!-- Icon -->
									<i class="bi bi-person fs-3 me-2 mt-2"></i>
									<!-- Dropdown input -->
									<div class="flex-grow-1">
										<label class="form-label">Passengers</label>
										<select class="form-select js-choice">
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
											<option>5</option>
											<option>6</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<!-- Button -->
						<div class="btn-position-md-middle">
							<a class="icon-lg btn btn-round btn-primary mb-0" href=""><i class="bi bi-search fa-fw"></i></a>
						</div>
					</form>
					<!-- Form END -->
				</div>
			</div>
		</div>
	</div>
</section>
</main>

<!-- Back to top -->
<div class="back-top"></div>

@endsection