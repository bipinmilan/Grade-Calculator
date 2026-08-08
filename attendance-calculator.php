<?php
/**
 * Template Name: Attendance Calculator
 * Description: Attendance Calculator. Uses the theme's existing
 * header/footer via get_header()/get_footer(). Everything below is scoped
 * under .ngen-page so it can't clash with other page styles.
 *
 * DATA: $sample_names below is placeholder data so the tool works out of
 * the box. Replace the array (or better, swap the block marked
 * "REPLACE WITH REAL DATA" for a WP_Query / REST call against your real
 * names database) once that's wired up. Everything else — filters,
 * shuffling, flip cards, favorites — works client-side against whatever
 * array is passed to rootlineNames.
 */
get_header();
?>
<div class="attendance-page-head">
  <div class="wrap">
    <span class="eyebrow-coral">Any required percentage</span>
    <div class="stamp-lg"><i class="fa-solid fa-user-check"></i></div>
    <h1>Attendance Calculator</h1>
    <p>Check your current attendance, see how many classes you can miss or need to attend, and run what-if scenarios — against any required percentage your institution sets.</p>
  </div>
</div>

<main>
  <div class="wrap">

    <!-- ---------- Main Calculator ---------- -->
    <section class="card" aria-label="Attendance calculator">
      <h2><i class="fa-solid fa-calculator"></i> Calculate Your Attendance</h2>
      <p class="card-sub">Enter your numbers and pick the attendance percentage your course actually requires — no fixed 75% assumption.</p>

      <div class="badge-row">
        <div class="badge"><div class="badge-val" id="liveBadge">--%</div><div class="badge-lbl">Live Attendance</div></div>
      </div>

      <form id="attForm" novalidate>
        <div class="field-row">
          <div class="field">
            <label for="attended">Classes Attended</label>
            <div class="input-wrap">
              <i class="fa-solid fa-check"></i>
              <input type="number" id="attended" min="0" step="1" placeholder="e.g. 42" required>
            </div>
            <span class="error-msg" id="err-attended"></span>
          </div>
          <div class="field">
            <label for="held">Total Classes Held</label>
            <div class="input-wrap">
              <i class="fa-solid fa-list-ol"></i>
              <input type="number" id="held" min="0" step="1" placeholder="e.g. 55" required>
            </div>
            <span class="error-msg" id="err-held"></span>
          </div>
        </div>

        <div class="field">
          <label>Required Attendance</label>
          <div class="chip-row" id="requiredChips">
            <button type="button" class="chip" data-val="50">50%</button>
            <button type="button" class="chip" data-val="60">60%</button>
            <button type="button" class="chip" data-val="70">70%</button>
            <button type="button" class="chip active" data-val="75">75%</button>
            <button type="button" class="chip" data-val="80">80%</button>
            <button type="button" class="chip" data-val="85">85%</button>
            <button type="button" class="chip" data-val="90">90%</button>
            <button type="button" class="chip" data-val="95">95%</button>
            <button type="button" class="chip chip-custom" data-val="custom">Custom</button>
          </div>
          <div class="custom-wrap" id="customWrap">
            <div class="input-wrap">
              <i class="fa-solid fa-percent"></i>
              <input type="number" id="customRequired" min="1" max="100" step="0.1" placeholder="e.g. 78">
            </div>
          </div>
          <span class="error-msg" id="err-required"></span>
        </div>

        <button type="submit" class="btn btn-primary" id="calcBtn">
          <i class="fa-solid fa-calculator"></i> Calculate
        </button>
      </form>

      <div class="formula-box">
        <span>Formulas used</span>
        Attendance % = (Attended ÷ Held) × 100
        Classes you can miss = floor(Attended ÷ Required% − Held)
        Classes needed to reach target = ceil((Required% × Held − Attended) ÷ (1 − Required%))
      </div>
    </section>

    <!-- ---------- Result ---------- -->
    <section class="card" id="resultCard" aria-live="polite">
      <div class="result-hero">
        <div class="result-stamp"><b id="resultPct">--</b><span>ATTENDANCE</span></div>
        <span class="status-pill" id="statusPill">-- REQUIRED</span>
      </div>

      <div class="stats-grid">
        <div class="stat-box"><div class="val" id="statAttended">0</div><div class="lbl">Classes Attended</div></div>
        <div class="stat-box"><div class="val" id="statHeld">0</div><div class="lbl">Classes Held</div></div>
        <div class="stat-box"><div class="val" id="statRequired">0%</div><div class="lbl">Required Attendance</div></div>
        <div class="stat-box"><div class="val" id="statCurrent">0%</div><div class="lbl">Current Attendance</div></div>
        <div class="stat-box stat-miss"><div class="val" id="statMiss">0</div><div class="lbl">Classes You Can Miss</div></div>
        <div class="stat-box stat-need"><div class="val" id="statNeed">0</div><div class="lbl">Classes Needed to Reach Target</div></div>
      </div>

      <div class="improve-callout" id="improveCallout"></div>

      <div class="action-row">
        <button id="copyBtn"><i class="fa-solid fa-copy"></i> Copy</button>
        <button id="printBtn"><i class="fa-solid fa-print"></i> Print</button>
        <button id="shareBtn" style="flex:1 1 100%;"><i class="fa-solid fa-share-nodes"></i> Share Result</button>
      </div>
    </section>

    <!-- ---------- Stretch Goal ---------- -->
    <section class="card">
      <h2><i class="fa-solid fa-bullseye"></i> Check a Different Target</h2>
      <p class="card-sub">Curious about a higher (or lower) bar — like 80% instead of your required 75%? Pick any target below.</p>

      <div class="chip-row" id="stretchChips">
        <button type="button" class="chip" data-val="50">50%</button>
        <button type="button" class="chip" data-val="60">60%</button>
        <button type="button" class="chip" data-val="70">70%</button>
        <button type="button" class="chip" data-val="75">75%</button>
        <button type="button" class="chip active" data-val="80">80%</button>
        <button type="button" class="chip" data-val="85">85%</button>
        <button type="button" class="chip" data-val="90">90%</button>
        <button type="button" class="chip" data-val="95">95%</button>
        <button type="button" class="chip chip-custom" data-val="custom">Custom</button>
      </div>
      <div class="custom-wrap" id="stretchCustomWrap">
        <div class="input-wrap">
          <i class="fa-solid fa-percent"></i>
          <input type="number" id="stretchCustomRequired" min="1" max="100" step="0.1" placeholder="e.g. 82">
        </div>
      </div>

      <button type="button" class="btn btn-outline" id="stretchBtn" style="margin-top:16px;">
        <i class="fa-solid fa-magnifying-glass"></i> Check This Target
      </button>

      <div id="stretchResult"></div>
    </section>

    <!-- ---------- What-If Calculator ---------- -->
    <section class="card">
      <h2><i class="fa-solid fa-shuffle"></i> What-If Calculator</h2>
      <p class="card-sub">See how future classes would change your attendance before they happen.</p>

      <div class="mode-switch">
        <button type="button" class="mode-btn active" data-mode="attend">If I attend N more</button>
        <button type="button" class="mode-btn" data-mode="miss">If I miss N more</button>
        <button type="button" class="mode-btn" data-mode="ratio">If I attend X of next Y</button>
      </div>

      <div class="whatif-fields show" id="wf-attend">
        <div class="field">
          <label for="wfAttendN">Classes I'll Attend</label>
          <div class="input-wrap">
            <i class="fa-solid fa-plus"></i>
            <input type="number" id="wfAttendN" min="0" step="1" placeholder="e.g. 5">
          </div>
        </div>
      </div>

      <div class="whatif-fields" id="wf-miss">
        <div class="field">
          <label for="wfMissN">Classes I'll Miss</label>
          <div class="input-wrap">
            <i class="fa-solid fa-minus"></i>
            <input type="number" id="wfMissN" min="0" step="1" placeholder="e.g. 2">
          </div>
        </div>
      </div>

      <div class="whatif-fields" id="wf-ratio">
        <div class="field-row">
          <div class="field">
            <label for="wfRatioX">Classes I'll Attend</label>
            <div class="input-wrap">
              <i class="fa-solid fa-check"></i>
              <input type="number" id="wfRatioX" min="0" step="1" placeholder="e.g. 10">
            </div>
          </div>
          <div class="field">
            <label for="wfRatioY">Out of Next</label>
            <div class="input-wrap">
              <i class="fa-solid fa-list-ol"></i>
              <input type="number" id="wfRatioY" min="1" step="1" placeholder="e.g. 12">
            </div>
          </div>
        </div>
        <span class="error-msg" id="err-ratio"></span>
      </div>

      <button type="button" class="btn btn-primary" id="whatifBtn">
        <i class="fa-solid fa-wand-magic-sparkles"></i> Calculate What-If
      </button>

      <div id="whatifResult">
        <div class="whatif-compare">
          <div class="whatif-num"><div class="v" id="wfBefore">--%</div><div class="l">Now</div></div>
          <div class="whatif-arrow"><i class="fa-solid fa-arrow-right"></i></div>
          <div class="whatif-num"><div class="v" id="wfAfter">--%</div><div class="l">After</div></div>
        </div>
        <span class="status-pill" id="wfPill" style="display:block; text-align:center; width:fit-content; margin:0 auto;">--</span>
      </div>
    </section>

  </div>
