<?php
/**
 * Template Name: Final Grade
 * Description: What's Ahead Grade?. Uses the theme's existing
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
<div class="page-head3">
  <div class="wrap">
    <span class="eyebrow">What's ahead</span>
    <div class="stamp-lg"><i class="fa-solid fa-bullseye"></i></div>
    <h1>What Do I Need on the Final?</h1>
    <p>Tell it your current grade and the final's weight, and it works backward to the exact score you need to hit your target overall grade.</p>
  </div>
</div>

<main>
  <div class="wrap">

    <section class="card" aria-label="Target grade calculator">
      <h2><i class="fa-solid fa-bullseye"></i> Set Your Target</h2>
      <p class="card-sub">Works with any exam weighting — and flags when a target is already locked in, or out of reach.</p>

      <div class="field">
        <label for="currentGrade">Current Grade (%)</label>
        <div class="input-wrap">
          <i class="fa-solid fa-chart-line"></i>
          <input type="number" id="currentGrade" min="0" max="100" step="0.1" placeholder="e.g. 78">
        </div>
        <span class="error-msg" id="err-currentGrade"></span>
      </div>

      <div class="field">
        <label for="finalWeight">Final Exam Weight (%)</label>
        <div class="input-wrap">
          <i class="fa-solid fa-weight-hanging"></i>
          <input type="number" id="finalWeight" min="1" max="100" step="0.1" placeholder="e.g. 30">
        </div>
        <span class="error-msg" id="err-finalWeight"></span>
      </div>

      <div class="field">
        <label for="desiredGrade">Desired Overall Grade (%)</label>
        <div class="input-wrap">
          <i class="fa-solid fa-flag-checkered"></i>
          <input type="number" id="desiredGrade" min="0" max="100" step="0.1" placeholder="e.g. 85">
        </div>
        <span class="error-msg" id="err-desiredGrade"></span>
      </div>

      <button type="button" class="btn btn-primary" id="calcTargetBtn">
        <i class="fa-solid fa-calculator"></i> Calculate Needed Score
      </button>

      <div id="targetResult">
        <div class="target-hero">
          <div class="target-stamp"><b id="neededScore">--</b><span>NEEDED</span></div>
          <span class="verdict-pill" id="verdictPill">REACHABLE</span>
          <p class="explain" id="explainText"></p>
        </div>
        <div class="breakdown">
          <div class="stat-box">
            <div class="val" id="bdCurrent">0%</div>
            <div class="lbl">Current Grade</div>
          </div>
          <div class="stat-box">
            <div class="val" id="bdWeight">0%</div>
            <div class="lbl">Final Weight</div>
          </div>
          <div class="stat-box">
            <div class="val" id="bdDesired">0%</div>
            <div class="lbl">Target Overall</div>
          </div>
        </div>
      </div>
    </section>

  </div>
</main>

<?php
get_footer();
?>