<!-- resources/views/site-visit-form.blade.php -->
<!-- Compile SCSS: resources/sass/site-visit-form.scss -> public/css/site-visit-form.css -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>Customer Site Visit Form</title>
  <meta name="description" content="Field sales form to capture customer site visit details, construction stage, product requirements and follow-ups.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  
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
    <h1>Customer Site Visit Form</h1>
    <p>Capture the visit in one pass — details, site, requirement, and next step.</p>
  </div>

  <form class="svf-form" id="svfForm" method="POST" action="{{ route('site-visit.store') }}" novalidate>
    @csrf

    {{-- 1. Sales Executive --}}
    <section class="svf-card">
      <div class="svf-card__head">
        <span class="svf-step">01</span>
        <div><h2>Sales Executive Details</h2><p>Auto-populated from your session</p></div>
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
        <div><h2>Customer Details</h2><p>Who you met on site</p></div>
      </div>
      <div class="svf-grid svf-grid--2">
        <label class="svf-field">
          <span class="svf-label">Customer Name <b>*</b></span>
          <input type="text" name="customer_name" placeholder="Full name" required>
        </label>
        <label class="svf-field">
          <span class="svf-label">Mobile Number <b>*</b></span>
          <input type="tel" name="mobile" inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}" placeholder="10-digit mobile" required>
        </label>
        <label class="svf-field">
          <span class="svf-label">Alternate Mobile <small>Optional</small></span>
          <input type="tel" name="alt_mobile" inputmode="numeric" maxlength="10" placeholder="10-digit mobile">
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
        <div><h2>Site Location</h2><p>Where the installation happens</p></div>
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
          <input type="text" name="pincode" inputmode="numeric" maxlength="6" placeholder="6-digit PIN">
        </label>
        <div class="svf-field">
          <span class="svf-label">GPS Location <small>Auto capture</small></span>
          <div class="svf-gps">
            <input type="text" name="gps" id="gpsInput" placeholder="Latitude, Longitude" readonly>
            <button type="button" class="svf-btn svf-btn--ghost" id="gpsBtn">Capture</button>
          </div>
          <span class="svf-hint" id="gpsHint">Allow location access to auto-fill.</span>
        </div>
        <label class="svf-field svf-col-span">
          <span class="svf-label">Google Maps Link <small>Auto-generated</small></span>
          <input type="url" name="maps_link" id="mapsLink" placeholder="https://maps.google.com/?q=…" readonly>
        </label>
      </div>
    </section>

    {{-- 4. Construction --}}
    <section class="svf-card">
      <div class="svf-card__head">
        <span class="svf-step">04</span>
        <div><h2>Construction Details</h2><p>Current stage of the site</p></div>
      </div>
      <div class="svf-pills" role="radiogroup" aria-label="Construction stage">
        @foreach ([
          'Foundation / Site Preparation',
          'Structure / Masonry in Progress',
          'Roofing Completed',
          'Finishing Stage (Doors & Windows Installation)',
          'Ready for Installation',
          'Renovation / Replacement',
        ] as $stage)
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
        <div><h2>Product Requirement</h2><p>Multi-select — at least one required</p></div>
      </div>
      <div class="svf-checks svf-checks--tiles">
        @foreach (['Doors','Windows','Doors & Windows','Frames','Hardware / Accessories','Others'] as $p)
          <label class="svf-check">
            <input type="checkbox" name="products[]" value="{{ $p }}" data-required-group="products">
            <span class="svf-check__box" aria-hidden="true"></span>
            <span class="svf-check__text">{{ $p }}</span>
          </label>
        @endforeach
      </div>

      <div class="svf-divider"><span>Product Category <small>Optional</small></span></div>
      <div class="svf-checks">
        @foreach ([
          'Embossed Wood / RAL Finish Doors',
          'Plain Wood Finish Doors',
          'Plain Steel Finish Doors',
          'Fly Mesh Doors',
          'Double Leaf Doors',
          'Reflections Natura Series',
          'French Doors (Lumière Series)',
          'Pebble Series (Casement)',
          'Pebble Series (Sliding)',
          'Swing & Slide Windows',
          'Doors / Windows with Ventilator',
        ] as $c)
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
        <div><h2>Quantity Requirement</h2><p>Units per product type</p></div>
      </div>
      <div class="svf-qty">
        @foreach (['doors' => 'Doors','windows' => 'Windows','frames' => 'Frames','others' => 'Others'] as $key => $label)
          <div class="svf-qty__row">
            <span class="svf-qty__label">{{ $label }}</span>
            <div class="svf-stepper">
              <button type="button" class="svf-stepper__btn" data-step="-1" aria-label="Decrease {{ $label }}">−</button>
              <input type="number" class="js-qty" name="qty[{{ $key }}]" value="0" min="0" inputmode="numeric">
              <button type="button" class="svf-stepper__btn" data-step="1" aria-label="Increase {{ $label }}">+</button>
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
        <div><h2>Timeline &amp; Budget</h2><p>Buying window and expected spend</p></div>
      </div>
      <div class="svf-grid svf-grid--2">
        <label class="svf-field">
          <span class="svf-label">Purchase Timeline <b>*</b></span>
          <select name="timeline" required>
            <option value="">Select timeline</option>
            @foreach (['Within 1 Month','Within 3 Months','3 - 6 Months','After 6 Months'] as $t)
              <option value="{{ $t }}">{{ $t }}</option>
            @endforeach
          </select>
        </label>
        <label class="svf-field">
          <span class="svf-label">Budget <small>Optional</small></span>
          <select name="budget">
            <option value="">Select budget</option>
            @foreach (['Below ₹1 Lakh','₹1–3 Lakhs','₹3–5 Lakhs','Above ₹5 Lakhs'] as $b)
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
        <div><h2>Competitor Information</h2><p>What else is being considered</p></div>
      </div>
      <label class="svf-field">
        <span class="svf-label">Competitor</span>
        <select name="competitor">
          <option value="">Select competitor</option>
          @foreach (['Godrej','Tostem','Fenesta','Asian Paints','Jindal','Local Fabricator','Wooden Door','PVC / uPVC','Others'] as $c)
            <option value="{{ $c }}">{{ $c }}</option>
          @endforeach
        </select>
      </label>
    </section>

    {{-- 10, 11, 12 --}}
    <section class="svf-card">
      <div class="svf-card__head">
        <span class="svf-step">09</span>
        <div><h2>Outcome</h2><p>Interest, follow-up and notes</p></div>
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

      <label class="svf-field">
        <span class="svf-label">Remarks</span>
        <textarea name="remarks" rows="4" maxlength="1000" placeholder="Observations, commitments, objections…"></textarea>
        <span class="svf-hint"><span id="remarkCount">0</span>/1000</span>
      </label>
    </section>

    <div class="svf-actions">
      <button type="reset" class="svf-btn svf-btn--ghost">Clear</button>
      <button type="submit" class="svf-btn svf-btn--primary">Submit Visit Report</button>
    </div>
  </form>
