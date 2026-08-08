<?php
/**
 * Template Name: GPA to Percentage
 * Description: GPA To Percentage and Percentage to GPA. Uses the theme's existing
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
<div class="page-head4">
  <div class="wrap">
    <span class="eyebrowgpa">Any grading scale</span>
    <div class="stamp-lg"><i class="fa-solid fa-arrows-left-right"></i></div>
    <h1>GPA to Percentage Calculator</h1>
    <p>Convert between GPA and percentage on 10 different scales — with a live letter grade, a slider for quick adjustments, and an instant side-by-side comparison across every other scale.</p>
  </div>
</div>

<main>
  <div class="wrap" id="gpatopercent">

    <!-- ---------- Converter Card ---------- -->
    <section class="card" aria-label="GPA to percentage converter">
      <h2><i class="fa-solid fa-calculator"></i> Convert</h2>
      <p class="card-sub">Pick a direction, choose your scale, and adjust the number or the slider — the result updates as you go.</p>

      <div class="mode-switch" role="tablist">
        <button type="button" class="mode-btn active" id="modeGpaBtn" role="tab" aria-selected="true">
          <i class="fa-solid fa-graduation-cap"></i> GPA → Percentage
        </button>
        <button type="button" class="mode-btn" id="modePercentBtn" role="tab" aria-selected="false">
          <i class="fa-solid fa-percent"></i> Percentage → GPA
        </button>
      </div>

      <form id="convertForm" novalidate>

        <div class="field">
          <label for="scaleSelect">Grading Scale</label>
          <div class="input-wrap">
            <i class="fa-solid fa-ruler"></i>
            <select id="scaleSelect">
              <option value="4.0">4.0 Scale (US Standard)</option>
              <option value="4.3">4.3 Scale (Canada)</option>
              <option value="4.5">4.5 Scale</option>
              <option value="5.0">5.0 Scale</option>
              <option value="6.0">6.0 Scale</option>
              <option value="7.0">7.0 Scale (UK / Australia / NZ)</option>
              <option value="9.0">9.0 Scale</option>
              <option value="10.0" selected>10.0 Scale (India)</option>
              <option value="12.0">12.0 Scale</option>
              <option value="20.0">20.0 Scale (France)</option>
            </select>
            <i class="fa-solid fa-chevron-down"></i>
          </div>
        </div>

        <div class="field">
          <label for="valueInput" id="valueLabel">Your GPA</label>
          <div class="input-wrap">
            <i class="fa-solid fa-star"></i>
            <input type="number" id="valueInput" min="0" step="0.01" inputmode="decimal" placeholder="e.g. 8.4" required aria-describedby="err-value">
          </div>
          <span class="error-msg" id="err-value"></span>
          <div class="slider-row">
            <input type="range" id="valueSlider" min="0" max="10" step="0.01" value="0">
            <span class="slider-val" id="sliderVal">0.00</span>
          </div>
        </div>

        <div class="row-toggle">
          <span><i class="fa-solid fa-bolt"></i> Live calculation as you type</span>
          <label class="switch">
            <input type="checkbox" id="liveToggle" checked>
            <span class="slider-toggle"></span>
          </label>
        </div>

        <button type="submit" class="btn btn-primary" id="calcBtn">
          <i class="fa-solid fa-calculator"></i> Calculate
        </button>
      </form>

      <div class="formula-box" id="formulaBox">
        <span>Formula used</span>
        Percentage = (GPA ÷ Scale Max) × 100
      </div>
    </section>

    <!-- ---------- Result Card ---------- -->
    <section class="card" id="resultCard" aria-live="polite">
      <div class="result-hero">
        <div class="result-stamp"><b id="resultBig">--</b><span id="resultUnit">PERCENT</span></div>
        <p class="result-recap" id="resultRecap"></p>
        <span class="grade-pill" id="gradePill">A+</span>
      </div>

      <div class="compare-head">
        <h3><i class="fa-solid fa-table-cells" style="color:var(--teal); margin-right:6px;"></i>Same result, every scale</h3>
      </div>
      <div style="overflow-x:auto;">
        <table class="compare">
          <thead>
            <tr><th>Scale</th><th>Equivalent GPA</th></tr>
          </thead>
          <tbody id="compareBody"></tbody>
        </table>
      </div>

      <div class="action-row">
        <button id="copyBtn"><i class="fa-solid fa-copy"></i> Copy</button>
        <button id="shareBtn"><i class="fa-solid fa-share-nodes"></i> Share</button>
      </div>
    </section>

    <!-- ---------- How it works ---------- -->
    <section class="card">
      <h2><i class="fa-solid fa-lightbulb"></i> How the Conversion Works</h2>
      <p class="card-sub">One formula drives every scale, so the calculator and the comparison table can never disagree with each other.</p>
      <div class="steps">
        <div class="step">
          <div class="num">1</div>
          <h3>Pick your scale</h3>
          <p>Select the grading scale your institution actually uses — from 4.0 up to 20.0.</p>
        </div>
        <div class="step">
          <div class="num">2</div>
          <h3>Enter a value</h3>
          <p>Type a GPA or a percentage, or drag the slider — the result updates live by default.</p>
        </div>
        <div class="step">
          <div class="num">3</div>
          <h3>Compare instantly</h3>
          <p>See the same result expressed on every other common scale, side by side.</p>
        </div>
      </div>
    </section>

  </div>
</main>

<div class="toast" id="toast"></div>
<?php
get_footer();
?>