</main>

<div class="toast" id="toast"></div>

<!-- ============================================================
     SEO / EDUCATIONAL CONTENT
     ============================================================ -->
<main>
  <div class="wrap">

    <section class="card">
      <span class="eyebrow" style="margin-bottom:14px;">Guide</span>
      <h2 style="font-size:1.4rem; margin-bottom:14px;"><i class="fa-solid fa-book-open" style="color:var(--coral); margin-right:8px;"></i>What Is the Attendance Calculator?</h2>
      <p style="color:var(--ink-soft); font-size:.95rem; margin-bottom:16px; line-height:1.7;">
        The <strong>Attendance Calculator</strong> works out your current attendance percentage from classes attended and classes held, then tells you exactly how many future classes you can afford to miss — or how many you must attend — to meet any <strong>required attendance percentage</strong>. Requirements vary by school, so nothing here is hard-coded to 75%: choose 50% through 95% in one tap, or enter any custom minimum attendance your institution sets.
      </p>
      <p style="color:var(--ink-soft); font-size:.95rem; margin-bottom:0; line-height:1.7;">
        Beyond the basic percentage, it includes a <strong>classes-you-can-miss calculator</strong>, a <strong>classes-needed-to-reach-target calculator</strong>, a second "stretch goal" check for any other percentage you're curious about, and a <strong>what-if attendance calculator</strong> for testing future scenarios before they happen.
      </p>
    </section>

    <section class="card">
      <h2 style="font-size:1.2rem; margin-bottom:16px;"><i class="fa-solid fa-list-check" style="color:var(--coral); margin-right:8px;"></i>How to Use It</h2>
      <div class="steps">
        <div class="step">
          <div class="num">1</div>
          <h3>Enter your numbers</h3>
          <p>Classes attended and total classes held so far — the live badge shows your current percentage as you type.</p>
        </div>
        <div class="step">
          <div class="num">2</div>
          <h3>Pick your required %</h3>
          <p>Tap a preset (50–95%) or choose Custom for any other minimum your course actually requires.</p>
        </div>
        <div class="step">
          <div class="num">3</div>
          <h3>Read your results</h3>
          <p>See how many classes you can miss, how many you need to attend, and test what-if scenarios for the classes ahead.</p>
        </div>
      </div>
    </section>

    <!-- ---------- FAQ ---------- -->
    <section class="card" id="faq">
      <h2 style="font-size:1.3rem; margin-bottom:6px; display:flex; align-items:center; gap:9px;">
        <i class="fa-solid fa-circle-question" style="color:var(--coral);"></i> Frequently Asked Questions
      </h2>
      <p class="card-sub">Common questions about calculating attendance and meeting a required percentage.</p>

      <details>
        <summary>How is attendance percentage calculated?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">Attendance percentage is classes attended divided by total classes held, multiplied by 100. For example, 42 attended out of 55 held gives 76.36%.</p>
      </details>

      <details>
        <summary>How many classes can I miss and still meet my requirement?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">It depends on your current attended count, held count, and required percentage. The calculator works out the maximum future classes you can miss while your attendance stays at or above your required minimum — no matter what that minimum is.</p>
      </details>

      <details>
        <summary>My requirement isn't 75% — can I still use this?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">Yes. Every calculation is based on whichever required percentage you select — 50% through 95% as presets, or any custom value — nothing is fixed to a single institution's rule.</p>
      </details>

      <details>
        <summary>What does "classes needed to reach target" mean?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">If your current attendance is below your required percentage, this is the number of classes you'd need to attend consecutively (assuming you don't miss any of them) to bring your overall percentage back up to that requirement.</p>
      </details>

      <details>
        <summary>What is the What-If Calculator for?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">It lets you test a scenario before it happens — for example, "if I attend 5 more classes" or "if I attend 10 out of the next 12" — and shows the resulting attendance percentage without changing your actual saved numbers.</p>
      </details>

      <details>
        <summary>Is this calculator free and is my data stored?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">Yes, it's completely free with no sign-up. All calculations run in your browser — no attendance numbers are sent to or stored on a server.</p>
      </details>
    </section>

  </div>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    { "@type": "Question", "name": "How is attendance percentage calculated?", "acceptedAnswer": { "@type": "Answer", "text": "Attendance percentage is classes attended divided by total classes held, multiplied by 100." } },
    { "@type": "Question", "name": "How many classes can I miss and still meet my requirement?", "acceptedAnswer": { "@type": "Answer", "text": "The calculator works out the maximum number of future classes that can be missed while attendance stays at or above the required minimum, based on classes attended, classes held, and the selected requirement." } },
    { "@type": "Question", "name": "Can this be used for any required attendance percentage, not just 75%?", "acceptedAnswer": { "@type": "Answer", "text": "Yes, calculations are based on whichever required percentage is selected, from 50% to 95% as presets or any custom value." } },
    { "@type": "Question", "name": "What does classes needed to reach target mean?", "acceptedAnswer": { "@type": "Answer", "text": "It is the number of classes that would need to be attended consecutively to bring overall attendance back up to the required percentage, if current attendance is below that target." } },
    { "@type": "Question", "name": "What is the What-If Calculator for?", "acceptedAnswer": { "@type": "Answer", "text": "It lets a scenario be tested before it happens, such as attending a set number of upcoming classes, and shows the resulting attendance percentage without changing saved numbers." } },
    { "@type": "Question", "name": "Is the attendance calculator free and is data stored?", "acceptedAnswer": { "@type": "Answer", "text": "It is free with no sign-up required, and all calculations run in the browser with no data sent to or stored on a server." } }
  ]
}
</script>
<?php
get_footer();
?>