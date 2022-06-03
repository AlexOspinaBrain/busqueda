<?php

namespace  Drupal\busqueda\Plugin\Block;

use Drupal\Core\Block\BlockBase;


/**
 * @Block(
 *   id = "Search Block",
 *   admin_label = @translation("Search Block"),
 *   category = @translation("Search Block"),
 * )
 */


class Busqueda extends BlockBase {

  /**
   * {@inheritdoc }
   */

  public function build(){
    return [
        \Drupal::formBuilder()->getForm('\Drupal\busqueda\Form\FormBusca'),
        '#cache' => [
          'max-age' => 0,
        ],
  
      ];
  }

}