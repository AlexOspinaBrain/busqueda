<?php
namespace Drupal\busqueda\Ajax;

use Drupal\commerce_product\Entity\Product;
use Drupal\Core\Ajax\CommandInterface;

class SearchProductsCommand implements CommandInterface {
  protected $listProducts = "";
  protected $strSearch = "";
  protected $show = false;

  function __construct($strSearch)
  {
    $this->strSearch = $strSearch;
  }

  private function searchProducts() {

    $anchorProduct="";

    if ($this->strSearch != "" && !is_null($this->strSearch)) {
      $nids = \Drupal::entityQuery('commerce_product')
        ->condition('type','default')
        ->condition('title', "%" . $this->strSearch . "%", 'LIKE')
        ->execute();

      $entity = Product::loadMultiple($nids);
      
      
      foreach ($entity as $product) {
        $imgVariation = $product->getDefaultVariation()->get('field_image')->first();
        $img="";
        if ($imgVariation) {
          $uriImg = $imgVariation->entity->getFileUri();
          $uriImg = '/sites/default/files/' . substr($uriImg,9);
          $img = '<img src="'.$uriImg.'" width="50px" height="50px" >';
        }

        $body = substr($this->rip_tags($product->get('body')->value),0,50);

        $anchorProduct .= '<div><a href="/'.$product->getDefaultVariation()->toUrl()->getInternalPath().'">'. 
          '<table><tr><td>' . $img . '</td>'.
          '<td align="center">'.
          '<h3>' . $product->getTitle() . '</h3>' .
          '<p>' . $body . '</p>' . 
        '</td></tr></table></a></div><br>';

        $this->show = true;
      }

      $this->listProducts=$anchorProduct;
    }
  }

  // Implements Drupal\Core\Ajax\CommandInterface:render().
  public function render() {
    $this->searchProducts();
    return [
      'command' => 'getProductAjax',
      'content' => $this->listProducts,
      'show' => $this->show,
    ];
  }

  private function rip_tags($string) {
    if (!empty($string) && !is_Null($string)) {
      // ----- remove HTML TAGs -----
      $string = preg_replace ('/<[^>]*>/', ' ', $string);
      // ----- remove control characters -----
      $string = str_replace("\r", '', $string); // --- replace with empty space
      //$string = str_replace("\n", ' ', $string); // --- replace with space
      //$string = str_replace("\t", ' ', $string); // --- replace with space
      //$string = str_replace("&nbsp;", ' ', $string); // --- replace with space
      // ----- remove multiple spaces -----
      //$string = trim(preg_replace('/ {2,}/', ' ', $string));
    
    } else {
      $string="";
    }
    return $string;
    
  }
    
}