<?php
/**
 * Template Name: Grade Calculator
 * Description: Grade Calculator. Uses the theme's existing
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
<div class="page-head">
  <div class="wrap">
    <span class="eyebrow">Single exam</span>
    <div class="stamp-lg"><i class="fa-solid fa-graduation-cap"></i></div>
    <h1>Grade Calculator</h1>
    <p>Enter total, attempted and wrong questions to get your percentage, letter grade, CGPA and pass/fail status — instantly, and live as you type.</p>
  </div>
</div>

<main>
  <div class="wrap">

    <!-- Input Card -->
    <section class="card" aria-label="Grade input form">
      <h2><i class="fa-solid fa-pen-to-square"></i> Enter Your Details</h2>

      <form id="gradeForm" novalidate>

        <div class="field">
          <label for="studentName">Student Full Name</label>
          <div class="input-wrap">
            <i class="fa-solid fa-user"></i>
            <input type="text" id="studentName" placeholder="e.g. John Doe" required aria-describedby="err-name" autocomplete="name">
          </div>
          <span class="error-msg" id="err-name"></span>
        </div>

        <div class="field">
          <label for="totalQuestions">Total Questions</label>
          <div class="input-wrap">
            <i class="fa-solid fa-list-ol"></i>
            <input type="number" id="totalQuestions" min="1" step="1" inputmode="numeric" placeholder="e.g. 100" required aria-describedby="err-total">
          </div>
          <span class="error-msg" id="err-total"></span>
        </div>

        <div class="field">
          <label for="attemptedQuestions">Attempted Questions</label>
          <div class="input-wrap">
            <i class="fa-solid fa-pen"></i>
            <input type="number" id="attemptedQuestions" min="0" step="1" inputmode="numeric" placeholder="e.g. 90" required aria-describedby="err-attempted">
          </div>
          <span class="error-msg" id="err-attempted"></span>
        </div>

        <div class="field">
          <label for="wrongQuestions">Wrong Questions</label>
          <div class="input-wrap">
            <i class="fa-solid fa-xmark"></i>
            <input type="number" id="wrongQuestions" min="0" step="1" inputmode="numeric" placeholder="e.g. 10" required aria-describedby="err-wrong">
          </div>
          <span class="error-msg" id="err-wrong"></span>
          <div class="live-hint" id="wrongHint" style="display:none;">
            <i class="fa-solid fa-circle-info"></i>
            <span id="wrongHintText"></span>
          </div>
        </div>

        <div class="row-toggle">
          <span><i class="fa-solid fa-bolt"></i> Live calculation as you type</span>
          <label class="switch">
            <input type="checkbox" id="liveToggle">
            <span class="slider"></span>
          </label>
        </div>

        <div class="btn-row">
          <button type="submit" class="btn btn-primary" id="calcBtn">
            <i class="fa-solid fa-calculator"></i> Calculate
          </button>
          <button type="button" class="btn btn-secondary" id="resetBtn">
            <i class="fa-solid fa-rotate-left"></i> Reset
          </button>
        </div>
      </form>
    </section>

    <!-- Result Card -->
    <section class="card" id="resultCard" aria-live="polite">
      <div id="resultCapture">
        <div class="grade-hero">
          <div class="student-name" id="studentNameDisplay"></div>
          <div class="grade-badge" id="gradeBadge"><b id="gradeBadgeText">A+</b></div>
          <div class="cgpa-big" id="cgpaValue">4.0</div>
          <div class="cgpa-label">CGPA</div>
          <div class="status-pill" id="statusPill">PASS</div>
        </div>

        <div class="progress-wrap">
          <div class="progress-label">
            <span>Percentage</span>
            <span id="percentLabel">0.00%</span>
          </div>
          <div class="progress-bar-bg">
            <div class="progress-bar-fill" id="progressFill"></div>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-box">
            <div class="val" id="statTotal">0</div>
            <div class="lbl">Total Questions</div>
          </div>
          <div class="stat-box">
            <div class="val" id="statAttempted">0</div>
            <div class="lbl">Attempted</div>
          </div>
          <div class="stat-box stat-correct">
            <div class="val" id="statCorrect">0</div>
            <div class="lbl">Correct</div>
          </div>
          <div class="stat-box stat-wrong">
            <div class="val" id="statWrong">0</div>
            <div class="lbl">Wrong</div>
          </div>
          <div class="stat-box stat-unattempted" style="grid-column: span 2;">
            <div class="val" id="statUnattempted">0</div>
            <div class="lbl">Unattempted</div>
          </div>
        </div>
      </div>

      <div class="action-row">
        <button id="copyBtn"><i class="fa-solid fa-copy"></i> Copy</button>
        <button id="printBtn"><i class="fa-solid fa-print"></i> Print</button>
        <button id="pdfBtn"><i class="fa-solid fa-file-pdf"></i> PDF</button>
        <button id="pngBtn"><i class="fa-solid fa-image"></i> PNG</button>
        <button id="shareBtn" style="flex:1 1 100%;"><i class="fa-solid fa-share-nodes"></i> Share Results</button>
      </div>
    </section>

  </div>
</main>

<div class="toast" id="toast"></div>
<?php
get_footer();
?>