<?php
/**
 * Template Name: About
 *
 * The About page template — Jamila's story, values, and mission.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

get_header();

// ── Hero Section fields ──
$hero_label     = get_field('about_hero_label')   ?: 'The Hands &amp; Heart';
$hero_heading   = get_field('about_hero_heading') ?: 'Hi, I\'m Jamila —<br/>The Heart Behind<br/><em>Hooked on a Needle</em>';
$hero_quote     = get_field('about_hero_quote')   ?: '&ldquo;I didn\'t just learn how to crochet&hellip; I was introduced to a rhythm. A rhythm of patience. Of creativity. Of healing.&rdquo;';
$hero_image     = get_field('about_hero_image');
$hero_image_url = $hero_image ? esc_url($hero_image['url']) : get_template_directory_uri() . '/assets/images/jamila-spider.avif';

// ── Story Section fields ──
$story_opener = get_field('about_story_opener') ?: 'Hooked on a Needle was born from more than yarn — it was born from <em>purpose.</em>';
$story_body   = get_field('about_story_body')   ?: 'As a <strong>self-taught Fiber-Arts Engineer</strong>, my journey with yarn is rooted in the fusion of artistic expression and structural integrity. I don\'t just create accessories — I engineer pieces that balance <strong>texture, structure, durability, and design</strong>.';
$story_quote  = get_field('about_story_quote')  ?: 'When you support Hooked on a Needle, you\'re not just buying a handmade item — you\'re investing in a legacy of craftsmanship and a commitment to a slow, intentional way of living.';

// ── Values Section fields ──
$values_label = get_field('about_values_label') ?: 'Beyond Craftsmanship';
$values_intro = get_field('about_values_intro') ?: 'My vision extends beyond hooks and needles. I am committed to fostering a community built on growth and empowerment.';
$acf_values   = get_field('about_values');
$values       = $acf_values ?: array(
    array('num' => '01', 'title' => 'Teaching',    'heading' => 'Teaching others',                     'body' => 'Sharing the technical mastery and meditative peace of crochet with a new generation of makers who come to this craft from every walk of life.'),
    array('num' => '02', 'title' => 'Community',   'heading' => 'Building spaces',                    'body' => 'Creating safe, inclusive environments where creativity can thrive without judgment or boundary — where every maker belongs.'),
    array('num' => '03', 'title' => 'Giving Back', 'heading' => 'Giving back',                        'body' => 'Using our craft for social good, ensuring every stitch contributes to the warmth of those in need within our communities.'),
    array('num' => '04', 'title' => 'Empowerment', 'heading' => 'Encouraging women',                  'body' => 'Empowering women to find their voice and agency through the rhythmic discipline of fiber arts and shared creative practice.'),
    array('num' => '05', 'title' => 'Confidence',  'heading' => 'Turning creativity into confidence', 'body' => 'Fostering the transformative process of making something with your own hands to build unshakeable self-worth, one project at a time.'),
);

// ── Mission Section fields ──
$mission_quote = get_field('about_mission_quote') ?: '&ldquo;My mission is simple: to <em>stitch warmth,</em> beauty, and purpose into everything I touch.&rdquo;';

// ── Sign-Off Section fields ──
$sign_intro   = get_field('about_sign_intro')   ?: 'Thank you for being here, for appreciating the art of the slow stitch, and for being part of this beautiful journey.';
$sign_close   = get_field('about_sign_close')   ?: 'With love &amp; loops,';
$sign_name    = get_field('about_sign_name')    ?: 'Jamila';
$sign_founder = get_field('about_sign_founder') ?: 'Founder, Hooked on a Needle LLC';
?>

<main>
    <!-- ════════ HERO SECTION ════════ -->
    <section class="about-hero">
        <div class="about-hero__text">
            <p class="about-hero__label"><?php echo wp_kses_post($hero_label); ?></p>
            <h1 class="about-hero__heading font-display"><?php echo wp_kses_post($hero_heading); ?></h1>
            <div class="about-hero__divider"></div>
            <p class="about-hero__quote font-display"><?php echo wp_kses_post($hero_quote); ?></p>
        </div>
        <div class="about-hero__image" style="background-image: url('<?php echo esc_url($hero_image_url); ?>');"
            role="img" aria-label="<?php esc_attr_e('Jamila, founder of Hooked on a Needle', 'hookedonaneedle'); ?>">
        </div>
    </section>

    <!-- ════════ STORY SECTION ════════ -->
    <section class="about-story">
        <p class="about-story__opener font-display"><?php echo wp_kses_post($story_opener); ?></p>
        <p class="about-story__body"><?php echo wp_kses_post($story_body); ?></p>
        <div class="about-story__pullquote">
            <p class="font-display"><?php echo wp_kses_post($story_quote); ?></p>
        </div>
    </section>

    <!-- ════════ VALUES SECTION ════════ -->
    <section class="about-values">
        <p class="about-values__label"><?php echo esc_html($values_label); ?></p>
        <p class="about-values__intro"><?php echo esc_html($values_intro); ?></p>
        <div class="about-values__grid">
            <?php foreach ($values as $value) : ?>
            <div class="about-values__row">
                <div class="about-values__left">
                    <span class="about-values__num font-display"><?php echo esc_html($value['num']); ?></span>
                    <span class="about-values__title"><?php echo esc_html($value['title']); ?></span>
                </div>
                <div class="about-values__right">
                    <p class="about-values__heading font-display"><?php echo esc_html($value['heading']); ?></p>
                    <p class="about-values__body"><?php echo esc_html($value['body']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ════════ MISSION SECTION ════════ -->
    <section class="about-mission">
        <blockquote class="about-mission__quote font-display">
            <?php echo wp_kses_post($mission_quote); ?>
        </blockquote>
    </section>

    <!-- ════════ SIGN-OFF SECTION ════════ -->
    <section class="about-sign">
        <p class="about-sign__intro font-display"><?php echo wp_kses_post($sign_intro); ?></p>
        <p class="about-sign__close font-display"><?php echo wp_kses_post($sign_close); ?></p>
        <p class="about-sign__name font-display"><?php echo esc_html($sign_name); ?></p>
        <div class="about-sign__divider"></div>
        <p class="about-sign__founder"><?php echo esc_html($sign_founder); ?></p>
        <div class="about-sign__icons">
            <span class="material-icons-outlined">all_inclusive</span>
            <span class="material-icons-outlined">favorite</span>
            <span class="material-icons-outlined">auto_awesome</span>
        </div>
    </section>
</main>

<?php get_footer(); ?>