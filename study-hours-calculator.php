<?php
/**
 * Template Name: Study Hours Calculator
 * Description: Study Hours Calculator. Uses the theme's existing
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
    <span class="eyebrow-violet">From now until exam day</span>
    <div class="stamp-lg violet"><i class="fa-solid fa-clock"></i></div>
    <h1>Study Hours &amp; Schedule Calculator</h1>
    <p>Turn your exam date, available study days, and topic list into a day-by-day study plan — with weak topics prioritized, practice and review built in, and a readiness estimate.</p>
  </div>
</div>

<main>
  <div class="wrap">

    <!-- ---------- Calculator Card ---------- -->
    <section class="card" aria-label="Study hours and schedule calculator">
      <h2><i class="fa-solid fa-calendar-days violet"></i> Build Your Plan</h2>
      <p class="card-sub">Set your dates and study days below — the badges update live. Add topics for a smarter, weighted plan.</p>

      <button type="button" class="example-btn" id="exampleBtn">
        <i class="fa-solid fa-wand-magic-sparkles"></i> Try an example
      </button>

      <div class="badge-row">
        <div class="badge"><div class="badge-val" id="badgeDays">--</div><div class="badge-lbl">Days Left</div></div>
        <div class="badge"><div class="badge-val" id="badgeSessions">--</div><div class="badge-lbl">Sessions / Week</div></div>
        <div class="badge"><div class="badge-val" id="badgeHours">--</div><div class="badge-lbl">Hours / Week</div></div>
        <div class="badge"><div class="badge-val" id="badgeTotal">--</div><div class="badge-lbl">Total Hours</div></div>
      </div>

      <form id="planForm" novalidate>

        <div class="field-row">
          <div class="field">
            <label for="startDate">Start Date</label>
            <div class="input-wrap">
              <i class="fa-solid fa-play"></i>
              <input type="date" id="startDate" required>
            </div>
          </div>
          <div class="field">
            <label for="examDate">Exam / Deadline Date</label>
            <div class="input-wrap">
              <i class="fa-solid fa-flag-checkered"></i>
              <input type="date" id="examDate" required>
            </div>
            <span class="error-msg" id="err-examDate"></span>
          </div>
        </div>

        <div class="field">
          <label>Study Days</label>
          <div class="day-chips" id="dayChips">
            <button type="button" class="day-chip" data-day="1">Mon</button>
            <button type="button" class="day-chip" data-day="2">Tue</button>
            <button type="button" class="day-chip" data-day="3">Wed</button>
            <button type="button" class="day-chip" data-day="4">Thu</button>
            <button type="button" class="day-chip" data-day="5">Fri</button>
            <button type="button" class="day-chip" data-day="6">Sat</button>
            <button type="button" class="day-chip" data-day="0">Sun</button>
          </div>
          <span class="error-msg" id="err-days"></span>
        </div>

        <div class="field-row">
          <div class="field">
            <label for="sessionLength">Minutes per Session</label>
            <div class="input-wrap">
              <i class="fa-solid fa-hourglass-half"></i>
              <select id="sessionLength">
                <option value="25">25 minutes</option>
                <option value="30">30 minutes</option>
                <option value="45" selected>45 minutes</option>
                <option value="60">60 minutes</option>
                <option value="90">90 minutes</option>
              </select>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
          </div>
          <div class="field">
            <label for="difficultySelect">Overall Difficulty</label>
            <div class="input-wrap">
              <i class="fa-solid fa-gauge-high"></i>
              <select id="difficultySelect">
                <option value="0.8">Easy</option>
                <option value="1.0" selected>Moderate</option>
                <option value="1.3">Hard</option>
              </select>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
          </div>
        </div>

        <div class="field">
          <label for="confidenceSelect">Current Confidence</label>
          <div class="input-wrap">
            <i class="fa-solid fa-face-smile"></i>
            <select id="confidenceSelect">
              <option value="weak">Low — I need the basics</option>
              <option value="medium" selected>Medium — I know some of it</option>
              <option value="strong">High — mostly review</option>
            </select>
            <i class="fa-solid fa-chevron-down"></i>
          </div>
          <p class="topic-hint" style="margin-top:8px;">Used as the default for every topic when you're not using Advanced mode below — and it shifts your readiness baseline either way.</p>
        </div>
        
        <div class="field">
          <label for="topicCount">Number of Topics</label>
          <div class="input-wrap">
            <i class="fa-solid fa-list-ol"></i>
            <input type="number" id="topicCount" min="1" max="30" step="1" value="5">
          </div>
          <p class="topic-hint" style="margin-top:8px;">Change this number and a name field appears for each topic below — add or remove one any time.</p>
        </div>

        <div class="field" id="topicNameField">
          <label>Name Your Topics</label>
          <div id="topicNameRows"></div>
        </div>

        <div class="row-toggle">
          <span><i class="fa-solid fa-sliders"></i> Paste a list instead (Topic | confidence | priority)</span>
          <label class="switch">
            <input type="checkbox" id="advancedToggle">
            <span class="slider-toggle"></span>
          </label>
        </div>

        <div class="field" id="topicsAdvanced">
          <label for="topicList">Topic List — one per line</label>
          <textarea id="topicList" placeholder="Stoichiometry | weak | high
Gases | medium | medium
Thermochemistry | strong | low"></textarea>
          <p class="topic-hint">Format: <code>Topic | confidence | priority</code> — confidence: weak / medium / strong, priority: low / medium / high. Leave a field out and it defaults to medium.</p>
        </div>

        <!--div class="row-toggle">
          <span><i class="fa-solid fa-sliders"></i> Advanced: name topics, set confidence &amp; priority</span>
          <label class="switch">
            <input type="checkbox" id="advancedToggle">
            <span class="slider-toggle"></span>
          </label>
        </div-->

        <div class="field" id="topicsAdvanced">
          <label for="topicList">Topic List — one per line</label>
          <textarea id="topicList" placeholder="Stoichiometry | weak | high
Gases | medium | medium
Thermochemistry | strong | low"></textarea>
          <p class="topic-hint">Format: <code>Topic | confidence | priority</code> — confidence: weak / medium / strong, priority: low / medium / high. Leave a field out and it defaults to medium. Blank lines are ignored; if this box is empty, the "Number of Topics" field above is used instead.</p>
        </div>

        <div class="style-grid">
          <div class="style-toggle">
            <span><i class="fa-solid fa-pen" style="color:var(--teal); margin-right:5px;"></i>Practice sessions</span>
            <label class="switch"><input type="checkbox" id="includePractice" checked><span class="slider-toggle"></span></label>
          </div>
          <div class="style-toggle">
            <span><i class="fa-solid fa-rotate" style="color:var(--amber); margin-right:5px;"></i>Review sessions</span>
            <label class="switch"><input type="checkbox" id="includeReview" checked><span class="slider-toggle"></span></label>
          </div>
          <div class="style-toggle">
            <span><i class="fa-solid fa-triangle-exclamation" style="color:var(--red); margin-right:5px;"></i>Weak-spot repair</span>
            <label class="switch"><input type="checkbox" id="includeWeak" checked><span class="slider-toggle"></span></label>
          </div>
          <div class="style-toggle">
            <span><i class="fa-solid fa-clipboard-check" style="color:var(--green); margin-right:5px;"></i>Mock test day</span>
            <label class="switch"><input type="checkbox" id="includeMock" checked><span class="slider-toggle"></span></label>
          </div>
        </div>

        <button type="submit" class="btn btn-primary" id="generateBtn">
          <i class="fa-solid fa-wand-magic-sparkles"></i> Generate Study Plan
        </button>
      </form>

      <div class="formula-box" id="formulaBox">
        <span>How this plan is built</span>
        Sessions/week = number of study days selected
        Hours/week = sessions/week × session length
        Total sessions = sessions/week × weeks until exam
        Current Confidence sets each topic's default weak/medium/strong rating (overridden per-topic in Advanced mode)
        Topic weight = confidence score + priority score (weaker/higher-priority topics score more)
        Topic time = learning-phase hours × (topic weight ÷ total weight)
      </div>
    </section>

    <!-- ---------- Result Card ---------- -->
    <section class="card" id="resultCard" aria-live="polite">
      <div class="result-hero">
        <div class="result-stamp"><b id="resultDays">--</b><span>DAYS TO GO</span></div>
        <p style="color:var(--ink-soft); font-size:.9rem;" id="resultRecap"></p>
        <span class="readiness-pill" id="readinessPill">-- READY</span>
      </div>

      <div class="stats-grid">
        <div class="stat-box stat-learn"><div class="val" id="statLearn">0</div><div class="lbl">Learn</div></div>
        <div class="stat-box stat-practice"><div class="val" id="statPractice">0</div><div class="lbl">Practice</div></div>
        <div class="stat-box stat-weak"><div class="val" id="statWeak">0</div><div class="lbl">Weak-Spot</div></div>
        <div class="stat-box stat-review"><div class="val" id="statReview">0</div><div class="lbl">Review</div></div>
      </div>

      <h3 style="font-size:.95rem; margin-bottom:14px;"><i class="fa-solid fa-chart-simple" style="color:var(--violet); margin-right:6px;"></i>Time per Topic</h3>
      <div id="topicBars"></div>

      <h3 style="font-size:.95rem; margin:20px 0 12px;"><i class="fa-solid fa-list-check" style="color:var(--violet); margin-right:6px;"></i>Your Sessions</h3>
      <div class="session-list" id="sessionList"></div>
      <div class="session-more" id="sessionMore"></div>

      <div class="action-row">
        <button id="copyBtn"><i class="fa-solid fa-copy"></i> Copy Plan</button>
        <button id="printBtn"><i class="fa-solid fa-print"></i> Print</button>
        <button id="shareBtn" style="flex:1 1 100%;"><i class="fa-solid fa-share-nodes"></i> Share Plan</button>
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

    <section class="card" id="about-study-hours">
      <span class="eyebrow-violet" style="margin-bottom:14px;">Guide</span>
      <h2 style="font-size:1.4rem; margin-bottom:14px;"><i class="fa-solid fa-book-open" style="color:var(--violet); margin-right:8px;"></i>What Is the Study Hours Calculator?</h2>
      <p style="color:var(--ink-soft); font-size:.95rem; margin-bottom:16px; line-height:1.7;">
        The <strong>Study Hours Calculator</strong> is a free <strong>study schedule generator</strong> that turns your exam date, available study days, and topic list into a realistic, day-by-day <strong>study plan</strong>. Instead of guessing how many hours to study or splitting time equally across every subject, it builds a <strong>weighted study schedule</strong> that gives more time to the topics you're weakest in and the ones you've marked as high priority — then layers in practice sessions, review days, weak-spot repair, and a mock test before your exam.
      </p>
      <p style="color:var(--ink-soft); font-size:.95rem; margin-bottom:0; line-height:1.7;">
        It works for exam countdowns, weekly study planning, finals week, midterms, standardized test prep, or any deadline where you need to know exactly what to study and when — not just how many hours in total.
      </p>
    </section>

    <section class="card">
      <h2 style="font-size:1.2rem; margin-bottom:16px;"><i class="fa-solid fa-list-check" style="color:var(--violet); margin-right:8px;"></i>How to Use This Study Planner</h2>
      <div class="steps">
        <div class="step">
          <div class="num">1</div>
          <h3>Set your dates &amp; study days</h3>
          <p>Pick a start date, your exam date, and the days of the week you can realistically study — sessions per week and total hours update live as you go.</p>
        </div>
        <div class="step">
          <div class="num">2</div>
          <h3>Add your topics</h3>
          <p>Enter a topic count for a quick plan, or switch on Advanced to name each topic and tag its confidence and priority for a weighted plan.</p>
        </div>
        <div class="step">
          <div class="num">3</div>
          <h3>Generate &amp; follow the plan</h3>
          <p>Get a session-by-session schedule with learning, practice, weak-spot repair, review, and a mock test day built in — copy, print, or share it.</p>
        </div>
      </div>
    </section>

    <section class="card">
      <h2 style="font-size:1.2rem; margin-bottom:12px;"><i class="fa-solid fa-square-root-variable" style="color:var(--violet); margin-right:8px;"></i>How the Plan Is Calculated</h2>
      <p style="color:var(--ink-soft); font-size:.9rem; line-height:1.7; margin-bottom:14px;">
        Every session in your plan comes from the same transparent formula — nothing here is a black box:
      </p>
      <div class="formula-box" style="margin-top:0;">
        <span>Session &amp; time formulas</span>
        Sessions/week = number of study days selected
        Hours/week = sessions/week × session length
        Total sessions until exam = sessions/week × weeks remaining
      </div>
      <div class="formula-box">
        <span>Topic weighting formula</span>
        Confidence score → weak = 3, medium = 2, strong = 1
        Priority score → high = 3, medium = 2, low = 1
        Topic weight = confidence score + priority score
        Topic time share = topic weight ÷ sum of all topic weights
      </div>
      <div class="formula-box">
        <span>Readiness estimate</span>
        Recommended hours = Σ (topic baseline hours by confidence)
        Readiness % = min(100, planned learning hours ÷ recommended hours × 100)
      </div>
      <p style="color:var(--ink-faint); font-size:.78rem; margin-top:6px;">Readiness is a planning estimate based on time allocated, not a measurement of what you've actually learned.</p>
    </section>

    <!-- ---------- FAQ ---------- -->
    <section class="card" id="faq">
      <h2 style="font-size:1.3rem; margin-bottom:6px; display:flex; align-items:center; gap:9px;">
        <i class="fa-solid fa-circle-question" style="color:var(--violet);"></i> Frequently Asked Questions
      </h2>
      <p class="card-sub">Common questions about building a study schedule with this tool.</p>

      <details>
        <summary>How many hours should I study per week?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">It depends on how many days you can realistically study and how long each session lasts. This calculator computes it for you — pick your study days and session length, and the weekly hours are shown automatically rather than something you need to guess.</p>
      </details>

      <details>
        <summary>What does "confidence" and "priority" mean for a topic?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">Confidence is how well you already know a topic (weak, medium, strong) — weaker topics get more study time. Priority is how important that topic is to your grade or exam (low, medium, high) — higher-priority topics also get more time. Together they decide how your total study hours are split across topics.</p>
      </details>

      <details>
        <summary>Do I need to name every topic, or can I just enter a number?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">Either works. Enter a number of topics for a quick, evenly-weighted plan, or switch on Advanced mode to name each topic and tag its confidence and priority for a plan that gives more time to your weaker or higher-priority subjects.</p>
      </details>

      <details>
        <summary>What's included in the generated schedule besides "studying"?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">Beyond core learning sessions, the plan can include practice sessions, dedicated weak-spot repair sessions for your lowest-confidence topics, spaced review sessions, and a mock test day near your exam date — each can be turned on or off.</p>
      </details>

      <details>
        <summary>What is the readiness score based on?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">It compares the learning and practice hours your plan allocates against a recommended baseline built from each topic's confidence level. It's a planning signal — how much time you've scheduled relative to what's typically needed — not a measure of actual mastery.</p>
      </details>

      <details>
        <summary>Is this study schedule generator free, and is my data stored?<i class="fa-solid fa-chevron-down"></i></summary>
        <p class="a">Yes, it's completely free with no sign-up. The entire plan is generated in your browser — no dates, topics, or schedule details are sent to or stored on a server.</p>
      </details>
    </section>

  </div>
</main>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How many hours should I study per week?",
      "acceptedAnswer": { "@type": "Answer", "text": "It depends on how many days you can study and how long each session lasts. The calculator computes weekly hours automatically from your selected study days and session length." }
    },
    {
      "@type": "Question",
      "name": "What does confidence and priority mean for a topic?",
      "acceptedAnswer": { "@type": "Answer", "text": "Confidence is how well a topic is already known (weak, medium, strong); priority is how important it is to the exam or grade (low, medium, high). Both determine how study time is split across topics." }
    },
    {
      "@type": "Question",
      "name": "Do I need to name every topic, or can I just enter a number?",
      "acceptedAnswer": { "@type": "Answer", "text": "Either works. A topic count gives a quick evenly-weighted plan, while naming topics with confidence and priority in Advanced mode gives a weighted plan favoring weaker or higher-priority subjects." }
    },
    {
      "@type": "Question",
      "name": "What is included in the generated study schedule?",
      "acceptedAnswer": { "@type": "Answer", "text": "The plan can include core learning sessions, practice sessions, weak-spot repair sessions, spaced review sessions, and a mock test day, each of which can be toggled on or off." }
    },
    {
      "@type": "Question",
      "name": "What is the readiness score based on?",
      "acceptedAnswer": { "@type": "Answer", "text": "It compares planned learning and practice hours against a recommended baseline derived from each topic's confidence level, serving as a planning signal rather than a measurement of actual mastery." }
    },
    {
      "@type": "Question",
      "name": "Is the study schedule generator free and is data stored?",
      "acceptedAnswer": { "@type": "Answer", "text": "It is free with no sign-up required, and the schedule is generated entirely in the browser with no data sent to or stored on a server." }
    }
  ]
}
</script>
<?php
get_footer();
?>