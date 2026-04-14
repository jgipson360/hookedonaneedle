/**
 * Waitlist Form Handler
 *
 * Handles email validation, form submission via AJAX, and UI feedback.
 * Supports modal open/close and name + email capture.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

class WaitlistForm {
  /**
   * Initialize form handler
   *
   * @param {HTMLFormElement} formElement - The form element to handle
   */
  constructor(formElement) {
    this.form = formElement;
    this.emailInput = null;
    this.nameInput = null;
    this.submitButton = null;
    this.messageContainer = null;
    this.loadingElement = null;
    this.originalButtonText = "";

    // Email regex pattern for validation
    this.emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    this.init();
  }

  /**
   * Initialize the form
   */
  init() {
    if (!this.form) return;

    this.emailInput = this.form.querySelector('input[type="email"]');
    this.nameInput = this.form.querySelector('input[name="name"]');
    this.submitButton = this.form.querySelector('button[type="submit"]');
    // Message container may be inside or after the form
    this.messageContainer =
      this.form.querySelector(".form-message") ||
      this.form.parentElement.querySelector(".form-message");
    this.loadingElement = this.form.querySelector(".form-loading");

    if (this.submitButton) {
      this.originalButtonText = this.submitButton.innerHTML;
    }

    this.bindEvents();
  }

  /**
   * Bind event listeners
   */
  bindEvents() {
    // Form submission
    this.form.addEventListener("submit", (e) => this.handleSubmit(e));

    // Real-time validation on input
    if (this.emailInput) {
      this.emailInput.addEventListener("input", () => this.handleInput());
      this.emailInput.addEventListener("blur", () => this.validateOnBlur());
    }
  }

  /**
   * Handle input event for real-time feedback
   */
  handleInput() {
    // Clear any existing error message when user starts typing
    this.clearMessage();

    // Remove error styling
    if (this.emailInput) {
      this.emailInput.classList.remove("border-red-500");
    }
  }

  /**
   * Validate email on blur
   */
  validateOnBlur() {
    const email = this.emailInput.value.trim();

    if (email && !this.validateEmail(email)) {
      this.showError("Please enter a valid email address");
      this.emailInput.classList.add("border-red-500");
    }
  }

  /**
   * Validate email format
   *
   * @param {string} email - Email address to validate
   * @returns {boolean} True if valid
   */
  validateEmail(email) {
    return this.emailPattern.test(email);
  }

  /**
   * Show error message
   *
   * @param {string} message - Error message to display
   */
  showError(message) {
    if (this.messageContainer) {
      this.messageContainer.innerHTML = `
                <div class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm mt-3">
                    <span class="material-icons-outlined text-sm">error_outline</span>
                    <span>${message}</span>
                </div>
            `;
      this.messageContainer.classList.remove("hidden");
    }

    if (this.emailInput) {
      this.emailInput.classList.add("border-red-500");
    }
  }

  /**
   * Show success message
   *
   * @param {string} message - Success message to display
   */
  showSuccess(message) {
    if (this.messageContainer) {
      this.messageContainer.innerHTML = `
                <div class="flex items-center gap-2 text-green-600 dark:text-green-400 text-sm mt-3">
                    <span class="material-icons-outlined text-sm">check_circle</span>
                    <span>${message}</span>
                </div>
            `;
      this.messageContainer.classList.remove("hidden");
    }

    if (this.emailInput) {
      this.emailInput.classList.remove("border-red-500");
      this.emailInput.value = "";
    }
  }

  /**
   * Clear any displayed message
   */
  clearMessage() {
    if (this.messageContainer) {
      this.messageContainer.innerHTML = "";
      this.messageContainer.classList.add("hidden");
    }
  }

  /**
   * Show loading state
   */
  showLoading() {
    if (this.submitButton) {
      this.submitButton.disabled = true;
      this.submitButton.innerHTML = `
                <span class="flex items-center gap-2">
                    <span class="spinner"></span>
                    <span>Submitting...</span>
                </span>
            `;
    }
  }

  /**
   * Hide loading state
   */
  hideLoading() {
    if (this.submitButton) {
      this.submitButton.disabled = false;
      this.submitButton.innerHTML = this.originalButtonText;
    }
  }

  /**
   * Submit form via AJAX
   *
   * @param {string} email - Email address to submit
   * @param {string} name  - Subscriber name
   * @returns {Promise} Promise resolving to response data
   */
  async submitForm(email, name) {
    // Check if WordPress AJAX data is available
    if (typeof hookedOnANeedle === "undefined") {
      throw new Error("WordPress AJAX configuration not available");
    }

    const formData = new FormData();
    formData.append("action", "submit_waitlist");
    formData.append("email", email);
    formData.append("name", name);
    formData.append("nonce", hookedOnANeedle.nonce);

    const response = await fetch(hookedOnANeedle.ajaxUrl, {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    return response.json();
  }

  /**
   * Handle form submission
   *
   * @param {Event} event - Submit event
   */
  async handleSubmit(event) {
    event.preventDefault();

    const email = this.emailInput ? this.emailInput.value.trim() : "";
    const name = this.nameInput ? this.nameInput.value.trim() : "";

    // Validate email
    if (!email) {
      this.showError("Please enter your email address");
      return;
    }

    if (!this.validateEmail(email)) {
      this.showError("Please enter a valid email address");
      return;
    }

    // Show loading state
    this.showLoading();
    this.clearMessage();

    try {
      const response = await this.submitForm(email, name);

      if (response.success) {
        this.showSuccess(
          response.data.message ||
            "Thank you! You've been added to the waitlist.",
        );
        // Reset name field too
        if (this.nameInput) {
          this.nameInput.value = "";
        }
      } else {
        this.showError(
          response.data.message || "An error occurred. Please try again.",
        );
      }
    } catch (error) {
      console.error("Form submission error:", error);
      this.showError("An error occurred. Please try again later.");
    } finally {
      this.hideLoading();
    }
  }
}

/**
 * Waitlist Modal Controller
 *
 * Opens / closes the #waitlist-modal overlay.
 */
class WaitlistModal {
  constructor() {
    this.modal = document.getElementById("waitlist-modal");
    this.backdrop = document.getElementById("waitlist-modal-backdrop");
    this.closeBtn = document.getElementById("waitlist-modal-close");

    if (!this.modal) return;

    this.bindEvents();
  }

  bindEvents() {
    // Open triggers
    document.querySelectorAll(".waitlist-modal-trigger").forEach((btn) => {
      btn.addEventListener("click", () => this.open());
    });

    // Close via X button
    if (this.closeBtn) {
      this.closeBtn.addEventListener("click", () => this.close());
    }

    // Close via backdrop click
    if (this.backdrop) {
      this.backdrop.addEventListener("click", () => this.close());
    }

    // Close via Escape key
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && this.isOpen()) {
        this.close();
      }
    });
  }

  isOpen() {
    return this.modal && !this.modal.classList.contains("hidden");
  }

  open() {
    this.modal.classList.remove("hidden");
    document.body.style.overflow = "hidden";

    // Focus the first input
    const firstInput = this.modal.querySelector("input");
    if (firstInput) {
      setTimeout(() => firstInput.focus(), 100);
    }
  }

  close() {
    this.modal.classList.add("hidden");
    document.body.style.overflow = "";
  }
}

// Initialize all waitlist forms and modal when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
  const forms = document.querySelectorAll(".waitlist-form");
  forms.forEach((form) => new WaitlistForm(form));

  new WaitlistModal();
});
