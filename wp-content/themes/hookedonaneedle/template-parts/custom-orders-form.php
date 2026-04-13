<?php
/**
 * Template Part: Custom Orders Form
 *
 * Multi-step commission request form with step pills, progress bar,
 * and three panels (The Piece, Colors & Material, About You).
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// --- ACF data with fallbacks ---

$categories_raw = get_field('co_form_categories');
if (!empty($categories_raw)) {
    $categories = array_filter(array_map('trim', explode("\n", $categories_raw)));
} else {
    $categories = array(
        'Blanket or Throw',
        'Cardigan or Sweater',
        'Hat or Beanie',
        'Baby Items',
        'Home Decor',
        'Plushie or Novelty',
        'Tote or Bag',
        'Something else',
    );
}

$colors = get_field('co_form_colors');
if (empty($colors)) {
    $colors = array(
        array('name' => 'Cream',      'hex' => '#f5e6d3'),
        array('name' => 'Blush',      'hex' => '#e8c4b8'),
        array('name' => 'Tan',        'hex' => '#c4a882'),
        array('name' => 'Clay',       'hex' => '#8B4A4E'),
        array('name' => 'Mauve',      'hex' => '#6b4e71'),
        array('name' => 'Sage',       'hex' => '#4a7c6f'),
        array('name' => 'Dusty Blue', 'hex' => '#5b7fa6'),
        array('name' => 'Charcoal',   'hex' => '#2c2c2c'),
        array('name' => 'White',      'hex' => '#f0f0ec'),
    );
}

$materials_raw = get_field('co_form_materials');
if (!empty($materials_raw)) {
    $materials = array_filter(array_map('trim', explode("\n", $materials_raw)));
} else {
    $materials = array('Wool', 'Cotton', 'Acrylic', 'Alpaca', 'Organic / Natural', 'No preference');
}
?>

<section class="custom-orders-form-section">

    <!-- Header -->
    <div class="co-form-header">
        <p class="form-section-label">Start Your Request</p>
        <h3 class="form-section-heading font-display">Tell us about your piece</h3>

        <div class="co-step-pills">
            <button type="button" class="co-step-pill active" data-step="1">The Piece</button>
            <button type="button" class="co-step-pill" data-step="2">Colors &amp; Material</button>
            <button type="button" class="co-step-pill" data-step="3">About You</button>
        </div>

        <div class="co-progress-bar">
            <div class="co-progress-fill" style="width:33%"></div>
        </div>
    </div>

    <!-- Form -->
    <form id="co-commission-form" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="action" value="hooan_submit_commission">
        <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('hooan_commission_nonce')); ?>">

        <!-- Step 1: The Piece -->
        <div class="co-step-panel active" data-step="1">
            <div class="co-step-fields">

                <div class="co-form-field">
                    <label for="co-category">What would you like made?</label>
                    <select id="co-category" name="category">
                        <option value="">Choose a category...</option>
                        <?php foreach ($categories as $cat) : ?>
                            <option value="<?php echo esc_attr($cat); ?>"><?php echo esc_html($cat); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="co-form-field">
                    <label for="co-vision">Describe your vision</label>
                    <textarea id="co-vision" name="vision" required placeholder="Tell us anything that comes to mind — a vibe, an occasion, an inspiration. The more you share, the better we can bring your vision to life."></textarea>
                    <span class="co-field-error"></span>
                </div>

                <div class="co-form-field">
                    <label for="co-size">Do you have a size or dimensions in mind?</label>
                    <input type="text" id="co-size" name="size" placeholder="e.g. adult medium, 50 × 60 inch throw, newborn...">
                </div>

                <div class="co-btn-footer">
                    <span></span>
                    <button type="button" class="co-submit-btn co-next-btn" data-next="2">Next: Colors &amp; Material</button>
                </div>
            </div>
        </div>

        <!-- Step 2: Colors & Material -->
        <div class="co-step-panel" data-step="2">
            <div class="co-step-fields">

                <div class="co-form-field">
                    <label>Color palette</label>
                    <p class="co-field-hint">Select all that appeal to you, or describe below.</p>
                    <div class="co-swatches">
                        <?php foreach ($colors as $color) :
                            $extra_border = (strtolower($color['name']) === 'white') ? 'border:1px solid #ddd;' : '';
                        ?>
                            <label class="co-swatch" title="<?php echo esc_attr($color['name']); ?>" style="background:<?php echo esc_attr($color['hex']); ?>;<?php echo $extra_border; ?>">
                                <input type="checkbox" name="colors[]" value="<?php echo esc_attr($color['name']); ?>">
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <input type="text" name="color_description" placeholder="Or describe your colors in your own words...">
                </div>

                <div class="co-form-field">
                    <label>Preferred material</label>
                    <div class="co-material-pills">
                        <?php foreach ($materials as $mat) : ?>
                            <label class="co-material-pill">
                                <input type="checkbox" name="materials[]" value="<?php echo esc_attr($mat); ?>">
                                <span><?php echo esc_html($mat); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="co-form-field">
                    <label>Inspiration images <span class="co-label-optional">— optional</span></label>
                    <p class="co-field-hint">A photo, screenshot, or sketch goes a long way. Upload up to 3 images.</p>
                    <div class="co-upload-zone" id="co-upload-zone">
                        <span class="material-icons-outlined" style="font-size:28px;color:#c4a882;display:block;margin-bottom:10px;">cloud_upload</span>
                        <p class="co-upload-zone__title">Drop images here or click to browse</p>
                        <p class="co-upload-zone__hint">JPG, PNG, WEBP — up to 10 MB each, max 3 images</p>
                    </div>
                    <input type="file" id="co-file-input" name="inspiration_images[]" accept=".jpg,.jpeg,.png,.webp" multiple style="display:none;">
                    <div id="co-preview-grid" class="co-preview-grid"></div>
                </div>

                <div class="co-form-field">
                    <label for="co-link">Or share a link <span class="co-label-optional">— optional</span></label>
                    <input type="text" id="co-link" name="inspiration_link" placeholder="Pinterest, Instagram, a website — anything that captures the vibe">
                </div>

                <div class="co-btn-footer">
                    <button type="button" class="co-back-btn co-prev-btn" data-prev="1">Back</button>
                    <button type="button" class="co-submit-btn co-next-btn" data-next="3">Next: About You</button>
                </div>
            </div>
        </div>

        <!-- Step 3: About You -->
        <div class="co-step-panel" data-step="3">
            <div class="co-step-fields">

                <div class="co-name-grid">
                    <div class="co-form-field">
                        <label for="co-firstname">First name</label>
                        <input type="text" id="co-firstname" name="firstname" required placeholder="Your first name">
                        <span class="co-field-error"></span>
                    </div>
                    <div class="co-form-field">
                        <label for="co-lastname">Last name</label>
                        <input type="text" id="co-lastname" name="lastname" required placeholder="Your last name">
                        <span class="co-field-error"></span>
                    </div>
                </div>

                <div class="co-form-field">
                    <label for="co-email">Email address</label>
                    <input type="email" id="co-email" name="email" required placeholder="Where should we reach you?">
                    <span class="co-field-error"></span>
                </div>

                <div class="co-form-field">
                    <label for="co-gift">Is this a gift?</label>
                    <select id="co-gift" name="gift">
                        <option value="">Select...</option>
                        <option value="Yes">Yes — it's a gift</option>
                        <option value="No">No — it's for me</option>
                    </select>
                </div>

                <div class="co-form-field">
                    <label for="co-notes">Anything else we should know?</label>
                    <textarea id="co-notes" name="notes" placeholder="Deadline, special occasion, allergies to certain fibers, anything at all..." style="min-height:80px;"></textarea>
                </div>

                <div class="co-btn-footer">
                    <button type="button" class="co-back-btn co-prev-btn" data-prev="2">Back</button>
                    <button type="submit" class="co-submit-btn" id="co-submit-btn">Send My Request</button>
                </div>

                <p class="co-form-footnote">We'll follow up within 2 business days with a quote and next steps. Custom commissions start at $100.</p>
            </div>
        </div>
    </form>

    <!-- Confirmation -->
    <div id="co-confirmation" class="co-confirmation" style="display:none;">
        <h3 class="co-confirmation__heading font-display">Thank you.</h3>
        <p class="co-confirmation__text">Your request is in our hands. We'll be in touch within 2 business days to talk through your piece.</p>
        <p class="co-confirmation__footnote">Keep an eye on your inbox</p>
    </div>

</section>
