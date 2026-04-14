<?php
/**
 * Template Name: Learn
 *
 * The Learn page template — Hats for the Homeless philanthropy initiative.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

get_header();

// ── Hero Section fields ──
$hero_label     = get_field('learn_hero_label')    ?: 'A Community Initiative';
$hero_heading   = get_field('learn_hero_heading')  ?: 'Hats for the<br/><em>Homeless</em>';
$hero_subtitle  = get_field('learn_hero_subtitle') ?: 'A Hooked on a Needle Community Initiative';
$hero_cta_text  = get_field('learn_hero_cta_text') ?: 'Explore Our Impact';
$hero_image     = get_field('learn_hero_image');
$hero_image_url = $hero_image ? esc_url($hero_image['url']) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuA3M5epxAZWVVpOCx7c_Bm8QTDRnuJ9Ll9qetf0Fi4GDUBJcZC7HU2mANLL62vdix1JQyz4yeEK77Z3mUpxadH4gdTO1I-TNT66svCz99XVcGCiGlldKfPrM-yiFGU16XDSOYowaOefCbk7r755z7c-s9dCmgz3AwwAE6bnLfFATrgBDDPVo7k1_CdphByUEiwa1MvXdtOkRCLQeC7T4q6AcNNN2YYfFc3qYKZSwpfHBVivg6usiYRS2zHQ6IM0XsUWvENepRocVKU';

// ── Mission Section fields ──
$mission_quote = get_field('learn_mission_quote') ?: '&ldquo;At Hooked on a Needle, crochet is more than craft — it&rsquo;s <em>a thread of hope.</em> Our mission is to weave compassion into every stitch, providing warmth and dignity to those who need it most.&rdquo;';

// ── Distribution Section fields ──
$dist_label   = get_field('learn_dist_label')   ?: 'Community Support';
$dist_heading = get_field('learn_dist_heading') ?: 'What we distribute';
$acf_dist_items = get_field('learn_dist_items');
$dist_items = $acf_dist_items ?: array(
    array(
        'icon'  => 'headset_off',
        'title' => 'Hand-crocheted hats',
        'desc'  => 'Signature beanies made with premium, thick wool for maximum warmth.',
    ),
    array(
        'icon'  => 'front_hand',
        'title' => 'Gloves & socks',
        'desc'  => 'Essential layers to protect hands and feet from extreme temperatures.',
    ),
    array(
        'icon'  => 'bed',
        'title' => 'Sleeping bags',
        'desc'  => 'High-performance thermal bags for safety during cold nights outdoors.',
    ),
    array(
        'icon'  => 'backpack',
        'title' => 'Essential packs',
        'desc'  => 'Durable backpacks filled with toiletries, water, and non-perishables.',
    ),
);

// ── Narrative Section fields ──
$narr_heading    = get_field('learn_narr_heading')    ?: 'Human connection in the heart of Fort Worth';
$narr_body_1     = get_field('learn_narr_body_1')     ?: 'Since our inception, Hooked on a Needle has looked beyond the luxury of high-end fiber arts to address the raw realities of our local community. Based in Fort Worth, our philanthropy is centered on the belief that a handmade item carries a weight of care that a mass-produced product cannot.';
$narr_body_2     = get_field('learn_narr_body_2')     ?: 'When we hand a hat to someone on the street, we aren\'t just giving them wool — we are giving them a piece of time, a symbol of dignity, and the knowledge that they are seen.';
$narr_quote      = get_field('learn_narr_quote')      ?: '&ldquo;Every stitch represents a moment where someone was thinking of their neighbor.&rdquo;';
$narr_stat_num   = get_field('learn_narr_stat_num')   ?: '5,000+';
$narr_stat_label = get_field('learn_narr_stat_label') ?: 'Hats distributed across the Fort Worth community since 2021.';
$narr_image      = get_field('learn_narr_image');
$narr_image_url  = $narr_image ? esc_url($narr_image['url']) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuDMJ6uUhW4Gezu3DQ7YXI67Qh0YhP42oVDo8pATxQem8_RH5Fi7KhFHwOWLiWq8KQXA9ndiozH8h1BTDFeTDJ8R9YxhoUJns-m7hD0qxz8nZ-LhjnE_yWeFIZtFLVdcJPbJxI1Q0scRSrB5fDf30G5KbBDJkVmzwSDHTWfn0MLzcgmDFG8y2lOmwNXYcMu7mjue_tLytG02mprmZLEahH6uNAcEzw7sduH3M0Oq4ffwbScIuq8DiDQItLCNiEgjHvhoL_gkibv_HKs';

// ── Get Involved Section fields ──
$involve_label   = get_field('learn_involve_label')   ?: 'Get Involved';
$involve_heading = get_field('learn_involve_heading') ?: 'Ways to make a difference';
$involve_intro   = get_field('learn_involve_intro')   ?: 'Whether you have five minutes, a stash of yarn, or a desire to give financially, there is a place for you here.';
$acf_involve_cards = get_field('learn_involve_cards');
$involve_cards = $acf_involve_cards ?: array(
    array(
        'title'     => 'Crochet or knit',
        'body'      => 'Download our official Warmth Beanie pattern and contribute your skills. We accept finished items year-round.',
        'link_text' => 'Download pattern',
        'link_url'  => '#',
        'featured'  => false,
    ),
    array(
        'title'     => 'Donate yarn',
        'body'      => 'Unused skeins of wool or acrylic blends can find new purpose. See our drop-off locations or mail-in guide.',
        'link_text' => 'Learn how to donate',
        'link_url'  => '#',
        'featured'  => false,
    ),
    array(
        'title'     => 'Financial contribution',
        'body'      => '100% of proceeds from our philanthropy fund go directly to material sourcing and essential supply packs.',
        'link_text' => 'Donate now',
        'link_url'  => '#',
        'featured'  => true,
    ),
);

// ── Location Section fields ──
$loc_heading = get_field('learn_loc_heading') ?: 'Visit our workshop';
$loc_desc    = get_field('learn_loc_desc')    ?: 'Our Fort Worth creative studio doubles as our distribution hub. Join us for community stitch nights every Thursday.';
$loc_address = get_field('learn_loc_address') ?: '402 Magnolia Avenue, Fort Worth, TX 76104';
$acf_loc_details = get_field('learn_loc_details');
$loc_details = $acf_loc_details ?: array(
    array(
        'icon'  => 'location_on',
        'title' => 'Main Studio',
        'body'  => '402 Magnolia Avenue, Fort Worth, TX 76104',
    ),
    array(
        'icon'  => 'schedule',
        'title' => 'Donation Hours',
        'body'  => 'Mon–Fri: 10am – 6pm',
    ),
);
$map_query = rawurlencode($loc_address);
?>

<main>
    <!-- ════════ HERO SECTION ════════ -->
    <section class="learn-hero">
        <div class="learn-hero__bg" style="background-image: url('<?php echo esc_url($hero_image_url); ?>');"></div>
        <div class="learn-hero__overlay"></div>
        <div class="learn-hero__content">
            <p class="learn-hero__label"><?php echo esc_html($hero_label); ?></p>
            <h1 class="learn-hero__h1 font-display"><?php echo wp_kses_post($hero_heading); ?></h1>
            <p class="learn-hero__sub font-display"><?php echo esc_html($hero_subtitle); ?></p>
            <a class="learn-hero__cta" href="#mission"><?php echo esc_html($hero_cta_text); ?></a>
        </div>
    </section>

    <!-- ════════ MISSION QUOTE SECTION ════════ -->
    <section class="learn-mission" id="mission">
        <p class="learn-mission__quote font-display"><?php echo wp_kses_post($mission_quote); ?></p>
        <div class="learn-mission__divider"></div>
    </section>

    <!-- ════════ DISTRIBUTION GRID SECTION ════════ -->
    <section class="learn-distribute">
        <div class="learn-distribute__label"><?php echo esc_html($dist_label); ?></div>
        <h2 class="learn-distribute__h2 font-display"><?php echo esc_html($dist_heading); ?></h2>
        <div class="learn-distribute__grid">
            <?php foreach ($dist_items as $item) : ?>
            <div class="learn-distribute__item">
                <span class="material-icons-outlined learn-distribute__icon"><?php echo esc_html($item['icon']); ?></span>
                <p class="learn-distribute__title font-display"><?php echo esc_html($item['title']); ?></p>
                <p class="learn-distribute__body"><?php echo esc_html($item['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ════════ NARRATIVE SECTION ════════ -->
    <section class="learn-narrative-wrap">
        <div class="learn-narrative">
            <div class="learn-narrative__text">
                <h3 class="learn-narrative__heading font-display"><?php echo esc_html($narr_heading); ?></h3>
                <p class="learn-narrative__body"><?php echo wp_kses_post($narr_body_1); ?></p>
                <p class="learn-narrative__body"><?php echo wp_kses_post($narr_body_2); ?></p>
                <div class="learn-narrative__pullquote">
                    <p class="font-display"><?php echo esc_html($narr_quote); ?></p>
                </div>
            </div>
            <div class="learn-narrative__img-wrap">
                <img class="learn-narrative__img" src="<?php echo esc_url($narr_image_url); ?>" alt="<?php esc_attr_e('Community outreach volunteer', 'hookedonaneedle'); ?>" loading="lazy" decoding="async" />
                <div class="learn-narrative__stat">
                    <p class="learn-narrative__stat-num font-display"><?php echo esc_html($narr_stat_num); ?></p>
                    <p class="learn-narrative__stat-label"><?php echo esc_html($narr_stat_label); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════ GET INVOLVED SECTION ════════ -->
    <section class="learn-involve">
        <div class="learn-involve__inner">
            <div class="learn-involve__label"><?php echo esc_html($involve_label); ?></div>
            <h2 class="learn-involve__h2 font-display"><?php echo esc_html($involve_heading); ?></h2>
            <p class="learn-involve__intro"><?php echo esc_html($involve_intro); ?></p>
            <div class="learn-involve__grid">
                <?php foreach ($involve_cards as $index => $card) :
                    $is_featured = !empty($card['featured']);
                    $num = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                ?>
                <div class="learn-involve__card<?php echo $is_featured ? ' learn-involve__card--featured' : ''; ?>">
                    <div class="learn-involve__num font-display"><?php echo esc_html($num); ?></div>
                    <p class="learn-involve__card-title font-display"><?php echo esc_html($card['title']); ?></p>
                    <p class="learn-involve__card-body"><?php echo esc_html($card['body']); ?></p>
                    <?php if ($is_featured) : ?>
                        <a class="learn-involve__donate-btn" href="<?php echo esc_url($card['link_url']); ?>"><?php echo esc_html($card['link_text']); ?></a>
                    <?php else : ?>
                        <a class="learn-involve__link" href="<?php echo esc_url($card['link_url']); ?>"><?php echo esc_html($card['link_text']); ?></a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ════════ LOCATION SECTION ════════ -->
    <section class="learn-location">
        <div class="learn-location__box">
            <div class="learn-location__text">
                <h3 class="learn-location__heading font-display"><?php echo esc_html($loc_heading); ?></h3>
                <p class="learn-location__desc"><?php echo esc_html($loc_desc); ?></p>
                <?php foreach ($loc_details as $detail) : ?>
                <div class="learn-location__detail">
                    <span class="material-icons-outlined"><?php echo esc_html($detail['icon']); ?></span>
                    <div>
                        <p class="learn-location__detail-title"><?php echo esc_html($detail['title']); ?></p>
                        <p class="learn-location__detail-body"><?php echo esc_html($detail['body']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="learn-location__map-wrap">
                <iframe
                    class="learn-location__map"
                    src="https://maps.google.com/maps?q=<?php echo $map_query; ?>&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                    width="100%"
                    height="100%"
                    style="border:0; min-height:420px; filter:grayscale(40%);"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="<?php esc_attr_e('Workshop location map', 'hookedonaneedle'); ?>">
                </iframe>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
