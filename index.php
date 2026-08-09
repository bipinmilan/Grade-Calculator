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
        <span class="eyebrow">Free calculators for grades, GPA &amp; attendance</span>
        <h1>Know where you stand before your teacher marks the paper<em> in red.</em></h1>
        <p class="lead">Calculate your grade, CGPA, and the exact score you need on your final. Convert GPA to percentage on any scale, check how many classes you can miss to stay above your required attendance, and plan your study hours before exam day. Six free calculators, instant results, no sign-up.</p>
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
        <h2>Pick the Calculator you need</h2>
        <p>Grade, CGPA, final exam score, GPA to percentage, study hours, and attendance — six free calculators, each built to answer one specific question.</p>
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
  <!--section class="how" id="how">
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
  </section-->
  <!-- ============================================================
     "HOW IT WORKS" SECTION — detailed, tabbed, interactive
     Paste into front-page.php / home.php, replacing (or above)
     your existing #how section. No header/footer included —
     matches your existing .wrap / card / stamp / eyebrow tokens.
     ============================================================ -->

<?php
// Edit URLs/labels here — everything below reads from this array,
// so this is the only place you need to touch to add/reorder tools.
$scorebook_tools = array(
  array(
    'id'          => 'grade',
    'accent'      => 'green',
    'icon'        => 'fa-graduation-cap',
    'tag'         => 'Single exam',
    'name'        => 'Grade Calculator',
    'blurb'       => 'Turn raw exam numbers into a percentage, letter grade, CGPA, and pass/fail status — instantly, and live as you type.',
    'steps'       => array(
      array( 'Enter your numbers', 'Total questions, attempted, and wrong — the live toggle updates your result as you go.' ),
      array( 'Get your breakdown', 'Correct, wrong, and unattempted are split out automatically, alongside your percentage and grade.' ),
      array( 'Save or share it', 'Copy, print, export as PNG, or share your result sheet directly.' ),
    ),
    'url'         => 'http://localhost/wordpress/grade-calculator/',
  ),
  array(
    'id'          => 'cgpa',
    'accent'      => 'blue',
    'icon'        => 'fa-layer-group',
    'tag'         => 'Whole semester',
    'name'        => 'Multi-Subject CGPA Calculator',
    'blurb'       => 'Add every subject with its credit hours and grade to get one credit-weighted CGPA across your whole course load.',
    'steps'       => array(
      array( 'Set your subject count', 'Rows for each subject appear automatically — no reload, no separate "add" clicks needed.' ),
      array( 'Assign credits &amp; grades', 'Pick a letter grade (A+ to NG) and credit hours per subject — points update live.' ),
      array( 'Calculate CGPA', 'Get one credit-weighted CGPA across everything you entered.' ),
    ),
    'url'         => 'http://localhost/wordpress/multi-subject-cgpa-calculator/',
  ),
  array(
    'id'          => 'target',
    'accent'      => 'amber',
    'icon'        => 'fa-bullseye',
    'tag'         => "What's ahead",
    'name'        => 'Final Grade Calculator',
    'blurb'       => "Tell it your current grade and the final's weight, and it works backward to the score you need to hit your target.",
    'steps'       => array(
      array( 'Enter your current grade', 'Your grade so far, before the final exam is factored in.' ),
      array( 'Add the final\'s weight', 'How much the final is worth toward your overall grade.' ),
      array( 'See what you need', 'Get the exact score required — flagged as reachable, already secured, or out of reach.' ),
    ),
    'url'         => 'http://localhost/wordpress/final-grade-calculator/',
  ),
  array(
    'id'          => 'gpa',
    'accent'      => 'teal',
    'icon'        => 'fa-arrows-left-right',
    'tag'         => 'Any grading scale',
    'name'        => 'GPA to Percentage',
    'blurb'       => 'Convert GPA to percentage and back, across 10 grading scales — with a live letter grade and cross-scale comparison.',
    'steps'       => array(
      array( 'Pick a direction', 'Toggle between GPA→Percentage or Percentage→GPA on the same form.' ),
      array( 'Choose your scale', 'From 4.0 up to 20.0 — ten scales supported, all from one formula.' ),
      array( 'Compare instantly', 'See your result mirrored across every other scale side by side.' ),
    ),
    'url'         => 'http://localhost/wordpress/gpa-to-percentage/',
  ),
  array(
    'id'          => 'study',
    'accent'      => 'violet',
    'icon'        => 'fa-clock',
    'tag'         => 'From now until exam day',
    'name'        => 'Study Hours Calculator',
    'blurb'       => 'Turn your exam date, study days, and topic list into a day-by-day plan — weak topics prioritized, practice and review built in.',
    'steps'       => array(
      array( 'Set dates &amp; study days', 'Pick a start date, exam date, and which days you can realistically study.' ),
      array( 'Add your topics', 'Name each topic and tag its confidence and priority — or just enter a count for a quick plan.' ),
      array( 'Generate your plan', 'Get a session-by-session schedule with learning, practice, review, and a mock test built in.' ),
    ),
    'url'         => 'http://localhost/wordpress/study-hours-calculator/',
  ),
  array(
    'id'          => 'attendance',
    'accent'      => 'coral',
    'icon'        => 'fa-user-check',
    'tag'         => 'Any required percentage',
    'name'        => 'Attendance Percentage Calculator',
    'blurb'       => 'Check your attendance, see how many classes you can miss or need to attend, and test what-if scenarios — for any required percentage.',
    'steps'       => array(
      array( 'Enter your numbers', 'Classes attended and total classes held — your live percentage updates as you type.' ),
      array( 'Pick your required %', 'Choose a preset from 50–95%, or enter any custom minimum your institution sets.' ),
      array( 'See what you can do', 'How many classes you can miss, how many you need to attend, and what-if scenarios.' ),
    ),
    'url'         => 'http://localhost/wordpress/attendance-percentage-calculator/',
  ),
);
?>

