<?php

namespace Drupal\Tests\system\Functional\Theme;

use Drupal\Component\Utility\Html;
use Drupal\Tests\BrowserTestBase;

/**
 * Tests for Twig debug markup.
 *
 * @group Theme
 */
class TwigDebugMarkupTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['theme_test', 'node'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    \Drupal::service('theme_handler')->install(['test_theme']);
    \Drupal::service('theme_handler')->setDefault('test_theme');
    $this->drupalCreateContentType(['type' => 'page']);

    // Enable debug, rebuild the service container, and clear all caches.
    $parameters = $this->container->getParameter('twig.config');
    $parameters['debug'] = TRUE;
    $this->setContainerParameter('twig.config', $parameters);
    $this->rebuildContainer();
    $this->resetAll();
  }

  /**
   * Tests debug markup added to Twig template output.
   */
  public function testTwigDebugMarkup() {
    /** @var \Drupal\Core\Render\RendererInterface $renderer */
    $renderer = $this->container->get('renderer');
    $extension = twig_extension();
    $cache = $this->container->get('theme.registry')->get();
    // Create array of Twig templates.
    $templates = drupal_find_theme_templates($cache, $extension, drupal_get_path('theme', 'test_theme'));
    $templates += drupal_find_theme_templates($cache, $extension, drupal_get_path('module', 'node'));

    // Create a node and test different features of the debug markup.
    $node = $this->drupalCreateNode();
    $build = node_view($node);
    $output = $renderer->renderRoot($build);
    $this->assertTrue(strpos($output, '<!-- THEME DEBUG -->') !== FALSE, 'Twig debug markup found in theme output when debug is enabled.');
    $this->assertTrue(strpos($output, "THEME HOOK: 'node'") !== FALSE, 'Theme call information found.');
    $this->assertTrue(strpos($output, '* node--1--full' . $extension . PHP_EOL . '   x node--1' . $extension . PHP_EOL . '   * node--page--full' . $extension . PHP_EOL . '   * node--page' . $extension . PHP_EOL . '   * node--full' . $extension . PHP_EOL . '   * node' . $extension) !== FALSE, 'Suggested template files found in order and node ID specific template shown as current template.');
    $this->assertContains(Html::escape('node--<script type="text/javascript">alert(\'yo\');</script>'), (string) $output);
    $template_filename = $templates['node__1']['path'] . '/' . $templates['node__1']['template'] . $extension;
    $this->assertTrue(strpos($output, "BEGIN OUTPUT from '$template_filename'") !== FALSE, 'Full path to current template file found.');

    // Create another node and make sure the template suggestions shown in the
    // debug markup are correct.
    $node2 = $this->drupalCreateNode();
    $build = node_view($node2);
    $output = $renderer->renderRoot($build);
    $this->assertTrue(strpos($output, '* node--2--full' . $extension . PHP_EOL . '   * node--2' . $extension . PHP_EOL . '   * node--page--full' . $extension . PHP_EOL . '   * node--page' . $extension . PHP_EOL . '   * node--full' . $extension . PHP_EOL . '   x node' . $extension) !== FALSE, 'Suggested template files found in order and base template shown as current template.');

    // Create another node and make sure the template suggestions shown in the
    // debug markup are correct.
    $node3 = $this->drupalCreateNode();
    $build = ['#theme' => 'node__foo__bar'];
    $build += node_view($node3);
    $output = $renderer->renderRoot($build);
    $this->assertTrue(strpos($output, "THEME HOOK: 'node__foo__bar'") !== FALSE, 'Theme call information found.');
    $this->assertTrue(strpos($output, '* node--foo--bar' . $extension . PHP_EOL . '   * node--foo' . $extension . PHP_EOL . '   * node--&lt;script type=&quot;text/javascript&quot;&gt;alert(&#039;yo&#039;);&lt;/script&gt;' . $extension . PHP_EOL . '   * node--3--full' . $extension . PHP_EOL . '   * node--3' . $extension . PHP_EOL . '   * node--page--full' . $extension . PHP_EOL . '   * node--page' . $extension . PHP_EOL . '   * node--full' . $extension . PHP_EOL . '   x node' . $extension) !== FALSE, 'Suggested template files found in order and base template shown as current template.');

    // Disable debug, rebuild the service container, and clear all caches.
    $parameters = $this->container->getParameter('twig.config');
    $parameters['debug'] = FALSE;
    $this->setContainerParameter('twig.config', $parameters);
    $this->rebuildContainer();
    $this->resetAll();

    $build = node_view($node);
    $output = $renderer->renderRoot($build);
    $this->assertFalse(strpos($output, '<!-- THEME DEBUG -->') !== FALSE, 'Twig debug markup not found in theme output when debug is disabled.');
  }

  /**
   * Tests debug markup for array suggestions and hook_theme_suggestions_HOOK().
   */
  public function testArraySuggestionsTwigDebugMarkup() {
    \Drupal::service('module_installer')->install(['theme_suggestions_test']);
    $extension = twig_extension();
    $this->drupalGet('theme-test/array-suggestions');
    $output = $this->getRawContent();

    $expected = "THEME HOOK: 'theme_test_array_suggestions'";
    $this->assertTrue(strpos($output, $expected) !== FALSE, 'Theme call information found.');

    $expected = '<!-- FILE NAME SUGGESTIONS:' . PHP_EOL
      . '   * theme-test-array-suggestions--not-implemented' . $extension . PHP_EOL
      . '   * theme-test-array-suggestions--not-implemented-2' . $extension . PHP_EOL
      . '   x theme-test-array-suggestions--suggestion-from-hook' . $extension . PHP_EOL
      . '   * theme-test-array-suggestions' . $extension . PHP_EOL
      . '-->';
    $message = 'Suggested template files found in order and correct suggestion shown as current template.';
    $this->assertTrue(strpos($output, $expected) !== FALSE, $message);
  }

  /**
   * Tests debug markup for specific suggestions without implementation.
   */
  public function testUnimplementedSpecificSuggestionsTwigDebugMarkup() {
    $extension = twig_extension();
    $this->drupalGet('theme-test/specific-suggestion');
    $output = $this->getRawContent();

    $expected = "THEME HOOK: 'theme_test_specific_suggestions__not__found'";
    $this->assertTrue(strpos($output, $expected) !== FALSE, 'Theme call information found.');

    $message = 'Suggested template files found in order and base template shown as current template.';
    $expected = '<!-- FILE NAME SUGGESTIONS:' . PHP_EOL
      . '   * theme-test-specific-suggestions--not--found' . $extension . PHP_EOL
      . '   * theme-test-specific-suggestions--not' . $extension . PHP_EOL
      . '   x theme-test-specific-suggestions' . $extension . PHP_EOL
      . '-->';
    $this->assertTrue(strpos($output, $expected) !== FALSE, $message);
  }

  /**
   * Tests debug markup for specific suggestions.
   */
  public function testSpecificSuggestionsTwigDebugMarkup() {
    $extension = twig_extension();
    $this->drupalGet('theme-test/specific-suggestion-alter');
    $output = $this->getRawContent();

    $expected = "THEME HOOK: 'theme_test_specific_suggestions__variant'";
    $this->assertTrue(strpos($output, $expected) !== FALSE, 'Theme call information found.');

    $expected = '<!-- FILE NAME SUGGESTIONS:' . PHP_EOL
      . '   x theme-test-specific-suggestions--variant' . $extension . PHP_EOL
      . '   * theme-test-specific-suggestions' . $extension . PHP_EOL
      . '-->';
    $message = 'Suggested template files found in order and suggested template shown as current.';
    $this->assertTrue(strpos($output, $expected) !== FALSE, $message);
  }

}