</main>

<script type="module">

    // public/js/site-visit-form.js
(function () {
  "use strict";

  // ---- Replace / extend with your own master data (or inject from Laravel) ----
  var STATE_DISTRICTS = window.SVF_STATE_DISTRICTS || {
    "Tamil Nadu": ["Chennai", "Coimbatore", "Madurai", "Salem", "Tiruchirappalli", "Erode", "Vellore"],
    "Karnataka": ["Bengaluru Urban", "Mysuru", "Mangaluru", "Hubballi", "Belagavi"],
    "Kerala": ["Thiruvananthapuram", "Ernakulam", "Kozhikode", "Thrissur", "Kollam"],
    "Maharashtra": ["Mumbai Suburban", "Pune", "Nagpur", "Nashik", "Thane"],
    "Telangana": ["Hyderabad", "Rangareddy", "Warangal", "Karimnagar"],
    "Andhra Pradesh": ["Visakhapatnam", "Guntur", "Krishna", "Nellore", "Tirupati"],
    "Delhi": ["New Delhi", "South Delhi", "North Delhi", "West Delhi"],
    "Gujarat": ["Ahmedabad", "Surat", "Vadodara", "Rajkot"]
  };

  var form = document.getElementById("svfForm");
  if (!form) return;

  // ---- 1. Auto date & time ----
  var now = new Date();
  var pad = function (n) { return String(n).padStart(2, "0"); };
  var dateEl = document.getElementById("visitDate");
  var timeEl = document.getElementById("visitTime");
  if (dateEl) dateEl.value = now.getFullYear() + "-" + pad(now.getMonth() + 1) + "-" + pad(now.getDate());
  if (timeEl) timeEl.value = pad(now.getHours()) + ":" + pad(now.getMinutes());

  // ---- 2. State / District ----
  var stateSel = document.getElementById("stateSelect");
  var distSel = document.getElementById("districtSelect");

  if (stateSel && distSel) {
    Object.keys(STATE_DISTRICTS).sort().forEach(function (s) {
      var o = document.createElement("option");
      o.value = o.textContent = s;
      stateSel.appendChild(o);
    });

    stateSel.addEventListener("change", function () {
      var list = STATE_DISTRICTS[stateSel.value] || [];
      distSel.innerHTML = "";
      var ph = document.createElement("option");
      ph.value = "";
      ph.textContent = list.length ? "Select district" : "Select state first";
      distSel.appendChild(ph);
      list.forEach(function (d) {
        var o = document.createElement("option");
        o.value = o.textContent = d;
        distSel.appendChild(o);
      });
      distSel.disabled = !list.length;
      updateProgress();
    });
  }

  // ---- 3. GPS capture + maps link ----
  var gpsInput = document.getElementById("gpsInput");
  var gpsHint = document.getElementById("gpsHint");
  var mapsLink = document.getElementById("mapsLink");
  var gpsBtn = document.getElementById("gpsBtn");

  function captureGps(silent) {
    if (!navigator.geolocation) {
      if (gpsHint) { gpsHint.textContent = "Geolocation is not supported on this device."; gpsHint.classList.add("is-error"); }
      return;
    }
    if (gpsHint) { gpsHint.classList.remove("is-error"); gpsHint.textContent = "Fetching location…"; }

    navigator.geolocation.getCurrentPosition(
      function (pos) {
        var lat = pos.coords.latitude.toFixed(6);
        var lng = pos.coords.longitude.toFixed(6);
        if (gpsInput) gpsInput.value = lat + ", " + lng;
        if (mapsLink) mapsLink.value = "https://www.google.com/maps?q=" + lat + "," + lng;
        if (gpsHint) gpsHint.textContent = "Captured (±" + Math.round(pos.coords.accuracy) + " m).";
        updateProgress();
      },
      function (err) {
        if (!gpsHint) return;
        gpsHint.classList.add("is-error");
        gpsHint.textContent = err.code === 1
          ? "Location permission denied — tap Capture to retry."
          : "Could not fetch location. Tap Capture to retry.";
      },
      { enableHighAccuracy: true, timeout: 12000, maximumAge: 0 }
    );
    void silent;
  }

  if (gpsBtn) gpsBtn.addEventListener("click", function () { captureGps(false); });
  captureGps(true);

  // ---- 4. Quantity steppers + total ----
  var totalEl = document.getElementById("qtyTotal");
  var totalInput = document.getElementById("qtyTotalInput");

  function recalcTotal() {
    var sum = 0;
    form.querySelectorAll(".js-qty").forEach(function (i) {
      var v = parseInt(i.value, 10);
      sum += isNaN(v) || v < 0 ? 0 : v;
    });
    if (totalEl) totalEl.textContent = sum;
    if (totalInput) totalInput.value = sum;
  }

  form.querySelectorAll(".svf-stepper__btn").forEach(function (btn) {
    btn.addEventListener("click", function () {
      var input = btn.parentElement.querySelector(".js-qty");
      var step = parseInt(btn.dataset.step, 10);
      var v = parseInt(input.value, 10);
      input.value = Math.max(0, (isNaN(v) ? 0 : v) + step);
      recalcTotal();
      updateProgress();
    });
  });

  form.addEventListener("input", function (e) {
    if (e.target.classList.contains("js-qty")) recalcTotal();
  });
  recalcTotal();

  // ---- 5. Remarks counter ----
  var remarks = form.querySelector('textarea[name="remarks"]');
  var remarkCount = document.getElementById("remarkCount");
  if (remarks && remarkCount) {
    remarks.addEventListener("input", function () {
      remarkCount.textContent = remarks.value.length;
    });
  }

  // ---- 6. Progress indicator ----
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
      if (n.type === "radio" || n.type === "checkbox") { if (n.checked) return true; }
      else if (String(n.value).trim() !== "") return true;
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

  // ---- 7. Multi-select "at least one" validation ----
  form.addEventListener("submit", function (e) {
    var boxes = form.querySelectorAll('input[name="products[]"]');
    var any = Array.prototype.some.call(boxes, function (b) { return b.checked; });
    if (!any) {
      e.preventDefault();
      boxes[0].closest(".svf-card").scrollIntoView({ behavior: "smooth", block: "center" });
      boxes[0].setCustomValidity("Select at least one product.");
      boxes[0].reportValidity();
      return;
    }
    boxes.forEach(function (b) { b.setCustomValidity(""); });
  });

  form.addEventListener("reset", function () {
    setTimeout(function () {
      recalcTotal();
      updateProgress();
      if (remarkCount) remarkCount.textContent = "0";
      if (distSel) { distSel.innerHTML = '<option value="">Select state first</option>'; distSel.disabled = true; }
      if (dateEl) dateEl.value = now.getFullYear() + "-" + pad(now.getMonth() + 1) + "-" + pad(now.getDate());
      if (timeEl) timeEl.value = pad(now.getHours()) + ":" + pad(now.getMinutes());
      captureGps(true);
    }, 0);
  });
})();


</script>


</body>
</html>
