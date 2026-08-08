<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Grade_Calculator
 */

get_header();
?>
<main id="top">

  <!-- ---------- Hero ---------- -->
  <section class="hero">
    <div class="wrap">
      <div>
        <span class="eyebrow">Three tools, one report card</span>
        <h1>Know your grade before your teacher marks the paper<em> in red.</em></h1>
        <p class="lead">Turn raw scores into a percentage, letter grade and CGPA in seconds — then work out your CGPA across every subject, or the exact score you need on the final to hit your target.</p>
        <div class="hero-ctas">
          <a href="#tools" class="btn btn-primary"><i class="fa-solid fa-calculator"></i> Explore the tools</a>
          <a href="#how" class="btn btn-ghost">See how it works</a>
        </div>
        <div class="trust-row">
          <span><i class="fa-solid fa-circle-check"></i> Free, no sign-up</span>
          <span><i class="fa-solid fa-circle-check"></i> Instant results</span>
          <span><i class="fa-solid fa-circle-check"></i> Nothing leaves your device</span>
        </div>
      </div>

      <div class="mock" aria-hidden="true">
        <div class="mock-head">
          <div>
            <div class="who">Result Sheet</div>
            <div class="name">Aditi Sharma</div>
          </div>
          <div class="mock-stamp"><b>A+</b><span>PASS</span></div>
        </div>
        <div class="mock-rows">
          <div class="mock-row"><span>Total Questions</span><b>100</b></div>
          <div class="mock-row"><span>Correct</span><b>96</b></div>
          <div class="mock-row"><span>Wrong</span><span class="redcircle">4</span></div>
          <div class="mock-row"><span>CGPA</span><b>4.0</b></div>
        </div>
        <div>
          <div class="mock-bar-bg"><div class="mock-bar-fill"></div></div>
        </div>
        <div class="mock-note">"Excellent work — keep this up." ✓</div>
      </div>
    </div>
  </section>

  <!-- ---------- Tools ---------- -->
  <section id="tools">
    <div class="wrap">
      <div class="section-head">
        <span class="eyebrow">The tools</span>
        <h2>Pick the calculation you need</h2>
        <p>Each tool solves a different question — from a single test to a full semester to what's still ahead of you.</p>
      </div>

      <div class="tools-grid">

        <article class="tool-card" data-c="green">
          <span class="tag">Single exam</span>
          <div class="stamp"><i class="fa-solid fa-graduation-cap"></i></div>
          <h3>Grade Calculator</h3>
          <p class="desc">Enter total, attempted and wrong questions to get your percentage, letter grade, CGPA and pass/fail status — instantly, and live as you type.</p>
          <ul class="feats">
            <li><i class="fa-solid fa-circle-check" style="color:var(--green)"></i> Correct / wrong / unattempted breakdown</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--green)"></i> Live calculation toggle</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--green)"></i> Copy, print, PNG or share your result</li>
          </ul>
          <a href="first-tool.html" class="go" target="_blank">Open Grade Calculator <i class="fa-solid fa-arrow-right"></i></a>
        </article>

        <article class="tool-card" data-c="blue">
          <span class="tag">Whole semester</span>
          <div class="stamp"><i class="fa-solid fa-layer-group"></i></div>
          <h3>Multi-Subject CGPA</h3>
          <p class="desc">Add every subject with its credit hours and score, and get one credit-weighted CGPA across your whole course load.</p>
          <ul class="feats">
            <li><i class="fa-solid fa-circle-check" style="color:var(--blue)"></i> Unlimited subjects, add or remove any time</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--blue)"></i> Per-subject grade tag as you type</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--blue)"></i> Credit-weighted overall CGPA</li>
          </ul>
          <a href="second-tool.html" class="go" target="_blank">Open CGPA Calculator <i class="fa-solid fa-arrow-right"></i></a>
        </article>

        <article class="tool-card" data-c="amber">
          <span class="tag">What's ahead</span>
          <div class="stamp-final"><i class="fa-solid fa-bullseye"></i></div>
          <h3>What Do I Need on the Final?</h3>
          <p class="desc">Tell it your current grade and the final's weight, and it works backward to the exact score you need to hit your target overall grade.</p>
          <ul class="feats">
            <li><i class="fa-solid fa-circle-check" style="color:var(--amber)"></i> Works with any exam weighting</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--amber)"></i> Flags targets that are already secured</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--amber)"></i> Flags targets that are out of reach</li>
          </ul>
          <a href="third-tool.html" class="go" target="_blank">Open Target Calculator <i class="fa-solid fa-arrow-right"></i></a>
        </article>

        <article class="tool-card" data-c="teal">
          <span class="tag">GPA to Percentage</span>
          <div class="stamp-gpa"><i class="fa-solid fa-arrows-left-right"></i></div>
          <h3>GPA → Percentage | Percentage → GPA</h3>
          <p class="desc">Tell it your current grade or percentage, and it calculate to convert GPA to Percentage and Percentage to GPA with Grade.</p>
          <ul class="feats">
            <li><i class="fa-solid fa-circle-check" style="color:var(--teal)"></i> GPA to Percentage</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--teal)"></i> Percentage to GPA</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--teal)"></i> Different International Grading Scale</li>
          </ul>
          <a href="gpa-to-percentage.html" class="go" target="_blank">Open GPA to Percentage Converter <i class="fa-solid fa-arrow-right"></i></a>
        </article>

        <article class="tool-card" data-c="violet">
          <span class="tag">Study Hours Calculator</span>
          <div class="stamp-hours"><i class="fa-solid fa-clock"></i></div>
          <h3>Study Hours & Schedule Calculator</h3>
          <p class="desc">Turn your exam date, available study days, and topic list into a day-by-day study plan — with weak topics prioritized, practice and review built in, and a readiness estimate.</p>
          <ul class="feats">
            <li><i class="fa-solid fa-circle-check" style="color:var(--violet)"></i> Set your dates & study days</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--violet)"></i> Add your topics</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--violet)"></i> Generate & follow the plan</li>
          </ul>
          <a href="gpa-to-percentage.html" class="go" target="_blank">Study Hours Calculator <i class="fa-solid fa-arrow-right"></i></a>
        </article>

        <article class="tool-card" data-c="coral">
          <span class="tag attendance">Attendance Calculator</span>
          <div class="stamp-attendance"><i class="fa-solid fa-user-check"></i></div>
          <h3>Attendance Percentage Calculator</h3>
          <p class="desc">Check your current attendance, see how many classes you can miss or need to attend, and run what-if scenarios — against any required percentage your institution sets.</p>
          <ul class="feats">
            <li><i class="fa-solid fa-circle-check" style="color:var(--coral)"></i> Calculate Attendance Percentage</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--coral)"></i> What-IF Calculator</li>
            <li><i class="fa-solid fa-circle-check" style="color:var(--coral)"></i> Different Attendance Percent Target</li>
          </ul>
          <a href="gpa-to-percentage.html" class="go" target="_blank">Attendance <i class="fa-solid fa-arrow-right"></i></a>
        </article>

      </div>
    </div>
  </section>

  <!-- ---------- How it works ---------- -->
  <section class="how" id="how">
    <div class="wrap">
      <div class="section-head">
        <span class="eyebrow">How it works</span>
        <h2>Three steps, no sign-up</h2>
      </div>
      <div class="steps">
        <div class="step">
          <div class="num">1</div>
          <h3>Enter your numbers</h3>
          <p>Questions, credits, or your current grade — whatever the tool asks for, plain and simple.</p>
        </div>
        <div class="step">
          <div class="num">2</div>
          <h3>Get an instant read-out</h3>
          <p>Percentage, letter grade, CGPA or target score — calculated the moment you finish typing.</p>
        </div>
        <div class="step">
          <div class="num">3</div>
          <h3>Save or share it</h3>
          <p>Copy the result, export it as an image, or print it — your data stays on your device.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ---------- CTA band ---------- -->
  <section>
    <div class="cta-band">
      <h2>Ready to see your grade?</h2>
      <p>No account, no email, no waiting — just your numbers and an answer.</p>
      <a href="calculator.html" class="btn btn-primary"><i class="fa-solid fa-calculator"></i> Open the Calculator</a>
    </div>
  </section>

</main>
	

<?php
get_sidebar();
get_footer();
