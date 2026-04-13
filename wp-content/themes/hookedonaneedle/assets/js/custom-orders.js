/**
 * Custom Orders — multi-step form navigation, validation, file upload, and AJAX submission.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

(function () {
  "use strict";

  var form = document.getElementById("co-commission-form");
  var header = document.querySelector(".co-form-header");
  var confirmation = document.getElementById("co-confirmation");
  var progressFill = document.querySelector(".co-progress-fill");
  var pills = document.querySelectorAll(".co-step-pill");
  var panels = document.querySelectorAll(".co-step-panel");
  var currentStep = 1;

  if (!form) return;

  /* ======================================================================
       Step navigation
       ====================================================================== */

  function goToStep(n) {
    // Validate before moving forward
    if (n > currentStep && !validateStep(currentStep)) return;

    currentStep = n;
    panels.forEach(function (p) {
      p.classList.toggle(
        "active",
        parseInt(p.getAttribute("data-step"), 10) === n,
      );
    });
    pills.forEach(function (p) {
      p.classList.toggle(
        "active",
        parseInt(p.getAttribute("data-step"), 10) === n,
      );
    });
    progressFill.style.width = n * 33.33 + "%";
  }

  pills.forEach(function (pill) {
    pill.addEventListener("click", function () {
      var target = parseInt(pill.getAttribute("data-step"), 10);
      if (target < currentStep) {
        currentStep = target; // allow jumping back without validation
        goToStep(target);
      } else {
        goToStep(target);
      }
    });
  });

  form.addEventListener("click", function (e) {
    var btn = e.target.closest(".co-next-btn");
    if (btn) {
      goToStep(parseInt(btn.getAttribute("data-next"), 10));
      return;
    }
    btn = e.target.closest(".co-prev-btn");
    if (btn) {
      currentStep = parseInt(btn.getAttribute("data-prev"), 10);
      goToStep(currentStep);
    }
  });

  /* ======================================================================
       Validation
       ====================================================================== */

  function setError(field, msg) {
    var wrapper = field.closest(".co-form-field");
    if (!wrapper) return;
    wrapper.classList.add("co-form-field--error");
    var span = wrapper.querySelector(".co-field-error");
    if (span) span.textContent = msg;
  }

  function clearError(field) {
    var wrapper = field.closest(".co-form-field");
    if (!wrapper) return;
    wrapper.classList.remove("co-form-field--error");
    var span = wrapper.querySelector(".co-field-error");
    if (span) span.textContent = "";
  }

  // Clear errors on input
  form.addEventListener("input", function (e) {
    clearError(e.target);
  });

  function validateStep(step) {
    var valid = true;

    if (step === 1) {
      var vision = form.querySelector("#co-vision");
      if (!vision.value.trim()) {
        setError(vision, "Please describe your vision.");
        valid = false;
      }
    }

    if (step === 3) {
      var fn = form.querySelector("#co-firstname");
      var ln = form.querySelector("#co-lastname");
      var em = form.querySelector("#co-email");

      if (!fn.value.trim()) {
        setError(fn, "First name is required.");
        valid = false;
      }
      if (!ln.value.trim()) {
        setError(ln, "Last name is required.");
        valid = false;
      }
      if (!em.value.trim()) {
        setError(em, "Email is required.");
        valid = false;
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em.value.trim())) {
        setError(em, "Please enter a valid email.");
        valid = false;
      }
    }

    return valid;
  }

  /* ======================================================================
       File upload
       ====================================================================== */

  var uploadZone = document.getElementById("co-upload-zone");
  var fileInput = document.getElementById("co-file-input");
  var previewGrid = document.getElementById("co-preview-grid");
  var storedFiles = [];
  var maxFiles = 3;
  var maxSize = 10 * 1024 * 1024;
  var allowedTypes = ["image/jpeg", "image/png", "image/webp"];

  if (uploadZone && fileInput) {
    uploadZone.addEventListener("click", function () {
      fileInput.click();
    });

    uploadZone.addEventListener("dragover", function (e) {
      e.preventDefault();
      uploadZone.classList.add("drag-over");
    });
    uploadZone.addEventListener("dragleave", function () {
      uploadZone.classList.remove("drag-over");
    });
    uploadZone.addEventListener("drop", function (e) {
      e.preventDefault();
      uploadZone.classList.remove("drag-over");
      addFiles(e.dataTransfer.files);
    });

    fileInput.addEventListener("change", function () {
      addFiles(fileInput.files);
      fileInput.value = "";
    });
  }

  function addFiles(fileList) {
    for (var i = 0; i < fileList.length; i++) {
      if (storedFiles.length >= maxFiles) break;
      var f = fileList[i];
      if (allowedTypes.indexOf(f.type) === -1) continue;
      if (f.size > maxSize) continue;
      storedFiles.push(f);
      renderThumb(f, storedFiles.length - 1);
    }
    toggleUploadZone();
  }

  function renderThumb(file, idx) {
    var reader = new FileReader();
    reader.onload = function (evt) {
      var thumb = document.createElement("div");
      thumb.className = "co-preview-thumb";
      thumb.setAttribute("data-idx", idx);

      var img = document.createElement("img");
      img.src = evt.target.result;
      img.alt = file.name;

      var btn = document.createElement("button");
      btn.type = "button";
      btn.className = "co-preview-remove";
      btn.innerHTML = "&#x2715;";
      btn.addEventListener("click", function (ev) {
        ev.stopPropagation();
        storedFiles.splice(idx, 1);
        rebuildPreviews();
      });

      thumb.appendChild(img);
      thumb.appendChild(btn);
      previewGrid.appendChild(thumb);
    };
    reader.readAsDataURL(file);
  }

  function rebuildPreviews() {
    previewGrid.innerHTML = "";
    storedFiles.forEach(function (f, i) {
      renderThumb(f, i);
    });
    toggleUploadZone();
  }

  function toggleUploadZone() {
    if (!uploadZone) return;
    if (storedFiles.length >= maxFiles) {
      uploadZone.style.opacity = "0.45";
      uploadZone.style.pointerEvents = "none";
    } else {
      uploadZone.style.opacity = "1";
      uploadZone.style.pointerEvents = "auto";
    }
  }

  /* ======================================================================
       Color swatches & material pills toggle
       ====================================================================== */

  form.addEventListener("change", function (e) {
    if (e.target.closest(".co-swatch")) {
      e.target
        .closest(".co-swatch")
        .classList.toggle("selected", e.target.checked);
    }
    if (e.target.closest(".co-material-pill")) {
      e.target
        .closest(".co-material-pill")
        .classList.toggle("selected", e.target.checked);
    }
  });

  /* ======================================================================
       AJAX submission
       ====================================================================== */

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    if (!validateStep(3)) return;

    var submitBtn = document.getElementById("co-submit-btn");
    submitBtn.disabled = true;
    submitBtn.textContent = "Sending…";

    var data = new FormData(form);

    // Append stored files
    storedFiles.forEach(function (f) {
      data.append("inspiration_images[]", f);
    });

    fetch(hookedOnANeedleCommission.ajaxUrl, {
      method: "POST",
      credentials: "same-origin",
      body: data,
    })
      .then(function (res) {
        return res.json();
      })
      .then(function (json) {
        if (json.success) {
          form.style.display = "none";
          header.style.display = "none";
          confirmation.style.display = "block";
        } else {
          submitBtn.disabled = false;
          submitBtn.textContent = "Send My Request";
          alert(
            json.data && json.data.message
              ? json.data.message
              : "Something went wrong. Please try again.",
          );
        }
      })
      .catch(function () {
        submitBtn.disabled = false;
        submitBtn.textContent = "Send My Request";
        alert("Network error. Please try again.");
      });
  });
})();
