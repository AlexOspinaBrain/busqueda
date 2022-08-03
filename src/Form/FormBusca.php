<?php
namespace Drupal\busqueda\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\busqueda\Ajax\SearchProductsCommand;

class FormBusca extends FormBase {

    /**
   * {@inheritdoc }
   */
  public function getFormId()
  {
    return 'form_busqueda_productos';
  }

  /**
   * {@inheritdoc }
   */  
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['buscar'] = [

      "#type"=> "textfield",
      '#id' => "buscar",
      '#name' => "buscar",
      '#size' => "30",
      '#maxlength' => "90",
      '#placeholder' => "Buscar...",
      '#prefix' => '<div class="dropdownBP"><div class="dropdownBP-content" id="buscaProducto">',
      '#suffix' => '<div id="divProducts"></div></div></div>',
      /*'#theme-wrapper' => ['alex'],*/
      '#input_group' => FALSE,
      
      '#attached' => [
              'library' => [
                'busqueda/busqueda',
              ]
            ],
      '#ajax' => [
        'callback' => [$this, 'getProduct'],
        'event' => 'change',
        'wrapper' => 'divProducts',
        'progress' => [
            'type' => 'throbber',
        ],
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc }
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    return [];
  }

  public function getProduct(array &$form, FormStateInterface $form_state) {
        
        // Create AJAX Response object.
        $response = new AjaxResponse();
        // Call the readMessage javascript function.
        $response->addCommand( new SearchProductsCommand($form_state->getValue('buscar')));

        // Return ajax response.
        return $response;
  }


}