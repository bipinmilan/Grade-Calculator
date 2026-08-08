document.addEventListener('DOMContentLoaded', function () {
  "use strict";

  // ============================================================
  // Shared site UI
  // ============================================================
  const yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  const cards = document.querySelectorAll('.tool-card');
  if (cards.length) {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion) {
      cards.forEach(c => c.classList.add('in'));
    } else if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
          if (entry.isIntersecting) {
            setTimeout(() => entry.target.classList.add('in'), i * 90);
            io.unobserve(entry.target);
          }
        });
      }, { threshold: 0.15 });
      cards.forEach(c => io.observe(c));
    } else {
      cards.forEach(c => c.classList.add('in'));
    }
  }

  // Shared helper used by more than one calculator below
  function animateValue(el, end, decimals = 0, suffix = "") {
    if (!el) return;
    const start = 0;
    const duration = 700;
    const startTime = performance.now();
    function step(now) {
      const progress = Math.min((now - startTime) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      const current = start + (end - start) * eased;
      el.textContent = current.toFixed(decimals) + suffix;
      if (progress < 1) requestAnimationFrame(step);
      else el.textContent = end.toFixed(decimals) + suffix;
    }
    requestAnimationFrame(step);
  }
  // ============================================================
  // "How it works" tab switcher (homepage)
  // ============================================================
  (function () {
    const tabs = document.querySelectorAll('.how-tab');
    const panels = document.querySelectorAll('.how-panel');
    if (!tabs.length || !panels.length) return; // not on this page

    tabs.forEach(tab => {
      tab.addEventListener('click', function () {
        const target = tab.dataset.tool;

        tabs.forEach(t => {
          t.classList.remove('active');
          t.setAttribute('aria-selected', 'false');
        });
        tab.classList.add('active');
        tab.setAttribute('aria-selected', 'true');

        panels.forEach(p => p.classList.toggle('active', p.dataset.tool === target));
      });
    });
  })();

  // ============================================================
  // 1) Grade Calculator  (#gradeForm)
  // ============================================================
  (function () {
    const form = document.getElementById('gradeForm');
    if (!form) return;

    const GRADE_TABLE = [
      { min: 90, grade: "A+", cgpa: 4.0, color: "#2F8F5B" },
      { min: 80, grade: "A",  cgpa: 3.6, color: "#3AA36B" },
      { min: 70, grade: "B+", cgpa: 3.2, color: "#2E5AAC" },
      { min: 60, grade: "B",  cgpa: 2.8, color: "#4472C4" },
      { min: 50, grade: "C+", cgpa: 2.4, color: "#B8791E" },
      { min: 40, grade: "C",  cgpa: 2.0, color: "#C98A1F" },
      { min: 35, grade: "D",  cgpa: 1.6, color: "#C7743A" },
      { min: 0,  grade: "F",  cgpa: 0.0, color: "#C7402B" }
    ];
    const PASS_THRESHOLD = 35;

    const nameEl = document.getElementById('studentName');
    const errName = document.getElementById('err-name');
    const totalEl = document.getElementById('totalQuestions');
    const attemptedEl = document.getElementById('attemptedQuestions');
    const wrongEl = document.getElementById('wrongQuestions');
    const errTotal = document.getElementById('err-total');
    const errAttempted = document.getElementById('err-attempted');
    const errWrong = document.getElementById('err-wrong');
    const wrongHint = document.getElementById('wrongHint');
    const wrongHintText = document.getElementById('wrongHintText');
    const resultCard = document.getElementById('resultCard');
    const liveToggle = document.getElementById('liveToggle');
    const toast = document.getElementById('toast');

    let lastResult = null;

    function clearErrors() {
      if (errName) errName.textContent = "";
      if (errTotal) errTotal.textContent = "";
      if (errAttempted) errAttempted.textContent = "";
      if (errWrong) errWrong.textContent = "";
      [nameEl, totalEl, attemptedEl, wrongEl].forEach(el => { if (el) el.style.borderColor = ""; });
    }
    function markError(el, errEl, msg) {
      if (el) el.style.borderColor = "var(--red)";
      if (errEl) errEl.textContent = msg;
    }
    function validate() {
      clearErrors();
      const name = nameEl ? nameEl.value.trim() : "";
      const total = Number(totalEl ? totalEl.value : NaN);
      const attempted = Number(attemptedEl ? attemptedEl.value : NaN);
      const wrong = Number(wrongEl ? wrongEl.value : NaN);
      let valid = true;

      if (name === "") { markError(nameEl, errName, "Please enter the student's full name."); valid = false; }
      if (!totalEl || totalEl.value === "" || isNaN(total) || total <= 0) { markError(totalEl, errTotal, "Total questions must be greater than 0."); valid = false; }
      if (!attemptedEl || attemptedEl.value === "" || isNaN(attempted) || attempted < 0) { markError(attemptedEl, errAttempted, "Attempted questions cannot be negative."); valid = false; }
      if (!wrongEl || wrongEl.value === "" || isNaN(wrong) || wrong < 0) { markError(wrongEl, errWrong, "Wrong questions cannot be negative."); valid = false; }
      if (valid && attempted > total) { markError(attemptedEl, errAttempted, "Attempted cannot exceed total questions."); valid = false; }
      if (valid && wrong > attempted) { markError(wrongEl, errWrong, "Wrong cannot exceed attempted questions."); valid = false; }
      return valid ? { name, total, attempted, wrong } : null;
    }

    function updateWrongHint() {
      if (!wrongHint || !totalEl || !attemptedEl) return;
      const total = Number(totalEl.value);
      const attempted = Number(attemptedEl.value);
      if (totalEl.value !== "" && attemptedEl.value !== "" && total > 0 && attempted >= 0 && attempted <= total) {
        const unattempted = total - attempted;
        wrongHintText.textContent = `You can enter 0–${attempted} wrong answers (Unattempted so far: ${unattempted})`;
        wrongHint.style.display = "flex";
      } else {
        wrongHint.style.display = "none";
      }
    }

    function getGradeInfo(percentage) {
      for (const row of GRADE_TABLE) { if (percentage >= row.min) return row; }
      return GRADE_TABLE[GRADE_TABLE.length - 1];
    }

    function launchConfetti() {
      const colors = ['#2F8F5B', '#3AA36B', '#B8791E', '#2E5AAC', '#C7402B'];
      for (let i = 0; i < 50; i++) {
        const piece = document.createElement('div');
        piece.className = 'confetti-piece';
        piece.style.left = Math.random() * 100 + 'vw';
        piece.style.width = (6 + Math.random() * 6) + 'px';
        piece.style.height = (6 + Math.random() * 6) + 'px';
        piece.style.background = colors[Math.floor(Math.random() * colors.length)];
        piece.style.animationDuration = (2.5 + Math.random() * 1.5) + 's';
        document.body.appendChild(piece);
        setTimeout(() => piece.remove(), 4200);
      }
    }

    let toastTimer;
    function showToast(msg, icon = "fa-circle-check") {
      if (!toast) return;
      clearTimeout(toastTimer);
      toast.innerHTML = `<i class="fa-solid ${icon}"></i> ${msg}`;
      toast.classList.add('show');
      toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
    }

    function calculate(showErrors = true) {
      const data = validate();
      if (!data) {
        if (showErrors && resultCard) resultCard.classList.remove('show');
        return null;
      }
      const { name, total, attempted, wrong } = data;
      const correct = attempted - wrong;
      const unattempted = total - attempted;
      const percentage = (correct / total) * 100;
      const gradeInfo = getGradeInfo(percentage);
      const passed = percentage >= PASS_THRESHOLD;

      const result = { name, total, attempted, wrong, correct, unattempted, percentage, gradeInfo, passed };
      lastResult = result;
      renderResult(result);
      return result;
    }

    function renderResult(r) {
      if (!resultCard) return;
      resultCard.classList.add('show');

      const setText = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
      setText('studentNameDisplay', r.name);
      setText('gradeBadgeText', r.gradeInfo.grade);

      const badge = document.getElementById('gradeBadge');
      if (badge) {
        badge.style.borderColor = r.gradeInfo.color;
        badge.style.color = r.gradeInfo.color;
      }

      animateValue(document.getElementById('cgpaValue'), r.gradeInfo.cgpa, 1);

      const statusPill = document.getElementById('statusPill');
      if (statusPill) {
        statusPill.textContent = r.passed ? "PASS" : "FAIL";
        statusPill.className = "status-pill " + (r.passed ? "status-pass" : "status-fail");
      }

      setText('percentLabel', r.percentage.toFixed(2) + "%");
      requestAnimationFrame(() => {
        const fill = document.getElementById('progressFill');
        if (fill) {
          fill.style.width = Math.min(Math.max(r.percentage, 0), 100) + "%";
          fill.style.background = r.passed
            ? "linear-gradient(90deg, #2F8F5B, #57b57e)"
            : "linear-gradient(90deg, #C7402B, #e0715e)";
        }
      });

      animateValue(document.getElementById('statTotal'), r.total, 0);
      animateValue(document.getElementById('statAttempted'), r.attempted, 0);
      animateValue(document.getElementById('statCorrect'), r.correct, 0);
      animateValue(document.getElementById('statWrong'), r.wrong, 0);
      animateValue(document.getElementById('statUnattempted'), r.unattempted, 0);

      if (r.gradeInfo.grade === "A+" || r.gradeInfo.grade === "A") launchConfetti();
      resultCard.scrollIntoView({ behavior: "smooth", block: "nearest" });
    }

    function resultToText() {
      if (!lastResult) return "";
      const r = lastResult;
      return `📊 Grade Calculator Results
Student Name: ${r.name}
Total Questions: ${r.total}
Attempted: ${r.attempted}
Correct: ${r.correct}
Wrong: ${r.wrong}
Unattempted: ${r.unattempted}
Percentage: ${r.percentage.toFixed(2)}%
Grade: ${r.gradeInfo.grade}
CGPA: ${r.gradeInfo.cgpa.toFixed(1)}
Status: ${r.passed ? "PASS" : "FAIL"}`;
    }

    form.addEventListener('submit', function (e) { e.preventDefault(); calculate(true); });

    const resetBtn = document.getElementById('resetBtn');
    if (resetBtn) {
      resetBtn.addEventListener('click', function () {
        form.reset();
        clearErrors();
        if (resultCard) resultCard.classList.remove('show');
        if (wrongHint) wrongHint.style.display = "none";
        lastResult = null;
      });
    }

    [totalEl, attemptedEl, wrongEl].forEach(el => {
      if (el) el.addEventListener('input', function () { if (liveToggle && liveToggle.checked) calculate(false); });
    });
    [totalEl, attemptedEl].forEach(el => { if (el) el.addEventListener('input', updateWrongHint); });
    if (liveToggle) liveToggle.addEventListener('change', function () { if (liveToggle.checked) calculate(false); });

    const copyBtn = document.getElementById('copyBtn');
    if (copyBtn) {
      copyBtn.addEventListener('click', function () {
        if (!lastResult) { showToast("Calculate first!", "fa-triangle-exclamation"); return; }
        navigator.clipboard.writeText(resultToText())
          .then(() => showToast("Results copied to clipboard!"))
          .catch(() => showToast("Could not copy results.", "fa-triangle-exclamation"));
      });
    }

    const printBtn = document.getElementById('printBtn');
    if (printBtn) {
      printBtn.addEventListener('click', function () {
        if (!lastResult) { showToast("Calculate first!", "fa-triangle-exclamation"); return; }
        window.print();
      });
    }

    const pdfBtn = document.getElementById('pdfBtn');
    if (pdfBtn) {
      pdfBtn.addEventListener('click', function () {
        if (!lastResult) { showToast("Calculate first!", "fa-triangle-exclamation"); return; }
        if (typeof html2canvas === 'undefined') {
          showToast("PDF export unavailable (html2canvas not loaded).", "fa-triangle-exclamation");
          return;
        }
        const capture = document.getElementById('resultCapture');
        if (!capture) return;
        html2canvas(capture, { backgroundColor: '#ffffff', scale: 2 }).then(canvas => {
          const imgData = canvas.toDataURL('image/png');
          const w = window.open('', '_blank');
          w.document.write(`<html><head><title>Grade Result</title></head><body style="margin:0;display:flex;justify-content:center;align-items:center;">
            <img src="${imgData}" style="max-width:100%;">
          </body></html>`);
          w.document.close();
          setTimeout(() => { w.focus(); w.print(); }, 400);
          showToast("Opening PDF print dialog…");
        }).catch(() => showToast("PDF export failed.", "fa-triangle-exclamation"));
      });
    }

    const pngBtn = document.getElementById('pngBtn');
    if (pngBtn) {
      pngBtn.addEventListener('click', function () {
        if (!lastResult) { showToast("Calculate first!", "fa-triangle-exclamation"); return; }
        if (typeof html2canvas === 'undefined') {
          showToast("PNG export unavailable (html2canvas not loaded).", "fa-triangle-exclamation");
          return;
        }
        const capture = document.getElementById('resultCapture');
        if (!capture) return;
        html2canvas(capture, { backgroundColor: '#ffffff', scale: 2 }).then(canvas => {
          const link = document.createElement('a');
          link.download = 'grade-result.png';
          link.href = canvas.toDataURL('image/png');
          link.click();
          showToast("Image downloaded!");
        }).catch(() => showToast("PNG export failed.", "fa-triangle-exclamation"));
      });
    }

    const shareBtn = document.getElementById('shareBtn');
    if (shareBtn) {
      shareBtn.addEventListener('click', async function () {
        if (!lastResult) { showToast("Calculate first!", "fa-triangle-exclamation"); return; }
        const text = resultToText();
        if (navigator.share) {
          try { await navigator.share({ title: 'My Grade Results', text }); showToast("Shared successfully!"); }
          catch (e) { /* user cancelled */ }
        } else {
          navigator.clipboard.writeText(text)
            .then(() => showToast("Share not supported — copied instead!"))
            .catch(() => showToast("Could not share or copy.", "fa-triangle-exclamation"));
        }
      });
    }
  })();

  // ============================================================
  // 2) CGPA Calculator  (#subjectsList)
  // ============================================================
  (function () {
    const subjectsList = document.getElementById('subjectsList');
    const subjectCountEl = document.getElementById('subjectCount');
    if (!subjectsList || !subjectCountEl) return; // not on this page

    const GRADE_OPTIONS = [
      { grade: "A+", cgpa: 4.0, color: "#2F8F5B" },
      { grade: "A",  cgpa: 3.6, color: "#3AA36B" },
      { grade: "B+", cgpa: 3.2, color: "#2E5AAC" },
      { grade: "B",  cgpa: 2.8, color: "#4472C4" },
      { grade: "C+", cgpa: 2.4, color: "#B8791E" },
      { grade: "C",  cgpa: 2.0, color: "#C98A1F" },
      { grade: "D",  cgpa: 1.6, color: "#C7743A" },
      { grade: "NG", cgpa: 0.0, color: "#C7402B" }
    ];
    function gradeInfoFor(letter) {
      return GRADE_OPTIONS.find(g => g.grade === letter) || GRADE_OPTIONS[GRADE_OPTIONS.length - 1];
    }

    const toast = document.getElementById('toast');
    let toastTimer;
    function showToast(msg, icon = "fa-circle-check") {
      if (!toast) return;
      clearTimeout(toastTimer);
      toast.innerHTML = `<i class="fa-solid ${icon}"></i> ${msg}`;
      toast.classList.add('show');
      toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
    }

    function escapeHtml(str) {
      const div = document.createElement('div');
      div.textContent = str;
      return div.innerHTML;
    }

    const cgpaSummary = document.getElementById('cgpaSummary');
    let subjectCounter = 0;
    let syncing = false;

    function gradeOptionsHtml(selected) {
      return GRADE_OPTIONS.map(g =>
        `<option value="${g.grade}" ${g.grade === selected ? 'selected' : ''}>${g.grade}</option>`
      ).join('');
    }

    function createSubjectRow(vals = {}) {
      subjectCounter++;
      const row = document.createElement('div');
      row.className = 'subject-row';
      row.dataset.id = 'subj-' + subjectCounter;
      row.innerHTML = `
        <input type="text" class="subj-name" placeholder="Subject name" value="${vals.name ? escapeHtml(vals.name) : ''}">
        <input type="number" class="subj-credit" placeholder="Credits" min="0" step="0.5" value="${vals.credit != null ? vals.credit : ''}">
        <select class="subj-grade">${gradeOptionsHtml(vals.grade)}</select>
        <span class="subj-points-badge">--</span>
        <button type="button" class="subj-remove" aria-label="Remove subject"><i class="fa-solid fa-trash"></i></button>
      `;
      subjectsList.appendChild(row);

      const gradeSelect = row.querySelector('.subj-grade');
      const pointsBadge = row.querySelector('.subj-points-badge');

      function updateBadge() {
        const info = gradeInfoFor(gradeSelect.value);
        pointsBadge.textContent = info.cgpa.toFixed(1);
        pointsBadge.style.color = info.color;
        pointsBadge.style.borderColor = info.color;
        pointsBadge.style.borderStyle = 'solid';
      }
      updateBadge();
      gradeSelect.addEventListener('change', updateBadge);

      row.querySelector('.subj-remove').addEventListener('click', function () {
        row.remove();
        syncCountFieldToRows();
        if (subjectsList.children.length === 0 && cgpaSummary) {
          cgpaSummary.classList.remove('show');
        }
      });

      return row;
    }

    function currentRowData() {
      return Array.from(subjectsList.querySelectorAll('.subject-row')).map(row => ({
        name: row.querySelector('.subj-name').value,
        credit: row.querySelector('.subj-credit').value,
        grade: row.querySelector('.subj-grade').value
      }));
    }

    function syncSubjectRows(count) {
      count = Math.max(1, Math.min(30, count || 1));
      syncing = true;

      const existing = currentRowData();
      const rows = subjectsList.querySelectorAll('.subject-row');

      if (count < rows.length) {
        for (let i = rows.length - 1; i >= count; i--) {
          rows[i].remove();
        }
      } else if (count > rows.length) {
        for (let i = rows.length; i < count; i++) {
          createSubjectRow(existing[i] || {});
        }
      }

      subjectCountEl.value = count;
      if (subjectsList.children.length === 0 && cgpaSummary) {
        cgpaSummary.classList.remove('show');
      }
      syncing = false;
    }

    function syncCountFieldToRows() {
      if (syncing) return;
      subjectCountEl.value = subjectsList.children.length || 1;
    }

    subjectCountEl.addEventListener('input', function () {
      const n = parseInt(subjectCountEl.value, 10);
      if (!isNaN(n) && n >= 1) {
        syncSubjectRows(n);
      }
    });

    const addSubjectBtn = document.getElementById('addSubjectBtn');
    if (addSubjectBtn) {
      addSubjectBtn.addEventListener('click', function () {
        createSubjectRow();
        syncCountFieldToRows();
      });
    }

    const resetSubjectsBtn = document.getElementById('resetSubjectsBtn');
    if (resetSubjectsBtn) {
      resetSubjectsBtn.addEventListener('click', function () {
        subjectsList.innerHTML = '';
        if (cgpaSummary) cgpaSummary.classList.remove('show');
        syncSubjectRows(2);
      });
    }

    const calcCgpaBtn = document.getElementById('calcCgpaBtn');
    if (calcCgpaBtn) {
      calcCgpaBtn.addEventListener('click', function () {
        const rows = subjectsList.querySelectorAll('.subject-row');
        if (rows.length === 0) {
          showToast('Add at least one subject.', 'fa-triangle-exclamation');
          return;
        }

        let totalCredits = 0;
        let totalPoints = 0;
        let valid = true;

        rows.forEach(row => {
          const creditInput = row.querySelector('.subj-credit');
          const gradeSelect = row.querySelector('.subj-grade');
          const credit = Number(creditInput.value);

          const rowValid = creditInput.value !== '' && !isNaN(credit) && credit > 0;

          if (!rowValid) {
            creditInput.style.borderColor = 'var(--red)';
            valid = false;
            return;
          }
          creditInput.style.borderColor = '';

          const info = gradeInfoFor(gradeSelect.value);
          totalCredits += credit;
          totalPoints += credit * info.cgpa;
        });

        if (!valid) {
          showToast('Fill in valid credits (>0) for every subject.', 'fa-triangle-exclamation');
          return;
        }

        const overallCgpa = totalPoints / totalCredits;
        const overallInfo = GRADE_OPTIONS.slice().reverse().reduce(
          (acc, g) => overallCgpa >= g.cgpa ? g : acc, GRADE_OPTIONS[GRADE_OPTIONS.length - 1]
        );

        const gradeTag = document.getElementById('overallGradeTag');
        if (gradeTag) gradeTag.textContent = overallInfo.grade;

        const stamp = document.querySelector('.summary-stamp');
        if (stamp) {
          stamp.style.borderColor = overallInfo.color;
          stamp.style.color = overallInfo.color;
        }

        if (cgpaSummary) {
          cgpaSummary.classList.add('show');
          cgpaSummary.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
        animateValue(document.getElementById('totalCredits'), totalCredits, Number.isInteger(totalCredits) ? 0 : 1);
        animateValue(document.getElementById('overallCgpaVal'), overallCgpa, 2);
      });
    }

    syncSubjectRows(Number(subjectCountEl.value) || 2);
  })();

  // ============================================================
  // 3) Final Grade Target Calculator  (#calcTargetBtn)
  // ============================================================
  (function () {
    const calcBtn = document.getElementById('calcTargetBtn');
    if (!calcBtn) return; // not on this page

    const currentGradeEl = document.getElementById('currentGrade');
    const finalWeightEl = document.getElementById('finalWeight');
    const desiredGradeEl = document.getElementById('desiredGrade');
    const errCurrentGrade = document.getElementById('err-currentGrade');
    const errFinalWeight = document.getElementById('err-finalWeight');
    const errDesiredGrade = document.getElementById('err-desiredGrade');
    const targetResult = document.getElementById('targetResult');
    const neededScore = document.getElementById('neededScore');
    const verdictPill = document.getElementById('verdictPill');
    const explainText = document.getElementById('explainText');
    const targetStamp = document.querySelector('.target-stamp');

    const required = [
      currentGradeEl, finalWeightEl, desiredGradeEl,
      errCurrentGrade, errFinalWeight, errDesiredGrade,
      targetResult, neededScore, verdictPill, explainText, targetStamp
    ];
    if (required.some(el => !el)) {
      console.warn('Final grade target calculator: one or more expected elements are missing on this page.');
      return;
    }

    calcBtn.addEventListener('click', function () {
      [errCurrentGrade, errFinalWeight, errDesiredGrade].forEach(e => e.textContent = '');
      [currentGradeEl, finalWeightEl, desiredGradeEl].forEach(e => e.style.borderColor = '');

      const current = Number(currentGradeEl.value);
      const weight = Number(finalWeightEl.value);
      const desired = Number(desiredGradeEl.value);
      let valid = true;

      if (currentGradeEl.value === '' || isNaN(current) || current < 0 || current > 100) {
        currentGradeEl.style.borderColor = 'var(--red)';
        errCurrentGrade.textContent = 'Enter a value between 0 and 100.';
        valid = false;
      }
      if (finalWeightEl.value === '' || isNaN(weight) || weight <= 0 || weight > 100) {
        finalWeightEl.style.borderColor = 'var(--red)';
        errFinalWeight.textContent = 'Enter a weight between 1 and 100.';
        valid = false;
      }
      if (desiredGradeEl.value === '' || isNaN(desired) || desired < 0 || desired > 100) {
        desiredGradeEl.style.borderColor = 'var(--red)';
        errDesiredGrade.textContent = 'Enter a value between 0 and 100.';
        valid = false;
      }
      if (!valid) return;

      const w = weight / 100;
      const needed = (desired - current * (1 - w)) / w;

      const bdCurrent = document.getElementById('bdCurrent');
      const bdWeight = document.getElementById('bdWeight');
      const bdDesired = document.getElementById('bdDesired');
      if (bdCurrent) bdCurrent.textContent = current.toFixed(1) + '%';
      if (bdWeight) bdWeight.textContent = weight.toFixed(1) + '%';
      if (bdDesired) bdDesired.textContent = desired.toFixed(1) + '%';

      if (needed > 100) {
        neededScore.textContent = needed.toFixed(1) + '%';
        targetStamp.style.borderColor = 'var(--red)';
        targetStamp.style.color = 'var(--red)';
        verdictPill.textContent = 'OUT OF REACH';
        verdictPill.className = 'verdict-pill verdict-impossible';
        explainText.textContent = `That's above 100% — reaching ${desired}% overall isn't possible from here with a ${weight}% final weight.`;
      } else if (needed <= 0) {
        neededScore.textContent = '0%';
        targetStamp.style.borderColor = 'var(--green)';
        targetStamp.style.color = 'var(--green)';
        verdictPill.textContent = 'ALREADY SECURED';
        verdictPill.className = 'verdict-pill verdict-secured';
        explainText.textContent = `You've already secured at least ${desired}% overall, even with 0% on the final.`;
      } else {
        neededScore.textContent = needed.toFixed(1) + '%';
        targetStamp.style.borderColor = 'var(--amber)';
        targetStamp.style.color = 'var(--amber)';
        verdictPill.textContent = 'REACHABLE';
        verdictPill.className = 'verdict-pill verdict-reachable';
        explainText.textContent = `Score at least this much on the final (weighted ${weight}%) to reach ${desired}% overall.`;
      }

      targetResult.classList.add('show');
      targetResult.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
  })();

  // ============================================================
  // 4) GPA ↔ Percentage Converter  (#convertForm)
  // ============================================================
  (function () {
    const form = document.getElementById('convertForm');
    if (!form) return; // not on this page

    const modeGpaBtn = document.getElementById('modeGpaBtn');
    const modePercentBtn = document.getElementById('modePercentBtn');
    const scaleSelect = document.getElementById('scaleSelect');
    const valueInput = document.getElementById('valueInput');
    const valueSlider = document.getElementById('valueSlider');
    const sliderVal = document.getElementById('sliderVal');
    const valueLabel = document.getElementById('valueLabel');
    const errValue = document.getElementById('err-value');
    const liveToggle = document.getElementById('liveToggle');
    const resultCard = document.getElementById('resultCard');
    const resultBig = document.getElementById('resultBig');
    const resultUnit = document.getElementById('resultUnit');
    const resultRecap = document.getElementById('resultRecap');
    const gradePill = document.getElementById('gradePill');
    const compareBody = document.getElementById('compareBody');
    const formulaBox = document.getElementById('formulaBox');
    const toast = document.getElementById('toast');
    const resultStamp = document.querySelector('.result-stamp');

    const required = [
      modeGpaBtn, modePercentBtn, scaleSelect, valueInput, valueSlider,
      sliderVal, valueLabel, errValue, liveToggle, resultCard, resultBig,
      resultUnit, resultRecap, gradePill, compareBody, formulaBox, resultStamp
    ];
    if (required.some(el => !el)) {
      console.warn('GPA ↔ Percentage converter: one or more expected elements are missing on this page.');
      return;
    }

    const SCALES = [4.0, 4.3, 4.5, 5.0, 6.0, 7.0, 9.0, 10.0, 12.0, 20.0];

    const GRADE_TABLE = [
      { min: 90, grade: "A+", color: "#2F8F5B" },
      { min: 80, grade: "A",  color: "#3AA36B" },
      { min: 70, grade: "B+", color: "#2E5AAC" },
      { min: 60, grade: "B",  color: "#4472C4" },
      { min: 50, grade: "C+", color: "#B8791E" },
      { min: 40, grade: "C",  color: "#C98A1F" },
      { min: 35, grade: "D",  color: "#C7743A" },
      { min: 0,  grade: "F",  color: "#C7402B" }
    ];
    function gradeFor(pct) {
      for (const row of GRADE_TABLE) { if (pct >= row.min) return row; }
      return GRADE_TABLE[GRADE_TABLE.length - 1];
    }

    function gpaToPercent(gpa, scaleMax) { return (gpa / scaleMax) * 100; }
    function percentToGpa(pct, scaleMax) { return (pct / 100) * scaleMax; }

    let mode = 'gpa';
    let lastResult = null;

    function currentScaleMax() { return Number(scaleSelect.value); }

    function refreshSliderBounds() {
      const max = mode === 'gpa' ? currentScaleMax() : 100;
      valueSlider.max = max;
      valueSlider.step = mode === 'gpa' ? 0.01 : 0.1;
      if (Number(valueSlider.value) > max) valueSlider.value = max;
    }

    function setMode(newMode) {
      mode = newMode;
      modeGpaBtn.classList.toggle('active', mode === 'gpa');
      modeGpaBtn.setAttribute('aria-selected', mode === 'gpa');
      modePercentBtn.classList.toggle('active', mode === 'percent');
      modePercentBtn.setAttribute('aria-selected', mode === 'percent');

      if (mode === 'gpa') {
        valueLabel.textContent = 'Your GPA';
        valueInput.placeholder = 'e.g. 8.4';
        resultUnit.textContent = 'PERCENT';
        formulaBox.innerHTML = '<span>Formula used</span>Percentage = (GPA ÷ Scale Max) × 100';
      } else {
        valueLabel.textContent = 'Your Percentage';
        valueInput.placeholder = 'e.g. 84';
        resultUnit.textContent = 'GPA';
        formulaBox.innerHTML = '<span>Formula used</span>GPA = (Percentage ÷ 100) × Scale Max';
      }
      refreshSliderBounds();
      if (liveToggle.checked) calculate(false);
    }

    modeGpaBtn.addEventListener('click', () => setMode('gpa'));
    modePercentBtn.addEventListener('click', () => setMode('percent'));

    scaleSelect.addEventListener('change', function () {
      refreshSliderBounds();
      if (liveToggle.checked) calculate(false);
    });

    valueSlider.addEventListener('input', function () {
      valueInput.value = valueSlider.value;
      sliderVal.textContent = Number(valueSlider.value).toFixed(2);
      if (liveToggle.checked) calculate(false);
    });
    valueInput.addEventListener('input', function () {
      const v = Number(valueInput.value);
      if (!isNaN(v)) {
        const max = Number(valueSlider.max);
        valueSlider.value = Math.min(Math.max(v, 0), max);
        sliderVal.textContent = Number(valueSlider.value).toFixed(2);
      }
      if (liveToggle.checked) calculate(false);
    });

    liveToggle.addEventListener('change', function () { if (liveToggle.checked) calculate(false); });

    function validate() {
      errValue.textContent = '';
      valueInput.style.borderColor = '';
      const v = Number(valueInput.value);
      const upperBound = mode === 'gpa' ? currentScaleMax() : 100;

      if (valueInput.value === '' || isNaN(v) || v < 0) {
        valueInput.style.borderColor = 'var(--red)';
        errValue.textContent = mode === 'gpa' ? 'Enter a GPA of 0 or more.' : 'Enter a percentage of 0 or more.';
        return null;
      }
      if (v > upperBound) {
        valueInput.style.borderColor = 'var(--red)';
        errValue.textContent = mode === 'gpa'
          ? `GPA can't exceed the ${upperBound.toFixed(1)} scale max.`
          : "Percentage can't exceed 100.";
        return null;
      }
      return v;
    }

    let toastTimer;
    function showToast(msg, icon = "fa-circle-check") {
      if (!toast) return;
      clearTimeout(toastTimer);
      toast.innerHTML = `<i class="fa-solid ${icon}"></i> ${msg}`;
      toast.classList.add('show');
      toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
    }

    function calculate(showErrors = true) {
      const v = validate();
      if (v === null) {
        if (showErrors) resultCard.classList.remove('show');
        return;
      }
      const scaleMax = currentScaleMax();
      let percent, gpaOnScale;

      if (mode === 'gpa') {
        gpaOnScale = v;
        percent = gpaToPercent(v, scaleMax);
      } else {
        percent = v;
        gpaOnScale = percentToGpa(v, scaleMax);
      }
      percent = Math.min(Math.max(percent, 0), 100);

      lastResult = { mode, inputValue: v, scaleMax, percent, gpaOnScale };
      renderResult(lastResult);
    }

    function renderResult(r) {
      resultCard.classList.add('show');

      const displayValue = r.mode === 'gpa' ? r.percent : r.gpaOnScale;
      resultBig.textContent = displayValue.toFixed(2);

      const g = gradeFor(r.percent);
      gradePill.textContent = `${g.grade} · ${r.percent.toFixed(1)}%`;
      gradePill.style.background = g.color + '22';
      gradePill.style.color = g.color;

      resultStamp.style.borderColor = g.color;
      resultStamp.style.color = g.color;

      if (r.mode === 'gpa') {
        resultRecap.innerHTML = `<b>${r.inputValue.toFixed(2)}</b> GPA on a <b>${r.scaleMax.toFixed(1)}</b> scale converts to`;
      } else {
        resultRecap.innerHTML = `<b>${r.inputValue.toFixed(2)}%</b> converts to a GPA on the <b>${r.scaleMax.toFixed(1)}</b> scale`;
      }

      compareBody.innerHTML = '';
      SCALES.forEach(scale => {
        const equivGpa = percentToGpa(r.percent, scale);
        const tr = document.createElement('tr');
        if (scale === r.scaleMax) tr.className = 'current-scale';
        tr.innerHTML = `<td>${scale.toFixed(1)} scale</td><td>${equivGpa.toFixed(2)}</td>`;
        compareBody.appendChild(tr);
      });

      resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function resultToText() {
      if (!lastResult) return '';
      const r = lastResult;
      const g = gradeFor(r.percent);
      let lines = [`📊 GPA ↔ Percentage Conversion`];
      if (r.mode === 'gpa') {
        lines.push(`GPA: ${r.inputValue.toFixed(2)} (on ${r.scaleMax.toFixed(1)} scale)`);
        lines.push(`Percentage: ${r.percent.toFixed(2)}%`);
      } else {
        lines.push(`Percentage: ${r.inputValue.toFixed(2)}%`);
        lines.push(`GPA: ${r.gpaOnScale.toFixed(2)} (on ${r.scaleMax.toFixed(1)} scale)`);
      }
      lines.push(`Approx. Letter Grade: ${g.grade}`);
      lines.push('');
      lines.push('Equivalent on other scales:');
      SCALES.forEach(scale => {
        lines.push(`  ${scale.toFixed(1)} scale: ${percentToGpa(r.percent, scale).toFixed(2)}`);
      });
      return lines.join('\n');
    }

    form.addEventListener('submit', function (e) { e.preventDefault(); calculate(true); });

    const copyBtn = document.getElementById('copyBtn');
    if (copyBtn) {
      copyBtn.addEventListener('click', function () {
        if (!lastResult) { showToast('Calculate first!', 'fa-triangle-exclamation'); return; }
        navigator.clipboard.writeText(resultToText())
          .then(() => showToast('Result copied to clipboard!'))
          .catch(() => showToast('Could not copy result.', 'fa-triangle-exclamation'));
      });
    }

    const shareBtn = document.getElementById('shareBtn');
    if (shareBtn) {
      shareBtn.addEventListener('click', async function () {
        if (!lastResult) { showToast('Calculate first!', 'fa-triangle-exclamation'); return; }
        const text = resultToText();
        if (navigator.share) {
          try { await navigator.share({ title: 'GPA to Percentage Result', text }); showToast('Shared successfully!'); }
          catch (e) { /* cancelled */ }
        } else {
          navigator.clipboard.writeText(text)
            .then(() => showToast('Share not supported — copied instead!'))
            .catch(() => showToast('Could not share or copy.', 'fa-triangle-exclamation'));
        }
      });
    }

    refreshSliderBounds();
    setMode('gpa');
  })();

  // ============================================================
  // 5) Study Hours Calculator  (#planForm)
  // ============================================================
  (function () {
    const startDateEl = document.getElementById('startDate');
    const examDateEl = document.getElementById('examDate');
    const errExamDate = document.getElementById('err-examDate');
    const errDays = document.getElementById('err-days');
    const dayChips = document.querySelectorAll('.day-chip');
    const sessionLengthEl = document.getElementById('sessionLength');
    const confidenceEl = document.getElementById('confidenceSelect');
    const difficultyEl = document.getElementById('difficultySelect');
    const topicCountEl = document.getElementById('topicCount');
    const topicNameField = document.getElementById('topicNameField');
    const topicNameRows = document.getElementById('topicNameRows');
    const form = document.getElementById('planForm');

    const requiredEls = [
      startDateEl, examDateEl, errExamDate, errDays, sessionLengthEl,
      confidenceEl, difficultyEl, topicCountEl, topicNameField, topicNameRows, form
    ];
    if (requiredEls.some(el => !el)) return; // not on this page

    // ---------- Weight tables (single source of truth) ----------
    const CONF_SCORE = { weak: 3, medium: 2, strong: 1 };
    const PRIO_SCORE = { high: 3, medium: 2, low: 1 };
    const BASELINE_HOURS = { weak: 4, medium: 2.5, strong: 1.5 };
    const DAY_NAMES = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

    let topicRowCounter = 0;
    let syncingTopicCount = false;
    const advancedToggle = document.getElementById('advancedToggle');
    const topicsAdvanced = document.getElementById('topicsAdvanced');
    const topicListEl = document.getElementById('topicList');
    const includePractice = document.getElementById('includePractice');
    const includeReview = document.getElementById('includeReview');
    const includeWeak = document.getElementById('includeWeak');
    const includeMock = document.getElementById('includeMock');
    const resultCard = document.getElementById('resultCard');
    const toast = document.getElementById('toast');

    const badgeDays = document.getElementById('badgeDays');
    const badgeSessions = document.getElementById('badgeSessions');
    const badgeHours = document.getElementById('badgeHours');
    const badgeTotal = document.getElementById('badgeTotal');

    let selectedDays = new Set([1,3,5]); // Mon/Wed/Fri default
    let lastPlan = null;

    function toISODate(d){ return d.toISOString().slice(0,10); }
    function todayISO(){ return toISODate(new Date()); }

    // ---------- Init defaults ----------
    startDateEl.value = todayISO();
    const defaultExam = new Date();
    defaultExam.setDate(defaultExam.getDate() + 21);
    examDateEl.value = toISODate(defaultExam);

    function syncDayChips(){
      dayChips.forEach(chip => {
        const d = Number(chip.dataset.day);
        chip.classList.toggle('active', selectedDays.has(d));
      });
    }
    dayChips.forEach(chip => {
      chip.addEventListener('click', function(){
        const d = Number(chip.dataset.day);
        if (selectedDays.has(d)) selectedDays.delete(d); else selectedDays.add(d);
        syncDayChips();
        updateBadges();
      });
    });
    syncDayChips();

    advancedToggle.addEventListener('change', function(){
      topicsAdvanced.classList.toggle('show', advancedToggle.checked);
      topicNameField.style.display = advancedToggle.checked ? 'none' : 'block';
    });

    // ---------- Live badges ----------
    function daysUntil(){
      const start = new Date(startDateEl.value);
      const exam = new Date(examDateEl.value);
      const diff = Math.round((exam - start) / (1000*60*60*24));
      return diff;
    }

    function updateBadges(){
      const diff = daysUntil();
      const sessionsPerWeek = selectedDays.size;
      const sessionMin = Number(sessionLengthEl.value);
      const hoursPerWeek = (sessionsPerWeek * sessionMin) / 60;
      const weeks = diff > 0 ? diff / 7 : 0;
      const totalHours = hoursPerWeek * weeks;

      badgeDays.textContent = diff > 0 ? diff : '--';
      badgeSessions.textContent = sessionsPerWeek || '--';
      badgeHours.textContent = hoursPerWeek ? hoursPerWeek.toFixed(1) + 'h' : '--';
      badgeTotal.textContent = totalHours ? totalHours.toFixed(1) + 'h' : '--';
    }
    [startDateEl, examDateEl, sessionLengthEl, confidenceEl].forEach(el => el.addEventListener('input', updateBadges));
    updateBadges();

    // ---------- Toast ----------
    let toastTimer;
    function showToast(msg, icon = "fa-circle-check"){
      if (!toast) return;
      clearTimeout(toastTimer);
      toast.innerHTML = `<i class="fa-solid ${icon}"></i> ${msg}`;
      toast.classList.add('show');
      toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
    }

    // ---------- Example prefill ----------
    const exampleBtn = document.getElementById('exampleBtn');
    if (exampleBtn) {
      exampleBtn.addEventListener('click', function(){
        const s = new Date();
        const e = new Date(); e.setDate(e.getDate() + 14);
        startDateEl.value = toISODate(s);
        examDateEl.value = toISODate(e);
        selectedDays = new Set([1,2,3,4,5]);
        syncDayChips();
        sessionLengthEl.value = '45';
        difficultyEl.value = '1.0';
        confidenceEl.value = 'weak';
        advancedToggle.checked = true;
        topicNameField.style.display = 'none';
        topicsAdvanced.classList.add('show');
        topicListEl.value = "Stoichiometry | weak | high\nGases | medium | medium\nThermochemistry | strong | low\nEquilibrium | weak | high\nAcids and Bases | medium | high";
        updateBadges();
        showToast('Example loaded — hit Generate Study Plan!');
      });
    }

    function escapeHtml(str){
      const div = document.createElement('div');
      div.textContent = str;
      return div.innerHTML;
    }

    function createTopicNameRow(vals = {}, index){
      topicRowCounter++;
      const row = document.createElement('div');
      row.className = 'topic-name-row';
      row.dataset.id = 'trow-' + topicRowCounter;
      const conf = vals.confidence || confidenceEl.value;
      const prio = vals.priority || 'medium';
      row.innerHTML = `
        <span class="topic-num-badge">${index}</span>
        <input type="text" class="tname" placeholder="Topic name" value="${vals.name ? escapeHtml(vals.name) : ''}">
        <select class="tconf">
          <option value="weak" ${conf==='weak'?'selected':''}>Weak</option>
          <option value="medium" ${conf==='medium'?'selected':''}>Medium</option>
          <option value="strong" ${conf==='strong'?'selected':''}>Strong</option>
        </select>
        <select class="tprio">
          <option value="low" ${prio==='low'?'selected':''}>Low priority</option>
          <option value="medium" ${prio==='medium'?'selected':''}>Medium priority</option>
          <option value="high" ${prio==='high'?'selected':''}>High priority</option>
        </select>
        <button type="button" class="topic-row-remove" aria-label="Remove topic"><i class="fa-solid fa-trash"></i></button>
      `;
      topicNameRows.appendChild(row);
      row.querySelector('.topic-row-remove').addEventListener('click', function(){
        row.remove();
        renumberTopicRows();
        syncTopicCountToRows();
      });
      return row;
    }

    function renumberTopicRows(){
      topicNameRows.querySelectorAll('.topic-name-row').forEach((r, i) => {
        r.querySelector('.topic-num-badge').textContent = i + 1;
      });
    }

    function currentTopicRowData(){
      return Array.from(topicNameRows.querySelectorAll('.topic-name-row')).map(r => ({
        name: r.querySelector('.tname').value,
        confidence: r.querySelector('.tconf').value,
        priority: r.querySelector('.tprio').value
      }));
    }

    function syncTopicRows(count){
      count = Math.max(1, Math.min(30, count || 1));
      syncingTopicCount = true;
      const existing = currentTopicRowData();
      const rows = topicNameRows.querySelectorAll('.topic-name-row');

      if (count < rows.length){
        for (let i = rows.length - 1; i >= count; i--) rows[i].remove();
      } else if (count > rows.length){
        for (let i = rows.length; i < count; i++){
          createTopicNameRow(existing[i] || {}, i + 1);
        }
      }
      renumberTopicRows();
      topicCountEl.value = count;
      syncingTopicCount = false;
    }

    function syncTopicCountToRows(){
      if (syncingTopicCount) return;
      topicCountEl.value = topicNameRows.children.length || 1;
    }

    topicCountEl.addEventListener('input', function(){
      const n = parseInt(topicCountEl.value, 10);
      if (!isNaN(n) && n >= 1) syncTopicRows(n);
    });

    // Fairly spreads `items` across `slotCount` slots, honoring `weights` proportionally,
    // and guaranteeing every item gets at least 1 slot when slotCount >= items.length.
    function distributeItemsAcrossSlots(items, slotCount, weights){
      if (!items.length || slotCount <= 0) return [];
      const w = weights || items.map(() => 1);
      const totalW = w.reduce((a,b) => a+b, 0) || 1;

      let ideal = w.map(x => (x / totalW) * slotCount);
      let counts = ideal.map(Math.floor);
      let allocated = counts.reduce((a,b) => a+b, 0);
      let remaining = slotCount - allocated;

      const remainder = ideal.map((v,i) => v - counts[i]);
      const order = remainder.map((r,i) => i).sort((a,b) => remainder[b] - remainder[a]);
      let idx = 0;
      while (remaining > 0){
        counts[order[idx % order.length]]++;
        remaining--; idx++;
      }

      if (slotCount >= items.length){
        for (let i = 0; i < items.length; i++){
          if (counts[i] === 0){
            let maxIdx = 0;
            for (let j = 1; j < counts.length; j++) if (counts[j] > counts[maxIdx]) maxIdx = j;
            if (counts[maxIdx] > 0){ counts[maxIdx]--; counts[i]++; }
          }
        }
      }

      const result = [];
      let round = 0, added = true;
      while (added){
        added = false;
        for (let i = 0; i < items.length; i++){
          if (round < counts[i]){ result.push(items[i]); added = true; }
        }
        round++;
      }
      return result.slice(0, slotCount);
    }

    // ---------- Topic parsing ----------
    function parseTopics(){
      const raw = topicListEl.value.trim();
      if (advancedToggle.checked && raw){
        return raw.split('\n').map(l => l.trim()).filter(Boolean).map(line => {
          const parts = line.split('|').map(p => p.trim().toLowerCase());
          let conf = parts[1] && CONF_SCORE[parts[1]] ? parts[1] : confidenceEl.value;
          let prio = parts[2] && PRIO_SCORE[parts[2]] ? parts[2] : 'medium';
          return { name: line.split('|')[0].trim() || 'Topic', confidence: conf, priority: prio };
        });
      }
      const rows = currentTopicRowData();
      if (rows.length){
        return rows.map((r, i) => ({
          name: r.name.trim() || ('Topic ' + (i + 1)),
          confidence: CONF_SCORE[r.confidence] ? r.confidence : confidenceEl.value,
          priority: PRIO_SCORE[r.priority] ? r.priority : 'medium'
        }));
      }
      const n = Math.max(1, Math.min(30, Number(topicCountEl.value) || 1));
      const defaultConf = confidenceEl.value;
      const topics = [];
      for (let i = 1; i <= n; i++){ topics.push({ name: 'Topic ' + i, confidence: defaultConf, priority: 'medium' }); }
      return topics;
    }

    // ---------- Session date generation ----------
    function generateSessionDates(start, exam, days){
      const dates = [];
      let cur = new Date(start);
      while (cur < exam){
        if (days.has(cur.getDay())){
          dates.push(new Date(cur));
        }
        cur.setDate(cur.getDate() + 1);
      }
      return dates;
    }

    // ---------- Main generation ----------
    form.addEventListener('submit', function(e){
      e.preventDefault();
      errExamDate.textContent = '';
      errDays.textContent = '';
      examDateEl.style.borderColor = '';

      const start = new Date(startDateEl.value);
      const exam = new Date(examDateEl.value);
      let valid = true;

      if (!(exam > start)){
        examDateEl.style.borderColor = 'var(--red)';
        errExamDate.textContent = 'Exam date must be after the start date.';
        valid = false;
      }
      if (selectedDays.size === 0){
        errDays.textContent = 'Select at least one study day.';
        valid = false;
      }
      if (!valid){ resultCard.classList.remove('show'); return; }

      const sessionMin = Number(sessionLengthEl.value);
      const difficultyMult = Number(difficultyEl.value);
      const topics = parseTopics();
      const sessionDates = generateSessionDates(start, exam, selectedDays);
      const total = sessionDates.length;

      if (total === 0){
        errDays.textContent = 'No study sessions fall between your start and exam date with these days selected.';
        resultCard.classList.remove('show');
        return;
      }

      // ---------- Phase counts ----------
      const baseLearn = Math.min(topics.length, total);
      let remaining = total - baseLearn;

      const mockCount = includeMock.checked && remaining > 0 ? 1 : 0;
      remaining -= mockCount;

      const reviewCount = includeReview.checked && remaining > 0 ? Math.max(1, Math.round(remaining * 0.30)) : 0;
      remaining -= reviewCount;

      const weakCount = includeWeak.checked && remaining > 0 ? Math.max(1, Math.round(remaining * 0.35)) : 0;
      remaining -= weakCount;

      const practiceCount = includePractice.checked && remaining > 0 ? remaining : 0;
      remaining -= practiceCount;

      const learnCount = baseLearn + Math.max(0, remaining);

      // ---------- Topic weighting ----------
      const weakTopics = topics.filter(t => t.confidence === 'weak');
      const weakPool = (weakTopics.length ? weakTopics : topics);

      const learnWeights = topics.map(t => CONF_SCORE[t.confidence] + PRIO_SCORE[t.priority]);
      const learnAssignments = distributeItemsAcrossSlots(topics, learnCount, learnWeights);
      const weakAssignments = distributeItemsAcrossSlots(weakPool, weakCount);

      // ---------- Assign phases + topics chronologically ----------
      const plan = [];
      let learnIdx = 0, weakIdx = 0;
      for (let i = 0; i < total; i++){
        let phase, topic = null;
        if (i < learnCount){
          phase = 'Learn';
          topic = learnAssignments[learnIdx]; learnIdx++;
        } else if (i < learnCount + practiceCount){
          phase = 'Practice';
        } else if (i < learnCount + practiceCount + weakCount){
          phase = 'Weak-Spot';
          topic = weakAssignments[weakIdx]; weakIdx++;
        } else if (i < learnCount + practiceCount + weakCount + reviewCount){
          phase = 'Review';
        } else {
          phase = 'Mock';
        }
        plan.push({ date: sessionDates[i], phase, topic });
      }

      // ---------- Per-topic hours ----------
      const topicHours = {};
      topics.forEach(t => topicHours[t.name] = 0);
      plan.forEach(s => {
        if (s.topic) topicHours[s.topic.name] += sessionMin / 60;
      });

      // ---------- Readiness ----------
      const learnPracticeHours = plan.filter(s => s.phase === 'Learn' || s.phase === 'Practice' || s.phase === 'Weak-Spot')
                                      .length * sessionMin / 60;
      const recommendedHours = topics.reduce((sum, t) => sum + BASELINE_HOURS[t.confidence] * difficultyMult, 0);
      const readiness = Math.min(100, Math.round((learnPracticeHours / recommendedHours) * 100)) || 0;

      lastPlan = {
        total, sessionMin, topics, plan, topicHours, readiness,
        learnCount, practiceCount, weakCount, reviewCount, mockCount,
        totalHours: total * sessionMin / 60, daysLeft: Math.round((exam - start) / 86400000)
      };
      renderResult(lastPlan);
    });

    function renderResult(p){
      resultCard.classList.add('show');
      document.getElementById('resultDays').textContent = p.daysLeft;
      document.getElementById('resultRecap').textContent =
        `${p.total} sessions planned across ${p.topics.length} topics, totaling ${p.totalHours.toFixed(1)} hours.`;

      const pill = document.getElementById('readinessPill');
      pill.textContent = p.readiness + '% READY';
      pill.className = 'readiness-pill ' + (p.readiness >= 80 ? 'ready-high' : p.readiness >= 50 ? 'ready-mid' : 'ready-low');
      const stampColor = p.readiness >= 80 ? getComputedStyle(document.documentElement).getPropertyValue('--green')
                        : p.readiness >= 50 ? getComputedStyle(document.documentElement).getPropertyValue('--amber')
                        : getComputedStyle(document.documentElement).getPropertyValue('--red');
      document.querySelector('.result-stamp').style.borderColor = stampColor;
      document.querySelector('.result-stamp').style.color = stampColor;

      document.getElementById('statLearn').textContent = p.learnCount;
      document.getElementById('statPractice').textContent = p.practiceCount;
      document.getElementById('statWeak').textContent = p.weakCount;
      document.getElementById('statReview').textContent = p.reviewCount;

      // Topic bars
      const maxHours = Math.max(...Object.values(p.topicHours), 0.01);
      const bars = document.getElementById('topicBars');
      bars.innerHTML = '';
      p.topics.forEach(t => {
        const hrs = p.topicHours[t.name] || 0;
        const pct = (hrs / maxHours) * 100;
        const tagClass = t.confidence === 'weak' ? 'tag-weak' : t.confidence === 'strong' ? 'tag-strong' : 'tag-medium';
        const row = document.createElement('div');
        row.className = 'topic-bar-row';
        row.innerHTML = `
          <div class="topic-bar-head">
            <b>${escapeHtml(t.name)}<span class="topic-tag ${tagClass}">${t.confidence}</span></b>
            <span>${hrs.toFixed(1)}h</span>
          </div>
          <div class="topic-bar-bg"><div class="topic-bar-fill" style="width:${pct}%;"></div></div>
        `;
        bars.appendChild(row);
      });

      // Session list (cap display)
      const list = document.getElementById('sessionList');
      const moreEl = document.getElementById('sessionMore');
      list.innerHTML = '';
      const CAP = 14;
      const shown = p.plan.slice(0, CAP);
      const phaseMeta = {
        'Learn': ['phase-learn', 'fa-book'],
        'Practice': ['phase-practice', 'fa-pen'],
        'Weak-Spot': ['phase-weak', 'fa-triangle-exclamation'],
        'Review': ['phase-review', 'fa-rotate'],
        'Mock': ['phase-mock', 'fa-clipboard-check']
      };
      shown.forEach(s => {
        const [cls, icon] = phaseMeta[s.phase];
        const dayName = DAY_NAMES[s.date.getDay()];
        const dateLabel = s.date.toLocaleDateString(undefined, { month:'short', day:'numeric' });
        const topicLabel = s.topic ? s.topic.name : (s.phase === 'Practice' ? 'Mixed practice' : s.phase === 'Review' ? 'Full review' : s.phase === 'Mock' ? 'Practice exam' : '');
        const item = document.createElement('div');
        item.className = 'session-item';
        item.innerHTML = `
          <div class="session-date">${dayName}<b>${dateLabel}</b></div>
          <div class="session-info"><b>${escapeHtml(topicLabel)}</b><span>${p.sessionMin} min session</span></div>
          <span class="session-phase ${cls}"><i class="fa-solid ${icon}"></i> ${s.phase}</span>
        `;
        list.appendChild(item);
      });
      moreEl.textContent = p.plan.length > CAP ? `+ ${p.plan.length - CAP} more sessions in your full plan` : '';

      resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function planToText(){
      if (!lastPlan) return '';
      const p = lastPlan;
      const lines = [`📅 Study Plan — ${p.daysLeft} days to go`, `${p.total} sessions · ${p.totalHours.toFixed(1)} hours total · ${p.readiness}% ready`, ''];
      lines.push('Time per topic:');
      p.topics.forEach(t => lines.push(`  ${t.name} (${t.confidence}/${t.priority}): ${(p.topicHours[t.name]||0).toFixed(1)}h`));
      lines.push('');
      lines.push('Sessions:');
      p.plan.forEach(s => {
        const d = s.date.toLocaleDateString(undefined, { month:'short', day:'numeric', weekday:'short' });
        const topicLabel = s.topic ? s.topic.name : s.phase;
        lines.push(`  ${d} — ${s.phase}: ${topicLabel}`);
      });
      return lines.join('\n');
    }

    const copyBtn = document.getElementById('copyBtn');
    if (copyBtn) {
      copyBtn.addEventListener('click', function(){
        if (!lastPlan) { showToast('Generate a plan first!', 'fa-triangle-exclamation'); return; }
        navigator.clipboard.writeText(planToText())
          .then(() => showToast('Plan copied to clipboard!'))
          .catch(() => showToast('Could not copy plan.', 'fa-triangle-exclamation'));
      });
    }

    const printBtn = document.getElementById('printBtn');
    if (printBtn) {
      printBtn.addEventListener('click', function(){
        if (!lastPlan) { showToast('Generate a plan first!', 'fa-triangle-exclamation'); return; }
        window.print();
      });
    }

    const shareBtn = document.getElementById('shareBtn');
    if (shareBtn) {
      shareBtn.addEventListener('click', async function(){
        if (!lastPlan) { showToast('Generate a plan first!', 'fa-triangle-exclamation'); return; }
        const text = planToText();
        if (navigator.share){
          try { await navigator.share({ title: 'My Study Plan', text }); showToast('Shared successfully!'); }
          catch(e) { /* cancelled */ }
        } else {
          navigator.clipboard.writeText(text)
            .then(() => showToast('Share not supported — copied instead!'))
            .catch(() => showToast('Could not share or copy.', 'fa-triangle-exclamation'));
        }
      });
    }
  })();

  // ============================================================
  // 6) Attendance Calculator  (#attForm)
  // ============================================================
  (function () {
    const form = document.getElementById('attForm');
    if (!form) return; // not on this page

    function currentPercent(a, h){ return h > 0 ? (a / h) * 100 : 0; }

    function classesCanMiss(a, h, reqPct){
      const r = reqPct / 100;
      if (r <= 0) return null;
      if (r >= 1) return 0;
      const raw = (a / r) - h;
      return Math.max(0, Math.floor(raw));
    }

    function classesNeeded(a, h, reqPct){
      const r = reqPct / 100;
      if (h === 0) return Math.ceil(r * 1000000) > 0 ? 1 : 0;
      if (a / h >= r) return 0;
      if (r >= 1) return Infinity;
      const raw = ((r * h) - a) / (1 - r);
      return Math.max(0, Math.ceil(raw));
    }

    function fmtPct(n){ return (Math.round(n * 100) / 100).toFixed(2) + '%'; }

    const toast = document.getElementById('toast');
    let toastTimer;
    function showToast(msg, icon = "fa-circle-check"){
      if (!toast) return;
      clearTimeout(toastTimer);
      toast.innerHTML = `<i class="fa-solid ${icon}"></i> ${msg}`;
      toast.classList.add('show');
      toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
    }

    const attendedEl = document.getElementById('attended');
    const heldEl = document.getElementById('held');
    const errAttended = document.getElementById('err-attended');
    const errHeld = document.getElementById('err-held');
    const errRequired = document.getElementById('err-required');
    const requiredChips = document.querySelectorAll('#requiredChips .chip');
    const customWrap = document.getElementById('customWrap');
    const customRequiredEl = document.getElementById('customRequired');
    const liveBadge = document.getElementById('liveBadge');
    const resultCard = document.getElementById('resultCard');

    const required = [
      attendedEl, heldEl, errAttended, errHeld, errRequired,
      customWrap, customRequiredEl, liveBadge, resultCard
    ];
    if (required.some(el => !el)) {
      console.warn('Attendance calculator: one or more expected elements are missing on this page.');
      return;
    }

    let requiredValue = 75;

    requiredChips.forEach(chip => {
      chip.addEventListener('click', function(){
        requiredChips.forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        if (chip.dataset.val === 'custom'){
          customWrap.classList.add('show');
          requiredValue = Number(customRequiredEl.value) || 75;
        } else {
          customWrap.classList.remove('show');
          requiredValue = Number(chip.dataset.val);
        }
      });
    });
    customRequiredEl.addEventListener('input', function(){
      requiredValue = Number(customRequiredEl.value) || requiredValue;
    });

    function updateLiveBadge(){
      const a = Number(attendedEl.value);
      const h = Number(heldEl.value);
      if (attendedEl.value !== '' && heldEl.value !== '' && h > 0 && a >= 0){
        liveBadge.textContent = fmtPct(currentPercent(a, h));
      } else {
        liveBadge.textContent = '--%';
      }
    }
    [attendedEl, heldEl].forEach(el => el.addEventListener('input', updateLiveBadge));

    function validateMain(){
      errAttended.textContent = ''; errHeld.textContent = ''; errRequired.textContent = '';
      [attendedEl, heldEl].forEach(el => el.style.borderColor = '');
      const a = Number(attendedEl.value);
      const h = Number(heldEl.value);
      let valid = true;

      if (attendedEl.value === '' || isNaN(a) || a < 0){
        attendedEl.style.borderColor = 'var(--red)'; errAttended.textContent = 'Enter classes attended (0 or more).'; valid = false;
      }
      if (heldEl.value === '' || isNaN(h) || h <= 0){
        heldEl.style.borderColor = 'var(--red)'; errHeld.textContent = 'Enter total classes held (more than 0).'; valid = false;
      }
      if (valid && a > h){
        attendedEl.style.borderColor = 'var(--red)'; errAttended.textContent = "Attended can't exceed classes held."; valid = false;
      }
      if (requiredValue <= 0 || requiredValue > 100 || isNaN(requiredValue)){
        errRequired.textContent = 'Choose a required percentage between 1 and 100.'; valid = false;
      }
      return valid ? { a, h } : null;
    }

    let lastResult = null;

    form.addEventListener('submit', function(e){
      e.preventDefault();
      const data = validateMain();
      if (!data){ resultCard.classList.remove('show'); return; }
      const { a, h } = data;
      const pct = currentPercent(a, h);
      const pass = pct >= requiredValue;
      const miss = pass ? classesCanMiss(a, h, requiredValue) : 0;
      const need = pass ? 0 : classesNeeded(a, h, requiredValue);

      lastResult = { a, h, pct, requiredValue, pass, miss, need };
      renderResult(lastResult);
    });

    function renderResult(r){
      resultCard.classList.add('show');
      const setText = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
      setText('resultPct', r.pct.toFixed(2) + '%');

      const stamp = document.querySelector('.result-stamp');
      const pill = document.getElementById('statusPill');
      if (r.pass){
        if (stamp) { stamp.style.borderColor = 'var(--green)'; stamp.style.color = 'var(--green)'; }
        if (pill) { pill.textContent = `ABOVE ${r.requiredValue}% REQUIRED`; pill.className = 'status-pill status-pass'; }
      } else {
        if (stamp) { stamp.style.borderColor = 'var(--red)'; stamp.style.color = 'var(--red)'; }
        if (pill) { pill.textContent = `BELOW ${r.requiredValue}% REQUIRED`; pill.className = 'status-pill status-fail'; }
      }

      setText('statAttended', r.a);
      setText('statHeld', r.h);
      setText('statRequired', r.requiredValue + '%');
      setText('statCurrent', r.pct.toFixed(2) + '%');
      setText('statMiss', Number.isFinite(r.miss) ? r.miss : '—');
      setText('statNeed', Number.isFinite(r.need) ? r.need : '—');

      const callout = document.getElementById('improveCallout');
      if (callout) {
        if (!r.pass){
          callout.classList.add('show');
          if (Number.isFinite(r.need)){
            callout.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> You're currently at <b>${r.pct.toFixed(2)}%</b>, below the <b>${r.requiredValue}%</b> requirement. Attend the next <b>${r.need}</b> consecutive classes to bring your attendance back up to ${r.requiredValue}%.`;
          } else {
            callout.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> At a ${r.requiredValue}% requirement with your current numbers, this target isn't mathematically reachable by attending future classes alone — talk to your instructor about your options.`;
          }
        } else {
          callout.classList.remove('show');
        }
      }

      resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function resultToText(){
      if (!lastResult) return '';
      const r = lastResult;
      return `📋 Attendance Result
Classes Attended: ${r.a}
Classes Held: ${r.h}
Current Attendance: ${r.pct.toFixed(2)}%
Required Attendance: ${r.requiredValue}%
Status: ${r.pass ? 'Above requirement' : 'Below requirement'}
Classes You Can Miss: ${Number.isFinite(r.miss) ? r.miss : 'N/A'}
Classes Needed to Reach Target: ${Number.isFinite(r.need) ? r.need : 'Not reachable'}`;
    }

    const copyBtn = document.getElementById('copyBtn');
    if (copyBtn) {
      copyBtn.addEventListener('click', function(){
        if (!lastResult) { showToast('Calculate first!', 'fa-triangle-exclamation'); return; }
        navigator.clipboard.writeText(resultToText())
          .then(() => showToast('Result copied to clipboard!'))
          .catch(() => showToast('Could not copy result.', 'fa-triangle-exclamation'));
      });
    }
    const printBtn = document.getElementById('printBtn');
    if (printBtn) {
      printBtn.addEventListener('click', function(){
        if (!lastResult) { showToast('Calculate first!', 'fa-triangle-exclamation'); return; }
        window.print();
      });
    }
    const shareBtn = document.getElementById('shareBtn');
    if (shareBtn) {
      shareBtn.addEventListener('click', async function(){
        if (!lastResult) { showToast('Calculate first!', 'fa-triangle-exclamation'); return; }
        const text = resultToText();
        if (navigator.share){
          try { await navigator.share({ title: 'My Attendance Result', text }); showToast('Shared successfully!'); }
          catch(e){ /* cancelled */ }
        } else {
          navigator.clipboard.writeText(text)
            .then(() => showToast('Share not supported — copied instead!'))
            .catch(() => showToast('Could not share or copy.', 'fa-triangle-exclamation'));
        }
      });
    }

    // ---------- Stretch goal ----------
    const stretchChips = document.querySelectorAll('#stretchChips .chip');
    const stretchCustomWrap = document.getElementById('stretchCustomWrap');
    const stretchCustomEl = document.getElementById('stretchCustomRequired');
    const stretchResult = document.getElementById('stretchResult');
    const stretchBtn = document.getElementById('stretchBtn');
    let stretchValue = 80;

    if (stretchCustomWrap && stretchCustomEl && stretchResult && stretchBtn) {
      stretchChips.forEach(chip => {
        chip.addEventListener('click', function(){
          stretchChips.forEach(c => c.classList.remove('active'));
          chip.classList.add('active');
          if (chip.dataset.val === 'custom'){
            stretchCustomWrap.classList.add('show');
            stretchValue = Number(stretchCustomEl.value) || 80;
          } else {
            stretchCustomWrap.classList.remove('show');
            stretchValue = Number(chip.dataset.val);
          }
        });
      });
      stretchCustomEl.addEventListener('input', function(){
        stretchValue = Number(stretchCustomEl.value) || stretchValue;
      });

      stretchBtn.addEventListener('click', function(){
        const a = Number(attendedEl.value);
        const h = Number(heldEl.value);
        if (attendedEl.value === '' || heldEl.value === '' || h <= 0 || a < 0 || a > h){
          showToast('Enter valid Classes Attended / Held above first.', 'fa-triangle-exclamation');
          return;
        }
        const pct = currentPercent(a, h);
        const pass = pct >= stretchValue;
        stretchResult.classList.add('show');
        if (pass){
          const miss = classesCanMiss(a, h, stretchValue);
          stretchResult.innerHTML = `At <b>${pct.toFixed(2)}%</b>, you're already above <b>${stretchValue}%</b>. You could still miss up to <b>${Number.isFinite(miss) ? miss : 0}</b> future classes and stay at or above ${stretchValue}%.`;
        } else {
          const need = classesNeeded(a, h, stretchValue);
          stretchResult.innerHTML = Number.isFinite(need)
            ? `At <b>${pct.toFixed(2)}%</b>, you're below <b>${stretchValue}%</b>. Attend the next <b>${need}</b> consecutive classes to reach ${stretchValue}%.`
            : `At <b>${pct.toFixed(2)}%</b>, reaching <b>${stretchValue}%</b> isn't mathematically possible through future attendance alone.`;
        }
      });
    }

    // ---------- What-If calculator ----------
    const modeBtns = document.querySelectorAll('.mode-btn');
    const wfAttend = document.getElementById('wf-attend');
    const wfMiss = document.getElementById('wf-miss');
    const wfRatio = document.getElementById('wf-ratio');
    const whatifBtn = document.getElementById('whatifBtn');
    const whatifResult = document.getElementById('whatifResult');

    if (modeBtns.length && wfAttend && wfMiss && wfRatio && whatifBtn && whatifResult) {
      const wfSections = { attend: wfAttend, miss: wfMiss, ratio: wfRatio };
      let wfMode = 'attend';

      modeBtns.forEach(btn => {
        btn.addEventListener('click', function(){
          modeBtns.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          wfMode = btn.dataset.mode;
          Object.keys(wfSections).forEach(k => wfSections[k].classList.toggle('show', k === wfMode));
          whatifResult.classList.remove('show');
        });
      });

      whatifBtn.addEventListener('click', function(){
        const a = Number(attendedEl.value);
        const h = Number(heldEl.value);
        if (attendedEl.value === '' || heldEl.value === '' || h <= 0 || a < 0 || a > h){
          showToast('Enter valid Classes Attended / Held above first.', 'fa-triangle-exclamation');
          return;
        }
        const beforePct = currentPercent(a, h);
        let newA = a, newH = h;
        const errRatio = document.getElementById('err-ratio');
        if (errRatio) errRatio.textContent = '';

        if (wfMode === 'attend'){
          const el = document.getElementById('wfAttendN');
          const n = Number(el ? el.value : NaN);
          if (isNaN(n) || n < 0){ showToast("Enter how many classes you'll attend.", 'fa-triangle-exclamation'); return; }
          newA = a + n; newH = h + n;
        } else if (wfMode === 'miss'){
          const el = document.getElementById('wfMissN');
          const n = Number(el ? el.value : NaN);
          if (isNaN(n) || n < 0){ showToast("Enter how many classes you'll miss.", 'fa-triangle-exclamation'); return; }
          newA = a; newH = h + n;
        } else {
          const xEl = document.getElementById('wfRatioX');
          const yEl = document.getElementById('wfRatioY');
          const x = Number(xEl ? xEl.value : NaN);
          const y = Number(yEl ? yEl.value : NaN);
          if (isNaN(x) || isNaN(y) || y <= 0 || x < 0){ showToast('Enter valid attend/next values.', 'fa-triangle-exclamation'); return; }
          if (x > y){ if (errRatio) errRatio.textContent = "Classes attended can't exceed classes in that range."; return; }
          newA = a + x; newH = h + y;
        }

        const afterPct = currentPercent(newA, newH);
        const wfBefore = document.getElementById('wfBefore');
        const wfAfter = document.getElementById('wfAfter');
        if (wfBefore) wfBefore.textContent = beforePct.toFixed(2) + '%';
        if (wfAfter) wfAfter.textContent = afterPct.toFixed(2) + '%';

        const pill = document.getElementById('wfPill');
        const pass = afterPct >= requiredValue;
        if (pill) {
          pill.textContent = pass ? `MEETS ${requiredValue}% REQUIRED` : `BELOW ${requiredValue}% REQUIRED`;
          pill.className = 'status-pill ' + (pass ? 'status-pass' : 'status-fail');
        }

        whatifResult.classList.add('show');
      });
    }
  })();

});