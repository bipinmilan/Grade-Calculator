<?php
/**
 * Template Name: Multi-Subject CGPA
 * Description: Multi-Subject CGPA. Uses the theme's existing
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
<div class="page-head2">
  <div class="wrap">
    <span class="eyebrow">Whole semester</span>
    <div class="stamp-lg"><i class="fa-solid fa-layer-group"></i></div>
    <h1>Multi-Subject CGPA Calculator</h1>
    <p>Enter how many subjects you have, pick a letter grade for each, and get one credit-weighted CGPA across your whole course load.</p>
  </div>
</div>

<main>
  <div class="wrap">

    <section class="card" aria-label="Multi-subject CGPA calculator">
      <h2><i class="fa-solid fa-layer-group"></i> Your Subjects</h2>
      <p class="card-sub">Set the number of subjects to build the list automatically — then add credits and a grade for each.</p>

      <div class="count-field">
        <div class="field">
          <label for="subjectCount">Number of Subjects</label>
          <input type="number" id="subjectCount" min="1" max="30" step="1" value="2">
        </div>
        <span class="hint"><i class="fa-solid fa-wand-magic-sparkles"></i>Rows update automatically as you change this.</span>
      </div>

      <div id="subjectsList"></div>
      <p class="subject-count-note"><i class="fa-solid fa-circle-info"></i> Use the trash icon to remove a single subject — the count above updates itself.</p>

      <button type="button" class="btn btn-add" id="addSubjectBtn">
        <i class="fa-solid fa-plus"></i> Add One More Subject
      </button>

      <div class="btn-row">
        <button type="button" class="btn btn-primary" id="calcCgpaBtn">
          <i class="fa-solid fa-calculator"></i> Calculate CGPA
        </button>
        <button type="button" class="btn btn-secondary" id="resetSubjectsBtn">
          <i class="fa-solid fa-rotate-left"></i> Reset
        </button>
      </div>

      <div id="cgpaSummary">
        <div class="summary-head">
          <div class="summary-stamp"><b id="overallGradeTag">A+</b><span>OVERALL</span></div>
        </div>
        <div class="stats-grid">
          <div class="stat-box">
            <div class="val" id="totalCredits">0</div>
            <div class="lbl">Total Credits</div>
          </div>
          <div class="stat-box">
            <div class="val" id="overallCgpaVal">0.00</div>
            <div class="lbl">Overall CGPA</div>
          </div>
        </div>
      </div>
    </section>
    <!-- ============================================================
     SEO / EDUCATIONAL CONTENT SECTION — Multi-Subject CGPA Tool
     Drop this <section> into cgpa.html, right after the closing
     </section> of the calculator card and before </div> (.wrap ends)
     or before the toast/footer — wherever you want the article to sit.
     Uses the same design tokens (--blue, --paper, --card, etc.) already
     defined in cgpa.html, so no extra CSS variables are needed.
     ============================================================ -->

<section class="card" aria-label="About the Multi-Subject CGPA Calculator" id="about-cgpa">
  <span class="eyebrow" style="margin-bottom:14px;">Guide</span>
  <h2 style="font-size:1.4rem; margin-bottom:14px; display:block;"><i class="fa-solid fa-book-open" style="color:var(--blue); margin-right:8px;"></i>What Is the Multi-Subject CGPA Calculator?</h2>

  <p style="color:var(--ink-soft); font-size:.95rem; margin-bottom:16px; line-height:1.7;">
    The <strong>Multi-Subject CGPA Calculator</strong> is a free online tool that works out your overall
    <strong>Cumulative Grade Point Average (CGPA)</strong> across every subject in a semester or academic year.
    Instead of averaging your grades equally, it applies a <strong>credit-weighted CGPA formula</strong> — so a
    4-credit core subject counts for more than a 1-credit elective, exactly the way most colleges, universities
    and grading boards calculate it. Just tell it how many subjects you're taking, assign a letter grade
    (A+ through NG) and a credit value to each one, and it returns your combined CGPA instantly, without
    spreadsheets or manual grade-point math.
  </p>

  <p style="color:var(--ink-soft); font-size:.95rem; margin-bottom:28px; line-height:1.7;">
    It's built for students who want to <strong>calculate CGPA online</strong> before results are officially
    published, plan how upcoming exams will affect their <strong>semester CGPA</strong>, or simply convert a
    mixed set of subject grades into one final number for a resume, scholarship application, or transcript check.
  </p>

  <h3 style="font-size:1.1rem; margin-bottom:14px;"><i class="fa-solid fa-list-check" style="color:var(--blue); margin-right:8px;"></i>How to Use the CGPA Calculator</h3>
  <div style="display:flex; flex-direction:column; gap:14px; margin-bottom:28px;">
    <div style="display:flex; gap:14px;">
      <div style="flex:0 0 30px; height:30px; border:1.5px solid var(--blue); border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:var(--mono); font-size:.8rem; font-weight:700; color:var(--blue);">1</div>
      <div>
        <b style="font-size:.92rem;">Enter your number of subjects</b>
        <p style="color:var(--ink-soft); font-size:.86rem; margin-top:3px;">Type the total subjects for the semester into the <em>Number of Subjects</em> field — the subject rows appear automatically, no page reload needed.</p>
      </div>
    </div>
    <div style="display:flex; gap:14px;">
      <div style="flex:0 0 30px; height:30px; border:1.5px solid var(--blue); border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:var(--mono); font-size:.8rem; font-weight:700; color:var(--blue);">2</div>
      <div>
        <b style="font-size:.92rem;">Name each subject and add its credit hours</b>
        <p style="color:var(--ink-soft); font-size:.86rem; margin-top:3px;">Credit hours reflect how much weight a subject carries — check your course handbook or mark sheet if you're unsure of a subject's credit value.</p>
      </div>
    </div>
    <div style="display:flex; gap:14px;">
      <div style="flex:0 0 30px; height:30px; border:1.5px solid var(--blue); border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:var(--mono); font-size:.8rem; font-weight:700; color:var(--blue);">3</div>
      <div>
        <b style="font-size:.92rem;">Pick a letter grade for each subject</b>
        <p style="color:var(--ink-soft); font-size:.86rem; margin-top:3px;">Choose from A+, A, B+, B, C+, C, D, or NG (No Grade / Fail) — each grade maps to a fixed grade point, shown right next to the dropdown.</p>
      </div>
    </div>
    <div style="display:flex; gap:14px;">
      <div style="flex:0 0 30px; height:30px; border:1.5px solid var(--blue); border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:var(--mono); font-size:.8rem; font-weight:700; color:var(--blue);">4</div>
      <div>
        <b style="font-size:.92rem;">Tap "Calculate CGPA"</b>
        <p style="color:var(--ink-soft); font-size:.86rem; margin-top:3px;">Your total credits and final credit-weighted CGPA appear instantly below the form.</p>
      </div>
    </div>
  </div>

  <h3 style="font-size:1.1rem; margin-bottom:12px;"><i class="fa-solid fa-square-root-variable" style="color:var(--blue); margin-right:8px;"></i>The CGPA Formula It Uses</h3>
  <p style="color:var(--ink-soft); font-size:.9rem; margin-bottom:10px; line-height:1.7;">
    Every subject's grade is converted to a grade point, multiplied by its credit hours, and the results are summed and divided by total credits:
  </p>
  <div style="background:var(--paper); border:1px dashed var(--border); border-radius:12px; padding:14px 16px; font-family:var(--mono); font-size:.85rem; color:var(--ink); margin-bottom:20px; overflow-x:auto;">
    CGPA = Σ (Credit Hours × Grade Point) ÷ Σ Credit Hours
  </div>

  <div style="overflow-x:auto; margin-bottom:8px;">
    <table style="width:100%; border-collapse:collapse; font-size:.85rem;">
      <thead>
        <tr style="background:var(--paper);">
          <th style="text-align:left; padding:10px 12px; font-family:var(--mono); font-size:.72rem; text-transform:uppercase; letter-spacing:.06em; color:var(--ink-faint);">Grade</th>
          <th style="text-align:left; padding:10px 12px; font-family:var(--mono); font-size:.72rem; text-transform:uppercase; letter-spacing:.06em; color:var(--ink-faint);">Grade Point</th>
        </tr>
      </thead>
      <tbody>
        <tr style="border-bottom:1px solid var(--border);"><td style="padding:9px 12px; font-weight:600;">A+</td><td style="padding:9px 12px; font-family:var(--mono); color:var(--green);">4.0</td></tr>
        <tr style="border-bottom:1px solid var(--border);"><td style="padding:9px 12px; font-weight:600;">A</td><td style="padding:9px 12px; font-family:var(--mono); color:var(--green);">3.6</td></tr>
        <tr style="border-bottom:1px solid var(--border);"><td style="padding:9px 12px; font-weight:600;">B+</td><td style="padding:9px 12px; font-family:var(--mono); color:var(--blue);">3.2</td></tr>
        <tr style="border-bottom:1px solid var(--border);"><td style="padding:9px 12px; font-weight:600;">B</td><td style="padding:9px 12px; font-family:var(--mono); color:var(--blue);">2.8</td></tr>
        <tr style="border-bottom:1px solid var(--border);"><td style="padding:9px 12px; font-weight:600;">C+</td><td style="padding:9px 12px; font-family:var(--mono); color:var(--amber);">2.4</td></tr>
        <tr style="border-bottom:1px solid var(--border);"><td style="padding:9px 12px; font-weight:600;">C</td><td style="padding:9px 12px; font-family:var(--mono); color:var(--amber);">2.0</td></tr>
        <tr style="border-bottom:1px solid var(--border);"><td style="padding:9px 12px; font-weight:600;">D</td><td style="padding:9px 12px; font-family:var(--mono); color:var(--amber);">1.6</td></tr>
        <tr><td style="padding:9px 12px; font-weight:600;">NG</td><td style="padding:9px 12px; font-family:var(--mono); color:var(--red);">0.0</td></tr>
      </tbody>
    </table>
  </div>
  <p style="color:var(--ink-faint); font-size:.78rem; margin-top:10px;">Grading scales vary by institution — check your college's official scale if it differs from the one above.</p>
</section>

<!-- ============================================================
     FAQ SECTION — with visible accordion + FAQPage schema for
     Google's rich-result eligibility
     ============================================================ -->
<section class="card" aria-label="Frequently asked questions about CGPA calculation" id="cgpa-faq">
  <h2 style="font-size:1.3rem; margin-bottom:6px; display:flex; align-items:center; gap:9px;">
    <i class="fa-solid fa-circle-question" style="color:var(--blue);"></i> Frequently Asked Questions
  </h2>
  <p class="card-sub">Common questions students ask about CGPA, credit weighting, and this calculator.</p>

  <div style="display:flex; flex-direction:column; gap:10px;">

    <details style="background:var(--paper); border:1px solid var(--border); border-radius:12px; padding:14px 16px;">
      <summary style="cursor:pointer; font-weight:600; font-size:.92rem; list-style:none; display:flex; justify-content:space-between; align-items:center;">
        What is CGPA and how is it different from GPA?
        <i class="fa-solid fa-chevron-down" style="font-size:.75rem; color:var(--ink-faint);"></i>
      </summary>
      <p style="color:var(--ink-soft); font-size:.86rem; margin-top:10px; line-height:1.6;">
        GPA (Grade Point Average) usually refers to your grade average for a single semester or term. CGPA
        (Cumulative Grade Point Average) is the combined, credit-weighted average across multiple subjects — or
        multiple semesters — giving you one overall score for your entire course load.
      </p>
    </details>

    <details style="background:var(--paper); border:1px solid var(--border); border-radius:12px; padding:14px 16px;">
      <summary style="cursor:pointer; font-weight:600; font-size:.92rem; list-style:none; display:flex; justify-content:space-between; align-items:center;">
        Why does this CGPA calculator ask for credit hours?
        <i class="fa-solid fa-chevron-down" style="font-size:.75rem; color:var(--ink-faint);"></i>
      </summary>
      <p style="color:var(--ink-soft); font-size:.86rem; margin-top:10px; line-height:1.6;">
        Not every subject carries equal weight. A 4-credit core course affects your CGPA more than a 1-credit
        elective. Credit-weighted CGPA reflects that — a high grade in a heavy-credit subject moves your overall
        CGPA more than the same grade in a light-credit one.
      </p>
    </details>

    <details style="background:var(--paper); border:1px solid var(--border); border-radius:12px; padding:14px 16px;">
      <summary style="cursor:pointer; font-weight:600; font-size:.92rem; list-style:none; display:flex; justify-content:space-between; align-items:center;">
        How many subjects can I add to the calculator?
        <i class="fa-solid fa-chevron-down" style="font-size:.75rem; color:var(--ink-faint);"></i>
      </summary>
      <p style="color:var(--ink-soft); font-size:.86rem; margin-top:10px; line-height:1.6;">
        You can calculate CGPA for up to 30 subjects in one go — enough for a full semester or an entire academic
        year. Enter the number of subjects at the top of the tool and the rows are generated automatically.
      </p>
    </details>

    <details style="background:var(--paper); border:1px solid var(--border); border-radius:12px; padding:14px 16px;">
      <summary style="cursor:pointer; font-weight:600; font-size:.92rem; list-style:none; display:flex; justify-content:space-between; align-items:center;">
        What does the "NG" grade option mean?
        <i class="fa-solid fa-chevron-down" style="font-size:.75rem; color:var(--ink-faint);"></i>
      </summary>
      <p style="color:var(--ink-soft); font-size:.86rem; margin-top:10px; line-height:1.6;">
        NG stands for "No Grade" — used for a subject that wasn't passed or wasn't graded. It carries a grade
        point of 0.0, so including it will lower your overall CGPA, the same way it would on an official transcript.
      </p>
    </details>

    <details style="background:var(--paper); border:1px solid var(--border); border-radius:12px; padding:14px 16px;">
      <summary style="cursor:pointer; font-weight:600; font-size:.92rem; list-style:none; display:flex; justify-content:space-between; align-items:center;">
        Does my grading scale match this calculator's?
        <i class="fa-solid fa-chevron-down" style="font-size:.75rem; color:var(--ink-faint);"></i>
      </summary>
      <p style="color:var(--ink-soft); font-size:.86rem; margin-top:10px; line-height:1.6;">
        This tool uses a common 4.0-point scale (A+ = 4.0 down to NG = 0.0). Some institutions use a 5.0 or 10.0
        scale, or slightly different grade-point values — check your college's grading policy and treat the
        result here as a close estimate rather than an official transcript figure.
      </p>
    </details>

    <details style="background:var(--paper); border:1px solid var(--border); border-radius:12px; padding:14px 16px;">
      <summary style="cursor:pointer; font-weight:600; font-size:.92rem; list-style:none; display:flex; justify-content:space-between; align-items:center;">
        Is this CGPA calculator free, and is my data stored anywhere?
        <i class="fa-solid fa-chevron-down" style="font-size:.75rem; color:var(--ink-faint);"></i>
      </summary>
      <p style="color:var(--ink-soft); font-size:.86rem; margin-top:10px; line-height:1.6;">
        Yes — it's completely free, with no sign-up. All calculations happen directly in your browser, and no
        subject names, grades, or credits are sent to or stored on any server.
      </p>
    </details>

  </div>
</section>

<!-- Optional: hide the default disclosure triangle browsers add to <summary> -->
<style>
  #cgpa-faq details summary::-webkit-details-marker{ display:none; }
  #cgpa-faq details[open] summary i{ transform:rotate(180deg); }
  #cgpa-faq details summary i{ transition:transform .2s ease; }
</style>

<!-- ============================================================
     FAQPage structured data (JSON-LD) — helps Google show this
     page as an FAQ rich result in search. Place anywhere in <head>
     or before </body>. Keep the questions/answers in sync with the
     visible FAQ above if you edit either one.
     ============================================================ -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is CGPA and how is it different from GPA?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "GPA usually refers to your grade average for a single semester or term. CGPA is the combined, credit-weighted average across multiple subjects or semesters, giving one overall score for your entire course load."
      }
    },
    {
      "@type": "Question",
      "name": "Why does this CGPA calculator ask for credit hours?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Subjects carry different weights. A 4-credit core course affects overall CGPA more than a 1-credit elective, so credit-weighted CGPA reflects that difference accurately."
      }
    },
    {
      "@type": "Question",
      "name": "How many subjects can I add to the calculator?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Up to 30 subjects can be added in one calculation, enough for a full semester or academic year. Rows are generated automatically based on the number entered."
      }
    },
    {
      "@type": "Question",
      "name": "What does the NG grade option mean?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "NG stands for No Grade, used for a subject that was not passed or graded. It carries a grade point of 0.0 and will lower the overall CGPA if included."
      }
    },
    {
      "@type": "Question",
      "name": "Does my grading scale match this calculator's?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The tool uses a common 4.0-point scale from A+ to NG. Some institutions use a 5.0 or 10.0 scale or different grade-point values, so results here should be treated as a close estimate."
      }
    },
    {
      "@type": "Question",
      "name": "Is this CGPA calculator free, and is data stored anywhere?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The tool is free with no sign-up required. All calculations run in the browser and no subject data is sent to or stored on a server."
      }
    }
  ]
}
</script>

  </div>
</main>

<div class="toast" id="toast"></div>

<?php
get_footer();
?>