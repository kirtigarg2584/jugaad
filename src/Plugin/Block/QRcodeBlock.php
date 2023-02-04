<?php

/**
 * @file
 * Contains \Drupal\jugaad\Plugin\Block\QRcodeBlock.
 */

namespace Drupal\jugaad\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * Provides a 'QRcode' block.
 *
 * @Block(
 *   id = "qrcode_block",
 *   admin_label = @Translation("QRcode block"),
 *   category = @Translation("Custom")
 * )
 */
class QRcodeBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      $node = Node::load($node->id());
    }
    $app_purchase_link = explode(',', $node->get('field_app_purchase_link')->getString());
    $qrcode = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='. urlencode(strip_tags($app_purchase_link[0])).'&choe=UTF-8';
    return array(
      '#type' => 'markup',
      '#cache' => [
        'max-age' => 0,
      ],
      '#markup' => '<img src="' . $qrcode . '" title="' . $node->get('field_app_purchase_link')->getValue() . '" />'
    );
  }
}
