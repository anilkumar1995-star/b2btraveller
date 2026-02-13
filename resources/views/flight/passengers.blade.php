@extends('layouts.app')
@section('title', 'Passenger Details')
@section('pagetitle', 'Passenger Details')

@push('style')
    <style>
        .passenger-form-card {
            margin-bottom: 1.5rem;
        }

        .passenger-form-card .card-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .passenger-form-card .card-header h6 {
            margin-bottom: 0;
            font-weight: 600;
            color: #333;
        }

        .passenger-form-card .badge {
            font-size: 0.85rem;
            padding: 0.4rem 0.7rem;
        }

        .passenger-form-card .card-body {
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .required-field {
            border-left: 3px solid #dc3545;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
        }

        #passengerFormsContainer {
            margin-top: 1.5rem;
        }

        .btn-primary:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .text-muted.small {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.85rem;
        }

        .row.g-3 {
            margin-top: 1rem;
        }

        .row.g-3.mt-2 {
            margin-top: 1rem;
        }

        /* Disabled option styling */
        .form-select:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* Selected customer label after select */
        .customer-selector-wrapper {
            position: relative;
        }

        .customer-selector-badge {
            display: inline-block;
            font-size: 0.75rem;
            background-color: #198754;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            margin-left: 0.5rem;
            font-weight: 600;
        }

        /* Disabled option in dropdown */
        .form-select option:disabled {
            background-color: #e9ecef;
            color: #999;
        }

        /* Highlight selected option */
        .customer-selector.selected-highlight {
            border: 2px solid #28a745;
            background-color: #f0f8f5;
        }

        /* Select2 custom styling */
        .select2-container--default .select2-selection--single {
            border-color: #ced4da;
            height: 38px;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .select2-dropdown {
            border-color: #ced4da;
        }

        .select2-results__option--highlighted[aria-selected] {
            background-color: #0d6efd;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@section('content')

    <main>
        <section>
            <div class="card border">
                <div class="card-header border-bottom bg-light">
                    <h5 class="card-title mb-0">
                        ✈️ Enter Passenger Details
                        <span class="badge bg-info ms-2 passenger-badge">0 Passengers</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning mt-3" role="alert">
                        <strong>⚠️ Important:</strong> Please enter passenger details exactly as they appear in your
                        passport.
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

                        <br/>
                        Canada: If Last Name is missing → use “LNU”. If First Name is missing → use “FNU”. Example:
                        LNU/JEREMY MR, SMITH/FNU MR.
                        <br /> UAE: Single-name passports not accepted. If only one full name → Last Name = full name, First
                        Name = “FNU”. Example: MARYAM ALI/FNU MS.
                        <br />Australia/NZ: If only one name → repeat for both. Example: JONES/JONES MR.
                    </div>

                    <form id="passengerDetailsForm">
                        <div id="passengerFormsContainer"></div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitPassengersBtn">
                                <i class="ti ti-arrow-right me-2"></i>Proceed to Flight Details
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </main>

@endsection


@push('script')
    <script>
        // Global variable to store customers from server
        let allCustomers = @json($customers ?? []);

        $(document).ready(function() {
            let flightDetails = JSON.parse(localStorage.getItem('selectedFlightDetails')) || {};
            let payload = JSON.parse(localStorage.getItem('payload')) || {};

            // Get passenger count from search payload
            function getPassengerCount() {
                return {
                    adults: parseInt(payload.AdultCount) || 1,
                    children: parseInt(payload.ChildCount) || 0,
                    infants: parseInt(payload.InfantCount) || 0,
                    total: (parseInt(payload.AdultCount) || 1) + (parseInt(payload.ChildCount) || 0) + (parseInt(
                        payload.InfantCount) || 0)
                };
            }

            let passengers = getPassengerCount();

            // Update passenger badge
            $('.passenger-badge').text(passengers.total + ' Passengers');

            // Check if we have flight details and payload
            if (!flightDetails || Object.keys(flightDetails).length === 0) {
                $('#passengerFormsContainer').html(
                    '<div class="alert alert-danger">Error: Flight details not found. Please go back and select a flight.</div>'
                );
                return;
            }

            if (!payload || Object.keys(payload).length === 0) {
                $('#passengerFormsContainer').html(
                    '<div class="alert alert-danger">Error: Search payload not found. Please go back and search for flights.</div>'
                );
                return;
            }

            // Load and display passenger forms
            loadPassengerForms(flightDetails);

            // Handle form submission
            $(document).on('submit', '#passengerDetailsForm', function(e) {
                e.preventDefault();
                savePassengerData();
            });
        });

        // Load and create passenger forms
        async function loadPassengerForms(flightDetails) {
            let passengers = getPassengerCount();

            // Extract flight requirements
            let flightRequirements = {
                IsPanRequiredAtBook: (flightDetails?.IsPanRequiredAtBook || flightDetails?.IsPanRequiredAtTicket) ||
                    false,
                IsPassportRequiredAtBook: (flightDetails?.IsPassportRequiredAtBook || flightDetails
                    ?.IsPassportRequiredAtTicket) || false
            };

            let formHtml = '';
            let globalIndex = 1;

            // Create forms for each passenger type
            for (let i = 1; i <= passengers.adults; i++) {
                formHtml += await createPassengerForm('Adult', i, globalIndex, flightRequirements);
                globalIndex++;
            }
            for (let i = 1; i <= passengers.children; i++) {
                formHtml += await createPassengerForm('Child', i, globalIndex, flightRequirements);
                globalIndex++;
            }
            for (let i = 1; i <= passengers.infants; i++) {
                formHtml += await createPassengerForm('Infant', i, globalIndex, flightRequirements);
                globalIndex++;
            }

            $('#passengerFormsContainer').html(formHtml);

            // Attach event handlers
            attachPassengerFormHandlers();
            
            // Initialize Select2 for customer selectors
            initializeSelect2();
        }

        // Initialize Select2 for customer selectors
        function initializeSelect2() {
            $('.customer-selector').select2({
                placeholder: "Search customer...",
                width: '100%',
                allowClear: false,
                minimumInputLength: 0,
                matcher: function(params, data) {
                    // Custom matcher for better search
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    var term = params.term.toLowerCase();
                    var matchText = data.text.toLowerCase();

                    if (matchText.indexOf(term) > -1) {
                        return $.extend({}, data, {
                            selected: false
                        });
                    }

                    return null;
                }
            });
        }

        // Create passenger form card (same as modal version)
        async function createPassengerForm(type, index, globalIndex, flightRequirements) {
            // Use allCustomers from server instead of loading from API
            let customers = allCustomers || [];

            // Check if PAN is required at booking OR at ticket
            let panRequired = (flightRequirements?.IsPanRequiredAtBook || flightRequirements?.IsPanRequiredAtTicket) ||
                false;

            // Check if Passport is required at booking OR at ticket
            let passportRequired = (flightRequirements?.IsPassportRequiredAtBook || flightRequirements
                ?.IsPassportRequiredAtTicket) || false;

            let customerOptions = '<option value="">Select 2</option>';
            let addressOptions = '<option value="">Select Saved Address (Optional)</option>';

            if (customers && customers.length > 0) {
                customers.forEach(customer => {
                    // Address selector options
                    let fullAddress = (customer.address1 || '') + (customer.address2 ? ', ' + customer
                        .address2 : '') + (customer.address3 ? ', ' + customer.address3 : '');
                    addressOptions +=
                        `<option value="${customer.id}" data-address1="${customer.address1 || ''}" data-address2="${customer.address2 || ''}" data-address3="${customer.address3 || ''}">${fullAddress || 'No address'}</option>`;

                    // Customer selector options
                    customerOptions += `<option value="${customer.id}" data-firstname="${customer.first_name || ''}" data-lastname="${customer.last_name || ''}" data-email="${customer.email || ''}" data-phone="${customer.phone || ''}" data-dob="${customer.dob || ''}" data-gender="${customer.gender || ''}" data-nationality="${customer.nationality || ''}" data-address1="${customer.address1 || ''}" data-address2="${customer.address2 || ''}" data-address3="${customer.address3 || ''}" data-panno="${customer.pan_number || ''}" data-passportno="${customer.passport_number || ''}" data-passportexpiry="${customer.passport_expiry || ''}">
                    ${customer.first_name || ''} ${customer.last_name || ''} (${customer.email || customer.phone || 'N/A'})
                </option>`;
                });
            }

            // Build passport fields HTML (only if required)
            let passportFields = '';
            if (passportRequired) {
                passportFields = `
                        <div class="col-md-4">
                            <label class="form-label">Passport Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control passenger-field required-field" name="passportNo" data-passenger-index="${globalIndex}" placeholder="Passport number">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Passport Expiry <span class="text-danger">*</span></label>
                            <input type="date" class="form-control passenger-field required-field" name="passportExpiry" data-passenger-index="${globalIndex}">
                        </div>`;
            } else {
                passportFields = `
                        <div class="col-md-4">
                            <label class="form-label">Passport Number</label>
                            <input type="text" class="form-control passenger-field" name="passportNo" data-passenger-index="${globalIndex}" placeholder="Passport number">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Passport Expiry</label>
                            <input type="date" class="form-control passenger-field" name="passportExpiry" data-passenger-index="${globalIndex}">
                        </div>`;
            }

            // Build PAN field HTML (apply to all passengers if required)
            let panField = '';
            if (panRequired) {
                panField = `<div class="col-md-4">
                            <label class="form-label">PAN Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control passenger-field required-field" name="panNo" data-passenger-index="${globalIndex}" placeholder="PAN number">
                        </div>`;
            } else {
                panField = `<div class="col-md-4">
                            <label class="form-label">PAN Number</label>
                            <input type="text" class="form-control passenger-field" name="panNo" data-passenger-index="${globalIndex}" placeholder="PAN number">
                        </div>`;
            }

            return `
            <div class="card border mb-3 passenger-form-card" data-passenger-index="${globalIndex}" data-passenger-type="${type}">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0">
                        <span class="badge bg-primary me-2">${type} ${index}</span>
                        <span class="text-muted small">#${globalIndex}</span>
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Customer & Address Selector Row -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6 customer-selector-wrapper">
                            <label class="form-label">Select 2 <span class="text-danger">*
                            <select class="form-select customer-selector" data-passenger-index="${globalIndex}">
                                ${customerOptions}
                            </select>
                            <small class="text-muted d-block mt-1">Auto-fills passenger details</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Select Saved Address <span class="text-muted">(Optional)</span></label>
                            <select class="form-select address-selector" data-passenger-index="${globalIndex}">
                                ${addressOptions}
                            </select>
                            <small class="text-muted d-block mt-1">Fills address fields only</small>
                        </div>
                    </div>

                    <!-- Name & Title Row -->
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <select class="form-select passenger-field required-field" name="titleName" data-passenger-index="${globalIndex}">
                                <option value="">Select</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Mstr">Mstr (Male Infant)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control passenger-field required-field" name="firstname" data-passenger-index="${globalIndex}" placeholder="First name">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control passenger-field required-field" name="lastname" data-passenger-index="${globalIndex}" placeholder="Last name">
                        </div>
                    </div>

                    <!-- DOB, Gender, Nationality Row -->
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label class="form-label">Date Of Birth</label>
                            <input type="date" class="form-control passenger-field" name="dob" data-passenger-index="${globalIndex}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select passenger-field required-field" name="gender" data-passenger-index="${globalIndex}">
                                <option value="">Select</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nationality <span class="text-danger">*</span></label>
                            <select class="form-select passenger-field required-field" name="nationality" data-passenger-index="${globalIndex}">
                                <option value="">Select</option>
                                <option value="IN">Indian</option>
                                <option value="US">American</option>
                                <option value="GB">British</option>
                            </select>
                        </div>
                    </div>

                    <!-- Address Row -->
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label class="form-label">Address 1 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control passenger-field required-field" name="address1" data-passenger-index="${globalIndex}" placeholder="Address 1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Address 2</label>
                            <input type="text" class="form-control passenger-field" name="address2" data-passenger-index="${globalIndex}" placeholder="Address 2">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Address 3 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control passenger-field required-field" name="address3" data-passenger-index="${globalIndex}" placeholder="Address 3">
                        </div>
                    </div>

                    <!-- Passport & PAN Row (Conditional) -->
                    <div class="row g-3 mt-2">
                        ${passportFields}
                        ${panField}
                    </div>
                </div>
            </div>
        `;
        }

        // Attach event handlers for passenger form
        function attachPassengerFormHandlers() {
            // Handle customer selection for each passenger
            $(document).off('change', '.customer-selector').on('change', '.customer-selector', function() {
                let selectedOption = $(this).find('option:selected');
                let passengerIndex = $(this).data('passenger-index');
                let selectedCustomerId = selectedOption.val();

                if (selectedCustomerId) {
                    // Auto-fill passenger data from selected customer
                    let passengerFormCard = $(`.passenger-form-card[data-passenger-index="${passengerIndex}"]`);

                    passengerFormCard.find('input[name="firstname"]').val(selectedOption.data('firstname'))
                        .change();
                    passengerFormCard.find('input[name="lastname"]').val(selectedOption.data('lastname')).change();
                    passengerFormCard.find('input[name="dob"]').val(selectedOption.data('dob')).change();
                    passengerFormCard.find('select[name="gender"]').val(selectedOption.data('gender')).change();
                    passengerFormCard.find('select[name="nationality"]').val(selectedOption.data('nationality'))
                        .change();
                    passengerFormCard.find('input[name="address1"]').val(selectedOption.data('address1')).change();
                    passengerFormCard.find('input[name="address2"]').val(selectedOption.data('address2')).change();
                    passengerFormCard.find('input[name="address3"]').val(selectedOption.data('address3')).change();
                    passengerFormCard.find('input[name="passportNo"]').val(selectedOption.data('passportno'))
                        .change();
                    passengerFormCard.find('input[name="passportExpiry"]').val(selectedOption.data(
                        'passportexpiry')).change();
                    passengerFormCard.find('input[name="panNo"]').val(selectedOption.data('panno')).change();

                    // Disable this customer option in all other passenger forms
                    disableSelectedCustomerInOtherForms(selectedCustomerId, passengerIndex);

                    notify(`Customer details auto-filled for ${selectedOption.text()}`, 'success');
                }
            });

            // Handle address selection for each passenger (fills only address fields)
            $(document).off('change', '.address-selector').on('change', '.address-selector', function() {
                let selectedOption = $(this).find('option:selected');
                let passengerIndex = $(this).data('passenger-index');

                if (selectedOption.val()) {
                    // Auto-fill only address fields from selected address
                    let passengerFormCard = $(`.passenger-form-card[data-passenger-index="${passengerIndex}"]`);

                    let address1 = selectedOption.data('address1');
                    let address2 = selectedOption.data('address2');
                    let address3 = selectedOption.data('address3');

                    passengerFormCard.find('input[name="address1"]').val(address1).change();
                    passengerFormCard.find('input[name="address2"]').val(address2).change();
                    passengerFormCard.find('input[name="address3"]').val(address3).change();

                    let addressDisplay = address1 + (address2 ? ', ' + address2 : '') + (address3 ? ', ' + address3 : '');
                    notify(`Address filled: ${addressDisplay}`, 'info');
                }
            });
        }

        // Function to disable selected customer in other passenger forms
        function disableSelectedCustomerInOtherForms(selectedCustomerId, currentPassengerIndex) {
            // Get all selected customer IDs (except current)
            let selectedCustomerIds = new Set();

            $('.customer-selector').each(function() {
                let passengerIndex = $(this).data('passenger-index');
                let customerId = $(this).val();

                if (customerId && passengerIndex != currentPassengerIndex) {
                    selectedCustomerIds.add(customerId);
                }
            });

            // Disable/Enable options based on selection
            $('.customer-selector').each(function() {
                let passengerIndex = $(this).data('passenger-index');

                if (passengerIndex != currentPassengerIndex) {
                    // Disable selected customer in other forms
                    $(this).find('option').each(function() {
                        let optionValue = $(this).val();
                        if (optionValue == selectedCustomerId) {
                            $(this).prop('disabled', true);
                        } else if (optionValue && !selectedCustomerIds.has(optionValue)) {
                            $(this).prop('disabled', false);
                        }
                    });
                    
                    // Add grey background if this select has disabled options
                    let hasDisabled = $(this).find('option:disabled').length > 0;
                    if (hasDisabled) {
                        $(this).css('background-color', '#e9ecef').css('opacity', '0.8');
                    } else {
                        $(this).css('background-color', '').css('opacity', '');
                    }
                }
            });
        }

        // Save passenger data and redirect to detail page
        function savePassengerData() {
            let allPassengersData = {};
            let allValid = true;

            // Collect all passenger data
            $('.passenger-form-card').each(function() {
                let passengerIndex = $(this).data('passenger-index');
                let formCard = $(this);

                let firstName = formCard.find('input[name="firstname"]').val().trim();
                let lastName = formCard.find('input[name="lastname"]').val().trim();
                let title = formCard.find('select[name="titleName"]').val();
                let gender = formCard.find('select[name="gender"]').val();
                let nationality = formCard.find('select[name="nationality"]').val();
                let address1 = formCard.find('input[name="address1"]').val().trim();
                let address2 = formCard.find('input[name="address2"]').val().trim();
                let address3 = formCard.find('input[name="address3"]').val().trim();

                // Validation
                if (!firstName || !lastName || !title || !gender || !nationality || !address1 || !address2 || !address3) {
                    allValid = false;
                    notify(`Please fill all required fields for Passenger ${passengerIndex}`, 'error');
                    return false;
                }

                allPassengersData[passengerIndex] = {
                    passengerIndex: passengerIndex,
                    type: formCard.data('passenger-type'),
                    title: title,
                    firstName: firstName,
                    lastName: lastName,
                    dob: formCard.find('input[name="dob"]').val(),
                    gender: gender,
                    nationality: nationality,
                    address1: address1,
                    address2: address2,
                    address3: address3,
                    passportNo: formCard.find('input[name="passportNo"]').val().trim(),
                    passportExpiry: formCard.find('input[name="passportExpiry"]').val(),
                    panNo: formCard.find('input[name="panNo"]').val().trim()
                };
            });

            if (!allValid) {
                return;
            }

            // Save data to localStorage
            localStorage.setItem('passengersFormData', JSON.stringify(allPassengersData));

            // Redirect to detail page
            window.location.href = "/flight/detail";
        }

        // Load customer list from backend (same function from bookingflighttrip.js)
        function loadCustomerList() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/customer/list-data',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let customers = [];
                        if (response.status === 'success' && response.data) {
                            customers = Array.isArray(response.data) ? response.data : [];
                        }
                        resolve(customers);
                    },
                    error: function() {
                        resolve([]); // Return empty array on error
                    }
                });
            });
        }

        // Helper function for passenger count
        function getPassengerCount() {
            let searchPayload = JSON.parse(localStorage.getItem('payload')) || {};
            return {
                adults: parseInt(searchPayload.AdultCount) || 1,
                children: parseInt(searchPayload.ChildCount) || 0,
                infants: parseInt(searchPayload.InfantCount) || 0,
                total: (parseInt(searchPayload.AdultCount) || 1) + (parseInt(searchPayload.ChildCount) || 0) + (parseInt(
                    searchPayload.InfantCount) || 0)
            };
        }

        // Notification helper function
        function notify(message, type = 'info') {
            console.log(message);
            // Bootstrap toast notification
            const alertClass = type === 'success' ? 'alert-success' : (type === 'error' ? 'alert-danger' : 'alert-info');
            const alertHtml = `<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;

            $('main').prepend(alertHtml);

            // Auto dismiss after 3 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000);
        }
    </script>
@endpush
