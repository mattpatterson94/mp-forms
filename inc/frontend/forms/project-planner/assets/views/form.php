<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://mattpatterson.xyz
 * @since      1.0.0
 *
 * @package    MpForms
 * @subpackage MpForms/inc/frontend/views
 */
?>

<form class="project-planner" method="POST" data-controller="project-planner--form" data-action="project-planner--form#submit" action="<?php echo admin_url('admin-post.php'); ?>" data-form-action="project_planner_process">
  <section class="section has-grey-bg is-relative">
    <div class="project-planner-progress">
        <progress data-target="project-planner--form.progressBar" class="progress is-small is-hidden" value="0" max="100">0%</progress>
    </div>

    <div class="project-planner-page is-visible container has-text-centered has-gutter-small-mobile" data-target="project-planner--form.page">
      <p><button class="pulse is-animated button is-medium" data-action="project-planner--form#next" data-target="project-planner--form.gettingStarted">Loading &nbsp;<i class="fa fa-spinner fa-spin"></i></button></p>
    </div>

    <div class="project-planner-page container has-text-centered has-gutter-small-mobile has-gutter-large-desktop" data-controller="project-planner--services" data-target="project-planner--form.page">
      <input type="hidden" name="services" value="" data-target="project-planner--services.services">
      <div><h4 class="title has-underline is-4 has-gutter-medium">What can we do for you?</h4></div>
      <div class="has-gutter-small">
        <div class="columns is-aligned-end">
          <div class="column">
            <a href="#" class="selectable-image" data-service="design" data-target="project-planner--services.serviceList" data-action="project-planner--services#toggle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/project-planner/design.svg">
              <p>Design</p>
            </a>
          </div>
          <div class="column">
            <a href="#" class="selectable-image" data-service="branding" data-target="project-planner--services.serviceList" data-action="project-planner--services#toggle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/project-planner/branding.svg">
              <p>Branding</p>
            </a>
          </div>
          <div class="column">
            <a href="#" class="selectable-image" data-service="social media" data-target="project-planner--services.serviceList" data-action="project-planner--services#toggle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/project-planner/social-media.svg">
              <p>Social Media</p>
            </a>
          </div>
          <div class="column">
            <a href="#" class="selectable-image" data-service="web" data-target="project-planner--services.serviceList" data-action="project-planner--services#toggle">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/project-planner/web.svg">
              <p>Web</p>
            </a>
          </div>
        </div>
      </div>
      <p class="has-gutter-small">Don’t be shy! Feel free to choose more than one option</p>
      <p><a href="#" class="button is-medium is-invisible" data-action="project-planner--form#next" data-target="project-planner--services.next">Next &gt;</a></p>
    </div>

    <div class="project-planner-page container has-text-centered has-gutter-small-mobile has-gutter-large-desktop" data-controller="project-planner--budget" data-target="project-planner--form.page">
      <input type="hidden" name="budget" value="" data-target="project-planner--budget.budget">
      <div><h4 class="title has-underline is-4 has-gutter-medium">What is your budget?</h4></div>
      <div class="columns is-aligned-end">
        <div class="column">
          <a href="#" class="selectable-image" data-budget="minimal" data-target="project-planner--budget.budgetList" data-action="project-planner--budget#toggle">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/project-planner/minimal.svg">
            <p>Minimal</p>
            </a>
        </div>
        <div class="column">
          <a href="#" class="selectable-image" data-budget="avocados" data-target="project-planner--budget.budgetList" data-action="project-planner--budget#toggle">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/project-planner/avocados.svg">
            <p>I can afford avocados</p>
            </a>
        </div>
        <div class="column">
          <a href="#" class="selectable-image" data-budget="high roller" data-target="project-planner--budget.budgetList" data-action="project-planner--budget#toggle">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/project-planner/high-roller.svg">
            <p>High Roller</p>
            </a>
        </div>
      </div>
      <p><a href="#" class="button is-medium is-invisible" data-action="project-planner--form#next"  data-target="project-planner--budget.next">Next &gt;</a></p>
    </div>

    <div class="project-planner-page container has-text-centered has-gutter-small-mobile has-gutter-large-desktop" data-target="project-planner--form.page" data-controller="project-planner--timeframe">
      <input type="hidden" name="timeframe" value="" data-target="project-planner--timeframe.timeframe">
      <div><h4 class="title has-underline is-4 has-gutter-medium">What is your timeframe?</h4></div>
      <div class="columns is-aligned-end">
        <div class="column">
          <a href="#" class="selectable-image" data-timeframe="yesterday" data-target="project-planner--timeframe.timeframeList" data-action="project-planner--timeframe#toggle">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/project-planner/yesterday.svg">
            <p>YESTERDAY!</p>
            </a>
        </div>
        <div class="column">
          <a href="#" class="selectable-image" data-timeframe="in a few weeks" data-target="project-planner--timeframe.timeframeList" data-action="project-planner--timeframe#toggle">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/project-planner/weeks.svg">
            <p>In a few weeks</p>
            </a>
        </div>
        <div class="column">
          <a href="#" class="selectable-image" data-timeframe="months" data-target="project-planner--timeframe.timeframeList" data-action="project-planner--timeframe#toggle">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/project-planner/months.svg">
            <p>In a few months</p>
            </a>
        </div>
      </div>
      <p><a href="#" class="button is-medium is-invisible" data-action="project-planner--form#next"  data-target="project-planner--timeframe.next">Next &gt;</a></p>
    </div>

    <div class="project-planner-page container has-text-centered has-gutter-small-mobile has-gutter-medium-desktop" data-target="project-planner--form.page" data-controller="project-planner--project-details">
      <div class="columns is-centered">
        <div class="column is-half">
          <div><h4 class="title has-underline is-4 has-gutter-small">Tell us more.</h4></div>
          <div class="has-gutter-small-mobile has-gutter-large-desktop">
            <div class="field">
              <textarea name="details" id="" cols="30" rows="10" class="textarea has-border" placeholder="Describe your vision, its requirements and objectives."></textarea>
            </div>
          </div>

          <h4 class="title has-underline is-4 has-gutter-small">Files / Attachments.</h4>
          <div class="field">
            <div class="file is-centered is-small is-boxed has-border">
              <label class="file-label">
                <input class="file-input" type="file" name="files" data-target="project-planner--project-details.file" data-action="change->project-planner--project-details#update">
                <span class="file-cta">
                  <span data-target="project-planner--project-details.label" class="file-label has-text-weight-bold">Select File</span>
                </span>
              </label>
            </div>
          </div>

          <div class="content has-gutter-small">
            <p><em>Attach files, documents or any inspiration that sparks your ideas.</em></p>
          </div>
        </div>
      </div>

      <p><a href="#" class="button is-medium" data-action="project-planner--form#next">Next &gt;</a></p>
    </div>

    <div class="project-planner-page" data-target="project-planner--form.page">

      <div class="container has-gutter-small-mobile has-gutter-large-desktop">
        <hr class="separator is-grey">
      </div>

      <div class="container has-gutter-small has-text-centered">
        <div><h3 class="title is-size-4-touch is-size-3-desktop has-text-centered-desktop has-gutter-medium">Ready to rumble?... Well we are!</h3></div>
        <div class="columns is-centered">
          <div class="column is-half">
            <div class="field">
              <input type="text" required name="contact_name" class="input has-border has-gutter-small" placeholder="Name:">
            </div>
            <div class="field">
              <input type="email" required name="contact_email" class="input has-border has-gutter-small" placeholder="Email:">
            </div>
            <div class="field">
              <input type="phone" required name="contact_phone" class="input has-border has-gutter-small" placeholder="Phone:">
            </div>
            <div class="field">
              <input type="text" required name="contact_time" class="input has-border has-gutter-small" placeholder="When is the best time to get in contact?">
            </div>
            <div class="field has-text-left">
              <label class="label">What is your preferred method of contact</label>
              <div class="control has-gutter-small">
                <label class="radio">
                  <input type="radio" name="contact_preference" value="email" checked>
                  Email
                </label>
                <label class="radio">
                  <input type="radio" name="contact_preference" value="phone">
                  Phone
                </label>
              </div>
            </div>

            <div class="has-gutter-small">
              <div class="g-recaptcha is-inline-block" data-sitekey="6LdJZU8UAAAAAIZIpymYIvGuQ0mEfug-8J9QIutS"></div>
            </div>

            <button type="submit" class="button is-medium" data-target="project-planner--form.submit" value="Submit" data-action="project-planner--form#submit">Submit</button>
          </div>
        </div>
      </div>
    </div>

    <div class="container has-text-centered is-hidden has-transition" data-target="project-planner--form.response"></div>
  </section>
</form>