<section id="how" aria-label="How Scorebook's tools work">
  <div class="wrap">

    <div class="section-head">
      <span class="eyebrow">How it works</span>
      <h2>Six tools, one simple pattern</h2>
      <p>Every calculator follows the same idea — enter your numbers, get an instant answer, and see exactly how it was calculated. Pick a tool below to see how it works.</p>
    </div>

    <div class="how-tabs" role="tablist" aria-label="Choose a tool">
      <?php foreach ( $scorebook_tools as $i => $tool ) : ?>
        <button
          type="button"
          class="how-tab<?php echo 0 === $i ? ' active' : ''; ?>"
          data-tool="<?php echo esc_attr( $tool['id'] ); ?>"
          data-accent="<?php echo esc_attr( $tool['accent'] ); ?>"
          role="tab"
          aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
        >
          <i class="fa-solid <?php echo esc_attr( $tool['icon'] ); ?>"></i>
          <span><?php echo esc_html( $tool['name'] ); ?></span>
        </button>
      <?php endforeach; ?>
    </div>

    <?php foreach ( $scorebook_tools as $i => $tool ) : ?>
      <div
        class="how-panel<?php echo 0 === $i ? ' active' : ''; ?>"
        id="how-panel-<?php echo esc_attr( $tool['id'] ); ?>"
        data-tool="<?php echo esc_attr( $tool['id'] ); ?>"
        role="tabpanel"
      >
        <div class="how-panel-inner card">

          <div class="how-panel-head">
            <div class="how-panel-stamp" data-accent="<?php echo esc_attr( $tool['accent'] ); ?>">
              <i class="fa-solid <?php echo esc_attr( $tool['icon'] ); ?>"></i>
            </div>
            <div>
              <span class="tag" data-accent="<?php echo esc_attr( $tool['accent'] ); ?>"><?php echo esc_html( $tool['tag'] ); ?></span>
              <h3><?php echo esc_html( $tool['name'] ); ?></h3>
              <p><?php echo esc_html( $tool['blurb'] ); ?></p>
            </div>
          </div>

          <div class="steps how-steps">
            <?php foreach ( $tool['steps'] as $si => $step ) : ?>
              <div class="step">
                <div class="num" data-accent="<?php echo esc_attr( $tool['accent'] ); ?>"><?php echo esc_html( $si + 1 ); ?></div>
                <h4><?php echo wp_kses_post( $step[0] ); ?></h4>
                <p><?php echo wp_kses_post( $step[1] ); ?></p>
              </div>
            <?php endforeach; ?>
          </div>

          <a href="<?php echo esc_url( $tool['url'] ); ?>" class="btn btn-primary how-cta" data-accent="<?php echo esc_attr( $tool['accent'] ); ?>" target="_blank">
            <i class="fa-solid fa-arrow-right"></i> Open <?php echo esc_html( $tool['name'] ); ?>
          </a>

        </div>
      </div>
    <?php endforeach; ?>

  </div>
</section>


  <!-- blog section -->
<?php
$scorebook_blog_query = new WP_Query( array(
  'post_type'      => 'post',
  'post_status'    => 'publish',
  'posts_per_page' => 6,
  'no_found_rows'  => true,
) );
?>

<?php if ( $scorebook_blog_query->have_posts() ) : ?>

<section id="blog" aria-label="Latest from the blog">
  <div class="wrap">

    <div class="section-head">
      <span class="eyebrow">From the blog</span>
      <h2>Study tips, guides &amp; updates</h2>
      <p>Fresh reads on grades, GPA, and getting the most out of your study time.</p>
    </div>

    <div class="blog-grid">
      <?php while ( $scorebook_blog_query->have_posts() ) : $scorebook_blog_query->the_post(); ?>

        <article class="blog-card">
          <a href="<?php the_permalink(); ?>" class="blog-thumb-link" aria-hidden="true" tabindex="-1">
            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail( 'medium_large', array( 'class' => 'blog-thumb', 'loading' => 'lazy' ) ); ?>
            <?php else : ?>
              <div class="blog-thumb blog-thumb-fallback">
                <i class="fa-solid fa-newspaper"></i>
              </div>
            <?php endif; ?>
          </a>

          <div class="blog-card-body">
            <?php
            $categories = get_the_category();
            if ( ! empty( $categories ) ) :
            ?>
              <span class="blog-tag"><?php echo esc_html( $categories[0]->name ); ?></span>
            <?php endif; ?>

            <h3 class="blog-title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>

            <p class="blog-excerpt">
              <?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '…' ) ); ?>
            </p>

            <a href="<?php the_permalink(); ?>" class="blog-readmore" target="_blank">
              Read full post <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
        </article>

      <?php endwhile; ?>
    </div>

    <div class="blog-viewall">
      <a href="<?php echo esc_url( get_category_link( get_cat_ID( 'Blog' ) ) ); ?>" class="btn btn-outline" target="_blank">
        <i class="fa-solid fa-book-open"></i> View all posts
      </a>
    </div>

  </div>
</section>

<?php wp_reset_postdata(); ?>
<?php endif; ?>

</main>
	

<?php
get_footer();
