<!-- resources/views/site-visit-form.blade.php -->
<!-- Compile SCSS: resources/sass/site-visit-form.scss -> public/css/site-visit-form.css -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Customer Site Visit Form</title>
    <meta name="description"
        content="Field sales form to capture customer site visit details, construction stage, product requirements and follow-ups.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/front/scss/style.scss'])

</head>

<body class="svf-body">

    <header class="svf-topbar">
        <div class="svf-topbar__inner">
            <div class="svf-brand">
                <span class="svf-brand__mark">SV</span>
                <span class="svf-brand__text">
                    <strong>Site Visit</strong>
                    <small>Sales field report</small>
                </span>
            </div>
            {{-- <span class="svf-chip svf-chip--live"><i class="svf-dot"></i> Draft autosaved</span> --}}
        </div>
        <div class="svf-progress"><span class="svf-progress__bar" id="svfProgress"></span></div>
    </header>

    <main class="svf-shell">
        <div class="svf-hero">
            <h1>{{ !empty($revisitData) ? 'Revisit Customer Site Visit' : 'Customer Site Visit Form' }}</h1>
            <p>{{ !empty($revisitData) ? 'Update the previous visit details and save as a fresh follow-up visit.' : 'Capture the visit in one pass — details, site, requirement, and next step.' }}</p>
        </div>

        <form class="svf-form" id="svfForm" method="POST" action="{{ route('admin.site-visit.store') }}" novalidate>
            @csrf
            @if(!empty($revisitSourceId))
                <input type="hidden" name="revisit_source_id" value="{{ $revisitSourceId }}">
            @endif

            {{-- 1. Sales Executive --}}
            <section class="svf-card">
                <div class="svf-card__head">
                    <span class="svf-step">01</span>
                    <div>
                        <h2>Sales Executive Details</h2>
                        <p>Auto-populated from your session</p>
                    </div>
                </div>
                <div class="svf-grid svf-grid--2">
                    <label class="svf-field is-locked">
                        <span class="svf-label">Sales Executive Name</span>
                        <input type="text" name="executive_name" value="{{ auth()->user()->name ?? '' }}" readonly>
                    </label>
                    <label class="svf-field is-locked">
                        <span class="svf-label">Email ID</span>
                        <input type="email" name="executive_email" value="{{ auth()->user()->email ?? '' }}" readonly>
                    </label>
                    <label class="svf-field is-locked">
                        <span class="svf-label">Visit Date</span>
                        <input type="date" name="visit_date" id="visitDate" readonly>
                    </label>
                    <label class="svf-field is-locked">
                        <span class="svf-label">Visit Time</span>
                        <input type="time" name="visit_time" id="visitTime" readonly>
                    </label>
                </div>
            </section>

            {{-- 2. Customer --}}
            <section class="svf-card">
                <div class="svf-card__head">
                    <span class="svf-step">02</span>
                    <div>
                        <h2>Customer Details</h2>
                        <p>Who you met on site</p>
                    </div>
                </div>
                <div class="svf-grid svf-grid--2">
                    <label class="svf-field">
                        <span class="svf-label">Customer Name <b>*</b></span>
                        <input type="text" name="customer_name" placeholder="Full name" required>
                    </label>
                    <label class="svf-field">
                        <span class="svf-label">Mobile Number <b>*</b></span>
                        <input type="tel" name="mobile" inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}"
                            placeholder="10-digit mobile" required>
                    </label>
                    <label class="svf-field">
                        <span class="svf-label">Alternate Mobile <small>Optional</small></span>
                        <input type="tel" name="alt_mobile" inputmode="numeric" maxlength="10"
                            placeholder="10-digit mobile">
                    </label>
                    <label class="svf-field">
                        <span class="svf-label">Email ID</span>
                        <input type="email" name="customer_email" placeholder="name@example.com">
                    </label>
                </div>
            </section>

            {{-- 3. Site Location --}}
            <section class="svf-card">
                <div class="svf-card__head">
                    <span class="svf-step">03</span>
                    <div>
                        <h2>Site Location</h2>
                        <p>Where the installation happens</p>
                    </div>
                </div>
                <div class="svf-grid svf-grid--2">
                    <label class="svf-field">
                        <span class="svf-label">State <b>*</b></span>
                        <select name="state" id="stateSelect" required>
                            <option value="">Select state</option>
                        </select>
                    </label>
                    <label class="svf-field">
                        <span class="svf-label">District <b>*</b></span>
                        <select name="district" id="districtSelect" required disabled>
                            <option value="">Select state first</option>
                        </select>
                    </label>
                    <label class="svf-field">
                        <span class="svf-label">Zip / PIN Code</span>
                        <input type="text" name="pincode" inputmode="numeric" maxlength="6"
                            placeholder="6-digit PIN">
                    </label>
                    <div class="svf-field">
                        <span class="svf-label">GPS Location <small>Auto capture</small></span>
                        <div class="svf-gps">
                            <input type="text" name="gps" id="gpsInput" placeholder="Latitude, Longitude"
                                readonly>
                            <button type="button" class="svf-btn svf-btn--ghost" id="gpsBtn">Capture</button>
                        </div>
                        <span class="svf-hint" id="gpsHint">Allow location access to auto-fill.</span>
                    </div>
                    <label class="svf-field svf-col-span">
                        <span class="svf-label">Google Maps Link <small>Auto-generated</small></span>
                        <input type="url" name="maps_link" id="mapsLink"
                            placeholder="https://maps.google.com/?q=…" readonly>
                    </label>
                </div>
            </section>

            {{-- 4. Construction --}}
            <section class="svf-card">
                <div class="svf-card__head">
                    <span class="svf-step">04</span>
                    <div>
                        <h2>Construction Details</h2>
                        <p>Current stage of the site</p>
                    </div>
                </div>
                <div class="svf-pills" role="radiogroup" aria-label="Construction stage">
                    @foreach (['Foundation / Site Preparation', 'Structure / Masonry in Progress', 'Roofing Completed', 'Finishing Stage (Doors & Windows Installation)', 'Ready for Installation', 'Renovation / Replacement'] as $stage)
                        <label class="svf-pill">
                            <input type="radio" name="construction_stage" value="{{ $stage }}" required>
                            <span>{{ $stage }}</span>
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- 5. Product Requirement --}}
            <section class="svf-card">
                <div class="svf-card__head">
                    <span class="svf-step">05</span>
                    <div>
                        <h2>Product Requirement</h2>
                        <p>Multi-select — at least one required</p>
                    </div>
                </div>
                <div class="svf-checks svf-checks--tiles">
                    @foreach (['Doors', 'Windows', 'Doors & Windows', 'Frames', 'Hardware / Accessories', 'Others'] as $p)
                        <label class="svf-check">
                            <input type="checkbox" name="products[]" value="{{ $p }}"
                                data-required-group="products">
                            <span class="svf-check__box" aria-hidden="true"></span>
                            <span class="svf-check__text">{{ $p }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="svf-divider"><span>Product Category <small>Optional</small></span></div>
                <div class="svf-checks">
                    @foreach (['Embossed Wood / RAL Finish Doors', 'Plain Wood Finish Doors', 'Plain Steel Finish Doors', 'Fly Mesh Doors', 'Double Leaf Doors', 'Reflections Natura Series', 'French Doors (Lumière Series)', 'Pebble Series (Casement)', 'Pebble Series (Sliding)', 'Swing & Slide Windows', 'Doors / Windows with Ventilator'] as $c)
                        <label class="svf-check">
                            <input type="checkbox" name="categories[]" value="{{ $c }}">
                            <span class="svf-check__box" aria-hidden="true"></span>
                            <span class="svf-check__text">{{ $c }}</span>
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- 6. Quantity --}}
            <section class="svf-card">
                <div class="svf-card__head">
                    <span class="svf-step">06</span>
                    <div>
                        <h2>Quantity Requirement</h2>
                        <p>Units per product type</p>
                    </div>
                </div>
                <div class="svf-qty">
                    @foreach (['doors' => 'Doors', 'windows' => 'Windows', 'frames' => 'Frames', 'others' => 'Others'] as $key => $label)
                        <div class="svf-qty__row">
                            <span class="svf-qty__label">{{ $label }}</span>
                            <div class="svf-stepper">
                                <button type="button" class="svf-stepper__btn" data-step="-1"
                                    aria-label="Decrease {{ $label }}">−</button>
                                <input type="number" class="js-qty" name="qty[{{ $key }}]" value="0"
                                    min="0" inputmode="numeric">
                                <button type="button" class="svf-stepper__btn" data-step="1"
                                    aria-label="Increase {{ $label }}">+</button>
                            </div>
                        </div>
                    @endforeach
                    <div class="svf-qty__total">
                        <span>Estimated Total Quantity</span>
                        <strong id="qtyTotal">0</strong>
                        <input type="hidden" name="qty_total" id="qtyTotalInput" value="0">
                    </div>
                </div>
            </section>

            {{-- 7 & 8 --}}
            <section class="svf-card">
                <div class="svf-card__head">
                    <span class="svf-step">07</span>
                    <div>
                        <h2>Timeline &amp; Budget</h2>
                        <p>Buying window and expected spend</p>
                    </div>
                </div>
                <div class="svf-grid svf-grid--2">
                    <label class="svf-field">
                        <span class="svf-label">Purchase Timeline <b>*</b></span>
                        <select name="timeline" required>
                            <option value="">Select timeline</option>
                            @foreach (['Within 1 Month', 'Within 3 Months', '3 - 6 Months', 'After 6 Months'] as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="svf-field">
                        <span class="svf-label">Budget <small>Optional</small></span>
                        <select name="budget">
                            <option value="">Select budget</option>
                            @foreach (['Below ₹1 Lakh', '₹1–3 Lakhs', '₹3–5 Lakhs', 'Above ₹5 Lakhs'] as $b)
                                <option value="{{ $b }}">{{ $b }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </section>

            {{-- 9. Competitor --}}
            <section class="svf-card">
                <div class="svf-card__head">
                    <span class="svf-step">08</span>
                    <div>
                        <h2>Competitor Information</h2>
                        <p>What else is being considered</p>
                    </div>
                </div>
                <label class="svf-field">
                    <span class="svf-label">Competitor</span>
                    <select name="competitor">
                        <option value="">Select competitor</option>
                        @foreach (['Godrej', 'Tostem', 'Fenesta', 'Asian Paints', 'Jindal', 'Local Fabricator', 'Wooden Door', 'PVC / uPVC', 'Others'] as $c)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endforeach
                    </select>
                </label>
            </section>

            {{-- 10, 11, 12 --}}
            <section class="svf-card">
                <div class="svf-card__head">
                    <span class="svf-step">09</span>
                    <div>
                        <h2>Outcome</h2>
                        <p>Interest, follow-up and notes</p>
                    </div>
                </div>

                <span class="svf-label">Customer Interest Level <b>*</b></span>
                <div class="svf-segment" role="radiogroup" aria-label="Interest level">
                    <label class="svf-segment__item svf-segment__item--low">
                        <input type="radio" name="interest" value="Low" required><span>Low</span>
                    </label>
                    <label class="svf-segment__item svf-segment__item--med">
                        <input type="radio" name="interest" value="Medium"><span>Medium</span>
                    </label>
                    <label class="svf-segment__item svf-segment__item--high">
                        <input type="radio" name="interest" value="High"><span>High</span>
                    </label>
                </div>

                <div class="svf-switchrow">
                    <div>
                        <span class="svf-label">Follow-up Required</span>
                        <span class="svf-hint">Schedule a callback or next visit</span>
                    </div>
                    <label class="svf-switch">
                        <input type="checkbox" name="follow_up" value="Yes">
                        <span class="svf-switch__track"><span class="svf-switch__knob"></span></span>
                    </label>
                </div>

                <div class="svf-follow-up-date" id="followUpDateWrap" style="display: none;">
                    <label class="svf-field">
                        <span class="svf-label">Follow-up Date <b>*</b></span>
                        <input type="date" name="follow_update" id="followUpdateDate" min="{{ date('Y-m-d') }}">
                    </label>
                </div>

                <label class="svf-field">
                    <span class="svf-label">Remarks</span>
                    <textarea name="remarks" rows="4" maxlength="1000" placeholder="Observations, commitments, objections…"></textarea>
                    <span class="svf-hint"><span id="remarkCount">0</span>/1000</span>
                </label>
            </section>

            <div class="svf-actions">
                <button type="reset" class="svf-btn svf-btn--ghost" id="svfResetBtn">Clear</button>
                <button type="submit" class="svf-btn svf-btn--primary" id="svfSubmitBtn">
                    <span class="svf-btn__label">Submit Visit Report</span>
                </button>
            </div>
        </form>
    </main>

    <div class="svf-submit-loader" id="svfSubmitLoader" aria-hidden="true">
        <div class="svf-submit-loader__panel">
            <div class="svf-submit-loader__spinner"></div>
            <p>Submitting visit report…</p>
        </div>
    </div>

    <div class="svf-success-overlay" id="svfSuccessOverlay" aria-hidden="true">
        <div class="svf-success-overlay__panel">
            <div class="svf-success-overlay__icon" aria-hidden="true"></div>
            <h2>Visit Report Saved</h2>
            <p id="svfSuccessMessage">Your site visit has been submitted successfully.</p>
            <p class="svf-success-overlay__redirect">Redirecting to listing in <span id="svfRedirectCountdown">3</span>s…</p>
        </div>
    </div>

    <div class="svf-error-banner" id="svfErrorBanner" role="alert" aria-live="polite"></div>

    <script type="module">
        // public/js/site-visit-form.js
        (function() {
            "use strict";

            var revisitData = @json($revisitData ?? []);

            function setFormValue(name, value) {
                if (!name) return;
                var el = form.querySelector('[name="' + name + '"]');
                if (!el) return;

                if (el.type === 'checkbox') {
                    el.checked = !!value;
                    return;
                }

                if (el.type === 'radio') {
                    var radios = form.querySelectorAll('[name="' + name + '"]');
                    radios.forEach(function(radio) {
                        radio.checked = String(radio.value) === String(value);
                    });
                    return;
                }

                el.value = value ?? '';
            }

            // ---- Replace / extend with your own master data (or inject from Laravel) ----
            var STATE_DISTRICTS = window.SVF_STATE_DISTRICTS || {
                "Andhra Pradesh": [
                    "Alluri Sitharama Raju",
                    "Anakapalli",
                    "Anantapur",
                    "Annamayya",
                    "Bapatla",
                    "Chittoor",
                    "Dr. B.R. Ambedkar Konaseema",
                    "East Godavari",
                    "Eluru",
                    "Guntur",
                    "Kakinada",
                    "Krishna",
                    "Kurnool",
                    "Nandyal",
                    "NTR",
                    "Palnadu",
                    "Parvathipuram Manyam",
                    "Prakasam",
                    "Srikakulam",
                    "Sri Potti Sriramulu Nellore",
                    "Sri Sathya Sai",
                    "Tirupati",
                    "Visakhapatnam",
                    "Vizianagaram",
                    "West Godavari",
                    "YSR Kadapa"
                ],

                "Arunachal Pradesh": [
                    "Anjaw",
                    "Bichom",
                    "Changlang",
                    "Dibang Valley",
                    "East Kameng",
                    "East Siang",
                    "Kamle",
                    "Keyi Panyor",
                    "Kra Daadi",
                    "Kurung Kumey",
                    "Lepa Rada",
                    "Lohit",
                    "Longding",
                    "Lower Dibang Valley",
                    "Lower Siang",
                    "Lower Subansiri",
                    "Namsai",
                    "Pakke Kessang",
                    "Papum Pare",
                    "Shi Yomi",
                    "Siang",
                    "Tawang",
                    "Tirap",
                    "Upper Siang",
                    "Upper Subansiri",
                    "West Kameng",
                    "West Siang"
                ],

                "Assam": [
                    "Baksa",
                    "Bajali",
                    "Barpeta",
                    "Biswanath",
                    "Bongaigaon",
                    "Cachar",
                    "Charaideo",
                    "Darrang",
                    "Dhemaji",
                    "Dhubri",
                    "Dibrugarh",
                    "Dima Hasao",
                    "Goalpara",
                    "Golaghat",
                    "Hailakandi",
                    "Hojai",
                    "Jorhat",
                    "Kamrup",
                    "Kamrup Metropolitan",
                    "Karbi Anglong",
                    "Kokrajhar",
                    "Lakhimpur",
                    "Majuli",
                    "Morigaon",
                    "Nagaon",
                    "Nalbari",
                    "Sivasagar",
                    "Sonitpur",
                    "South Salmara-Mankachar",
                    "Tamulpur",
                    "Tinsukia",
                    "Udalguri",
                    "West Karbi Anglong"
                ],

                "Bihar": [
                    "Araria",
                    "Arwal",
                    "Aurangabad",
                    "Banka",
                    "Begusarai",
                    "Bhagalpur",
                    "Bhojpur",
                    "Buxar",
                    "Darbhanga",
                    "East Champaran",
                    "Gaya",
                    "Gopalganj",
                    "Jamui",
                    "Jehanabad",
                    "Kaimur",
                    "Katihar",
                    "Khagaria",
                    "Kishanganj",
                    "Lakhisarai",
                    "Madhepura",
                    "Madhubani",
                    "Munger",
                    "Muzaffarpur",
                    "Nalanda",
                    "Nawada",
                    "Patna",
                    "Purnia",
                    "Rohtas",
                    "Saharsa",
                    "Samastipur",
                    "Saran",
                    "Sheikhpura",
                    "Sheohar",
                    "Sitamarhi",
                    "Siwan",
                    "Supaul",
                    "Vaishali",
                    "West Champaran"
                ],

                "Chhattisgarh": [
                    "Balod",
                    "Baloda Bazar",
                    "Balrampur-Ramanujganj",
                    "Bastar",
                    "Bemetara",
                    "Bijapur",
                    "Bilaspur",
                    "Dantewada",
                    "Dhamtari",
                    "Durg",
                    "Gariaband",
                    "Gaurela-Pendra-Marwahi",
                    "Janjgir-Champa",
                    "Jashpur",
                    "Kabirdham",
                    "Kanker",
                    "Khairagarh-Chhuikhadan-Gandai",
                    "Kondagaon",
                    "Korba",
                    "Koriya",
                    "Mahasamund",
                    "Manendragarh-Chirmiri-Bharatpur",
                    "Mohla-Manpur-Ambagarh Chowki",
                    "Mungeli",
                    "Narayanpur",
                    "Raigarh",
                    "Raipur",
                    "Rajnandgaon",
                    "Sarangarh-Bilaigarh",
                    "Sukma",
                    "Surajpur",
                    "Surguja"
                ],

                "Goa": [
                    "North Goa",
                    "South Goa"
                ],

                "Gujarat": [
                    "Ahmedabad",
                    "Amreli",
                    "Anand",
                    "Aravalli",
                    "Banaskantha",
                    "Bharuch",
                    "Bhavnagar",
                    "Botad",
                    "Chhota Udaipur",
                    "Dahod",
                    "Dang",
                    "Devbhumi Dwarka",
                    "Gandhinagar",
                    "Gir Somnath",
                    "Jamnagar",
                    "Junagadh",
                    "Kheda",
                    "Kutch",
                    "Mahisagar",
                    "Mehsana",
                    "Morbi",
                    "Narmada",
                    "Navsari",
                    "Panchmahal",
                    "Patan",
                    "Porbandar",
                    "Rajkot",
                    "Sabarkantha",
                    "Surat",
                    "Surendranagar",
                    "Tapi",
                    "Vadodara",
                    "Valsad"
                ],

                "Haryana": [
                    "Ambala",
                    "Bhiwani",
                    "Charkhi Dadri",
                    "Faridabad",
                    "Fatehabad",
                    "Gurugram",
                    "Hisar",
                    "Jhajjar",
                    "Jind",
                    "Kaithal",
                    "Karnal",
                    "Kurukshetra",
                    "Mahendragarh",
                    "Nuh",
                    "Palwal",
                    "Panchkula",
                    "Panipat",
                    "Rewari",
                    "Rohtak",
                    "Sirsa",
                    "Sonipat",
                    "Yamunanagar"
                ],

                "Himachal Pradesh": [
                    "Bilaspur",
                    "Chamba",
                    "Hamirpur",
                    "Kangra",
                    "Kinnaur",
                    "Kullu",
                    "Lahaul and Spiti",
                    "Mandi",
                    "Shimla",
                    "Sirmaur",
                    "Solan",
                    "Una"
                ],

                "Jharkhand": [
                    "Bokaro",
                    "Chatra",
                    "Deoghar",
                    "Dhanbad",
                    "Dumka",
                    "East Singhbhum",
                    "Garhwa",
                    "Giridih",
                    "Godda",
                    "Gumla",
                    "Hazaribagh",
                    "Jamtara",
                    "Khunti",
                    "Koderma",
                    "Latehar",
                    "Lohardaga",
                    "Pakur",
                    "Palamu",
                    "Ramgarh",
                    "Ranchi",
                    "Sahibganj",
                    "Seraikela Kharsawan",
                    "Simdega",
                    "West Singhbhum"
                ],

                "Karnataka": [
                    "Bagalkot",
                    "Ballari",
                    "Belagavi",
                    "Bengaluru Rural",
                    "Bengaluru Urban",
                    "Bidar",
                    "Chamarajanagar",
                    "Chikkaballapur",
                    "Chikkamagaluru",
                    "Chitradurga",
                    "Dakshina Kannada",
                    "Davanagere",
                    "Dharwad",
                    "Gadag",
                    "Hassan",
                    "Haveri",
                    "Kalaburagi",
                    "Kodagu",
                    "Kolar",
                    "Koppal",
                    "Mandya",
                    "Mysuru",
                    "Raichur",
                    "Ramanagara",
                    "Shivamogga",
                    "Tumakuru",
                    "Udupi",
                    "Uttara Kannada",
                    "Vijayapura",
                    "Vijayanagara",
                    "Yadgir"
                ],

                "Kerala": [
                    "Alappuzha",
                    "Ernakulam",
                    "Idukki",
                    "Kannur",
                    "Kasaragod",
                    "Kollam",
                    "Kottayam",
                    "Kozhikode",
                    "Malappuram",
                    "Palakkad",
                    "Pathanamthitta",
                    "Thiruvananthapuram",
                    "Thrissur",
                    "Wayanad"
                ],

                "Madhya Pradesh": [
                    "Agar Malwa",
                    "Alirajpur",
                    "Anuppur",
                    "Ashoknagar",
                    "Balaghat",
                    "Barwani",
                    "Betul",
                    "Bhind",
                    "Bhopal",
                    "Burhanpur",
                    "Chhatarpur",
                    "Chhindwara",
                    "Damoh",
                    "Datia",
                    "Dewas",
                    "Dhar",
                    "Dindori",
                    "Guna",
                    "Gwalior",
                    "Harda",
                    "Indore",
                    "Jabalpur",
                    "Jhabua",
                    "Katni",
                    "Khandwa",
                    "Khargone",
                    "Maihar",
                    "Mandla",
                    "Mandsaur",
                    "Mauganj",
                    "Morena",
                    "Narmadapuram",
                    "Narsinghpur",
                    "Neemuch",
                    "Niwari",
                    "Panna",
                    "Raisen",
                    "Rajgarh",
                    "Ratlam",
                    "Rewa",
                    "Sagar",
                    "Satna",
                    "Sehore",
                    "Seoni",
                    "Shahdol",
                    "Shajapur",
                    "Sheopur",
                    "Shivpuri",
                    "Sidhi",
                    "Singrauli",
                    "Tikamgarh",
                    "Ujjain",
                    "Umaria",
                    "Vidisha"
                ],

                "Maharashtra": [
                    "Ahmednagar",
                    "Akola",
                    "Amravati",
                    "Beed",
                    "Bhandara",
                    "Buldhana",
                    "Chandrapur",
                    "Chhatrapati Sambhajinagar",
                    "Dhule",
                    "Gadchiroli",
                    "Gondia",
                    "Hingoli",
                    "Jalgaon",
                    "Jalna",
                    "Kolhapur",
                    "Latur",
                    "Mumbai City",
                    "Mumbai Suburban",
                    "Nagpur",
                    "Nanded",
                    "Nandurbar",
                    "Nashik",
                    "Dharashiv",
                    "Palghar",
                    "Parbhani",
                    "Pune",
                    "Raigad",
                    "Ratnagiri",
                    "Sangli",
                    "Satara",
                    "Sindhudurg",
                    "Solapur",
                    "Thane",
                    "Wardha",
                    "Washim",
                    "Yavatmal"
                ],

                "Manipur": [
                    "Bishnupur",
                    "Chandel",
                    "Churachandpur",
                    "Imphal East",
                    "Imphal West",
                    "Jiribam",
                    "Kakching",
                    "Kamjong",
                    "Kangpokpi",
                    "Noney",
                    "Pherzawl",
                    "Senapati",
                    "Tamenglong",
                    "Tengnoupal",
                    "Thoubal",
                    "Ukhrul"
                ],

                "Meghalaya": [
                    "East Garo Hills",
                    "East Jaintia Hills",
                    "East Khasi Hills",
                    "Eastern West Khasi Hills",
                    "North Garo Hills",
                    "Ri-Bhoi",
                    "South Garo Hills",
                    "South West Garo Hills",
                    "South West Khasi Hills",
                    "West Garo Hills",
                    "West Jaintia Hills",
                    "West Khasi Hills"
                ],

                "Mizoram": [
                    "Aizawl",
                    "Champhai",
                    "Hnahthial",
                    "Khawzawl",
                    "Kolasib",
                    "Lawngtlai",
                    "Lunglei",
                    "Mamit",
                    "Saiha",
                    "Saitual",
                    "Serchhip"
                ],

                "Nagaland": [
                    "Chumoukedima",
                    "Dimapur",
                    "Kiphire",
                    "Kohima",
                    "Longleng",
                    "Mokokchung",
                    "Mon",
                    "Niuland",
                    "Noklak",
                    "Peren",
                    "Phek",
                    "Shamator",
                    "Tuensang",
                    "Tseminyu",
                    "Wokha",
                    "Zunheboto"
                ],

                "Odisha": [
                    "Angul",
                    "Boudh",
                    "Balangir",
                    "Bargarh",
                    "Balasore",
                    "Bhadrak",
                    "Cuttack",
                    "Deogarh",
                    "Dhenkanal",
                    "Gajapati",
                    "Ganjam",
                    "Jagatsinghpur",
                    "Jajpur",
                    "Jharsuguda",
                    "Kalahandi",
                    "Kandhamal",
                    "Kendrapara",
                    "Kendujhar",
                    "Khordha",
                    "Koraput",
                    "Malkangiri",
                    "Mayurbhanj",
                    "Nabarangpur",
                    "Nayagarh",
                    "Nuapada",
                    "Puri",
                    "Rayagada",
                    "Sambalpur",
                    "Subarnapur",
                    "Sundargarh"
                ],

                "Punjab": [
                    "Amritsar",
                    "Barnala",
                    "Bathinda",
                    "Faridkot",
                    "Fatehgarh Sahib",
                    "Fazilka",
                    "Ferozepur",
                    "Gurdaspur",
                    "Hoshiarpur",
                    "Jalandhar",
                    "Kapurthala",
                    "Ludhiana",
                    "Malerkotla",
                    "Mansa",
                    "Moga",
                    "Pathankot",
                    "Patiala",
                    "Rupnagar",
                    "Sahibzada Ajit Singh Nagar",
                    "Sangrur",
                    "Shaheed Bhagat Singh Nagar",
                    "Sri Muktsar Sahib",
                    "Tarn Taran"
                ],

                "Rajasthan": [
                    "Ajmer",
                    "Alwar",
                    "Balotra",
                    "Banswara",
                    "Baran",
                    "Barmer",
                    "Beawar",
                    "Bharatpur",
                    "Bhilwara",
                    "Bikaner",
                    "Bundi",
                    "Chittorgarh",
                    "Churu",
                    "Dausa",
                    "Deeg",
                    "Dholpur",
                    "Didwana-Kuchamana",
                    "Dudu",
                    "Dungarpur",
                    "Ganganagar",
                    "Hanumangarh",
                    "Jaipur",
                    "Jaisalmer",
                    "Jalore",
                    "Jhalawar",
                    "Jhunjhunu",
                    "Jodhpur",
                    "Karauli",
                    "Kekri",
                    "Khairthal-Tijara",
                    "Kota",
                    "Kotputli-Behror",
                    "Nagaur",
                    "Neem Ka Thana",
                    "Pali",
                    "Phalodi",
                    "Pratapgarh",
                    "Rajsamand",
                    "Salumbar",
                    "Sawai Madhopur",
                    "Sikar",
                    "Sirohi",
                    "Tonk",
                    "Udaipur"
                ],

                "Sikkim": [
                    "Gangtok",
                    "Gyalshing",
                    "Mangan",
                    "Namchi",
                    "Pakyong",
                    "Soreng"
                ],

                "Tamil Nadu": [
                    "Ariyalur",
                    "Chengalpattu",
                    "Chennai",
                    "Coimbatore",
                    "Cuddalore",
                    "Dharmapuri",
                    "Dindigul",
                    "Erode",
                    "Kallakurichi",
                    "Kancheepuram",
                    "Karur",
                    "Krishnagiri",
                    "Madurai",
                    "Mayiladuthurai",
                    "Nagapattinam",
                    "Namakkal",
                    "Nilgiris",
                    "Perambalur",
                    "Pudukkottai",
                    "Ramanathapuram",
                    "Ranipet",
                    "Salem",
                    "Sivaganga",
                    "Tenkasi",
                    "Thanjavur",
                    "Theni",
                    "Thoothukudi",
                    "Tiruchirappalli",
                    "Tirunelveli",
                    "Tirupathur",
                    "Tiruppur",
                    "Tiruvallur",
                    "Tiruvannamalai",
                    "Tiruvarur",
                    "Vellore",
                    "Viluppuram",
                    "Virudhunagar"
                ],

                "Telangana": [
                    "Adilabad",
                    "Bhadradri Kothagudem",
                    "Hanamkonda",
                    "Hyderabad",
                    "Jagtial",
                    "Jangaon",
                    "Jayashankar Bhupalpally",
                    "Jogulamba Gadwal",
                    "Kamareddy",
                    "Karimnagar",
                    "Khammam",
                    "Komaram Bheem Asifabad",
                    "Mahabubabad",
                    "Mahbubnagar",
                    "Mancherial",
                    "Medak",
                    "Medchal-Malkajgiri",
                    "Mulugu",
                    "Nagarkurnool",
                    "Nalgonda",
                    "Narayanpet",
                    "Nirmal",
                    "Nizamabad",
                    "Peddapalli",
                    "Rajanna Sircilla",
                    "Rangareddy",
                    "Sangareddy",
                    "Siddipet",
                    "Suryapet",
                    "Vikarabad",
                    "Wanaparthy",
                    "Warangal",
                    "Yadadri Bhuvanagiri"
                ],

                "Tripura": [
                    "Dhalai",
                    "Gomati",
                    "Khowai",
                    "North Tripura",
                    "Sepahijala",
                    "South Tripura",
                    "Unakoti",
                    "West Tripura"
                ],

                "Uttar Pradesh": [
                    "Agra",
                    "Aligarh",
                    "Ambedkar Nagar",
                    "Amethi",
                    "Amroha",
                    "Auraiya",
                    "Ayodhya",
                    "Azamgarh",
                    "Baghpat",
                    "Bahraich",
                    "Ballia",
                    "Balrampur",
                    "Banda",
                    "Barabanki",
                    "Bareilly",
                    "Basti",
                    "Bhadohi",
                    "Bijnor",
                    "Budaun",
                    "Bulandshahr",
                    "Chandauli",
                    "Chitrakoot",
                    "Deoria",
                    "Etah",
                    "Etawah",
                    "Farrukhabad",
                    "Fatehpur",
                    "Firozabad",
                    "Gautam Buddha Nagar",
                    "Ghaziabad",
                    "Ghazipur",
                    "Gonda",
                    "Gorakhpur",
                    "Hamirpur",
                    "Hapur",
                    "Hardoi",
                    "Hathras",
                    "Jalaun",
                    "Jaunpur",
                    "Jhansi",
                    "Kannauj",
                    "Kanpur Dehat",
                    "Kanpur Nagar",
                    "Kasganj",
                    "Kaushambi",
                    "Kushinagar",
                    "Lakhimpur Kheri",
                    "Lalitpur",
                    "Lucknow",
                    "Maharajganj",
                    "Mahoba",
                    "Mainpuri",
                    "Mathura",
                    "Mau",
                    "Meerut",
                    "Mirzapur",
                    "Moradabad",
                    "Muzaffarnagar",
                    "Pilibhit",
                    "Pratapgarh",
                    "Prayagraj",
                    "Raebareli",
                    "Rampur",
                    "Saharanpur",
                    "Sambhal",
                    "Sant Kabir Nagar",
                    "Shahjahanpur",
                    "Shamli",
                    "Shravasti",
                    "Siddharthnagar",
                    "Sitapur",
                    "Sonbhadra",
                    "Sultanpur",
                    "Unnao",
                    "Varanasi"
                ],

                "Uttarakhand": [
                    "Almora",
                    "Bageshwar",
                    "Chamoli",
                    "Champawat",
                    "Dehradun",
                    "Haridwar",
                    "Nainital",
                    "Pauri Garhwal",
                    "Pithoragarh",
                    "Rudraprayag",
                    "Tehri Garhwal",
                    "Udham Singh Nagar",
                    "Uttarkashi"
                ],

                "West Bengal": [
                    "Alipurduar",
                    "Bankura",
                    "Birbhum",
                    "Cooch Behar",
                    "Dakshin Dinajpur",
                    "Darjeeling",
                    "Hooghly",
                    "Howrah",
                    "Jalpaiguri",
                    "Jhargram",
                    "Kalimpong",
                    "Kolkata",
                    "Malda",
                    "Murshidabad",
                    "Nadia",
                    "North 24 Parganas",
                    "Paschim Bardhaman",
                    "Paschim Medinipur",
                    "Purba Bardhaman",
                    "Purba Medinipur",
                    "Purulia",
                    "South 24 Parganas",
                    "Uttar Dinajpur"
                ],

                /* Union Territories */

                "Andaman and Nicobar Islands": [
                    "Nicobar",
                    "North and Middle Andaman",
                    "South Andaman"
                ],

                "Chandigarh": [
                    "Chandigarh"
                ],

                "Dadra and Nagar Haveli and Daman and Diu": [
                    "Dadra and Nagar Haveli",
                    "Daman",
                    "Diu"
                ],

                "Delhi": [
                    "Central Delhi",
                    "East Delhi",
                    "New Delhi",
                    "North Delhi",
                    "North East Delhi",
                    "North West Delhi",
                    "Shahdara",
                    "South Delhi",
                    "South East Delhi",
                    "South West Delhi",
                    "West Delhi"
                ],

                "Jammu and Kashmir": [
                    "Anantnag",
                    "Bandipora",
                    "Baramulla",
                    "Budgam",
                    "Doda",
                    "Ganderbal",
                    "Jammu",
                    "Kathua",
                    "Kishtwar",
                    "Kulgam",
                    "Kupwara",
                    "Poonch",
                    "Pulwama",
                    "Rajouri",
                    "Ramban",
                    "Reasi",
                    "Samba",
                    "Shopian",
                    "Srinagar",
                    "Udhampur"
                ],

                "Ladakh": [
                    "Kargil",
                    "Leh"
                ],

                "Lakshadweep": [
                    "Lakshadweep"
                ],

                "Puducherry": [
                    "Karaikal",
                    "Mahe",
                    "Puducherry",
                    "Yanam"
                ]
            };

            var form = document.getElementById("svfForm");
            if (!form) return;

            // ---- 1. Auto date & time ----
            var now = new Date();
            var pad = function(n) {
                return String(n).padStart(2, "0");
            };
            var dateEl = document.getElementById("visitDate");
            var timeEl = document.getElementById("visitTime");
            if (dateEl) dateEl.value = now.getFullYear() + "-" + pad(now.getMonth() + 1) + "-" + pad(now.getDate());
            if (timeEl) timeEl.value = pad(now.getHours()) + ":" + pad(now.getMinutes());

            // ---- 2. State / District ----
            var stateSel = document.getElementById("stateSelect");
            var distSel = document.getElementById("districtSelect");

            if (stateSel && distSel) {
                Object.keys(STATE_DISTRICTS).sort().forEach(function(s) {
                    var o = document.createElement("option");
                    o.value = o.textContent = s;
                    stateSel.appendChild(o);
                });

                stateSel.addEventListener("change", function() {
                    var list = STATE_DISTRICTS[stateSel.value] || [];
                    distSel.innerHTML = "";
                    var ph = document.createElement("option");
                    ph.value = "";
                    ph.textContent = list.length ? "Select district" : "Select state first";
                    distSel.appendChild(ph);
                    list.forEach(function(d) {
                        var o = document.createElement("option");
                        o.value = o.textContent = d;
                        distSel.appendChild(o);
                    });
                    distSel.disabled = !list.length;
                    if (revisitData && revisitData.district && !distSel.dataset.applied) {
                        distSel.value = revisitData.district;
                    }
                    distSel.dataset.applied = '1';
                    updateProgress();
                });
            }

            function applyRevisitData() {
                if (!revisitData || Object.keys(revisitData).length === 0) {
                    return;
                }

                if (revisitData.visit_date) {
                    var visitDateInput = document.getElementById('visitDate');
                    if (visitDateInput) visitDateInput.value = revisitData.visit_date;
                }

                if (revisitData.visit_time) {
                    var visitTimeInput = document.getElementById('visitTime');
                    if (visitTimeInput) visitTimeInput.value = revisitData.visit_time;
                }

                setFormValue('customer_name', revisitData.customer_name);
                setFormValue('mobile', revisitData.mobile);
                setFormValue('alt_mobile', revisitData.alt_mobile);
                setFormValue('customer_email', revisitData.customer_email);
                setFormValue('pincode', revisitData.pincode);
                setFormValue('gps', revisitData.gps);
                setFormValue('maps_link', revisitData.maps_link);
                setFormValue('timeline', revisitData.timeline);
                setFormValue('budget', revisitData.budget);
                setFormValue('competitor', revisitData.competitor);
                setFormValue('remarks', revisitData.remarks);

                if (stateSel && revisitData.state) {
                    stateSel.value = revisitData.state;
                    stateSel.dispatchEvent(new Event('change', { bubbles: true }));
                }

                if (distSel && revisitData.district) {
                    setTimeout(function () {
                        distSel.value = revisitData.district;
                    }, 0);
                }

                if (revisitData.construction_stage) {
                    var constructionRadio = form.querySelector('input[name="construction_stage"][value="' + revisitData.construction_stage + '"]');
                    if (constructionRadio) constructionRadio.checked = true;
                }

                if (Array.isArray(revisitData.products)) {
                    form.querySelectorAll('input[name="products[]"]').forEach(function (box) {
                        box.checked = revisitData.products.includes(box.value);
                    });
                }

                if (Array.isArray(revisitData.categories)) {
                    form.querySelectorAll('input[name="categories[]"]').forEach(function (box) {
                        box.checked = revisitData.categories.includes(box.value);
                    });
                }

                if (revisitData.qty) {
                    Object.keys(revisitData.qty).forEach(function (key) {
                        var qtyInput = form.querySelector('input[name="qty[' + key + ']"]');
                        if (qtyInput) qtyInput.value = revisitData.qty[key] ?? 0;
                    });
                    recalcTotal();
                }

                if (revisitData.interest) {
                    var interestRadio = form.querySelector('input[name="interest"][value="' + revisitData.interest + '"]');
                    if (interestRadio) interestRadio.checked = true;
                }

                if (revisitData.follow_up) {
                    var followUpCheckbox = form.querySelector('input[name="follow_up"]');
                    if (followUpCheckbox) {
                        followUpCheckbox.checked = true;
                    }
                }

                if (followUpDate && revisitData.follow_update) {
                    followUpDate.value = revisitData.follow_update;
                }

                if (followUpToggle) {
                    toggleFollowUpDate();
                }
            }

            // ---- 3. GPS capture + maps link ----
            var gpsInput = document.getElementById("gpsInput");
            var gpsHint = document.getElementById("gpsHint");
            var mapsLink = document.getElementById("mapsLink");
            var gpsBtn = document.getElementById("gpsBtn");

            function captureGps(silent) {
                if (!navigator.geolocation) {
                    if (gpsHint) {
                        gpsHint.textContent = "Geolocation is not supported on this device.";
                        gpsHint.classList.add("is-error");
                    }
                    return;
                }
                if (gpsHint) {
                    gpsHint.classList.remove("is-error");
                    gpsHint.textContent = "Fetching location…";
                }

                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        var lat = pos.coords.latitude.toFixed(6);
                        var lng = pos.coords.longitude.toFixed(6);
                        if (gpsInput) gpsInput.value = lat + ", " + lng;
                        if (mapsLink) mapsLink.value = "https://www.google.com/maps?q=" + lat + "," + lng;
                        if (gpsHint) gpsHint.textContent = "Captured (±" + Math.round(pos.coords.accuracy) + " m).";
                        updateProgress();
                    },
                    function(err) {
                        if (!gpsHint) return;
                        gpsHint.classList.add("is-error");
                        gpsHint.textContent = err.code === 1 ?
                            "Location permission denied — tap Capture to retry." :
                            "Could not fetch location. Tap Capture to retry.";
                    }, {
                        enableHighAccuracy: true,
                        timeout: 12000,
                        maximumAge: 0
                    }
                );
                void silent;
            }

            if (gpsBtn) gpsBtn.addEventListener("click", function() {
                captureGps(false);
            });
            if (!revisitData || Object.keys(revisitData).length === 0) {
                captureGps(true);
            }

            // ---- 4. Quantity steppers + total ----
            var totalEl = document.getElementById("qtyTotal");
            var totalInput = document.getElementById("qtyTotalInput");

            function recalcTotal() {
                var sum = 0;
                form.querySelectorAll(".js-qty").forEach(function(i) {
                    var v = parseInt(i.value, 10);
                    sum += isNaN(v) || v < 0 ? 0 : v;
                });
                if (totalEl) totalEl.textContent = sum;
                if (totalInput) totalInput.value = sum;
            }

            form.querySelectorAll(".svf-stepper__btn").forEach(function(btn) {
                btn.addEventListener("click", function() {
                    var input = btn.parentElement.querySelector(".js-qty");
                    var step = parseInt(btn.dataset.step, 10);
                    var v = parseInt(input.value, 10);
                    input.value = Math.max(0, (isNaN(v) ? 0 : v) + step);
                    recalcTotal();
                    updateProgress();
                });
            });

            form.addEventListener("input", function(e) {
                if (e.target.classList.contains("js-qty")) recalcTotal();
            });
            recalcTotal();

            // ---- 5. Follow-up date toggle ----
            var followUpToggle = form.querySelector('input[name="follow_up"]');
            var followUpDateWrap = document.getElementById("followUpDateWrap");
            var followUpDate = document.getElementById("followUpdateDate");

            function toggleFollowUpDate() {
                if (!followUpToggle || !followUpDateWrap || !followUpDate) return;

                var isRequired = followUpToggle.checked;
                followUpDateWrap.style.display = isRequired ? "block" : "none";
                followUpDate.required = isRequired;
                followUpDate.disabled = !isRequired;

                if (!isRequired) {
                    followUpDate.value = "";
                }
            }

            if (followUpToggle) {
                followUpToggle.addEventListener("change", toggleFollowUpDate);
                toggleFollowUpDate();
            }

            applyRevisitData();

            // ---- 6. Remarks counter ----
            var remarks = form.querySelector('textarea[name="remarks"]');
            var remarkCount = document.getElementById("remarkCount");
            if (remarks && remarkCount) {
                remarks.addEventListener("input", function() {
                    remarkCount.textContent = remarks.value.length;
                });
            }

            // ---- 7. Progress indicator ----
            var progress = document.getElementById("svfProgress");
            var tracked = [
                'input[name="customer_name"]',
                'input[name="mobile"]',
                "#stateSelect",
                "#districtSelect",
                'input[name="construction_stage"]',
                'input[name="products[]"]',
                'select[name="timeline"]',
                'input[name="interest"]'
            ];

            function filled(sel) {
                var nodes = form.querySelectorAll(sel);
                for (var i = 0; i < nodes.length; i++) {
                    var n = nodes[i];
                    if (n.type === "radio" || n.type === "checkbox") {
                        if (n.checked) return true;
                    } else if (String(n.value).trim() !== "") return true;
                }
                return false;
            }

            function updateProgress() {
                if (!progress) return;
                var done = tracked.filter(filled).length;
                progress.style.width = Math.round((done / tracked.length) * 100) + "%";
            }

            form.addEventListener("input", updateProgress);
            form.addEventListener("change", updateProgress);
            updateProgress();

            // ---- 7. Multi-select "at least one" validation + AJAX submit ----
            var submitBtn = document.getElementById("svfSubmitBtn");
            var submitLoader = document.getElementById("svfSubmitLoader");
            var successOverlay = document.getElementById("svfSuccessOverlay");
            var successMessage = document.getElementById("svfSuccessMessage");
            var redirectCountdown = document.getElementById("svfRedirectCountdown");
            var errorBanner = document.getElementById("svfErrorBanner");
            var listingUrl = @json(route('admin.site_visit_record'));
            var isSubmitting = false;

            function showLoader(show) {
                if (!submitLoader) return;
                submitLoader.classList.toggle("is-visible", show);
                submitLoader.setAttribute("aria-hidden", show ? "false" : "true");
            }

            function showError(message) {
                if (!errorBanner) return;
                errorBanner.textContent = message;
                errorBanner.classList.add("is-visible");
                errorBanner.scrollIntoView({ behavior: "smooth", block: "start" });
            }

            function clearError() {
                if (!errorBanner) return;
                errorBanner.textContent = "";
                errorBanner.classList.remove("is-visible");
            }

            function setSubmitting(state) {
                isSubmitting = state;
                if (submitBtn) submitBtn.disabled = state;
            }

            function showSuccessAndRedirect(message, redirectUrl) {
                if (successMessage) successMessage.textContent = message;
                if (successOverlay) {
                    successOverlay.classList.add("is-visible");
                    successOverlay.setAttribute("aria-hidden", "false");
                }

                var seconds = 3;
                if (redirectCountdown) redirectCountdown.textContent = String(seconds);

                var timer = setInterval(function () {
                    seconds -= 1;
                    if (redirectCountdown) redirectCountdown.textContent = String(Math.max(seconds, 0));
                    if (seconds <= 0) {
                        clearInterval(timer);
                        window.location.href = redirectUrl || listingUrl;
                    }
                }, 1000);
            }

            function collectValidationErrors(payload) {
                if (!payload || !payload.errors) {
                    return payload && payload.message ? payload.message : "Unable to submit the visit report.";
                }

                var messages = [];
                Object.keys(payload.errors).forEach(function (key) {
                    var fieldErrors = payload.errors[key];
                    if (Array.isArray(fieldErrors)) {
                        fieldErrors.forEach(function (msg) {
                            messages.push(msg);
                        });
                    }
                });

                return messages.length ? messages.join(" ") : payload.message;
            }

            form.addEventListener("submit", function(e) {
                e.preventDefault();
                clearError();

                if (isSubmitting) {
                    return;
                }

                var boxes = form.querySelectorAll('input[name="products[]"]');
                var any = Array.prototype.some.call(boxes, function(b) {
                    return b.checked;
                });
                if (!any) {
                    boxes[0].closest(".svf-card").scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });
                    boxes[0].setCustomValidity("Select at least one product.");
                    boxes[0].reportValidity();
                    return;
                }
                boxes.forEach(function(b) {
                    b.setCustomValidity("");
                });

                if (!form.reportValidity()) {
                    return;
                }

                setSubmitting(true);
                showLoader(true);

                var formData = new FormData(form);

                fetch(form.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Accept": "application/json"
                    },
                    credentials: "same-origin"
                })
                    .then(function (response) {
                        return response.json().then(function (payload) {
                            return { ok: response.ok, status: response.status, payload: payload };
                        }).catch(function () {
                            return {
                                ok: false,
                                status: response.status,
                                payload: { message: "Unexpected server response. Please try again." }
                            };
                        });
                    })
                    .then(function (result) {
                        showLoader(false);
                        setSubmitting(false);

                        if (result.ok && result.payload && result.payload.success) {
                            showSuccessAndRedirect(
                                result.payload.message || "Visit report saved successfully.",
                                result.payload.redirect_url || listingUrl
                            );
                            return;
                        }

                        showError(collectValidationErrors(result.payload));
                    })
                    .catch(function () {
                        showLoader(false);
                        setSubmitting(false);
                        showError("Network error while submitting. Please check your connection and try again.");
                    });
            });

            form.addEventListener("reset", function() {
                setTimeout(function() {
                    recalcTotal();
                    updateProgress();
                    if (remarkCount) remarkCount.textContent = "0";
                    if (distSel) {
                        distSel.innerHTML = '<option value="">Select state first</option>';
                        distSel.disabled = true;
                    }
                    if (followUpToggle) followUpToggle.checked = false;
                    if (followUpDate) followUpDate.value = "";
                    if (followUpDateWrap) followUpDateWrap.style.display = "none";
                    if (dateEl) dateEl.value = now.getFullYear() + "-" + pad(now.getMonth() + 1) + "-" +
                        pad(now.getDate());
                    if (timeEl) timeEl.value = pad(now.getHours()) + ":" + pad(now.getMinutes());
                    captureGps(true);
                    toggleFollowUpDate();
                }, 0);
            });
        })();
    </script>


</body>

</html>
